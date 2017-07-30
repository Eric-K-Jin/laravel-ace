<?php

/**
 * Created by PhpStorm.
 * User: EricJin
 * Date: 2017/7/18
 * Time: 12:15
 */
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SetPasswordRequest;
use App\Models\Permission;
use App\Services\AdminService;
use App\Tools\Response;

class DashboardController extends Controller
{
    protected $response, $service;

    /**
     * create an new controller instance
     * DashboardController constructor.
     * @param Response $response
     * @param AdminService $service
     */
    public function __construct(Response $response, AdminService $service)
    {
        $this->middleware('auth.admin:admin');
        $this->response = $response;
        $this->service = $service;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $data = [
            'userName' => auth('admin')->user()->username,
            'menus' => $this->getMenu(),
        ];
        return view('admin.dashboard.index', $data);
    }

    public function getMenu()
    {
        $menus = [];
        $permissions = [];

//        $table = Permission::where('cid', 0)->orWhere('is_menu', '1')->orderBy('cid')->orderBy('sort')->get();
//       所有权限配好后使用下面的代码把权限进行缓存，缓存目录在 根目录/storage/framework/cache
        $table = \Cache::store('file')->rememberForever('menus', function () {
            return Permission::where('cid', 0)->orWhere('is_menu', '1')->orderBy('cid')->orderBy('sort')->get();
        });

        foreach ($table as $row) {
            if (checkPermission($row->name)) {
                if ($row->cid == 0) {
                    $menus[$row->id] = $row;
                } elseif ($row->is_menu == 1) {
                    $permissions[$row->cid][] = $row;
                }
            }
        }

        foreach ($menus as $row) {
            if (isset($permissions[$row->id])) {
                $row->permissions = $permissions[$row->id];
            }
        }
        return $menus;
    }

    /**
     * 修改用户密码
     * @param SetPasswordRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updatePassword(SetPasswordRequest $request)
    {
        $newPassword = $request->input('newPassword');
        $password = $request->input('password');

        return $this->service->updatePassword($password, $newPassword);
    }
}