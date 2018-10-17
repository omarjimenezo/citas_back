<?php
//Date: 28 May 2018 / Ede nuñez
namespace App\Business\Emprende\Repositories\FlujoEfectivo;
// bd
use DB;
//model
use App\Models\EmpFlux;
use App\Models\Catalogs\cStatus;
//interface
use App\Business\Interfaces\BaseRepo;


class FluxRepository implements BaseRepo{   

    public static function fnAllByCashFlux($id){
        return EmpFlux::where('idCashFlux', '=',$id)->where('idStatus','=',cStatus::$ACTIVO);    
    }	
    public static function fnSave($oModel){
        $oModel->save();
        return $oModel;
    }

    public static function fnGet(){
      return EmpFlux::Where('idStatus','=',cStatus::$ACTIVO);
    }

    public static function fnFind($id){
        return EmpFlux::where('id','=',$id)->where('idStatus','=',cStatus::$ACTIVO);
    }
}