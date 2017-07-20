<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable {

    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'realname', 'email', 'password', 'status',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    public function roles()
    {
        return $this->belongsToMany(Role::class,'roles_admins','admins_id','roles_id');
    }

    public function assignRole($role)
    {
        return $this->roles()->save(
            Role::find($role->id)
        );
    }

    public function hasRole($roles)
    {
        if (is_string($roles))
        {
            return $this->roles->contain('name', $roles);
        }

        return !!$roles->intersect($this->roles)->count();
    }

    // 判断用户是否具有某权限
    public function hasPermission($permission)
    {
        if (is_string($permission)) {
            $permission = Permission::where('name', $permission)->first();
            if (!$permission) return false;
        }
        return $this->hasRole($permission->roles);
    }

    //角色整体添加与修改
    public function giveRoleTo(array $RoleId)
    {
        $this->roles()->detach();
        $roles = Role::whereIn('id', $RoleId)->get();
        foreach ($roles as $v) {
            $this->assignRole($v);
        }
        return true;
    }

    public function isSuperAdmin()
    {
        if ($this->username == 'admin') {
            return true;
        }
        return false;
    }
}