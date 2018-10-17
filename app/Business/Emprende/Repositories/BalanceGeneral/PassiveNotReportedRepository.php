<?php
//Date: 28 May 2018 / Ede nuñez
namespace App\Business\Emprende\Repositories\BalanceGeneral;
// bd
use DB;
//model
use App\Models\EmpPassiveNotReported;
use App\Models\Catalogs\cStatus;
//interface
use App\Business\Interfaces\BaseRepo;


class PassiveNotReportedRepository implements BaseRepo{   

  
    public static function fnAllByUser($id){
        return EmpPassiveNotReported::where('idUserCourse', '=',$id)->where('idStatus','=',cStatus::$ACTIVO)->get();    
    }	
    public static function fnSave($oModel){
        $oModel->save();
        return $oModel;
    }

    public static function fnGet(){
      return EmpPassiveNotReported::Where('idStatus','=',cStatus::$ACTIVO);
    }

    public static function fnFind($id){
        return EmpPassiveNotReported::where('id','=',$id)->where('idStatus','=',cStatus::$ACTIVO);
    }
}