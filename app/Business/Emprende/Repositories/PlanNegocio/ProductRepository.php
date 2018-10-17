<?php
//Date: 16 May 2018 / Ede nuñez
namespace App\Business\Emprende\Repositories\PlanNegocio;
// bd
use DB;
//Models
use App\Models\EmpProduct;
use App\Models\Catalogs\cStatus;
//interface
use App\Business\Interfaces\BaseRepo;


class ProductRepository implements BaseRepo{   

    public static function fnAllByOperational($id){
        return EmpProduct::Where('idOperationalManagement','=',$id)->where('idStatus','=',cStatus::$ACTIVO);
    }

    public static function fnSave($oModel){
        $oModel->save();
        return $oModel;
    }

    public static function fnGet(){
      return EmpProduct::Where('idStatus','=',cStatus::$ACTIVO);
    }

    public static function fnFind($id){
        return EmpProduct::where('id','=',$id)->where('idStatus','=',cStatus::$ACTIVO);
    }
}