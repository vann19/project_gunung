<?php

namespace App\Http\Middleware;

use App\Models\Visit;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class LogVisit
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        // Only log GET requests (pages)
        if ($request->method() === 'GET') {
            try {
                $userId = Auth::check() ? Auth::id() : null;

                // skip logging assets and laravel telescope/horizon routes
                $path = $request->path();
                if (str_starts_with($path, 'vendor') || str_starts_with($path, 'storage') || str_starts_with($path, '_ignition') || str_starts_with($path, 'horizon') || str_starts_with($path, 'telescope')) {
                    return $next($request);
                }

                $ip = $request->ip();
                $geo = [];
                try {
                    // quick external lookup (fallback to nulls on failure)
                    $resp = Http::timeout(2)->get("http://ip-api.com/json/" . $ip, [
                        'fields' => 'status,country,regionName,city,query'
                    ]);
                    if ($resp->ok()) {
                        $data = $resp->json();
                        if (($data['status'] ?? '') === 'success') {
                            $geo['city'] = $data['city'] ?? null;
                            $geo['region'] = $data['regionName'] ?? null;
                            $geo['country'] = $data['country'] ?? null;
                        }
                    }
                } catch (\Throwable $e) {
                    // ignore geo lookup failure
                }

                Visit::create(array_merge([
                    'user_id' => $userId,
                    'ip' => $ip,
                    'method' => $request->method(),
                    'path' => '/' . ltrim($request->path(), '/'),
                    'user_agent' => substr($request->userAgent() ?? '', 0, 1000),
                    'referer' => $request->headers->get('referer') ?: null,
                ], $geo));
            } catch (\Throwable $e) {
                // don't break the app if logging fails
            }
        }

        return $next($request);
    }
}
