<?php

namespace App\Http\Middleware;

use Closure;
Use Session;
use Carbon\Carbon;
use Illuminate\Session\Store;
use Illuminate\Support\Facades\Redirect;
use Cookie;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
class Login
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(!empty(Session::has('session'))) {

    }else{
    		// $mapidgetlogout = Cookie::get('mapid');
        //         $brandid=Cookie::get('brandid');
        //         $ip=Cookie::get('ip');

		//DB::table($brandid.'_master_log')->insert(['map_id'=>$mapidgetlogout,'out_time' => now(),'ipaddress'=>$ip]);
        Session::flush();
        Session::flash('error', 'Your Session has Expired Please login again ');
        return Redirect::to('/');

    }
        return $next($request);

    }
}
