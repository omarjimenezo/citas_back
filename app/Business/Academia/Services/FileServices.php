<?php
/**
 * Created by Ede nuñez.
 * User: enunez
 * Date: 25/08/2018
 */

namespace App\Business\Academia\Services;



//Biblioteca que permite hacer un cliente de servicios.
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\RequestOptions;

class FileServices
{
    //Uri base.
    const API_URL = 'http://fojaladmin.bioxor.net/api/v1/admin';


    //Metodo que genera la peticion
    Public static function BuildConstancy($token, $idUserCourse)
    {
        try
        {
            //$body = '{idUserCourse: ' . $idUserCourse . '}';
            $url = self::API_URL . '/course/generate/certificate';
            
            //Se crea el cliente.
            $gClient = new Client();
            $option = array('exceptions' => false);
            
            //Se agrega el tipo de peticion, la url, los headers y el json (en caso de tener)
            $response = $gClient->request('POST', $url,[
                'headers' => [
                    'Authorization' => $token,
                    'Accept'     => 'application/json'
                ], 'json' => [ 'idUserCourse' => $idUserCourse]
            ]);

            //se recoge la respuesta
            $result = $response->getBody()->getContents();
            $result = json_decode($result);
            
            return ($result->data == null) ? null : $result->data->path;
        }
        catch (ClientErrorResponseException  $e)
        {
            $response = $e->getResponse()->getBody(true);
            return $response;
        }
    }
}