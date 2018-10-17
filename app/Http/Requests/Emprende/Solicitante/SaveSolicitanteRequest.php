<?php
namespace App\Http\Requests\Emprende\Solicitante;

use Joeldeval\Form\FormRequest;
use App\Http\Requests\ValidationRequest;

class SaveSolicitanteRequest extends ValidationRequest
{
    public function authorize()
	{
		return true;
	}

	public function rules()
	{
		$rules = [
			// Initial data ---------
			'initial_data.idApplicationPlace' =>'required',
			'initial_data.applicationDate',
			'initial_data.idSector' =>'required',
			'initial_data.idLinkedBeneficiary' =>'required',
			'initial_data.idTypeRequest' =>'required',

			// Initial data ---------


			// Datos solicitante----------------

			'applicant_detail.firstName' =>'required|max:150|min:2', //-----UserTable
			'applicant_detail.lastName' =>'required|max:150|min:2', //-----UserTable
			// 'applicant_detail.secondLastName' =>'|max:150|min:2', //-----UserTable
			'applicant_detail.idMatrimonialRegime' => "",  //-----UserTable
			'applicant_detail.idCivilStatus' =>'required', //-----UserTable
			'applicant_detail.birthdate' => 'required', //-----UserTable
			'applicant_detail.idGender' => 'required', //-----UserTable
			'applicant_detail.idCountryNationality' =>'required',
			'applicant_detail.idCountryBirth' =>'required',  //-----UserTable
			'applicant_detail.CURP' =>'required',  //-----UserTable
			// 'applicant_detail.CURP' => ['required', //-----UserTable
										// 'regex:/^[A-Z]{1}[AEIOU]{1}[A-Z]{2}[0-9]{2}(0[1-9]|1[0-2])(0[1-9]|1[0-9]|2[0-9]|3[0-1])[HM]{1}(AS|BC|BS|CC|CS|CH|CL|CM|DF|DG|GT|GR|HG|JC|MC|MN|MS|NT|NL|OC|PL|QT|QR|SP|SL|SR|TC|TS|TL|VZ|YN|ZS|NE)[B-DF-HJ-NP-TV-Z]{3}[0-9A-Z]{1}[0-9]{1}$/'],
			'applicant_detail.idType' => 'required',
			'applicant_detail.idIdentificationIssuer' => 'required',
			'applicant_detail.identificationNumber'=> 'required',
			'applicant_detail.rfc' => 'required|max:18', //-----UserTable
			// 'applicant_detail.rfc' => ['required', //-----UserTable
			// 						   'regex:/^([A-Z,Ñ,&]{3,4}([0-9]{2})(0[1-9]|1[0-2])(0[1-9]|1[0-9]|2[0-9]|3[0-1])[A-Z|\d]{3})+$/'],
			'applicant_detail.street'=> 'required|max:150',  //-----UserTable
			'applicant_detail.outsideNumber' =>'required|max:10',  //-----UserTabl
			'applicant_detail.insideNumber' =>'max:10', //-----UserTable
			'applicant_detail.postalCode' =>'required|max:15', //-----UserTable
			'applicant_detail.colony' =>'required|max:150',  //-----UserTable
			'applicant_detail.idMunicipality' =>'required',  //-----UserTable
			'applicant_detail.cityLocality' =>'required|max:150',  //-----UserTable
			'applicant_detail.idFederalEntity' =>'required',
			'applicant_detail.cellPhoneNumber' =>'required|max:25|min:10',
			// 'applicant_detail.phoneNumber' =>'max:15|min:10',  //-----UserTable
			'applicant_detail.email' =>'required|email|max:100|min:6',  //-----UserTable
			'applicant_detail.seniorityCurrentAddressYear' =>'required|max:2',
			'applicant_detail.idCreditBuroScore' =>'required',

			// Datos solicitante----------------

			// business_data----------------
			'datos_negocio.street' => "required|max:150",
			'datos_negocio.outsideNumber' => "required|max:10", 
			'datos_negocio.insideNumber' => "max:10", 
			'datos_negocio.postalCode' => "required|max:15", 
			'datos_negocio.colony' => "required|max:150",
			'datos_negocio.idMunicipality' => "required", 
			'datos_negocio.cityLocality' => "required|max:150",
			'datos_negocio.idFederalEntity' => "required", 
			// 'datos_negocio.phoneNumber' => "max:15|min:10", 
			'datos_negocio.cellPhoneNumber' => "required|max:25|min:10", 
			'datos_negocio.email' =>'required|email|max:100|min:6',
			'datos_negocio.activityBusiness' => "required|max:150",
			'datos_negocio.startDateOperation' => "required|max:150",
			// business_data----------------


			/// Referencias-----------------

			"reference.*.idReference" => 'required',
			'reference.*.firstName' =>'required|max:150|min:2',
			'reference.*.lastName' =>'required|max:150|min:2',
			'Reference.*.secondLastName' =>'|max:150|min:2',
			// 'reference.*.phoneNumber' =>'required|max:15|min:10',
			
			/// Referencias-----------------


			// deudor_solidario-----------------

			   'deudor_solidario.firstName' => "required|max:150|min:2",
			   'deudor_solidario.secondName' => "max:150|min:2",
			//    'deudor_solidario.secondLastName' => "max:150|min:2",
			   'deudor_solidario.rfc' => "required|max:13|min:9",
			//    'deudor_solidario.rfc' => ['required', 
			//   	'regex:/^[A-Z]{1}[AEIOU]{1}[A-Z]{2}[0-9]{2}(0[1-9]|1[0-2])(0[1-9]|1[0-9]|2[0-9]|3[0-1])[HM]{1}'],
			   'deudor_solidario.idGender' => "required",
			   'deudor_solidario.idCivilStatus' => "required",
			//    'deudor_solidario.idMatrimonialRegime' => "required",
			   'deudor_solidario.birthdate' => "required",
			   'deudor_solidario.idCountryNationality' => "required",
			   'deudor_solidario.idCountryBirth' => "required",
			   'deudor_solidario.CURP' => "required|max:18",
			//    'deudor_solidario.CURP' => ['required', 
			//'regex:/^[A-Z]{1}[AEIOU]{1}[A-Z]{2}[0-9]{2}(0[1-9]|1[0-2])(0[1-9]|1[0-9]|2[0-9]|3[0-1])[HM]{1}(AS|BC|BS|CC|CS|CH|CL|CM|DF|DG|GT|GR|HG|JC|MC|MN|MS|NT|NL|OC|PL|QT|QR|SP|SL|SR|TC|TS|TL|VZ|YN|ZS|NE)[B-DF-HJ-NP-TV-Z]{3}[0-9A-Z]{1}[0-9]{1}$/'],
			   'deudor_solidario.street' => "required|max:150",
			   'deudor_solidario.outsideNumber' => "required|max:150",
			   'deudor_solidario.insideNumber' => "max:150",
			   'deudor_solidario.postalCode' => "required|max:15|min:5",
			   'deudor_solidario.colony' => "required|max:150",
			   'deudor_solidario.idMunicipality' => "required",
			   'deudor_solidario.cityLocality' => "required|max:150",
			   'deudor_solidario.idFederalEntity' => "required",
			   'deudor_solidario.cellPhoneNumber' => "required|max:25|min:10",
			//    'deudor_solidario.phoneNumber' => "required|max:15|min:10",
			   'deudor_solidario.email' => "required|email|max:100|min:6",
			   'deudor_solidario.idType' => "required",
			   'deudor_solidario.identificationNumber' => "required",
			   'deudor_solidario.idIdentificationIssuer' => "required",
			   'deudor_solidario.idCreditBuroScore' => "required",
			   'deudor_solidario.seniorityCurrentAddressYear' => "required|max:4|min:1",
			   'deudor_solidario.preponderantEconomicActivity' => "required|max:70",
			   'deudor_solidario.idSourceIncome' => "required|max:4|min:1",

			// deudor_solidario-----------------


			// credit_data------------------

				'datos_credito.workingCapitalCredit' => "required|max:8",
				'datos_credito.equipmentCredit' => "required|max:8",
				'datos_credito.infrastructureCredit' => "required|max:8",
				'datos_credito.passivePaymentCredit' => "required|max:8",
				// 'datos_credito.termWorkingCapital' => "required|max:12",
				// 'datos_credito.termEquipment' => "required",
				// 'datos_credito.termInfrastructure' => "required",
				// 'datos_credito.termPassivePayment' => "required",
				'datos_credito.totalAmount' => "required"
		
			// credit_data------------------    

		];


		if ($this->input('reference.*.idReference') == 2 || $this->input('reference.*.idReference') == 3) {

			$rules_referencia =[
				/// Referencias-----------------
				'reference.*.businessName' =>'required|max:200|min:2',
				/// Referencias-----------------
			];
			$rules = array_merge($rules, $rules_referencia);
		}

		if ($this->input('deudor_solidario.idCivilStatus') != 2) {
			$deudor =[
			'deudor_solidario.idMatrimonialRegime' => "required",
			];
			$rules = array_merge($rules, $deudor);
		}
	

		if ($this->input('reference.*.idReference') == 1) {

			$rules_referencia_other =[
				/// Referencias-----------------
				'reference.*.idRelationshipApplicant' =>'required|max:15',
				/// Referencias-----------------
			];
			$rules = array_merge($rules, $rules_referencia_other);
		}

		if ($this->input('reference.*.idRelationshipApplicant') == 4) {

			$rules_referencia_other =[
				/// Referencias-----------------
				'reference.*.other' =>'required|max:200|min:5',
				/// Referencias-----------------
			];
			$rules = array_merge($rules, $rules_referencia_other);
		}

		return $rules;

	}

	public function message(){
        return [
			'initial_data.idApplicationPlace.required'  =>  'Ingesa un lugar de solicitud.',
			'initial_data.applicationDate.required'=>'Ingesa una fecha de la solicitud.',
			'initial_data.idSector.required'  =>  'Ingesa un sector.',
			'initial_data.idLinkedBeneficiary.required' =>'Indique si existe un beeficiario controlador.',
			'initial_data.idTypeRequest.required'  =>  'Ingesa un tipo de solicitud.',


			// Datos solicitante----------------

			'applicant_detail.idType.required' => 'Ingresa un tipo de identificación.',
			'applicant_detail.idIdentificationIssuer.required' => 'Ingresa un emisor de identificación.',
			'applicant_detail.identificationNumber.required'=> 'Ingresa un numero de identificación.',
			'applicant_detail.idFederalEntity.required'  =>  'Ingesa un estado.',
			'applicant_detail.cellPhoneNumber.required'  =>  'Ingesa un numero de celular.',
			'applicant_detail.seniorityCurrentAddressYear.required'  =>  'Ingesa la antiguedad en el domicilio en años.',
			'applicant_detail.idCreditBuroScore.required'  =>  'Ingesa un score de buro de crédito.',

			'applicant_detail.cellPhoneNumber.max' =>' el telefono celular no debe sobrepasar de 25 caracteres',
			'applicant_detail.cellPhoneNumber.min' =>' el telefono celular no debe ser menor de 10 caracteres',
			// Datos solicitante----------------

			
			// business_data----------------
			'datos_negocio.street.required'  =>  "Ingesa una calle en datos del negocio.",
			'datos_negocio.outsideNumber.required'  =>  "Ingesa un numero exterior en datos del negocio.", 
			'datos_negocio.postalCode.required'  =>  "Ingesa un codigo postal en datos del negocio.", 
			'datos_negocio.colony.required'  =>  "Ingesa una colonia en datos del negocio.",
			'datos_negocio.idMunicipality.required'  =>  "Ingesa un municipio en datos del negocio.", 
			'datos_negocio.cityLocality.required'  =>  "Ingesa una ciudad o localidad en datos del negocio.",
			'datos_negocio.idFederalEntity.required'  =>  "Ingesa un estado en datos del negocio.", 
			'datos_negocio.cellPhoneNumber.required'  =>  "Ingesa un telefono de celular en datos del negocio.", 
			'datos_negocio.email.required'  =>  'Ingesa un correo electronico en datos del negocio.',
			'datos_negocio.activityBusiness.required'  =>  "Ingesa una actividad o giro  en datos del negocio.",
			'datos_negocio.startDateOperation.required'  =>  "Ingesa una fecha de inicio de operaciones en datos del negocio.",
			// business_data----------------

			/// Referencias-----------------

			"reference.*.idReference.required"  =>  'Ingesa un tipo de referencia en referencias.',
			'reference.*.idRelationshipApplicant.required'  =>  'Ingesa un tipo de relacion co el solicitante en referencias.',
			'reference.*.firstName.required'  =>  'Ingesa el nombre completo en referencias.',
			'reference.*.lastName.required'  =>  'Ingesa un apellido paterno en referencias.',
			// 'reference.*.phoneNumber.required'  =>  'Ingesa un número de telefono en referencias.',
			'reference.*.other.required' =>'llena el campo otro en referencias.',
			'reference.*.businessName.required'  =>  'Ingesa una razón social en referencias.',
			/// Referencias-----------------


			
			// deudor_solidario-----------------

			'deudor_solidario.firstName.required'  =>  "Ingesa el nombre completo en deudor solidario",
			'deudor_solidario.lastName.required'  =>  "Ingesa el apellido paterno en deudor solidario",
			// 'deudor_solidario.secondLastName.required'  =>  "Ingesa el apellido materno en deudor solidario",
			'deudor_solidario.rfc.required'  =>  "Ingesa un RFC en deudor solidario",
			// 'deudor_solidario.rfc.regex' => 'El RFC no es válido',	
			'deudor_solidario.idGender.required'  =>  "Ingesa un genero en deudor solidario",
			'deudor_solidario.idCivilStatus.required'  =>  "Ingesa el estado civil en deudor solidario.",
			'deudor_solidario.idMatrimonialRegime.required'  =>  "Ingesa el regimen matrimonial en deudor solidario.",
			'deudor_solidario.birthdate.required'  =>  "Ingesa una fecha de nacimiento en deudor solidario.",
			'deudor_solidario.idCountryNationality.required'  =>  "Ingesa un pais de nacionalidad en deudor solidario.",
			'deudor_solidario.idCountryBirth.required'  =>  "Ingesa un pais de nacimiento en deudor solidario.",
			'deudor_solidario.CURP.required'  =>  "Ingesa una CURP en deudor solidario.",
			// 'deudor_solidario.CURP.regex' => 'El CURP no es válido',
			'deudor_solidario.street.required'  =>  "Ingesa una calle en deudor solidario.",
			'deudor_solidario.outsideNumber.required'  =>  "Ingesa un numero exterior en deudor solidario.",
			'deudor_solidario.insideNumber.required'  =>  "Ingesa un numero interiror en deudor solidario.",
			'deudor_solidario.postalCode.required'  =>  "Ingesa un código postal en deudor solidario.",
			'deudor_solidario.colony.required'  =>  "Ingesa una colonia en deudor solidario.",
			'deudor_solidario.idMunicipality.required'  =>  "Ingesa un municipio en deudor solidario.",
			'deudor_solidario.cityLocality.required'  =>  "Ingesa una ciudad o localidad en deudor solidario.",
			'deudor_solidario.idFederalEntity.required'  =>  "Ingesa un estado en deudor solidario.",
			'deudor_solidario.cellPhoneNumber.required'  =>  "Ingesa un numero de telefono celular en deudor solidario.",
			// 'deudor_solidario.phoneNumber.required'  =>  "Ingesa un numero de telefono en deudor solidario.",
			'deudor_solidario.email.required'  =>  "Ingesa un correo electronico en deudor solidario.",
			'deudor_solidario.idType.required'  =>  "Ingesa un tipo de identificación en deudor solidario.",
			'deudor_solidario.identificationNumber.required'  =>  "Ingesa un numero de identificación en deudor solidario.",
			'deudor_solidario.idIdentificationIssuer.required'  =>  "Ingesa un emisor de identificación en deudor solidario.",
			'deudor_solidario.idCreditBuroScore.required'  =>  "Ingesa un escore de buro de crédito en deudor solidario.",
			'deudor_solidario.seniorityCurrentAddressYear.required'  =>  "Ingesa la antoguedad en el domicilio en deudor solidario.",
			'deudor_solidario.preponderantEconomicActivity.required'  =>  "Ingesa una actividad economica preponderante en deudor solidario.",
			'deudor_solidario.idSourceIncome.required'  =>  "Ingesa una fuente de ingreso en deudor solidario.",

		 // deudor_solidario----------------


		// credit_data------------------

			'datos_credito.workingCapitalCredit.required'  =>  "Ingesa una cantidad en credito solicitado en datos de credito.",
			'datos_credito.equipmentCredit.required'  =>  "Ingesa una cantidad de equipamiento en datos de credito.",
			'datos_credito.infrastructureCredit.required'  =>  "Ingesa una cantidad de infraestructura en datos de credito.",
			'datos_credito.passivePaymentCredit.required'  =>  "Ingesa una cantidad de pago de pasivos en datos de credito.",
			'datos_credito.termWorkingCapital.required'  =>  "Ingesa una cantidad de capital de trabajo en datos de credito.",
			'datos_credito.termEquipment.required'  =>  "Ingesa un pazo equipamiento en datos de credito.",
			'datos_credito.termInfrastructure.required'  =>  "Ingesa un pazo equipamiento en datos de credito.",
			'datos_credito.termPassivePayment.required'  =>  "Ingesa un pazo infraestructura en datos de credito.",
			'datos_credito.totalAmount.required'  =>  "Ingesa un total en datos de credito."
		
			// credit_data------------------   
		];
    }
}