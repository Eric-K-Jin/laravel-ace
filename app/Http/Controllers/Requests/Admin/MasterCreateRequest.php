<?php
/**
 * Created by PhpStorm.
 * User: EricJin
 * Date: 2017/6/19
 * Time: 14:49
 */

namespace App\Http\Requests\Admin;


use Illuminate\Foundation\Http\FormRequest;

class MasterCreateRequest extends FormRequest
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

    public function rules()
    {
        return [
            'name'=>'required|max:10',
            'title'=>'required',
            'post'=>'required',
            'background'=>'required'
        ];
    }
}