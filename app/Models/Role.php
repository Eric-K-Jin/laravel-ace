<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    public $table = 'roles';

    public $timestamps = true;

    public $fillable = ['name', 'label', 'description'];

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'roles_permissions', 'roles_id', 'permissions_id');
    }

    public function users()
    {
        return $this->belongsToMany(Admin::class,'roles_admins','roles_id','admins_id');
    }

    public function getPermission(Permission $permission)
    {
        return $this->permissions()->save($permission);
    }
}
