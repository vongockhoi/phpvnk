<?php

namespace App\Http\Controllers\Api\V2;

use App\Constants\Globals\Common as CommonConst;
use App\Constants\Globals\Queue;
use App\Constants\OTP as OTPConst;
use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Auth\V2\SignInCustomerRequest;
use App\Http\Requests\Api\Auth\V2\SignUpCustomerRequest;
use App\Http\Requests\Api\LoginCustomerRequest;
use App\Http\Requests\Api\Auth\V2\SendOTPRequest;
use App\Http\Requests\Api\Auth\V2\VerifyOTPRequest;
use App\Jobs\Coupon\IssueCouponForUserJustRegistered;
use App\Jobs\OTPSender;
use App\Models\Customer;
use App\Models\Device;
use App\Models\OTP;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use function config;
use function request;
use function response;

class AuthController extends Controller
{

    public function signUp(SignUpCustomerRequest $request)
    {
        $validated = $request->validated();
        $phone = $validated['phone'];
        $code = $validated['code'];
        $last_name = $validated['last_name'] ?? '';
        list($result, $otp) = $this->checkExistVerifyOTP($phone,$code,OTPConst::TYPE_SEND['SIGN_UP']);
        if($result){
            $customer = new Customer([
                'full_name'  => trim($last_name.CommonConst::SPACE.$request->first_name),
                'first_name' => $request->first_name,
                'last_name'  => $request->last_name,
                'phone'      => $phone,
                'verified'    => 1,
                'verified_at' => Carbon::parse($otp->updated_at)->toDateTimeString(),
            ]);

            $customer->save();

            Auth::login($customer);
            $tokenResult = $customer->createToken('Personal Access Token');

            #Job
            IssueCouponForUserJustRegistered::dispatch($customer->id);

            return response()->json([
                'access_token' => $tokenResult->accessToken,
                'token_type'   => 'Bearer',
                'expires_at'   => Carbon::parse(
                    $tokenResult->token->expires_at
                )->toDateTimeString(),
            ]);
        }
        return ResponseHelper::failed('R???t ti???c ???? c?? l???i x???y ra trong qu?? tr??nh t???o t??i kho???n. Qu?? kh??ch vui l??ng th???c hi???n l???i thao t??c.',401);

    }


    public function signIn(SignInCustomerRequest $request)
    {
        $validated = $request->validated();
        $phone = $validated['phone'];
        $code = $validated['code'];
        list($isValid,$data) = $this->verifyOTPProcess($code, $phone, OTPConst::TYPE_SEND['SIGN_IN']);
        if($isValid){
            return ResponseHelper::failed($data);
        }else{
            $customer = Customer::where('phone', $phone)->whereNull("deleted_at")->first();
            if (empty($customer)) {
                return ResponseHelper::failed('T??i kho???n kh??ng h???p l???.', 401);
            }
            Auth::login($customer);
            $tokenResult = $customer->createToken('Personal Access Token');

            return response()->json([
                'access_token' => $tokenResult->accessToken,
                'token_type'   => 'Bearer',
                'expires_at'   => Carbon::parse(
                    $tokenResult->token->expires_at
                )->toDateTimeString(),
            ]);
        }

    }

    public function signOut(Request $request)
    {
        $request->user()->token()->revoke();

        //Xoa device_token
        $request['customer_id'] = Auth::id();
        $device = Device::where("device_id", $request->device_id)->where("customer_id", $request['customer_id'])->first();
        if (!empty($device)) {
            $device->delete();
        }

        return ResponseHelper::successful('????ng xu???t th??nh c??ng.', 201);
    }

    public function sendOTP(SendOTPRequest $request)
    {
        $validated = $request->validated();
        $phone = $validated['phone'];

        $check = OTP::where("phone", $phone)->orderByDesc("id")->first();
        if (!empty($check)) {
            $created_at = Carbon::parse($check->created_at);
            $subSecond = Carbon::now()->diffInSeconds($created_at);
            if ($subSecond < OTPConst::TIME_OUT_SEND_OTP) {
                $subSecond = OTPConst::TIME_OUT_SEND_OTP - $subSecond;

                return ResponseHelper::failed("Th??? l???i sau {$subSecond} gi??y.");
            }
        }
        #customer for apple test
        $otp = sprintf("%06d", mt_rand(1, 999999));
        $type = $this->_checkTypeOfPhoneBeforeSendOTP($phone);
        if (App::environment(['local','develop-nori','develop-delivery']) || ($phone == '0111111111')) {
            $otp = '000000';
        }
        if (App::environment(['production', 'production-delivery']) && ($phone != '0111111111')) {
            OTPSender::dispatch($phone, $otp);
        }
        OTP::create([
            'otp'    => $otp,
            'phone'  => $phone,
            'type'   => $type,
            'status' => OTPConst::STATUS['NOT_USED_YET'],
        ]);

        return ResponseHelper::success(['type'=> $type]);
    }


    public function verifyOTP(VerifyOTPRequest $request)
    {
        $validated = $request->validated();
        $code = $validated['code'];
        $phone = $validated['phone'];
        $type = $validated['type'];

        list($isValid,$data) = $this->verifyOTPProcess($code,$phone, $type);
        if($isValid){
            return ResponseHelper::failed($data);
        }
        return ResponseHelper::success(['type'=> $data]);

    }

    private function verifyOTPProcess($code, $phone, $type){
        $isValid = false;
        $smsExpired = config('esms.smsExpired');
        $smsExpired = Carbon::now()->subMinute($smsExpired)->toDateTimeString();
        $otp = OTP::where('phone', $phone)->orderByDesc("id")->first();
        if (!empty($otp)) {
            if ($otp->otp != $code) {
                $isValid = true;
                $data = 'OTP kh??ng ch??nh x??c.';
            }elseif ($otp->status == OTPConst::STATUS['USED']) {
                $isValid = true;
                $data = 'Code ???? s??? d???ng.';
            } elseif ($otp->type != $type) {
                $isValid = true;
                $data = 'Code kh??ng ph?? h???p.';
            } elseif ($otp->created_at <= $smsExpired) {
                $isValid = true;
                $data = 'OTP ???? h???t h???n.';
            } else {
                $otp->update(['status' => OTPConst::STATUS['USED']]);
                $data = $type;
            }
        } else {
            $isValid = true;
            $data = 'OTP kh??ng ch??nh x??c.';
        }
        return [$isValid,$data];

    }

    private function _checkTypeOfPhoneBeforeSendOTP($phone)
    {
        $type = OTPConst::TYPE_SEND['SIGN_UP'];
        $customer = Customer::where('phone', $phone)->first();
        if(!empty($customer)){
            $type = OTPConst::TYPE_SEND['SIGN_IN'];
        }
        return $type;
    }

    private function checkExistVerifyOTP($phone, $code, $type)
    {
        $otp = OTP::where('phone', $phone)->where('type',$type)->orderByDesc("id")->first();
        if (!empty($otp) && strcmp($code,$otp->otp) == 0 && $otp->status == OTPConst::STATUS['USED']) {
            return [true, $otp];
        }
        return [false, null];
    }
}
