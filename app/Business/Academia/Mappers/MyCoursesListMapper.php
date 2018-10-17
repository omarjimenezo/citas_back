<?php

namespace App\Business\Academia\Mappers;

use App\Http\Responses\Academia\MyCourses\MyCoursesModel;
use App\Http\Responses\Academia\MyCourses\MyCoursesResponse;
use App\Business\Academia\Queries\MyCoursesListQuery;




class MyCoursesListMapper
{
    public static function fnMatchDataMyCoursesListResponse($oModel)
    {
        $lstMyCourses = Collect();
      
        foreach($oModel as $model)
        {
            $oPerson = MyCoursesListQuery::fnGetTeacherDateByIdUserTeacher($model->aca_user_sale_course__details[0]->adm_aca_group->idUserTeacher);
            $oAssitance = MyCoursesListQuery::fnGetAssitanceByIdUserCourse($model->idUser, $model->aca_user_sale_course__details[0]->adm_aca_group->idCourse);
            $oMyCoursesModel = new MyCoursesModel();
            $oMyCoursesModel->idUser = $model->idUser;
            $oMyCoursesModel->name_AdmAcaCourse = $model->aca_user_sale_course__details[0]->adm_aca_group->adm_aca_course->name;
            $oMyCoursesModel->idCourse = $model->aca_user_sale_course__details[0]->adm_aca_group->idCourse;
            $oMyCoursesModel->totalSessions = $model->aca_user_sale_course__details[0]->adm_aca_group->adm_aca_course->totalSessions;
            $oMyCoursesModel->assistance = $oAssitance;
            $oMyCoursesModel->firstName_AdmPerson = $oPerson->firstName; 
            $oMyCoursesModel->secondName_AdmPerson = $oPerson->secondName;
            $oMyCoursesModel->lastName_AdmPerson = $oPerson->lastName;
            $oMyCoursesModel->secondLastName_AdmPerson = $oPerson->secondLastName;
            $oMyCoursesModel->imageBackground = $model->aca_user_sale_course__details[0]->adm_aca_group->adm_aca_course->imageBackground;
            $oMyCoursesModel->percentage = $oAssitance / $oMyCoursesModel->totalSessions;
            $lstMyCourses->push($oMyCoursesModel);
        }

        $oMyCoursesListResponse = new MyCoursesResponse();
        $oMyCoursesListResponse->lstMyCourses = $lstMyCourses;

        return $oMyCoursesListResponse;
    }

}