<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Laravel\Socialite\Facades\Socialite;
use App\User;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    /*protected function redirectTo($request, Closure $next)
    {
        $user = Socialite::driver('github')->stateless()->user();

        if ($user->token) {
            return $next($request);
        }
        //return redirect('some_other_route_for_error');

        return Response::json([
            'message' => 'Please login!'
        ], 404);

        /*if (! $request->expectsJson()) {
            return route('login');
        }*/
    //}

    public function handle($request, $next)
    {
        $status = false;
        $accessToken =  $request->bearerToken();
        if($accessToken) {
            $user_check = User::where("api_token", $accessToken)->first();
            if(!empty($user_check))
            {
                $status = true;
            }
        }

        if($status == false) {
            return response()->json([
                'message' => 'Bad credentials',
            ], 401);
        } else {
            return $next($request);
        }
    }
}
