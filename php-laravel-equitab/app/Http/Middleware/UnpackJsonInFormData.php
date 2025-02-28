<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UnpackJsonInFormData
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->getContentTypeFormat() == "form") {
            foreach ($request->request->all() as $key => $value) {
                if (is_string($value)) {
                    try {
                        $request->request->set($key, json_decode($value, true));
                    } catch (\Exception $e) {
                        /** Ignore error */
                    }
                }
            }
        }

        return $next($request);
    }
}
