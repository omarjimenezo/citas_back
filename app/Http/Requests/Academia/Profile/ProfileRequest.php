<?php
namespace App\Http\Requests\Academia\Profile;

use App\Http\Requests\ValidationRequest;

/**
 * Class PreRegisterRequest.
 */
class ProfileRequest extends ValidationRequest
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
			'id_AcaUserAcademy' => 'required',
			'id_informationMedia' => 'required',
			'id_fiscalRegime' => 'required',
			'id_userType' => 'required',
			'id_typeUserType' => 'required',
			'id_HaveHadCreditFojal' => '',
			'creditNumber' => '',
			'id_BusinessTraining' => 'required',
            'firstName' => 'required|max:200',
            'lastName' => 'required|max:200',
            'secondLastName' => 'required|max:200',
			'id_gender' => 'required',
			'id_civilStatus' => 'required',
			'id_matrimonialRegime' => '',
            'birthdate' => 'required|max:100',
            'age'=>'required|max:100',
			'id_countryBirth' => 'required',
            'curp' => ['required','unique:aca_user_academy,CURP,' .$this->id_AcaUserAcademy, 'regex:/^[A-Z]{1}[AEIOU]{1}[A-Z]{2}[0-9]{2}(0[1-9]|1[0-2])(0[1-9]|1[0-9]|2[0-9]|3[0-1])[HM]{1}(AS|BC|BS|CC|CS|CH|CL|CM|DF|DG|GT|GR|HG|JC|MC|MN|MS|NT|NL|OC|PL|QT|QR|SP|SL|SR|TC|TS|TL|VZ|YN|ZS|NE)[B-DF-HJ-NP-TV-Z]{3}[0-9A-Z]{1}[0-9]{1}$/'],
			'rfc' => ['required','unique:aca_user_academy,rfc,'.$this->id_AcaUserAcademy, 'regex:/^([A-Z,Ñ,&]{3,4}([0-9]{2})(0[1-9]|1[0-2])(0[1-9]|1[0-9]|2[0-9]|3[0-1])[A-Z|\d]{3})+$/'],
            'id_occupation' => 'required|max:100',
			'email' => 'required|email|unique:aca_user_academy,email,'.$this->id_AcaUserAcademy,
			'phoneNumberList' => 'required',
			'cityLocality' => 'required|max:70',
			'id_Municipality' => 'required',
			'id_state' => 'required',
			'postalCode' => 'required',
			'password' => 'same:confirm_password',
			'confirm_password' => '',
			'idCapacitationArea' => '',
			'idScholarship' => 'required',
			'street' => 'required|max:100',
			'outsideNumber' => 'required|max:100',
			'insideNumber' => 'max:100',
			'colony' => 'required|max:100',
			'anotherOccupation' => ''
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