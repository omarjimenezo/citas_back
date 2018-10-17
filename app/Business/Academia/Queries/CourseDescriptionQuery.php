<?php

namespace App\Business\Academia\Queries;
use App\Models\AcaUserCourse;
use App\Models\AcaUserAcademy;
use App\Models\AcaUserCourseGroupSession;
use App\Models\AcaUserCourseTest;

use App\Business\Academia\Mappers\CourseDescriptionMapper;
use App\Http\Responses\Academia\Profile\ProfileResponse;



class CourseDescriptionQuery 
{

    //Obtiene la descripcion por curso
    public static function fnGetCourseDescription($id, $idCourse)
    {
        $oModel = AcaUserCourse::select('id', 'idUser', 'idCourse')
                 ->with(['adm_aca_course' => function($query){
                     $query->select('id', 'name', 'description', 'totalSessions', 'imageBackground', 'sessionTool');
                 }])->where('idUser', $id)->where('idCourse', $idCourse)->first();        
    
        $oAssisByIdCourse = AcaUserCourseGroupSession::where('assistance', 'si')->where('idUserCourse', $oModel->id)->count();         
        $oCoursesDescriptionResponse = CourseDescriptionMapper::fnMatchDataToResponse($oModel, $oAssisByIdCourse);
    
        return $oCoursesDescriptionResponse;
    }

    //Asignacion de herramienta emprende (Empresario o emprendendor). Los numeros pudieran ser variables de entorno.
    public static function fnGetTypeProfileUser($id, $sessionTool)
    {
        $toolAccess = false;
        $oModel = AcaUserAcademy::select('idUserType')->first();
        if($oModel->idUserType == 1 && $sessionTool >= 15)
            $toolAccess = true;    
        else if($oModel->idUserType == 2)
          $toolAccess = true;
        
          return $toolAccess;
    }

    //Revisa si ya se tiene una evaluacion inicial de ese curso.
    public static function fnCheckIfHaveInitialTest($idUserCourse)
    {
        $oModel = AcaUserCourseTest::select('idTest', 'idUserCourse')->where('idUserCourse', $idUserCourse)->where('idStatus', 1)->where('idTest', 2)->first();
        
        $haveInitialTest = false;
        if($oModel != null)
            $haveInitialTest = true;

        return $haveInitialTest; 
    }

    //Revisa si ya se tiene una evaluacion final de ese curso.
    public static function fnCheckIfHaveFinalTest($idUserCourse)
    {
        $oModel = AcaUserCourseTest::select('idTest', 'idUserCourse')->where('idUserCourse', $idUserCourse)->where('idStatus', 1)->where('idTest', 3)->first();
        
        $haveFinalTest = false;
        if($oModel != null)
            $haveFinalTest = true;

        return $haveFinalTest; 
    }

}
