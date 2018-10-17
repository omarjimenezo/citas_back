<?php
//Date: 11 June 2018 / Ede nuñez
namespace App\Business\Emprende\Queries;

// Mappers
use App\Business\Emprende\Mappers\DataUserFileMapper;
//Repositories
use App\Business\Emprende\Repositories\Archivos\UserFileRepository;
use App\Business\Emprende\Repositories\Participante\ParticipanteRepository;
use App\Bussiness\Academia\Repositories\UserRepository;
// Models
use App\Models\AcaUserFile;
use App\Models\CEmpFileName;
use App\Models\Catalogs\CStatus;
use App\Models\Emprende\ParticipantsGuarante as Participant;
use App\Models\Emprende\FileSystem as fileName;
use App\Models\Catalogs\CTypeParticipants;
//
use App\Business\Emprende\Constants\ConstantsEmprende;
use Illuminate\Support\Facades\File;




class UserFileQuery{   

    public static function fnSaveFile($oModel,$idUser){
      $paso = "Solicitante";

      $file = ($oModel["solicitante"]["identificationFile"] == null) ? null : $oModel["solicitante"]["identificationFile"];
      self::fnSaveFileUser($file,$paso,null,$idUser,fileName::$IDENTIFICACIÓN_OFICIAL);

      $file = ($oModel["solicitante"]["passport"] == null) ? null : $oModel["solicitante"]["passport"];
      self::fnSaveFileUser($file,$paso,null,$idUser,fileName::$PASAPORTE);

      $file = ($oModel["solicitante"]["matrimonialAct"] == null) ? null : $oModel["solicitante"]["matrimonialAct"];
      self::fnSaveFileUser($file,$paso,null,$idUser,fileName::$ACTA_MATRIMONIO);

      $file = ($oModel["solicitante"]["proofAddress"] == null) ? null : $oModel["solicitante"]["proofAddress"];
      self::fnSaveFileUser($file,$paso,null,$idUser,fileName::$COMPROBANTE_DOMICILIO);


      $file = ($oModel["deudor_solidario"]["identificationFile"] == null) ? null : $oModel["deudor_solidario"]["identificationFile"];
      self::fnSaveFileUser($file,$paso,Participant::$DEUDOR_SOLIDARIO,$idUser,fileName::$IDENTIFICACIÓN_OFICIAL);

      $file = ($oModel["deudor_solidario"]["passport"] == null) ? null : $oModel["deudor_solidario"]["passport"];
      self::fnSaveFileUser($file,$paso,Participant::$DEUDOR_SOLIDARIO,$idUser,fileName::$PASAPORTE);

      $file = ($oModel["deudor_solidario"]["matrimonialAct"] == null) ? null : $oModel["deudor_solidario"]["matrimonialAct"];
      self::fnSaveFileUser($file,$paso,Participant::$DEUDOR_SOLIDARIO,$idUser,fileName::$ACTA_MATRIMONIO);

      $file = ($oModel["deudor_solidario"]["proofAddress"] == null) ? null : $oModel["deudor_solidario"]["proofAddress"];
      self::fnSaveFileUser($file,$paso,Participant::$DEUDOR_SOLIDARIO,$idUser,fileName::$COMPROBANTE_DOMICILIO);
    


      $file = ($oModel["negocio"]["proofAddress"] == null) ? null : $oModel["negocio"]["proofAddress"];
      self::fnSaveFileUser($file,$paso,null,$idUser,fileName::$COMPROBANTE_DOMICILIO);

      $file = ($oModel["negocio"]["bankCart"] == null) ? null : $oModel["negocio"]["bankCart"];
      self::fnSaveFileUser($file,$paso,null,$idUser,fileName::$CARÁTULA_BANCO);

      $file = ($oModel["negocio"]["opinionPositiveSat"] == null) ? null : $oModel["negocio"]["opinionPositiveSat"];
      self::fnSaveFileUser($file,$paso,null,$idUser,fileName::$CARTA_OPINIÓN_POSITIVA_SAT);

      $file = ($oModel["negocio"]["fiscalSituationSat"] == null) ? null : $oModel["negocio"]["fiscalSituationSat"];
      self::fnSaveFileUser($file,$paso,null,$idUser,fileName::$CONSTANCIA_SITUACIÓN_SAT);

      $file = ($oModel["negocio"]["propertyReceipt"] == null) ? null : $oModel["negocio"]["propertyReceipt"];
      self::fnSaveFileUser($file,$paso,null,$idUser,fileName::$RECIBO_PREDIAL_VIGENTE);



    //   self::fnSaveFileUser($oModel->rfcFile,$paso,"RFC",$oModel->idUser,10);

    }	


    public static function fnSaveFileUser($file,$folderName,$idGuarante,$idUser,$idFile){

        try{

            if($file == null){
                //crea onjeto de file
                $oFileNew = DataUserFileMapper::fnSaveFile($idFile,null,$idUser,$idGuarante);
                //guarda registro de de file
                $oFile = UserFileRepository::fnSave($oFileNew);
            }

            //obtenemos el campo file definido en el formulario
            $Ext = $file->getClientOriginalExtension();
            $nameEncrypt = UserRepository::fnGetUserCode($idUser)->studentCode;
            //si no existe la carpeta del usuario la crea
            $FolderUser = base_path() . ConstantsEmprende::$basePathFilesStudents .$nameEncrypt;
            if (!File::exists($FolderUser)) {
                File::makeDirectory($FolderUser, '0777', true, true);
            }
            $fileName = CEmpFileName::where("id",$idFile).first();

            $fileName = $fileName->name. "." .$Ext;
            $ruta = base_path() . ConstantsEmprende::$basePathFilesStudents .$nameEncrypt .'/' . $folderName; 
            //comprueba si existe la carpeta del paso y si no la crea
            
            if (!File::exists($ruta)) {            
                File::makeDirectory($ruta, '0777', true, true);            
            }   

            $rutaAll = $ruta . '/' . $fileName;
            //crea onjeto de file
            $oFileNew = DataUserFileMapper::fnSaveFile($idFile,$rutaAll,$idUser,$idGuarante);
            //guarda registro de de file
            $oFile = UserFileRepository::fnSave($oFileNew);
            //Guarda el archivo en la ruta con el nuevo nombre
            $file->move($ruta,$fileName);

            return true;
        }
        catch(Exception $err){

            return "Erro: ". $err;
        }
    }

    
    public static function fnExistFile($oFies){

        if ($oFies->idAval !=null) {
          $result = UserFileRepository::fnFindGuarrante($oFies->idAval)->where("createdFile", 1)->first();
          return ($result == null) ? false : true;
        }else{

            $result = ParticipanteRepository::fnFindProperty($oFies->idAval, CTypeParticipants::$DATOS_AVAL);
            
            foreach ($result as $value) {
               $valor = UserFileRepository::fnFindGuarrante($value->id)
                                            ->where("createdFile", 1)->first();
                if($valor == null) 
                    return false;
            }
            return true;
        }
    }

    public static function isFileCreated($filePath){
        $uri = base64_decode($filePath);
        $result = UserFileRepository::fnGetIsCreatedFile($uri)->first();
        if($result == null)
            return $result;
        return  ($result->createdFile == 1) ? true : false;
    }

    public static function fnExistFilePath($id, $idUserCourse){
        $result = UserFileRepository::fnGetExistFile($id, $idUserCourse)->first();
        // dd($result);
         if($result == null) 
            return null; 
         return ($result->createdFile == 0) ? null : $result->pathFile;
    }
}