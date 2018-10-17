<?php
namespace App\Http\Requests\Emprende\Garantia;

use Joeldeval\Form\FormRequest;
use App\Http\Requests\ValidationRequest;

class SavePropertyRequest extends ValidationRequest
{
    public function authorize()
	{
		return true;
	}

	public function rules()
	{

		$rules = [
				//Aval recibo predial
				"recibo_predial.idWarranty"=> "required",
				"recibo_predial.propertyAccountNumber"=> "required|min:1|max:40",
				"recibo_predial.idKindProperty"=> "required",
				"recibo_predial.description"=> "required|min:2|max:500",
				"recibo_predial.location"=> "required|min:2|max:500",
				"recibo_predial.fiscalValue"=> "required|min:1|max:20",
				"recibo_predial.numberOwners"=> "required|min:1|max:2"
		];

		if ($this->input('recibo_predial.idKindProperty') == 5) {
			$indice_rule = [
				"recibo_predial.indicateTypeProperty"=> "required|min:1|max:200"
			];
			$rules = array_merge($rules, $indice_rule);
		 }

		return $rules;
	}
}