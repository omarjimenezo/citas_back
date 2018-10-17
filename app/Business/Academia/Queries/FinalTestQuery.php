<?php
namespace App\Business\Academia\Queries;

use App\Models\AdmAcaTest;
use App\Models\AdmCSectionQuestion;
use App\Models\AcaUserCourse;
use App\Models\AcaUserCourseGroupSession;
use App\Models\AcaUserCourseTest;
use App\Models\AdmAcaGroupSession;

use App\Business\Academia\Mappers\FinalTestMapper;

class FinalTestQuery
{

    //Obtiene las preguntas del cuestionario. El tipo de examen puede ser una variable de etorno.
    public static function fnGetCuestions($idCourse)
    {        
       $oInitialTestResponse = AdmAcaTest::select('id', 'idTypeTest', 'idCourse', 'name')
        ->with(['adm_aca_questions' => function($query){
            $query->select('id', 'idSection', 'idTest', 'name', 'mainQuestion')
            ->with(['adm_c_section_question' => function($query){
                $query->select('id', 'name', 'description')->get();
            }])
            ->with(['adm_aca_options' => function($query){
                $query->select('id', 'idQuestion', 'name', 'clause', 'isCorrect');
            }]);
        }])->where('idCourse', 1)->where('id', 3)->first();

        $oInitialTestResponse = FinalTestMapper::fnMatchDataToResponse($oInitialTestResponse);
        
        return $oInitialTestResponse;
    }

    //Extrae las distintas secciones que existen. 

    public static function fnGetDistinctSections()
    {
        $oSections = AdmCSectionQuestion::select('id', 'name', 'description')->where('idStatus', 1)->get();
        return $oSections;
    }

    //extrae el idUserCourse necesario para culminar con el procedimiento.
    public static function fnGetIdUserCourse($idUser, $idCourse)
    {
        $idUserCourse = AcaUserCourse::select('id')->where('idUser', $idUser)->where('idCourse', $idCourse)->first();
        return $idUserCourse->id;
    }

    //Extrae el idGroup Correspondiente a ese usuario por ese curso.
    public static function fnGetIdGroupByUser($idUserCourse)
    {
        $idGroupSession = AcaUserCourseGroupSession::select('idGroupSession')->where('idUserCourse', $idUserCourse)->first();
        $idGroup = AdmAcaGroupSession::select('idGroup')->where('id', $idGroupSession->idGroupSession)->first();
        return $idGroup->idGroup;
    }

    //Extrae el idUserCourseTest del usuario en cuestion.
    public static function fnGetIdUserCourseTest($idUserCourse)
    {
        $idUserCourseTest = AcaUserCourseTest::select('id')->where('idUserCourse', $idUserCourse)->where('idTest', 3)->first(); 
        return $idUserCourseTest->id;
    }
    
}