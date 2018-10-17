<?php
namespace App\Http\Requests\Emprende\Garantia;

use Joeldeval\Form\FormRequest;
use App\Http\Requests\ValidationRequest;

class UpdatePropertyRepresentRequest extends ValidationRequest
{
    public function authorize()
	{
		return true;
	}

	public function rules()
	{

		$rules = [
				//Aval recibo predial

				"recibo_predial.id" => "required",
				"recibo_predial.propertyAccountNumber"=> "required|min:1|max:40",
				"recibo_predial.idKindProperty"=> "required",
				"recibo_predial.description"=> "required|min:2|max:500",
				"recibo_predial.location"=> "required|min:2|max:500",
				"recibo_predial.fiscalValue"=> "required|min:1|max:20",
				"recibo_predial.numberOwners"=> "required|min:1|max:2",


				//Aval Datos de avales
				"representante_legal.id" => "required",
				"representante_legal.firstName"=> "required|min:2|max:150",
				"representante_legal.lastName"=> "required|min:2|max:70",
				"representante_legal.secondLastName"=> "min:2|max:70",
				"representante_legal.rfc"=> "required|max:13|min:13",
				"representante_legal.idGender"=> "required",
				"representante_legal.idCivilStatus"=> "required",
				"representante_legal.idMatrimonialRegime"=> "required",
				"representante_legal.birthdate"=> "required",
				"representante_legal.idCountryNationality"=> "required",
				"representante_legal.idCountryBirth"=> "required",
				"representante_legal.CURP"=> "required|min:18|max:18",
				"representante_legal.street"=> "required|min:2|max:150",
				"representante_legal.outsideNumber"=> "required|min:2|max:10",
				"representante_legal.insideNumber"=> "required|min:2|max:10",
				"representante_legal.postalCode"=> "required|min:5|max:5",
				"representante_legal.colony"=> "required|min:2|max:150",
				"representante_legal.idMunicipality"=> "required",
				"representante_legal.idFederalEntity"=> "required",
				"representante_legal.cityLocality"=> "required",
				"representante_legal.phoneNumber"=> "|min:2|max:15",
				"representante_legal.cellPhoneNumber"=> "required|min:2|max:15",
				"representante_legal.email"=> "required|min:6|max:100|email",
				"representante_legal.idType"=> "required",
				"representante_legal.identificationNumber"=> "required|min:10|max:50",
				"representante_legal.idIdentificationIssuer"=> "required",
				"representante_legal.idCreditBuroScore"=> "required",
				"representante_legal.idRelationshipApplicant"=> "required",
				"representante_legal.preponderantEconomicActivity"=> "required|min:10|max:50",
				"representante_legal.idCreditBuroScore"=> "required",
		];

		if ($this->input('representante_legal.idRelationshipApplicant') == 4) {

			$rules_referencia_other =[
				
				'representante_legal.other' =>'required|max:200|min:5',
				
			];
			$rules = array_merge($rules, $rules_referencia_other);
		}

		if ($this->input('recibo_predial.idKindProperty') == 5) {
			$indice_rule = [
				"recibo_predial.indicateTypeProperty"=> "required|min:1|max:200"
			];
			$rules = array_merge($rules, $indice_rule);
		 }

		return $rules;
	}
}