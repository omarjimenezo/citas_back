<?php
namespace App\Business\Academia\Queries;

use App\Models\AcaUserSaleCourse;
use App\Models\AdmPerson;
use App\Models\AcaUserSaleCourseDetail;
use App\Business\Academia\Mappers\MyShoppingMapper;

//MyshoppingQuery
class MyShoppingQuery
{


    //Extrae la informacion de las compras por usuario-
    public static function fnGetShoppingByUserId($id)
    {
      $oModel = AcaUserSaleCourse::select('id', 'idUser', 'idpaymentType', 'subtotal', 'total', 'created_at')
                                    ->with(['c_aca_payment_type' => function($query){
                                        $query->select('id', 'name')->first();
                                    }])
                                    ->with(['aca_user_sale_course__details' => function($query){
                                        $query->select('idUserSaleCourse','idGroup', 'price')
                                        ->with(['adm_aca_group' => function($query){
                                            $query->select('id', 'idCourse', 'idUserTeacher')
                                            ->with(['adm_aca_course' => function($query){
                                                $query->select('id','name')->get();
                                            }]);
                                        }]);
                                    }])->where('idUser', $id)->get();
    $oModel = MyShoppingMapper::fnMatchDataMyShoppingResponse($oModel);     
    
    return $oModel;
    }

    //Extrae la informacion del maestro
    public static function fnGetTeacherDateByIdUserTeacher($idUserTeacher)
    {
        $oPerson = AdmPerson::select('firstName', 'secondName', 'lastName', 'secondLastName')
                         ->where('idUser', $idUserTeacher)->first();
        
        return $oPerson;
    }
}