<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Checkadmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

         if($request->user() == null){
       //     session()->flash('error','You are not autroized to acess this page');
        return redirect()->route('home');

    }
        if($request->user()->role != 'admin'){
            session()->flash('error','You are not autroized to acess this page');
        return redirect()->route('profile');

    }
     return $next($request);
}
}
