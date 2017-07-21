<?php
/**
 * Created by PhpStorm.
 * User: EricJin
 * Date: 2017/6/15
 * Time: 16:34
 */

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ProductCreateRequest extends FormRequest
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
            'name'=>'required|max:255',
            'category'=>'required',
            'amount'=>'required',
            'consult_times'=>'required|min:1',
            'validate_time'=>'required',
        ];
    }
}