<?php
//Date: 26 Jun 2018 / Ede nuñez
namespace App\Business\Emprende\Repositories\Garantia;
// bd
use DB;
//Models
use App\Models\EmpPropertyReceipt;
use App\Models\Catalogs\cStatus;
//interface
use App\Business\Interfaces\BaseRepo;


class PropertyReceiptRepository implements BaseRepo{   

    // Forma un solo Json con todos los catalogos de emprende
    public static function fnFindByUser($id){
        return EmpPropertyReceipt::where('idUserCourse', '=',$id)->where('idStatus','=',cStatus::$ACTIVO);
    }	
    
    public static function fnSave($oModel){
        $oModel->save();
        return $oModel;
    }

    public static function fnGet(){
        EmpPropertyReceipt::Where('idStatus','=',cStatus::$ACTIVO);
    }

    public static function fnFind($id){
        return EmpPropertyReceipt::where('id','=',$id)->where('idStatus','=',cStatus::$ACTIVO);
    }
    public static function fnFindWarranty($id){
        return EmpPropertyReceipt::where('idWarranty','=',$id)->where('idStatus','=',cStatus::$ACTIVO);
    }

    public static function fnDelete($id){
        $property  =  EmpPropertyReceipt::find($id);
        $property->forceDelete();
    }

}