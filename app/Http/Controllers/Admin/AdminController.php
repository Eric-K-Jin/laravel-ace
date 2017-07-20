<?php
/**
 * Created by PhpStorm.
 * User: EricJin
 * Date: 2017/6/11
 * Time: 12:41
 */

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdminUserCreateRequest;
use App\Http\Requests\Admin\AdminUserUpdateRequest;
use App\Models\Admin as User;
use App\Models\Role;
use App\Services\AdminService;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    protected $fields = [
        'username' => '',
        'realname' => '',
        'status'=>1,
        'roles' => [],
    ], $service;

    public function __construct(AdminService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        return view('admin.manager.index');
    }


    function adminList(Request $request)
    {

        $page = $request->input('page', 1);
        $limit = $request->input('limit', 10);
        $search = $request->input('search', null);

        $total = $this->service->getUserTotal($search);
        $list = $this->service->getUserList($search, $page, $limit);

        foreach ($list as $item) {

            $item->status = $item->status ? "启用" : "锁定";

            $item->operate = '';
            if (checkPermission('admin.manager.edit')) {
                $item->operate .= "<a data-url='' href='#admin/manager/edit/{$item->id}'>编辑</a>";
            }

            if (checkPermission('admin.manager.destroy')) {
                $item->operate .= " <a href='javascript:;' class='delete' rel='$item->id' class='delete'>删除</a>";
            }
        }

        $data = ['data' => $list, 'total' => $total, 'page' => ceil($total / $limit), 'limit' => $limit];

        return \Response::json($data);

    }

    public function create()
    {
        $data = [];
        foreach ($this->fields as $field => $default) {
            $data[$field] = old($field, $default);
        }
        $data['rolesAll'] = Role::all()->toArray();
        return view('admin.manager.create', $data);
    }

    public function store(AdminUserCreateRequest $request)
    {
        foreach (array_keys($this->fields) as $field) {
            $data[$field] = $request->get($field);
        }
        $data['password'] = bcrypt($request->get('password'));
        unset($data['roles']);
        $user = User::create($data);
        if (is_array($request->get('roles'))) {
            $user->giveRoleTo($request->get('roles'));
        }
        return \Response::json(['code' => 0, 'msg' => '新增成功']);
    }


    public function edit($id)
    {
        $user = User::find((int)$id);
        if (!$user)
            abort(404);
        $roles = [];
        if ($user->roles) {
            foreach ($user->roles as $v) {
                $roles[] = $v->id;
            }
        }
        $user->roles = $roles;
        foreach (array_keys($this->fields) as $field) {
            $data[$field] = old($field, $user->$field);
        }
        $data['rolesAll'] = Role::all()->toArray();
        $data['id'] = (int)$id;
        return view('admin.manager.edit', $data);
    }


    public function update(AdminUserUpdateRequest $request)
    {
        $user = User::find((int)$request->input('id'));
        foreach (array_keys($this->fields) as $field) {
            $user->$field = $request->get($field);
        }
        unset($user->roles);
        if ($request->get('password') != '') {
            $user->password = bcrypt($request->get('password'));
        }
        $user->save();
        $user->giveRoleTo($request->get('roles', []));
        return \Response::json(['code' => 0, 'msg' => '成功']);
    }


    public function destroy($id)
    {
        $tag = User::find((int)$id);
        foreach ($tag->roles as $v) {
            $tag->roles()->detach($v);
        }
        if ($tag && $tag->id != 1) {
            $tag->delete();
        } else {
            return \Response::json(['code' => -2, 'msg' => '删除失败']);
        }
        return \Response::json(['code' => 0, 'msg' => '删除成功']);
    }

}