<?php
//Date: 24 May 2018 /
namespace App\Business\Emprende\Mappers;

//Models
use App\Models\Emprende\PropertyCapture;
use App\Models\Emprende\PatrimonialSupport;
use App\Models\Catalogs\CStatus;

class DataRespaldoPatrimonialMapper{   

    public static function fnPatrimonialSupport($oSupport,$idAvales, $valor){
       
        $oModel =  new PatrimonialSupport();  

        if ($valor == 1) {
            $oModel->idUser = $oSupport['idUser'];
            $oModel->idStatus = CStatus::$ACTIVO;
         }
         
         $oModel->idAvales = $oSupport['idAvales'];
         $oModel->proposedGuarantee = $oSupport['proposedGuarantee'];
         $oModel->nameGuarantee = $oSupport['nameGuarantee'];
         $oModel->typeEconomicSupport = $oSupport['typeEconomicSupport'];
         $oModel->totalValueProperty = $oSupport['totalValueProperty'];

        return $oModel;
    }
    public static function fnPropertyCapture($oSupport,$valor){

         $oModel =  new PropertyCapture();  
         if ($valor == 1) {
            $oModel->idUser = $oSupport['idUser'];
            $oModel->idStatus = CStatus::$ACTIVO;
         }

         $oModel->idProperty = $oSupport['idProperty'];
         $oModel->other = $oSupport['other'];
         $oModel->description = $oSupport['description'];
         $oModel->location = $oSupport['location'];
         $oModel->propertySheet = $oSupport['propertySheet'];
         $oModel->propertyTaxValue = $oSupport['propertyTaxValue'];
         
         return $oModel;
    }
}

    