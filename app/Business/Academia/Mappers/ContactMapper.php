<?php

namespace App\Business\Academia\Mappers;


use App\Http\Responses\Academia\Contact\ContactResponse;



class ContactMapper
{
    public static function fnMatchData($oModel)
    {
        $oContactResponse = new ContactResponse();
        
        $dataArray = Array();
        $count = 0;
        foreach($oModel as $model)
        {
            $dataArray[$count] = $model->ValueConfig;
            $count++;
        }

        $oContacResponse->calle = $dataArray[1];
        $oContacResponse->numero = $dataArray[2];
        $oContacResponse->colonia = $dataArray[3];
        $oContacResponse->ciudad = $dataArray[4];
        $oContacResponse->cp = $dataArray[5];
        $oContacResponse->estado = $dataArray[6];
        $oContacResponse->pais = $dataArray[7];
        $oContacResponse->numeroCelular = $dataArray[8];
        $oContacResponse->correoElectronico = $dataArray[9];
        $oContacResponse->latitud = $dataArray[10];
        $oContacResponse->longitud = $dataArray[11];
        $oContacResponse->descripcionContacto = $dataArray[12];

        return $oContactResponse;
    }

}