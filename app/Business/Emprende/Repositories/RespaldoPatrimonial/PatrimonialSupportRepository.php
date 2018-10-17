<?php
//Date: 1 Jun 2018 / Ede nuñez
namespace App\Business\Emprende\Repositories\RespaldoPatrimonial;
// bd
use DB;
//model
use App\Models\Emprende\PatrimonialSupport;
use App\Models\Catalogs\cStatus;
//interface
use App\Business\Interfaces\BaseRepo;


class PatrimonialSupportRepository implements BaseRepo{   


    public static function fnAllByUser($id){
        return PatrimonialSupport::where('idUser', '=',$id)->where('idStatus','=',cStatus::$ACTIVO);    
    }	
    public static function fnSave($oModel){
        $oModel->save();
        return $oModel;
    }

    public static function fnGet(){
      return PatrimonialSupport::Where('idStatus','=',cStatus::$ACTIVO);
    }

    public static function fnFind($id){
        return PatrimonialSupport::where('id','=',$id)->where('idStatus','=',cStatus::$ACTIVO);
    }
}