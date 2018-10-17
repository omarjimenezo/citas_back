<?php
namespace App\Http\Requests\Emprende\ProyectoInversion;

use Joeldeval\Form\FormRequest;
use App\Http\Requests\ValidationRequest;

class SaveInversionRequest extends ValidationRequest
{
    public function authorize()
	{
		return true;
	}

	public function rules()
	{
		$rules = [

			// Proyecto de inversion ----------------
            'investment_project.totalValueInvestment'    => 'required',
            'investment_project.requestedCredit'         => 'required',
            'investment_project.contributionApplicant'   => 'required',
            // Proyecto de inversion ----------------

            // Deudas a pagar ----------------
            'debt_to_pays.providers.name'                   => 'max:60',
            'debt_to_pays.providers.creditNumberInvoices'   => 'max:30',
            'debt_to_pays.providers.amountPayFojalCredit'   => 'min:1|max:10',

            'debt_to_pays.long_term.name'                   => 'max:60',
            'debt_to_pays.long_term.creditNumberInvoices'   => 'max:30',
            'debt_to_pays.long_term.amountPayFojalCredit'   => 'min:1|max:10',

            'debt_to_pays.short_term.name'                  => 'max:60',
            'debt_to_pays.short_term.creditNumberInvoices'  => 'max:30',
            'debt_to_pays.short_term.amountPayFojalCredit'  => 'min:1|max:10',
            // Deudas a pagar ----------------

            // Tipo de credito ----------------
            'type_credits.working_capital.description'       => 'max:1700',
            'type_credits.working_capital.contributions'     => 'min:1|max:30',

            'type_credits.equipment.description'             => 'max:1700',
            'type_credits.equipment.contributions'           => 'min:1|max:30',

            'type_credits.infrastructure.description'        => 'max:1700',
            'type_credits.infrastructure.contributions'      => 'min:1|max:30',

            'type_credits.passive_payments.contributions'    => 'min:1|max:30',
            // Tipo de credito ----------------
	
		];

		return $rules;

	}

	public function messages(){
        return [

            // Proyecto de inversion ----------------
            'investment_project.totalValueInvestment.required'    => 'Ingesa el total de inversión.',
            'investment_project.requestedCredit.required'         => 'Ingesa el monto solicitado.',
            'investment_project.contributionApplicant.required'   => 'Ingesa la aprotacion del solicitante.',
            // Proyecto de inversion ----------------

            // Deudas a pagar ----------------
            'debt_to_pays.providers.name.min'                        => 'el nombre no debe ser menor de 1 caracteres',
            'debt_to_pays.providers.name.max'                        => 'el nombre no debe sobrepasar de 60 caracteres',
            'debt_to_pays.providers.creditNumberInvoices.min'        => 'el numero de crèditos/facturas no debe ser menor de 1 caracteres',
            'debt_to_pays.providers.creditNumberInvoices.max'        => 'el numero de crèditos/facturas no debe sobrepasar de 30 caracteres',
            'debt_to_pays.providers.amountPayFojalCredit.min'        => 'el mondo a pagar no debe ser menor de 1 caracteres',
            'debt_to_pays.providers.amountPayFojalCredit.max'        => 'el mondo a pagar no debe sobrepasar de 10 caracteres',
            
            'debt_to_pays.long_term.name.min'                        => 'el nombre no debe ser menor de 1 caracteres',
            'debt_to_pays.long_term.name.max'                        => 'el nombre no debe sobrepasar de 60 caracteres',
            'debt_to_pays.long_term.creditNumberInvoices.min'        => 'el numero de crèditos/facturas no debe ser menor de 1 caracteres',
            'debt_to_pays.long_term.creditNumberInvoices.max'        => 'el numero de crèditos/facturas no debe sobrepasar de 30 caracteres',
            'debt_to_pays.long_term.amountPayFojalCredit.min'        => 'el monto a pagar no debe ser menor de 1 caracteres',
            'debt_to_pays.long_term.amountPayFojalCredit.max'        => 'el monto a pagar no debe sobrepasar de 10 caracteres',
            
            'debt_to_pays.short_term.name.min'                        => 'el nombre no debe ser menor de 1 caracteres',
            'debt_to_pays.short_term.name.max'                        => 'el nombre no debe sobrepasar de 60 caracteres',
            'debt_to_pays.short_term.creditNumberInvoices.min'        => 'el numero de crèditos/facturas no debe ser menor de 1 caracteres',
            'debt_to_pays.short_term.creditNumberInvoices.max'        => 'el numero de crèditos/facturas no debe sobrepasar de 30 caracteres',
            'debt_to_pays.short_term.amountPayFojalCredit.min'        => 'el monto a pagar no debe ser menor de 1 caracteres',
            'debt_to_pays.short_term.amountPayFojalCredit.max'        => 'el monto a pagar no debe sobrepasar de 10 caracteres',
            // Deudas a pagar ----------------

            // Tipo de credito ----------------
            'type_credits.working_capital.contributions.required'   => 'Ingresa la aportación',

            'type_credits.working_capital.description.max'          => 'La descripcion no debe sobrepasar de 1700 caracteres',
            'type_credits.working_capital.contributions.min'        => 'La aportación no debe ser menor de 1 caracteres',
            'type_credits.working_capital.contributions.max'        => 'La aportación no debe sobrepasar de 30 caracteres',
           
            'type_credits.equipment.contributions.required'         => 'Ingresa la aportación',

            'type_credits.equipment.description.max'                => 'La descripcion no debe sobrepasar de 1700 caracteres',
            'type_credits.equipment.contributions.min'              => 'La aportación no debe ser menor de 1 caracteres',
            'type_credits.equipment.contributions.max'              => 'La aportación no debe sobrepasar de 30 caracteres',
            
            'type_credits.infrastructure.contributions.required'    => 'Ingresa la aportación',

            'type_credits.infrastructure.description.max'           => 'La descripcion no debe sobrepasar de 1700 caracteres',
            'type_credits.infrastructure.contributions.min'         => 'La aportación no debe ser menor de 1 caracteres',
            'type_credits.infrastructure.contributions.max'         => 'La aportación no debe sobrepasar de 30 caracteres',
           
            'type_credits.passive_payments.contributions.required'  => 'Ingresa la aportación',

            'type_credits.passive_payments.description.min'         => 'La descripcion no debe ser menor de 2 caracteres',
            'type_credits.passive_payments.description.min'         => 'La descripcion no debe sobrepasar de 1700 caracteres',
            'type_credits.passive_payments.contributions.max'       => 'La aportación no debe ser menor de 1 caracteres',
            'type_credits.passive_payments.contributions.max'       => 'La aportación no debe sobrepasar de 30 caracteres',
            // Tipo de credito ----------------
			
		];
    }
}