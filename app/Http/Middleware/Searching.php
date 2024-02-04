<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Searching
{
    const ALLOWED_ALL = [];

    const MAX_PER_PAGE = 100;

    const DEFAULT_PER_PAGE = 10;
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $per_page = in_array($request->segment(2), self::ALLOWED_ALL) ? "" : self::DEFAULT_PER_PAGE;

        if (filter_var($request->per_page, FILTER_VALIDATE_INT) !== false) {
            if (abs($request->per_page) > self::MAX_PER_PAGE) {
                $per_page = self::MAX_PER_PAGE;
            } else {
                $per_page = abs($request->per_page);
            }
        }

        $request->merge(['per_page' => $per_page]);

        return $next($request);
    }
}
