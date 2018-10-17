<?php
//Date: 16 May 2018 / Ede nuñez
namespace App\Business\Emprende\Queries;

// Mappers
use App\Business\Emprende\Mappers\DataPlanNegocioMapper;
//Repositories
use  App\Business\Emprende\Repositories\PlanNegocio\BusinessPlanRepository;
use  App\Business\Emprende\Repositories\PlanNegocio\OperationalManagementRepository;
use  App\Business\Emprende\Repositories\PlanNegocio\ProductRepository;
use  App\Business\Emprende\Repositories\PlanNegocio\TalentManagementRepository;
use  App\Business\Emprende\Repositories\PlanNegocio\EmployeesByAreaRepository;
use  App\Business\Emprende\Repositories\Solicitante\InitialDataRepository;
use  App\Business\Academia\Repositories\UserAcademyRepository;
// MOdels
use App\Models\Catalogs\CStatus;
//Services
use App\Business\Emprende\Services\FileService;

use DB;


class PlanNegocioQuery{   

    public static function fnGetPlanNegocio($oUser, $idUserCourse){
        $dataProducto = [];
        $dataEmployee = [];
        $show = null;
        //Obtiene los datos iniciales
        $oInitial =  InitialDataRepository::fnAllByUser($idUserCourse)->first();

        // Incidencia 0009207: [Plan de negocios] validación "Gestión operativa"
        if($oInitial == null) 
            $show = null;
            
        if($oInitial != null)    
            $show = ($oInitial->idSector == 1 || $oInitial->idSector == 4 ) ? false : true;
        
        //Busca el el plan de negocio apartir de id de ususario
        $oBusiness =  BusinessPlanRepository::fnAllByUser($idUserCourse)->first();

        //Se arma la estructura de la respuesta con datos null
        $oTalentNew = DataPlanNegocioMapper::fnGetTalentManagement(null, $show);
        
        //Mapea el modelo de plan de negocio
        $oBusinessNew = DataPlanNegocioMapper::fnGetBusinessPlan(null, $oUser);

        if($oBusiness != null)
        {
            //Mape el modelo de plan de negocio
            $oBusinessNew = DataPlanNegocioMapper::fnGetBusinessPlan($oBusiness, $oUser);

            // Busca el registro apartir del idOperationalManagement
            $oOperacionaal = OperationalManagementRepository::fnFind($oBusiness->idOperationalManagement)->first();

            // Busca descriptionProblems apartir del idOperationalManagement
            $oBusinessNew->descriptionProblems = $oOperacionaal->descriptionProblems;
            
            //Busca el registro apartir del idHumanTalentManagement
            $oTalent = TalentManagementRepository::fnFind($oBusiness->idHumanTalentManagement)->first();
            
            // mapea el modelo de HumanTalentManagement
            $oTalentNew = DataPlanNegocioMapper::fnGetTalentManagement($oTalent, $show);

            //Busca los empleados apartir del idHumanTalent
            $oEmployees = EmployeesByAreaRepository::fnAllByEmployees($oTalent->id)->get();
            
            if($oEmployees)
            {
                //recorre los registros de productos
                foreach ($oEmployees as $value) {
                    //Mapea el modelo de Products
                    $oEmployeesNew = DataPlanNegocioMapper::fnGetEmployee($value);
                    array_push($dataEmployee,$oEmployeesNew);
                }
            }
            // else
            // {
            //     $dataEmployee[0] = DataPlanNegocioMapper::fnGetEmployee(null);
            // }

            //Busca los productos apartir del idOperacionaal
            $oProduct = ProductRepository::fnAllByOperational($oOperacionaal->id)->get();
            
            if($oProduct)
            {
                //recorre los registros de productos
                foreach ($oProduct as $value) {
                    //Mapea el modelo de Products
                    $oProductNew = DataPlanNegocioMapper::fnGetProduct($value);
                    array_push($dataProducto,$oProductNew);
                }
            }
            // else
            // {
            //     $dataProducto[0] = DataPlanNegocioMapper::fnGetProduct(null);
            // }
        }


        
      //Genera el json para obtener el paso Plan de negocio
       return array_merge(['business_plan' => $oBusinessNew,
                           'human_talent_management' => $oTalentNew,
                           'employees_by_area' => $dataEmployee,
                           "product" => $dataProducto]);
    }	

    public static function fnSavePlanNegocio($oModel, $idUserCourse, $token){

        DB::beginTransaction();

        try {
        
        // obtiene los datos del usuario logeado
        $oUser = UserAcademyRepository::fnFindByidUserCourse( $idUserCourse )->first();

        //Mapea el modelo de OperationalManagement
        $dataOperational = DataPlanNegocioMapper::fnSaveOperationalManagement($oModel["operational_management"]);
            
        //Guarda en la tabla OperationalManagement
        $oOperacional = OperationalManagementRepository::fnSave($dataOperational);
        
        if($oModel["human_talent_management"]["show"] == true)
        {
            
            
            //recorre el array de productos
            foreach ($oModel["product"] as $value) {
                //Mapea el modelo de Products
                $dataProduct = DataPlanNegocioMapper::fnSaveProduct($value,$oOperacional->id);
                
                //Guarda en la tabla Productos
                ProductRepository::fnSave($dataProduct);
            }

        }

        $services = new  FileService($token);
        $upImage = $services->getOrganizationchart($oModel["human_talent_management"]["ImageOrganizationChart"]);

        // mapea el modelo de HumanTalentManagement
        $dataTalent = DataPlanNegocioMapper::fnSaveTalentManagement($oModel["human_talent_management"],$upImage);
       
        //Guarda en la tabla de TalentManagement
        $oTalent = TalentManagementRepository::fnSave($dataTalent);
        
        //recorre el array de productos
        foreach ($oModel["employees_by_area"] as $value) {
            //Mapea el modelo de Products
            $dataEmployee = DataPlanNegocioMapper::fnSaveEmployee($value,$oTalent->id);
            //Guarda en la tabla Productos
            EmployeesByAreaRepository::fnSave($dataEmployee);
        }

        
        //Mape el modelo de plan de negocio Agrega los id de las tablas previamente creadas
        $oBusinessNew = DataPlanNegocioMapper::fnSaveBusinessPlan($oModel["business_plan"],
                                                                  $idUserCourse,
                                                                  $oOperacional->id,
                                                                  $oTalent->id);              
        //Guarda el registro en la tabla BusinessPlan
        BusinessPlanRepository::fnSave( $oBusinessNew );
        DB::commit();

        return self::fnGetPlanNegocio( $oUser, $idUserCourse );

    } catch (\Throwable $e) {
        DB::rollback();
        throw $e;
    }

    }	
}