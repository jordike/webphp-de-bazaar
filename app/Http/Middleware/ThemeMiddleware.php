<?php

namespace App\Http\Middleware;

use App\Models\Company;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ThemeMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $company = $request->route('company');

        if (is_string($company)) {
            $company = Company::find($company);
        }

        if (!$company) {
            session()->forget('theme');

            return $next($request);
        }

        $theme = $company->currentTheme ?? null;

        if (isset($theme)) {
            session()->put('theme', $theme);
        } else {
            session()->forget('theme');
        }

        return $next($request);
    }
}
