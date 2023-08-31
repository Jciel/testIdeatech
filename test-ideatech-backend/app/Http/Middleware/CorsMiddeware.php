<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Client\Response;

class CorsMiddeware
{
    public function handle($request, Closure $next)
    {
        if ($request->isMethod('OPTIONS')) {
            $response = response('', 200);
        } else {
            $response = $next($request);
        }

        $response->header('Access-Control-Allow-Origin', '*');
        $response->header('Access-Control-Allow-Headers', ['*']);
        $response->header('Access-Control-Allow-Methods', 'HEAD, GET, POST, PUT, PATCH, DELETE');
        $response->header('Content-Type', 'application/json');
        return $response;
    }
}
