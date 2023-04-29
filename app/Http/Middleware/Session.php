<?php

namespace App\Http\Middleware;

use App\Models\Session as ModelsSession;
use Closure;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Session
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $session = ModelsSession::where('token', $request->header('Auth'))->first();
        if (!$session) throw new AuthenticationException();
        $request->merge(['session' => $session]);
        return $next($request);
    }
}
