<?php
//Date: 18 May 2018 /
namespace App\Business\Emprende\Mappers;

// Responses
use App\Http\Responses\Emprende\EstadoResultados\DatosEstadoResultadosResponse;
use App\Http\Responses\Emprende\EstadoResultados\DatosCostoResponse;

//Models
use Carbon\Carbon;
use App\Models\Catalogs\CStatus;
use App\Models\EmpStatusResult;
use App\Models\EmpSaleCostUtilityExpense;

class DataEstadoResultadosMapper{   

    public static function fnGetStatusResults($StatusResults, $User, $startDateOperation)
    {
        
        // Obtiene el numero de meses desde que inició la operación hasta el dia de hoy
        $months = (int)abs((strtotime($startDateOperation) - strtotime("now"))/(60*60*24*30));

        $oModel = new DatosEstadoResultadosResponse();       
        
        $oModel->name = $User->firstName . ' ' . $User->lastName . ' ' . $User->secondLastName;
        
        $oModel->startDateOperation         = ($months > 6) ? true : false;
        $oModel->dateFinancialInformation   = ($StatusResults == null) ? date('Y-m-d H:i:s', strtotime("now")) : date('Y-m-d H:i:s', strtotime($StatusResults->dateFinancialInformation));
        $oModel->complete                   = ($StatusResults == null) ? null : $StatusResults->complete;
        
        return $oModel;        
    }

    public static function fnGetSaleCost($SaleCost)
    {
        
        $oModel = new DatosCostoResponse();      

        $oModel->monthlySales                   = ($SaleCost == null) ? null : $SaleCost->monthlySales;
        $oModel->percentage1                    = ($SaleCost == null) ? null : $SaleCost->percentage1;
        $oModel->merchandiseRawMaterial         = ($SaleCost == null) ? null : $SaleCost->merchandiseRawMaterial;
        $oModel->percentage2                    = ($SaleCost == null) ? null : $SaleCost->percentage2;
        $oModel->wagesSalaries                  = ($SaleCost == null) ? null : $SaleCost->wagesSalaries;
        $oModel->percentage3                    = ($SaleCost == null) ? null : $SaleCost->percentage3;
        $oModel->rentalPremises                 = ($SaleCost == null) ? null : $SaleCost->rentalPremises;
        $oModel->percentage4                    = ($SaleCost == null) ? null : $SaleCost->percentage4;
        $oModel->stationeryVarious              = ($SaleCost == null) ? null : $SaleCost->stationeryVarious;
        $oModel->percentage5                    = ($SaleCost == null) ? null : $SaleCost->percentage5;
        $oModel->phone                          = ($SaleCost == null) ? null : $SaleCost->phone;
        $oModel->percentage6                    = ($SaleCost == null) ? null : $SaleCost->percentage6;
        $oModel->otherAdministrationExpenses    = ($SaleCost == null) ? null : $SaleCost->otherAdministrationExpenses;
        $oModel->percentage7                    = ($SaleCost == null) ? null : $SaleCost->percentage7;
        $oModel->gasolineLubricants             = ($SaleCost == null) ? null : $SaleCost->gasolineLubricants;
        $oModel->percentage8                    = ($SaleCost == null) ? null : $SaleCost->percentage8;
        $oModel->maintenance                    = ($SaleCost == null) ? null : $SaleCost->maintenance;
        $oModel->percentage9                    = ($SaleCost == null) ? null : $SaleCost->percentage9;
        $oModel->otherOperatingExpenses         = ($SaleCost == null) ? null : $SaleCost->otherOperatingExpenses;
        $oModel->percentage10                   = ($SaleCost == null) ? null : $SaleCost->percentage10;
        $oModel->netInterests                   = ($SaleCost == null) ? null : $SaleCost->netInterests;
        $oModel->percentage11                   = ($SaleCost == null) ? null : $SaleCost->percentage11;
        $oModel->ISR                            = ($SaleCost == null) ? null : $SaleCost->ISR;
        $oModel->percentage12                   = ($SaleCost == null) ? null : $SaleCost->percentage12;
        $oModel->totalCostsExpenses             = ($SaleCost == null) ? null : $SaleCost->totalCostsExpenses;
        $oModel->percentage13                   = ($SaleCost == null) ? null : $SaleCost->percentage13;
        $oModel->utility                        = ($SaleCost == null) ? null : $SaleCost->utility;
        $oModel->percentage14                   = ($SaleCost == null) ? null : $SaleCost->percentage14;

        return $oModel;
    }

    public static function fnStatusResults( $StatusResults, $idUserCourse )
    {   
        $time = strtotime($StatusResults["dateFinancialInformation"]);
        
        $oModel = new EmpStatusResult();       

        $oModel->idStatus                   = CStatus::$ACTIVO;
        $oModel->idUserCourse               = $idUserCourse;
        $oModel->complete                   = 1;

        $oModel->dateFinancialInformation   = ($StatusResults == null) ? null : date('Y-m-d H:i:s',$time);
        
        return $oModel;        
    }

    public static function fnSaleCost($SaleCost, $idStatusResults, $idAverage)
    {
        
        $oModel = new EmpSaleCostUtilityExpense();      

        $oModel->idStatus                       = CStatus::$ACTIVO;
        $oModel->idAverage                      = $idAverage;
        $oModel->idStatusResults                = $idStatusResults;

        $oModel->monthlySales                   = ($SaleCost == null) ? null : $SaleCost["monthlySales"];
        $oModel->percentage1                    = ($SaleCost == null) ? null : $SaleCost["percentage1"];
        $oModel->merchandiseRawMaterial         = ($SaleCost == null) ? null : $SaleCost["merchandiseRawMaterial"];
        $oModel->percentage2                    = ($SaleCost == null) ? null : $SaleCost["percentage2"];
        $oModel->wagesSalaries                  = ($SaleCost == null) ? null : $SaleCost["wagesSalaries"];
        $oModel->percentage3                    = ($SaleCost == null) ? null : $SaleCost["percentage3"];
        $oModel->rentalPremises                 = ($SaleCost == null) ? null : $SaleCost["rentalPremises"];
        $oModel->percentage4                    = ($SaleCost == null) ? null : $SaleCost["percentage4"];
        $oModel->stationeryVarious              = ($SaleCost == null) ? null : $SaleCost["stationeryVarious"];
        $oModel->percentage5                    = ($SaleCost == null) ? null : $SaleCost["percentage5"];
        $oModel->phone                          = ($SaleCost == null) ? null : $SaleCost["phone"];
        $oModel->percentage6                    = ($SaleCost == null) ? null : $SaleCost["percentage6"];
        $oModel->otherAdministrationExpenses    = ($SaleCost == null) ? null : $SaleCost["otherAdministrationExpenses"];
        $oModel->percentage7                    = ($SaleCost == null) ? null : $SaleCost["percentage7"];
        $oModel->gasolineLubricants             = ($SaleCost == null) ? null : $SaleCost["gasolineLubricants"];
        $oModel->percentage8                    = ($SaleCost == null) ? null : $SaleCost["percentage8"];
        $oModel->maintenance                    = ($SaleCost == null) ? null : $SaleCost["maintenance"];
        $oModel->percentage9                    = ($SaleCost == null) ? null : $SaleCost["percentage9"];
        $oModel->otherOperatingExpenses         = ($SaleCost == null) ? null : $SaleCost["otherOperatingExpenses"];
        $oModel->percentage10                   = ($SaleCost == null) ? null : $SaleCost["percentage10"];
        $oModel->netInterests                   = ($SaleCost == null) ? null : $SaleCost["netInterests"];
        $oModel->percentage11                   = ($SaleCost == null) ? null : $SaleCost["percentage11"];
        $oModel->ISR                            = ($SaleCost == null) ? null : $SaleCost["ISR"];
        $oModel->percentage12                   = ($SaleCost == null) ? null : $SaleCost["percentage12"];
        $oModel->totalCostsExpenses             = ($SaleCost == null) ? null : $SaleCost["totalCostsExpenses"];
        $oModel->percentage13                   = ($SaleCost == null) ? null : $SaleCost["percentage13"];
        $oModel->utility                        = ($SaleCost == null) ? null : $SaleCost["utility"];
        $oModel->percentage14                   = ($SaleCost == null) ? null : $SaleCost["percentage14"];

        return $oModel;
    }
    
}
