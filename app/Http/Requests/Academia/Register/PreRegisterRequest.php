<?php
namespace App\Http\Requests\Academia\Register;

use App\Http\Requests\ValidationRequest;
use Illuminate\Validation\Rule;

/**
 * Class PreRegisterRequest.
 */
class PreRegisterRequest extends ValidationRequest
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
			'firstName' => 'required|max:150',
			'secondName' => 'max:150',
			'lastName' => 'required|max:150',
			'secondLastName' => 'required|max:150',
			'idGender' => 'required',
			'birthdate' => 'required|date',
			'curp' => ['required',Rule::unique('aca_user_academy')->where(function ($query) {
    				return $query->where('idStatus', 1)->orwhere('idStatus',2);
			}), 'regex:/^[A-Z]{1}[AEIOU]{1}[A-Z]{2}[0-9]{2}(0[1-9]|1[0-2])(0[1-9]|1[0-9]|2[0-9]|3[0-1])[HM]{1}(AS|BC|BS|CC|CS|CH|CL|CM|DF|DG|GT|GR|HG|JC|MC|MN|MS|NT|NL|OC|PL|QT|QR|SP|SL|SR|TC|TS|TL|VZ|YN|ZS|NE)[B-DF-HJ-NP-TV-Z]{3}[0-9A-Z]{1}[0-9]{1}$/'],
			'rfc' => ['required',Rule::unique('aca_user_academy')->where(function ($query) {
    				return $query->where('idStatus', 1)->orwhere('idStatus',2);
			}), 'regex:/^([A-Z,Ñ,&]{3,4}([0-9]{2})(0[1-9]|1[0-2])(0[1-9]|1[0-9]|2[0-9]|3[0-1])[A-Z|\d]{3})+$/'],
			'street' => 'required',
			'outsideNumber' => 'required',
			'postalCode' => 'required',
			'colony' => 'required|max:150',
			'cityLocality' => 'required',
			'idMunicipality' => 'required',
			'phoneNumber' => 'required|numeric|digits:10',
			'email' => 'required|email',Rule::unique('aca_user_academy')->where(function ($query) {
    				return $query->where('idStatus', 1);
			}),
			'idUserType' => 'required',
			'idTypeUserType' => 'required',
			'password' => 'required|min:6|same:confirm_password'
		];

	}

	/**
     * Get custom messages for validator errors.
     *
     * @return array
     */
	public function messages(){

        return [
			'firstName.required' => 'Ingresa un nombre',
			'firstName.max' => 'El nombre no debe sobrepasar de 150 caracteres',
			'lastName.required' => 'Ingresa un apellido paterno',
			'lastName.max' => 'El nombre no debe sobrepasar de 150 caracteres',			
			'secondLastName.required' => 'Ingresa un apellido materno',
			'secondLastName.max' => 'El nombre no debe sobrepasar de 150 caracteres',
			'idGender.required' => 'Ingresa un género',
			'birthdate.required' => 'Ingresa una fecha de nacimiento',
			'birthdate.date' => 'Ingresa una fecha correcta',
			'curp.required' => 'El CURP no puede estar vacío',
			'curp.regex' => 'El CURP no es válido',
			'curp.unique' => 'El CURP ya ha sido registrado',
			'rfc.unique' => 'El RFC ya ha sido registrado',
			'rfc.required' => 'El RFC no puede estar vacío',
			'rfc.regex' => 'El RFC no es válido',			
			'street.required' => 'Ingresa el nombre de tu calle',
			'outsideNumber.required' => 'Ingresa el numero exterior',
			'postalCode.required' => 'Ingresa el codigo postal',
			'colony.required' => 'Escribe tu colonia',
			'colony.max' => 'La colonia no debe sobrepasar de 150 caracteres',
			'cityLocality.required' => 'Ingresa la ciudad o localidad',
			'idMunicipality.required' => 'Ingresa el municipio',
			'phoneNumber.required' => 'Ingresa el numero de teléfono',
			'phoneNumber.digits' => 'El teléfono debe tener 10 dígitos',
			'phoneNumber.numeric' => 'El teléfono debe ser solamente números',
			'email.required'=>'Ingesa un correo electronico.',
            'email.email'=>'Ingresa un correo electronico valido.',
            'email.unique'=>'El correo electronico ya ha sido registrado.',
			'idUserType.required' => 'Selecciona Empresario o Emprendedor',
			'idTypeUserType.required' => 'Selecciona tipo de Emprendedor o Empresario',
			'password.required' => 'La contraseña no puede ser vacía',
			'password.same' => 'Las contraseñas no coinciden',
			'password.min' => 'La contraseña debe tener mínimo 6 dígitos'			
		];
    }
}