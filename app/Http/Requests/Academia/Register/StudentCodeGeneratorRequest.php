<?php
namespace App\Http\Requests\Academia\Register;

use App\Http\Requests\ValidationRequest;
use Illuminate\Validation\Rule;

/**
 * Class PreRegisterRequest.
 */
class StudentCodeGeneratorRequest extends ValidationRequest
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
			'token' => 'required'
		];

	}

	/**
     * Get custom messages for validator errors.
     *
     * @return array
     */
	public function messages(){

        return [
			'token.required' => 'no se ha enviado un c&oacute;digo'			
		];
    }
}