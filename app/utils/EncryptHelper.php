<?php

namespace App\Bussiness\Helpers;

/*
 * Class EncryptHelper.
 *
 */
class EncryptHelper{
    
    /**
     * Encripta una cadena de texto
     *
     * @return string
     */
    static public function encrypt($somethingString){
        $key='L0$Prr13.14';  // Una clave de codificacion, debe usarse la misma para encriptar y desencriptar
        $encrypted = base64_encode(openssl_encrypt($somethingString, 'AES-128-ECB', md5($key)));
        
        return $encrypted; //Devuelve el string encriptado
    
    }

    /**
     * Desencripta una cadena de texto
     *
     * @return string
     */
    static public function decrypt($stringEncrypted){
        $key='L0$Prr13.14';  // Una clave de codificacion, debe usarse la misma para encriptar y desencriptar
        $decrypted = rtrim(openssl_decrypt(base64_decode($stringEncrypted), 'AES-128-ECB', md5($key)), "\0");
        
        return $decrypted;  //Devuelve el string desencriptado
    }
}