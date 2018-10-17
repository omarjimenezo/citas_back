<?php

namespace App\Business\Academia\Mappers;

// Request
use App\Http\Requests\Academia\Profile\ProfileRequest;

// Responses
use App\Http\Responses\Academia\Profile\ProfileResponse;
// Models
use App\Models\Academia\AcaUser;
use App\Models\Catalogs\CStatus;

//Hash
use Illuminate\Support\Facades\Hash;

class AcaUserAcademyMapper{   

    public static function fnMatchDataFromRequest($oUser, ProfileRequest $oProfileRequest){       
        
        if(!empty($oProfileRequest->id_AcaUserAcademy) && $oProfileRequest->id_AcaUserAcademy != null)
            $oUser->id = $oProfileRequest->id_AcaUserAcademy;
        if(!empty($oProfileRequest->id_informationMedia) && $oProfileRequest->id_informationMedia != null)
            $oUser->idInformationMedia = $oProfileRequest->id_informationMedia;
        if(!empty($oProfileRequest->id_fiscalRegime) && $oProfileRequest->id_fiscalRegime != null)
            $oUser->idFiscalRegime = $oProfileRequest->id_fiscalRegime;
        if(!empty($oProfileRequest->id_userType)  && $oProfileRequest->id_userType != null)
            $oUser->idUserType = $oProfileRequest->id_userType;
        if(!empty($oProfileRequest->id_typeUserType) && $oProfileRequest->id_typeUserType != null)
            $oUser->idTypeUserType = $oProfileRequest->id_typeUserType;
        if(!empty($oProfileRequest->id_HaveHadCreditFojal) && $oProfileRequest->id_HaveHadCreditFojal != null)
            $oUser->idHaveHadCreditFojal = $oProfileRequest->id_HaveHadCreditFojal;
        if(empty($oProfileRequest->id_HaveHadCreditFojal) || $oProfileRequest->id_HaveHadCreditFojal == null)
            $oUser->idHaveHadCreditFojal = 2;
        $oUser->creditNumber = $oProfileRequest->creditNumber;
        if(!empty($oProfileRequest->id_BusinessTraining) && $oProfileRequest->id_BusinessTraining != null)
            $oUser->idBusinessTraining = $oProfileRequest->id_BusinessTraining;
        if(empty($oProfileRequest->id_BusinessTraining) || $oProfileRequest->id_BusinessTraining == null)
            $oUser->idBusinessTraining = 2;
        if(!empty($oProfileRequest->firstName) && $oProfileRequest->firstName != null)
            $oUser->firstName = $oProfileRequest->firstName; 
        if(!empty($oProfileRequest->lastName) && $oProfileRequest->lastName != null)
            $oUser->lastName = $oProfileRequest->lastName;
        if(!empty($oProfileRequest->secondLastName) && $oProfileRequest->secondLastName != null)
            $oUser->secondLastName = $oProfileRequest->secondLastName;
        if(!empty($oProfileRequest->id_gender) && $oProfileRequest->id_gender != null)
            $oUser->idGender = $oProfileRequest->id_gender;
        if(!empty($oProfileRequest->id_civilStatus) && $oProfileRequest->id_civilStatus != null)
            $oUser->idCivilStatus = $oProfileRequest->id_civilStatus;
        if(!empty($oProfileRequest->id_matrimonialRegime) && $oProfileRequest->id_matrimonialRegime != null)
            $oUser->idMatrimonialRegime = $oProfileRequest->id_matrimonialRegime;
        if(empty($oProfileRequest->id_matrimonialRegime) || $oProfileRequest->id_matrimonialRegime == null)
            $oUser->idMatrimonialRegime = 4;
        if(!empty($oProfileRequest->birthdate) && $oProfileRequest->birthdate != null)
            $oUser->birthdate = $oProfileRequest->birthdate;
        if(!empty($oProfileRequest->age) && $oProfileRequest->age != null)
            $oUser->age = $oProfileRequest->age;
        if(!empty($oProfileRequest->id_countryBirth) && $oProfileRequest->id_countryBirth != null)    
            $oUser->idCountryBirth = $oProfileRequest->id_countryBirth;
        if(!empty($oProfileRequest->curp) && $oProfileRequest->curp != null)    
            $oUser->CURP = $oProfileRequest->curp;
        if(!empty($oProfileRequest->rfc) && $oProfileRequest->rfc != null)    
            $oUser->rfc = $oProfileRequest->rfc;
        if(!empty($oProfileRequest->id_occupation) && $oProfileRequest->id_occupation != null)    
            $oUser->idOccupation = $oProfileRequest->id_occupation;
        if(!empty($oProfileRequest->email) && $oProfileRequest->email != null)    
            $oUser->email = $oProfileRequest->email;
        if(!empty($oProfileRequest->cityLocality) && $oProfileRequest->cityLocality != null)    
            $oUser->cityLocality = $oProfileRequest->cityLocality;
        if(!empty($oProfileRequest->id_Municipality) && $oProfileRequest->id_Municipality != null)    
            $oUser->idMunicipality = $oProfileRequest->id_Municipality;
        if(!empty($oProfileRequest->postalCode) && $oProfileRequest->postalCode != null)    
            $oUser->postalCode = $oProfileRequest->postalCode;
        if(!empty($oProfileRequest->password) && $oProfileRequest->password != null)
            $oUser->password = Hash::make($oProfileRequest->password);
        if(!empty($oProfileRequest->idCapacitationArea) && $oProfileRequest->idCapacitationArea != null)    
            $oUser->idCapacitationArea = $oProfileRequest->idCapacitationArea;
        if(empty($oProfileRequest->idCapacitationArea) || $oProfileRequest->idCapacitationArea == null)    
            $oUser->idCapacitationArea = 9;
        if(!empty($oProfileRequest->idScholarship) && $oProfileRequest->idScholarship != null)    
            $oUser->idScholarship = $oProfileRequest->idScholarship; 
        if(!empty($oProfileRequest->street) && $oProfileRequest->street != null)    
            $oUser->street = $oProfileRequest->street;
        if(!empty($oProfileRequest->outsideNumber) && $oProfileRequest->outsideNumber != null)    
            $oUser->outsideNumber = $oProfileRequest->outsideNumber;
        if(!empty($oProfileRequest->insideNumber) && $oProfileRequest->insideNumber != null)    
            $oUser->insideNumber = $oProfileRequest->insideNumber;  
        if(!empty($oProfileRequest->colony) && $oProfileRequest->colony != null)    
            $oUser->colony = $oProfileRequest->colony;
        if(!empty($oProfileRequest->anotherOccupation) && $oProfileRequest->anotherOccupation != null)
            $oUser->anotherOccupation = $oProfileRequest->anotherOccupation;
            
        $oUser->idAction = 2;  
            
        return $oUser;        
    }

    public static function fnMatchDataFromResponse($oModel)
    {
        $oUser = new ProfileResponse();
        $oUser->id_AcaUserAcademy = $oModel->id;
        $oUser->id_informationMedia = $oModel->idInformationMedia;
        $oUser->id_fiscalRegime = $oModel->idFiscalRegime;
        $oUser->id_userType = $oModel->idUserType;
        $oUser->id_typeUserType = $oModel->idTypeUserType;
        $oUser->id_HaveHadCreditFojal = $oModel->idHaveHadCreditFojal;
        $oUser->creditNumber = $oModel->creditNumber;
        $oUser->id_BusinessTraining = $oModel->idBusinessTraining;
        $oUser->firstName = $oModel->firstName;
        $oUser->lastName = $oModel->lastName;
        $oUser->secondLastName = $oModel->secondLastName;
        $oUser->id_gender = $oModel->idGender;
        $oUser->id_civilStatus = $oModel->idCivilStatus;
        $oUser->id_matrimonialRegime = $oModel->idMatrimonialRegime;
        $oUser->birthdate = $oModel->birthdate == null? null : $oModel->birthdate->format('Y-m-d H:i:s');
        $oUser->age = $oModel->age;
        $oUser->id_countryBirth = $oModel->idCountryBirth;
        $oUser->curp = $oModel->CURP;
        $oUser->rfc = $oModel->rfc;
        $oUser->id_occupation = $oModel->idOccupation;
        $oUser->email = $oModel->email;
        $oUser->cityLocality = $oModel->cityLocality;
        $oUser->id_Municipality = $oModel->idMunicipality;
        $oUser->id_state = $oModel->c_municipality->c_state->id;
        $oUser->postalCode = $oModel->postalCode;
        $oUser->idCapacitationArea = $oModel->idCapacitationArea;
        $oUser->idScholarship = $oModel->idScholarship; 
        $oUser->street = $oModel->street;
        $oUser->outsideNumber = $oModel->outsideNumber;
        $oUser->insideNumber = $oModel->insideNumber; 
        $oUser->colony = $oModel->colony;
        $oUser->anotherOccupation = $oModel->anotherOccupation; 
        
        return $oUser;

    }
}
