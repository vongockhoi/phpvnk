<?php

namespace App\Http\Middleware;

use App\Helpers\ResponseHelper;
use Closure;
use Illuminate\Http\Request;

class VerifyApi
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // check secret code
        $secretCode = $request->header("Secret-Code");
        if (!$secretCode) {
            return ResponseHelper::failed("Thêm mã bí mật ở header khi request đi cu Quý", 401);
        } else {
            $secretKey = config('app.secretCode');
            if ($secretCode != $secretKey) {
                return ResponseHelper::failed("Mã bí mật sai rồi cu Quý ơi", 401);
            }
        }
        return $next($request);
    }
}
