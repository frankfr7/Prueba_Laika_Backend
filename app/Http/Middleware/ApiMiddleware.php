<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ApiMiddleware
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
        // Comprobar si el usuario está identificado
        $token = $request->header('Authorization');

        if ($token == 'api-key-laika'){

            return $next($request);
        }else{
            $data = array(
                'code'      => 400,
                'status'    => 'error',
                'message'   => 'El usuario no está identificado'
            );

            return response()->json($data, $data['code']);
        }
    }
}
