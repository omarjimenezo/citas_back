<?php
//Date: 16 May 2018 / Ede nuñez
namespace App\Business\Emprende\Repositories\Configuration;
// bd
use DB;
//model
use App\Models\CConfiguration;
use App\Models\Catalogs\cStatus;
//interface
use App\Business\Interfaces\BaseRepo;


class ConfigurationRepository implements BaseRepo{   

    public static function fnSave($oModel){
        $oModel->save();
        return $oModel;
    }

    public static function fnGet(){
      return CConfiguration::Where('idStatus','=',cStatus::$ACTIVO);
    }

    public static function fnFind($id){
        return CConfiguration::where('id','=',$id)->where('idStatus','=',cStatus::$ACTIVO);
    }
}