<?php
namespace App\Business\Academia\Queries;

use App\Models\AdmAcaTest;
use App\Models\AdmCSectionQuestion;
use App\Models\AcaUserCourse;
use App\Models\AcaUserCourseGroupSession;
use App\Models\AcaUserCourseTest;
use App\Models\AdmAcaGroupSession;

use App\Business\Academia\Mappers\InitialTestMapper;

class InitialTestQuery
{

    //Obtiene el conjunto de preguntas correspondientes a ese tipo de examen. Se puede cambiar el numero por una constante.
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
        }])->where('idCourse', 1)->where('id', 1)->first();

        $oInitialTestResponse = InitialTestMapper::fnMatchDataToResponse($oInitialTestResponse);
        
        return $oInitialTestResponse;
    }

    //Extrae las diferentes secciones.
    public static function fnGetDistinctSections()
    {
        $oSections = AdmCSectionQuestion::select('id', 'name', 'description')->where('idStatus', 1)->get();
        return $oSections;
    }

    //Extrae el idUserCourse Correspondiente.
    public static function fnGetIdUserCourse($idUser, $idCourse)
    {
        $idUserCourse = AcaUserCourse::select('id')->where('idUser', $idUser)->where('idCourse', $idCourse)->first();

        return $idUserCourse->id;
    }

    //Extrae el idGroup del usuario en cuestion
    public static function fnGetIdGroupByUser($idUserCourse)
    {
        $idGroupSession = AcaUserCourseGroupSession::select('idGroupSession')->where('idUserCourse', $idUserCourse)->first();
        $idGroup = AdmAcaGroupSession::select('idGroup')->where('id', $idGroupSession->idGroupSession)->first();
        return $idGroup->idGroup;
    }

    //Extrae el idUserCourseTest correspondiente a ese usuario
    public static function fnGetIdUserCourseTest($idUserCourse)
    {
        $idUserCourseTest = AcaUserCourseTest::select('id')->where('idUserCourse', $idUserCourse)->where('idTest', 2)->first(); 
        
        return $idUserCourseTest->id;
    }
    
}