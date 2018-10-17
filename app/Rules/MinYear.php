<?php
namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class MinYear Implements Rule
{
    /**
     * Crate a new rule instance.
     * 
     * @return void
     */
    public function __construct(){
        //
    }

    /**
     * Determine if the validation rule passes
     * 
     * @param string $attribute
     * @param mixed $value
     * @param bool
     */
    public function passes($attribute,$value){

        return (calculaedad($value) >= 30) ? true : false;
    }
    /**
     * Get the validation error message
     * 
     * @return string
     */
    public function message(){
        return "El deudor solidario tiene que ser mayor a 30 años.";
    }

    public function calculaedad($fechanacimiento){

        list($ano,$mes,$dia) = explode("-",$fechanacimiento);
        $ano_diferencia  = date("Y") - $ano;
        $mes_diferencia = date("m") - $mes;
        $dia_diferencia   = date("d") - $dia;
        if ($dia_diferencia < 0 || $mes_diferencia < 0)
            $ano_diferencia--;
        return $ano_diferencia;
    }
    
}