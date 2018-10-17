<?php
//Date: 18 May 2018 /
namespace App\Business\Emprende\Mappers;
// Responses
use App\Http\Responses\Emprende\Negocio\DataNegocioResponse;
//Models
use App\Models\Catalogs\CStatus;
use App\Models\EmpBusinessDatum;
use App\Models\EmpCreditDatum;




class DataNegocioMapper{   

    public static function fnGetNegocio($Business, $Credit){

        $oModel = new DataNegocioResponse();
        
        //emp_business_data----------------
        $oModel->idFiscalRegime = ($Business == null) ? null : $Business->idFiscalRegime;
        $oModel->street = ($Business == null) ? null : $Business->street;
        $oModel->outsideNumber = ($Business == null) ? null : $Business->outsideNumber;
        $oModel->insideNumber = ($Business == null) ? null : $Business->insideNumber;
        $oModel->postalCode = ($Business == null) ? null : $Business->postalCode;
        $oModel->colony = ($Business == null) ? null : $Business->colony;
        $oModel->idMunicipality = ($Business == null) ? null : $Business->idMunicipality;
        $oModel->cityLocality = ($Business == null) ? null : $Business->cityLocality;
        $oModel->phoneNumber = ($Business == null) ? null : $Business->phoneNumber;
        $oModel->cellPhoneNumber = ($Business == null) ? null : $Business->cellPhoneNumber;
        $oModel->activityBusiness = ($Business == null) ? null : $Business->activityBusiness;
        $oModel->idTypeLocal = ($Business == null) ? null : $Business->idTypeLocal;
        $oModel->startDateOperation = ($Business == null) ? null : $Business->startDateOperation;
        $oModel->idProductType = ($Business == null) ? null : $Business->idProductType;
        $oModel->portfolioNumberClient = ($Business == null) ? null : $Business->portfolioNumberClient;
        $oModel->salesInCustomer = ($Business == null) ? null : $Business->salesInCustomer;

        $oModel->wholesaler = ($Business == null) ? null : $Business->wholesaler;
        $oModel->retailer = ($Business == null) ? null : $Business->retailer;
        $oModel->business = ($Business == null) ? null : $Business->business;
        $oModel->generalPublic = ($Business == null) ? null : $Business->generalPublic;
        $oModel->totalPercentageClients = ($Business == null) ? null : $Business->totalPercentageClients;
        $oModel->creditClient = ($Business == null) ? null : $Business->creditClient;
        $oModel->numberDay = ($Business == null) ? null : $Business->numberDay;
        $oModel->toThe = ($Business == null) ? null : $Business->toThe;
        $oModel->andNumberDay = ($Business == null) ? null : $Business->andNumberDay;
        $oModel->andToThe = ($Business == null) ? null : $Business->andToThe;

        $oModel->local = ($Business == null) ? null : $Business->local;
        $oModel->state = ($Business == null) ? null : $Business->state;
        $oModel->regional = ($Business == null) ? null : $Business->regional;
        $oModel->national = ($Business == null) ? null : $Business->national;
        $oModel->fromExportation = ($Business == null) ? null : $Business->fromExportation;
        $oModel->other = ($Business == null) ? null : $Business->other;
        //emp_business_data----------------

        
        //emp_credit_data------------------
        $oModel->workingCapitalCredit = ($Credit == null) ? null : $Credit->workingCapitalCredit;
        $oModel->equipmentCredit = ($Credit == null) ? null : $Credit->equipmentCredit;
        $oModel->infrastructureCredit = ($Credit == null) ? null : $Credit->infrastructureCredit;
        $oModel->passivePaymentCredit = ($Credit == null) ? null : $Credit->passivePaymentCredit;
        $oModel->termWorkingCapital = ($Credit == null) ? null : $Credit->termWorkingCapital;
        $oModel->termEquipment = ($Credit == null) ? null : $Credit->termEquipment;
        $oModel->termInfrastructure = ($Credit == null) ? null : $Credit->termInfrastructure;
        $oModel->termPassivePayment = ($Credit == null) ? null : $Credit->termPassivePayment;
        $oModel->totalAmount = ($Credit == null) ? null : $Credit->totalAmount;

        //emp_credit_data------------------    

     
        return $oModel;
    }

    public static function fnGetBusiness($Business, $phoneNegocio){

        $oModel = new DataNegocioResponse();

        $oModel->street = ($Business == null) ? null : $Business->street;
        $oModel->outsideNumber = ($Business == null) ? null : $Business->outsideNumber;
        $oModel->insideNumber = ($Business == null) ? null : $Business->insideNumber;
        $oModel->postalCode = ($Business == null) ? null : $Business->postalCode;
        $oModel->colony = ($Business == null) ? null : $Business->colony;
        $oModel->idMunicipality = ($Business == null) ? null : $Business->idMunicipality;
        $oModel->cityLocality = ($Business == null) ? null : $Business->cityLocality;
        $oModel->phoneNumber = ($phoneNegocio == null) ? null : $phoneNegocio;//$Business->phoneNumber;
        $oModel->cellPhoneNumber = ($Business == null) ? null : $Business->cellPhoneNumber;
        $oModel->email = ($Business == null) ? null : $Business->email;
        $oModel->activityBusiness = ($Business == null) ? null : $Business->activityBusiness;
        $oModel->startDateOperation = ($Business == null) ? null :$Business->startDateOperation->format('Y-m-d h:i:s');
        $oModel->idFederalEntity = ($Business == null) ? null : $Business->c_municipality->c_state->id;
        

        $oModel->nameMunicipality = ($Business == null) ? null : $Business->c_municipality->municipality;
        $oModel->nameFederalEntity = ($Business == null) ? null :$Business->c_municipality->c_state->name;


        return $oModel;
    }

    public static function fnGetCredit($Credit){

        $oModel = new EmpCreditDatum();

        $oModel->workingCapitalCredit = ($Credit == null) ? null : $Credit->workingCapitalCredit;
        $oModel->equipmentCredit = ($Credit == null) ? null : $Credit->equipmentCredit;
        $oModel->infrastructureCredit = ($Credit == null) ? null : $Credit->infrastructureCredit;
        $oModel->passivePaymentCredit = ($Credit == null) ? null : $Credit->passivePaymentCredit;
        $oModel->termWorkingCapital = ($Credit == null) ? null : $Credit->termWorkingCapital;
        $oModel->termEquipment = ($Credit == null) ? null : $Credit->termEquipment;
        $oModel->termInfrastructure = ($Credit == null) ? null : $Credit->termInfrastructure;
        $oModel->termPassivePayment = ($Credit == null) ? null : $Credit->termPassivePayment;
        $oModel->totalAmount = ($Credit == null) ? null : $Credit->totalAmount;
       

        return $oModel;

    }


    public static function fnSaveBusiness($Business,$idUserCourse){

        $oModel = new EmpBusinessDatum();

        $oModel->idStatus = CStatus::$ACTIVO;
        $oModel->idUserCourse = $idUserCourse;
        
      
        $oModel->street = $Business['street'];
        $oModel->outsideNumber = $Business['outsideNumber'];
        $oModel->insideNumber = $Business['insideNumber'];
        $oModel->postalCode = $Business['postalCode'];
        $oModel->colony = $Business['colony'];
        $oModel->idMunicipality = $Business['idMunicipality'];
        $oModel->cityLocality = $Business['cityLocality'];
        $oModel->phoneNumber = $Business['phoneNumber'];
        $oModel->cellPhoneNumber = $Business['cellPhoneNumber'];
        $oModel->email = $Business['email'];
        $oModel->activityBusiness = $Business['activityBusiness'];
        $time = strtotime($Business['startDateOperation']);
        // dd(date('Y-m-d H:i:s',$time));
        $oModel->startDateOperation = date('Y-m-d H:i:s',$time);
       
        return $oModel;
    }

    public static function fnSaveCredit($Credit, $idUserCourse){

        $oModel = new EmpCreditDatum();

        $oModel->idStatus = CStatus::$ACTIVO;
        $oModel->idUserCourse = $idUserCourse;
        $oModel->workingCapitalCredit = $Credit['workingCapitalCredit'];
        $oModel->equipmentCredit = $Credit['equipmentCredit'];
        $oModel->infrastructureCredit = $Credit['infrastructureCredit'];
        $oModel->passivePaymentCredit = $Credit['passivePaymentCredit'];
        $oModel->termWorkingCapital = $Credit['termWorkingCapital'];
        $oModel->termEquipment = $Credit['termEquipment'];
        $oModel->termInfrastructure = $Credit['termInfrastructure'];
        $oModel->termPassivePayment = $Credit['termPassivePayment'];
        $oModel->totalAmount = $Credit['totalAmount'];
       
        return $oModel;

    }

}
