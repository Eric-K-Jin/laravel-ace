<?php
/**
 * Created by PhpStorm.
 * User: guan
 * Date: 17/4/18
 * Time: 上午12:44
 */

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class AdminUserCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            'username'=>'required|unique:admins|max:255',
            'realname'=>'required|unique:admins,realname|max:255',
            'password'=>'required|confirmed|min:6|max:50'
        ];
    }
}