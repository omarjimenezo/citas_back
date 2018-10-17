<?php
//Date: 28 May 2018 / Ede nuñez
namespace App\Business\Emprende\Repositories\BalanceGeneral;
// bd
use DB;
//model
use App\Models\EmpDeferredAsset;
use App\Models\Catalogs\cStatus;
//interface
use App\Business\Interfaces\BaseRepo;


class DeferredAssetsRepository implements BaseRepo{   

  
    public static function fnAllByUser($id){
        return EmpDeferredAsset::where('idUserCourse', '=',$id)->where('idStatus','=',cStatus::$ACTIVO)->get();    
    }	
    public static function fnSave($oModel){
        $oModel->save();
        return $oModel;
    }

    public static function fnGet(){
      return EmpDeferredAsset::Where('idStatus','=',cStatus::$ACTIVO);
    }

    public static function fnFind($id){
        return EmpDeferredAsset::where('id','=',$id)->where('idStatus','=',cStatus::$ACTIVO);
    }
}