<?php
//Date: 16 May 2018 / Ede nuñez
namespace App\Business\Emprende\Queries;

// Mappers
use App\Business\Emprende\Mappers\DataBalanceGeneralMapper;
//Repositories
use App\Business\Emprende\Repositories\EstadoResultados\EstadoResultadosRepository;
use App\Business\Emprende\Repositories\BalanceGeneral\CurrentAssetsRepository;
use App\Business\Emprende\Repositories\BalanceGeneral\DeferredAssetsRepository;
use App\Business\Emprende\Repositories\BalanceGeneral\FixedAssetRepository;
use App\Business\Emprende\Repositories\BalanceGeneral\GeneralBalanceRepository;
use App\Business\Emprende\Repositories\BalanceGeneral\PassiveAccountingCapitalRepository;
use App\Business\Emprende\Repositories\BalanceGeneral\PassiveLongTermRepository;
use App\Business\Emprende\Repositories\BalanceGeneral\PassiveNotReportedRepository;
use App\Business\Emprende\Repositories\BalanceGeneral\PassiveShortTermRepository;
// MOdels
use App\Models\Catalogs\CStatus;

class BalanceGeneralQuery{   

    public static function fnGetBalance($idUserCourse, $oUser){

        
         // obtiene los datos de balance general por el id de usuariocurso
        $oGeneral = GeneralBalanceRepository::fnAByUser($idUserCourse)->first();
        $oGeneralNew = DataBalanceGeneralMapper::fnGetGeneral($oGeneral, $oUser);

        // obtiene los datos de  pasivos a traves del idCurrentAssets
        $oCurrent= CurrentAssetsRepository::fnfind(($oGeneral == null)? null :$oGeneral->idCurrentAssets)->first();
        $oCurrentNew = DataBalanceGeneralMapper::fnGetCurrentAssets($oCurrent);

         // obtiene los datos de  pasivos fijo a traves del idFixedAsset  
        $oFixed= FixedAssetRepository::fnfind(($oGeneral == null)? null :$oGeneral->idFixedAsset)->first();
        $oFixedNew = DataBalanceGeneralMapper::fnGetFixedAsset($oFixed);

         // obtiene los datos de  pasivos diferido a traves del idDeferredAssets
        $oDeferred= DeferredAssetsRepository::fnfind(($oGeneral == null)? null :$oGeneral->idDeferredAssets)->first();
        $oDeferredNew = DataBalanceGeneralMapper::fnGetDeferredAssets($oDeferred);

        // obtiene los datos de  pasivos corto plazo a traves del idPassiveShortTerm
        $oPassiveShort= PassiveShortTermRepository::fnfind(($oGeneral == null)? null :$oGeneral->idPassiveShortTerm)->first();
        $oPassiveShortNew = DataBalanceGeneralMapper::fnGetPassiveShortTerm($oPassiveShort);

         // obtiene los datos de  pasivos largo plazo a traves del idPassiveLongTerm
        $oPassiveLong= PassiveLongTermRepository::fnfind(($oGeneral == null)? null :$oGeneral->idPassiveLongTerm)->first();
        $oPassiveLongNew = DataBalanceGeneralMapper::fnGetPassiveLongTerm($oPassiveLong);

        // obtiene los datos de  pasivos capital contable a traves del idPassiveAccountingCapital
        $oPassiveAccount= PassiveAccountingCapitalRepository::fnfind(($oGeneral == null)? null :$oGeneral->idPassiveAccountingCapital)->first();
        $oMensual = self::fngetSaleCost($idUserCourse,1);
        $oEsperado = self::fngetSaleCost($idUserCourse,2);
        
        $utility = ($oMensual != null) ? $oMensual->utility : ($oMensual != null) ? $oEsperado->utility : 0;
        $oPassiveAccountNew = DataBalanceGeneralMapper::fnGetPassiveAccountingCapital($oPassiveAccount,$utility);
        
        // obtiene los datos de  pasivos no reportados a traves del idPassiveNotReported
        $oPassiveNot= PassiveNotReportedRepository::fnfind(($oGeneral == null)? null :$oGeneral->idPassiveNotReported)->first();
        $oPassiveNotNew = DataBalanceGeneralMapper::fnGetPassiveNotReported($oPassiveNot);

        // arma el json de datos
       return array_merge([ "general_balance"               => $oGeneralNew,
                            "assets"                        => ["current_assets" => $oCurrentNew, 
                                                                "fixed_asset" => $oFixedNew, 
                                                                "deferred_assets" => $oDeferredNew],
                            "passive"                       => ["passive_short_term" => $oPassiveShortNew, 
                                                                "passive_long_term" => $oPassiveLongNew],
                            "passive_accounting_capital"    => $oPassiveAccountNew,
                            "passive_not_reported"          => $oPassiveNotNew]);
    }	

    public static function fnSaveBalance($oModel, $idUserCourse,$oUser){
      
        // Mappers
        $oCurrentNew        = DataBalanceGeneralMapper::fnSaveCurrentAssets($oModel['assets']['current_assets']);
        $oFixedNew          = DataBalanceGeneralMapper::fnSaveFixedAsset($oModel['assets']['fixed_asset']);
        $oDeferredNew       = DataBalanceGeneralMapper::fnSaveDeferredAssets($oModel['assets']['deferred_assets']);
        $oPassiveShortNew   = DataBalanceGeneralMapper::fnSavePassiveShortTerm($oModel['passive']['passive_short_term']);
        $oPassiveLongNew    = DataBalanceGeneralMapper::fnSavePassiveLongTerm($oModel['passive']['passive_long_term']);
        $oPassiveAccountNew = DataBalanceGeneralMapper::fnSavePassiveAccountingCapital($oModel['passive_accounting_capital']);
        $oPassiveNotNew     = DataBalanceGeneralMapper::fnSavePassiveNotReported($oModel['passive_not_reported']);

        // Guardar
        $oCurrent           = CurrentAssetsRepository::fnSave($oCurrentNew);
        $oFixed             = FixedAssetRepository::fnSave($oFixedNew);
        $oDeferred          = DeferredAssetsRepository::fnSave($oDeferredNew);
        $oPassiveShort      = PassiveShortTermRepository::fnSave($oPassiveShortNew);
        $oPassiveLong       = PassiveLongTermRepository::fnSave($oPassiveLongNew);
        $oPassiveAccount    = PassiveAccountingCapitalRepository::fnSave($oPassiveAccountNew);
        $oPassiveNot        = PassiveNotReportedRepository::fnSave($oPassiveNotNew);   
        

        $oGeneralNew = DataBalanceGeneralMapper::fnSaveGeneral($idUserCourse,
                                                               $oCurrent->id,
                                                               $oFixed->id,
                                                               $oDeferred->id,
                                                               $oPassiveShort->id,
                                                               $oPassiveLong->id,
                                                               $oPassiveAccount->id,
                                                               $oPassiveNot->id);

        $oGeneral = GeneralBalanceRepository::fnSave($oGeneralNew);
        
        return self::fnGetBalance($idUserCourse, $oUser);
    }	

    public static function fngetSaleCost($idUserCourse, $val){
        // Queries
        $oStatusResultsData = EstadoResultadosRepository::fnAllByUser( $idUserCourse )->first();
        if($oStatusResultsData == null)
            return null;
        $saleCost = EstadoResultadosRepository::fnSaleCost($val, $oStatusResultsData->id)->first();
        return ($saleCost == null) ? null : $saleCost;
    }
}