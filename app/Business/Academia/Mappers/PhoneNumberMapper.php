<?php

namespace App\Business\Academia\Mappers;

// Models
use App\Models\Academia\User;
use App\Models\Catalogs\CStatus;
use App\Models\AcaPhoneNumber;
use App\Http\Responses\Academia\Profile\TelephoneResponse;

//Repositories
use App\Business\Academia\Repositories\PhoneNumberRepository;

//Hash
use Illuminate\Support\Facades\Hash;

class PhoneNumberMapper{   

    public static function fnMatchDataLstTelephones($oTelephones, $oUser)
    {
        $lstTelephones = Collect(); 
        
        foreach($oTelephones as $telephone)
        {
            $oTelephone = new TelephoneResponse();
            $oTelephone->id = $telephone->id;
            $oTelephone->idTypePhone = $telephone->idTypePhone;
            $oTelephone->phoneNumber = $telephone->phoneNumber;
            $oTelephone->extension = $telephone->phoneExtension;
            $oTelephone->idAction = $telephone->idAction;
            $lstTelephones->push($oTelephone);
        }

        $oUser->phoneNumberList = $lstTelephones;

        return $oUser;
    }

    public static function fnMatchDataTelephone($oTelephone, $telephone, $idUser)
    {
        if($telephone['idAction'] == 1)
        {
            $oTelephone = new AcaPhoneNumber();
            $oTelephone->idUser = $idUser;
            $oTelephone->idTypePhone = $telephone['idTypePhone'];
            $oTelephone->phoneNumber = $telephone['phoneNumber'];
            $oTelephone->phoneExtension = $telephone['extension'];
            $oTelephone->idAction = $telephone['idAction'];
            $oTelephone->idStatus = 1;
        }
        else if($telephone['idAction'] == 2)
        {
            $oTelephone->id = $telephone['id'];
            $oTelephone->idUser = $idUser;
            $oTelephone->idTypePhone = $telephone['idTypePhone'];
            $oTelephone->phoneNumber = $telephone['phoneNumber'];
            $oTelephone->phoneExtension = $telephone['extension'];
            $oTelephone->idAction = $telephone['idAction'];
            $oTelephone->idStatus = 1;
        }
        else if($telephone['idAction'] == 3)
            $oTelephone->idStatus = 2;

        return $oTelephone;
    }





}