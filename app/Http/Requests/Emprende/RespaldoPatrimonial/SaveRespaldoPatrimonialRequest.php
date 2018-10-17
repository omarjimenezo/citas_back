<?php
namespace App\Http\Requests\Emprende\RespaldoPatrimonial;

use Joeldeval\Form\FormRequest;
use App\Http\Requests\ValidationRequest;

class SaveRespaldoPatrimonialRequest extends ValidationRequest
{
    public function authorize()
	{
		return true;
	}

	public function rules()
	{

		$rules = [
            "patrimonial_support.*.proposedGuarantee" =>'required|max:150|min:2',
            "patrimonial_support.*.nameGuarantee" =>'required',
            "patrimonial_support.*.typeEconomicSupport" =>'required|max:150|min:2',
            "patrimonial_support.*.totalValueProperty" =>'required',

            "property_capture.*.idProperty" =>'required',
            "property_capture.*.other" =>'required',
            "property_capture.*.description" =>'required',
            "property_capture.*.location" =>'required',
            "property_capture.*.propertySheet" =>'required',
            "property_capture.*.propertyTaxValue" =>'required'
        ];
		return $rules;
    }
}