<?php
//Date: 24 Jun 2018 / Ede nuñez
namespace App\Business\Emprende\Queries;

// Mappers
use App\Business\Emprende\Mappers\DataGarantiaMapper;
use App\Business\Emprende\Mappers\DataQualificationMapper;
//Repositories
use  App\Business\Emprende\Repositories\Garantia\PropertyReceiptRepository;
use  App\Business\Emprende\Repositories\Garantia\WarrantyRepository;
use App\Business\Emprende\Repositories\Participante\ParticipanteRepository;
use  App\Business\Emprende\Repositories\Solicitante\ApplicantDetailRepository;
use  App\Business\Emprende\Repositories\Negocio\CreditDataRepository;
use App\Business\Emprende\Repositories\Archivos\UserFileRepository;
// Models
use App\Models\Catalogs\CStatus;
use App\Models\Catalogs\CTypeParticipants;
use App\Models\EmpParticipantsGuarantee;
// Business calificar
Use App\Business\Emprende\Calificar\CalificarPasos;
//Services
use App\Business\Emprende\Services\FileService;
// Querys
use App\Business\Emprende\Queries\UserFileQuery;
use DB;



class GarantiaQuery{   

 
    public static function fnGetGarantia($idUserCourse, $token){
    $file = "http://".$_SERVER['SERVER_NAME'] . '/Files/AUTORIZACIÓN%20PARA%20SOLICITAR%20REPORTES%20DE%20CRÉDITO.pdf';

        $dataGeneral = [];
        $oAvalesNew = [];
        $scoreAvales = [];
        $dataLegal = null;

        // obtiene los datos de credito de usuario
        $totalAmount = CreditDataRepository::fnAllByUser($idUserCourse)->first();

        $totalAmount = ($totalAmount == null) ? null  : $totalAmount->totalAmount;        
        //Obtiene datos de warranty por usuario
        $warranty = WarrantyRepository::fnFindByUser($idUserCourse)->first();
        if($warranty == null)
             return $data =  array_merge(["totalAmount" => $totalAmount]);
        
        $oWarrantyNew = DataGarantiaMapper::fnGetWarranty($warranty);
        // obtiene las garantias del usuario  por el id de warranty
        $property = PropertyReceiptRepository::fnFindWarranty($warranty->id)->get();
   
        //Recorre registros de PropertyReceipt
        foreach ($property as $value) {
            // mapea objeto de PropertyReceipt
            $data = DataGarantiaMapper::fnGetProperty($value);
            
            // valida si es una persona moral
            if ($warranty->idPropertyPhysicalPerson == 2) {
                
                //Obtiene Avales por medio de idPropertyReceipt
                $avalesLegal = ParticipanteRepository::fnFindProperty($value->id,CTypeParticipants::$REPRESENTANTE_LEGAL)->first();
                
                //Mapea objeto de aval
                $dataLegal = DataGarantiaMapper::fnGetAvales($avalesLegal,
                                                                1,
                                                                null);
                //Busca y agrega el idFederative desde el municipio         
                $dataLegal->idFederalEntity = ($dataLegal->idMunicipality == null) ? null :ApplicantDetailRepository::fnFindEstate($dataLegal->idMunicipality)->first()->idState;
                // obtiene los escore de todos los avales
                array_push($scoreAvales,$dataLegal->idCreditBuroScore);
            }
            //Obtiene Avales por medio de idPropertyReceipt
            $avales = ParticipanteRepository::fnFindProperty($value->id,CTypeParticipants::$DATOS_AVAL)->get();
                //Recorre registro de avales 
                foreach ($avales as $val) {
                    
                    //obtiene file del aval
                    // $file = UserFileRepository::fnFindGuarrante($val->id)->first();
                    
                    // $file = ($file == null) ? null : $file->pathFile;
                    // $file = $_file;
                    //Mapea objeto de aval
                    $dataA = DataGarantiaMapper::fnGetAvales($val,
                                                            ($oWarrantyNew->idPropertyPhysicalPerson == 2) 
                                                                ? 0: 1,$file);
                    // obtiene los escore de todos los avales
                    array_push($scoreAvales,$dataA->idCreditBuroScore);
                    //Busca y agrega el idFederative desde el municipio         
                    $dataA->idFederalEntity = ApplicantDetailRepository::fnFindEstate($dataA->idMunicipality)->first()->idState;
                    array_push($oAvalesNew,$dataA);
                }
            array_push($dataGeneral,array_merge(["recibo_predial" => $data,"datos_avales" => $oAvalesNew,"representante_legal" => $dataLegal]));
            $oAvalesNew = [];
        }

         //obtiene calificacion del paso
         $oRate =  (count($scoreAvales) > 0) ? CalificarPasos::fnCalificaGarantia($scoreAvales) : null;
         $oRatenew =  DataQualificationMapper::fnQualification($oRate);

        
         
        
        return $data = array_merge(["totalAmount" => $totalAmount,
                                    'qualification' => $oRatenew,
                                    "warranty"=>$oWarrantyNew,
                                    "aval"=> $dataGeneral]);
    }	

    public static function validFiles($idaval,$token){
       
            $services = new  FileService($token);
            $avalScore = UserFileQuery::fnExistFilePath($idaval, null);
            return ($avalScore == null) ? $services->getFileScoreDeudor($idaval) : $avalScore;
    }

    public static function fnSaveGarantia($oModel, $idUserCourse,$token){

        DB::beginTransaction();

        try {

        $scoreAvales =[];
        // llena modelo de Warranty
        $oWarrantyNew = DataGarantiaMapper::fnSaveWarranty($oModel["warranty"],$idUserCourse);
        // dd($oWarrantyNew->idPropertyPhysicalPerson,$oProperty->id);
        // Guarda Warranty
         $owarranty = WarrantyRepository::fnSave($oWarrantyNew);

            foreach ($oModel["aval"] as $value) {
                // llena objeto de PropertyReceipt
                $oPropertyNew = DataGarantiaMapper::fnSaveProperty($value["recibo_predial"],$owarranty->id);
             
                // guarda Property
                  $oProperty = PropertyReceiptRepository::fnSave($oPropertyNew);
                   
                    foreach ($value["datos_avales"] as $valueAval ) {
                        // llena modelo de avales
                        $oAvalNew = DataGarantiaMapper::fnSaveAvales($valueAval,
                                                                     $idUserCourse,
                                                                     CTypeParticipants::$DATOS_AVAL,
                                                                     $oProperty->id,
                                                                     ($oWarrantyNew->idPropertyPhysicalPerson == 2) 
                                                                     ? 0: 1
                                                                     );
                        
                        //Guarda los avales
                         $oAvales = ParticipanteRepository::fnSave($oAvalNew);
                        // invoca servicio para generar documento de score por aval
                        //  self::validFiles($oAvales->id,$token);
                         // obtiene los escore de todos los avales
                         array_push($scoreAvales,$oAvalNew->idCreditBuroScore);
                        }
                if ($oWarrantyNew->idPropertyPhysicalPerson == 2) {
                    foreach ($value["representante_legal"] as $valueLegal ) {
                         // llena modelo de avales
                        $oLegalNew = DataGarantiaMapper::fnSaveAvales($valueLegal,
                                                                      $idUserCourse,
                                                                      CTypeParticipants::$REPRESENTANTE_LEGAL,
                                                                      $oProperty->id,
                                                                      0
                                                                      );
                       
                          //Guarda los avales
                          $oAvales = ParticipanteRepository::fnSave($oLegalNew);
                          // obtiene los escore del representante legal
                          array_push($scoreAvales,$oLegalNew->idCreditBuroScore);  
                    }
                }
                }
          
        //obtiene calificacion del paso
        $oRate =  CalificarPasos::fnCalificaGarantia($scoreAvales);
        $oRatenew =  DataQualificationMapper::fnQualification($oRate);

        // DB::commit();
        
        return self::fnGetGarantia($idUserCourse, $token);

         } catch (\Throwable $e) {
            DB::rollback();
            throw $e;
        }

    }	
    
//     public static function fnSaveWarranty($oModel,$idUserCourse){
//         // llena modelo de Warranty
//         $oWarrantyNew = DataGarantiaMapper::fnSaveWarranty($oModel["warranty"],$idUserCourse);
//         // Guarda Warranty
//         $owarranty = WarrantyRepository::fnSave($oWarrantyNew);
//         return $owarranty->id;
//     }

//     public static function fnSaveProperty($oModel,$idUserCourse){

//          // llena objeto de PropertyReceipt
//          $oPropertyNew = DataGarantiaMapper::fnSaveProperty($oModel["recibo_predial"]);
//          // guarda Property
//          $oProperty = PropertyReceiptRepository::fnSave($oPropertyNew);

//          return   $oProperty->id;
//     }

//     public static function fnSaveAval($oModel,$idUserCourse){
//          // llena modelo de avales
//          $oAvalesNew = DataGarantiaMapper::fnSaveAvales($oModel["datos_avales"],
//                                                           $idUserCourse,
//                                                           CTypeParticipants::$DATOS_AVAL, 1);
//         //Guarda los avales
//         $oAvales = ParticipanteRepository::fnSave($oAvalesNew);
        
//         return  $oAvales->id;
//     }

//     public static function fnSaveAvalMoral($oModel,$idUserCourse){
//         // llena modelo de avales
//         $oAvalesNew = DataGarantiaMapper::fnSaveAvales($oModel["datos_avales"],
//                                                          $idUserCourse,
//                                                          CTypeParticipants::$DATOS_AVAL, 2);
//        //Guarda los avales
//        $oAvales = ParticipanteRepository::fnSave($oAvalesNew);
       
//        return  $oAvales->id;
//    }

//     public static function fnSavePropertyRepresent($oModel,$idUserCourse){

//          // llena objeto de PropertyReceipt
//          $oPropertyNew = DataGarantiaMapper::fnSaveProperty($oModel["recibo_predial"]);
//          // guarda Property
//          $oProperty = PropertyReceiptRepository::fnSave($oPropertyNew);
//         // dd($oProperty->id);
         
//         // llena modelo de avales
//         $oAvalesNew = DataGarantiaMapper::fnSaveAvales($oModel["representante_legal"],
//                                                          $idUserCourse,
//                                                          CTypeParticipants::$REPRESENTANTE_LEGAL,
//                                                          1,
//                                                          $oProperty->id);
//         //Guarda los avales
//         $oAvales = ParticipanteRepository::fnSave($oAvalesNew);

       

//        return  array_merge(["idAval" => $oAvales->id, "idProperty" => $oProperty->id]);
//    }

//     public static function fnDeleteAval($idAval){
//       //Elimina un aval
//         return ParticipanteRepository::fnDelete($idAval);

//     }

//     public static function fnDeleteProperty($idProperty){
//         //Obtiene Avales por medio de idPropertyReceipt
//         $avalesLegal = ParticipanteRepository::fnFindProperty($idProperty)->get();
//         if (count($avalesLegal) > 0) {
//             foreach ($avalesLegal as $value) {
//                 //Elimina los avales del predial selecionado
//                 self::fnDeleteAval($value->id);
//             }
//         }
//         //Elimina un predial
//         PropertyReceiptRepository::fnDelete($idProperty);
//     }


}