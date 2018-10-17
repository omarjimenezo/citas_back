<?php
//Date: 16 May 2018 / Ede nuñez
namespace App\Business\Emprende\Repositories\EstadoResultados;
// bd
use DB;
//model
use App\Models\EmpStatusResult;
use App\Models\EmpSaleCostUtilityExpense;
use App\Models\Catalogs\cStatus;
//interface
use App\Business\Interfaces\BaseRepo;


class EstadoResultadosRepository implements BaseRepo{   

    // Forma un solo Json con todos los catalogos de emprende
    public static function fnAllByUser($id){
        return EmpStatusResult::where('idUserCourse','=',$id)->get();    
    }	
    
    public static function fnSave($oModel){
        $oModel->save();
        return $oModel;
    }

    public static function fnSaleCost($val, $statusResult){
        return EmpSaleCostUtilityExpense::where("idAverage",$val)->where("idStatusResults",$statusResult);
    }

    public static function fnGet(){
      return ApplicantDetail::Where('idStatus','=',cStatus::$ACTIVO);
    }

    public static function fnFind($id){
        return ApplicantDetail::where('id','=',$id)->where('idStatus','=',cStatus::$ACTIVO);
    }

    public static function fnFindEstate($id){
        return CMunicipality::where('id','=',$id);
    }
}