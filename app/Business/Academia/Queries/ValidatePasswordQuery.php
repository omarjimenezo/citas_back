<?php

namespace App\Business\Academia\Queries;
use App\Models\AcaUserAcademy;
use Illuminate\Support\Facades\Hash;


class ValidatePasswordQuery
{
    public static function fnValidatePassword($id, $CurrentPassword)
    {
        $isSame = null;
        $oUser =  AcaUserAcademy::select('id', 'password')->where('id', $id)->first();
        
        if(Hash::check($CurrentPassword, $oUser->password))
            $isSame = true;
        else $isSame = false;            

        return $isSame;
    }   
}

