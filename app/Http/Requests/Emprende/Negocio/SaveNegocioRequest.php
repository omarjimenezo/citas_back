<?php
namespace App\Http\Requests\Emprende\Negocio;

use Joeldeval\Form\FormRequest;
use App\Http\Requests\ValidationRequest;

class SaveNegocioRequest extends ValidationRequest
{
    public function authorize()
	{
		return true;
	}

	public function rules()
	{

		$rules = [
        
        //emp_business_data----------------
        'datos_negocio.idUser' => "required",
        'datos_negocio.activityBusiness' => "required|max:13", 
        'datos_negocio.idTypeLocal' => "required", 
        'datos_negocio.startDateOperation' => "required", 
        'datos_negocio.idProductType' => "required", 
        'datos_negocio.portfolioNumberClient' => "required|max:50", 
        'datos_negocio.salesInCustomer' => "required|max:50", 

        'datos_negocio.wholesaler' => "required|max:4", 
        'datos_negocio.retailer' => "required|max:4", 
        'datos_negocio.business' => "required|max:4", 
        'datos_negocio.generalPublic' => "required|max:4", 
        'datos_negocio.totalPercentageClients' => "required", 
        'datos_negocio.creditClient' => "required", 
        'datos_negocio.numberDay' => "required|max:20", 
        'datos_negocio.toThe' => "required|max:4", 
        'datos_negocio.andNumberDay' => "required|max:20", 
        'datos_negocio.andToThe' => "required|max:4",

        'datos_negocio.local' => "required|max:4", 
        'datos_negocio.state' => "required|max:4",
        'datos_negocio.regional' => "required|max:4", 
        'datos_negocio.national' => "required|max:4", 
        'datos_negocio.fromExportation' => "required", 
		'datos_negocio.other' => "max:4", 
		'datos_negocio.sumPercentage' => "required",
		//emp_business_data----------------
		

		 //emp_credit_data------------------
		 'datos_credito.workingCapitalCredit' => "required|max:8",
		 'datos_credito.equipmentCredit' => "required|max:8",
		 'datos_credito.infrastructureCredit' => "required|max:8",
		 'datos_credito.passivePaymentCredit' => "required|max:8",
		 'datos_credito.termWorkingCapital' => "required|max:12",
		 'datos_credito.termEquipment' => "required",
		 'datos_credito.termInfrastructure' => "required",
		 'datos_credito.termPassivePayment' => "required",
		 'datos_credito.totalAmount' => "required"
 
		 //emp_credit_data------------------    
		];

		if ($this->input('idFiscalRegimeGeneral') == 1) {

		$rule_fisica =[
			//emp_business_data----------------
			'datos_negocio.street' => "required|max:150",
			'datos_negocio.outsideNumber' => "required|max:10", 
			'datos_negocio.insideNumber' => "required|max:10", 
			'datos_negocio.postalCode' => "required|max:15", 
			'datos_negocio.colony' => "required|max:150",
			'datos_negocio.idMunicipality' => "required", 
			'datos_negocio.cityLocality' => "required|max:150",
			'datos_negocio.idFederalEntity' => "required", 
			'datos_negocio.phoneNumber' => "max:13", 
			'datos_negocio.cellPhoneNumber' => "required|max:13", 
			//emp_business_data----------------
			];
			return array_merge($rules, $rule_fisica);
		}
		return $rules;
    }
}