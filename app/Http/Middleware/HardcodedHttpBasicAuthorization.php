<?php

namespace App\Http\Middleware;

use App\Responses\Classes\ErrorAPIResponse;
use Closure;
use Illuminate\Validation\UnauthorizedException;

class HardcodedHttpBasicAuthorization
{

    //Hardcoding the credentials as the Services API document instructions
    private static $credentials = [
        'USER'     => 'my_user',
        'PASSWORD' => 'my_password'
    ];

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->getUser() != self::$credentials['USER'] || $request->getPassword() != self::$credentials['PASSWORD']) {

            return new ErrorAPIResponse(new UnauthorizedException());
        }

        return $next($request);
    }
}
