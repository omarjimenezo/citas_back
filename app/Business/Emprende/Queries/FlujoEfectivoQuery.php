<?php
//Date: 16 May 2018 / Ede nuñez
namespace App\Business\Emprende\Queries;

//Queries
use App\Business\Emprende\Queries\TablaPagosQuery;
// Mappers
use App\Business\Emprende\Mappers\DataFlujoEfectivoMapper;
//Repositories
use  App\Business\Emprende\Repositories\ProyectoInversion\InvestmentProjectRepository;
use  App\Business\Emprende\Repositories\Negocio\CreditDataRepository as creditBusiness;
use  App\Business\Emprende\Repositories\ProyectoInversion\CreditDataRepository;
use  App\Business\Emprende\Repositories\EstadoResultados\EstadoResultadosRepository;
use  App\Business\Emprende\Repositories\FlujoEfectivo\CashFluxRepository;
use  App\Business\Emprende\Repositories\FlujoEfectivo\FluxRepository;
use App\Business\Emprende\Repositories\FlujoEfectivo\MonthlySalesPercentageRepository;
use App\Business\Emprende\Repositories\FlujoEfectivo\ProjectionPremisesRepository; 
use App\Business\Emprende\Repositories\BalanceGeneral\GeneralBalanceRepository;
// MOdels
use App\Models\Catalogs\CStatus;

class FlujoEfectivoQuery{   

    public static function fnGetFlujoEfectivo($idUserCourse, $oUser){

 
      $percentageCostOverSales = 0;
      $percentagePurchasesCredit =0;
      $netMargin = 0;
      $oFluxNew = [];
      $oMonthNew = [];

      //obtiene datos estado de resultados 
      $oSaleCostData = self::fngetSaleCost($idUserCourse,2);
     
     // obtiene datos de premisas de proyeccion
     // Porcentaje de costo sobre ventas
      $percentageCostOverSales = ($oSaleCostData == null) ? 0 : $oSaleCostData->percentage3 + $oSaleCostData->percentage4 + $oSaleCostData->percentage5
                               + $oSaleCostData->percentage6 + $oSaleCostData->percentage7 + $oSaleCostData->percentage8
                               + $oSaleCostData->percentage9 + $oSaleCostData->percentage10 + $oSaleCostData->percentage11
                               + $oSaleCostData->percentage12;
      // Porcentaje de gastos sobre ventas
      $percentagePurchasesCredit = ($oSaleCostData == null) ? 0 :  $oSaleCostData->percentage2;

      // Margen neto
      $netMargin = ($oSaleCostData == null) ? 0 :  $oSaleCostData->percentage14;

      ///--------
      //  $percentageCostOverSales = $oSaleCostData->percentage13;

        // Obtiene datos de flujo de efectibo info base
        $oCashFlux = CashFluxRepository::fnAllByUser($idUserCourse)->first();
        // mapea datos de flujo de efectibo info base
        $oCashFluxNew = DataFlujoEfectivoMapper::fnGetCashFlux(($oCashFlux == null)? null : $oCashFlux,$oUser);
      
        // obtiene datos de flujo
        $oFlux = FluxRepository::fnAllByCashFlux(($oCashFlux == null)? null : $oCashFlux->id)->get();
        
        // si el objeto esta lleno se forma la estructura de flujos
        if(count($oFlux) > 0){

            $cont = 1;
            foreach ($oFlux as $value) {
                
                    $result = DataFlujoEfectivoMapper::fnGetFlux($value);
                    array_push($oMonthNew,$result);

                    if($value->idMonth == 13){ 
                        array_push($oFluxNew,array_merge(['periodo' => $cont, 'mes' => $oMonthNew]));
                        $cont ++;
                        $oMonthNew =[]; 
                }
            }
        }
        else{
            // si no crea una estructura con nulos
            $result = DataFlujoEfectivoMapper::fnGetFlux(null);
            array_push($oMonthNew,$result);
            array_push($oFluxNew,array_merge(['periodo' => 0, 'mes' => $oMonthNew]));
        }

        // obtine porjentajes por meses
        $oMonthlyPercentage = MonthlySalesPercentageRepository::fnFind(($oCashFlux == null)? null : $oCashFlux->idMonthlySalesPercentage)->first();
         // mapea porjentajes por meses
        $oMonthlyPercentageNew = DataFlujoEfectivoMapper::fnGetMonthlyPercentage($oMonthlyPercentage);
        // obtine premisas de proyeccion
        $oProjection = ProjectionPremisesRepository::fnFind(($oCashFlux == null)? null : $oCashFlux->idProjectionPremises)->first();
        // mapea premisas de proyeccion
        $oProjectionNew = DataFlujoEfectivoMapper::fnGetProjectionPremises($oProjection, $percentagePurchasesCredit, $percentageCostOverSales,$netMargin);
      
        //obtiene los datos de otras tablas que se necesitan para las formulas
        $balance    =   self::fnGetinitialBalance($idUserCourse);
        $inversion  =   self::fnGetInversion($idUserCourse);
        $resultados =   self::fnGetResultados($idUserCourse);


        //mapea los datos en un solo objeto
        $FormuleData = DataFlujoEfectivoMapper::fnGetFormuleData($balance,$inversion,$resultados);
        
        // obtiene tabla de pagos
        $paymentTable = TablaPagosQuery::fnGetAllPeriod( $idUserCourse );

        //Selecciona cuantos meses muestra en la tabla
        // $salida = array_slice($paymentTable["payments_table"], 0, 12);

        // forma el Json general del servicio
       return array_merge(['flujo_efectivo' => $oCashFluxNew,
                            'flujos' => $oFluxNew,
                            'porcentaje_mensual' => $oMonthlyPercentageNew,
                            'premisas_inversion' => $oProjectionNew,
                            'FormuleData' => $FormuleData,
                            'payments_table' => $paymentTable["payments_table"]
                            ]);
    }	

    public static function fnSaveFlujoEfectivo($oModel, $idUserCourse, $token, $oUser){
        $result;
        // Mapea objeto porcentaje mensual
        $oMonthlyPercentageNew = DataFlujoEfectivoMapper::fnSaveMonthlyPercentage($oModel["porcentaje_mensual"]);
        // Guarda objeto porcentaje mensual
        $oMonthlyPercentage = MonthlySalesPercentageRepository::fnSave($oMonthlyPercentageNew);
       
         // Mapea objeto premisas de inversion
        $oProjectionNew = DataFlujoEfectivoMapper::fnSaveProjectionPremises($oModel["premisas_inversion"]);
        // Guarda objeto premisas de inversion
        $oProjection = ProjectionPremisesRepository::fnSave($oProjectionNew);

        //Mapea objeto flujo de efectivo
        $oCashFluxNew = DataFlujoEfectivoMapper::fnSaveCashFlux($oModel["flujo_efectivo"], 
                                                                $idUserCourse,
                                                                $oMonthlyPercentage->id,
                                                                $oProjection->id);
        //guarda objeto flujo de efectivo
        $oCashFlux    = CashFluxRepository::fnSave($oCashFluxNew);

        // foreach ($oModel["flujos"] as $value) {
        //     // Mapea cada  objeto de flujos
        //     $result = DataFlujoEfectivoMapper::fnSaveFlux($value,$oCashFlux->id);
        //     // Guarda cada objeto de flujos
        //     $oFlux  = FluxRepository::fnSave($result);
        // }

           
        foreach ($oModel["flujos"] as $value) {

            $periodo = $value['periodo'];
           
            foreach ($value['mes'] as $val) {
                // Mapea cada  objeto de flujos
                $result = DataFlujoEfectivoMapper::fnSaveFlux($val, $periodo,$oCashFlux->id);

                // Guarda cada objeto de flujos
                $oFlux  = FluxRepository::fnSave($result);
            }
           

        }

        return   self::fnGetFlujoEfectivo($idUserCourse, $oUser);
    }	

    public static function fngetSaleCost($idUserCourse, $val){
        // Queries
        
        $oStatusResultsData = EstadoResultadosRepository::fnAllByUser( $idUserCourse )->first();

        if($oStatusResultsData == null)
            return 0;

        return $saleCost = EstadoResultadosRepository::fnSaleCost($val, $oStatusResultsData->id)->first();
    }

    public static function fnGetCreditData($idUserCourse){
        // obtiene los datos de credito de usuario
        return creditBusiness::fnAllByUser($idUserCourse)->first();
    }

    public static function fnGetinitialBalance($idUserCourse){
          // obtiene los datos de balance general por el id de usuariocurso
          $oGeneral = GeneralBalanceRepository::fnAByUser($idUserCourse)->first();
          return array_merge(['caja_bancos' => ($oGeneral == null) ? 0 : $oGeneral->emp_current_asset->boxesBanks,
                              'prestamos_bancarios' => ($oGeneral == null) ? 0 : $oGeneral->emp_passive_short_term->bankLoans,
                              'total_pasivo_largo_plazo' => ($oGeneral == null || $oGeneral->emp_passive_long_term->totalPassiveLongTerm == null) ? 0 : $oGeneral->emp_passive_long_term->totalPassiveLongTerm,
                              'otros_prestamos' => ($oGeneral == null || $oGeneral->emp_passive_short_term->otherAssets == null) ? 0 :$oGeneral->emp_passive_short_term->otherAssets,
                              'pago_mensual_hipoteca' => ($oGeneral == null) ? 0 :$oGeneral->emp_passive_not_reported->monthlyMortgagePayment,
                              'cuentas_cobrar' => ($oGeneral == null) ? 0 :$oGeneral->emp_current_asset->accountsReceivable,
                              'provedores' => ($oGeneral == null) ? 0 :$oGeneral->emp_passive_short_term->provider,
                              'pasive_not_reporteado_buropagoano' => ($oGeneral == null) ? 0 :$oGeneral->emp_passive_not_reported->debtsBureauPayOneYear,
                              'pasive_not_reporteado_buropagomasano' => ($oGeneral == null) ? 0 :$oGeneral->emp_passive_not_reported->debtsBureauPayMoreOneYear
                              ]);
    }

    public static function fnGetInversion($idUserCourse){
        $oCreditData  = CreditDataRepository::fnAllByUser( $idUserCourse )->first();
        $credit = self::fnGetCreditData($idUserCourse);

        $ContriEqui = InvestmentProjectRepository::fnAllByUserType($idUserCourse, 2);
        $ContriInfra = InvestmentProjectRepository::fnAllByUserType($idUserCourse, 3);
        $ContriIPagoPasivo = InvestmentProjectRepository::fnAllByUserType($idUserCourse, 4);
        $ContriCapital = InvestmentProjectRepository::fnAllByUserType($idUserCourse, 1);
        //$ContriPago = self::fnGetContribution($idUserCourse, 4);

        $creditSolicitado = ($oCreditData == null) ? null : $oCreditData->equipmentCredit + $oCreditData->infrastructureCredit
                          + $oCreditData->workingCapitalCredit + $oCreditData->passivePaymentCredit;
        $proveedores = self::fnPrroyect($idUserCourse,1);
        $acreedoresCorto = self::fnPrroyect($idUserCourse,2);
        $acreedoresLargo = self::fnPrroyect($idUserCourse,3);

        return array_merge(['aportaciones_equi' =>($ContriEqui == null) ? 0 : $ContriEqui->contributions, //$oCreditData->equipmentCredit->contributions,
                            'aportaciones_infra' =>($ContriInfra == null) ? 0 : $ContriInfra->contributions, //$oCreditData->infrastructureCredit->contributions,
                            'aportaciones_pagopasivo' =>  ($ContriIPagoPasivo == null) ? 0 : $ContriIPagoPasivo->contributions,
                            'aportaciones_capital' => ($ContriCapital == null) ? 0 : $ContriCapital->contributions,
                            'monto_credito_fojal' =>   ($credit == null) ? 0 : $credit->passivePaymentCredit,
                            'monto_equipamiento' => ($oCreditData == null) ? 0 : $oCreditData->equipmentCredit,
                            'monto_infraestructura' =>($oCreditData == null) ? 0 : $oCreditData->infrastructureCredit,
                            'monto_capital_trabajo' =>($oCreditData == null) ? 0 : $oCreditData->workingCapitalCredit,
                            'monto_pago_pasivo' => ($oCreditData == null) ? 0 :$oCreditData->passivePaymentCredit,
                            'credito_solicitado' =>($creditSolicitado == null) ? 0 : $creditSolicitado,
                            'otros_acreedores_monto_corto_plazo' => ($acreedoresCorto == null) ? 0 : $acreedoresCorto->amountPayFojalCredit,
                            'otros_proveedores_monto_credito_fojal' => ($proveedores == null) ? 0 : $proveedores->amountPayFojalCredit,
                            'otros_acreedores_largo_plazo' => ($acreedoresLargo == null) ? 0 : $acreedoresLargo->amountPayFojalCredit
                          ]);
    }

    public static function fnGetResultados($idUserCourse){
        // $actual = self::fngetSaleCost($idUserCourse, 1);
        $esperado = self::fngetSaleCost($idUserCourse, 2);

        return array_merge(['ventas_mensuales_A' => ($esperado == null) ? 0 :  $esperado->monthlySales,
                            'porcentaje_ventas_mensual' => ($esperado == null) ? 0 : $esperado->percentage1,
                            'intereses_netos_ganados_pagados' => ($esperado == null) ? 0 : $esperado->percentage11,
                            'ISR' => ($esperado == null) ? 0 : $esperado->percentage12
                            ]);
    }

    public static function fnGetContribution($idUserCourse, $val){
      return  InvestmentProjectRepository::fnAllByUserType($idUserCourse, $val);
    }

    public static function fnPrroyect($idUserCourse,$val){

      return  $oInvestmentData  = InvestmentProjectRepository::fnAllByUserToPay( $idUserCourse, $val );
    }

}