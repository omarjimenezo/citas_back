<?php
//Date: 16 May 2018 / Ede nuñez
namespace App\Business\Emprende\Repositories\PlanNegocio;
// bd
use DB;
//Models
use App\Models\EmpHumanTalentManagement;
use App\Models\Catalogs\cStatus;
//interface
use App\Business\Interfaces\BaseRepo;


class TalentManagementRepository implements BaseRepo{   


    public static function fnSave($oModel){
        $oModel->save();
        return $oModel;
    }
    
    public static function fnGet(){
      return EmpHumanTalentManagement::Where('idStatus','=',cStatus::$ACTIVO);
    }

    public static function fnFind($id){
        return EmpHumanTalentManagement::where('id','=',$id)->where('idStatus','=',cStatus::$ACTIVO);
    }
}