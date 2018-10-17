<?php
//Date: 16 May 2018 / Ede nuñez
namespace App\Business\Emprende\Queries;
// Mappers
use App\Business\Emprende\Mappers\DataInversionMapper;
//Repositories
use  App\Business\Emprende\Repositories\ProyectoInversion\InvestmentProjectRepository;
use  App\Business\Emprende\Repositories\ProyectoInversion\DebtToPayRepository;
use  App\Business\Emprende\Repositories\ProyectoInversion\TypeCreditsRepository;
use  App\Business\Emprende\Repositories\ProyectoInversion\CreditDataRepository;
use  App\Business\Academia\Repositories\UserAcademyRepository;
use  DB;

class InversionQuery{   

    // Forma un solo Json con todos los catalogos de emprende
    public static function fngetInversion( $idUserCourse ){
        $aTypeCredits   = [];
        $aDebt          = [];

        // obtiene los datos del usuario logeado
        $oUser = UserAcademyRepository::fnFindByidUserCourse( $idUserCourse )->first();
    
        if($oUser == null)
            return null;
    
        // Queries
        $oInvestmentData    = InvestmentProjectRepository::fnAllByUser( $idUserCourse )->first();
        $oCreditData        = CreditDataRepository::fnAllByUser( $idUserCourse )->first();

        // Mappers
        $oInvestment    = DataInversionMapper::fnGetInversion( $oInvestmentData, $oUser );

        // Se inicializa la estrutura para devolver en la respuesta estrutura completa
        $aTypeCredits['working_capital']    =  DataInversionMapper::fnGetTipoCredito( null, ($oCreditData == null) ? null : $oCreditData->workingCapitalCredit );   // Caítal de trabajo
        $aTypeCredits['equipment']          =  DataInversionMapper::fnGetTipoCredito( null, ($oCreditData == null) ? null : $oCreditData->equipmentCredit );        // Equipamiento
        $aTypeCredits['infrastructure']     =  DataInversionMapper::fnGetTipoCredito( null, ($oCreditData == null) ? null : $oCreditData->infrastructureCredit );   // Infraestructura
        $aTypeCredits['passive_payments']   =  DataInversionMapper::fnGetTipoCredito( null, ($oCreditData == null) ? null : $oCreditData->passivePaymentCredit );   // Pago de pasivos
        
        // Se inicializa la estrutura para devolver en la respuesta estrutura completa
        $aDebt['providers']     = DataInversionMapper::fnGetDeudas( null ); // Proveedor
        $aDebt['short_term']    = DataInversionMapper::fnGetDeudas( null ); // Corto plazo
        $aDebt['long_term']     = DataInversionMapper::fnGetDeudas( null ); // Largo plazo
        
        // Verificamos si la tabla principal trajo resultados
        if($oInvestmentData != null)
        {
            foreach ( $oInvestmentData->emp_debt_to_pays as $value ) 
            {
                $oDebt = DataInversionMapper::fnGetDeudas( $value );
                switch($value->idDescriptionDebt)
                {
                    case 1:
                        $aDebt['providers']     = $oDebt; // Caítal de trabajo
                        break;
                    case 2:
                        $aDebt['short_term']    = $oDebt; // Equipamiento
                        break;
                    case 3:
                        $aDebt['long_term']     = $oDebt; // Infraestructura
                        break;
                }
            }

            foreach ( $oInvestmentData->emp_type_credits as $value ) 
            {
                $oCredit = DataInversionMapper::fnGetTipoCredito( $value, null );
                switch($value->idTypeCredit)
                {
                    case 1:
                        $oCredit->amount                    = $oCreditData->workingCapitalCredit;
                        $aTypeCredits['working_capital']    = $oCredit; // Caítal de trabajo
                        break;
                    case 2:
                        $oCredit->amount                    = $oCreditData->equipmentCredit;
                        $aTypeCredits['equipment']          = $oCredit; // Equipamiento
                        break;
                    case 3:
                        $oCredit->amount                    = $oCreditData->infrastructureCredit;
                        $aTypeCredits['infrastructure']     = $oCredit; // Infraestructura
                        break;
                    case 4:
                        $oCredit->amount                    = $oCreditData->passivePaymentCredit;
                        $aTypeCredits['passive_payments']   = $oCredit; // Pago de pasivos
                        break;
                }
            }
        }

        // llena array  con todos los datos de solicitante
        return array_merge([
            'investment_project'    => $oInvestment,
            'debt_to_pays'          => $aDebt,
            'type_credits'          => $aTypeCredits,
        ]);    
    }	

    public static function fnSaveInversion( $oModel, $idUserCourse ){
        
        DB::beginTransaction();

        try {
        // Obtiene le credit data del usuario
        $oCreditData = CreditDataRepository::fnAllByUser( $idUserCourse )->first();
        
        // Mappers
        $oInversion =  DataInversionMapper::fnInversion( $oModel["investment_project"], $idUserCourse, $oCreditData->id );
        // Guardar
        $oInvestment =  InvestmentProjectRepository::fnSave( $oInversion );
        
        // Mappers
        $oCredito1  =  DataInversionMapper::fnCreditos( $oModel["type_credits"]["working_capital"]  , $oInvestment->id, 1 ); // Caítal de trabajo
        $oCredito2  =  DataInversionMapper::fnCreditos( $oModel["type_credits"]["equipment"]        , $oInvestment->id, 2 ); // Equipamiento
        $oCredito3  =  DataInversionMapper::fnCreditos( $oModel["type_credits"]["infrastructure"]   , $oInvestment->id, 3 ); // Infraestructura
        $oCredito4  =  DataInversionMapper::fnCreditos( $oModel["type_credits"]["passive_payments"] , $oInvestment->id, 4 ); // Pago de pasivos

        // Guardar
        $oCredit =  TypeCreditsRepository::fnSave( $oCredito1 );
        $oCredit =  TypeCreditsRepository::fnSave( $oCredito2 );
        $oCredit =  TypeCreditsRepository::fnSave( $oCredito3 );
        $oCredit =  TypeCreditsRepository::fnSave( $oCredito4 );

        if(isset($oModel["debt_to_pays"]["providers"]))
        {
            $oDeuda1    =  DataInversionMapper::fnDeudas( $oModel["debt_to_pays"]["providers"]   , $oInvestment->id, 1 ); // Pago de pasivos prooverdores
            $oDebts     =  DebtToPayRepository::fnSave( $oDeuda1 );
        }
        if(isset($oModel["debt_to_pays"]["short_term"]))
        {
            $oDeuda2    =  DataInversionMapper::fnDeudas( $oModel["debt_to_pays"]["short_term"]  , $oInvestment->id, 2 ); // Pago de pasivos corto plazo
            $oDebts     =  DebtToPayRepository::fnSave( $oDeuda2 );
        }
        if(isset($oModel["debt_to_pays"]["long_term"]))
        {
            $oDeuda3    =  DataInversionMapper::fnDeudas( $oModel["debt_to_pays"]["long_term"]   , $oInvestment->id, 3 ); // Pago de pasivos largo plazo
            $oDebts     =  DebtToPayRepository::fnSave( $oDeuda3 );
        }

        DB::commit();

        return self::fngetInversion( $idUserCourse );
        
        } catch (\Throwable $e) {
            DB::rollback();
            throw $e;
        }
    }
}

