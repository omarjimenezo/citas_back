<?php
namespace App\Business\Acedemia\Mappers;

//Models
use App\Models\AcaUserSaleCourseDetail;
use App\Models\Catalogs\CStatus;

class AcaUserSaleCourseDetailMapper
{
    public static function fnAcaUserSaleCourseDetail($idUserSaleCourse, $idGroup, $price)
    {
        $oUSCourseDetail = new AcaUserSaleCourseDetail();
        // $oUSCourseDetail->idStatus = CStatus::$ACTIVO;
        $oUSCourseDetail->idStatus = 1;
        $oUSCourseDetail->idUserSaleCourse = $idUserSaleCourse;
        $oUSCourseDetail->idGroup = $idGroup;
        $oUSCourseDetail->price = $price;
        return $oUSCourseDetail;
    }
}
