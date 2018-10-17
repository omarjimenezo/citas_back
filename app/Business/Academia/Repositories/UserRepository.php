<?php

namespace App\Business\Academia\Repositories;

// Models
use App\Models\User; //creo que se cambia aquí
use App\Models\Catalogs\CStatus;

//interface
use App\Business\Interfaces\BaseRepo;
use DB;

class UserRepository implements BaseRepo{   

    public static function fnSave($oModel){
        $oModel->save();
        return $oModel;
    }

    public static function fnGet(){
      return User::Where('idStatus','=',CStatus::$ACTIVO);
    }

    public static function fnFind($id){
        return DB::table('user')->where('id',$id)->where('idStatus',CStatus::$ACTIVO);  
    }


}	