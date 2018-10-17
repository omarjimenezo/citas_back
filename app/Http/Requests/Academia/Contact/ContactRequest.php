<?php
namespace App\Http\Requests\Academia\Contact;

use App\Http\Requests\ValidationRequest;

/**
 * Class ContactRequest.
 */
class ContactRequest extends ValidationRequest
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
            'name' => 'required|max:150',
            'email' => 'required|email',
			'subject' => 'required|max:150',
			'message' => 'required|max:255'
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
			'name.required' => 'Ingresa un nombre',
            'name.max' => 'El nombre no debe sobrepasar de 150 caracteres',
			'email.required'=>'Ingesa un correo electronico.',
            'email.email'=>'Ingresa un correo electronico valido.',
			'subject.required' => 'Ingresa un asunto',
			'subject.max' => 'El asunto no debe sobrepasar de 150 caracteres',			
			'message.required' => 'Ingresa un mensaje',
			'message.max' => 'El mensaje no debe sobrepasar de 255 caracteres',
		];
    }
}