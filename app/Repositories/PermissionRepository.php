<?php
/**
 * Created by PhpStorm.
 * User: EricJin
 * Date: 2017/7/20
 * Time: 12:09
 */

namespace App\Repositories;


use App\Models\Permission;

class PermissionRepository
{
    /**
     * 获取相关权限规则总数
     * @param $cid
     * @param $search
     * @return mixed
     */
    public function getTotal($cid, $search) {
        return Permission::where('cid', $cid)->where(function ($query) use ($search) {
            return $query->where('name', 'LIKE', '%' . $search . '%')
                ->orWhere('description', 'like', '%' . $search . '%')
                ->orWhere('label', 'like', '%' . $search . '%');
        })->count();
    }

    /**
     * 获取整个权限规则列表
     * @param $cid
     * @param $search
     * @param $page
     * @param $limit
     * @return mixed
     */
    public function getList($cid, $search, $page, $limit) {
        return Permission::where('cid', $cid)->where(function ($query) use ($search) {
            return $query->where('name', 'LIKE', '%' . $search . '%')
                ->orWhere('description', 'like', '%' . $search . '%')
                ->orWhere('label', 'like', '%' . $search . '%');
        })
            ->forPage($page, $limit)
            ->get();
    }
}