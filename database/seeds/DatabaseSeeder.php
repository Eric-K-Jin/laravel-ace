<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::beginTransaction();

        $admins = DB::table('admins')->insert([
            'username' => 'admin',
            'password' => bcrypt('abc123'),
            'realname' => 'admin',
            'status' => '1',
            'remember_token' => ''
        ]);

        $permissions = DB::table('permissions')->insert([
            ['id' => 1, 'cid' => 0, 'name' => 'admin.index', 'label' => '主页', 'description' => 'admin/index', 'icon' => 'fa fa-home', 'is_menu' => '0', 'sort' => 1],
            ['id' => 2, 'cid' => 1, 'name' => 'admin.index', 'label' => '首页', 'description' => '首页', 'icon' => '', 'is_menu' => '0', 'sort' => 0],
            ['id' => 3, 'cid' => 1, 'name' => 'admin.update-pwd', 'label' => '修改密码', 'description' => '修改密码', 'icon' => '', 'is_menu' => '0', 'sort' => 0],
            ['id' => 4, 'cid' => 0, 'name' => 'admin.manager.index', 'label' => '后台管理', 'description' => '后台管理', 'icon' => 'fa fa-user', 'is_menu' => '0', 'sort' => 2],
            ['id' => 5, 'cid' => 4, 'name' => 'admin.manager.index', 'label' => '后台账户', 'description' => 'admin/manager/index', 'icon' => '', 'is_menu' => '1', 'sort' => 0],
            ['id' => 6, 'cid' => 4, 'name' => 'admin.role.index', 'label' => '角色管理', 'description' => 'admin/role/index', 'icon' => '', 'is_menu' => '1', 'sort' => 0],
            ['id' => 7, 'cid' => 4, 'name' => 'admin.permission.index', 'label' => '权限列表', 'description' => 'admin/permission/index', 'icon' => '', 'is_menu' => '1', 'sort' => 0]
        ]);

        $roles = DB::table('roles')->insert([
            'name' => 'admin',
            'label' => 'The admin of the site',
            'description' => ''
        ]);

        $roles_admins = DB::table('roles_admins')->insert([
            'roles_id' => 1,
            'admins_id' => 1
        ]);

        $roles_permissions = DB::table('roles_permissions')->insert([
            'roles_id' => 1,
            'permissions_id' => 1
        ]);

        if ($admins && $permissions && $roles && $roles_admins && $roles_permissions) {
            DB::commit();
        } else {
            DB::rollBack();
        }
        // $this->call(UsersTableSeeder::class);
    }
}
