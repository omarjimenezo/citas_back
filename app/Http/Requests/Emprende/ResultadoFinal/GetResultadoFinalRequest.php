<?php
namespace App\Http\Requests\Emprende\ResultadoFinal;

use Joeldeval\Form\FormRequest;
use App\Http\Requests\ValidationRequest;

class GetResultadoFinalRequest extends ValidationRequest
{
    public function authorize()
	{
		return true;
	}

	public function rules()
	{
		$rules = [

            'token'    => 'required',
	
		];

		return $rules;

	}

	public function messages(){
        return [

            'token.required'    => 'Ingesa el token.',
			
		];
    }
}