<?php


namespace App\Business\Academia\Mappers;

use App\Business\Academia\Queries\CourseDescriptionQuery;
use App\Http\Responses\Academia\CourseDescription\CourseDescriptionModel;
use App\Http\Responses\Academia\CourseDescription\CourseDescriptionResponse;

class CourseDescriptionMapper
{
    
    public static function fnMatchDataToResponse($oModel, $currentSession)
    {
        $oCoursesDescriptionResponse = new CourseDescriptionResponse();
        $oCoursesDescriptionResponse->idUser = $oModel->idUser;
        $oCoursesDescriptionResponse->idCourse = $oModel->idCourse;
        $oCoursesDescriptionResponse->name_admAcaCourse = $oModel->adm_aca_course->name;
        $oCoursesDescriptionResponse->description_admAcaCourse = $oModel->adm_aca_course->description;
        $oCoursesDescriptionResponse->totalSessions = $oModel->adm_aca_course->totalSessions;
        $oCoursesDescriptionResponse->currentSession = $currentSession;
        $oCoursesDescriptionResponse->imageBackground = $oModel->imageBackground;
        $oCoursesDescriptionResponse->urlProgram = 'https://www.honda.mx/assets/pdf/fuerza/modelos/HRR-216K9-VKM.pdf';
        $oCoursesDescriptionResponse->urlMaterial = 'https://www.honda.mx/assets/pdf/fuerza/modelos/HRR-216K9-VKM.pdf';
        $oCoursesDescriptionResponse->AccessTool = CourseDescriptionQuery::fnGetTypeProfileUser($oModel->idUser, $oModel->sessionTool);
        $oCoursesDescriptionResponse->haveInitialTest = CourseDescriptionQuery::fnCheckIfHaveInitialTest($oModel->id);
        $oCoursesDescriptionResponse->haveFinalTest = CourseDescriptionQuery::fnCheckIfHaveFinalTest($oModel->id);
       

        return $oCoursesDescriptionResponse;
    }

}
