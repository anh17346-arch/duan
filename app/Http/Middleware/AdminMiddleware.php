<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    private const ADMIN_ROLE = 'admin';
    private const ERROR_MESSAGE = 'Chỉ quản trị viên mới được truy cập.';
    private const ERROR_CODE = 403;

    public function handle(Request $request, Closure $next): Response
    {
        if (!$this->isAdmin()) {
            $this->logUnauthorizedAccess($request);
            abort(self::ERROR_CODE, self::ERROR_MESSAGE);
        }

        return $next($request);
    }

    private function isAdmin(): bool
    {
        return auth()->check() && auth()->user()->role === self::ADMIN_ROLE;
    }

    private function logUnauthorizedAccess(Request $request): void
    {
        $user = auth()->user();
        $userId = $user ? $user->id : 'guest';
        $userEmail = $user ? $user->email : 'N/A';

        Log::warning('Unauthorized admin access attempt', [
            'user_id' => $userId,
            'user_email' => $userEmail,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'url' => $request->fullUrl(),
            'method' => $request->method(),
        ]);
    }
}
