<?php
//Date: 28 May 2018 / Ede nuñez
namespace App\Business\Emprende\Repositories\Negocio;
// bd
use DB;
//model
use App\Models\EmpBusinessDatum;
use App\Models\Catalogs\cStatus;
//interface
use App\Business\Interfaces\BaseRepo;


class BusinessDataRepository implements BaseRepo{   

  
    public static function fnAllByUser($id){
        return EmpBusinessDatum::where('idUserCourse', '=',$id)->where('idStatus','=',cStatus::$ACTIVO)->get();    
    }	
    public static function fnSave($oModel){
        $oModel->save();
        return $oModel;
    }

    public static function fnGet(){
      return EmpBusinessDatum::Where('idStatus','=',cStatus::$ACTIVO);
    }

    public static function fnFind($id){
        return EmpBusinessDatum::where('id','=',$id)->where('idStatus','=',cStatus::$ACTIVO);
    }
}