<?php
//Date: 11 Jun 2018 / Ede nuñez
namespace App\Business\Emprende\Repositories\Archivos;
// bd
use DB;
//model
use App\Models\AcaUserFile;
use App\Models\Catalogs\cStatus;
//interface
use App\Business\Interfaces\BaseRepo;


class UserFileRepository implements BaseRepo{   

  
    public static function fnAllByUser($id){
        return AcaUserFile::where('idUser', '=',$id)->where('idStatus','=',cStatus::$ACTIVO)->get();    
    }	
    public static function fnSave($oModel){
        $oModel->save();
        return $oModel;
    }

    public static function fnGet(){
      return AcaUserFile::Where('idStatus','=',cStatus::$ACTIVO);
    }

    public static function fnFind($id){
        return AcaUserFile::where('id','=',$id)->where('idStatus','=',cStatus::$ACTIVO);
    }

    public static function fnFindGuarrante($id){
        return AcaUserFile::where('idParticipantsGuarantee','=',$id)->where('idStatus','=',cStatus::$ACTIVO);
    }

    public static function fnFindFile($idUser,$idFileName,$idGuarante,$idSeccion){

        $result = AcaUserFile::where('idUser','=',$idUser)
                            ->where('idFineName','=',$idFileName)
                            ->where('idStatus','=',cStatus::$ACTIVO);
        $result = ($idGuarante == null) ? $result->where('idParticipantsGuarantee','=',$idGuarante)
                                        : $result->where('idParticipantsGuarantee','=',$idSeccion);
        return $result;
    }

    public static function fnGetIsCreatedFile($filePath){
        return AcaUserFile::where('pathFile','=',$filePath);
    }
    public static function fnGetExistFile($id, $idUserCourse){
        if($idUserCourse != null)
            return AcaUserFile::where('idUserCourse','=',$idUserCourse);
        return AcaUserFile::where('idParticipantsGuarantee','=',$id);
    }
}