<?php
//Date: 28 May 2018 / Ede nuñez
namespace App\Business\Emprende\Repositories\FlujoEfectivo;
// bd
use DB;
//model
use App\Models\EmpProjectionPremise;
use App\Models\Catalogs\cStatus;
//interface
use App\Business\Interfaces\BaseRepo;


class ProjectionPremisesRepository implements BaseRepo{   

    public static function fnAllByUser($id){
        return EmpProjectionPremise::where('idUserCourse', '=',$id)->where('idStatus','=',cStatus::$ACTIVO)->get();    
    }	
    public static function fnSave($oModel){
        $oModel->save();
        return $oModel;
    }

    public static function fnGet(){
      return EmpProjectionPremise::Where('idStatus','=',cStatus::$ACTIVO);
    }

    public static function fnFind($id){
        return EmpProjectionPremise::where('id','=',$id)->where('idStatus','=',cStatus::$ACTIVO);
    }
}