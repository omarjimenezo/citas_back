<?php
namespace App\Http\Requests\Emprende\Garantia;

use Joeldeval\Form\FormRequest;
use App\Http\Requests\ValidationRequest;

class SaveAvalRequest extends ValidationRequest
{
    public function authorize()
	{
		return true;
	}

	public function rules()
	{

		$rules = [
			
			//Aval Datos de avales
			"datos_avales.idProperty"=> "required",
			"datos_avales.firstName"=> "required|min:2|max:150",
			"datos_avales.lastName"=> "required|min:2|max:70",
			"datos_avales.secondLastName"=> "min:2|max:70",
			"datos_avales.rfc"=> "required|max:13|min:13",
			"datos_avales.idGender"=> "required",
			"datos_avales.idCivilStatus"=> "required",
			"datos_avales.idMatrimonialRegime"=> "required",
			"datos_avales.birthdate"=> "required",
			"datos_avales.idCountryNationality"=> "required",
			"datos_avales.idCountryBirth"=> "required",
			"datos_avales.CURP"=> "required|min:18|max:18",
			"datos_avales.street"=> "required|min:2|max:150",
			"datos_avales.outsideNumber"=> "required|min:2|max:10",
			"datos_avales.insideNumber"=> "required|min:2|max:10",
			"datos_avales.postalCode"=> "required|min:5|max:5",
			"datos_avales.colony"=> "required|min:2|max:150",
			"datos_avales.idMunicipality"=> "required",
			"datos_avales.idFederalEntity"=> "required",
			"datos_avales.cityLocality"=> "required",
			"datos_avales.phoneNumber"=> "|min:2|max:15",
			"datos_avales.cellPhoneNumber"=> "required|min:2|max:15",
			"datos_avales.email"=> "required|min:6|max:100|email",
			"datos_avales.idType"=> "required",
			"datos_avales.identificationNumber"=> "required|min:10|max:50",
			"datos_avales.idIdentificationIssuer"=> "required",
			"datos_avales.idCreditBuroScore"=> "required",
			"datos_avales.idRelationshipApplicant"=> "required",
			"datos_avales.preponderantEconomicActivity"=> "required|min:10|max:50",
			"datos_avales.idCreditBuroScore"=> "required",

		];

		if ($this->input('datos_avales.idRelationshipApplicant') == 4) {

			$rules_referencia_other =[
				/// -----------------
				'datos_avales.other' =>'required|max:200|min:5',
				/// -----------------
			];
			$rules = array_merge($rules, $rules_referencia_other);
		}

		return $rules;
	}
    
}