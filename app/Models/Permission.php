<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Permission extends Model {

    public $table = 'permissions';

    public $timestamps = true;

    public $fillable=['name','label','description', 'is_menu'];

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'roles_permissions', 'permissions_id', 'roles_id');
    }
}
