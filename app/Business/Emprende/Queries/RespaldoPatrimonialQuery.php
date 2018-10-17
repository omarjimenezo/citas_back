<?php
//Date: 1 Jun 2018 / Ede nuñez
namespace App\Business\Emprende\Queries;


// Mappers
use App\Business\Emprende\Mappers\DataRespaldoPatrimonialMapper;
//Repositories
use  App\Business\Emprende\Repositories\RespaldoPatrimonial\PatrimonialSupportRepository;
use  App\Business\Emprende\Repositories\RespaldoPatrimonial\PropertyCaptureRepository;
use  App\Business\Emprende\Repositories\Participante\ParticipanteRepository;

class RespaldoPatrimonialQuery{   

    // Forma un solo Json con los datos de RespaldoPatrimonial
    public static function fnGetRespaldoPatrimonial($idUser){
        $aSupport = [];
        $aCapture = [];
        $data = [];
        
        $oRespaldo = PatrimonialSupportRepository::fnAllByUser($idUser)->get();
        $oAval = ParticipanteRepository::fnFindByUser($idUser)->where("idParticipantsGuarantee",'=',5)->get();
        dd($oAval);
        foreach ($oRespaldo as  $value) {

            $oRespaldoNew = DataRespaldoPatrimonialMapper::fnPatrimonialSupport($value, 0);
            $aCapture = PropertyCaptureRepository::fnAllByIdSupport($value->id,0)->get();
            $data = array_merge(["patrimonial_support"=> $oRespaldoNew,"property_capture"=> $aCapture]);
            $data = array_merge([$data,$data]);
        }
        return $data;
    }	

    public static function fnSaveRespaldoPatrimonial($oModel)
    {
        foreach ($oModel as $value) {
      
            $oRespaldoNew = DataRespaldoPatrimonialMapper::fnPatrimonialSupport($value['patrimonial_support'], 1);
          
            $oRespaldo = PatrimonialSupportRepository::fnSave($oRespaldoNew);

            foreach ($value['property_capture'] as $CaptureVal) {

                $oCaptureNew = DataRespaldoPatrimonialMapper::fnPropertyCapture($CaptureVal,1);
                $oCapture = PropertyCaptureRepository::fnSave($oCapture);
            }
        }    
    }
}