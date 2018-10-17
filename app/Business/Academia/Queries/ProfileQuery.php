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


class ProfileQuery
{
    //obtiene la informacion del perfile de un usuario especifico.
    public static function fnGetProfile($id)
    {
        $oUser =  AcaUserAcademy::with(['c_municipality' => function($query){
                    $query->select('id', 'municipality', 'idState')
                    ->with(['c_state' => function($query){
                        $query->select('id', 'name')->first();
                    }]);
                }])->where('id', $id)->first();            

        $oUser = AcaUserAcademyMapper::fnMatchDataFromResponse($oUser);
        $oTelephones = AcaPhoneNumber::select('id', 'idTypePhone', 'phoneNumber', 'phoneExtension')->
                    with(['aca_user_Academy' => function($query){
                    $query->select('id')->first();
                    }])->where('idUser', $id)->where('idStatus', 1)->get();
        $oUser = PhoneNumberMapper::fnMatchDataLstTelephones($oTelephones, $oUser);
        
        return $oUser;
    }
    
    public static function fnGetAcaUserAcademy($id)
    {               
        $oUser = AcaUserAcademy::where("id", $id)->where('idStatus', 1)->first();
        return $oUser;
    }
}




