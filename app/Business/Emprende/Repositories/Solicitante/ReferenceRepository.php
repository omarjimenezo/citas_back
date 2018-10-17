<?php
//Date: 16 May 2018 / Ede nuñez
namespace App\Business\Emprende\Repositories\Solicitante;
// bd
use DB;
//Models
use App\Models\EmpReference;
use App\Models\Catalogs\cStatus;
//interface
use App\Business\Interfaces\BaseRepo;


class ReferenceRepository implements BaseRepo{   

    // Forma un solo Json con todos los catalogos de emprende
    public static function fnFindByUser($id){
        return EmpReference::where('idUserCourse', '=',$id)->where('idStatus','=',cStatus::$ACTIVO);
    }	
    public static function fnSave($oModel){
        $oModel->save();
        return $oModel;
    }

    public static function fnGet(){
      return EmpReference::Where('idStatus','=',cStatus::$ACTIVO);
    }

    public static function fnFind($id){
        return EmpReference::where('id','=',$id)->where('idStatus','=',cStatus::$ACTIVO);
    }
}