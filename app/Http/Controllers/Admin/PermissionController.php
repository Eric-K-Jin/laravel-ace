<?php
/**
 * Created by PhpStorm.
 * User: EricJin
 * Date: 2017/6/12
 * Time: 10:48
 */

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PermissionCreateRequest;
use App\Http\Requests\Admin\PermissionUpdateRequest;
use App\Models\Permission;
use App\Services\PermissionService;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    protected $fields = [
        'name' => '',
        'label' => '',
        'description' => '',
        'cid' => 0,
        'icon' => '',
        'is_menu' => ''
    ], $service;

    public function __construct(PermissionService $service)
    {
        $this->service = $service;
    }

    public function index($cid = 0)
    {
        $cid = (int)$cid;
        $datas['cid'] = $cid;
        if ($cid > 0) {
            $datas['data'] = Permission::find($cid);
        }
        return view('admin.permission.index', $datas);
    }

    public function permissionList(Request $request,$cid=0)
    {
        $page = $request->input('page', 1);
        $limit = $request->input('limit', 10);
        $search = $request->input('search', null);

        $total = $this->service->getPermissionTotal($cid, $search);
        $list = $this->service->getPermissionList($cid, $search, $page, $limit);

        foreach ($list as $item) {
            $item->operate = '';

            //下级菜单
            if ($cid == 0) {
                $item->operate .= "<a data-url='admin/permission/index/{$item->id}' href='#admin/permission/index/{$item->id}'>下级权限  </a>";
            }

            if (checkPermission('admin.permission.edit')) {
                $item->operate .= "<a data-url='admin/permission/edit/{$item->id}' href='#admin/permission/edit/{$item->id}'>编辑  </a>";
            }
            if (checkPermission('admin.permission.destroy')) {
                $item->operate .= " <a href='javascript:;' class='delete' rel='$item->id' class='delete'>删除</a>";
            }
        }

        $data = ['data' => $list, 'total' => $total, 'page' => ceil($total / $limit), 'limit' => $limit];

        return \Response::json($data);
    }


    public function create($cid=0)
    {
        $data = [];
        foreach ($this->fields as $field => $default) {
            $data[$field] = old($field, $default);
        }
        $data['cid'] = $cid;
        return view('admin.permission.create', $data);
    }

    public function store(PermissionCreateRequest $request)
    {
        $permission = new Permission();
        foreach (array_keys($this->fields) as $field) {
            if ($field == 'is_menu') {
                if ($request->get('is_menu') == "on")
                    $permission->$field = '1';
                else
                    $permission->$field = '0';
            } else {
                $permission->$field = $request->get($field, $this->fields[$field]);
            }
        }
        $permission->save();
        return \Response::json(['code' => 0, 'msg' => '添加成功']);
    }


    public function edit($id)
    {
        $permission = Permission::find((int)$id);
        if (!$permission)
            abort(404, '找不到该权限数据!');
        $data = ['id' => (int)$id];
        foreach (array_keys($this->fields) as $field) {
            $data[$field] = old($field, $permission->$field);
        }
        return view('admin.permission.edit', $data);
    }


    public function update(PermissionCreateRequest $request)
    {
        $permission = Permission::find((int)$request->get('id'));
        foreach (array_keys($this->fields) as $field) {
            if ($field == 'is_menu') {
                if ($request->get('is_menu') == "on")
                    $permission->$field = '1';
                else
                    $permission->$field = '0';

                continue;
            } elseif ($field == 'icon')  {
                if ($request->get('icon') == "") {
                    continue;
                }
            }
            $permission->$field = $request->get($field, $this->fields[$field]);
        }
        $permission->save();
        return \Response::json(['code' => 0, 'msg' => '修改成功']);
    }


    public function destroy($id)
    {
        $child = Permission::where('cid', $id)->first();
        if ($child) {
            return \Response::json(['code' => -2, 'msg' => '请先将该权限的子权限删除后再做删除操作!']);
        }

        $tag = Permission::find((int)$id);

        foreach ($tag->roles as $v) {
            $tag->roles()->detach($v->id);
        }

        if ($tag) {
            $tag->delete();
        } else {
            return \Response::json(['code' => -2, 'msg' => '删除失败!']);
        }
        return \Response::json(['code' => 0, 'msg' => '删除成功']);
    }

}