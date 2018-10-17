<?php
//Date: 16 May 2018 / Ede nuñez
namespace App\Business\Emprende\Repositories\EstadoResultados;
// bd
use DB;
//model
use App\Models\EmpSaleCostUtilityExpense;
use App\Models\Catalogs\cStatus;
//interface
use App\Business\Interfaces\BaseRepo;


class CostoUtilidadesRepository implements BaseRepo{   

    // Forma un solo Json con todos los catalogos de emprende
    public static function fnAllByUser($id){
        return EmpSaleCostUtilityExpense::where('idStatusResults','=',$id)->get();    
    }	
    
    public static function fnSave($oModel){
        $oModel->save();
        return $oModel;
    }

    public static function fnGet(){
      
    }

    public static function fnFind($id){
        
    }

}