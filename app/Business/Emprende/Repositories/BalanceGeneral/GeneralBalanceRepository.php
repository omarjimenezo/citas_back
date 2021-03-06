<?php
//Date: 28 May 2018 / Ede nuñez
namespace App\Business\Emprende\Repositories\BalanceGeneral;
// bd
use DB;
//model
use App\Models\EmpGeneralBalance;
use App\Models\Catalogs\cStatus;
//interface
use App\Business\Interfaces\BaseRepo;


class GeneralBalanceRepository implements BaseRepo{   

  
    public static function fnAByUser($id){
        return EmpGeneralBalance::where('idUserCourse', '=',$id)->where('idStatus','=',cStatus::$ACTIVO)->get();    
    }	
    public static function fnSave($oModel){
        $oModel->save();
        return $oModel;
    }

    public static function fnGet(){
      return EmpGeneralBalance::Where('idStatus','=',cStatus::$ACTIVO);
    }

    public static function fnFind($id){
        return EmpGeneralBalance::where('id','=',$id)->where('idStatus','=',cStatus::$ACTIVO);
    }
}