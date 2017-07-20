<?php

namespace App\Http\Middleware;

use App\Tools\Response;
use Closure;

class AdminAuthMiddleware
{
    protected $except = [
        'admin'
    ];

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        $response = new Response();

        if (\Auth::guard($guard)->guest()) {
            if ($request->ajax() || $request->wantsJson()) {
                return response('Unauthorized.', 401);
            } else {
                return redirect()->guest('admin/login');
            }
        }

        $routeName = \Route::currentRouteName();

        if (\Auth::guard('admin')->user()->isSuperAdmin() || in_array(\URL::getRequest()->path(), $this->except)) {
            return $next($request);
        }

        if (!\Gate::forUser(\Auth::guard('admin')->user())->check($routeName)) {
            if ($request->ajax() && ($request->getMethod() != 'GET')) {
                return $response->setCode(code('unauthorized'))->responseWithError(message('unauthorized'));
            } else {
                return $response->setCode(code('no_permission_to_operate'))->responseWithError(message('no_permission_to_operate'));
            }
        }

        return $next($request);
    }
}
