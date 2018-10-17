<?php

namespace App\Business\Academia\Mappers;

// Responses
use App\Http\Responses\Academia\Auth\LoginResponse;

// Models
use App\Models\Academia\AcaUser;
use App\Models\Catalogs\CStatus;
use App\Http\Requests\Academia\Register\PreRegisterRequest;

//Hash
use Illuminate\Support\Facades\Hash;

class UserAcademyMapper{   

    public static function fnUserLogin($oUser){
        $oModel = new LoginResponse();        
        $oModel->id = $oUser->id;            
        $oModel->idAction = $oUser->idAction;            
        $oModel->username = $oUser->firstName;        
        $oModel->email = $oUser->email;        
        $oModel->studentCode = $oUser->studentCode;        
        return $oModel;    
      }	

      public static function fnPreRegister(PreRegisterRequest $oRequest){

        $oModel = new AcaUser();       
        $oModel->idStatus = CStatus::$INACTIVO;
        $oModel->idAction = cStatus::$ACTIVO;				
        $oModel->firstName = $oRequest->firstName;
        $oModel->lastName = $oRequest->lastName;
        $oModel->secondLastName = $oRequest->secondLastName;
        $oModel->idGender = $oRequest->idGender;
        $oModel->birthdate = $oRequest->birthdate;
        $oModel->curp = $oRequest->curp;
        $oModel->rfc = $oRequest->rfc;
        $oModel->street = $oRequest->street;
        $oModel->outsideNumber = $oRequest->outsideNumber;
        $oModel->postalCode = $oRequest->postalCode;
        $oModel->colony = $oRequest->colony;
        $oModel->cityLocality = $oRequest->cityLocality;
        $oModel->idMunicipality = $oRequest->idMunicipality;
        $oModel->email = $oRequest->email;
        $oModel->idUserType = $oRequest->idUserType;
        $oModel->idTypeUserType = $oRequest->idTypeUserType;
        $oModel->password = Hash::make($oRequest->password);

        return $oModel;        
    }
}
