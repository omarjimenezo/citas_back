<?php


namespace App\Business\Academia\Queries;

// Repositories
use App\Business\Academia\Repositories\UserAcademyRepository;
use App\Business\Academia\Queries\UserPhoneQuery;

// Mappers
use App\Business\Academia\Mappers\UserAcademyMapper;
//Database instance
//model user phone

//Model
use App\Models\Academia\AcaUserPhone;
use App\Models\Catalogs\cTypePhone;
use App\Models\Catalogs\CStatus;
use App\Models\Catalogs\CConfiguration;
use App\Models\Academia\AcaUser;

use DB;

/** Class User Query */
class UserAcademyQuery
{

    /** Guarda y actualiza los datos del preregistro */
    public static function fnSavePreRegister(AcaUser $oModel)
    {
        try{
            $oResponse =   UserAcademyRepository::fnSave($oModel);
        }catch(Exception $e){
            throw $e;
        }
        return $oResponse;
    }

 
    // Actualiza el código de estuduante del alumno y el consecutivo de generación de código.
    public static function fnUpdateStudentConsecutiveCode($studentCodeConsecutive){
         try{
            $studentCodeConsecutive->ValueConfig  = $studentCodeConsecutive->ValueConfig == 999999? '100000' : $studentCodeConsecutive->ValueConfig+1;
            $oResponse = UserAcademyRepository::fnSave($studentCodeConsecutive);
         }catch(Exception $e){
         }
        return  $oResponse;

    }
}