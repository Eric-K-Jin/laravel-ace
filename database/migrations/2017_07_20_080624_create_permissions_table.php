<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('permissions', function($table) {
            $table->increments('id');
            $table->integer('cid')->comment('上级权限id,0为一级');
            $table->string('name');
            $table->string('label');
            $table->string('description');
            $table->string('icon')->comment('图标');
            $table->enum('is_menu', ['0', '1'])->default('0')->comment('0不是菜单项，1是菜单项');
            $table->integer('sort')->comment('权重');
            $table->timestamps();
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
