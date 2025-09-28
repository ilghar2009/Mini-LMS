<?php

namespace App\Http\Middleware;

use App\Models\Token_User;
use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TokenCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        //get token and check
            $token_code = $request->bearerToken();
            $token = Token_User::where('token', $token_code)->first();

        if(isset($token_code) and $token->user) {

            if ($token->expired_time < Carbon::now()->timestamp)
                return \response()->json([
                    'error' => 'token expired',
                ]);
            else
                return $next($request);

        }else
            return \response()->json([
                'error' => 'invalid token',
            ], 403);
    }
}
