<?php
//Date: 28 Jn 2018 /
namespace App\Business\Emprende\Mappers;

//Models

//Repositories

//Responses
use App\Http\Responses\Emprende\Qualification;

class DataQualificationMapper{   

    public static function fnQualification($rate){

        $oQualification = new Qualification();

        $oQualification->rate = $rate;

        return $oQualification;
    } 

}

    