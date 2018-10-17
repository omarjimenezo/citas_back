<?php
namespace App\Http\Requests\Emprende\BalanceGeneral;

use Joeldeval\Form\FormRequest;
use App\Http\Requests\ValidationRequest;

class SaveDataBalanceGeneralRequest extends ValidationRequest
{
    public function authorize()
	{
		return true;
	}

	public function rules()
	{

	return	$rules = [
			
			// general_balance
			// "Balance_geral.idCurrentAssets"=> "required",
            // "Balance_geral.idFixedAsset"=> "required",
            // "Balance_geral.idDeferredAssets"=> "required",
            // "Balance_geral.idPassiveShortTerm"=> "required",
            // "Balance_geral.idPassiveLongTerm"=> "required",
            // "Balance_geral.idPassiveAccountingCapital"=> "required",
            // "Balance_geral.idPassiveNotReported"=> "required",
            // "Balance_geral.complete"=> "required",


        
            //current_assets
            "assets.current_assets.boxesBanks"=> "required|max:10",
            "assets.current_assets.accountsReceivable"=> "required|max:10",
            "assets.current_assets.inventory"=> "required|max:10",
            "assets.current_assets.totalCurrentAssets"=> "required|max:10",



            //fixed_asset
            "assets.fixed_asset.immovables"=> "required",
            "assets.fixed_asset.machineryWorkEquipment"=> "required|max:10",
            "assets.fixed_asset.furnitureOfficeEquipment"=> "required|max:10",
            "assets.fixed_asset.transportationEquipment"=> "required|max:10",
            "assets.fixed_asset.accumulatedDepreciation"=> "required|max:10",
            "assets.fixed_asset.totalFixedAsset"=> "required|max:10",

             //deferred_assets
            "assets.deferred_assets.installationCosts"=> "required|max:10",
            "assets.deferred_assets.otherAssets"=> "required|max:10",
            "assets.deferred_assets.totalDeferredAssets"=> "required|max:10",
            
            //passive_short_term
            "passive.passive_short_term.bankLoans"=> "required|max:10",
            "passive.passive_short_term.provider"=> "required|max:10",
            "passive.passive_short_term.otherAssets"=> "required|max:10",
            "passive.passive_short_term.totalPassiveShortTerm"=> "required|max:10",

             
            //passive_long_term
            "passive.passive_long_term.bankLoans"=> "required|max:10",
            "passive.passive_long_term.otherAssets"=> "required|max:10",
            "passive.passive_long_term.totalPassiveLongTerm"=> "required|max:10",

             
             //passive_accounting_capital
            "passive_accounting_capital.patrimony"=> "required|max:10",
            "passive_accounting_capital.periodUtility"=> "required|max:10",
            "passive_accounting_capital.totalPassiveAccountingCapital"=> "required|max:10",

             
             //passive_not_reported
             "passive_not_reported.debtsBureauPayOneYear"=> "required",
             "passive_not_reported.debtsBureauPayMoreOneYear"=> "required",
             "passive_not_reported.monthlyMortgagePayment"=> "required",

		];

	}

	public function message(){
        return [

                   //current_assets
                   "assets.current_assets.boxesBanks.required"=> "El campo caja y bancos es requerido.",
                   "assets.current_assets.boxesBanks.max:10"=> "El campo caja y bancos no puede ser mayor a 10 caracteres.",
                   "assets.current_assets.accountsReceivable.required"=> "El campo cuentas por cobrar es requerido.",
                   "assets.current_assets.accountsReceivable.max:10"=> "El campo cuentas por cobrar no puede ser mayor a 10 caracteres.",
                   "assets.current_assets.inventory.required"=> "El campo inventario es requerido.",
                   "assets.current_assets.inventory.max:10"=> "El campo inventario no puede ser mayor a 10 caracteres.",
                   "assets.current_assets.totalCurrentAssets.required"=> "El campo total de activos corrientes es requerido.",
                   "assets.current_assets.totalCurrentAssets.max:10"=> "El campo total de activos corrientes no puede ser mayor a 10 caracteres.",
       
       
                   //fixed_asset
                   "assets.fixed_asset.immovables.required"=> "El campo inmuebles es requerido.",
                   "assets.fixed_asset.machineryWorkEquipment.required"=> "El campo maquinaria de trabajo es requerido.",
                   "assets.fixed_asset.machineryWorkEquipment.max:10"=> "El campo maquinaria no puede ser mayor a 10 caracteres.",
                   "assets.fixed_asset.furnitureOfficeEquipment.required"=> "El campo equipamiento de oficina es requerido.",
                   "assets.fixed_asset.furnitureOfficeEquipment.max:10"=> "El campo equipamiento de oficina no puede ser mayor a 10 caracteres.",
                   "assets.fixed_asset.transportationEquipment.required"=> "El campo equipo de transporte es requerido.",
                   "assets.fixed_asset.transportationEquipment.max:10"=> "El campo equipo de transporte no puede ser mayor a 10 caracteres.",
                   "assets.fixed_asset.accumulatedDepreciation.required"=> "El campo depresiación acumulada es requerido.",
                   "assets.fixed_asset.accumulatedDepreciation.max:10"=> "El campo depresiación acumulada no puede ser mayor a 10 caracteres.",
                   "assets.fixed_asset.totalFixedAsset.required"=> "El campo total activo fijo es requerido.",
                   "assets.fixed_asset.totalFixedAsset.max:10"=> "El campo total activo fijo no puede ser mayor a 10 caracteres.",
                   
                    //deferred_assets
                   "assets.deferred_assets.installationCosts.required"=> "El campo costos de instalación es requerido.",
                   "assets.deferred_assets.installationCosts.max:10"=> "El campo costos de instalación no puede ser mayor a 10 caracteres.",

                   "assets.deferred_assets.otherAssets.required"=> "El campo otros activos es requerido.",
                   "assets.deferred_assets.otherAssets.max:10"=> "El campo otros activos no puede ser mayor a 10 caracteres.",

                   "assets.deferred_assets.totalDeferredAssets.required"=> "El campo total activos diferidos es requerido.",
                   "assets.deferred_assets.totalDeferredAssets.max:10"=> "El campo total activos diferidos no puede ser mayor a 10 caracteres.",

       
                   
                    //passive_short_term
                    "passive.passive_short_term.bankLoans.required"=> "El campo prestamos bancario es requerido.",
                    "passive.passive_short_term.bankLoans.max:10"=> "El campo prestamos bancarios no puede ser mayor a 10 caracteres.",

                    "passive.passive_short_term.provider.required"=> "El campo proveedores es requerido.",
                    "passive.passive_short_term.provider.max:10"=> "El campo proveedores no puede ser mayor a 10 caracteres.",

                    "passive.passive_short_term.otherAssets.required"=> "El campo otro prestamos es requerido.",
                    "passive.passive_short_term.otherAssets.max:10"=> "El campo otro prestamos no puede ser mayor a 10 caracteres.",

                    "passive.passive_short_term.totalPassiveShortTerm.required"=> "El campo total pasivos corto plazo es requerido.",
                    "passive.passive_short_term.totalPassiveShortTerm.max:10"=> "El campo total pasivos corto plazo no puede ser mayor a 10 caracteres.",

                    
                    //passive_long_term
                    "passive.passive_long_term.bankLoans.required"=> "El campo prestamos bancario es requerido.",
                    "passive.passive_long_term.bankLoans.max:10"=> "El campo prestamos bancarios no puede ser mayor a 10 caracteres.",

                    "passive.passive_long_term.otherAssets.required"=> "El campo prestamos bancario es requerido.",
                    "passive.passive_long_term.otherAssets.max:10"=> "El campo prestamos bancarios no puede ser mayor a 10 caracteres.",

                    "passive.passive_long_term.totalPassiveLongTerm.required"=> "El campo prestamos bancario es requerido.",
                    "passive.passive_long_term.totalPassiveLongTerm.max:10"=> "El campo prestamos bancarios no puede ser mayor a 10 caracteres.",

       
                     //passive_accounting_capital
                    "passive_accounting_capital.patrimony.required"=> "El campo patrimonio es requerido.",
                    "passive_accounting_capital.patrimony.max:10"=> "El campo patrimonio no puede ser mayor a 10 caracteres.",

                    "passive_accounting_capital.periodUtility.required"=> "El campo utilidad del periodo es requerido.",
                    "passive_accounting_capital.periodUtility.max:10"=> "El campo utilidad del periodo no puede ser mayor a 10 caracteres.",

                    // "passive_accounting_capital.totalPassiveAccountingCapital.required"=> "El campo prestamos bancario es requerido.",
                    // "passive_accounting_capital.totalPassiveAccountingCapital.max:10"=> "El campo prestamos bancarios no puede ser mayor a 10 caracteres.",

       
                    
                    //passive_not_reported
                    "passive_not_reported.debtsBureauPayOneYear.required"=> "El campo deudas adicionales buro de credito por año es requerido.",
                    "passive_not_reported.debtsBureauPayMoreOneYear.required"=> "El campo deudas adicionales buro de credito a mas de un año es requerido.",
                    "passive_not_reported.monthlyMortgagePayment.required"=> "El campo pago mensual de hipoteca es requerido.",

		];
	}
    
}				
