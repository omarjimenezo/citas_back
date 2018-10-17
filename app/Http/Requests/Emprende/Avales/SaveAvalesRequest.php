<?php
namespace App\Http\Requests\Emprende\Avales;

use Joeldeval\Form\FormRequest;
use App\Http\Requests\ValidationRequest;

class SaveAvalesRequest extends ValidationRequest
{
    public function authorize()
	{
		return true;
	}

	public function rules()
	{

		$rules = [
                '*idUser' => "required",
                '*idParticipantsGuarantee' => "required",
                '*firstName' => "required|max:150",
                '*lastName' => "required|max:150|min:2",
                '*secondName' => "required|max:150",
                '*secondLastName' => "required|max:150|min:2",
                '*idGender' => "required",
                '*idCivilStatus' => "required",
                '*idMatrimonialRegime' => "required",
                '*birthdate' => "required",
                '*idCountryNationality' => "required",
                '*idCountryBirth' => "required",
                '*idBirthdateState' => "required",
                '*rfc' => "required|max:13|min:12",
                '*homoclave' => "required|min:3",
                '*CURP' => "required|max:18",
                '*street' => "required|max:150",
                '*outsideNumber' => "required|max:10",
                '*insideNumber' => "required|max:10",
                '*postalCode' => "required|max:15|min:5",
                '*colony' => "required|max:150",
                '*idMunicipality' => "required",
                '*cityLocality' => "required|max:150",
                '*idFederalEntity' => "required",
                '*cellPhoneNumber' => "required|max:13|min:10",
                '*phoneNumber' => "required|max:13|min:10",
                '*email' => "required|email|max:100|min:6",
                '*idType' => "required",
                '*identificationNumber' => "required|max:30|min:10",
                '*idIdentificationIssuer' => "required",
                '*idRelationship' => "required",
                '*preponderantEconomicActivity' => "required|max:50|min:10",
                '*idCreditBuroScore' => "required",
        
        ];
		return $rules;
    }
}