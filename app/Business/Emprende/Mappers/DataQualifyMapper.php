<?php
//Date: 24 May 2018 /
namespace App\Business\Emprende\Mappers;

//Models
use App\Models\Emprende\ParticipantsGuarantee;
use App\Models\Catalogs\CStatus;
use App\Models\Emprende\qualify;

class DataQualifyMapper{   

    public static function fnQualify($score1,$score2,$idLinkedBeneficiary,$municipality1,$municipality2){

        $oModel = new qualify();

        $oModel->idScore1 = $score1;
        $oModel->idScore2 = $score2;
        $oModel->idLinkedBeneficiary = $idLinkedBeneficiary;
        $oModel->municipality1 = $municipality1;
        $oModel->municipality2 = $municipality2;
        return $oModel;
        }
    }

    