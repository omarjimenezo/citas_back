<?php
namespace App\Http\Requests\Emprende\Garantia;

use Joeldeval\Form\FormRequest;
use App\Http\Requests\ValidationRequest;

class SaveGarantiaRequest extends ValidationRequest
{
    public function authorize()
	{
		return true;
	}

	public function rules()
	{

		$rules = [
			
			// Warranty
            "warranty.idPropertyPhysicalPerson"=> "required",

		];

		if ($this->input("warranty.idPropertyPhysicalPerson")== 1) {

			$rules_fisica = [

			// Warranty
			"warranty.idNumberPropertiesReceive"=> "required",

			//Aval recibo predial
			"aval.*.recibo_predial.propertyAccountNumber"=> "required|min:1|max:40",
			"aval.*.recibo_predial.idKindProperty"=> "required",
			"aval.*.recibo_predial.description"=> "required|min:2|max:500",
			"aval.*.recibo_predial.location"=> "required|min:2|max:500",
			"aval.*.recibo_predial.fiscalValue"=> "required|min:1|max:20",
			"aval.*.recibo_predial.numberOwners"=> "required|min:1|max:2",
			

			//Aval Datos de avales
			"aval.datos_avales.*.firstName"=> "required|min:2|max:150",
			"aval.datos_avales.*.lastName"=> "required|min:2|max:70",
			"aval.datos_avales.*.secondLastName"=> "min:2|max:70",
			"aval.datos_avales.*.rfc"=> "required|max:13|min:13",
			"aval.datos_avales.*.idGender"=> "required",
			"aval.datos_avales.*.idCivilStatus"=> "required",
			"aval.datos_avales.*.idMatrimonialRegime"=> "required",
			"aval.datos_avales.*.birthdate"=> "required",
			"aval.datos_avales.*.idCountryNationality"=> "required",
			"aval.datos_avales.*.idCountryBirth"=> "required",
			"aval.datos_avales.*.CURP"=> "required|min:18|max:18",
			"aval.datos_avales.*.street"=> "required|min:2|max:150",
			"aval.datos_avales.*.outsideNumber"=> "required|min:2|max:10",
			"aval.datos_avales.*.insideNumber"=> "min:2|max:10",
			"aval.datos_avales.*.postalCode"=> "required|min:5|max:5",
			"aval.datos_avales.*.colony"=> "required|min:2|max:150",
			"aval.datos_avales.*.idMunicipality"=> "required",
			"aval.datos_avales.*.idFederalEntity"=> "required",
			"aval.datos_avales.*.cityLocality"=> "required",
			"aval.datos_avales.*.phoneNumber"=> "|min:2|max:15",
			"aval.datos_avales.*.cellPhoneNumber"=> "required|min:2|max:15",
			"aval.datos_avales.*.email"=> "required|min:6|max:100|email",
			"aval.datos_avales.*.idType"=> "required",
			"aval.datos_avales.*.identificationNumber"=> "required|min:10|max:50",
			"aval.datos_avales.*.idIdentificationIssuer"=> "required",
			"aval.datos_avales.*.idCreditBuroScore"=> "required",
			"aval.datos_avales.*.relationshipApplicant"=> "required",
			"aval.datos_avales.*.preponderantEconomicActivity"=> "required|min:10|max:50",
			"aval.datos_avales.*.idCreditBuroScore"=> "required",

			];
			$rules = array_merge($rules, $rules_fisica);

		}

		if ($this->input("warranty.idPropertyPhysicalPerson") == 2) {
			
			$rules_no_fisica = [

				//Aval recibo predial
			"aval.*.recibo_predial.propertyAccountNumber"=> "required|min:1|max:40",
			"aval.*.recibo_predial.idKindProperty"=> "required",
			"aval.*.recibo_predial.description"=> "required|min:2|max:500",
			"aval.*.recibo_predial.location"=> "required|min:2|max:500",
			"aval.*.recibo_predial.fiscalValue"=> "required|min:1|max:20",
			"aval.*.recibo_predial.numberOwners"=> "required|min:1|max:2",


			//datos avales
			"aval.datos_avales.*.businessName" => "required|min:2|max:70 ",
			"aval.datos_avales.*.birthdate"=> "required",
			"aval.datos_avales.*.idCountryNationality"=> "required",
			"aval.datos_avales.*.rfc"=> "required|min:13|max:13",
			"aval.datos_avales.*.street"=> "required|min:2|max:150",
			"aval.datos_avales.*.outsideNumber"=> "required|min:2|max:10",
			"aval.datos_avales.*.insideNumber"=> "min:2|max:10",
			"aval.datos_avales.*.postalCode"=> "required|min:5|max:5",
			"aval.datos_avales.*.colony"=> "required|min:2|max:150",
			"aval.datos_avales.*.idMunicipality"=> "required",
			"aval.datos_avales.*.idFederalEntity"=> "required",
			"aval.datos_avales.*.cityLocality"=> "required",
			"aval.datos_avales.*.phoneNumber"=> "|min:2|max:15",
			"aval.datos_avales.*.cellPhoneNumber"=> "required|min:2|max:15",
			"aval.datos_avales.*.email"=> "required|min:6|max:100|email",
			"aval.datos_avales.*.preponderantEconomicActivity"=> "required|min:10|max:50",
			"aval.datos_avales.*.idCreditBuroScore"=> "required",


			//Representante legal
			"aval.representante_legal.*.rfc"=> "required|min:13|max:13",
			"aval.representante_legal.*.idGender"=> "required",
			"aval.representante_legal.*.idCivilStatus"=> "required",
			"aval.representante_legal.*.idMatrimonialRegime"=> "required",
			"aval.representante_legal.*.birthdate"=> "required",
			"aval.representante_legal.*.idCountryNationality"=> "required",
			"aval.representante_legal.*.idCountryBirth"=> "required",
			// "aval.*.representante_legal.CURP"=> "required|min:10|max:10",
			"aval.representante_legal.*.street"=> "required|min:2|max:150",
			"aval.representante_legal.*.outsideNumber"=> "required|min:2|max:10",
			"aval.representante_legal.*.insideNumber"=> "min:2|max:10",
			"aval.representante_legal.*.postalCode"=> "required|min:5|max:5",
			"aval.representante_legal.*.colony"=> "required|min:2|max:150",
			"aval.representante_legal.*.idMunicipality"=> "required",
			"aval.representante_legal.*.idFederalEntity"=> "required",
			"aval.representante_legal.*.phoneNumber"=> "required",
			"aval.representante_legal.*.cellPhoneNumber"=> "required",
			"aval.representante_legal.*.email"=> "required",
			"aval.representante_legal.*.idType"=> "required",
			"aval.representante_legal.*.idIdentificationIssuer"=> "required",
			"aval.representante_legal.*.relationshipApplicant"=> "required",
			"aval.representante_legal.*.preponderantEconomicActivity"=> "required|min:10|max:150",
			// "aval.*.representante_legal.idCreditBuroScore"=> "required",

			];
			$rules = array_merge($rules, $rules_no_fisica);

	}

		if ($this->input('aval.datos_avales.*.idRelationshipApplicant') == 4) {

			$rules_referencia_other =[
				/// -----------------
				'aval.datos_avales.*.other' =>'required|max:200|min:5',
				/// -----------------
			];
			$rules = array_merge($rules, $rules_referencia_other);
		}
		if ($this->input('aval.representante_legal.idRelationshipApplicant') == 4) {

			$rules_referencia_other =[
				
				'aval.representante_legal.other' =>'required|max:200|min:5',
				
			];
			$rules = array_merge($rules, $rules_referencia_other);
		}

		if ($this->input('aval.*.recibo_predial.idKindProperty') == 5) {
				$indice_rule = [
					"aval.*.recibo_predial.indicateTypeProperty"=> "required|min:1|max:200"
				];
				$rules = array_merge($rules, $indice_rule);
		}
		return $rules;
	}
    
}