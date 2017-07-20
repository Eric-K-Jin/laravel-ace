<?php
/**
 * Created by PhpStorm.
 * User: EricJin
 * Date: 2017/6/7
 * Time: 12:04
 */

namespace App\Repositories;


use App\Models\Admin;

class AdminRepository
{

    /**
     * 获取管理员信息
     * @param array $where
     * @return mixed
     */
    public function getInfo(array $where)
    {
        return Admin::where($where)->first();
    }

    /**
     * 获取管理员总数
     * @param $search
     * @return mixed
     */
    public function getTotal($search)
    {
        return Admin::where(function ($query) use ($search) {
            $query->where('username', 'LIKE', '%' . $search . '%')
                ->orWhere('realname', 'like', '%' . $search . '%');
        })->count();
    }

    /**
     * 获取管理员列表
     * @param $search
     * @param $page
     * @param $limit
     * @return mixed
     */
    public function getList($search, $page, $limit)
    {
        return Admin::where(function ($query) use ($search) {
            $query->where('username', 'LIKE', '%' . $search . '%')
                ->orWhere('realname', 'like', '%' . $search . '%');
        })
            ->forPage($page, $limit)
            ->get();
    }
}