<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Symfony\Component\HttpFoundation\Response;

class SetTenantRouteParameter
{
    public function handle(Request $request, Closure $next): Response
    {
        URL::defaults([
            'tenant' => tenant('id'),
        ]);

        return $next($request);
    }
}
