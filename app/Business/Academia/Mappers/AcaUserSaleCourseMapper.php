<?php
namespace App\Business\Acedemia\Mappers;

//Models
use App\Models\AcaUserSaleCourse;
use App\Models\Catalogs\CStatus;

use App\Business\Academia\Queries\CourseQuery;

class AcaUserSaleCourseMapper
{
    public static function fnAcaUserSaleCourse($idUser,$idpaymentType,$price)
    {
        $oAUSCourse = new AcaUserSaleCourse();
        $oAUSCourse->idStatus=CStatus::$ACTIVO; 
        $oAUSCourse->folio = CourseQuery::fnBuildFolioToSale($idUser);
        $oAUSCourse->idUser=$idUser;
        $oAUSCourse->idpaymentType=$idpaymentType;
        $oAUSCourse->subtotal=$price;
        $oAUSCourse->total=$price;
        return $oAUSCourse;
    }
}
