<?php
namespace App\Http\Requests\Emprende\Participante;

use Joeldeval\Form\FormRequest;
use App\Http\Requests\ValidationRequest;
use \Illuminate\Validation\Validator;
use App\Rules\MinYear;

class ParticipanteRequest extends ValidationRequest
{
    public function authorize()
	{
		return true;
    }
  

	public function rules()
	{
        $rules = ['idFiscalRegimeGeneral' => "required",];

        ///Valida si el id de regimen fiscal es fisico
        if ($this->input('idFiscalRegimeGeneral') == 1) {
           $deudor_solidario = [
            'idFiscalRegimeGeneral' => "required",
                'deudor_solidario.idUser' => "required",
                'deudor_solidario.idParticipantsGuarantee' => "required",
                'deudor_solidario.firstName' => "required|max:150|min:2",
                'deudor_solidario.lastName' => "required|max:150|min:2",
                'deudor_solidario.secondName' => "max:150|min:2",
                'deudor_solidario.secondLastName' => "max:150|min:2",
                'deudor_solidario.idGender' => "required",
                'deudor_solidario.idCivilStatus' => "required",
                'deudor_solidario.idMatrimonialRegime' => "required",
                'deudor_solidario.birthdate' => "required",
                'deudor_solidario.idCountryNationality' => "required",
                'deudor_solidario.idCountryBirth' => "required",
                'deudor_solidario.idBirthdateState' => "required",
                'deudor_solidario.rfc' => "required|max:13|min:9",
                'deudor_solidario.homoclave' => "required|max:3|min:3",
                'deudor_solidario.CURP' => "required|max:18",
                'deudor_solidario.street' => "required|max:150",
                'deudor_solidario.outsideNumber' => "required|max:10",
                'deudor_solidario.insideNumber' => "required|max:10",
                'deudor_solidario.postalCode' => "required|max:150|min:5",
                'deudor_solidario.colony' => "required|max:150",
                'deudor_solidario.idMunicipality' => "required",
                'deudor_solidario.cityLocality' => "required",
                'deudor_solidario.idFederalEntity' => "required",
                'deudor_solidario.cellPhoneNumber' => "required|max:13|min:10",
                'deudor_solidario.phoneNumber' => "max:13|min:10",
                'deudor_solidario.email' => "required|email|max:100|min:6",
                'deudor_solidario.idType' => "required",
                'deudor_solidario.identificationNumber' => "required|max:30|min:10",
                'deudor_solidario.idIdentificationIssuer' => "required",
                'deudor_solidario.idCreditBuroScore' => "required",
                'deudor_solidario.seniorityCurrentAddressYear' => "required|max:4|min:1",
                ];

                $rules = array_merge($rules, $deudor_solidario);
        }
        
        //Si regimen fiscal id es Moral valida estas reglas
         $rules = [

        //deudor_solidario--------------------------------------------------begin
	   'deudor_solidario.idUser' => "required",
       'deudor_solidario.idParticipantsGuarantee' => "required",
    //    'deudor_solidario.businessName' => "required|max:150|min:2", 
	   'deudor_solidario.firstName' => "required|max:150|min:2",
        'deudor_solidario.lastName' => "required|max:150|min:2",
        'deudor_solidario.secondName' => "max:150|min:2",
        'deudor_solidario.secondLastName' => "max:150|min:2",
		'deudor_solidario.idGender' => "required",
		'deudor_solidario.idCivilStatus' => "required",
		'deudor_solidario.idMatrimonialRegime' => "required",
		'deudor_solidario.birthdate' => "required",
		'deudor_solidario.idCountryNationality' => "required",
		'deudor_solidario.idCountryBirth' => "required",
		'deudor_solidario.idBirthdateState' => "required",
		'deudor_solidario.rfc' => "required|max:13|min:9",
		'deudor_solidario.homoclave' => "required|max:3|min:3",
		'deudor_solidario.CURP' => "required|max:18",
		'deudor_solidario.street' => "required|max:150",
		'deudor_solidario.outsideNumber' => "required|max:150",
		'deudor_solidario.insideNumber' => "required|max:150",
		'deudor_solidario.postalCode' => "required|max:15|min:5",
		'deudor_solidario.colony' => "required|max:150",
		'deudor_solidario.idMunicipality' => "required",
		'deudor_solidario.cityLocality' => "required|max:150",
		'deudor_solidario.idFederalEntity' => "required",
        'deudor_solidario.cellPhoneNumber' => "required|max:13|min:10",
        'deudor_solidario.phoneNumber' => "required|max:13|min:10",
		'deudor_solidario.email' => "required|email|max:100|min:6",
		'deudor_solidario.idType' => "required",
		'deudor_solidario.identificationNumber' => "required|max:30|min:10",
        'deudor_solidario.idIdentificationIssuer' => "required",
        'deudor_solidario.seniorityCurrentAddressYear' => "required|max:4|min:1",
		'deudor_solidario.idCreditBuroScore' => "required",
        
        'deudor_solidario.idSolidarityDebtor' => "required",
        'deudor_solidario.sharePercentage' =>"required|max:4|min:1",
        //deudor_solidario--------------------------------------------------begin

 

       // identidad_accionistas.*------------------------------begin

           'identidad_accionistas.*.idUser' => "required",
           'identidad_accionistas.*.idParticipantsGuarantee' => "required",
           'identidad_accionistas.*.idFiscalRegime' => "required",
           'identidad_accionistas.*.businessName' => "required|max:150|min:2", 
           'identidad_accionistas.*.firstName' => "required|max:150|min:2",
           'identidad_accionistas.*.lastName' => "required|max:150|min:2",
           'identidad_accionistas.*.secondName' => "max:150|min:2",
           'identidad_accionistas.*.secondLastName' => "max:150|min:2",
           'identidad_accionistas.*.rfc' => "required|max:13|min:9",
           'identidad_accionistas.*.homoclave' => "required|max:3|min:3",
           'identidad_accionistas.*.sharePercentage' =>"required|max:4|min:1",

       // identidad_accionistas.*------------------------------end
         ];
     
       if ($this->input('deudor_solidario.idSolidarityDebtor') == 2) {
      
      
        $rules_legal = [
         
        //representante_legal---------------------------------begin
        'representante_legal.idUser' => "required",
        'representante_legal.idParticipantsGuarantee' => "required",
        'representante_legal.businessName' => "require|dmax:150|min:2", 
        'representante_legal.firstName' => "required|max:150|min:2",
        'representante_legal.lastName' => "required|max:150|min:2",
        'representante_legal.secondName' => "max:150|min:2",
        'representante_legal.secondLastName' => "max:150|min:2",
		'representante_legal.idGender' => "required",
		'representante_legal.idCivilStatus' => "required",
		'representante_legal.idMatrimonialRegime' => "required",
		'representante_legal.birthdate' => "required",
		'representante_legal.idCountryNationality' => "required",
		'representante_legal.idCountryBirth' => "required",
		'representante_legal.idBirthdateState' => "required",
		'representante_legal.rfc' => "required|max:13|min:9",
		'representante_legal.homoclave' => "required|max:3|min:3",
		'representante_legal.CURP' => "required|max:18",
		'representante_legal.street' => "required|max:150",
		'representante_legal.outsideNumber' => "required|max:10",
		'representante_legal.insideNumber' => "required|max:10",
		'representante_legal.postalCode' => "required|max:15|min:5",
		'representante_legal.colony' => "required|max:150",
		'representante_legal.idMunicipality' => "required",
		'representante_legal.cityLocality' => "required|max:150",
		'representante_legal.idFederalEntity' => "required",
        'representante_legal.cellPhoneNumber' => "required|max:13|min:10",
        'representante_legal.phoneNumber' => "max:13|min:10",
		'representante_legal.email' => "required|emailmax:100|min:6",
		'representante_legal.idType' => "required",
		'representante_legal.identificationNumber' => "required|max:30|min:10",
		'representante_legal.idIdentificationIssuer' => "required",
		'representante_legal.idCreditBuroScore' => "required",
        // 'representante_legal.seniorityCurrentAddressYear' => "required",

       //representante_legal---------------------------------end
       

        ];
        
       $rules = array_merge($rules, $rules_legal);
    }

    if ($this->input('deudor_solidario.idSolidarityDebtor') == 2) {

       //accionista_mayoritario-----------------------------begin
        
       $rules_accionista = [
       'accionista_mayoritario.idUser' => "required",
       'accionista_mayoritario.idParticipantsGuarantee' => "required",
       'accionista_mayoritario.idFiscalRegime' => "required",
       'accionista_mayoritario.idParticipantsGuarantee' => "required",
       'accionista_mayoritario.businessName' => "required|max:150|min:2", 
       'accionista_mayoritario.firstName' => "required|max:150|min:2",
       'accionista_mayoritario.lastName' => "required|max:150|min:2",
       'accionista_mayoritario.secondName' => "max:150|min:2",
       'accionista_mayoritario.secondLastName' => "max:150|min:2",
		'accionista_mayoritario.idGender' => "required",
		'accionista_mayoritario.idCivilStatus' => "required",
		'accionista_mayoritario.idMatrimonialRegime' => "required",
		'accionista_mayoritario.birthdate' => "required",
		'accionista_mayoritario.idCountryNationality' => "required",
		'accionista_mayoritario.idCountryBirth' => "required",
		'accionista_mayoritario.idBirthdateState' => "required",

        'accionista_mayoritario.idType' => "required",
        'accionista_mayoritario.identificationNumber' => "required|max:30|min:10",
        'accionista_mayoritario.idIdentificationIssuer' => "required",

        
        'accionista_mayoritario.rfc' => "required|max:13|min:9",
		'accionista_mayoritario.homoclave' => "required|max:3|min:3",
		'accionista_mayoritario.CURP' => "required|max:18",
		'accionista_mayoritario.street' => "required|max:150",
		'accionista_mayoritario.outsideNumber' => "required|max:10",
		'accionista_mayoritario.insideNumber' => "required|max:10",
		'accionista_mayoritario.postalCode' => "required|max:15|min:5",
		'accionista_mayoritario.colony' => "required|max:150",
		'accionista_mayoritario.idMunicipality' => "required",
		'accionista_mayoritario.cityLocality' => "required|max:150",
		'accionista_mayoritario.idFederalEntity' => "required",
        'accionista_mayoritario.cellPhoneNumber' => "required|max:13|min:10",
        'accionista_mayoritario.phoneNumber' => "max:13|min:10",
		'accionista_mayoritario.email' => "required|email|max:100|min:6",
        'accionista_mayoritario.seniorityCurrentAddressYear' => "required|max:4",
        'accionista_mayoritario.sharePercentage' => "required",

    ];
       // accionista_mayoritario-----------------------------end

       $rules = array_merge($rules, $rules_accionista);
    }
        
       return  $rules;
	}
}