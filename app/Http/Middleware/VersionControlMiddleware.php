<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\VersionControl;
use Symfony\Component\HttpFoundation\Response;

class VersionControlMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $appVersion = $request->header('appVersion');
        if ($appVersion) {
            if ($appVersion != VersionControl::first()->appVersion) {
                return response()->json(['status' => 3, 'msg' => __('messages.successMsg'), 'payload' => (object)[]], config('constants.ok'));
            }
        } else {
            return response()->json(['status' => 0, 'msg' => "App version is not send through api header", 'payload' => (object)[]], config('constants.ok'));
        }

        return $next($request);
    }
}
