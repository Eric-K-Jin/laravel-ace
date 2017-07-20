<?php
/**
 * Created by PhpStorm.
 * User: EricJin
 * Date: 2017/7/20
 * Time: 12:16
 */

namespace App\Repositories;


use App\Models\Role;

class RoleRepository
{
    /**
     * 获取角色总数
     * @param $search
     * @return mixed
     */
    public function getTotal($search) {
        return Role::where(function ($query) use ($search) {
            return $query->where('name', 'LIKE', '%' . $search . '%')
                ->orWhere('description', 'like', '%' . $search . '%');
        })->count();
    }

    /**
     * 获取角色列表
     * @param $search
     * @param $page
     * @param $limit
     * @return mixed
     */
    public function getList($search, $page, $limit) {
        return Role::where(function ($query) use ($search) {
            return $query->where('name', 'LIKE', '%' . $search . '%')
                ->orWhere('description', 'like', '%' . $search . '%');
        })
            ->forPage($page, $limit)
            ->get();
    }
}