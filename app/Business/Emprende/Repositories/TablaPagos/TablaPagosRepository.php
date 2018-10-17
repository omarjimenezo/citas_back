<?php
//Date: 16 May 2018 / Ede nuñez
namespace App\Business\Emprende\Repositories\TablaPagos;
// bd
use DB;
//model
use App\Models\EmpAmortizationTable;
use App\Models\Catalogs\cStatus;
//interface
use App\Business\Interfaces\BaseRepo;


class TablaPagosRepository implements BaseRepo{   

    // Forma un solo Json con todos los catalogos de emprende
    public static function fnAllByUser($id){
        return EmpAmortizationTable::where('idUserCourse','=',$id)->get();    
    }	
    
    public static function fnSave($oModel){
        $oModel->save();
        return $oModel;
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