<?php

namespace App\Business\Academia\Mappers;

use App\Http\Responses\Academia\Notifications\NotificationModel;
use App\Http\Responses\Academia\Notifications\NotificationsResponse;
use App\Business\Academia\Queries\NotificationsQuery;




class NotificationsMapper
{
    public static function fnMatchDataToNotificationsResponse($oModel, $id)
    {
        $oNotificationsResponse = new NotificationsResponse();
        $lstNotifications = Collect();

        $oNotificationsResponse->totalNotRead = NotificationsQuery::fnGetNotificationsNotReadTotal($id);
        foreach($oModel as $model)
        {
            $oNotificationModel = new NotificationModel();
            $oNotificationModel->idNotification = $model->id;
            $oNotificationModel->NotificationDate = $model->created_at->format('Y-m-d H:i:s');
            $oNotificationModel->idCnotification = $model->idNotification;
            $oNotificationModel->NotificationName = $model->adm_aca_c_notification->name;
            $oNotificationModel->NotificationImage = $model->adm_aca_c_notification->icon_img;
            $oNotificationModel->NotificationModule = $model->adm_aca_c_notification->aca_c_module->name;
            if($model->idAffirmationDenial == 1)
                $oNotificationModel->NotificationRead = true;
            else if($model->idAffirmationDenial == 2)
                $oNotificationModel->NotificationRead = false;
            $lstNotifications->push($oNotificationModel);
        }

        $oNotificationsResponse->lstNotifications = $lstNotifications;
        
        return $oNotificationsResponse;
    }

    public static function fnMatchDataDetailToNotificationsResponse($model)
    {
        $oNotificationModel = new NotificationModel();

        if($model !=  null)
        {
            $oNotificationModel->idNotification = $model->id;
            $oNotificationModel->idCnotification = $model->idNotification;
            $oNotificationModel->NotificationName = $model->adm_aca_c_notification->name;
            $oNotificationModel->NotificationDescription = $model->adm_aca_c_notification->description;
            $oNotificationModel->NotificationDetailImg = $model->adm_aca_c_notification->detail_img;
            $oNotificationModel->NotificationModule = $model->adm_aca_c_notification->aca_c_module->name;
            if($model->idAffirmationDenial == 1)
                $oNotificationModel->NotificationRead = true;
            else if($model->idAffirmationDenial == 2)
                $oNotificationModel->NotificationRead = false;
        }

        return $oNotificationModel;
    }

}