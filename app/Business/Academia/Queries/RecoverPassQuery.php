<?php

namespace App\Business\Academia\Queries;
use App\Models\AcaUserAcademy;
use App\Business\Academia\Repositories\RecoverPassRepository;
//Hash
use Illuminate\Support\Facades\Hash;

class RecoverPassQuery
{
    public static function fnSelectData()
    {
        $lstCourses = CourseRepository::fnGet()->get();
        return $lstCourses;
    
    }
    
    public static function fnUpdateUserToken($oModel)
    {
       $oRecoverPass = AcaUserAcademy::where('id', '=', $oModel->id)->first();
       if($oRecoverPass != null)
       {
           $oRecoverPass->token = $oModel->token;
           $oRecoverPass = RecoverPassRepository::fnsave($oRecoverPass);
       }
    }

    public static function fnUpdateUserPassword($oModel)
    {
        $oRecoverPass = AcaUserAcademy::where('id', '=', $oModel->id)->first();
        
        if($oRecoverPass != null)
        {
            $oRecoverPass->password = Hash::make($oModel->password);
            $oRecoverPass = RecoverPassRepository::fnsave($oRecoverPass);
        }

        $oModel->password = $oRecoverPass->password;
    }

    public static function fnFindByEmail($oModel)
    {
        $oAcaUser = AcaUserAcademy::where('email', $oModel->email)->where('idStatus', 1)->first();
        return $oAcaUser;    
    }
}