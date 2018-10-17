<?php
//Date: 1 Jun 2018 / Ede nuñez
namespace App\Business\Emprende\Repositories\RespaldoPatrimonial;
// bd
use DB;
//model
use App\Models\Emprende\PropertyCapture;

use App\Models\Catalogs\CStatus;
//interface
use App\Business\Interfaces\BaseRepo;


class PropertyCaptureRepository implements BaseRepo{   


    public static function fnAllByUser($id){
        return PropertyCapture::where('idUser', '=',$id)->where('idStatus','=',cStatus::$ACTIVO)->get();    
    }	
    public static function fnSave($oModel){
        $oModel->save();
        return $oModel;
    }

    public static function fnGet(){
      return PropertyCapture::Where('idStatus','=',cStatus::$ACTIVO);
    }

    public static function fnFind($id){
        return PropertyCapture::where('id','=',$id)->where('idStatus','=',cStatus::$ACTIVO);
    }

    public static function fnAllByIdSupport($id){
        return PropertyCapture::where('idPatrimonialSupport', '=',$id)->where('idStatus','=',cStatus::$ACTIVO);    
    }	
}