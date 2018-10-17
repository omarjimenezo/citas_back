<?php
//Date: 16 May 2018 / Ede nuñez
namespace App\Business\Emprende\Repositories\Participante;
// bd
use DB;
//Models
use App\Models\EmpParticipantsGuarantee;
use App\Models\Catalogs\cStatus;
//interface
use App\Business\Interfaces\BaseRepo;


class ParticipanteRepository implements BaseRepo{   

    // Forma un solo Json con todos los catalogos de emprende
    public static function fnFindByUser($id){
        return EmpParticipantsGuarantee::where('idUserCourse', '=',$id)->where('idStatus','=',cStatus::$ACTIVO);
    }	
    
    public static function fnSave($oModel){
        $oModel->save();
        return $oModel;
    }

    public static function fnGet(){
        EmpParticipantsGuarantee::Where('idStatus','=',cStatus::$ACTIVO);
    }

    public static function fnFind($id){
        return EmpParticipantsGuarantee::where('id','=',$id)->where('idStatus','=',cStatus::$ACTIVO);
    }

    
    public static function fnFindProperty($id,$idType){
        
        return EmpParticipantsGuarantee::where('idPropertyReceipt','=',$id)
                                         ->where('idParticipantsGuarantee','=',$idType)
                                        ->where('idStatus','=',cStatus::$ACTIVO);
    }

    public static function fnDelete($id){

        $aval =  ParticipanteRepository::fnFind($id)->first();
        $aval->forceDelete();
    }


}