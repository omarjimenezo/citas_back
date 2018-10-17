<?php
namespace App\Business\Academia\Queries;

use App\Models\AcaUserCourse;
use App\Models\AcaUserCourseGroupSession;
use App\Models\admPerson;
use App\Business\Academia\Mappers\MyQualificationsMapper;

class MyQualificationsQuery
{

    public static function fnGetMyQualifications($id)
    {
     
        $oCourse = AcaUserCourse::select('id', 'idUser', 'idCourse')
                                    ->where('idUser', $id)->get();
        
        $lstQualificationsByCourse = MyQualificationsMapper::fnMatchDataMyQualificationsResponse($oCourse);
        
        return $lstQualificationsByCourse;
    }

    
    public static function fnGetCourseData($idUserCourse)
    {
        
        $oCourseData = AcaUserCourseGroupSession::select('id', 'idUserCourse', 'idGroupSession', 'qualification')
                                                ->with(['adm_aca_group_session' => function($query){
                                                    $query->select('id', 'idGroup')
                                                    ->with(['adm_aca_group' => function($query){
                                                            $query->select('id', 'idUserTeacher', 'start_date', 'end_date', 'idCourse')
                                                            ->with(['adm_aca_course' => function($query){
                                                             $query->select('id', 'name', 'idModel', 'life')
                                                              ->with(['adm_aca_model' => function($query){
                                                                    $query->select('id', 'name');
                                                                }]);
                                                            }]);
                                                    }]);
                                                        }])->where('idUserCourse', $idUserCourse)->get();     
        return $oCourseData;
    }

    public static function fnGetTeacherDateByIdUserTeacher($idUserTeacher)
    {
        $oPerson = AdmPerson::select('firstName', 'secondName', 'lastName', 'secondLastName')
                         ->where('idUser', $idUserTeacher)->first();
        
        return $oPerson;
    }
}