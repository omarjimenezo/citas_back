<?php
//Date: 16 May 2018 / Ede nuñez
namespace App\Business\Emprende\Queries;

// Mappers
use App\Business\Emprende\Mappers\DataEstadoResultadosMapper;

// Repositories
use  App\Business\Emprende\Repositories\EstadoResultados\EstadoResultadosRepository;
use  App\Business\Emprende\Repositories\EstadoResultados\CostoUtilidadesRepository;
use  App\Business\Emprende\Repositories\PlanNegocio\BusinessPlanRepository;
use  App\Business\Academia\Repositories\UserAcademyRepository;
use  App\Business\Academia\Repositories\AcaUserCourseRepository;

// Guzzler
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;

class EstadoResultadosQuery{   

    // Forma un solo Json con todos los catalogos de emprende
    public static function fnGetStatusResults( $idUserCourse ){

        // obtiene los datos del usuario logeado
        $oUser = UserAcademyRepository::fnFindByidUserCourse( $idUserCourse )->first();

        // Queries
        $oStatusResultsData = EstadoResultadosRepository::fnAllByUser( $idUserCourse )->first();
        
        // Obtiene la fecha de inicio de operaciones
        $oUserCourse = AcaUserCourseRepository::fnFindCourse( $idUserCourse );
     
        // Obtiene la relación de AcaUserCourse con BusinessData
        $oBusiness = $oUserCourse->emp_business_data;

        // Obtiene la fecha de inicio de operacion del negocio
        $startDateOperation = $oBusiness[0]->startDateOperation->toDateString();

        // Mappers (inicializamos las estructuras)
        $oStatusResults = DataEstadoResultadosMapper::fnGetStatusResults( null, $oUser, $startDateOperation );
        $oCurrentSales  = DataEstadoResultadosMapper::fnGetSaleCost( null );
        $oExpectedSales = DataEstadoResultadosMapper::fnGetSaleCost( null );

        // Verifica si se obtuvo resultado en la consulta
        if($oStatusResultsData != null)
        {
            // Obtiene las ventas mensuales
            // $oSaleCostData = CostoUtilidadesRepository::fnAllByUser( $oStatusResultsData->id );
            
            // Mappers
            $oStatusResults = DataEstadoResultadosMapper::fnGetStatusResults( $oStatusResultsData, $oUser,  $startDateOperation);

            $oSaleCostData = $oStatusResultsData->emp_sale_cost_utility_expenses;
            
            // Itera entre los tipos de ventas mensuales
            foreach ($oSaleCostData as $value) 
            {
                switch($value->idAverage)
                {
                    case 1:
                        $oCurrentSales = DataEstadoResultadosMapper::fnGetSaleCost( $value );
                        break;
                    case 2:
                        $oExpectedSales = DataEstadoResultadosMapper::fnGetSaleCost( $value );
                        break;
                }
                
            }
        }
        
        // llena array  con todos los datos de solicitante
        return array_merge([
            'status_results'            => $oStatusResults,
            'sale_cost_utility_expense' => ['current_monthly_sales' => $oCurrentSales,
                                            'expected_monthly_sales' => $oExpectedSales],
        ]);    
    }	

    public static function fnSaveStatusResults( $oModel, $idUserCourse ){

        // Mappers
        $oStatusResults =  DataEstadoResultadosMapper::fnStatusResults( $oModel["status_results"], $idUserCourse );

        // Guardar
        $oStatusResultsData =  EstadoResultadosRepository::fnSave( $oStatusResults );

        // Mapers
        $oCurrentSales  =  DataEstadoResultadosMapper::fnSaleCost( $oModel["sale_cost_utility_expense"]["current_monthly_sales"], $oStatusResultsData->id, 1 );
        $oExpectedSales =  DataEstadoResultadosMapper::fnSaleCost( $oModel["sale_cost_utility_expense"]["expected_monthly_sales"], $oStatusResultsData->id, 2 );
        
        // Guardar
        $oCurrentSalesData  =  EstadoResultadosRepository::fnSave( $oCurrentSales );
        $oExpectedSalesData =  EstadoResultadosRepository::fnSave( $oExpectedSales );
        
        return self::fnGetStatusResults( $idUserCourse );
    }
}

