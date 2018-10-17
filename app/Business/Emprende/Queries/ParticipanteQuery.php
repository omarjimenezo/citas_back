<?php
//Date: 16 May 2018 / Ede nuñez
namespace App\Business\Emprende\Queries;


// Mappers
use App\Business\Emprende\Mappers\DataParticipanteMappers;
//Repositories
use  App\Business\Emprende\Repositories\Participante\ParticipanteRepository;
use  App\Business\Emprende\Repositories\Solicitante\InitialDataRepository;




class ParticipanteQuery{   

    // Forma un solo Json con todos los catalogos de emprende
    public static function fngetParticipante($idUser){

        $oAccionistasNew = [];
        // obtiene los datos iniciales  por el id de usuario
        $oInitialData =  InitialDataRepository::fnAllByUser($idUser)->first();
        
        $oSolidario = ParticipanteRepository::fnFindByUser($idUser)->where("idParticipantsGuarantee",'=',1)->first();
        $oSolidarioNew = DataParticipanteMappers::fnParticipante($oSolidario,$oInitialData->idRegime,0);
       
       
        if ($oInitialData->idRegime == 2) {
            $oLegal = ParticipanteRepository::fnFindByUser($idUser)->where("idParticipantsGuarantee",'=',2)->first();
            $oLegalNew = DataParticipanteMappers::fnParticipante($oLegal,$oInitialData->idRegime,0);

            $oMayoritario = ParticipanteRepository::fnFindByUser($idUser)->where("idParticipantsGuarantee",'=',3)->first();
            $oMayoritarioNew = DataParticipanteMappers::fnParticipante($oMayoritario,$oInitialData->idRegime,0);
            
            $oAccionistas = ParticipanteRepository::fnFindByUser($idUser)->where("idParticipantsGuarantee",'=',4)->get();
            
            foreach ($oAccionistas as $value) {
                $data = DataParticipanteMappers::fnParticipante($value,$oInitialData->idRegime,0);
                array_push($oAccionistasNew,$data);
            }
            
            return array_merge(['deudor_solidario' => $oSolidarioNew,
                                'representante_legal' => $oLegalNew,
                                'accionista_mayoritario' => $oMayoritarioNew,
                                'identidad_accionistas' => $oAccionistasNew ]);    # code...
        }

        return array_merge(['deudor_solidario' => $oSolidarioNew,]);
       
    }	

    public static function fnSaveParticipante($oModel)
    {
        //inserta el participante deudor solidario
        $oparticipante = DataParticipanteMappers::fnParticipante($oModel["deudor_solidario"],$oModel->idFiscalRegimeGeneral,1);
        $result = ParticipanteRepository::fnSave($oparticipante);

        // si el solicitnte es persona moral
        if ($oModel->idFiscalRegimeGeneral == 2) {

            //si el paarticipante  a la vez es representante legal
            if ($oModel["deudor_solidario"]['idSolidarityDebtor'] == 1) {

            $oparticipante = DataParticipanteMappers::fnParticipante($oModel["representante_legal"],$oModel->idFiscalRegimeGeneral,1);
            // $result =  ParticipanteRepository::fnSave($oparticipante);
            }
            //si el participante a la vez es accionista mayoritario
            if ($oModel["deudor_solidario"]['idSolidarityDebtor'] == 2) {
                $oparticipante = DataParticipanteMappers::fnParticipante($oModel["accionista_mayoritario"],$oModel->idFiscalRegimeGeneral,1);
                // $result = ParticipanteRepository::fnSave($oparticipante);
            }
            
                // recorre array de identidad de accionistas
                foreach ($oModel["identidad_accionistas"] as $value) {

                    $oparticipante = DataParticipanteMappers::fnParticipante($value,$oModel->idFiscalRegimeGeneral,1);
                    // $result =  ParticipanteRepository::fnSave($oparticipante);
                }
        }
        return $oModel["deudor_solidario"]['idCreditBuroScore'];
    }
}