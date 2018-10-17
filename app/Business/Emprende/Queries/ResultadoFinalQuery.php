<?php
//Date: 16 May 2018 / Ede nuñez
namespace App\Business\Emprende\Queries;

// Mappers
// use App\Business\Emprende\Mappers\DataTablaPagosMapper;


// Repositories
use  App\Business\Emprende\Repositories\ResultadoFInal\TabulatorMunicipalityRepository;
use  App\Business\Emprende\Repositories\Configuration\ConfigurationRepository;
use  App\Business\Emprende\Repositories\Solicitante\ApplicantDetailRepository;
use  App\Business\Emprende\Repositories\Solicitante\InitialDataRepository;
use  App\Business\Emprende\Repositories\Garantia\WarrantyRepository;
use  App\Business\Emprende\Repositories\Garantia\PropertyReceiptRepository;
use  App\Business\Emprende\Repositories\Participante\ParticipanteRepository;
use  App\Business\Emprende\Repositories\Negocio\BusinessDataRepository;
use  App\Business\Emprende\Repositories\ProyectoInversion\CreditDataRepository;
use  App\Business\Emprende\Repositories\EstadoResultados\EstadoResultadosRepository;
use  App\Business\Emprende\Repositories\BalanceGeneral\GeneralBalanceRepository;
use  App\Business\Emprende\Repositories\BalanceGeneral\FixedAssetRepository;
use  App\Business\Emprende\Repositories\BalanceGeneral\PassiveNotReportedRepository;
use  App\Business\Emprende\Repositories\BalanceGeneral\PassiveShortTermRepository;
use  App\Business\Emprende\Repositories\BalanceGeneral\PassiveLongTermRepository;
use  App\Business\Emprende\Repositories\BalanceGeneral\PassiveAccountingCapitalRepository;
use  App\Business\Emprende\Repositories\BalanceGeneral\CurrentAssetsRepository;
use  App\Business\Academia\Repositories\UserAcademyRepository;
use  App\Business\Academia\Repositories\AcaUserCourseRepository;

// Catalogos
use App\Models\Catalogs\CTypeParticipants;

// Queries
use  App\Business\Emprende\Queries\GarantiaQuery;

// Services
use App\Business\Emprende\Services\FileService;

class ResultadoFinalQuery{   

    // Forma un solo Json con todos los catalogos de emprende
    public static function fnGetFinalResult( $idUserCourse, $token ){
        $behavior   = 0; // Conducta
        $sector     = 0; // Condiciones del sector
        $colateral  = 0; // Colateral
        $payment    = 0; // Capacidad de pago

        // obtiene los datos del usuario logeado
        $oUser = UserAcademyRepository::fnFindByidUserCourse( $idUserCourse )->first();

        // Obtiene el registro del usuario curso
        $oUserCourse = AcaUserCourseRepository::fnFindCourse( $idUserCourse )->first();
        
        // obtiene las configuraciones de el sistema
        $oConfig = ConfigurationRepository::fnGet()->get();

        foreach ($oConfig as $value) {
            if($value->keyConfig == 'RESULT_DEMO')
            {
                $result = $value->ValueConfig;
            }
        }

        /** 1. Conducta **/

            // obtiene los datos del solicitante
            $oApplicant = ApplicantDetailRepository::fnAllByUser( $idUserCourse )->first();

            // tener como respuesta, “Excelente” (1), “Bueno” (2) o “No reporta” (4)
            switch($oApplicant->idCreditBuroScore)
            {
                case 1: 
                    $score = true;
                    $_sScore = "Excelente";
                    break;
                case 2: 
                    $score = true;
                    $_sScore = "Bueno";
                    break;
                case 3: 
                    $score = false;
                    $_sScore = "Malo";
                    break;
                case 4: 
                    $score = true;
                    $_sScore = "No reporta";
                    break;
                default: 
                    $score = false;
                    $_sScore = "No reporta";
                    break;
            }

            $oInitial = InitialDataRepository::fnAllByUser( $idUserCourse )->first();
            
            // el apartado de “Beneficiario controlador” debe tener como respuesta “No”
            switch($oInitial->idLinkedBeneficiary)
            {
                case 1: 
                    $benefeciary = false;
                    $_sBenefeciary = "No cumple";
                    break;
                case 2: 
                    $benefeciary = true;
                    $_sBenefeciary = "Cumple";
                    break;
                default: 
                    $benefeciary = false;
                    break;
            }

            // en este apartado se pueden obtener 30 o 0 puntos
            $_behavior = ($score == true && $benefeciary == true) ? 30 : 0;

            // Objeto con la respuesta
            $_behaviorResult = array('score' => $_sScore, 
                                     'beneficiary' => $_sBenefeciary, 
                                     'result' => $_behavior);

        /** 2. Condiciones del sector**/
        
            // Obtiene el solicitante
            $oParticipant   = UserAcademyRepository::fnFindByidUserCourse( $idUserCourse )->first();
            $ParticipantTab = TabulatorMunicipalityRepository::fnFindByMunicipality( $oParticipant->idMunicipality )->first();

            switch($ParticipantTab->idBlock)
            {
                case 1: 
                    $participantBlock = 30;
                    $_sParticipantBlock = "Bloque A";
                    break;
                case 2: 
                    $participantBlock = 20;
                    $_sParticipantBlock = "Bloque B";
                    break;
                case 3: 
                    $participantBlock = 10;
                    $_sParticipantBlock = "Bloque C";
                    break;
                case 4: 
                    $participantBlock = 0;
                    $_sParticipantBlock = "Bloque D";
                    break;
                default: 
                    $participantBlock = 0;
                    $_sParticipantBlock = "Bloque D";
                    break;
            }
            
            // Obtiene el negocio del solicitante
            $oBusiness = BusinessDataRepository::fnAllByUser( $idUserCourse )->first();
            $oBusinessTab = TabulatorMunicipalityRepository::fnFindByMunicipality( $oBusiness->idMunicipality )->first();
            switch($oBusinessTab->idBlock)
            {
                case 1: 
                    $businessBlock = 30;
                    $_sBusinessBlock = "Bloque A";
                    break;
                case 2: 
                    $businessBlock = 20;
                    $_sBusinessBlock = "Bloque B";
                    break;
                case 3: 
                    $businessBlock = 10;
                    $_sBusinessBlock = "Bloque C";
                    break;
                case 4: 
                    $businessBlock = 0;
                    $_sBusinessBlock = "Bloque D";
                    break;
                default: 
                    $businessBlock = 0;
                    $_sBusinessBlock = "Bloque D";
                    break;
            }

            // se deberá considerar el municipio (de los dos resultantes) perteneciente al bloque menor, para otorgar una calificación
            $_sector = min( $participantBlock, $businessBlock );

            // Objeto con la respuesta
            $_sectorResult = array('participantBlock'   => $_sParticipantBlock, 
                                   'businessBlock'      => $_sBusinessBlock, 
                                   'result'             => $_sector);

        /** 3. Colateral **/
            
            // Obtiene los avales
            $oWarranty = WarrantyRepository::fnFindByUser( $idUserCourse )->get();
            
            $_propertyTotal = 0;

            foreach($oWarranty as $eWarranty)
            {
                // Obtiene las propiedades de los avales
                $oProperty = $eWarranty->emp_property_receipts;
                foreach($oProperty as $eProperty)
                {
                    // Realiza la suma de las propiedades de cada aval
                    $_propertyTotal = $eProperty->fiscalValue + $_propertyTotal;
                }

                $avales = ParticipanteRepository::fnFindProperty($eWarranty->id,CTypeParticipants::$DATOS_AVAL)->get();

                $avalScore = true;

                //Recorre registro de avales 
                foreach ($avales as $eAvales) {
                    // tener como respuesta, “Excelente” (1), “Bueno” (2) o “No reporta” (4)
                    if($avalScore)
                    {
                        switch($eAvales->idCreditBuroScore)
                        {
                            case 1: 
                                $avalScore = true;
                                $_sAvalScore = "Cumple";
                                break;
                            case 2: 
                                $avalScore = true;
                                $_sAvalScore = "Cumple";
                                break;
                            case 3: 
                                $avalScore = false;
                                $_sAvalScore = "No cumple";
                                break;
                            case 4: 
                                $avalScore = true;
                                $_sAvalScore = "Cumple";
                                break;
                            default: 
                                $avalScore = false;
                                $_sAvalScore = "No cumple";
                                break;
                        }
                    }
                }

            }

            // Obtiene datos del credito solicitado
            $oCredit = CreditDataRepository::fnAllByUser( $idUserCourse )->first();

            // Suma las cantidades del credito por separado
            $_creditTotal = $oCredit->workingCapitalCredit + $oCredit->equipmentCredit + $oCredit->infrastructureCredit + $oCredit->PassivePaymentCredit; 

            // Si el total de valor(es) fiscal(es) ingresado(s) y total de crédito solicitado es igual o mayor a 1, y el score(s) del aval(es) tiene como respuesta “Excelente”, “Bueno” o “No reporta”, el puntaje obtenido será igual a 20
            $_colateral = ($_propertyTotal >= $_creditTotal && $avalScore == true) ? 20 : 0;

            $_sProportion = ($_propertyTotal >= $_creditTotal) ? "Cumple" : "No cumple";

            // Objeto con la respuesta
            $_colateralResult = array('patrimony'   => $_propertyTotal, 
                                      'credit'      => $_creditTotal, 
                                      'proportion'  => $_sProportion, 
                                      'avalScore'   => $_sAvalScore, 
                                      'result'      => $_colateral); 

        /** 4. Capacidad de pago **/
            /* Generacion bruta */
                // Obtiene estado de resultados
                $oStatusResultsData = EstadoResultadosRepository::fnAllByUser( $idUserCourse )->first();

                //Obtiene gastos
                $oSaleCostData = $oStatusResultsData->emp_sale_cost_utility_expenses->where('idAverage','==','2')->first();
                
                $totalExpenses =    $oSaleCostData['merchandiseRawMaterial'] +
                                    $oSaleCostData['wagesSalaries'] +
                                    $oSaleCostData['rentalPremises'] +
                                    $oSaleCostData['stationeryVarious'] +
                                    $oSaleCostData['phone'] +
                                    $oSaleCostData['otherAdministrationExpenses'] +
                                    $oSaleCostData['gasolineLubricants'] +
                                    $oSaleCostData['maintenance'];
                
                // Obtiene balance general
                $oGeneral = GeneralBalanceRepository::fnAByUser($idUserCourse)->first();

                // Obtiene activo fijo
                $oFixed  = FixedAssetRepository::fnfind(($oGeneral == null)? null :$oGeneral->idFixedAsset)->first();
                
                // ((campo “Utilidad (A-B)”) del apartado promedio mensual esperado, de la sección Estado de Resultados + (campo “Depreciación acumulada”) del apartado Activo de la sección Balance General) * 12
                $utility = $oSaleCostData['monthlySales'] - $totalExpenses; 
                $_rawGeneration = ($utility + $oFixed->accumulatedDepreciation) * 12;
            
            /* Pasivos a corto plazo del balance general */

                // Obtiene pasivos a costo plazo
                $oPassiveShort = PassiveShortTermRepository::fnfind(($oGeneral == null)? null :$oGeneral->idPassiveShortTerm)->first();

                // (campo “Préstamos bancarios”) + (campo “Otros préstamos”) del apartado Pasivo de la sección Balance General
                $_passiveShort = $oPassiveShort['bankLoans'] + $oPassiveShort['otherAssets'];

            /* Amortizaciones mensuales Fojal */
            
                $working            = ($oCredit->workingCapitalCredit > 0)  ? ( ( $oCredit->workingCapitalCredit / $oCredit->termWorkingCapital ) + ( $oCredit->workingCapitalCredit * .12 ) ) / 12 : 0;
                $equipment          = ($oCredit->equipmentCredit > 0)       ? ( ( $oCredit->equipmentCredit / $oCredit->termEquipment ) + ($oCredit->equipmentCredit * .12 ) ) / 12 : 0;
                $infrastructure     = ($oCredit->infrastructureCredit > 0)  ? ( ( $oCredit->infrastructureCredit / $oCredit->termInfrastructure ) + ( $oCredit->infrastructureCredit * .12 ) ) / 12 : 0;
                
                $_capacity = ( $working + $equipment + $infrastructure ) * 12;

            /* Amortizaciones de pasivos no reportados corto plazo */

                // Obtiene pasivos no reportados
                $oNotReported  = PassiveNotReportedRepository::fnfind(($oGeneral == null)? null :$oGeneral->idPassiveNotReported)->first();

                $debtsBureauPayOneYear      = $oNotReported->debtsBureauPayOneYear;
                $debtsBureauPayMoreOneYear  = $oNotReported->debtsBureauPayMoreOneYear;
                $monthlyMortgagePayment     = $oNotReported->monthlyMortgagePayment;

                $_notReportedShort = ( ( ( $debtsBureauPayOneYear + ( $monthlyMortgagePayment * 12 ) ) / 12 ) + ( ( $debtsBureauPayMoreOneYear + ( $monthlyMortgagePayment * 12 ) ) * 0.15 ) / 12 ) * 12 ;
        
            /* Amortizaciones de pasivos no reportados corto plazo */

                $_notReportedLong = ( ( ( $debtsBureauPayOneYear  / 36 ) + ( $debtsBureauPayMoreOneYear * 0.15 ) / 12 ) ) * 12;

            /* FÓRMULA GENERAL CAPACIDAD DE PAGO */

                // La capacidad de pago resultante debe ser mayor o igual que 1, para obtener 10 puntos.
                $_paymentCapacity = ( ( $_rawGeneration / ( $_passiveShort + $_capacity + $_notReportedShort + $_notReportedLong ) ) >= 1 ) ? 10 : 0;

                // Objeto con la respuesta
                $_paymentCapacityResult = array('rawGeneration'     => $_rawGeneration, 
                                                'passiveShort'      => $_passiveShort, 
                                                'amortizationMonts' => $_capacity, 
                                                'amortizationShort' => $_notReportedShort, 
                                                'amortizationLong'  => $_notReportedLong, 
                                                'result'            => $_paymentCapacity);
        
        /** 5. Capacidad de deuda **/
        
            /* Pasivos totales */
                $oPassiveLong = PassiveLongTermRepository::fnfind(($oGeneral == null)? null :$oGeneral->idPassiveLongTerm)->first();
                
                // Resultado del campo “Suma total de pasivo” del apartado “Pasivo” de la sección “Balance General”
                $_totalPassive  = $oPassiveShort->totalPassiveShortTerm + $oPassiveLong->totalPassiveLongTerm;
                
            /* Pasivos no reportados */
                
                // campo “Deudas adicionales en buró de crédito por pagar a un año”+ campo “Deudas adicionales en buró de crédito por pagar a más de un año” +(campo “Pago mensual de hipoteca” *12)
                $_notReportedTotal = $debtsBureauPayOneYear + $debtsBureauPayMoreOneYear + ( $monthlyMortgagePayment * 12 );
                
            /* Crédito solicitado */
                
                // muestra el resultado de la siguiente suma: campo “Importe del crédito para capital de trabajo” + campo “Importe del crédito para equipamiento” + campo “Importe del crédito para infraestructura” del apartado “Datos del crédito solicitado” de la sección “Solicitante”
                $_totalCredit = $oCredit->workingCapitalCredit + $oCredit->equipmentCredit + $oCredit->infrastructureCredit;
                
            /* Capital contable */
            
                // Obtiene capital contable
                $oPassiveAccounting = PassiveAccountingCapitalRepository::fnfind(($oGeneral == null)? null :$oGeneral->idPassiveAccountingCapital)->first();
                
                // “Suma total de capital contable” del apartado “Pasivo” de la sección “Balance General”
                $_totalPassiveAccounting = $oPassiveAccounting->totalPassiveAccountingCapital;
                
            /* Activo total */
            
                // Obtiene capital contable
                $oCurrentAssets = CurrentAssetsRepository::fnfind(($oGeneral == null)? null :$oGeneral->idCurrentAssets)->first();

                // “Suma total de activo” del apartado “Activo” de la sección “Balance General”
                $_totalCurrentAssets = $oCurrentAssets->totalCurrentAssets;
            
            /* Apalancamiento */

                // muestra el resultado de la siguiente fórmula: (Pasivos totales + Pasivos no reportados + Crédito solicitado)/ Capital contable
                $_leverage = ( $_totalPassive + $_notReportedTotal + $_creditTotal ) / $_totalPassiveAccounting;
            
            /* Independencia Se detecto un error en esta formuña*/

            /*Formula correcta : Activo total/(pasivo total + pasivos no reportados + nuevo crédito solicitado ) / capital contable*/ 

                // muestra el resultado de la siguiente fórmula: (Pasivos totales + Pasivos no reportados + Crédito solicitado)/ Capital contable
                $_independency = $_totalCredit / ( $_totalPassive + $_notReportedTotal + $_creditTotal );
                
            
            /* FÓRMULA GENERAL */
                // Para poder obtener 10 puntos, los conceptos “Apalancamiento” e “Independencia” deben cumplir las siguientes reglas:
                // Apalancamiento: debe ser igual o menor que 2
                // Independencia: debe ser igual o mayor que 0.2
                $leverageTotal = ( $_leverage >= 2) ? 5 : 0;
                $independencyTotal = ( $_independency >= 0.2 ) ? 5 : 0;
                $_debtCapacity = $leverageTotal + $independencyTotal;

                // Objeto con la respuesta
                $_debtCapacityResult = array(   'totalPassive'          => $_totalPassive,
                                                'notReportedPassive'    => $_notReportedTotal,
                                                'newCredit'             => $_totalCredit,
                                                'accountingCapital'     => $_totalPassiveAccounting,
                                                'currentAssets'         => $_totalCurrentAssets,
                                                'leverage'              => $_leverage,
                                                'independency'          => $_independency,
                                                'result'                => $_debtCapacity);


        /* Evaluacion de resultado */

            if( ( $_behavior + $_sector + $_colateral + $_paymentCapacity + $_debtCapacity ) >= 80 )
            {
                // El usuario fue aceptado
                $accepted = true;

                // Se obtiene el objeto del servicio de documentos
                $services = new  FileService( $token );

                // Se solicita la generación y obtención del documento de preautorizacion
                $file = $services->getPrePositiveAuthorization( $idUserCourse );

                // Se define el campo de aprovación como verdadero
                $oUserCourse->approved = true;

                // Actualiza el registro
                $oUserSaved = AcaUserCourseRepository::fnSave($oUserCourse);
            }
            else
            {
                // El usuario fue rechazado
                $accepted = false;

                // Se obtiene el objeto del servicio de documentos
                $services = new  FileService( $token );

                // Se solicita la generación y obtención del documento de preautorizacion
                $file = $services->getPreAuthorizationNegative( $idUserCourse );

                // Se define el campo de aprovación como falso
                $oUserCourse->approved = false;

                // Actualiza el registro
                $oUserSaved = AcaUserCourseRepository::fnSave($oUserCourse);
            }
        
        return array('final_result' => [
                        'accepted' => $accepted, 
                        'file' => $file],
                     '5c'           => [
                        'behavior'          => $_behaviorResult,
                        'sector'            => $_sectorResult,
                        'colateral'         => $_colateralResult,
                        'paymentCapacity'   => $_paymentCapacityResult,
                        'debtCapacity'      => $_debtCapacityResult
                     ]);
    }
}
