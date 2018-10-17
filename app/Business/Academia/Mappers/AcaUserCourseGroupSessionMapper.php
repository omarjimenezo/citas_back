<?php

namespace App\Business\Academia\Mappers;

use App\Http\Responses\Academia\SatisfactionTest\QuestionsModel;
use App\Http\Responses\Academia\SatisfactionTest\AnswersModel;
use App\Http\Responses\Academia\SatisfactionTest\SectionsModel;
use App\Business\Academia\Queries\SatisfactionTestQuery;
use App\Models\AcaUserCourseGroupSession;




class AcaUserCourseGroupSessionMapper
{
    public static function fnMatchDataToSave($oModel, $idUserCourse)
    {
        $oAcaUserCourseGroupSession = new AcaUserCourseGroupSession();

        $oAcaUserCourseGroupSession->idStatus = 1;
        $oAcaUserCourseGroupSession->idUserCourse = $idUserCourse;
        $oAcaUserCourseGroupSession->idGroupSession = $oModel->idGroupSession;
        $oAcaUserCourseGroupSession->actual = 1;
        $oAcaUserCourseGroupSession->assistance = "si";

        return $oAcaUserCourseGroupSession;
    }
}