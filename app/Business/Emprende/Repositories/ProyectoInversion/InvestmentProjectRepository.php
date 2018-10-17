<?php
//Date: 16 May 2018 / Ede nuñez
namespace App\Business\Emprende\Repositories\ProyectoInversion;
// bd
use DB;
//model
use App\Models\EmpDebtToPay;
use App\Models\EmpInvestmentProject;
use App\Models\EmpTypeCredit;
use App\Models\Catalogs\cStatus;
//interface
use App\Business\Interfaces\BaseRepo;


class InvestmentProjectRepository implements BaseRepo{   

    // Forma un solo Json con todos los catalogos de emprende
    public static function fnAllByUser($id){
        return EmpInvestmentProject::where('idUserCourse','=',$id)->get();    
    }	
    
    public static function fnAllByUserType($id, $val){
        $invent =  EmpInvestmentProject::where('idUserCourse','=',$id)->first(); 
        return ($invent == null) ? null : EmpTypeCredit::where('idInvestmentProject','=',$invent->id)
                                                         ->where("idTypeCredit", $val)->first();    
    }	

    public static function fnAllByUserToPay($id, $val){
        $invent =  EmpInvestmentProject::where('idUserCourse','=',$id)->first(); 
        return ($invent == null) ? null : EmpDebtToPay::where('idInvestmentProject','=',$invent->id)
                                                        ->where("idDescriptionDebt", $val)->first();    
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