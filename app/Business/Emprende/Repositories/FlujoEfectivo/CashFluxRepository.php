<?php
//Date: 28 May 2018 / Ede nuñez
namespace App\Business\Emprende\Repositories\FlujoEfectivo;
// bd
use DB;
//model
use App\Models\EmpCashFlux;
use App\Models\Catalogs\cStatus;
//interface
use App\Business\Interfaces\BaseRepo;


class CashFluxRepository implements BaseRepo{   

    public static function fnAllByUser($id){
        return EmpCashFlux::where('idUserCourse', '=',$id)->where('idStatus','=',cStatus::$ACTIVO)->get();    
    }	
    public static function fnSave($oModel){
        $oModel->save();
        return $oModel;
    }

    public static function fnGet(){
      return EmpCashFlux::Where('idStatus','=',cStatus::$ACTIVO);
    }

    public static function fnFind($id){
        return EmpCashFlux::where('id','=',$id)->where('idStatus','=',cStatus::$ACTIVO);
    }
}