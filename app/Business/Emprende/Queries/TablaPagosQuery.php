<?php
//Date: 16 May 2018 / Ede nuñez
namespace App\Business\Emprende\Queries;

// Mappers
use App\Business\Emprende\Mappers\DataTablaPagosMapper;

// Repositories
use  App\Business\Emprende\Repositories\TablaPagos\TablaPagosRepository;
use  App\Business\Academia\Repositories\UserAcademyRepository;

// Guzzler
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;

class TablaPagosQuery{   

    // Forma un solo Json con todos los catalogos de emprende
    public static function fnGetPaymentsTable( $idUserCourse ){

        $aPaymentsTable = [];
        $oPeriod = [];

        $interest_total     = 0;
        $capital_total      = 0;
        $payment_total      = 0;

        // obtiene los datos del usuario logeado
        $oUser = UserAcademyRepository::fnFindByidUserCourse( $idUserCourse )->first();
        
        // Queries
        $oAmortization = TablaPagosRepository::fnAllByUser( $idUserCourse )->first();
       
        $oCreditsDestination['working_capital']    =  DataTablaPagosMapper::fnGetTipoCredito( null );   // Caítal de trabajo
        $oCreditsDestination['equipment']          =  DataTablaPagosMapper::fnGetTipoCredito( null );   // Equipamiento
        $oCreditsDestination['infrastructure']     =  DataTablaPagosMapper::fnGetTipoCredito( null );   // Infraestructura
        $oCreditsDestination['passive_payments']   =  DataTablaPagosMapper::fnGetTipoCredito( null );   // Pago de pasivos
      
        if($oAmortization)
        {
            foreach ( $oAmortization->emp_credits_destinations as $value ) 
            {
                // $oCredit = DataTablaPagosMapper::fnGetTipoCredito( $value, null );
                switch($value->idAmount)
                {
                    case 1:
                        $oCreditsDestination['working_capital']    =  DataTablaPagosMapper::fnGetTipoCredito( ($value == null) ? null : $value );   // Caítal de trabajo
                        break;
                    case 2:
                        $oCreditsDestination['equipment']          =  DataTablaPagosMapper::fnGetTipoCredito( ($value == null) ? null : $value );   // Equipamiento
                        break;
                    case 3:
                        $oCreditsDestination['infrastructure']     =  DataTablaPagosMapper::fnGetTipoCredito( ($value == null) ? null : $value );   // Infraestructura
                        break;
                    case 4:
                        $oCreditsDestination['passive_payments']   =  DataTablaPagosMapper::fnGetTipoCredito( ($value == null) ? null : $value );   // Pago de pasivos
                        break;
                }
            }
        }
  
      

        $working_amount                 = $oCreditsDestination['working_capital']->amount;
        $equipment_amount               = $oCreditsDestination['equipment']->amount;
        $infrastructure_amount          = $oCreditsDestination['infrastructure']->amount;
        $payments_amount                = $oCreditsDestination['passive_payments']->amount;

        $working_interestRate           = $oCreditsDestination['working_capital']->interestRate;
        $equipment_interestRate         = $oCreditsDestination['equipment']->interestRate;
        $infrastructure_interestRate    = $oCreditsDestination['infrastructure']->interestRate;
        $payments_interestRate          = $oCreditsDestination['passive_payments']->interestRate;

        $working_timeLimit              = $oCreditsDestination['working_capital']->timeLimit;
        $equipment_timeLimit            = $oCreditsDestination['equipment']->timeLimit;
        $infrastructure_timeLimit       = $oCreditsDestination['infrastructure']->timeLimit;
        $payments_timeLimit             = $oCreditsDestination['passive_payments']->timeLimit;

        $working_payment                = $oCreditsDestination['working_capital']->payment;
        $equipment_payment              = $oCreditsDestination['equipment']->payment;
        $infrastructure_payment         = $oCreditsDestination['infrastructure']->payment;
        $payments_payment               = $oCreditsDestination['passive_payments']->payment;
        
        $max_timeLimit = max($working_timeLimit, $equipment_timeLimit, $infrastructure_timeLimit, $payments_timeLimit);
        
        for($index = 0; $index < $max_timeLimit; $index++)
        {
            $period = $index + 1;

            //**Interes** Si el campo “xxx_amount” es mayor a 0, ejecuta la siguiente fórmula: ( xxx_interestRate/12 ) * xxx_amount. De lo contrario el resultado será 0
            $working_interest           = ($working_amount > 0)           ? self::truncar(( ($working_interestRate * .01) / 12 ) * $working_amount) : 0;
            $equipment_interest         = ($equipment_amount > 0)         ? self::truncar(( ($equipment_interestRate * .01) / 12 ) * $equipment_amount) : 0;
            $infrastructure_interest    = ($infrastructure_amount > 0)    ? self::truncar(( ($infrastructure_interestRate * .01) / 12 ) * $infrastructure_amount) : 0;
            $payments_interest          = ($payments_amount > 0)          ? self::truncar(( ($payments_interestRate * .01) / 12 ) * $payments_amount) : 0;
            
            //**Capital** Si el campo “xxx_amount” es mayor que 0, entonces muestra el resultado de la resta de los campos xxx_payment” menos “xxx_interest” de cada mes.
            $working_capital            = ($working_amount > 0)           ? $working_payment - $working_interest : 0; 
            $equipment_capital          = ($equipment_amount > 0)         ? $equipment_payment - $equipment_interest : 0; 
            $infrastructure_capital     = ($infrastructure_amount > 0)    ? $infrastructure_payment - $infrastructure_interest : 0; 
            $payments_capital           = ($payments_amount > 0)          ? $payments_payment - $payments_interest : 0; 
            
            //**Pago total ** Si el campo “Periodos” es menor o igual que el campo “xxx_interestRate”, muestra el resultado del campo “xxx_payment”, de lo contrario muestra como resultado 0
            ($period <= $working_timeLimit)           ? $working_payment : $working_payment = 0;
            ($period <= $equipment_timeLimit)         ? $equipment_payment : $equipment_payment = 0;
            ($period <= $infrastructure_timeLimit)    ? $infrastructure_payment : $infrastructure_payment = 0;
            ($period <= $payments_timeLimit)          ? $payments_payment : $payments_payment = 0;


            $oPeriod            =   $period;

            $oAmount            =   $working_amount + 
                                    $equipment_amount + 
                                    $infrastructure_amount + 
                                    $payments_amount;
            
            $oInterest          =   $working_interest + 
                                    $equipment_interest + 
                                    $infrastructure_interest + 
                                    $payments_interest;

            $oCapital           =   $working_capital +
                                    $equipment_capital +
                                    $infrastructure_capital +
                                    $payments_capital;
                
            $oPayment           =   $working_payment +
                                    $equipment_payment +
                                    $infrastructure_payment +
                                    $payments_payment;
            
            // Guarda datos de periodo
            $oPaymentsTableData[] = array(
                'period'    => self::truncar($oPeriod),
                'balance'   => self::truncar($oAmount),
                'interest'  => self::truncar($oInterest),
                'capital'   => self::truncar($oCapital),
                'payment'   => self::truncar($oPayment),
            );   
           
            //**Saldo insoluto** Si el campo “xxx_amount” menos el campo “xxx_capital” es menor que 0, entonces el resultado será 0, en caso contrario mostrará el resultado de la resta.
            ( ($working_amount - $working_capital) == 0 )               ? 0 : $working_amount = $working_amount - $working_capital;
            ( ($equipment_amount - $equipment_capital) == 0 )           ? 0 : $equipment_amount = $equipment_amount - $equipment_capital;
            ( ($infrastructure_amount - $infrastructure_capital) == 0 ) ? 0 : $infrastructure_amount = $infrastructure_amount - $infrastructure_capital;
            ( ($payments_amount - $payments_capital) == 0 )             ? 0 : $payments_amount = $payments_amount - $payments_capital;
            
            $interest_total     = $interest_total + $oInterest;
            $capital_total      = $capital_total + $oCapital;
            $payment_total      = $payment_total + $oPayment;
        }

        // // Guarda sumas totales
        $oPaymentsTableData[] = array(
            'period'    => "Sumas",
            'balance'   => "",
            'interest'  => self::truncar($interest_total),
            'capital'   => self::noDecimal($capital_total),
            'payment'   => self::truncar($payment_total),
        );
        
        foreach ($oPaymentsTableData as $k => $v )
        {
            $oPeriod = DataTablaPagosMapper::fnGetPaymentsTable( $v );
            array_push( $aPaymentsTable, $oPeriod );
        }

        //dd( $aPaymentsTable );
        // llena array  con todos los datos de solicitante
        return array_merge([
            'credits_destination'   => $oCreditsDestination,
            'payments_table'        => $aPaymentsTable,
        ]); 
        
    }	

    
    public static function fneachperiod($idUserCourse, $typecredit)
    {

        $aPaymentsTable = [];
        $oPeriod = [];

        $interest_total     = 0;
        $capital_total      = 0;
        $payment_total      = 0;

        // obtiene los datos del usuario logeado
        $oUser = UserAcademyRepository::fnFindByidUserCourse( $idUserCourse )->first();
    
        // Queries
        $oAmortization = TablaPagosRepository::fnAllByUser( $idUserCourse )->first();
       
        $oCreditsDestination['working_capital']    =  DataTablaPagosMapper::fnGetTipoCredito( null );   // Caítal de trabajo
        // $oCreditsDestination['equipment']          =  DataTablaPagosMapper::fnGetTipoCredito( null );   // Equipamiento
        // $oCreditsDestination['infrastructure']     =  DataTablaPagosMapper::fnGetTipoCredito( null );   // Infraestructura
        // $oCreditsDestination['passive_payments']   =  DataTablaPagosMapper::fnGetTipoCredito( null );   // Pago de pasivos
      
        if($oAmortization)
        {
           
            foreach ( $oAmortization->emp_credits_destinations as $value ) 
            {
                // $oCredit = DataTablaPagosMapper::fnGetTipoCredito( $value, null );
                if($typecredit == $value->idAmount)
               
                    $oCreditsDestination['tabla']   =  DataTablaPagosMapper::fnGetTipoCredito( ($value == null) ? null : $value ); 
                
            }
        }
  
      

        $working_amount                 = $oCreditsDestination['tabla']->amount;


        $working_interestRate           = $oCreditsDestination['tabla']->interestRate;


        $working_timeLimit              = $oCreditsDestination['tabla']->timeLimit;


        $working_payment                = $oCreditsDestination['tabla']->payment;

        
        $max_timeLimit = $working_timeLimit;
        
        for($index = 0; $index < $max_timeLimit; $index++)
        {
            $period = $index + 1;

            //**Interes** Si el campo “xxx_amount” es mayor a 0, ejecuta la siguiente fórmula: ( xxx_interestRate/12 ) * xxx_amount. De lo contrario el resultado será 0
            $working_interest           = ($working_amount > 0)           ? self::truncar(( ($working_interestRate * .01) / 12 ) * $working_amount) : 0;

            //**Capital** Si el campo “xxx_amount” es mayor que 0, entonces muestra el resultado de la resta de los campos xxx_payment” menos “xxx_interest” de cada mes.
            $working_capital            = ($working_amount > 0)           ? $working_payment - $working_interest : 0; 

            //**Pago total ** Si el campo “Periodos” es menor o igual que el campo “xxx_interestRate”, muestra el resultado del campo “xxx_payment”, de lo contrario muestra como resultado 0
            ($period <= $working_timeLimit)           ? $working_payment : $working_payment = 0;


            $oPeriod            =   $period;

            $oAmount            =   $working_amount;

            $oInterest          =   $working_interest;

            $oCapital           =   $working_capital;
                
            $oPayment           =   $working_payment;

                                    
            
            // Guarda datos de periodo
            $oPaymentsTableData[] = array(
                'period'    => self::truncar($oPeriod),
                'balance'   => self::truncar($oAmount),
                'interest'  => self::truncar($oInterest),
                'capital'   => self::truncar($oCapital),
                'payment'   => self::truncar($oPayment),
            );   
           

            //**Saldo insoluto** Si el campo “xxx_amount” menos el campo “xxx_capital” es menor que 0, entonces el resultado será 0, en caso contrario mostrará el resultado de la resta.
            ( ($working_amount - $working_capital) == 0 )               ? 0 : $working_amount = $working_amount - $working_capital;
            // ( ($equipment_amount - $equipment_capital) == 0 )           ? 0 : $equipment_amount = $equipment_amount - $equipment_capital;
            // ( ($infrastructure_amount - $infrastructure_capital) == 0 ) ? 0 : $infrastructure_amount = $infrastructure_amount - $infrastructure_capital;
            // ( ($payments_amount - $payments_capital) == 0 )             ? 0 : $payments_amount = $payments_amount - $payments_capital;
            
            $interest_total     = $interest_total + $oInterest;
            $capital_total      = $capital_total + $oCapital;
            $payment_total      = $payment_total + $oPayment;
        }

        // Guarda sumas totales
        // $oPaymentsTableData[] = array(
        //     'period'    => "Sumas",
        //     'balance'   => "",
        //     'interest'  => self::truncar($interest_total),
        //     'capital'   => self::truncar($capital_total),
        //     'payment'   => self::truncar($payment_total),
        // );
        
        foreach ($oPaymentsTableData as $k => $v )
        {
            $oPeriod = DataTablaPagosMapper::fnGetPaymentsTable( $v );
            array_push( $aPaymentsTable, $oPeriod );
        }

        //dd( $aPaymentsTable );
        // llena array  con todos los datos de solicitante
        
        return  $aPaymentsTable;
       
    }

    public static function fnGetAllPeriod($idUserCourse){
        $aPaymentsTable = [];
        // Queries
        $oAmortization = TablaPagosRepository::fnAllByUser( $idUserCourse )->first();
      
        if($oAmortization)
        {
            foreach ( $oAmortization->emp_credits_destinations as $value ) 
            {
                $result = self::fneachperiod($idUserCourse, $value->idAmount);
              
                array_push($aPaymentsTable, $result);
            }
            
            return array_merge([
                'payments_table' => $aPaymentsTable,
            ]); 
        }
    }
    
    public static function truncar($val)
    {
        // return 0.01 * (int)($val*100);
        return floor($val * 100)/100;
        // return round($val,2);
    }
    
    public static function noDecimal($val)
    {
        return (int)($val);
        // return floor($val * 100)/100;
        // return round($val,2);
    }


}


