<?php

namespace App\utils;

//Modelo de la tabla de log
use App\Models\LogException;
use DB;

/*
 * Class EncryptHelper.
 *
 */
class LogHelper{
    
    /**
     * Encripta una cadena de texto
     *
     * @return string
     */
    static public function LogSave($logMessage){
        //crear tabla de mensajes
        
    }

    //Guardado de  una excepción.
    static public function LogExceptionSave($idSystem,$logErrorMessage){
        try{
            DB::table('log_exception')->insert(array('date'=>date('d/m/y H:i:s'),'idSystem'=>$idSystem,'exception'=>$logErrorMessage)); 
        }catch(exception $e){
            echo '<script>console.log("%c Excepción al guardar el log de excepciones: %c '.$e.'", "color:green","color: red")</script>';
        }
    }
}