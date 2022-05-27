<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;


    /**
     * @OA\Swagger(
     *     @OA\Info(
     *         version="1.0.0",
     *         title="NoriFood Api Documentation",
     *         description="This is the list of apis on mobile platform.",
     *         termsOfService="",
     *     ),
     *     @OA\Server(
     *         url=L5_SWAGGER_CONST_HOST,
     *     ),
     *     @OA\SecurityScheme(
     *         securityScheme="secretCode",
     *         in="header",
     *         name="Secret-Code",
     *         type="apiKey",
     *         description="Secret code."
     *     ),
     *     @OA\SecurityScheme(
     *         securityScheme="bearerAuth",
     *         in="header",
     *         name="Authorization",
     *         type="http",
     *         scheme="bearer",
     *         bearerFormat="JWT",
     *         description="Sign in with userId and password to get the authentication token."
     *     ),
     * )
     */
}
