<?php
/**
 * Created by PhpStorm.
 * User: EricJin
 * Date: 2017/3/17
 * Time: 上午10:28
 */

namespace App\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;

class SetPasswordRequest extends FormRequest
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
			'password' => 'required|isPassword',
			'newPassword' => 'required|isPassword',
			'rePassword' => 'required|isPassword'
		];
	}
}