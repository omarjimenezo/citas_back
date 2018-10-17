<?php
//Date: 16 May 2018 / Ede nuñez
namespace App\Business\Emprende\Repositories\ResultadoFInal;
// bd
use DB;
//model
use App\Models\AdmCTabulatorMunicipalityBlock;
use App\Models\Catalogs\cStatus;
//interface
use App\Business\Interfaces\BaseRepo;


class TabulatorMunicipalityRepository implements BaseRepo{   
    
    public static function fnFindByMunicipality($id){
        return AdmCTabulatorMunicipalityBlock::where('idMunicipality','=',$id)->where('idStatus','=',cStatus::$ACTIVO);
    }

    public static function fnSave($oModel){
        $oModel->save();
        return $oModel;
    }

    public static function fnGet(){
      return AdmCTabulatorMunicipalityBlock::Where('idStatus','=',cStatus::$ACTIVO);
    }

    public static function fnFind($id){
        return AdmCTabulatorMunicipalityBlock::where('id','=',$id)->where('idStatus','=',cStatus::$ACTIVO);
    }

}