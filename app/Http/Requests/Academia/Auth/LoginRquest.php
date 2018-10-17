<?php
namespace App\Http\Requests\Academia\Auth;

use Joeldeval\Form\FormRequest;
use App\Http\Requests\ValidationRequest;

class LoginRequest extends ValidationRequest
{
    public function authorize()
	{
		return true;
	}

	public function rules()
	{
		return [
            'studentCode' => 'required|alpha_num|exists:aca_user_academy',
            'password'  => 'required'
		];
    }
    
    public function message(){
        return [
            'studentCode.required'=>'Ingesa tu codigo de alumno.',
            'studentCode.exists' => 'Credenciales inválidas',
            'studentCode.alpha_num' => 'Credenciales inválidas',
            'password.required'  => 'Ingresa una contraseña'
		];
    }
}