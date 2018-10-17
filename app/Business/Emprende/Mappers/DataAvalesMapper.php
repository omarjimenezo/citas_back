<?php
//Date: 24 May 2018 /
namespace App\Business\Emprende\Mappers;

//Models
use App\Models\Emprende\ParticipantsGuarantee;
use App\Models\Catalogs\CStatus;

class DataAvalesMapper{   

    public static function fnAvales($oParticipante,$iValor){

                $oModel = new ParticipantsGuarantee();  

                if ($iValor == 1) {
                    $oModel->idStatus = ($oParticipante['idStatus'] == null) ? CStatus::$ACTIVO :$oParticipante['idStatus'] ;
                    $oModel->idUser = $oParticipante['idUser'];
                }

                $oModel->idParticipantsGuarantee = $oParticipante['idParticipantsGuarantee'];
                $oModel->firstName =  $oParticipante['firstName'];
                $oModel->secondName =  $oParticipante['secondName'];
                $oModel->lastName =  $oParticipante['lastName'];
                $oModel->secondLastName = $oParticipante['secondLastName'];
                $oModel->idGender = $oParticipante['idGender'];
                $oModel->idCivilStatus = $oParticipante['idCivilStatus'];
                $oModel->idMatrimonialRegime = $oParticipante['idMatrimonialRegime'];
                $oModel->birthdate = $oParticipante['birthdate'];
                $oModel->idCountryNationality = $oParticipante['idCountryNationality'];
                $oModel->idCountryBirth = $oParticipante['idCountryBirth'];
                $oModel->idBirthdateState = $oParticipante['idBirthdateState'];
                $oModel->rfc = $oParticipante['rfc'];
                $oModel->homoclave = $oParticipante['homoclave'];
                $oModel->CURP = $oParticipante['CURP'];
                $oModel->street = $oParticipante['street'];
                $oModel->outsideNumber = $oParticipante['outsideNumber'];
                $oModel->insideNumber = $oParticipante['insideNumber'];
                $oModel->postalCode = $oParticipante['postalCode'];
                $oModel->colony = $oParticipante['colony'];
                $oModel->idMunicipality = $oParticipante['idMunicipality'];
                $oModel->cityLocality = $oParticipante['cityLocality'];
                $oModel->idFederalEntity = $oParticipante['idFederalEntity'];
                $oModel->phoneNumber = $oParticipante['phoneNumber'];
                $oModel->cellPhoneNumber = $oParticipante['cellPhoneNumber'];
                $oModel->email = $oParticipante['email'];
                $oModel->idType = $oParticipante['idType'];
                $oModel->identificationNumber = $oParticipante['identificationNumber'];
                $oModel->idIdentificationIssuer = $oParticipante['idIdentificationIssuer'];
                $oModel->idRelationship  = $oParticipante['idRelationship'];
                $oModel->preponderantEconomicActivity = $oParticipante['preponderantEconomicActivity'];
                $oModel->idCreditBuroScore = $oParticipante['idCreditBuroScore'];

                return $oModel;
        }
     }

    