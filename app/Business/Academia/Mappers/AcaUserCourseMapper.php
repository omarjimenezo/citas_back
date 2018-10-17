<?php
namespace App\Business\Acedemia\Mappers;

//Models
use App\Models\AcaUserCourse;

class AcaUserCourseMapper
{
    public static function fnAcaUserCourse($idCourse, $idUser)
    {
        $oAUCourse = new AcaUserCourse();
        // $oAUCourse->idStatus=CStatus::$ACTIVO;
        $oAUCourse->idStatus = 1;
        $oAUCourse->idUser = $idUser;
        $oAUCourse->idCourse = $idCourse;
        return $oAUCourse;
    }
}
