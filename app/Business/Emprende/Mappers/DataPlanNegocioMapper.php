<?php
//Date: 18 May 2018 /
namespace App\Business\Emprende\Mappers;
//Responses 
use App\Http\Responses\Emprende\PlanNegocio\BusinessPlanResponse;
use App\Http\Responses\Emprende\PlanNegocio\TalentManagementResponse;
use App\Http\Responses\Emprende\PlanNegocio\OperationalManagementResponse;
use App\Http\Responses\Emprende\PlanNegocio\EmployeesByAreaResponse;
use App\Http\Responses\Emprende\PlanNegocio\ProductResponse;
//Models
use App\Models\Catalogs\CStatus;
use App\Models\EmpProduct;
use App\Models\EmpOperationalManagement;
use App\Models\EmpHumanTalentManagement;
use App\Models\EmpBusinessPlan;
use App\Models\EmpEmployeesByArea;

class DataPlanNegocioMapper{   

    public static function fnGetBusinessPlan($Business, $User){

        $oModel = new BusinessPlanResponse();

        $oModel->name                       = $User->firstName . ' ' . $User->lastName . ' ' . $User->secondLastName;
        $oModel->date                       = date('Y-m-d H:i:s');

        $oModel->idOperationalManagement    = ($Business == null) ? null : $Business->idOperationalManagement;
        $oModel->idHumanTalentManagement    = ($Business == null) ? null : $Business->idHumanTalentManagement;
        $oModel->describeBusinessBackground = ($Business == null) ? null : $Business->describeBusinessBackground;
        $oModel->describeMarketCompetition  = ($Business == null) ? null : $Business->describeMarketCompetition;
        $oModel->descriptionProblems        = null;
        $oModel->conclusions                = ($Business == null) ? null : $Business->conclusions;
        $oModel->complete                   = ($Business == null) ? null : $Business->complete;

        return $oModel;
    }

    public static function fnGetTalentManagement($oTalent, $show){
        
        $oModel = new TalentManagementResponse();

        $oModel->idRotationProblems         =  ($oTalent == null) ? null : $oTalent->idRotationProblems;
        $oModel->monthlySalaryAdministrator =  ($oTalent == null) ? null : $oTalent->monthlySalaryAdministrator;
        $oModel->monthlySalaryAdministrator =  ($oTalent == null) ? null : $oTalent->monthlySalaryAdministrator;
        $oModel->monthlySalaryEmployees     =  ($oTalent == null) ? null : $oTalent->monthlySalaryEmployees;
        $oModel->ImageOrganizationChart     =  ($oTalent == null) ? null : $oTalent->ImageOrganizationChart;   
        $oModel->show                       =  $show;
        //name de catalogos
        $oModel->nameRotationProblems         =  ($oTalent == null) ? null : $oTalent->c_affirmation_denial->name;
       
        return $oModel;
    }

    public static function fnGetEmployee($oEmployee){

        $oModel = new EmployeesByAreaResponse();

        $oModel->areaName = ($oEmployee == null) ? null : $oEmployee->areaName;
        $oModel->quantity = ($oEmployee == null) ? null : $oEmployee->quantity;

        return $oModel;

    }

    public static function fnGetOperationalManagement($oOperational){

        $oModel = new OperationalManagementResponse();

        $oModel->descriptionProblems = ($oOperational == null) ? null : $oOperational->descriptionProblems;

        return $oModel;

    }

    public static function fnGetProduct($oProducto){

        $oModel = new ProductResponse();

        $oModel->name                   = ($oProducto == null) ? null : $oProducto->name;
        $oModel->description            = ($oProducto == null) ? null : $oProducto->description;
        $oModel->capacity               = ($oProducto == null) ? null : $oProducto->capacity;
        $oModel->currentInstalled       = ($oProducto == null) ? null : $oProducto->currentInstalled;
        $oModel->currentUsed            = ($oProducto == null) ? null : $oProducto->currentUsed;
        $oModel->currentPercentage      = ($oProducto == null) ? null : $oProducto->currentPercentage;
        $oModel->projectedInstalled     = ($oProducto == null) ? null : $oProducto->projectedInstalled;
        $oModel->projectedUsed          = ($oProducto == null) ? null : $oProducto->projectedUsed;
        $oModel->projectedPercentage    = ($oProducto == null) ? null : $oProducto->projectedPercentage;
       
        return $oModel;
    }

    public static function fnSaveOperationalManagement($Operational){
        
        $oModel = new EmpOperationalManagement();

        $oModel->idStatus               = CStatus::$ACTIVO;
        $oModel->descriptionProblems    = ($Operational['descriptionProblems'] == null) ? "" : $Operational['descriptionProblems'];
       
        return $oModel;

    }

    public static function fnSaveTalentManagement($oTalent, $upImage){

        $oModel = new EmpHumanTalentManagement();

        $oModel->idStatus = CStatus::$ACTIVO;

        $oModel->idRotationProblems         =  $oTalent["idRotationProblems"];
        $oModel->monthlySalaryAdministrator =  $oTalent["monthlySalaryAdministrator"];
        $oModel->monthlySalaryAdministrator =  $oTalent["monthlySalaryAdministrator"];
        $oModel->monthlySalaryEmployees     =  $oTalent["monthlySalaryEmployees"];
        $oModel->ImageOrganizationChart     =  $upImage; //$oTalent["ImageOrganizationChart"];   
       
        return $oModel;
    }

    public static function fnSaveProduct($oProducto,$idOperational){

        $oModel = new EmpProduct();

        $oModel->idStatus = CStatus::$ACTIVO;

        $oModel->idOperationalManagement    = $idOperational;
        $oModel->name                       = $oProducto["name"];
        $oModel->description                = $oProducto["description"];
        $oModel->capacity                   = $oProducto["capacity"];
        $oModel->currentInstalled           = $oProducto["currentInstalled"];
        $oModel->currentUsed                = $oProducto["currentUsed"];
        $oModel->currentPercentage          = $oProducto["currentPercentage"];
        $oModel->projectedInstalled         = $oProducto["projectedInstalled"];
        $oModel->projectedUsed              = $oProducto["projectedUsed"];
        $oModel->projectedPercentage        = $oProducto["projectedPercentage"];
       
        return $oModel;
    }
    
    public static function fnSaveEmployee($oEmployee,$idHumanTalentManagement){

        $oModel = new EmpEmployeesByArea();

        $oModel->idStatus = CStatus::$ACTIVO;

        $oModel->idHumanTalentManagement    = $idHumanTalentManagement;
        $oModel->areaName                   = $oEmployee["areaName"];
        $oModel->quantity                   = $oEmployee["quantity"];
       
        return $oModel;
    }

    public static function fnSaveBusinessPlan($oBusiness,$idUserCourse,$idOperational,$idTalent){

        $oModel = new EmpBusinessPlan();

        $oModel->idStatus                   = CStatus::$ACTIVO;
        $oModel->idUserCourse               = $idUserCourse;

        $oModel->idOperationalManagement    =  $idOperational;
        $oModel->idHumanTalentManagement    =  $idTalent;
        $oModel->describeBusinessBackground =  $oBusiness["describeBusinessBackground"];
        $oModel->describeMarketCompetition  =  $oBusiness["describeMarketCompetition"];
        $oModel->conclusions                =  $oBusiness["conclusions"];
        $oModel->complete                   =  true;
          
        return $oModel;
    }

}
