<?php

namespace App\Business\Academia\Queries;
use App\Models\AcaUserAcademy;
use App\Models\AcaPhoneNumber;
use App\Business\Academia\Repositories\ProfileRepository;

use App\Business\Academia\Mappers\AcaUserAcademyMapper;
use App\Business\Academia\Mappers\PhoneNumberMapper;
use App\Http\Responses\Academia\Profile\ProfileResponse;
use App\Http\Responses\Academia\Profile\TelephoneResponse;

//Hash
use Illuminate\Support\Facades\Hash;


class PhoneNumberQuery 
{
    public static function fnGetPhoneNumberById($id)
    {
        $oUser = AcaPhoneNumber::where("idUser", $id)->where('idStatus', 1)->get();
        return $oUser;
    }
    public static function fnGetPhoneNumberByIdPhone($idPhone){
        $oTelphone = AcaPhoneNumber::where("id", $idPhone)->first();

        return $oTelphone;
    }
}




