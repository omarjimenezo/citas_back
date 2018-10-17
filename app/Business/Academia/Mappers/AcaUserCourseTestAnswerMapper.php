<?php

namespace App\Business\Academia\Mappers;

use App\Models\AcaUserCourseTestAnswer;

class AcaUserCourseTestAnswerMapper
{

    public static function fnMatchDataFromRequest($answerToSave, $idUserCourseTest)
    {

        $oAcaUserCourseTestAnswer = new AcaUserCourseTestAnswer();
        $oAcaUserCourseTestAnswer->idUserCourseTest = $idUserCourseTest;
        //$oAcaUserCourseTestAnswer->idQuestion = $answerToSave['idQuestion'];
        $oAcaUserCourseTestAnswer->answer = $answerToSave['answer'];
        $oAcaUserCourseTestAnswer->idOption = $answerToSave['idOption'];

        return $oAcaUserCourseTestAnswer;
    }
}