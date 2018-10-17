<?php

namespace App\Business\Academia\Queries;


use App\Business\Academia\Mappers\CourseContentMapper;
use App\Models\AcaUserCourseGroupSession;
use App\Models\AcaUserCourse;

class CourseContentQuery
{

    public static $idGlobal;

    //Obtiene los datos necesarios para mostrar la informacion del contenido del curso por idCourse
    //tomando en cuenta el id del usuario
    public static function fnGetCourseContent($id, $idCourse)
    {
        //self::$idGlobal = 16;


        $oModel = AcaUserCourse::select('id', 'idUser', 'idCourse')
                  ->with(['aca_user_course_group_sessions' => function($query){
                      $query->select('id', 'idUserCourse', 'idGroupSession')
                      ->with(['adm_aca_group_session' => function($query){
                            $query->select('id', 'idSession')
                            ->with(['adm_aca_session' => function($query){
                                $query->select('id', 'name');
                            }]);
                        }]);  
                  }])->where('idUser', $id)->where('idCourse', $idCourse)->first();

        
        //Se construye el modelado de datos del response que se requiere para integrarse en el front.
        $oCourseContentResponse = CourseContentMapper::fnMatchDataCourseContentResponse($oModel);

        return $oCourseContentResponse;
    }

}