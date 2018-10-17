<?php
namespace App\Http\Requests\Emprende\Solicitante;

use Joeldeval\Form\FormRequest;
use App\Http\Requests\ValidationRequest;

class FilesSolicitantes extends ValidationRequest
{
    public function authorize()
	{
		return true;
	}

	public function rules()
	{
		$rules = [
			"idAval"=>"",
			"idProperty"=>"",
		];
      
        return $rules;
    }

}