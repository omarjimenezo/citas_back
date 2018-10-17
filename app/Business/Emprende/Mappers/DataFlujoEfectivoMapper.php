<?php
//Date: 18 May 2018 /
namespace App\Business\Emprende\Mappers;
// Responses
use App\Http\Responses\Emprende\FlujoEfectivo\CashFluxResponse;
use App\Http\Responses\Emprende\FlujoEfectivo\FluxResponse;
use App\Http\Responses\Emprende\FlujoEfectivo\MonthlyPercentageResponse; 
use App\Http\Responses\Emprende\FlujoEfectivo\ProjectionPremisesResponse;
//Models
use App\Models\Catalogs\CStatus;
use App\Models\EmpProjectionPremise;
use App\Models\EmpMonthlySalesPercentage;
use App\Models\EmpCashFlux;
use App\Models\EmpFlux;
use App\Http\Responses\Emprende\FlujoEfectivo\FormulesData;




class DataFlujoEfectivoMapper{   

    //get

    public static function fnGetCashFlux($oCashFlux, $oUser){

        $oModel = new CashFluxResponse();

        $oModel->name       = $oUser->firstName. " ". $oUser->lastName. " ".$oUser->secondLastName;
        $time = strtotime(date('y-m-d h:i:s'));
       
        if($oCashFlux != null)
           $times = strtotime($oCashFlux->date);

        $oModel->date = ($oCashFlux == null) ? date('Y-m-d H:i:s',$time) : date('Y-m-d H:i:s',$times);
        $oModel->estimatedPercentage = ($oCashFlux == null) ? 0 : $oCashFlux->estimatedPercentage;
        $oModel->describePersonalExpenses = ($oCashFlux == null) ? null : $oCashFlux->describePersonalExpenses;
        // $oModel->idProjectionPremises = ($oCashFlux == null) ? null : $oCashFlux->idProjectionPremises;
        // $oModel->idMonthlySalesPercentage = ($oCashFlux == null) ? null : $oCashFlux->idMonthlySalesPercentage;
        $oModel->complete = ($oCashFlux == null) ? null : $oCashFlux->complete;
     
        return $oModel;
    }

    public static function fnGetMonthlyPercentage($oPercentage){

        $oModel = new MonthlyPercentageResponse();

        $oModel->january = ($oPercentage == null) ? 0 : $oPercentage->january;
        $oModel->february = ($oPercentage == null) ? 0 : $oPercentage->february;
        $oModel->march = ($oPercentage == null) ? 0 : $oPercentage->march;
        $oModel->april = ($oPercentage == null) ? 0 : $oPercentage->april;
        $oModel->may = ($oPercentage == null) ? 0 : $oPercentage->may;
        $oModel->june = ($oPercentage == null) ? 0 : $oPercentage->june;
        $oModel->july = ($oPercentage == null) ? 0 : $oPercentage->july;
        $oModel->august = ($oPercentage == null) ? 0 : $oPercentage->august;
        $oModel->september = ($oPercentage == null) ? 0 : $oPercentage->september;
        $oModel->october = ($oPercentage == null) ? 0 : $oPercentage->october;
        $oModel->november = ($oPercentage == null) ? 0 : $oPercentage->november;
        $oModel->december = ($oPercentage == null) ? 0 : $oPercentage->december;
        $oModel->year = ($oPercentage == null) ? 0 : $oPercentage->year;

        return $oModel;
    }


    public static function fnGetFlux($oFlux){

        $oModel = new FluxResponse();

        // $oModel->idPeriod = ($oFlux == null) ? null : $oFlux->idPeriod;
       
        $oModel->idMonth  = ($oFlux == null) ? 0 : $oFlux->idMonth;

        $oModel->initialBalance  = ($oFlux == null) ? 0 : $oFlux->initialBalance;
        $oModel->informationSales  = ($oFlux == null) ? 0 : $oFlux->informationSales;
        $oModel->cashSales  = ($oFlux == null) ? 0 : $oFlux->cashSales;
        $oModel->collection  = ($oFlux == null) ? 0 : $oFlux->collection;
        $oModel->creditFojal  = ($oFlux == null) ? 0 : $oFlux->creditFojal;
        $oModel->totalIncome  = ($oFlux == null) ? 0 : $oFlux->totalIncome;
        $oModel->rawMaterial  = ($oFlux == null) ? 0 : $oFlux->rawMaterial;
        $oModel->paymentSuppliers  = ($oFlux == null) ? 0 : $oFlux->paymentSuppliers;
        $oModel->investmentsInNonCurrentAssets = ($oFlux == null) ? 0 : $oFlux->investmentsInNonCurrentAssets;
        $oModel->generalExpenses = ($oFlux == null) ? 0 : $oFlux->generalExpenses;
        $oModel->serviceAndMortgageExpenses  = ($oFlux == null) ? 0 : $oFlux->serviceAndMortgageExpenses;
        $oModel->taxes  = ($oFlux == null) ? 0 : $oFlux->taxes;
        $oModel->payOtherCredits  = ($oFlux == null) ? 0 : $oFlux->payOtherCredits;
        $oModel->paymentCreditCapitalFojal  = ($oFlux == null) ? 0 : $oFlux->paymentCreditCapitalFojal;
        $oModel->financialExpenses  = ($oFlux == null) ? 0 : $oFlux->financialExpenses;
        $oModel->otherExpenses  = ($oFlux == null) ? 0 : $oFlux->otherExpenses;
        $oModel->totalExpenses  = ($oFlux == null) ? 0 : $oFlux->totalExpenses;
        $oModel->finalBalance  = ($oFlux == null) ? 0 : $oFlux->finalBalance;
     
        return $oModel;
    }

    
    public static function fnGetProjectionPremises($oProjection, $percentagePurchasesCredit, $percentageCostOverSales,$netMargin){

        $oModel = new ProjectionPremisesResponse();

        $oModel->percentageSalesCredit  = ($oProjection == null) ? 0 : $oProjection->percentageSalesCredit;
        $oModel->percentagePurchasesCredit = ($oProjection == null) ? 0 : $oProjection->percentagePurchasesCredit;
        $oModel->percentageCostOverSales = ($oProjection == null) ? $percentagePurchasesCredit : $oProjection->percentageCostOverSales;
        $oModel->percentageExpensesOnSales = ($oProjection == null) ? $percentageCostOverSales : $oProjection->percentageExpensesOnSales;
        $oModel->expectedGrowthFirstYear = ($oProjection == null) ? 0 : $oProjection->expectedGrowthFirstYear;
        $oModel->expectedGrowthSecondYear = ($oProjection == null) ? 0 : $oProjection->expectedGrowthSecondYear;
        $oModel->expectedGrowthThirdYear = ($oProjection == null) ? 0 : $oProjection->expectedGrowthThirdYear;
        $oModel->expectedGrowthFourthYear = ($oProjection == null) ? 0 : $oProjection->expectedGrowthFourthYear;
        $oModel->netMargin = ($oProjection == null) ? $netMargin : $oProjection->netMargin;
        
        return $oModel;

    }

    public static function fnGetFormuleData($balance,$inversion,$resultados){

       $oModel = new FormulesData();

       $oModel->caja_bancos = $balance["caja_bancos"];
       $oModel->prestamos_bancarios = $balance["prestamos_bancarios"];
       $oModel->total_pasivo_largo_plazo = $balance["total_pasivo_largo_plazo"];
       $oModel->otros_prestamos = $balance["otros_prestamos"];
       $oModel->pago_mensual_hipoteca = $balance["pago_mensual_hipoteca"];
       $oModel->cuentas_cobrar = $balance["cuentas_cobrar"]; 
       $oModel->provedores = $balance["provedores"]; 
       $oModel->pasive_not_reporteado_buropagoano = $balance['pasive_not_reporteado_buropagoano'];
       $oModel->pasive_not_reporteado_buropagomasano  = $balance['pasive_not_reporteado_buropagomasano'];
     
       $oModel->aportaciones_equi = $inversion["aportaciones_equi"];
       $oModel->aportaciones_infra = $inversion["aportaciones_infra"];
       $oModel->aportaciones_pagopasivo = $inversion["aportaciones_pagopasivo"]; 
       $oModel->aportaciones_capital = $inversion["aportaciones_capital"]; 
       $oModel->monto_credito_fojal = $inversion["monto_credito_fojal"];
       $oModel->monto_equipamiento = $inversion["monto_equipamiento"];
       $oModel->monto_infraestructura = $inversion["monto_infraestructura"];
       $oModel->monto_capital_trabajo = $inversion["monto_capital_trabajo"];
       $oModel->monto_pago_pasivo = $inversion["monto_pago_pasivo"];
       $oModel->credito_solicitado = $inversion["credito_solicitado"];
       $oModel->otros_acreedores_monto_corto_plazo = $inversion["otros_acreedores_monto_corto_plazo"];
       $oModel->otros_proveedores_monto_credito_fojal = $inversion["otros_proveedores_monto_credito_fojal"];
       $oModel->otros_acreedores_largo_plazo= $inversion["otros_acreedores_largo_plazo"];
     
       $oModel->ventas_mensuales_A = $resultados["ventas_mensuales_A"];
       $oModel->porcentaje_ventas_mensual = $resultados["porcentaje_ventas_mensual"];
       $oModel->intereses_netos_ganados_pagados = $resultados["intereses_netos_ganados_pagados"];
       $oModel->ISR = $resultados["ISR"];

       return $oModel;
    }


    //save
    public static function fnSaveMonthlyPercentage($oPercentage){

        $oModel = new EmpMonthlySalesPercentage();

        $oModel->idStatus = CStatus::$ACTIVO;

		$oModel->january = $oPercentage["january"];
		$oModel->february = $oPercentage["february"];
		$oModel->march = $oPercentage["march"];
		$oModel->april  = $oPercentage["april"];
		$oModel->may = $oPercentage["may"];
		$oModel->june = $oPercentage["june"];
		$oModel->july = $oPercentage["july"];
		$oModel->august = $oPercentage["august"];
		$oModel->september = $oPercentage["september"];
		$oModel->october = $oPercentage["october"];
		$oModel->november = $oPercentage["november"];
		$oModel->december = $oPercentage["december"];
		$oModel->year = $oPercentage["year"];

        return $oModel;
    }

    public static function fnSaveProjectionPremises($oProjection){

        $oModel = new EmpProjectionPremise();

        $oModel->idStatus = CStatus::$ACTIVO;
        $oModel->percentageSalesCredit = $oProjection["percentageSalesCredit"];
        $oModel->percentagePurchasesCredit = $oProjection['percentagePurchasesCredit'];
        $oModel->percentageCostOverSales = $oProjection['percentageCostOverSales'];
        $oModel->percentageExpensesOnSales = $oProjection['percentageExpensesOnSales'];
        $oModel->expectedGrowthFirstYear = $oProjection['expectedGrowthFirstYear'];
        $oModel->expectedGrowthSecondYear = $oProjection['expectedGrowthSecondYear'];
        $oModel->expectedGrowthThirdYear = $oProjection['expectedGrowthThirdYear'];
        $oModel->expectedGrowthFourthYear = $oProjection['expectedGrowthFourthYear'];
        $oModel->netMargin = $oProjection['netMargin'];
       
        return $oModel;

    }

    public static function fnSaveCashFlux($oCashFlux, $idUserCourse,$Percentage,$idProjection){

        $oModel = new EmpCashFlux();

        $oModel->idStatus = CStatus::$ACTIVO;
		$oModel->idUserCourse = $idUserCourse;
		$oModel->date = strtotime(date('y-m-d h:i:s'));
		$oModel->estimatedPercentage = $oCashFlux['estimatedPercentage'];
		$oModel->describePersonalExpenses = $oCashFlux['describePersonalExpenses'];
		$oModel->idProjectionPremises = $idProjection;
		$oModel->idMonthlySalesPercentage = $Percentage;
		$oModel->complete =true;

        return $oModel;

    }


    public static function fnSaveFlux($oFlux, $periodo, $idCashFlux){

        $oModel = new EmpFlux();

        $oModel->idStatus = CStatus::$ACTIVO;
		$oModel->idCashFlux = $idCashFlux;
		$oModel->idPeriod = $periodo; //$oFlux['idPeriod'];
		// $oModel->idMovementType = $oFlux['idMovementType'];
		$oModel->idMonth = $oFlux['idMonth'];
		$oModel->initialBalance = $oFlux['initialBalance'];
		$oModel->informationSales = $oFlux['informationSales'];
		$oModel->cashSales = $oFlux['cashSales'];
		$oModel->collection = $oFlux['collection'];
		$oModel->creditFojal = $oFlux['creditFojal'];
		$oModel->totalIncome = $oFlux['totalIncome'];
		$oModel->rawMaterial = $oFlux['rawMaterial'];
		$oModel->paymentSuppliers = $oFlux['paymentSuppliers'];
		$oModel->investmentsInNonCurrentAssets = $oFlux['investmentsInNonCurrentAssets'];
		$oModel->generalExpenses = $oFlux['generalExpenses'];
		$oModel->serviceAndMortgageExpenses = $oFlux['serviceAndMortgageExpenses'];
		$oModel->taxes = $oFlux['taxes'];
		$oModel->payOtherCredits = $oFlux['payOtherCredits'];
		$oModel->paymentCreditCapitalFojal = $oFlux['paymentCreditCapitalFojal'];
		$oModel->financialExpenses = $oFlux['financialExpenses'];
		$oModel->otherExpenses = $oFlux['otherExpenses'];
		$oModel->totalExpenses = $oFlux['totalExpenses'];
		$oModel->finalBalance = $oFlux['finalBalance'];

        return $oModel;

    }

}
