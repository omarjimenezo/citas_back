<?php
namespace App\Http\Requests\Academia\FinalTest;

use App\Http\Requests\ValidationRequest;

/**
 * Class InitialTestRequest.
 */
class FinalTestRequest extends ValidationRequest
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
			'idCourse' => 'required',
			'lstAnswers' => 'required'
		];

	}

	/**
     * Get custom messages for validator errors.
     *
     * @return array
     */
	public function messages(){

        return [
			'idCourse.required' => 'Ingresa un idCourse',
			'lstAnswers' => 'Igresa una lista de respuestas'		
		];
    }
}