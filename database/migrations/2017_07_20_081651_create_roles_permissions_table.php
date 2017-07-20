<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRolesPermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('roles_permissions', function($table) {
            $table->increments('id');
            $table->integer('roles_id')->comment('用户角色id，关联roles主键id');
            $table->integer('permissions_id')->comment('权限规则id，关联permissions主键id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
