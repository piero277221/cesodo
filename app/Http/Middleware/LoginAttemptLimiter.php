<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

class LoginAttemptLimiter
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->isMethod('post') && $request->routeIs('login')) {
            $email = $request->input('email');
            $ip = $request->ip();

            // Clave para el cache basada en email e IP
            $cacheKey = 'login_attempts_' . md5($email . $ip);
            $attempts = Cache::get($cacheKey, 0);

            // Límite de intentos
            $maxAttempts = 5;
            $lockoutMinutes = 15;

            if ($attempts >= $maxAttempts) {
                return back()->withErrors([
                    'email' => 'Demasiados intentos de inicio de sesión. Inténtalo de nuevo en ' . $lockoutMinutes . ' minutos.',
                ])->withInput($request->only('email'));
            }

            // Incrementar intentos si la autenticación falla
            $response = $next($request);

            if ($response->getStatusCode() === 302 && session()->has('errors')) {
                Cache::put($cacheKey, $attempts + 1, now()->addMinutes($lockoutMinutes));
            } else {
                // Si el login es exitoso, limpiar los intentos
                Cache::forget($cacheKey);
            }

            return $response;
        }

        return $next($request);
    }
}
