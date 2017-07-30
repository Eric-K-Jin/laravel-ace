<?php
/**
 * Created by PhpStorm.
 * User: EricJin
 * Date: 2017/6/12
 * Time: 10:28
 */

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\RoleCreateRequest;
use App\Http\Requests\Admin\RoleUpdateRequest;
use App\Models\Permission;
use App\Models\Role;
use App\Services\RoleService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    protected $fields = [
        'name' => '',
        'label' => '',
        'description' => '',
        'permissions' => [],
    ], $service;

    public function __construct(RoleService $service)
    {
        $this->service = $service;
    }


    public function index()
    {
        return view('admin.role.index');
    }

    public function roleList(Request $request)
    {
        $page = $request->input('page', 1);
        $limit = $request->input('limit', 10);
        $search = $request->input('search', null);

        $total = $this->service->getRoleTotal($search);
        $list = $this->service->getRoleList($search, $page, $limit);

        foreach ($list as $item) {
            $item->operate = '';
            if (checkPermission('admin.role.edit')) {
                $item->operate .= "<a data-url='' href='#admin/role/edit/{$item->id}'>编辑</a>";
            }

            if (checkPermission('admin.role.destroy')) {
                $item->operate .= " <a  href='javascript:;' class='delete' rel='$item->id' class='delete'>删除</a>";
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
        $arr = Permission::all()->toArray();
        foreach ($arr as $v) {
            $data['permissionAll'][$v['cid']][] = $v;
        }
        return view('admin.role.create', $data);
    }

    public function store(RoleCreateRequest $request)
    {
        $role = new Role();
        foreach (array_keys($this->fields) as $field) {
            $role->$field = $request->get($field);
        }
        unset($role->permissions);
        $role->save();
        if (is_array($request->get('permissions'))) {
            $role->permissions()->sync($request->get('permissions', []));
        }
        \Cache::forget('menus');
        return \Response::json(['code' => 0, 'msg' => '新增成功']);
    }

    public function edit($id)
    {
        $role = Role::find((int)$id);
        if (!$role)
            abort('404', '找不到该角色!');
        $permissions = [];
        if ($role->permissions) {
            foreach ($role->permissions as $v) {
                $permissions[] = $v->id;
            }
        }
        $role->permissions = $permissions;
        foreach (array_keys($this->fields) as $field) {
            $data[$field] = old($field, $role->$field);
        }
        $arr = Permission::all()->toArray();
        foreach ($arr as $v) {
            $data['permissionAll'][$v['cid']][] = $v;
        }
        $data['id'] = (int)$id;
        return view('admin.role.edit', $data);
    }

    public function update(RoleUpdateRequest $request)
    {
        $role = Role::find((int)$request->get('id'));
        foreach (array_keys($this->fields) as $field) {
            $role->$field = $request->get($field);
        }
        unset($role->permissions);
        $role->updated_at = Carbon::now();
        $role->save();
        $role->permissions()->sync($request->get('permissions', []));
        \Cache::forget('menus');
        return \Response::json(['code' => 0, 'msg' => '修改成功']);
    }

    public function destroy($id)
    {
        $role = Role::find((int)$id);
        if (!$role)
            abort(404, '用户组不存在!');
        if ($role_users = $role->users) {
            foreach ($role_users as $v) {
                $role->users()->detach($v);
            }
        }
        if ($role_permissions = $role->permissions) {
            foreach ($role->permissions as $v) {
                $role->permissions()->detach($v);
            }
        }

        if ($role) {
            $role->delete();
        } else {
            return \Response::json(['code' => -2, 'msg' => '删除失败']);
        }
        \Cache::forget('menus');
        return \Response::json(['code' => 0, 'msg' => '删除失败']);
    }
}