<?php
namespace App\Http\Requests\Emprende\FlujoEfectivo;

use Joeldeval\Form\FormRequest;
use App\Http\Requests\ValidationRequest;

class SaveFlujoEfectivoRequest extends ValidationRequest
{
    public function authorize()
	{
		return true;
	}

	public function rules()
	{

		$rules = [
                
                // emp_cash_flux
                "flujo_efectivo.estimatedPercentage"=> "required|max:5",
				

				// emp_projection_premises
				"premisas_inversion.percentageSalesCredit"=> "required|max:10",
				"premisas_inversion.percentagePurchasesCredit" => "required|min:1|max:10",
				"premisas_inversion.percentageCostOverSales"=> "required",
				"premisas_inversion.percentageExpensesOnSales"=> "required",
				"premisas_inversion.expectedGrowthFirstYear"=> "required|max:10",
				"premisas_inversion.expectedGrowthSecondYear"=> "required|max:10",
				"premisas_inversion.expectedGrowthThirdYear"=> "required|max:10",
				"premisas_inversion.expectedGrowthFourthYear"=> "required|max:10",
                "premisas_inversion.netMargin" => "required|max:10",
                

                // emp_monthly_sales_percentage
                "porcentaje_mensual.january"=> "required|max:10",
                "porcentaje_mensual.february"=> "required|max:10",
                "porcentaje_mensual.march"=> "required|max:10",
                "porcentaje_mensual.april"=> "required|max:10",
                "porcentaje_mensual.may"=> "required|max:10",
                "porcentaje_mensual.june"=> "required|max:10",
                "porcentaje_mensual.july"=> "required|max:10",
                "porcentaje_mensual.august"=> "required|max:10",
                "porcentaje_mensual.september"=> "required|max:10",
                "porcentaje_mensual.october"=> "required|max:10",
                "porcentaje_mensual.november"=> "required|max:10",
                "porcentaje_mensual.december"=> "required|max:10",
                "porcentaje_mensual.year"=> "required|max:10",


                // emp_flux
                "flujo.*.periodo"=>"required",
                "flujos.*.mes.*.idMonth"=> "required",
                "flujos.*.mes.*.initialBalance"=> "",
                "flujos.*.mes.*.informationSales"=> "",
                "flujos.*.mes.*.cashSales"=> "",
                "flujos.*.mes.*.collection"=> "",
                "flujos.*.mes.*.creditFojal"=> "",
                "flujos.*.mes.*.totalIncome"=> "",
                "flujos.*.mes.*.rawMaterial"=> "",
                "flujos.*.mes.*.paymentSuppliers"=> "",
                "flujos.*.mes.*.investmentsInNonCurrentAssets"=> "",
                "flujos.*.mes.*.generalExpenses"=> "",
                "flujos.*..mes.*.serviceAndMortgageExpenses"=> "",
                "flujos.*.mes.*.taxes"=> "",
                "flujos.*.mes.*.payOtherCredits"=> "",
                "flujos.*.mes.*.paymentCreditCapitalFojal"=> "",
                "flujos.*.mes.*.financialExpenses"=> "",
                "flujos.*.mes.*.otherExpenses"=> "",
                "flujos.*.mes.*.totalExpenses"=> "",
                "flujos.*.mes.*.finalBalance"=> ""

        ];

        if ($this->input('flujo_efectivo.estimatedPercentage') > 0) {
			$flux =[
                "flujo_efectivo.describePersonalExpenses" => "required|max:2000",
			];
			$rules = array_merge($rules, $flux);
		}

		return $rules;
	}
    
}