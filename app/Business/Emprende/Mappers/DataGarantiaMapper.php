<?php
//Date: 24 May 2018 /
namespace App\Business\Emprende\Mappers;

//Models
use App\Models\Emprende\ParticipantsGuarante;
use App\Models\Catalogs\CStatus;
use App\Models\EmpPropertyReceipt;
use App\Models\EmpWarranty;
use App\Models\EmpParticipantsGuarantee;
//Repositories
use App\Business\Emprende\Repositories\Garantia\PropertyReceiptRepository;
use App\Business\Emprende\Repositories\Garantia\WarrantyRepository;
use App\Business\Emprende\Repositories\Participante\ParticipanteRepository;
//Responses
use App\Http\Responses\Emprende\Garantia\PropertyReceiptResponse;
use App\Http\Responses\Emprende\Garantia\WarrantyResponse;
use App\Http\Responses\Emprende\Garantia\ParticipantsGuarranteResponse;


class DataGarantiaMapper{   

    public static function fnGetWarranty($oModel){

            $warranty = new WarrantyResponse();
            $warranty->idPropertyPhysicalPerson = ($oModel == null) ? null : $oModel->idPropertyPhysicalPerson;
            $warranty->idNumberPropertiesReceive = ($oModel == null) ? null : $oModel->idNumberPropertiesReceive;
            $warranty->complete = ($oModel == null) ? false : $oModel->complete;  

            // nombre de los catalogos
            $warranty->namePropertyPhysicalPerson = ($oModel == null) ? null : $oModel->c_affirmation_denial->name;
            $warranty->nameNumberPropertiesReceive = ($oModel == null) ? null : $oModel->c_emp_answer_number->name;
            
            return $warranty;
    }

    public static function fnGetProperty($oModel){

        $property = new PropertyReceiptResponse();

        $property->propertyAccountNumber = ($oModel == null) ? null : $oModel->propertyAccountNumber;
        $property->idKindProperty = ($oModel == null) ? null : $oModel->idKindProperty;
        $property->indicateTypeProperty = ($oModel == null) ? null : $oModel->indicateTypeProperty;
        $property->description = ($oModel == null) ? null : $oModel->description;
        $property->location = ($oModel == null) ? null : $oModel->location;
        $property->fiscalValue = ($oModel == null) ? null : $oModel->fiscalValue;
        $property->numberOwners = ($oModel == null) ? null : $oModel->numberOwners;

        // nombre de los catalogos
        $property->nameKindProperty = ($oModel == null) ? null : $oModel->c_property->name;

        return $property;
    }

    public static function fnGetAvales($oParticipante,$type,$file){
       
        $oModel = new ParticipantsGuarranteResponse();  
        $oModel->file = $file;

        if ($type == 1) {
            
            $oModel->firstName  = ($oParticipante == null) ? null : $oParticipante->firstName;
            $oModel->lastName  = ($oParticipante == null) ? null : $oParticipante->lastName;
            $oModel->secondLastName  = ($oParticipante == null) ? null : $oParticipante->secondLastName;
            $oModel->rfc  = ($oParticipante == null) ? null : $oParticipante->rfc;
            $oModel->idGender  = ($oParticipante == null) ? null : $oParticipante->idGender;
            $oModel->idCivilStatus  = ($oParticipante == null) ? null : $oParticipante->idCivilStatus;
            $oModel->idMatrimonialRegime  = ($oParticipante == null) ? null : $oParticipante->idMatrimonialRegime;
            $oModel->birthdate  = ($oParticipante == null) ? null : $oParticipante->birthdate->format('Y-m-d H:i:s');
            $oModel->idCountryNationality  = ($oParticipante == null) ? null : $oParticipante->idCountryNationality;
            $oModel->idCountryBirth  = ($oParticipante == null) ? null : $oParticipante->idCountryBirth;
            $oModel->CURP  = ($oParticipante == null) ? null : $oParticipante->CURP;
            $oModel->street  = ($oParticipante == null) ? null : $oParticipante->street;
            $oModel->outsideNumber  = ($oParticipante == null) ? null : $oParticipante->outsideNumber;
            $oModel->insideNumber  = ($oParticipante == null) ? null : $oParticipante->insideNumber;
            $oModel->postalCode  = ($oParticipante == null) ? null : $oParticipante->postalCode;
            $oModel->colony  = ($oParticipante == null) ? null : $oParticipante->colony;
            $oModel->idMunicipality  = ($oParticipante == null) ? null : $oParticipante->idMunicipality;
            $oModel->idFederalEntity  = ($oParticipante == null) ? null : $oParticipante->idFederalEntity;
            $oModel->cityLocality = ($oParticipante == null) ? null :$oParticipante->cityLocality;
            $oModel->phoneNumber  = ($oParticipante == null) ? null : $oParticipante->phoneNumber;
            $oModel->cellPhoneNumber  = ($oParticipante == null) ? null : $oParticipante->cellPhoneNumber;
            $oModel->email  = ($oParticipante == null) ? null : $oParticipante->email;
            $oModel->idType  = ($oParticipante == null) ? null : $oParticipante->idType;
            $oModel->identificationNumber  = ($oParticipante == null) ? null : $oParticipante->identificationNumber;
            $oModel->idIdentificationIssuer  = ($oParticipante == null) ? null : $oParticipante->idIdentificationIssuer;
            $oModel->idCreditBuroScore  = ($oParticipante == null) ? null : $oParticipante->idCreditBuroScore;
            $oModel->relationshipApplicant  = ($oParticipante == null) ? null : $oParticipante->relationshipApplicant;
            $oModel->other  = ($oParticipante == null) ? null : $oParticipante->other;
            $oModel->preponderantEconomicActivity  = ($oParticipante == null) ? null : $oParticipante->preponderantEconomicActivity;
           
            //nombre de catallogos
            $oModel->nameGender  = ($oParticipante == null) ? null : $oParticipante->c_gender->name;
            $oModel->nameCivilStatus  = ($oParticipante == null) ? null : $oParticipante->c_civil_status->name;
            $oModel->nameMatrimonialRegime  = ($oParticipante == null) ? null : $oParticipante->c_matrimonial_regime->name;
            $oModel->nameCountryNationality  = ($oParticipante == null) ? null : $oParticipante->c_country->name;
            $oModel->nameCountryBirth  = ($oParticipante == null) ? null : $oParticipante->c_country->name;
            $oModel->nameMunicipality  = ($oParticipante == null) ? null : $oParticipante->c_municipality->municipality;
            $oModel->nameFederalEntity  = ($oParticipante == null) ? null : $oParticipante->c_municipality->c_state->name;
            $oModel->nameType  = ($oParticipante == null) ? null : $oParticipante->c_id_type->name;
            $oModel->nameCreditBuroScore  = ($oParticipante == null) ? null : $oParticipante->c_score->name;
           
            }
        if ($type == 0) {
            $oModel->businessName = ($oParticipante == null) ? null : $oParticipante->businessName;
            $oModel->birthdate  = ($oParticipante == null) ? null : $oParticipante->birthdate->format(' H:i:s');
            $oModel->idCountryNationality =($oParticipante == null) ? null : $oParticipante->idCountryNationality;
            $oModel->rfc = ($oParticipante == null) ? null : $oParticipante->rfc;
            $oModel->street = ($oParticipante == null) ? null : $oParticipante->street;
            $oModel->outsideNumber = ($oParticipante == null) ? null :$oParticipante->outsideNumber;
            $oModel->insideNumber  = ($oParticipante == null) ? null : $oParticipante->insideNumber;
            $oModel->postalCode  = ($oParticipante == null) ? null : $oParticipante->postalCode;
            $oModel->colony  = ($oParticipante == null) ? null : $oParticipante->colony;
            $oModel->idMunicipality  = ($oParticipante == null) ? null : $oParticipante->idMunicipality;
            $oModel->idFederalEntity  = ($oParticipante == null) ? null : $oParticipante->idFederalEntity;
            $oModel->cityLocality = ($oParticipante == null) ? null :$oParticipante->cityLocality;
            $oModel->phoneNumber  = ($oParticipante == null) ? null : $oParticipante->phoneNumber;
            $oModel->cellPhoneNumber  = ($oParticipante == null) ? null : $oParticipante->cellPhoneNumber;
            $oModel->email  = ($oParticipante == null) ? null : $oParticipante->email;
            $oModel->idType  = ($oParticipante == null) ? null : $oParticipante->idType;
            $oModel->identificationNumber  = ($oParticipante == null) ? null : $oParticipante->identificationNumber;
            $oModel->idIdentificationIssuer  = ($oParticipante == null) ? null : $oParticipante->idIdentificationIssuer;
            $oModel->relationshipApplicant  = ($oParticipante == null) ? null : $oParticipante->relationshipApplicant;
            $oModel->other  = ($oParticipante == null) ? null : $oParticipante->other;
            $oModel->preponderantEconomicActivity  = ($oParticipante == null) ? null : $oParticipante->preponderantEconomicActivity;
            $oModel->idCreditBuroScore  = ($oParticipante == null) ? null : $oParticipante->idCreditBuroScore;
            
           
            
             //nombre de catallogos
             $oModel->nameGender  = ($oParticipante == null) ? null : $oParticipante->c_gender->name;
             $oModel->nameCivilStatus  = ($oParticipante == null) ? null : $oParticipante->c_civil_status->name;
             $oModel->nameMatrimonialRegime  = ($oParticipante == null) ? null : $oParticipante->c_matrimonial_regime->name;
             $oModel->nameCountryNationality  = ($oParticipante == null) ? null : $oParticipante->c_country->name;
             $oModel->nameCountryBirth  = ($oParticipante == null) ? null : $oParticipante->c_country->name;
             $oModel->nameMunicipality  = ($oParticipante == null) ? null : $oParticipante->c_municipality->municipality;
             $oModel->nameFederalEntity  = ($oParticipante == null) ? null : $oParticipante->c_municipality->c_state->name;
             $oModel->nameType  = ($oParticipante == null) ? null : $oParticipante->c_id_type->name;
             $oModel->idIdentificationIssuer  = ($oParticipante == null) ? null : $oParticipante->c_identification_issuer->name;
             $oModel->nameCreditBuroScore  = ($oParticipante == null) ? null : $oParticipante->c_score->name;

            }   

        return $oModel;
        }

    public static function fnSaveWarranty($oModel,$idUserCourse){

        $warranty = new EmpWarranty();

        $warranty->idStatus =CStatus::$ACTIVO;
        $warranty->complete = true;
        $warranty->idUserCourse = $idUserCourse;
        $warranty->idPropertyPhysicalPerson = $oModel['idPropertyPhysicalPerson'];
        $warranty->idNumberPropertiesReceive = $oModel['idNumberPropertiesReceive'];
        
        return $warranty;
        }

    public static function fnSaveProperty($oModel, $idWarranty){
        
        $property =   new EmpPropertyReceipt();

        $property->idWarranty = $idWarranty;
        $property->idStatus =CStatus::$ACTIVO;
        $property->propertyAccountNumber = $oModel['propertyAccountNumber'];
        $property->idKindProperty = $oModel['idKindProperty'];
        $property->indicateTypeProperty = $oModel['indicateTypeProperty'];
        $property->description = $oModel['description'];
        $property->location = $oModel['location'];
        $property->fiscalValue = $oModel['fiscalValue'];
        $property->numberOwners = $oModel['numberOwners'];

        return $property;
        
    }

    public static function fnSaveAvales($oModel,$idUserCourse,$idTypeParticiants,$idProperty, $type){

        $oParticipante = new EmpParticipantsGuarantee();
        

        $oParticipante->idPropertyReceipt = $idProperty;
        $oParticipante->idUserCourse = $idUserCourse;
        $oParticipante->idStatus = CStatus::$ACTIVO;
        $oParticipante->idParticipantsGuarantee = $idTypeParticiants;

        if ($type == 1) {

            $oParticipante->firstName =$oModel["firstName"];
            $oParticipante->lastName = $oModel["lastName"];
            $oParticipante->secondLastName =$oModel["secondLastName"]; 
            $oParticipante->rfc =$oModel["rfc"]; 
            $oParticipante->idGender =$oModel["idGender"]; 
            $oParticipante->idCivilStatus =$oModel["idCivilStatus"]; 
            $oParticipante->idMatrimonialRegime =$oModel["idMatrimonialRegime"]; 
            $time = strtotime($oModel['birthdate']);
            $oParticipante->birthdate = $time; 
            $oParticipante->idCountryNationality =$oModel["idCountryNationality"]; 
            $oParticipante->CURP =$oModel["CURP"]; 
            $oParticipante->idCountryBirth =$oModel["idCountryBirth"]; 
            $oParticipante->street =$oModel["street"]; 
            $oParticipante->outsideNumber =$oModel["outsideNumber"]; 
            $oParticipante->insideNumber =$oModel["insideNumber"]; 
            $oParticipante->postalCode =$oModel["postalCode"]; 
            $oParticipante->colony =$oModel["colony"]; 
            $oParticipante->idMunicipality =$oModel["idMunicipality"]; 
            $oParticipante->cityLocality =$oModel["cityLocality"]; 
            $oParticipante->phoneNumber =$oModel["phoneNumber"]; 
            $oParticipante->cellPhoneNumber =$oModel["cellPhoneNumber"]; 
            $oParticipante->idType =$oModel["idType"]; 
            $oParticipante->identificationNumber =$oModel["identificationNumber"]; 
            $oParticipante->idIdentificationIssuer =$oModel["idIdentificationIssuer"]; 
            $oParticipante->idCreditBuroScore =$oModel["idCreditBuroScore"]; 
            $oParticipante->relationshipApplicant =$oModel["relationshipApplicant"]; 
            $oParticipante->other =$oModel["other"]; 
            $oParticipante->preponderantEconomicActivity =$oModel["preponderantEconomicActivity"]; 
            $oParticipante->email =$oModel["email"]; 
            }

        if ($type == 0) {

            $oParticipante->businessName =$oModel["businessName"]; 
            $time = strtotime($oModel['birthdate']);
            $oParticipante->birthdate = $time; 
            $oParticipante->idCountryNationality =$oModel["idCountryNationality"]; 
            $oParticipante->rfc =$oModel["rfc"]; 
            $oParticipante->street =$oModel["street"]; 
            $oParticipante->outsideNumber =$oModel["outsideNumber"]; 
            $oParticipante->insideNumber =$oModel["insideNumber"]; 
            $oParticipante->postalCode =$oModel["postalCode"]; 
            $oParticipante->colony =$oModel["colony"]; 
            $oParticipante->idMunicipality =$oModel["idMunicipality"]; 
            $oParticipante->cityLocality =$oModel["cityLocality"]; 
            $oParticipante->phoneNumber =$oModel["phoneNumber"]; 
            $oParticipante->cellPhoneNumber =$oModel["cellPhoneNumber"]; 
            $oParticipante->email =$oModel["email"]; 
            $oParticipante->idType =$oModel["idType"]; 
            $oParticipante->identificationNumber =$oModel["identificationNumber"]; 
            $oParticipante->idIdentificationIssuer =$oModel["idIdentificationIssuer"]; 
            $oParticipante->relationshipApplicant =$oModel["relationshipApplicant"]; 
            $oParticipante->other =$oModel["other"]; 
            $oParticipante->preponderantEconomicActivity =$oModel["preponderantEconomicActivity"]; 
            $oParticipante->idCreditBuroScore =$oModel["idCreditBuroScore"]; 
        }   

        return $oParticipante;
        }
}

    