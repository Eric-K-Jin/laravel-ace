<?php
/**
 * Created by PhpStorm.
 * User: EricJin
 * Date: 2017/7/18
 * Time: 12:10
 */
if (!function_exists('code')) {
    /**
     * code
     * @param $id
     * @return string|\Symfony\Component\Translation\TranslatorInterface
     */
    function code($id)
    {
        return trans('code.' . $id);
    }
}

if (!function_exists('message')) {
    /**
     * message
     * @param $id
     * @return string|\Symfony\Component\Translation\TranslatorInterface
     */
    function message($id)
    {
        return trans('message.' . $id);
    }
}

if (!function_exists('checkPermission')) {
    function checkPermission($permission)
    {
        return \Gate::forUser(\Auth::guard('admin')->user())->check($permission);
    }
}