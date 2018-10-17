<?php
//Date: 16 May 2018 / Ede nuñez
namespace App\Business\Emprende\Queries;

// Mappers
use App\Business\Emprende\Mappers\DataNegocioMapper;
//Repositories
use  App\Business\Emprende\Repositories\Negocio\BusinessDataRepository;
use  App\Business\Emprende\Repositories\Negocio\CreditDataRepository;
use App\Business\Emprende\Repositories\Solicitante\InitialDataRepository;
// MOdels
use App\Models\Catalogs\CStatus;

class NegocioQuery{   

    public static function fnGetNegocio($idUser){

         // obtiene los datos iniciales  por el id de usuario
        // $oInitialData =  InitialDataRepository::fnAllByUser($idUser)->first();

        $oBusiness = BusinessDataRepository::fnAllByUser($idUser)->first();
        $oBusinessNew = DataNegocioMapper::fnGetBusiness($oBusiness);
        $oCredit= CreditDataRepository::fnAllByUser($idUser)->first();
        $oCreditNew = DataNegocioMapper::fnGetCredit($oCredit);

       return array_merge(['datos_negocio' => $oBusinessNew,'datos_credito' => $oCreditNew]);
    }	

    public static function fnSaveNegocio($oModel){
        
        $oBusinessNew = DataNegocioMapper::fnSaveBusiness($oModel['datos_negocio']);
        $oBusiness = BusinessDataRepository::fnSave($oBusinessNew);

        $oCreditNew = DataNegocioMapper::fnSaveCredit($oModel['datos_credito'], $oBusinessNew->idUser);
        $oCredit= CreditDataRepository::fnSave($oCreditNew);
        
    }	
}