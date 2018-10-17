<?php
//Date: 18 May 2018 /
namespace App\Business\Emprende\Mappers;
// Responses
use App\Http\Responses\Emprende\Negocio\DataNegocioResponse;
//Models
use App\Models\Catalogs\CStatus;
use App\Models\EmpGeneralBalance;
use App\Models\EmpCurrentAsset;
use App\Models\EmpFixedAsset;
use App\Models\EmpDeferredAsset;
use App\Models\EmpPassiveShortTerm;
use App\Models\EmpPassiveLongTerm;
use App\Models\EmpPassiveAccountingCapital;
use App\Models\EmpPassiveNotReported;




class DataBalanceGeneralMapper{   

    public static function fnGetGeneral($oGeneral, $oUser){
       
        $oModel = new EmpGeneralBalance();

        $oModel->name       = $oUser->firstName. " ". $oUser->lastName. " ".$oUser->secondLastName;

        $oModel->complete   = ($oGeneral == null) ? null : $oGeneral->complete;
        $oModel->date       = ($oGeneral == null) ? date('Y-m-d H:i:s', strtotime("now")) : date('Y-m-d H:i:s', strtotime($oGeneral->date));
      
        return $oModel;
    }

    public static function fnSaveGeneral($idUserCourse,$idCurrentAssets,
                                         $idFixedAsset,$idDeferredAssets,
                                         $idPassiveShortTerm,$idPassiveLongTerm,
                                         $idPassiveAccountingCapital,$idPassiveNotReported){

         $oModel = new EmpGeneralBalance();
         
         $time = strtotime(date('y-m-d h:i:s'));

         $oModel->idStatus                      = CStatus::$ACTIVO;
         $oModel->idUserCourse                  = $idUserCourse;
         $oModel->date                          = date('Y-m-d H:i:s',$time);
		 $oModel->idCurrentAssets               = $idCurrentAssets;
		 $oModel->idFixedAsset                  = $idFixedAsset;
		 $oModel->idDeferredAssets              = $idDeferredAssets;
		 $oModel->idPassiveShortTerm            = $idPassiveShortTerm;
		 $oModel->idPassiveLongTerm             = $idPassiveLongTerm;
		 $oModel->idPassiveAccountingCapital    = $idPassiveAccountingCapital;
		 $oModel->idPassiveNotReported          = $idPassiveNotReported;
         $oModel->complete                      = true;
      
        return $oModel;
    }

    public static function fnGetCurrentAssets($Current){

        $oModel = new EmpCurrentAsset();

        $oModel->boxesBanks         = ($Current == null) ? null : $Current->boxesBanks;
        $oModel->percentage1        = ($Current == null) ? null : $Current->percentage1;
        $oModel->accountsReceivable = ($Current == null) ? null : $Current->accountsReceivable;
        $oModel->percentage2        = ($Current == null) ? null : $Current->percentage2;
        $oModel->inventory          = ($Current == null) ? null : $Current->inventory;
        $oModel->percentage3        = ($Current == null) ? null : $Current->percentage3;
        $oModel->totalCurrentAssets = ($Current == null) ? null : $Current->totalCurrentAssets;
        $oModel->percentage4        = ($Current == null) ? null : $Current->percentage4;

        return $oModel;
    }

    public static function fnSaveCurrentAssets($Current){

        $oModel = new EmpCurrentAsset();

        $oModel->idStatus           = CStatus::$ACTIVO;
        $oModel->boxesBanks         =  $Current["boxesBanks"];
        $oModel->percentage1        =  $Current["percentage1"];
        $oModel->accountsReceivable =  $Current["accountsReceivable"];
        $oModel->percentage2        =  $Current["percentage2"];
        $oModel->inventory          =  $Current["inventory"];
        $oModel->percentage3        =  $Current["percentage3"];
        $oModel->totalCurrentAssets =  $Current["totalCurrentAssets"];
        $oModel->percentage4        =  $Current["percentage4"];

        return $oModel;
    }

    public static function fnGetFixedAsset($Fixed){

        $oModel = new EmpFixedAsset();

        $oModel->immovables                 = ($Fixed == null) ? null : $Fixed->immovables;
        $oModel->percentage1                = ($Fixed == null) ? null : $Fixed->percentage1;
        $oModel->machineryWorkEquipment     = ($Fixed == null) ? null : $Fixed->machineryWorkEquipment;
        $oModel->percentage2                = ($Fixed == null) ? null : $Fixed->percentage2;
        $oModel->furnitureOfficeEquipment   = ($Fixed == null) ? null : $Fixed->furnitureOfficeEquipment;
        $oModel->percentage3                = ($Fixed == null) ? null : $Fixed->percentage3;
        $oModel->transportationEquipment    = ($Fixed == null) ? null : $Fixed->transportationEquipment;
        $oModel->percentage4                = ($Fixed == null) ? null : $Fixed->percentage4;
        $oModel->accumulatedDepreciation    = ($Fixed == null) ? null : $Fixed->accumulatedDepreciation;
        $oModel->percentage5                = ($Fixed == null) ? null : $Fixed->percentage5;
        $oModel->totalFixedAsset            = ($Fixed == null) ? null : $Fixed->totalFixedAsset;
        $oModel->percentage6                = ($Fixed == null) ? null : $Fixed->percentage6;

        return $oModel;
    }

    public static function fnSaveFixedAsset($Fixed){

        $oModel = new EmpFixedAsset();

        $oModel ->idStatus                  = CStatus::$ACTIVO;
        $oModel->immovables                 = $Fixed["immovables"];
        $oModel->percentage1                = $Fixed["percentage1"];
        $oModel->machineryWorkEquipment     = $Fixed["machineryWorkEquipment"];
        $oModel->percentage2                = $Fixed["percentage2"];
        $oModel->furnitureOfficeEquipment   = $Fixed["furnitureOfficeEquipment"];
        $oModel->percentage3                = $Fixed["percentage3"];
        $oModel->transportationEquipment    = $Fixed["transportationEquipment"];
        $oModel->percentage4                = $Fixed["percentage4"];
        $oModel->accumulatedDepreciation    = $Fixed["accumulatedDepreciation"];
        $oModel->percentage5                = $Fixed["percentage5"];
        $oModel->totalFixedAsset            = $Fixed["totalFixedAsset"];
        $oModel->percentage6                = $Fixed["percentage6"];

        return $oModel;
    }


    public static function fnGetDeferredAssets($Deferred){

        $oModel = new EmpDeferredAsset();
        
        $oModel->installationCosts      = ($Deferred == null) ? null : $Deferred->installationCosts;
        $oModel->percentage1            = ($Deferred == null) ? null : $Deferred->percentage1;
        $oModel->otherAssets            = ($Deferred == null) ? null : $Deferred->otherAssets;
        $oModel->percentage2            = ($Deferred == null) ? null : $Deferred->percentage2;
        $oModel->totalDeferredAssets    = ($Deferred == null) ? null : $Deferred->totalDeferredAssets;
        $oModel->percentage3            = ($Deferred == null) ? null : $Deferred->percentage3;
       
        return $oModel;
    }

    public static function fnSaveDeferredAssets($Deferred){

        $oModel = new EmpDeferredAsset();
        
        $oModel ->idStatus              = CStatus::$ACTIVO;
        $oModel->installationCosts      = $Deferred["installationCosts"];
        $oModel->percentage1            = $Deferred["percentage1"];
        $oModel->otherAssets            = $Deferred["otherAssets"];
        $oModel->percentage2            = $Deferred["percentage2"];
        $oModel->totalDeferredAssets    = $Deferred["totalDeferredAssets"];
        $oModel->percentage3            = $Deferred["percentage3"];
       
        return $oModel;
    }

    public static function fnGetPassiveShortTerm($PassiveShort){

        $oModel = new EmpPassiveShortTerm();
        
        $oModel->bankLoans              = ($PassiveShort == null) ? null : $PassiveShort->bankLoans;
        $oModel->percentage1            = ($PassiveShort == null) ? null : $PassiveShort->percentage1;
        $oModel->provider               = ($PassiveShort == null) ? null : $PassiveShort->provider;
        $oModel->percentage2            = ($PassiveShort == null) ? null : $PassiveShort->percentage2;
        $oModel->otherAssets            = ($PassiveShort == null) ? null : $PassiveShort->otherAssets;
        $oModel->percentage3            = ($PassiveShort == null) ? null : $PassiveShort->percentage3;
        $oModel->totalPassiveShortTerm  = ($PassiveShort == null) ? null : $PassiveShort->totalPassiveShortTerm;
        $oModel->percentage4            = ($PassiveShort == null) ? null : $PassiveShort->percentage4;
      
       
        return $oModel;

    }


    public static function fnSavePassiveShortTerm($PassiveShort){

        $oModel = new EmpPassiveShortTerm();

        $oModel->idStatus               = CStatus::$ACTIVO;
        $oModel->bankLoans              = $PassiveShort["bankLoans"];
        $oModel->percentage1            = $PassiveShort["percentage1"];
        $oModel->provider               = $PassiveShort["provider"];
        $oModel->percentage2            = $PassiveShort["percentage2"];
        $oModel->otherAssets            = $PassiveShort["otherAssets"];
        $oModel->percentage3            = $PassiveShort["percentage3"];
        $oModel->totalPassiveShortTerm  = $PassiveShort["totalPassiveShortTerm"];
        $oModel->percentage4            = $PassiveShort["percentage4"];
      
       
        return $oModel;

    }

    public static function fnGetPassiveLongTerm($PassiveLong){

        $oModel = new EmpPassiveLongTerm();

        $oModel->bankLoans              = ($PassiveLong == null) ? null : $PassiveLong->bankLoans;
        $oModel->percentage1            = ($PassiveLong == null) ? null : $PassiveLong->percentage1;
        $oModel->otherAssets            = ($PassiveLong == null) ? null : $PassiveLong->otherAssets;
        $oModel->percentage2            = ($PassiveLong == null) ? null : $PassiveLong->percentage2;
        $oModel->totalPassiveLongTerm   = ($PassiveLong == null) ? null : $PassiveLong->totalPassiveLongTerm;     
        $oModel->percentage3            = ($PassiveLong == null) ? null : $PassiveLong->percentage3;
      
        return $oModel;

    }
    
    public static function fnSavePassiveLongTerm($PassiveLong){

        $oModel = new EmpPassiveLongTerm();

        $oModel ->idStatus              = CStatus::$ACTIVO;
        $oModel->bankLoans              = $PassiveLong["bankLoans"];
        $oModel->percentage1            = $PassiveLong["percentage1"];
        $oModel->otherAssets            = $PassiveLong["otherAssets"];
        $oModel->percentage2            = $PassiveLong["percentage2"];
        $oModel->totalPassiveLongTerm   = $PassiveLong["totalPassiveLongTerm"];     
        $oModel->percentage3            = $PassiveLong["percentage3"];
      
        return $oModel;

    }

    public static function fnGetPassiveAccountingCapital($PassiveAccount, $utility){

        $oModel = new EmpPassiveAccountingCapital();

        $oModel->patrimony                      = ($PassiveAccount == null) ? null : $PassiveAccount->patrimony;
        $oModel->percentage1                    = ($PassiveAccount == null) ? null : $PassiveAccount->percentage1;
        $oModel->periodUtility                  = ($PassiveAccount == null) ? $utility : $PassiveAccount->periodUtility;
        $oModel->percentage2                    = ($PassiveAccount == null) ? null : $PassiveAccount->percentage2;
        $oModel->totalPassiveAccountingCapital  = ($PassiveAccount == null) ? null : $PassiveAccount->totalPassiveAccountingCapital;     
        $oModel->percentage3                    = ($PassiveAccount == null) ? null : $PassiveAccount->percentage3;
      
        return $oModel;
    }

    public static function fnSavePassiveAccountingCapital($PassiveAccount){

        $oModel = new EmpPassiveAccountingCapital();

        $oModel ->idStatus                      = CStatus::$ACTIVO;
        $oModel->patrimony                      = $PassiveAccount["patrimony"];
        $oModel->percentage1                    = $PassiveAccount["percentage1"];
        $oModel->periodUtility                  = $PassiveAccount["periodUtility"];
        $oModel->percentage2                    = $PassiveAccount["percentage2"];
        $oModel->totalPassiveAccountingCapital  = $PassiveAccount["totalPassiveAccountingCapital"];     
        $oModel->percentage3                    = $PassiveAccount["percentage3"];
      
        return $oModel;
    }


    public static function fnGetPassiveNotReported($PassiveNot){

        $oModel = new EmpPassiveNotReported();

        $oModel->debtsBureauPayOneYear      = ($PassiveNot == null) ? null : $PassiveNot->debtsBureauPayOneYear;
        $oModel->debtsBureauPayMoreOneYear  = ($PassiveNot == null) ? null : $PassiveNot->debtsBureauPayMoreOneYear;
        $oModel->monthlyMortgagePayment     = ($PassiveNot == null) ? null : $PassiveNot->monthlyMortgagePayment;

        return $oModel;
    }


    public static function fnSavePassiveNotReported($PassiveNot){

        $oModel = new EmpPassiveNotReported();

        $oModel->idStatus                   = CStatus::$ACTIVO;
        $oModel->debtsBureauPayOneYear      = $PassiveNot["debtsBureauPayOneYear"];
        $oModel->debtsBureauPayMoreOneYear  = $PassiveNot["debtsBureauPayMoreOneYear"];
        $oModel->monthlyMortgagePayment     = $PassiveNot["monthlyMortgagePayment"];

        return $oModel;
    }

}
