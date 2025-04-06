<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class VerifyCsrfToken
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
    protected $except = [
        // Add routes you want to exclude from CSRF verification here.
        // For example:
        'advertisement/*', // To exclude advertisement routes from CSRF verification.
    ];

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Handle CSRF verification
        if ($this->isReading($request) || $this->isExcluded($request)) {
            return $next($request);
        }

        if ($this->tokensMatch($request)) {
            return $next($request);
        }

        Log::error('CSRF token mismatch', ['url' => $request->fullUrl()]);
        abort(419, 'CSRF token mismatch');
    }

    /**
     * Determine if the request has a valid CSRF token.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    protected function tokensMatch(Request $request)
    {
        $token = $request->session()->token();
        return hash_equals($token, $request->input('_token') ?: $request->header('X-CSRF-TOKEN'));
    }

    /**
     * Determine if the request is reading data.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    protected function isReading(Request $request)
    {
        return $request->isMethod('get') || $request->isMethod('head');
    }

    /**
     * Determine if the request is in the excluded list.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    protected function isExcluded(Request $request)
    {
        foreach ($this->except as $except) {
            if ($request->is($except)) {
                return true;
            }
        }
        return false;
    }
}
