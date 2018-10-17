<?php
/**
 * Created by PhpStorm.
 * User: Bioxor
 * Date: 06/06/2018
 * Time: 03:31 PM
 */

namespace App\Business\Emprende\Mappers;


use App\Models\AcaUserFile;

class DataAcaUserFileMapper
{
   public static function ModelAcaUserFile($oData){
      $oModel = new AcaUserFile();
      $oModel->idStatus = 1;
      $oModel->idUser = $oData['idUser'];
      $oModel->idFileName = $oData['idFileName'];
      $oModel->pathFile = $oData['pathFile'];
      $oModel->idParticipantsGuarantee = $oData['idParticipantsGuarantee'];
      return $oModel;
   }
}