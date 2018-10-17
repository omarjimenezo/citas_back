<?php
namespace App\Http\Requests\Emprende\Garantia;

use Joeldeval\Form\FormRequest;
use App\Http\Requests\ValidationRequest;

class SaveWarrantyRequest extends ValidationRequest
{
    public function authorize()
	{
		return true;
	}

	public function rules()
	{

	return	$rules = [
			
			// Warranty
			"warranty.idPropertyPhysicalPerson"=> "required",
			"warranty.idNumberPropertiesReceive"=> "required",

		];

	}

	public function message(){
        return [
			'warranty.idPropertyPhysicalPerson.required'  =>  'Debe definir si es persona fisica o no..',
			'warranty.idNumberPropertiesReceive.required'=>'Ingesa un numero de prediales.',
		];
	}
    
}