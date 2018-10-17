<?php
namespace App\Http\Requests\Emprende\Garantia;

use Joeldeval\Form\FormRequest;
use App\Http\Requests\ValidationRequest;

class UpdatePropertyRequest extends ValidationRequest
{
    public function authorize()
	{
		return true;
	}

	public function rules()
	{

	return	$rules = [
				//Aval recibo predial
				"recibo_predial.id"=> "required",
				"recibo_predial.propertyAccountNumber"=> "required|min:1|max:40",
				"recibo_predial.idKindProperty"=> "required",
				"recibo_predial.description"=> "required|min:2|max:500",
				"recibo_predial.location"=> "required|min:2|max:500",
				"recibo_predial.fiscalValue"=> "required|min:1|max:20",
				"recibo_predial.numberOwners"=> "required|min:1|max:2"
		];

	}
}