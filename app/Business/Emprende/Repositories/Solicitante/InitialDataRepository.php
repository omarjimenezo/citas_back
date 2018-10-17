<?php
//Date: 16 May 2018 / Ede nuñez
namespace App\Business\Emprende\Repositories\Solicitante;
// bd
use DB;
//Models
use App\Models\Emprende\InitialData;
use App\Models\Catalogs\cStatus;
//interface
use App\Business\Interfaces\BaseRepo;


class InitialDataRepository implements BaseRepo{   

    // Forma un solo Json con todos los catalogos de emprende
    public static function fnAllByUser($id){
        return InitialData::where('idUserCourse', '=',$id)->where('idStatus','=',cStatus::$ACTIVO)->get();
    }	

    public static function fnSave($oModel){
        $oModel->save();
        return $oModel;
    }

    public static function fnGet(){
      return InitialData::Where('idStatus','=',cStatus::$ACTIVO);
    }

    public static function fnFind($id){
        return InitialData::where('id','=',$id)->where('idStatus','=',cStatus::$ACTIVO);
    }
}