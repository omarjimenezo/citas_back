<?php
//Date: 24 May 2018 /
namespace App\Business\Emprende\Calificar;

//Models
use App\Models\Emprende\ParticipantsGuarantee;
use App\Models\Catalogs\CStatus;
use App\Models\Emprende\qualify;
use App\Models\AdmCTabulatorMunicipalityBlock as Block;
//
use DB;


class CalificarPasos{   

  public static function fnCalificaSolicitante($oModel){

        $goobScore = array(1, 2, 5);
        //valida score de deudor y de solicitante
        $score1 = (in_array($oModel->idScore1, $goobScore)) ? true : False;
        // dd($score1);
        $score2 = (in_array($oModel->idScore2, $goobScore)) ? true : False;
        // dd($score2);
        $qualification = ($score1 == true && $score2 == true) ? true : false;
        // dd($qualification);
        if($qualification == false)
            return $qualification;

        $goobBlock = array(1, 2, 3);
        // evalue monicipio
        $block1 = self::fnValueMunicipality($oModel->municipality1);
     
        $blockNew1 = (in_array($block1, $goobBlock)) ? true : False;
      
        $block2 = self::fnValueMunicipality($oModel->municipality2);
        
        $blockNew2 = (in_array($block2, $goobBlock)) ? true : False;
      
        $qualification = ($blockNew1 == true && $blockNew2 == true) ? true : false;
      
        if($qualification == false)
            return $qualification;
       
        // valida beneficiario del prestamo
        $qualification = ($oModel->idLinkedBeneficiary == 2) ? true : false;
      
        return $qualification;
    }


    public static function fnCalificaGarantia($scoreAvales){
       
        $goobScore = array(1, 2, 5);
        $score = array();
        foreach ($scoreAvales as $value) {
            $score = (in_array($value, $goobScore)) ? true : False;
            if($score == false)
                return $score;
        }
        return $score;
    }

    public static function fnValueMunicipality($municipality){
       
        return Block::where('idMunicipality','=',$municipality)
                    ->where('idStatus','=',cStatus::$ACTIVO)
                    ->first()->idBlock;
    }
    
}