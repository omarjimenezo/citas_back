<?php
namespace App\Business\Emprende\Queries;
//Date: 16 May 2018 / Ede nuñez
// Mappers
use App\Business\Emprende\Mappers\DataSolicitanteMapper;
use App\Business\Emprende\Mappers\DataNegocioMapper;
use App\Business\Emprende\Mappers\DataParticipanteMappers;
use App\Business\Emprende\Mappers\DataQualifyMapper;
use App\Business\Emprende\Mappers\DataQualificationMapper;
use App\Business\Academia\Mappers\PhoneNumberMapper;
use App\Business\Emprende\Mappers\DataTablaPagosMapper;
//Repositories
use  App\Business\Emprende\Repositories\Solicitante\InitialDataRepository;
use  App\Business\Emprende\Repositories\Solicitante\ApplicantDetailRepository;
use  App\Business\Emprende\Repositories\Solicitante\ReferenceRepository;
use  App\Business\Academia\Repositories\UserAcademyRepository;
use  App\Business\Emprende\Repositories\Negocio\BusinessDataRepository;
use  App\Business\Emprende\Repositories\Negocio\CreditDataRepository;
use  App\Business\Emprende\Repositories\Participante\ParticipanteRepository;
use  App\Business\Academia\Repositories\PhoneNumberRepository;
use App\Business\Emprende\Repositories\Archivos\UserFileRepository;
use App\Business\Emprende\Repositories\TablaPagos\TablaPagosRepository;
//
Use App\Business\Emprende\Calificar\CalificarPasos;
use App\Models\Emprende\InitialData;
use App\Models\Academia\PhoneNumber;
//Models
use App\Models\Catalogs\CTypeParticipants;
//Services
use App\Business\Emprende\Services\FileService;
// Querys
use App\Business\Emprende\Queries\UserFileQuery;

use DB;



class SolicitanteQuery{   

    // Forma un solo Json con todos los catalogos de emprende
    public static function fngetSolicitante($oUserCourse,$token){
        
        $data = [];
        $dataReference = [];
        $idUserCourse = $oUserCourse->id;
         // obtiene los datos del usuario logeado
        //  $oUser = UserAcademyRepository::fnFindByidUserCourse($idUserCourse)->first();
         $oUser = UserAcademyRepository::fnFindEm($oUserCourse->idUser)->first();
        
         if($oUser == null)
            return null;
    
        // obtiene los datos iniciales  por el id de usuario
        $oInitialData =  InitialDataRepository::fnAllByUser($idUserCourse)->first();
        
        $oInitialDataNew = DataSolicitanteMapper::fnGetInitialData($oInitialData);

        // obtiene los datos de detalle de aplicacion  por el id de usuario
        $oApplicate = ApplicantDetailRepository::fnAllByUser($idUserCourse)->first();

        // obtiene los datos de telefono del usuario
        $cellPhone = PhoneNumberRepository::fnFindIdPhone($oUser->id, PhoneNumber::$CELULAR);
        $cellPhone = ($cellPhone == null ) ? null : $cellPhone->phoneNumber . ' EXT '.$cellPhone->phoneExtension;
        $phoneHome = PhoneNumberRepository::fnFindIdPhone($oUser->id,PhoneNumber::$CASA);
        $phoneHome = ($phoneHome == null) ? null : $phoneHome->phoneNumber . ' EXT '.$phoneHome->phoneExtension;
        $phoneNegocio = PhoneNumberRepository::fnFindIdPhone($oUser->id,PhoneNumber::$NEGOCIO);
        $phoneNegocio = ($phoneNegocio == null) ? null : $phoneNegocio->phoneNumber . ' EXT '.$phoneNegocio->phoneExtension;
        // Crea los porma el modelo de los datos personales 
        $oDataSolicitante = DataSolicitanteMapper::fnGetSolicitante($oApplicate,$oUser,$phoneHome,$cellPhone);
        
      

        // obtiene las referencias del usuario  por el id de usuario
        $oReference = ReferenceRepository::fnFindByUser($idUserCourse)->get();
        //Crea modelo d referencias
        foreach ($oReference as $value) {
            $oReferenceNew =  DataSolicitanteMapper::fnGetReference($value);
            array_push($data,$oReferenceNew);
        }

        // obtiene los datos de negocio del usuario
        $oBusiness = BusinessDataRepository::fnAllByUser($idUserCourse)->first();
        // crea modelo de  datos de negocio
        $oBusinessNew = DataNegocioMapper::fnGetBusiness($oBusiness,$phoneNegocio);

        if($oBusinessNew->idMunicipality != null)       
             $oBusinessNew->idFederalEntity = ApplicantDetailRepository::fnFindEstate($oBusiness->idMunicipality)->first()->idState;
  

        // obtiene los datos de credito de usuario
        $oCredit= CreditDataRepository::fnAllByUser($idUserCourse)->first();
        // crea el modelo de datos de credito
        $oCreditNew = DataNegocioMapper::fnGetCredit($oCredit);

        // obtiene los datos de participante (solidario)
        $oSolidario = ParticipanteRepository::fnFindByUser($idUserCourse)->where("idParticipantsGuarantee",'=',1)->first();
        // crea modelo de datos de participante
        $oSolidarioNew = DataParticipanteMappers::fnGetParticipante($oSolidario);

        //Busca y agrega el idFederative desde el municipio       
        // $oSolidarioNew->idFederalEntity = ($oSolidarioNew->idMunicipality == null) ? null : ApplicantDetailRepository::fnFindEstate($oSolidarioNew->idMunicipality)->first()->idState;
  
        if($oDataSolicitante->idCreditBuroScore != null && $oSolidarioNew->idMunicipality != null) {
        
        //obtiene calificacion del paso
        $oRateNew =  DataQualifyMapper::fnQualify($oDataSolicitante->idCreditBuroScore,
                                                 $oSolidarioNew->idCreditBuroScore,
                                                 $oInitialDataNew->idLinkedBeneficiary,
                                                 $oBusinessNew->idMunicipality,
                                                 $oUser->idMunicipality);
        //obtiene calificacion del paso
        $oRate =  CalificarPasos::fnCalificaSolicitante($oRateNew);
    
        }
        else{
            $oRate = null;
        }

        $oRatenew =  DataQualificationMapper::fnQualification($oRate);
       
        // obtiele los archivos de escore de desusor solidario y solicitante
        $Files =  self::validFiles($idUserCourse, $oSolidario,$token);
        
        // llena array  con todos los datos de solicitante
        return array_merge(['datos_curso' => $oUserCourse,
                            'qualification' => $oRatenew,
                            'files' => $Files,
                            'initial_data' => $oInitialDataNew,
                            'applicant_detail' => $oDataSolicitante,
                            'datos_negocio' => $oBusinessNew,
                            'deudor_solidario' => $oSolidarioNew,
                            'reference' => $data,
                            'datos_credito' => $oCreditNew]);    
    }	

    public static function fnSaveSolicitante($oModel,$oUserCourse,$token){
     
        $idUserCourse = $oUserCourse->id;
        DB::beginTransaction();

        try {

            // crea modelo para tabla initildata
            $oInitialNew =  DataSolicitanteMapper::fnInitialData($oModel["initial_data"],$idUserCourse);

            //Guarda initialdata
            $oInitialData =  InitialDataRepository::fnSave($oInitialNew);

            //Crea modelo para oApplicantData
            $oApplicantNew =  DataSolicitanteMapper::fnApplicantDetail($oModel["applicant_detail"],$idUserCourse);
            
            // guarda en tabla oApplicantData
            $oApplicantData =  ApplicantDetailRepository::fnSave($oApplicantNew);

            // recorre array de referencias
            foreach ($oModel["reference"] as $value) {

                //Crea modelo d referencias
                $oReferenceNew =  DataSolicitanteMapper::fnReference($value,$idUserCourse);
                // Guarda en tabla reference
                $oApplicantData =  ReferenceRepository::fnSave($oReferenceNew);
            }

        $oBusinessNew = DataNegocioMapper::fnSaveBusiness($oModel['datos_negocio'],$idUserCourse);
         // Guarda en tabla negocio
        $oBusiness = BusinessDataRepository::fnSave($oBusinessNew);

        $oCreditNew = DataNegocioMapper::fnSaveCredit($oModel['datos_credito'], $idUserCourse);

        // Guarda en tabla de creditos
        $oCredit= CreditDataRepository::fnSave($oCreditNew);

        //--------------------------------------------------------------------------------------------
        //--------------------------------------------------------------------------------------------
            //inserta en la tabla amortizacion
            $oAmortizationNew = DataTablaPagosMapper::fnSaveAmortizacion($idUserCourse);
            // Guarda en tabla Amortization
            $oAmortization = TablaPagosRepository::fnSave($oAmortizationNew);

            // obtiene los meses por el id del catalogo
            
            $i= 12;
            $intRate = ($i/100) / 12;
            //inserta datos de tabla de credit destination

            //capital de trabajo ==
            if($oCredit->termWorkingCapital != null){
            $termWorkingCapital = intval(DB::table('c_short_term')->where('id',$oCredit->termWorkingCapital)->first()->name);
            $princ = $oCredit->workingCapitalCredit;
            $cuota_working = ($princ*$intRate)/(1-pow(1+$intRate,(-1*$termWorkingCapital)))*100/100;
            $working_capital    =  DataTablaPagosMapper::fnGetTypeCredit($oAmortizationNew->id, 1, $oCredit->workingCapitalCredit, $termWorkingCapital, $cuota_working);   // Caítal de trabajo
            $working = TablaPagosRepository::fnSave($working_capital);
            }

            //equipamieto
            if($oCredit->termEquipment != null){
            $termEquipment = intval(DB::table('c_another_credit')->select("name")->where('id',$oCredit->termEquipment)->first()->name);
            $princ = $oCredit->equipmentCredit;
            $cuota_equipment = ($princ*$intRate)/(1-pow(1+$intRate,(-1*$termEquipment)))*100/100;
            $equipment          =  DataTablaPagosMapper::fnGetTypeCredit($oAmortizationNew->id, 2, $oCredit->equipmentCredit, $termEquipment, $cuota_equipment);   // Equipamiento
            $equip = TablaPagosRepository::fnSave($equipment);
            }

            if($oCredit->termInfrastructure != null){
            $termInfrastructure = intval(DB::table('c_another_credit')->select("name")->where('id',$oCredit->termInfrastructure)->first()->name);
            $princ = $oCredit->infrastructureCredit;
            $cuota_frastructure  = ($princ*$intRate)/(1-pow(1+$intRate,(-1*$termInfrastructure)))*100/100;
            $infrastructure     =  DataTablaPagosMapper::fnGetTypeCredit($oAmortizationNew->id, 3, $oCredit->infrastructureCredit, $termInfrastructure, $cuota_frastructure);   // Infraestructura
            $infras = TablaPagosRepository::fnSave($infrastructure);
            }
            
            if($oCredit->termPassivePayment != null){
            $termPassivePayment = intval(DB::table('c_another_credit')->select("name")->where('id',$oCredit->termPassivePayment)->first()->name);
            $princ = $oCredit->passivePaymentCredit;
            $cuota = ($princ*$intRate)/(1-pow(1+$intRate,(-1*$termPassivePayment)))*100/100;
            $cuota_passive = ($princ*$intRate)/(1-pow(1+$intRate,(-1*$termPassivePayment)))*100/100;
            $passive_payments   =  DataTablaPagosMapper::fnGetTypeCredit($oAmortizationNew->id, 4, $oCredit->passivePaymentCredit, $termPassivePayment, $cuota_passive);   // Pago de pasivos
            $passive = TablaPagosRepository::fnSave($passive_payments);
            }

        //--------------------------------------------------------------------------------------------
        //--------------------------------------------------------------------------------------------

        $oparticipanteNew = DataParticipanteMappers::fnSaveParticipante($oModel["deudor_solidario"], $idUserCourse,CTypeParticipants::$DEUDOR_SOLIDARIO);
        
            // Guarda en tabla deudor solidario
            $oparticipante = ParticipanteRepository::fnSave($oparticipanteNew);

            //obtiene calificacion del paso
            $oRateNew = DataQualifyMapper::fnQualify($oApplicantNew->idCreditBuroScore,
                                                    $oparticipanteNew->idCreditBuroScore,
                                                    $oInitialNew->idLinkedBeneficiary,
                                                    $oBusinessNew->idMunicipality,
                                                    $oModel["applicant_detail"]["idMunicipality"]);
            //obtiene calificacion del paso
            $oRate =  CalificarPasos::fnCalificaSolicitante($oRateNew);
            
            $qualification =  DataQualificationMapper::fnQualification($oRate);

            DB::commit();

            return self::fngetSolicitante($oUserCourse,$token);
            
        } catch (\Throwable $e) {
            DB::rollback();
            throw $e;
        }


    }

    public static function validFiles($idUserCourse,$Solidario, $token){

        // if ($Solidario != null) {
        //     $solicitanteScore  = UserFileQuery::fnExistFilePath(null, $idUserCourse);
           
        //     $deudorScore = UserFileQuery::fnExistFilePath($Solidario->id, null);
        //     $services = new  FileService($token);
        //     $solicitanteScore = ($solicitanteScore == null) ? $services->getFileScoreSolicitante($idUserCourse) : $solicitanteScore;
        //     $deudorScore = ($deudorScore == null) ? $services->getFileScoreDeudor($Solidario->id) : $deudorScore;
             $rutaFileScore = "http://".$_SERVER['SERVER_NAME'] . '/Files/AUTORIZACIÓN%20PARA%20SOLICITAR%20REPORTES%20DE%20CRÉDITO.pdf';
             $solicitanteScore = $rutaFileScore;
             $deudorScore = $rutaFileScore;

             return array_merge(['fileScoreSolicitante' => $solicitanteScore, 'fileScoreDeudor' => $deudorScore]);
        // }
        // return array_merge(['fileScoreSolicitante' => null, 'fileScoreDeudor' => null]);
    }
}