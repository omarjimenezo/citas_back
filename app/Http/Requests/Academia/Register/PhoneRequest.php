<?php
namespace App\Http\Requests\Academia\Register;

use App\Http\Requests\ValidationRequest;
use Illuminate\Validation\Rule;

/**
 * Class PreRegisterRequest.
 */
class PhoneRequest extends ValidationRequest
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
			'phoneNumber' => 'required|numeric|digits:10'
		];

	}

	/**
     * Get custom messages for validator errors.
     *
     * @return array
     */
	public function messages(){

        return [
			'phoneNumber.required' => 'Ingresa el numero de teléfono',
			'phoneNumber.digits' => 'El teléfono debe tener 10 dígitos',
			'phoneNumber.numeric' => 'El teléfono debe ser solamente números'
		];
    }
}