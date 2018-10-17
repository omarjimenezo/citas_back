<?php
//Date: 18 May 2018 /
namespace App\Business\Emprende\Mappers;

// Responses
use App\Http\Responses\Emprende\TablaPagos\DatosTablaPagosResponse;
use App\Http\Responses\Emprende\TablaPagos\DatosTipoCreditoResponse;
use App\Http\Responses\Emprende\TablaPagos\DataTypeCreditResponse;

//Models
use Carbon\Carbon;
use App\Models\Catalogs\CStatus;
use App\Models\EmpAmortizationTable;
use App\Models\EmpCreditsDestination;


class DataTablaPagosMapper{   

    public static function fnGetPaymentsTable( $PaymentsResults )
    {
        $oModel = new DatosTablaPagosResponse();       
        
        $oModel->period     = $PaymentsResults['period'];
        $oModel->balance    = $PaymentsResults['balance'];
        $oModel->interest   = $PaymentsResults['interest'];
        $oModel->capital    = $PaymentsResults['capital'];
        $oModel->payment    = $PaymentsResults['payment'];

        return $oModel;        
    }

    public static function fnGetTipoCredito($TipoCredito)
    {
        $oModel = new DatosTipoCreditoResponse();      
        
        $oModel->amount         = ($TipoCredito == null) ? null : $TipoCredito->amount;
        $oModel->timeLimit      = ($TipoCredito == null) ? null : $TipoCredito->timeLimit;       
        $oModel->interestRate   = ($TipoCredito == null) ? null : $TipoCredito->interestRate;
        $oModel->payment        = ($TipoCredito == null) ? null : $TipoCredito->payment;
        
        return $oModel;        
    }
    
    public static function fnGetTypeCredit($id,$idAmount,$amount, $timeLimit,$payment)
    {
        $oModel = new EmpCreditsDestination(); 

        $oModel->idStatus                   = CStatus::$ACTIVO;
        $oModel->idAmortizationTable        = $id;
        $oModel->idAmount                   = $idAmount;
        $oModel->amount                     = $amount;
        $oModel->timeLimit                  = $timeLimit;       
        $oModel->interestRate               = 12;
        $oModel->payment                    = $payment;
        
        return $oModel;        
    }

        
    public static function fnSaveAmortizacion($idUserCourse)
    {
        $oModel = new EmpAmortizationTable();   

        $oModel->idStatus        = CStatus::$ACTIVO;
        $oModel->idUserCourse    = $idUserCourse;

        return $oModel;        
    }


    
}
