<?php

namespace App\Business\Academia\Mappers;

use App\Http\Responses\Academia\MyQualifications\MyQualificationsModel;
use App\Http\Responses\Academia\MyQualifications\MyQualificationsResponse;
use App\Business\Academia\Queries\MyQualificationsQuery;




class MyQualificationsMapper
{
    public static function fnMatchDataMyQualificationsResponse($oModel)
    {
        $lstQualificationsByCourse = Collect();

        $contador = 0;
        foreach($oModel as $model)
        {
            $oCoursesData = MyQualificationsQuery::fnGetCourseData($model->id);
            foreach($oCoursesData as $oCourseData)
            {
                $contador++;
                $oMyQualifications = new MyQualificationsModel();
                $oMyQualifications->idUser = $model->idUser;
                $oMyQualifications->idUserCourse = $model->idCourse;
                $oPerson = MyQualificationsQuery::fnGetTeacherDateByIdUserTeacher($oCourseData->adm_aca_group_session->adm_aca_group->idUserTeacher);
                $oMyQualifications->id_AdmAcaModel = $oCourseData->adm_aca_group_session->adm_aca_group->adm_aca_course->adm_aca_model->id;
                $oMyQualifications->name_AdmAcaCourse = $oCourseData->adm_aca_group_session->adm_aca_group->adm_aca_course->name;
                $oMyQualifications->name_AdmAcaModel = $oCourseData->adm_aca_group_session->adm_aca_group->adm_aca_course->adm_aca_model->name;
                $oMyQualifications->startDate_AdmAcaGroup = $oCourseData->adm_aca_group_session->adm_aca_group->start_date->format('Y-m-d H:i:s');
                $oMyQualifications->endDate_AdmAcaGroup = $oCourseData->adm_aca_group_session->adm_aca_group->end_date->format('Y-m-d H:i:s');
                $oMyQualifications->life_AdmAcaCourse = $oCourseData->adm_aca_group_session->adm_aca_group->adm_aca_course->life->format('Y-m-d H:i:s');
                $oMyQualifications->qualification_AcaUserCourseGroupSession = $oCourseData->qualification; 
                $oMyQualifications->firstName_AdmUser = $oPerson->firstName;
                $oMyQualifications->secondName_AdmUser = $oPerson->secondName;
                $oMyQualifications->lastName_AdmUser = $oPerson->lastName;
                $oMyQualifications->secondLastName_AdmUser = $oPerson->secondLastName;
                $lstQualificationsByCourse->push($oMyQualifications);
            }   
        }
        $oMyQualificationsResponse = new MyQualificationsResponse();
        $oMyQualificationsResponse->lstQualificationsByCourse = $lstQualificationsByCourse;
        
        return $oMyQualificationsResponse;
    }

}