<?php
/**
 * Created by PhpStorm.
 * User: EricJin
 * Date: 2017/7/20
 * Time: 12:17
 */

namespace App\Services;


use App\Repositories\RoleRepository;

class RoleService
{
    protected $repository;

    public function __construct(RoleRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * 获取角色总数
     * @param $search
     * @return mixed
     */
    public function getRoleTotal($search) {
        return $this->repository->getTotal($search);
    }

    /**
     * 获取角色列表
     * @param $search
     * @param $page
     * @param $limit
     * @return mixed
     */
    public function getRoleList($search, $page, $limit) {
        return $this->repository->getList($search, $page, $limit);
    }
}