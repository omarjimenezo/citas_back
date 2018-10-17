<?php
namespace App\Http\Requests\Academia\ValidatePassword;

use App\Http\Requests\ValidationRequest;

/**
 * Class PreRegisterRequest.
 */
class ValidatePasswordRequest extends ValidationRequest
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
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
	public function rules()
	{
		return [
			'CurrentPassword' => 'required',
		];

	}

	/**
     * Get custom messages for validator errors.
     *
     * @return array
     */
	public function messages(){

        return [
			'firstName.required' => 'Ingresa el password actual',	
		];
    }
}