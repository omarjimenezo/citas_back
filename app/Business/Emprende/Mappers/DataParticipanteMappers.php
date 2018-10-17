<?php
//Date: 24 May 2018 /
namespace App\Business\Emprende\Mappers;

//Models
use App\Models\EmpParticipantsGuarantee;
use App\Models\Catalogs\CStatus;
use App\Models\Emprende\ParticipantsGuarante;
// responses
use App\Http\Responses\Emprende\Participante\ParticipanteResponse;


class DataParticipanteMappers{   

    public static function fnGetParticipante($oParticipante){
  
        $oModel = new ParticipanteResponse(); 
        
        $oModel->idParticipantsGuarantee =  ($oParticipante == null) ? null : $oParticipante->idParticipantsGuarantee;
        $oModel->firstName =  ($oParticipante == null) ? null : $oParticipante->firstName;
        $oModel->lastName = ($oParticipante == null) ? null : $oParticipante->lastName;
        $oModel->secondLastName = ($oParticipante == null) ? null :$oParticipante->secondLastName;
        $oModel->rfc = ($oParticipante == null) ? null : $oParticipante->rfc;
        $oModel->idGender = ($oParticipante == null) ? null : $oParticipante->idGender;
        $oModel->idCivilStatus = ($oParticipante == null) ? null : $oParticipante->idCivilStatus;
        $oModel->idMatrimonialRegime = ($oParticipante == null) ? null : $oParticipante->idMatrimonialRegime;
        $oModel->birthdate = ($oParticipante == null) ? null : date('Y-m-d H:i:s', strtotime($oParticipante->birthdate));
        $oModel->idCountryNationality = ($oParticipante == null) ? null : $oParticipante->idCountryNationality;
        $oModel->idCountryBirth = ($oParticipante == null) ? null : $oParticipante->idCountryBirth;
        $oModel->CURP = ($oParticipante == null) ? null : $oParticipante->CURP;
        $oModel->street = ($oParticipante == null) ? null : $oParticipante->street;
        $oModel->outsideNumber = ($oParticipante == null) ? null : $oParticipante->outsideNumber;
        $oModel->insideNumber = ($oParticipante == null) ? null : $oParticipante->insideNumber;
        $oModel->postalCode = ($oParticipante == null) ? null : $oParticipante->postalCode;
        $oModel->colony = ($oParticipante == null) ? null : $oParticipante->colony;
        $oModel->idMunicipality = ($oParticipante == null) ? null : $oParticipante->idMunicipality;
        $oModel->cityLocality = ($oParticipante == null) ? null : $oParticipante->cityLocality;
        $oModel->cellPhoneNumber = ($oParticipante == null) ? null : $oParticipante->cellPhoneNumber;
        $oModel->phoneNumber = ($oParticipante == null) ? null : $oParticipante->phoneNumber;
        $oModel->email = ($oParticipante == null) ? null : $oParticipante->email;
        $oModel->idType = ($oParticipante == null) ? null : $oParticipante->idType;
        $oModel->identificationNumber = ($oParticipante == null) ? null : $oParticipante->identificationNumber;
        $oModel->idIdentificationIssuer = ($oParticipante == null) ? null : $oParticipante->idIdentificationIssuer;
        $oModel->idCreditBuroScore  = ($oParticipante == null) ? null : $oParticipante->idCreditBuroScore;
        $oModel->seniorityCurrentAddressYear = ($oParticipante == null) ? null : $oParticipante->seniorityCurrentAddressYear;
        $oModel->preponderantEconomicActivity  = ($oParticipante == null) ? null : $oParticipante->preponderantEconomicActivity;
        $oModel->idSourceIncome = ($oParticipante == null) ? null : $oParticipante->idSourceIncome;
        $oModel->idFederalEntity = ($oParticipante == null) ? null : $oParticipante->c_municipality->idState;

        //nombre de catalogos
        $oModel->nameParticipantsGuarantee = ($oParticipante == null) ? null : $oParticipante->c_emp_participants_guarantee->name;
        $oModel->nameGender = ($oParticipante == null) ? null : $oParticipante->c_gender->name;
        $oModel->nameCivilStatus = ($oParticipante == null) ? null : $oParticipante->c_civil_status->name;
  
     

                if($oParticipante != null){
                    if($oParticipante->c_matrimonial_regime != null){
                        $oModel->nameMatrimonialRegime =  $oParticipante->c_matrimonial_regime->name;
                    }else{
                        $oModel->nameMatrimonialRegime =  null;
                    }
                }
                else{
                    $oModel->nameMatrimonialRegime =  null;
                }
                    
            
        $oModel->nameCountryNationality = ($oParticipante == null) ? null : $oParticipante->c_country->name;
        $oModel->nameCountryBirth = ($oParticipante == null) ? null : $oParticipante->c_country->name;
        $oModel->nameMunicipality = ($oParticipante == null) ? null : $oParticipante->c_municipality->municipality;
        $oModel->nameType = ($oParticipante == null) ? null : $oParticipante->c_id_type->name;
        $oModel->nameIdentificationIssuer = ($oParticipante == null) ? null : $oParticipante->c_identification_issuer->name;;
        $oModel->nameCreditBuroScore  = ($oParticipante == null) ? null : $oParticipante->c_score->name;
        $oModel->nameSourceIncome = ($oParticipante == null) ? null : $oParticipante->c_emp_source_income->name;
        $oModel->nameFederalEntity = ($oParticipante == null) ? null : $oParticipante->c_municipality->c_state->name;

       return $oModel;

    }

    public static function fnSaveParticipante($oParticipante,$idUserCourse,$typeParticipants){
        
        $oModel = new ParticipantsGuarante();  
       
        $oModel->idStatus = CStatus::$ACTIVO;
        $oModel->idUserCourse = $idUserCourse;

        $oModel->idParticipantsGuarantee = ($oParticipante == null) ? null : $typeParticipants;
        $oModel->firstName =  $oParticipante['firstName'];
        $oModel->lastName =  $oParticipante['lastName'];
        $oModel->secondLastName = ($oParticipante == null) ? null : $oParticipante['secondLastName'];
        $oModel->rfc = ($oParticipante == null) ? null : $oParticipante['rfc'];
        $oModel->idGender = ($oParticipante == null) ? null : $oParticipante['idGender'];
        $oModel->idCivilStatus = ($oParticipante == null) ? null : $oParticipante['idCivilStatus'];
        $oModel->idMatrimonialRegime = ($oParticipante == null) ? null : ($oModel->idCivilStatus == 2) ? null: $oParticipante['idMatrimonialRegime'];
        $time = ($oParticipante == null) ? null :strtotime($oParticipante['birthdate']);
        $oModel->birthdate = ($oParticipante == null) ? null : date('Y-m-d H:i:s',$time);;
        $oModel->idCountryNationality = ($oParticipante == null) ? null : $oParticipante['idCountryNationality'];
        $oModel->idCountryBirth = ($oParticipante == null) ? null : $oParticipante['idCountryBirth'];
        $oModel->CURP = ($oParticipante == null) ? null : $oParticipante['CURP'];
        $oModel->street = ($oParticipante == null) ? null : $oParticipante['street'];
        $oModel->outsideNumber = ($oParticipante == null) ? null : $oParticipante['outsideNumber'];
        $oModel->insideNumber = ($oParticipante == null) ? null : $oParticipante['insideNumber'];
        $oModel->postalCode = ($oParticipante == null) ? null : $oParticipante['postalCode'];
        $oModel->colony = ($oParticipante == null) ? null : $oParticipante['colony'];
        $oModel->idMunicipality = ($oParticipante == null) ? null : $oParticipante['idMunicipality'];
        $oModel->cityLocality = ($oParticipante == null) ? null : $oParticipante['cityLocality'];
        $oModel->cellPhoneNumber = ($oParticipante == null) ? null : $oParticipante['cellPhoneNumber'];
        $oModel->phoneNumber = ($oParticipante == null) ? null : $oParticipante['phoneNumber'];
        $oModel->email = ($oParticipante == null) ? null : $oParticipante['email'];
        $oModel->idType = ($oParticipante == null) ? null : $oParticipante['idType'];
        $oModel->identificationNumber = ($oParticipante == null) ? null : $oParticipante['identificationNumber'];
        $oModel->idIdentificationIssuer = ($oParticipante == null) ? null : $oParticipante['idIdentificationIssuer'];
        $oModel->idCreditBuroScore  = ($oParticipante == null) ? null : $oParticipante['idCreditBuroScore'];
        $oModel->seniorityCurrentAddressYear = ($oParticipante == null) ? null : $oParticipante['seniorityCurrentAddressYear'];
        $oModel->preponderantEconomicActivity = ($oParticipante == null) ? null : $oParticipante['preponderantEconomicActivity'];
        $oModel->idSourceIncome = ($oParticipante == null) ? null : $oParticipante['idSourceIncome'];


    return $oModel;
            
    }
    
}
