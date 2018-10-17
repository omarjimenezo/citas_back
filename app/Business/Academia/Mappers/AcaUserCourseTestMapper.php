<?php

namespace App\Business\Academia\Mappers;

use App\Models\AcaUserCourseTest;

class AcaUserCourseTestMapper
{

    public static function fnMatchDataFromRequest( $idUserCourse, $idGroupSession, $idTest)
    {
        $oAcaUserCourseTest = new AcaUserCourseTest();
        $oAcaUserCourseTest->idStatus = 1;
        $oAcaUserCourseTest->idUserCourse = $idUserCourse;
        $oAcaUserCourseTest->idGroupSession = $idGroupSession;
        $oAcaUserCourseTest->idTest = $idTest;

        return $oAcaUserCourseTest;
    }
}