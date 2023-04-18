<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Illuminate\Http\Request;

class CheckLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        echo "check login <br>";
        if(is_null(session('data.userInfo'))) {
            return redirect(route('user.login'));
        }

       try {
        $userInfo = json_decode(json_encode(session('data.userInfo')), True);
        if($userInfo['Quyen'] != 1) {
            return redirect()->route('index')->with( ['isAdmin' => false] );

        }
       } catch (Exception $e) {
            // page notification not admin
            return redirect(route('index'));
       }

        return $next($request);
    }
}
