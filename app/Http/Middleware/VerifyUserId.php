<?php

namespace App\Http\Middleware;

use Closure;
use Laravel\Passport\Exceptions\MissingScopeException;

/**
 * Class VerifyUserId
 *
 * @package App\Http\Middleware
 * @author  Nikola Zekavica <nikolazekavica88@yahoo.com>
 */
class VerifyUserId
{
    /**
     * Handle the incoming request and verify does user id belongs to logged user.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Closure $next
     * @return \Illuminate\Http\RedirectResponse|mixed
     * @throws MissingScopeException
     */
    public function handle($request, Closure $next)
    {
        $id = $request->route('id');

        if ($request->user()->id != $id) {
            throw new MissingScopeException();
        }

        return $next($request);
    }
}