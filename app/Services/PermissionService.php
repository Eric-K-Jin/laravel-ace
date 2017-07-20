<?php
/**
 * Created by PhpStorm.
 * User: EricJin
 * Date: 2017/7/20
 * Time: 12:09
 */

namespace App\Services;

use App\Repositories\PermissionRepository;

class PermissionService
{
    protected $repository;

    public function __construct(PermissionRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * 获取角色总数
     * @param $cid
     * @param $search
     * @return mixed
     */
    public function getPermissionTotal($cid, $search) {
        return $this->repository->getTotal($cid, $search);
    }

    /**
     * 获取角色列表
     * @param $cid
     * @param $search
     * @param $page
     * @param $limit
     * @return mixed
     */
    public function getPermissionList($cid, $search, $page, $limit) {
        return $this->repository->getList($cid, $search, $page, $limit);
    }
}