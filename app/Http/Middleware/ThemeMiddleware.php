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

        if (is_int($company)) {
            $company = Company::find($company);
        }

        if (!$company) {
            return $next($request);
        }

        $theme = $company->currentTheme ?? null;

        if ($theme) {
            session()->put('theme', $theme);
        }

        return $next($request);
    }
}
