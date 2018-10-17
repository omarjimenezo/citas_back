<?php
namespace App\Http\Requests\Academia\User;

use Joeldeval\Form\FormRequest;
use App\Http\Requests\ValidationRequest;

class RegistrationRequest extends ValidationRequest
{
    public function authorize()
	{
		return true;
	}

	public function rules()
	{
		$rules = [
			'firstName' => 'required|max:150',
			'secondName' => 'required|max:150',
			'lastName' => 'required|max:150',
			'secondLastName' => 'required|max:150',
			'idGender' => 'required',
			'birthdate' => 'required|date',
			'CURP' => ['required','unique:aca_user_academy', 'regex:/^[A-Z]{1}[AEIOU]{1}[A-Z]{2}[0-9]{2}(0[1-9]|1[0-2])(0[1-9]|1[0-9]|2[0-9]|3[0-1])[HM]{1}(AS|BC|BS|CC|CS|CH|CL|CM|DF|DG|GT|GR|HG|JC|MC|MN|MS|NT|NL|OC|PL|QT|QR|SP|SL|SR|TC|TS|TL|VZ|YN|ZS|NE)[B-DF-HJ-NP-TV-Z]{3}[0-9A-Z]{1}[0-9]{1}$/'],
			'rfc' => ['required','unique:aca_user_academy', 'regex:/^([A-Z,Ñ,&]{3,4}([0-9]{2})(0[1-9]|1[0-2])(0[1-9]|1[0-9]|2[0-9]|3[0-1])[A-Z|\d]{3})+$/'],
			'street' => 'required',
			'outsideNumber' => 'required',
			'postalCode' => 'required',
			'colony' => 'required|max:150',
			'cityLocality' => 'required',
			'idMunicipality' => 'required',
			'idState' => 'required',
			'phoneNumber' => 'required|max:15',
			'email' => 'required|email|unique:aca_user_academy',
			'idUserType' => 'required',
			'idTypeUserType' => 'required'

		];
		
		if ($this->input('id') == null) {
			$rules_new = [
				
				'password' => 'required|max:20|same:confirm_password'
			];
			return   $rules = array_merge($rules, $rules_new);
		}else{
			return array_merge($rules,['id' => 'required']);
		}
		
		return $rules;

	}

	public function message(){
        return [
			'firstName' => 'Ingresa un nombre',
			'lastName' => 'Ingresa un apellido paterno',
			'secondLastName' => 'Ingresa un apellido materno',
            'email.required'=>'Ingesa un correo electronico.',
            'email.email'=>'Ingresa un correo electronico valido.',
			'password.required'  => 'Ingresa una contraseña',
			'birthdate' => 'Ingresa una fecha de nacimiento',
			'address' => 'Ingresa una dirección',
			'phoneNumber' => 'Ingresa un numero de tlefono',
			'idState' => 'Ingresa un estado',
			'idMunicipaly' => 'Ingresa un municipio',
			'colony' => 'ingresa una colonia',
		];
    }
}