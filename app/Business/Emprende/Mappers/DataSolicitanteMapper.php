<?php
//Date: 18 May 2018 /
namespace App\Business\Emprende\Mappers;

// Responses
use App\Business\Academia\Repositories\UserAcademyRepository;
use App\Http\Responses\Emprende\Solicitante\DatosSolicitanteResponse;
use App\Http\Responses\Emprende\solicitante\FilesScoreResponse;

//Models
use App\Http\Responses\Emprende\Solicitante\InitialDataResponse;
use App\Http\Responses\Emprende\Solicitante\ReferenceDataResponse;
use App\Models\Catalogs\CStatus;
use App\Models\EmpInitialDatum;
use App\Models\EmpReference;
use App\Models\Emprende\ApplicantDetail;

class DataSolicitanteMapper
{



    public static function fnInitialData($oModel, $idUserCourse)
    {

        $oInitial = new EmpInitialDatum();

        $oInitial->idStatus = CStatus::$ACTIVO;
        $oInitial->idUserCourse = $idUserCourse;
        $oInitial->idApplicationPlace = $oModel["idApplicationPlace"];
        $time = strtotime(date('y-m-d h:i:s'));
        $oInitial->applicationDate = date('Y-m-d H:i:s', $time);
        $oInitial->idTypeRequest = $oModel['idTypeRequest'];
        $oInitial->idSector = $oModel["idSector"];
        $oInitial->idLinkedBeneficiary = $oModel['idLinkedBeneficiary'];

        return $oInitial;
    }
    public static function fnGetInitialData($oModel)
    {

        $oInitial = new InitialDataResponse();

        $oInitial->idApplicationPlace = ($oModel == null) ? null : $oModel->idApplicationPlace;
        $oInitial->applicationDate = ($oModel == null) ? null : $oModel->applicationDate;
        $oInitial->idTypeRequest = ($oModel == null) ? null : $oModel->idTypeRequest;
        $oInitial->idSector = ($oModel == null) ? null : $oModel->idSector;
        $oInitial->idLinkedBeneficiary = ($oModel == null) ? null : $oModel->idLinkedBeneficiary;

        //nombres de catalogos
        $oInitial->nameSector = ($oModel == null) ? null : $oModel->c_sector->name;
        $oInitial->nameTypeRequest = ($oModel == null) ? null : $oModel->c_type_request->name;
        $oInitial->nameApplicationPlace = ($oModel == null) ? null : $oModel->c_municipality->municipality;
        $oInitial->nameLinkedBeneficiary = ($oModel == null) ? null : $oModel->c_affirmation_denial->name;

        return $oInitial;
    }

    public static function fnGetSolicitante($Applicant, $User, $phoneHome, $cellPhone)
    {

        $oModel = new DatosSolicitanteResponse();

        $oModel->firstName = $User->firstName;
        $oModel->lastName = $User->lastName;
        $oModel->secondLastName = $User->secondLastName;
        $oModel->idMatrimonialRegime = ($User == null) ? null : $User->idMatrimonialRegime;
        $oModel->idCivilStatus = $User->idCivilStatus;
        $oModel->birthdate = $User->birthdate->format('Y-m-d h:i:s');//$User->birthdate;
        $oModel->idGender = $User->idGender;
        $oModel->idCountryNationality = ($Applicant == null) ? null : $Applicant->idCountryNationality;
        $oModel->idCountryBirth = ($User == null) ? null : $User->idCountryBirth;
        $oModel->CURP = $User->CURP;

        $oModel->idType = ($Applicant == null) ? null : $Applicant->idType;
        $oModel->idIdentificationIssuer = ($Applicant == null) ? null : $Applicant->idIdentificationIssuer;
        $oModel->identificationNumber = ($Applicant == null) ? null : $Applicant->identificationNumber;

        $oModel->rfc = ($User == null) ? null : $User->rfc;
        $oModel->street = ($User == null) ? null : $User->street;
        $oModel->outsideNumber = ($User == null) ? null : $User->outsideNumber;
        $oModel->insideNumber = ($User == null) ? null : $User->insideNumber;
        $oModel->postalCode = ($User == null) ? null : $User->postalCode;
        $oModel->colony = ($User == null) ? null : $User->colony;
        $oModel->idMunicipality = ($User == null) ? null : $User->idMunicipality;
        $oModel->idFederalEntity = $User->c_municipality->idState;
     
        $oModel->cityLocality = ($User == null) ? null : $User->cityLocality;

        $oModel->cellPhoneNumber = ($cellPhone == null) ? null : $cellPhone;
        $oModel->phoneNumber = ($phoneHome == null) ? null : $phoneHome;

        $oModel->email = $User->email;

        $oModel->seniorityCurrentAddressYear = ($Applicant == null) ? null : $Applicant->seniorityCurrentAddressYear;
        $oModel->idCreditBuroScore = ($Applicant == null) ? null : $Applicant->idCreditBuroScore;
        $oModel->complete = ($Applicant == null) ? null : $Applicant->complete;

        // nombre de catalogo
        $oModel->nameMatrimonialRegime = $User->c_matrimonial_regime->name;
        $oModel->nameCivilStatus = $User->c_civil_status->name;
        $oModel->nameGender = $User->c_gender->name;
        $oModel->nameCountryNationality = $User->c_country->name;
        $oModel->nameCountryBirth = $User->c_country->name;
        $oModel->nameType = ($Applicant == null) ? null : $Applicant->c_id_type->name;
        $oModel->nameIdentificationIssuer =($Applicant == null) ? null : $Applicant->c_identification_issuer->name;
        $oModel->nameMunicipality = $User->c_municipality->municipality;
        $oModel->nameCreditBuroScore = ($Applicant == null) ? null : $Applicant->c_score->name;
        $oModel->nameFederalEntity = $User->c_municipality->c_state->name;

        return $oModel;
    }

    public static function fnGetReference($oModel)
    {

        $oReference = new ReferenceDataResponse();

        $oReference->idReference = $oModel->idReference;
        $oReference->businessName = ($oModel->businessName == null) ? null : $oModel->businessName;
        $oReference->firstName = $oModel->firstName;
        $oReference->lastName = $oModel->lastName;
        $oReference->secondLastName = $oModel->secondLastName;
        $oReference->phoneNumber = $oModel->phoneNumber;
        $oReference->idRelationshipApplicant = $oModel->idRelationshipApplicant;
        $oReference->other = ($oModel->other == null) ? null : $oModel->other;

        // nombres de catalogos
        $oReference->nameReference = $oModel->c_reference->name;
        $oReference->nameRelationshipApplicant = ($oModel->idRelationshipApplicant == null) ? null : $oModel->c_emp_relationship_applicant->name;

        return $oReference;

    }

    public static function fnApplicantDetail($oModel, $idUserCourse)
    {

        $oApplicant = new ApplicantDetail();

        $oApplicant->idStatus = CStatus::$ACTIVO;
        $oApplicant->idUserCourse = $idUserCourse;
        $oApplicant->complete = true;

        $oApplicant->idType = $oModel["idType"];
        $oApplicant->idIdentificationIssuer = $oModel["idIdentificationIssuer"];
        $oApplicant->idCountryNationality = $oModel["idCountryNationality"];
        $oApplicant->identificationNumber = $oModel["identificationNumber"];
        $oApplicant->seniorityCurrentAddressYear = $oModel["seniorityCurrentAddressYear"];
        $oApplicant->idCreditBuroScore = $oModel["idCreditBuroScore"];

        return $oApplicant;
    }

    public static function fnReference($oModel, $idUserCourse)
    {

        $oReference = new EmpReference();

        $oReference->idUserCourse = $idUserCourse;

        $oReference->idStatus = CStatus::$ACTIVO;
        $oReference->idReference = $oModel["idReference"];
        if ($oReference->idReference != 1) {
            $oReference->businessName = $oModel["businessName"];
        }

        $oReference->firstName = $oModel["firstName"];
        $oReference->lastName = $oModel["lastName"];
        $oReference->secondLastName = $oModel["secondLastName"];
        $oReference->phoneNumber = $oModel["phoneNumber"];
        $oReference->other = $oModel["other"];
        $oReference->idRelationshipApplicant = $oModel["idRelationshipApplicant"];
        return $oReference;

    }

    public static function fnUserData($oModel, $idUser)
    {

        $oUser = UserAcademyRepository::fnFind($idUser)->first();

        $oUser->firstName = $oModel["firstName"];
        $oUser->lastName = $oModel["lastName"];
        $oUser->secondLastName = $oModel["secondLastName"];
        $oUser->idCivilStatus = $oModel["idCivilStatus"];
        $oUser->idMatrimonialRegime = $oModel["idMatrimonialRegime"];
        $oUser->birthdate = $oModel["birthdate"];
        $oUser->idGender = $oModel["idGender"];
        $oUser->idCountryBirth = $oModel["idCountryBirth"];
        $oUser->CURP = $oModel["CURP"];
        $oUser->rfc = $oModel["rfc"];
        $oUser->street = $oModel["street"];
        $oUser->outsideNumber = $oModel["outsideNumber"];
        $oUser->insideNumber = $oModel["insideNumber"];
        $oUser->postalCode = $oModel["postalCode"];
        $oUser->colony = $oModel["colony"];
        $oUser->idMunicipality = $oModel["idMunicipality"];
        $oUser->cityLocality = $oModel["cityLocality"];
        $oUser->email = $oModel["email"];

        return $oUser;
    }

}
