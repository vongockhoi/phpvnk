<?php

namespace App\Helpers;
use GuzzleHttp;

class RequestHelper
{
    public static function request(array $body, string $endpoint, $method = 'POST')
    {
        $headers = ['Content-Type' => 'application/json; charset=UTF-8'];
        $options = [
            'headers' => $headers,
        ];

        $client = app('GuzzleClient', [])($options);
        $response = $client->request(
            $method,
            $endpoint,
            [
                'json' => $body,
            ]
        );

        return (string)$response->getBody() ? json_decode((string)$response->getBody(), true) : [];
    }

    public static function requestExternalApi(array $body, string $endpoint, $method = 'POST', $provider)
    {
        $client = new GuzzleHttp\Client();
        $response = $client->request(
            $method,
            $endpoint,
            [
                'json' => $body,
            ]
        );

        $response = (string)$response->getBody() ? json_decode((string)$response->getBody(), true) : [];
        LoggingHelper::logExternalApi($method, $endpoint, $body, $response, $provider);

        return $response;
    }
}
