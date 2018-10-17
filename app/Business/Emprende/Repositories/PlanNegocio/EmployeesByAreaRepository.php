<?php
//Date: 16 May 2018 / Ede nuñez
namespace App\Business\Emprende\Repositories\PlanNegocio;
// bd
use DB;
//Models
use App\Models\EmpEmployeesByArea;
use App\Models\Catalogs\cStatus;
//interface
use App\Business\Interfaces\BaseRepo;


class EmployeesByAreaRepository implements BaseRepo{   

    public static function fnAllByEmployees($id){
        return EmpEmployeesByArea::Where('idHumanTalentManagement','=',$id)->where('idStatus','=',cStatus::$ACTIVO);
    }

    public static function fnSave($oModel){
        $oModel->save();
        return $oModel;
    }
    
    public static function fnGet(){
      return EmpEmployeesByArea::Where('idStatus','=',cStatus::$ACTIVO);
    }

    public static function fnFind($id){
        return EmpEmployeesByArea::where('id','=',$id)->where('idStatus','=',cStatus::$ACTIVO);
    }
}