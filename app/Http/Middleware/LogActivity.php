<?php

namespace App\Http\Middleware;

use App\Helpers\LoggingHelper;
use Closure;
use Illuminate\Http\Request;

class LogActivity
{
    public function handle(Request $request, Closure $next)
    {
        return $next($request);
    }

    public function terminate(Request $request, $response)
    {
        LoggingHelper::logActivity($request, $response);
    }
}
