<?php
namespace App\Http\Requests\Emprende\EstadoResultados;

use Joeldeval\Form\FormRequest;
use App\Http\Requests\ValidationRequest;

class SaveEstadoResultadosRequest extends ValidationRequest
{
    public function authorize()
	{
		return true;
	}

	public function rules()
	{
		$rules = [

            // Estado de resultados ----------------
            'status_results.dateFinancialInformation'   => 'required',
            // Estado de resultados----------------
            
            // Costo de utilidades ----------------
            'sale_cost_utility_expense.*.monthlySales'                  => 'required|min:1|max:10',
            'sale_cost_utility_expense.*.merchandiseRawMaterial'        => 'required|min:1|max:10',
            'sale_cost_utility_expense.*.wagesSalaries'                 => 'required|min:1|max:10',
            'sale_cost_utility_expense.*.rentalPremises'                => 'required|min:1|max:10',
            'sale_cost_utility_expense.*.stationeryVarious'             => 'required|min:1|max:10',
            'sale_cost_utility_expense.*.phone'                         => 'required|min:1|max:10',
            'sale_cost_utility_expense.*.otherAdministrationExpenses'   => 'required|min:1|max:10',
            'sale_cost_utility_expense.*.gasolineLubricants'            => 'required|min:1|max:10',
            'sale_cost_utility_expense.*.maintenance'                   => 'required|min:1|max:10',
            'sale_cost_utility_expense.*.otherOperatingExpenses'        => 'required|min:1|max:10',
            'sale_cost_utility_expense.*.netInterests'                  => 'required|min:1|max:10',
            'sale_cost_utility_expense.*.ISR'                           => 'required|min:1|max:10',
            'sale_cost_utility_expense.*.percentage1'                   => 'required',
            'sale_cost_utility_expense.*.percentage2'                   => 'required',
            'sale_cost_utility_expense.*.percentage3'                   => 'required',
            'sale_cost_utility_expense.*.percentage4'                   => 'required',
            'sale_cost_utility_expense.*.percentage5'                   => 'required',
            'sale_cost_utility_expense.*.percentage6'                   => 'required',
            'sale_cost_utility_expense.*.percentage7'                   => 'required',
            'sale_cost_utility_expense.*.percentage8'                   => 'required',
            'sale_cost_utility_expense.*.percentage9'                   => 'required',
            'sale_cost_utility_expense.*.percentage10'                  => 'required',
            'sale_cost_utility_expense.*.percentage11'                  => 'required',
            'sale_cost_utility_expense.*.percentage12'                  => 'required',
            'sale_cost_utility_expense.*.percentage13'                  => 'required',
            'sale_cost_utility_expense.*.percentage14'                  => 'required',
            'sale_cost_utility_expense.*.totalCostsExpenses'            => 'required',
            'sale_cost_utility_expense.*.utility'                       => 'required',
            // Costo de utilidades ----------------
			
		];

		return $rules;

	}

	public function message(){
        return [

            // Estado de resultados ----------------
            'status_results.dateFinancialInformation.required'   => 'Ingesa la fecha de curso.',
            // Estado de resultados----------------

            // Costo de utilidades ----------------
            'sale_cost_utility_expense.*.percentage1.required'                   => 'Ingesa el campo porcentaje 1',
            'sale_cost_utility_expense.*.percentage2.required'                   => 'Ingesa el campo porcentaje 2',
            'sale_cost_utility_expense.*.percentage3.required'                   => 'Ingesa el campo porcentaje 3',
            'sale_cost_utility_expense.*.percentage4.required'                   => 'Ingesa el campo porcentaje 4',
            'sale_cost_utility_expense.*.percentage5.required'                   => 'Ingesa el campo porcentaje 5',
            'sale_cost_utility_expense.*.percentage6.required'                   => 'Ingesa el campo porcentaje 6',
            'sale_cost_utility_expense.*.percentage7.required'                   => 'Ingesa el campo porcentaje 7',
            'sale_cost_utility_expense.*.percentage8.required'                   => 'Ingesa el campo porcentaje 8',
            'sale_cost_utility_expense.*.percentage9.required'                   => 'Ingesa el campo porcentaje 9',
            'sale_cost_utility_expense.*.percentage10.required'                  => 'Ingesa el campo porcentaje 10',
            'sale_cost_utility_expense.*.percentage11.required'                  => 'Ingesa el campo porcentaje 11',
            'sale_cost_utility_expense.*.percentage12.required'                  => 'Ingesa el campo porcentaje 12',
            'sale_cost_utility_expense.*.percentage13.required'                  => 'Ingesa el campo porcentaje 13',
            'sale_cost_utility_expense.*.percentage14.required'                  => 'Ingesa el campo porcentaje 14',
            'sale_cost_utility_expense.*.monthlySales.required'                  => 'Ingesa el campo monthlySaless',
            'sale_cost_utility_expense.*.merchandiseRawMaterial.required'        => 'Ingesa el campo merchandiseRawMaterial',
            'sale_cost_utility_expense.*.wagesSalaries.required'                 => 'Ingesa el campo wagesSalaries',
            'sale_cost_utility_expense.*.rentalPremises.required'                => 'Ingesa el campo rentalPremises ',
            'sale_cost_utility_expense.*.stationeryVarious.required'             => 'Ingesa el campo stationeryVarious ',
            'sale_cost_utility_expense.*.phone.required'                         => 'Ingesa el campo phone ',
            'sale_cost_utility_expense.*.otherAdministrationExpenses.required'   => 'Ingesa el campo otherAdministrationExpenses ',
            'sale_cost_utility_expense.*.gasolineLubricants.required'            => 'Ingesa el campo gasolineLubricants ',
            'sale_cost_utility_expense.*.maintenance.required'                   => 'Ingesa el campo maintenance ',
            'sale_cost_utility_expense.*.otherOperatingExpenses.required'        => 'Ingesa el campo otherOperatingExpenses ',
            'sale_cost_utility_expense.*.netInterests.required'                  => 'Ingesa el campo netInterests ',
            'sale_cost_utility_expense.*.ISR.required'                           => 'Ingesa el campo ISR ',
            'sale_cost_utility_expense.*.totalCostsExpenses.required'            => 'Ingesa el campo totalCostsExpenses ',
            'sale_cost_utility_expense.*.utility.required'                       => 'Ingesa el campo utility ',

            'sale_cost_utility_expense.*.monthlySales.min'                  => 'el nombre no debe ser menor de 1 caracteres',
            'sale_cost_utility_expense.*.merchandiseRawMaterial.min'        => 'el nombre no debe ser menor de 1 caracteres',
            'sale_cost_utility_expense.*.wagesSalaries.min'                 => 'el nombre no debe ser menor de 1 caracteres',
            'sale_cost_utility_expense.*.rentalPremises.min'                => 'el nombre no debe ser menor de 1 caracteres',
            'sale_cost_utility_expense.*.stationeryVarious.min'             => 'el nombre no debe ser menor de 1 caracteres',
            'sale_cost_utility_expense.*.phone.min'                         => 'el nombre no debe ser menor de 1 caracteres',
            'sale_cost_utility_expense.*.otherAdministrationExpenses.min'   => 'el nombre no debe ser menor de 1 caracteres',
            'sale_cost_utility_expense.*.gasolineLubricants.min'            => 'el nombre no debe ser menor de 1 caracteres',
            'sale_cost_utility_expense.*.maintenance.min'                   => 'el nombre no debe ser menor de 1 caracteres',
            'sale_cost_utility_expense.*.otherOperatingExpenses.min'        => 'el nombre no debe ser menor de 1 caracteres',
            'sale_cost_utility_expense.*.netInterests.min'                  => 'el nombre no debe ser menor de 1 caracteres',
            'sale_cost_utility_expense.*.ISR.min'                           => 'el nombre no debe ser menor de 1 caracteres',

            'sale_cost_utility_expense.*.monthlySales.max'                  => 'el nombre no debe sobrepasar de 10 caracteres',
            'sale_cost_utility_expense.*.merchandiseRawMaterial.max'        => 'el nombre no debe sobrepasar de 10 caracteres',
            'sale_cost_utility_expense.*.wagesSalaries.max'                 => 'el nombre no debe sobrepasar de 10 caracteres',
            'sale_cost_utility_expense.*.rentalPremises.max'                => 'el nombre no debe sobrepasar de 10 caracteres',
            'sale_cost_utility_expense.*.stationeryVarious.max'             => 'el nombre no debe sobrepasar de 10 caracteres',
            'sale_cost_utility_expense.*.phone.max'                         => 'el nombre no debe sobrepasar de 10 caracteres',
            'sale_cost_utility_expense.*.otherAdministrationExpenses.max'   => 'el nombre no debe sobrepasar de 10 caracteres',
            'sale_cost_utility_expense.*.gasolineLubricants.max'            => 'el nombre no debe sobrepasar de 10 caracteres',
            'sale_cost_utility_expense.*.maintenance.max'                   => 'el nombre no debe sobrepasar de 10 caracteres',
            'sale_cost_utility_expense.*.otherOperatingExpenses.max'        => 'el nombre no debe sobrepasar de 10 caracteres',
            'sale_cost_utility_expense.*.netInterests.max'                  => 'el nombre no debe sobrepasar de 10 caracteres',
            'sale_cost_utility_expense.*.ISR.max'                           => 'el nombre no debe sobrepasar de 10 caracteres',
			
		];
    }
}