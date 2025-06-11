<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\VersionControl;
use Illuminate\Support\Facades\Config;
use Symfony\Component\HttpFoundation\Response;

class VersionControlMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $appVersion = $request->header('appVersion');
        if ($appVersion) {
            if ($appVersion != VersionControl::first()->appVersion) {
                return response()->json(['status' => 3, 'msg' => __('messages.successMsg'), 'payload' => (object)[]], Config::get('constants.errorCode.ok'));
            }
        } else {
            return response()->json(['status' => 0, 'msg' => "App version is not send through api header", 'payload' => (object)[]], Config::get('constants.errorCode.ok'));
        }

        return $next($request);
    }
}
