<?php
namespace App\Http\Requests\Academia\Auth;
use App\Http\Requests\ValidationRequest;

class RecoverPassRequest extends ValidationRequest
{
    public function authorize()
	{
		return true;
	}

	public function rules()
	{
		return [
            'email'     => 'required|email'
    	];
    }
    
    public function message(){
        return [
            'email.required'=>'Ingresa un correo electronico',
            'email.email'=>'Ingresa un correo electronico valido',
		];
    }
}