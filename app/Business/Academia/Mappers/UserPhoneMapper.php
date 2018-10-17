<?php

namespace App\Business\Academia\Mappers;

// Responses
use App\Http\Responses\Academia\Auth\LoginResponse;

// Models
use App\Models\Academia\AcaUserPhone;
use App\Models\Catalogs\CStatus;
use App\Models\Catalogs\cTypePhone;
use App\Http\Requests\Academia\Register\PreRegisterRequest;

//Hash
use Illuminate\Support\Facades\Hash;

class UserPhoneMapper{   

      public static function fnMapSavePhone(PhoneRequest $oRequest){

        $oModel = new AcaUserPhone();       
        $oModel->idStatus = CStatus::$ACTIVO;
        $oModel->idUser = $oRequest->idUser;			
        $oModel->idTypePhone = cTypePhone::$CELULAR;
        $oModel->phoneNumber = $oRequest->phoneNumber;
        $oModel->created_at = new DateTime('today');

        return $oModel;        
    }
}
