<?php
/**
 * Created by PhpStorm.
 * User: EricJin
 * Date: 2017/7/19
 * Time: 18:09
 */

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    public function index() {
        return view('admin.index.index');
    }
}