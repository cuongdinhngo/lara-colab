<?php

namespace App\Http\Middleware;

use Closure;
use App;

class CheckCurrentLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $locale = get_current_locale();
        App::setLocale($locale);
        return $next($request);
    }
}
