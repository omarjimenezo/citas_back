<?php
namespace App\Http\Requests\Academia\Inscription;

use App\Http\Requests\ValidationRequest;

/**
 * Class ContactRequest.
 */
class SaveInscriptionRequest extends ValidationRequest
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
            'idpaymentType' => 'required',
		];

	}

	/**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
			'idpaymentType.required' => 'Ingresa un método de pago',
		];
    }
}