<?php

namespace App\Http\Middleware;

use Closure;

class XSSProtection
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
        if (!in_array(strtolower($request->method()), ['put', 'post', 'get']))
        {
            return $next($request);
        }

        $input = $request->all();

        array_walk_recursive($input, function (&$input, $low = false)
        {
            $input = strip_tags($input);
            $input = htmlspecialchars($input);
            if ($low)
            {
                $input = str_replace(array('"', "\\", "'", "/", "..", "../", "./", "//"), '', $input);
                $no = '/%0[0-8bcef]/';
                $input = preg_replace($no, '', $input);
                $no = '/%1[0-9a-f]/';
                $input = preg_replace($no, '', $input);
                $no = '/[\x00-\x08\x0B\x0C\x0E-\x1F\x7F]+/S';
                $input = preg_replace($no, '', $input);
            }
        });

        $request->merge($input);

        return $next($request);
    }
}
