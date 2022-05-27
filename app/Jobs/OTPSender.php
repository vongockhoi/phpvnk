<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class OTPSender implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $phone;

    protected $otp;

    public function __construct($phone, $otp)
    {
        $this->phone = $phone;
        $this->otp = $otp;
    }

    public function handle()
    {
        $APIKey = config("esms.smsApiKey");
        $SecretKey = config("esms.smsSecretKey");
        $YourPhone = $this->phone;
        $Otp = $this->otp;
        $Content = "Cam on quy khach da su dung dich vu cua NORI FOOD. Ma xac thuc cua quy khach tai ung dung Nori Food la $Otp, vui long khong chia se ma nay voi bat cu ai.";
        $Brandname = "NORI%20FOOD";
        $SendContent = urlencode($Content);
        $data = "http://rest.esms.vn/MainService.svc/json/SendMultipleMessage_V4_get?Phone=$YourPhone&ApiKey=$APIKey&SecretKey=$SecretKey&Content=$SendContent&Brandname=$Brandname&SmsType=2";
        $curl = curl_init($data);
        curl_setopt($curl, CURLOPT_FAILONERROR, true);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($curl);
        $obj = json_decode($result, true);
        if ($obj['CodeResult'] == 100) {
//            print "<br>"; //
//            print "CodeResult:" . $obj['CodeResult'];
//            print "<br>";
//            print "CountRegenerate:" . $obj['CountRegenerate'];
//            print "<br>";
//            print "SMSID:" . $obj['SMSID'];
//            print "<br>";
        } else {
//            print "CodeResult:" . $obj['CodeResult'];
//            print "ErrorMessage:" . $obj['ErrorMessage'];
            Log::error("ErrorMessage:" . $obj['ErrorMessage']);
        }
    }
}
