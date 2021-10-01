<?php

namespace App\Http\Middleware;

use App\Models\Setting;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckSetting
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $setting = Setting::find(1);
        if ($setting == null) {
            return redirect()->route('first.page');
        } else {
            $auth = Auth::check();

            if (!$auth) {
                return redirect()->route('login');
            }
        }
        return $next($request);
    }
}
