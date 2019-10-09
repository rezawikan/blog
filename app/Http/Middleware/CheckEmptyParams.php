<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckEmptyParams
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $query = $request->all();
        $querycount = count($query);
        foreach ($query as $key => $value) {
            if ($value == null) {
                unset($query[$key]);
            }
        }

        if ($querycount > count($query)) {
              return redirect()->to(
                url()->current() . (!empty($query) ? '/?' . http_build_query($query) : '')
              );
        }

        return $next($request);
    }
}
