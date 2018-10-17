<?php
/**
 * Created by PhpStorm.
 * User: Bioxor
 * Date: 08/06/2018
 * Time: 11:36 AM
 */

namespace App\Business\Emprende\Mappers;


use App\Http\Responses\Emprende\Solicitante\preAuthorizationNegativeModel;
use App\Models\AcaUserAcademy;
use App\Models\Emprende\CustomAcaUserAcademy;
use Carbon\Carbon;

class DataCreatePdfMapper
{
    public static function DataAcaUserAcademy($id){
        $oModel = new preAuthorizationNegativeModel();
        $oUserAcademy = AcaUserAcademy::where('id', '=', $id)
            ->with('c_municipality')
            ->first();
        $oModel->nombreSolicitante = $oUserAcademy->firstName . " " . $oUserAcademy->secondName . " " . $oUserAcademy->lastName . " " . $oUserAcademy->secondLastName;
        $oModel->domicilio = $oUserAcademy->street;
        $oModel->colonia = $oUserAcademy->colony;
        $oModel->codigo_postal = $oUserAcademy->postalCode;
        $oModel->municipio = $oUserAcademy->c_municipality->municipality;
        $dt = Carbon::now();
        $oModel->año = $dt->year;
        $oModel->dia = $dt->day;
        $oModel->mes = $dt->month;
        $oModel->locality = $oUserAcademy->cityLocality;
        return array('oModel'=>$oModel,'oUserAcademy'=>$oUserAcademy);
    }

}