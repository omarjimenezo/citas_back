<?php
//Date: 18 May 2018 /
namespace App\Business\Emprende\Mappers;

// Responses
use App\Http\Responses\Emprende\Inversion\DatosInversionResponse;
use App\Http\Responses\Emprende\Inversion\DatosDeudasResponse;
use App\Http\Responses\Emprende\Inversion\DatosTipoCreditoResponse;

//Models
use Carbon\Carbon;
use App\Models\Catalogs\CStatus;
use App\Models\EmpInvestmentProject;
use App\Models\EmpDebtToPay;
use App\Models\EmpTypeCredit;
use App\Models\EmpCreditData;




class DataInversionMapper{   

    public static function fnGetInversion($Inversion, $User)
    {
        $oModel = new DatosInversionResponse();       
        
        $oModel->name                   = $User->firstName . ' ' . $User->lastName . ' ' . $User->secondLastName;
        $time = strtotime(date('y-m-d h:i:s'));
        $oModel->date                   = ($Inversion == null) ? date('Y-m-d H:i:s',$time) : date('Y-m-d H:i:s', strtotime($Inversion->date));
        $oModel->totalValueInvestment   = ($Inversion == null) ? null : $Inversion->totalValueInvestment;
        $oModel->requestedCredit        = ($Inversion == null) ? null : $Inversion->requestedCredit;
        $oModel->contributionApplicant  = ($Inversion == null) ? null : $Inversion->contributionApplicant;
        $oModel->complete               = ($Inversion == null) ? null : $Inversion->complete;

        return $oModel;        
    }

    public static function fnGetDeudas($Deudas)
    {
        
        $oModel = new DatosDeudasResponse();      
        
        $oModel->name                   = ($Deudas == null) ? null : $Deudas->name;
        $oModel->creditNumberInvoices   = ($Deudas == null) ? null : $Deudas->creditNumberInvoices;
        $oModel->amountPayFojalCredit   = ($Deudas == null) ? null : $Deudas->amountPayFojalCredit;

        return $oModel;
    }
    
    public static function fnGetTipoCredito($TipoCredito, $amount)
    {
        $oModel = new DatosTipoCreditoResponse();      
        
        $oModel->description            = ($TipoCredito == null) ? null : $TipoCredito->description;
        $oModel->contributions          = ($TipoCredito == null) ? null : $TipoCredito->contributions;
        $oModel->amount                 = $amount;
        
        return $oModel;        
    }

    public static function fnInversion($oModel, $idUserCourse, $idCreditData)
    {
        $time = strtotime(date('y-m-d h:i:s'));

        $oInversion = new EmpInvestmentProject();
        
        $oInversion->idStatus       = CStatus::$ACTIVO;
		$oInversion->idUserCourse   = $idUserCourse;
        $oInversion->complete       = 1;
        $oInversion->date           = date('Y-m-d H:i:s',$time);
        
		$oInversion->idCreditData           = $idCreditData;
		$oInversion->totalValueInvestment   = $oModel["totalValueInvestment"];
		$oInversion->requestedCredit        = $oModel["requestedCredit"];
        $oInversion->contributionApplicant  = $oModel["contributionApplicant"];
        
        return $oInversion;
    }

    public static function fnDeudas($oModel, $idInvestmentProject, $idDescriptionDebt)
    {
        $oDeudas = new EmpDebtToPay();
        
        $oDeudas->idStatus = CStatus::$ACTIVO;
        
		$oDeudas->idInvestmentProject   = $idInvestmentProject;
		$oDeudas->idDescriptionDebt     = $idDescriptionDebt;
		$oDeudas->name                  = $oModel["name"];
		$oDeudas->creditNumberInvoices  = $oModel["creditNumberInvoices"];
        $oDeudas->amountPayFojalCredit  = $oModel["amountPayFojalCredit"];   
        
        return $oDeudas;
    }

    public static function fnCreditos($oModel, $idInvestmentProject, $idTypeCredit)
    {
        $oCredito = new EmpTypeCredit();

        $oCredito->idStatus = CStatus::$ACTIVO;

        $oCredito->idInvestmentProject  = $idInvestmentProject;
		$oCredito->idTypeCredit         = $idTypeCredit;
		$oCredito->description          = $oModel["description"];
		$oCredito->contributions        = $oModel["contributions"];

        return $oCredito;
    }

}
