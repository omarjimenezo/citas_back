<?php
//Date: 18 May 2018 /
namespace App\Business\Emprende\Mappers;
// Responses
use App\Http\Responses\Emprende\Negocio\DataNegocioResponse;
//Models
use App\Models\Catalogs\CStatus;
use App\Models\Emprende\AcaUserFile;




class DataUserFileMapper{   


    public static function fnGetFiles($oFiles){

        $oModel = new UserFile();

        $oModel->workingCapitalCredit = ($oFiles == null) ? null : $oFiles->workingCapitalCredit;
        $oModel->equipmentCredit = ($oFiles == null) ? null : $oFiles->equipmentCredit;
        $oModel->infrastructureCredit = ($oFiles == null) ? null : $oFiles->infrastructureCredit;
        $oModel->passivePaymentCredit = ($oFiles == null) ? null : $oFiles->passivePaymentCredit;
     
        return $oModel;
    }

    public static function fnSaveFile($idFileName,$pathFile, $idUser,$idGuarante){

        $oModel = new UserFile();

        $oModel->idStatus = CStatus::$ACTIVO;
        $oModel->idUser = $idUser;
        $oModel->idParticipantsGuarantee = $idGuarante;
        $oModel->idFileName = $idFileName;
        $oModel->pathFile = $pathFile;
        
        return $oModel;
    }
}
