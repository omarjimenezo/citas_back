<?php

namespace App\Business\Academia\Mappers;

use App\Http\Responses\Academia\CourseContent\CourseContentModel;
use App\Http\Responses\Academia\CourseContent\CourseContentResponse;

class CourseContentMapper
{

    public static function fnMatchDataCourseContentResponse($oModel)
    {
        //Es la lista que posteriormente tendra la informacion de cada sesion.
        $lstSessionsByCourse = Collect();
        
        //Se recorre el modelo por session y se agrega a la coleccion de datos.
        foreach($oModel->aca_user_course_group_sessions as $model)
        {
            $oCourseContentModel = new CourseContentModel();
            $oCourseContentModel->id_AcaUserCourseGroupSession = $model->id;
            $oCourseContentModel->idGroupSession = $model->idGroupSession; 
            $oCourseContentModel->name_admAcaSession = $model->adm_aca_group_session->adm_aca_session->name;
            $lstSessionsByCourse->push($oCourseContentModel);
        }

        //Se crea el header del response.
        $oCourseContentResponse = new CourseContentResponse();
        //Se asigna la coleccion de datos con la informacion de cada sesion
        $oCourseContentResponse->lstSessionsByCourse = $lstSessionsByCourse;
        $oCourseContentResponse->idUser = $oModel->idUser; 
        $oCourseContentResponse->idUserCourse = $oModel->id;
        $oCourseContentResponse->idCourse = $oModel->idCourse;
        
        return $oCourseContentResponse;
    }

}