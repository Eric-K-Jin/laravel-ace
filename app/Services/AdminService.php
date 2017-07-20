<?php
/**
 * Created by PhpStorm.
 * User: EricJin
 * Date: 2017/6/7
 * Time: 12:07
 */

namespace App\Services;


use App\Repositories\AdminRepository;
use App\Tools\Response;

class AdminService
{
    protected $repository, $response;

    public function __construct(AdminRepository $repository, Response $response)
    {
        $this->repository = $repository;
        $this->response = $response;
    }

    /**
     * 修改管理员密码
     * @param $password
     * @param $newPassword
     * @return \Illuminate\Http\JsonResponse
     */
    public function updatePassword($password, $newPassword)
    {
        $id = auth('admin')->user()->id;
        $where = [
            'id' => $id
        ];
        if (!$adminInfo = $this->repository->getInfo($where)) {
            return $this->response->responseNotFound();
        }

        if (!\Hash::check($password, $adminInfo->password)) {
            return $this->response->setCode(code('admin_user_password_error'))->responseWithError(message('admin_user_password_error'));
        }

        $adminInfo->password = bcrypt($newPassword);
        if (!$adminInfo->save()) {
            return $this->response->setCode(code('system_error'))->responseWithError(message('system_error'));
        }

        return $this->response->responseNormal([]);
    }

    /**
     * 获取管理员人数
     * @param $search
     * @return mixed
     */
    public function getUserTotal($search) {
        return $this->repository->getTotal($search);
    }

    /**
     * 获取管理员列表
     * @param $search
     * @param $page
     * @param $limt
     * @return mixed
     */
    public function getUserList($search, $page, $limt) {
        return $this->repository->getList($search, $page, $limt);
    }
}