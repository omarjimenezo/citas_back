<?php
namespace App\Business\Academia\Queries;

use App\Models\AcaUserCourse;
use App\Models\AcaUserSaleCourse;
use App\Models\AdmPerson;
use App\Models\AcaUserCourseGroupSession;
use App\Business\Academia\Mappers\MyCoursesListMapper;

class MyCoursesListQuery
{

    //Extrae la lista de cursos por id del usuario
    public static function fnGetMyCoursesLst($id)
    {
        $oModel = AcaUserSaleCourse::select('id', 'idUser')
                                    ->with(['aca_user_sale_course__details' => function($query){
                                        $query->select('id', 'idUserSaleCourse','idGroup')
                                        ->with(['adm_aca_group' => function($query){
                                            $query->select('id', 'idCourse', 'idUserTeacher')
                                            ->with(['adm_aca_course' => function($query){
                                                $query->select('id', 'name', 'totalSessions', 'imageBackground');
                                            }]);
                                        }]);
                                    }])->where('idUser', $id)->get();

        $oMyCoursesListResponse = MyCoursesListMapper::fnMatchDataMyCoursesListResponse($oModel);

        return $oMyCoursesListResponse;
    }

    //Extrae la informacion del maestro del curso solicitado.
    public static function fnGetTeacherDateByIdUserTeacher($idUserTeacher)
    {
        $oPerson = AdmPerson::select('firstName', 'secondName', 'lastName', 'secondLastName')
                         ->where('idUser', $idUserTeacher)->first();
        
        return $oPerson;
    }

    //extrae el total de asistencia por curso.
    public static function fnGetAssitanceByIdUserCourse($idUser, $idCourse)
    {
        $idUserCourse = MyCoursesListQuery::fnGetIdUserCourse($idUser, $idCourse);
        $oAssitance = AcaUserCourseGroupSession::select('id', 'assistance')
                                                 ->where('idUserCourse', $idUserCourse)->where('assistance', 'si')->get();
                            
                       
        return $oAssitance->count();
    }

    //Extrae el idUserCourse correspondiente a ese usuario para ese curso.
    public static function fnGetIdUserCourse($idUser, $idCourse)
    {
        $idUserCourse = AcaUserCourse::select('id')
                                     ->where('idUser', $idUser)->where('idCourse', $idCourse)->first();
                         
        return $idUserCourse->id;
    }

    


    
}