<?php

namespace App\Helpers;

use App\Constants\Globals\Exception as ExceptionConst;
use App\Models\LogExternalApi;
use App\Models\LogExternalCallback;
use App\Notifications\SlackNotification;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Throwable;
use Illuminate\Support\Facades\Log;
use PDOException;

class LoggingHelper
{
    public static function logExternalApi($method, $endpoint, $body, $response, $provider)
    {
        $requestAt = Carbon::now()->toDateTimeString();
        $_request = [
            'method'   => $method,
            'endpoint' => $endpoint,
            'body'     => $body,
        ];
        $_response = $response;
        try {
            $logExternalApi = new LogExternalApi();
            $logExternalApi->{LogExternalApi::FIELD_REQUEST_AT} = $requestAt;
            $logExternalApi->{LogExternalApi::FIELD_REQUEST} = json_encode($_request);
            $logExternalApi->{LogExternalApi::FIELD_RESPONSE} = json_encode($_response);
            $logExternalApi->{LogExternalApi::FIELD_PROVIDER} = $provider;
            $logExternalApi->save();

            DB::table('log_external_api')->insert([
                LogExternalApi::FIELD_REQUEST_AT => $requestAt,
                LogExternalApi::FIELD_REQUEST    => json_encode($_request),
                LogExternalApi::FIELD_RESPONSE   => json_encode($_response),
                LogExternalApi::FIELD_PROVIDER   => $provider,
            ]);

        } catch (Exception $exception) {
            self::logException($exception);
        }
    }

    public static function logExternalCallback(int $service, int $provider, $request, $response)
    {
        #region Write log MongoDB
        $requestAt = Carbon::now()->toDateTimeString();
        $_request = [
            'host'        => $_SERVER['SERVER_NAME'],
            'host_client' => self::getIPAddress(),
            'url'         => $request->getRequestUri(),
            'method'      => $request->method(),
            'header'      => $request->header(),
            'body'        => json_decode($request->getContent(), true),
        ];
        $_response = [
            'http_status_code' => $response->getStatusCode(),
            'header'           => $response->headers,
            'body'             => json_decode($response->getContent(), true),
        ];
        try {
            $logExternalCallback = new LogExternalCallback();
            $logExternalCallback->{LogExternalCallback::FIELD_REQUEST_AT} = $requestAt;
            $logExternalCallback->{LogExternalCallback::FIELD_REQUEST} = json_encode($_request);
            $logExternalCallback->{LogExternalCallback::FIELD_RESPONSE} = json_encode($_response);
            $logExternalCallback->{LogExternalCallback::FIELD_SERVICE} = $service;
            $logExternalCallback->{LogExternalCallback::FIELD_PROVIDER} = $provider;
            $logExternalCallback->save();
        } catch (Exception $exception) {
            self::logException($exception);
        }
        #endregion Write log MongoDB
    }

    public static function logException(Throwable $exception)
    {
        #Notification to slack
        $slackWebhookUrl = config('slack.webhook_url');

        $issueTime = Carbon::now()->toDateTimeString();
        $key = sprintf('%s:%s', ExceptionConst::CACHE_NAME, $exception->getCode());
        $value = [
            'message'   => $exception->getMessage(),
            'file'      => $exception->getFile(),
            'line'      => $exception->getLine(),
            'trace'     => $exception->getTraceAsString(),
            'issueTime' => $issueTime,
        ];

        if (!Cache::has($key)) {
            Cache::put($key, $value, ExceptionConst::TTL);
            Notification::route('slack', $slackWebhookUrl)->notify(new SlackNotification($exception));
        }
        #end
    }

    function getIPAddress()
    {
        //whether ip is from the share internet
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } //whether ip is from the proxy
        elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } //whether ip is from the remote address
        else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }

        return $ip;
    }

    public static function logActivity(Request $request, $response)
    {
        try {
            $_request = [
                'from_ip' => $request->getClientIp(),
                'url'     => $request->getRequestUri(),
                'method'  => $request->method(),
                'header'  => $request->header(),
                'body'    => json_decode($request->getContent(), true),
            ];
            $_response = [
                'http_status_code' => $response->getStatusCode(),
                'body'             => json_decode($response->getContent(), true),
            ];
            DB::table('log_activities')->insert([
                'request'  => json_encode($_request),
                'response' => json_encode($_response),
            ]);
        } catch (Exception $exception) {
            self::logException($exception);
        }
    }
}
