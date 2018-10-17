<?php

namespace App\Business\Academia\Mappers;
use App\Http\Responses\Academia\Session\CourseModel;
use App\Http\Responses\Academia\Session\GroupModel;
use App\Http\Responses\Academia\Session\SessionModel;
use App\Http\Responses\Academia\Session\SessionResponse;
class SessionMapper
{
    public static function fnMatchDatasessionResponse($oGroup)
    {   
        $oCourseModel = new CourseModel();
        $oCourseModel->id = $oGroup->adm_aca_course->id;
        $oCourseModel->name = $oGroup->adm_aca_course->name;;
        $oCourseModel->description = $oGroup->adm_aca_course->description;

        $oGroupModel = new GroupModel();
        $oGroupModel->id = $oGroup->id;
        $oGroupModel->name = $oGroup->name;;
        $sDays = "";
        for ($i = 0; $i < count($oGroup->adm_aca_group_days); $i++) {
            if($i == count($oGroup->adm_aca_group_days)-1){
                $sDays = $sDays.' y '.$oGroup->adm_aca_group_days[$i]['name'];
            }else {
                $sDays = $sDays.' '.$oGroup->adm_aca_group_days[$i]['name'];
            }
        }
        $oGroupModel->days = $sDays;
        $oGroupModel->schedule = $oGroup->c_aca_schedule->name;
        $oGroupModel->start_date = $oGroup->start_date === null? null : $oGroup->start_date->format('Y-m-d H:i:s');
        $oGroupModel->end_date = $oGroup->end_date === null? null : $oGroup->end_date->format('Y-m-d H:i:s');
        $oGroupModel->total_hours = 0;
        $lstSesionsModel= [];
        $iTotal = 0;
        for ($i = 0; $i < count($oGroup->adm_aca_group_sessions); $i++) {
            $oSession= new SessionModel();
            $oSession->id = $oGroup->adm_aca_group_sessions[$i]->adm_aca_session->id;
            $oSession->name = $oGroup->adm_aca_group_sessions[$i]->adm_aca_session->name;
            $oSession->temary = $oGroup->adm_aca_group_sessions[$i]->adm_aca_session->temary;
            $oSession->duration = $oGroup->adm_aca_group_sessions[$i]->adm_aca_session->duration;
            $oSession->startDate = $oGroup->adm_aca_group_sessions[$i]->startDate === null? null :$oGroup->adm_aca_group_sessions[$i]->startDate->format('Y-m-d H:i:s');
            $oSession->endDate =$oGroup->adm_aca_group_sessions[$i]->endDate === null? null : $oGroup->adm_aca_group_sessions[$i]->endDate->format('Y-m-d H:i:s');
            array_push($lstSesionsModel,$oSession);
            $oGroupModel->total_hours = $oGroupModel->total_hours + $oSession->duration;
            $iTotal ++;
        }
        $oGroupModel->total_session = $iTotal;
        
        $oSessionResponse = new SessionResponse();
        $oSessionResponse->oCourse = $oCourseModel;
        $oSessionResponse->oGroup = $oGroupModel;
        $oSessionResponse->lstSessions = $lstSesionsModel;
        return $oSessionResponse;
    }

}