<?php
//Date: 26 Jun 2018 / Ede nuñez
namespace App\Business\Emprende\Repositories\Garantia;
// bd
use DB;
//Models
use App\Models\EmpWarranty;
use App\Models\Catalogs\cStatus;
//interface
use App\Business\Interfaces\BaseRepo;


class WarrantyRepository implements BaseRepo{   

    // Forma un solo Json con todos los catalogos de emprende
    public static function fnFindByUser($id){
        return EmpWarranty::where('idUserCourse', '=',$id)->where('idStatus','=',cStatus::$ACTIVO);
    }	
    
    public static function fnSave($oModel){
        $oModel->save();
        return $oModel;
    }

    public static function fnGet(){
        EmpWarranty::Where('idStatus','=',cStatus::$ACTIVO);
    }

    public static function fnFind($id){
        return EmpWarranty::where('id','=',$id)->where('idStatus','=',cStatus::$ACTIVO);
    }
}