<?php

namespace App\Http\Controllers\Api\V1;

use App\Constants\Globals\Queue;
use App\Constants\OTP as OTPConst;
use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ChangePasswordRequest;
use App\Http\Requests\Api\LoginCustomerRequest;
use App\Http\Requests\Api\SendOTPRequest;
use App\Http\Requests\Api\SignupCustomerRequest;
use App\Http\Requests\Api\UpdateProfileRequest;
use App\Http\Requests\Api\VerifyOTPRequest;
use App\Http\Resources\Admin\CustomerResource;
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
use function bcrypt;
use function config;
use function now;
use function request;
use function response;

class AuthController extends Controller
{
    /**
     * @OA\Post(
     *     path="/signup",
     *     operationId="signup",
     *     tags={"Auth"},
     *     summary="Signup",
     *     description="",
     *     security={{"secretCode":{}}},
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *               mediaType="application/json",
     *    		     @OA\Schema(
     *                  type="object",
     *                  @OA\Property(
     *                       property="full_name",
     *                       type="string",
     *                       example="Luong Trung Kien",
     *                       description="Full name of customer, required field",
     *                   ),
     *                  @OA\Property(
     *                       property="first_name",
     *                       type="string",
     *                       example="Trung Kien",
     *                       description="First name of customer, required field",
     *                   ),
     *                  @OA\Property(
     *                       property="last_name",
     *                       type="string",
     *                       example="Luong",
     *                       description="Last name of customer, required field",
     *                   ),
     *                  @OA\Property(
     *                       property="email",
     *                       type="string",
     *                       example="trungkien@gmail.com",
     *                       description="Email of customer, required field",
     *                   ),
     *                  @OA\Property(
     *                       property="birthday",
     *                       type="string",
     *                       example="2000-05-25",
     *                       description="Full name of customer, field can be empty",
     *                   ),
     *                  @OA\Property(
     *                       property="phone",
     *                       type="string",
     *                       example="0353111222",
     *                       description="Phone of customer, required field",
     *                   ),
     *                  @OA\Property(
     *                       property="password",
     *                       type="string",
     *                       example="123456",
     *                       description="Password of customer, required field",
     *                   ),
     *               ),
     *            ),
     *     ),
     *     @OA\Response(response=200, description="Successful operation.", @OA\MediaType(mediaType="application/json")),
     *     @OA\Response(response=400, description="Bad Request."),
     *     @OA\Response(response=401, description="Permission denied."),
     *     @OA\Response(response=404, description="404 not found."),
     *     @OA\Response(response=500, description="An error occurred in processing the request."),
     * )
     */
    public function signup(SignupCustomerRequest $request)
    {
        $validated = $request->validated();
        $phone = $validated['phone'];
        $email = $validated['email'] ?? null;

        $customer = new Customer([
            'full_name'  => $request->full_name,
            'first_name' => $request->first_name,
            'last_name'  => $request->last_name,
            'birthday'   => $request->birthday,
            'email'      => $email,
            'phone'      => $phone,
            'password'   => bcrypt($request->password),
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

    /**
     * @OA\Post(
     *     path="/login",
     *     operationId="login",
     *     tags={"Auth"},
     *     summary="Login",
     *     description="",
     *     security={{"secretCode":{}}},
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *               mediaType="application/json",
     *    		     @OA\Schema(
     *                  type="object",
     *                  @OA\Property(
     *                       property="email",
     *                       type="string",
     *                       example="trungkien@gmail.com",
     *                       description="Email of customer. The email field is required when a phone is not available.",
     *                   ),
     *                  @OA\Property(
     *                       property="phone",
     *                       type="string",
     *                       example="0353111222",
     *                       description="Phone of customer. The phone field is required when a email is not available.",
     *                   ),
     *                  @OA\Property(
     *                       property="password",
     *                       type="string",
     *                       example="123456",
     *                       description="Password of customer, required field",
     *                   ),
     *               ),
     *            ),
     *     ),
     *     @OA\Response(response=200, description="Successful operation.", @OA\MediaType(mediaType="application/json")),
     *     @OA\Response(response=400, description="Bad Request."),
     *     @OA\Response(response=401, description="Permission denied."),
     *     @OA\Response(response=404, description="404 not found."),
     *     @OA\Response(response=500, description="An error occurred in processing the request."),
     * )
     */
    public function login(LoginCustomerRequest $request)
    {
        $validated = $request->validated();

        $field = filter_var($request->get('email'), FILTER_VALIDATE_EMAIL)
            ? 'email'
            : 'phone';
        $customer = Customer::where($field, $validated[$field] ?? $validated['email'])->first();
        if (empty($customer)) {
            return ResponseHelper::failed('Tài khoản không hợp lệ.', 401);
        }
        if (!Hash::check(request()->password, $customer->password)) {
            return ResponseHelper::failed('Tài khoản không hợp lệ.', 401);

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

    /**
     * @OA\Get(
     *     path="/logout",
     *     operationId="logout",
     *     tags={"Auth"},
     *     summary="Logout",
     *     description="",
     *     security={{"bearerAuth":{}, "secretCode":{}}},
     *     @OA\Response(response=200, description="Successful operation.", @OA\MediaType(mediaType="application/json")),
     *     @OA\Response(response=400, description="Bad Request."),
     *     @OA\Response(response=401, description="Permission denied."),
     *     @OA\Response(response=404, description="404 not found."),
     *     @OA\Response(response=500, description="An error occurred in processing the request."),
     * )
     */
    public function logout(Request $request)
    {
        $request->user()->token()->revoke();

        //Xoa device_token
        $request['customer_id'] = Auth::id();
        $device = Device::where("device_id", $request->device_id)->where("customer_id", $request['customer_id'])->first();
        if (!empty($device)) {
            $device->delete();
        }

        return ResponseHelper::successful('Đăng xuất thành công.', 201);
    }

    /**
     * @OA\Get(
     *     path="/customer",
     *     operationId="customer",
     *     tags={"Auth"},
     *     summary="Infomation customer",
     *     description="",
     *     security={{"bearerAuth":{}, "secretCode":{}}},
     *     @OA\Response(response=200, description="Successful operation.", @OA\MediaType(mediaType="application/json")),
     *     @OA\Response(response=400, description="Bad Request."),
     *     @OA\Response(response=401, description="Permission denied."),
     *     @OA\Response(response=404, description="404 not found."),
     *     @OA\Response(response=500, description="An error occurred in processing the request."),
     * )
     */
    public function customer(Request $request)
    {
        return new CustomerResource($request->user()->load(['membership', 'myPoints']));
    }

    /**
     * @OA\Post(
     *     path="/changePassword",
     *     operationId="changePassword",
     *     tags={"Auth"},
     *     summary="Change Password",
     *     description="",
     *     security={{"secretCode":{}}},
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *               mediaType="application/json",
     *    		     @OA\Schema(
     *                  type="object",
     *                  @OA\Property(
     *                       property="curPassword",
     *                       type="string",
     *                       example="",
     *                       description="",
     *                   ),
     *                  @OA\Property(
     *                       property="password",
     *                       type="string",
     *                       example="",
     *                       description="",
     *                   ),
     *                  @OA\Property(
     *                       property="confirmPassword",
     *                       type="string",
     *                       example="",
     *                       description="",
     *                   ),
     *               ),
     *            ),
     *     ),
     *     @OA\Response(response=200, description="Successful operation.", @OA\MediaType(mediaType="application/json")),
     *     @OA\Response(response=400, description="Bad Request."),
     *     @OA\Response(response=401, description="Permission denied."),
     *     @OA\Response(response=404, description="404 not found."),
     *     @OA\Response(response=500, description="An error occurred in processing the request."),
     * )
     */
    public function changePassword(ChangePasswordRequest $request)
    {
        $custormer_id = Auth::id();
        $customer = Customer::find($custormer_id);
        if (!Hash::check(request()->curPassword, $customer->password)) {
            return ResponseHelper::failed('Mật khẩu cũ không đúng.', 401);
        }
        $customer->update(['password' => bcrypt($request->password)]);

        return new CustomerResource($customer);
    }

    /**
     * @OA\Post(
     *     path="/updateProfile",
     *     operationId="updateProfile",
     *     tags={"Auth"},
     *     summary="Update Profile",
     *     description="",
     *     security={{"secretCode":{}}},
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *               mediaType="application/json",
     *    		     @OA\Schema(
     *                  type="object",
     *                  @OA\Property(
     *                       property="full_name",
     *                       type="string",
     *                       example="",
     *                       description="",
     *                   ),
     *                  @OA\Property(
     *                       property="first_name",
     *                       type="string",
     *                       example="",
     *                       description="",
     *                   ),
     *                  @OA\Property(
     *                       property="last_name",
     *                       type="string",
     *                       example="",
     *                       description="",
     *                   ),
     *                  @OA\Property(
     *                       property="birthday",
     *                       type="string",
     *                       example="",
     *                       description="",
     *                   ),
     *                  @OA\Property(
     *                       property="phone",
     *                       type="string",
     *                       example="",
     *                       description="",
     *                   ),
     *                  @OA\Property(
     *                       property="email",
     *                       type="string",
     *                       example="",
     *                       description="",
     *                   ),
     *               ),
     *            ),
     *     ),
     *     @OA\Response(response=200, description="Successful operation.", @OA\MediaType(mediaType="application/json")),
     *     @OA\Response(response=400, description="Bad Request."),
     *     @OA\Response(response=401, description="Permission denied."),
     *     @OA\Response(response=404, description="404 not found."),
     *     @OA\Response(response=500, description="An error occurred in processing the request."),
     * )
     */
    public function updateProfile(UpdateProfileRequest $request)
    {
        $custormer_id = Auth::id();
        $validated = $request->validated();

        $customer = Customer::find($custormer_id);

        if (!$request->input('avatar') && $customer->getFirstMedia('avatar')) {
            $customer->getFirstMedia('avatar')->delete();
        }
        if ($request->hasFile('avatar')) {
            $customer->addMedia($request->file('avatar'))->toMediaCollection('avatar');
        }

        $customer->update($validated);

        return new CustomerResource($customer);
    }

    public function sendOTP(SendOTPRequest $request)
    {
        $validated = $request->validated();
        $phone = $validated['phone'];
        $type = $validated['type'];

        $check = OTP::where("phone", $phone)->orderByDesc("id")->first();
        if (!empty($check)) {
            $created_at = Carbon::parse($check->created_at);
            $subSecond = Carbon::now()->diffInSeconds($created_at);
            if ($subSecond < 120) {
                $subSecond = 120 - $subSecond;

                return ResponseHelper::failed("Thử lại sau {$subSecond} giây.");
            }
        }
        $otp = sprintf("%06d", mt_rand(1, 999999));

        if (App::environment(['local', 'develop'])) {
            $otp = '080996';
        }
        OTP::create([
            'otp'    => $otp,
            'phone'  => $phone,
            'type'   => $type,
            'status' => OTPConst::STATUS['NOT_USED_YET'],
        ]);
        if (App::environment(['production', 'production-delivery'])) {
            OTPSender::dispatch($phone, $otp);
        }

        return ResponseHelper::successful('Gửi OTP thành công.', 201);
    }

    public function verifyAccount(VerifyOTPRequest $request)
    {
        $validated = $request->validated();
        $code = $validated['code'];
        $phone = $validated['phone'];
        $smsExpired = config('esms.smsExpired');
        $smsExpired = Carbon::now()->subMinute($smsExpired)->toDateTimeString();

        $otp = OTP::where('otp', $code)->where('phone', $phone)->orderByDesc("id")->first();

        if (!empty($otp)) {
            if ($otp->status == OTPConst::STATUS['USED']) {
                return ResponseHelper::failed('Code đã sử dụng.');
            } elseif ($otp->type != OTPConst::TYPE['VERIFY_ACCOUNT']) {
                return ResponseHelper::failed('Code không phù hợp.');
            } elseif ($otp->created_at <= $smsExpired) {
                return ResponseHelper::failed('OTP đã hết hạn.');
            } else {
                $otp->update(['status' => OTPConst::STATUS['USED']]);
                $customer = Customer::where("phone", $phone)->first();
                if (!empty($customer)) {
                    $customer->update([
                        "verified"    => 1,
                        "verified_at" => Carbon::now()->toDateTimeString(),
                    ]);
                }

                return ResponseHelper::successful('OTP chính xác.', 201);
            }
        } else {
            return ResponseHelper::failed('OTP không chính xác.');
        }
    }
}
