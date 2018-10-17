<?php

namespace App\Business\Academia\Queries;
use App\Models\AdmAcaNotification;
use App\Models\AdmAcaCNotification;

use App\Business\Academia\Mappers\NotificationsMapper;
use App\Http\Responses\Academia\Profile\ProfileResponse;
use App\Http\Responses\Academia\Profile\TelephoneResponse;

//Hash
use Illuminate\Support\Facades\Hash;


class NotificationsQuery
{
    //Extrae la lista de notificaciones del usuario actual. //$skip = registros que se va a saltar.
    public static function fnGetLstNotifications($id, $skip)
    {
        $oModel = AdmAcaNotification::select('id', 'idNotification', 'idUser', 'idAffirmationDenial', 'created_at')
                                    ->with(['adm_aca_c_notification' => function($query){
                                        $query->select('id', 'name', 'icon_img', 'idModule')
                                        ->with(['aca_c_module' => function($query){
                                            $query->select('id', 'name')->first();
                                        }]);
                                    }])->where('idUser', $id)->skip($skip)->take(5)->get();

        $oNotificationsResponse = NotificationsMapper::fnMatchDataToNotificationsResponse($oModel, $id);

        return $oNotificationsResponse;
    }

    //Extrae la lista de las notificaciones que no han sido leidas.
    public static function fnGetNotificationsIsnotRead($id)
    {
        $oModel = AdmAcaNotification::where('idUser', $id)->where('idAffirmationDenial', 2)->get();
        
        return $oModel;
    }

    //Extrae el detalle de cada notificacion solicitada.
    public static function fnGetNotificationDetailById($idNotification)
    {
        $oNotificationDetail = AdmAcaNotification::select('id', 'idNotification', 'idUser', 'idAffirmationDenial')
                                    ->with(['adm_aca_c_notification' => function($query){
                                        $query->select('id', 'idModule', 'name', 'detail_img', 'description')
                                        ->with(['aca_c_module' => function($query){
                                            $query->select('id', 'name')->first();
                                        }]);
                                    }])->where('id', $idNotification)->first();

                                    dd($oNotificationDetail->toJson());
        $oNotificationDetail = NotificationsMapper::fnMatchDataDetailToNotificationsResponse($oNotificationDetail);

        return $oNotificationDetail;
    }

    public static function fnGetNotificationsNotReadTotal($id)
    {
        $oModel = AdmAcaNotification::where('idUser', $id)->where('idAffirmationDenial', 2)->count();

        return $oModel;
    }
}
