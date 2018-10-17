<?php
namespace App\Http\Requests\Academia\Auth;
use App\Http\Requests\ValidationRequest;

class ValidateTokenPass extends ValidationRequest
{
    public function authorize()
	{
		return true;
	}

	public function rules()
	{
		return [
            'password'     => 'required',
            'token' => 'required'
    	];
    }
    
    public function message(){
        return [
            'password.required'=>'Es necesario el campo password',
            'token.required'=>'Token necesario para completar la acción',
		];
    }
}