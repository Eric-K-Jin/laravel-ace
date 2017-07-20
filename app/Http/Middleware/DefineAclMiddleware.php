<?php

namespace App\Http\Middleware;

use App\Models\Permission;
use Closure;

class DefineAclMiddleware
{
    protected $permissions;

    public function __construct()
    {
        $this->permissions = Permission::with('roles')->get();
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        foreach ($this->permissions as $permission)
        {

            \Gate::define($permission->name, function ($user) use ($permission)
            {
                return $user->hasRole($permission->roles);
            });
        }
        return $next($request);
    }
}
