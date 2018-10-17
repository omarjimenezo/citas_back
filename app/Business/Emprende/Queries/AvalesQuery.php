<?php
//Date: 30 May 2018 / Ede nuñez
namespace App\Business\Emprende\Queries;


// Mappers
use App\Business\Emprende\Mappers\DataAvalesMapper;
//Repositories
use  App\Business\Emprende\Repositories\Participante\ParticipanteRepository;


class AvalesQuery{   

    // Forma un solo Json con los datos de Avales
    public static function fnGetAvales($idUser){
        $oAvalNew =[];
        $oAval = ParticipanteRepository::fnFindByUser($idUser)->where("idParticipantsGuarantee",'=',5)->get();
        if(!$oAval){
            return null;
        }
        foreach ($oAval as $value) {
            $data = DataAvalesMapper::fnAvales($value,0);
            array_push($oAvalNew,$data);
        }
        return $oAvalNew;
    }	

    public static function fnSaveAvales($oModel)
    {
        $oAvalNew = DataAvalesMapper::fnAvales($oModel,1);
        $oAval = ParticipanteRepository::fnSave($oAvalNew);
       return $oAval;
    }
}