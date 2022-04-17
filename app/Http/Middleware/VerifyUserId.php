<?php
/**
 * Created by PhpStorm.
 * User: n.zekavica
 * Date: 16.4.2022.
 * Time: 16:03
 */

namespace App\Http\Middleware;


use Closure;
use Laravel\Passport\Exceptions\MissingScopeException;

class VerifyUserId
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Closure $next
     * @return \Illuminate\Http\RedirectResponse|mixed
     * @throws MissingScopeException
     */
    public function handle($request,Closure $next)
    {
        $id = $request->route('id');

        if($request->user()->id != $id){
            throw new MissingScopeException();
        }

        return $next($request);
    }
}