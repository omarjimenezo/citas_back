<?php
/**
 * Created by Ede nuñez.
 * User: enunez
 * Date: 25/08/2018
 */

namespace App\Business\Emprende\Services;


use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Request;

class FileService
{
    public  $API_URL = "";

    var $accessToken;

    public function __construct($token)
    {
        $this->API_URL = env('DOMAIN_ADMIN').'/api/v1/admin/academia/file/'; 
        $this->accessToken = $token;
    }


    Public function getFileScoreSolicitante($idUserCourse)
    {
        try
        {
            $client = new Client();
            $url =  $this->API_URL .$idUserCourse.'/creditBureauAuthorizationApplicant';
            $option = array('exceptions' => false);
            $header = array('authorization' => $this->accessToken,'Content-type' => 'application/json');
            $response = $client->get($url, array('headers' => $header));
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


    Public function getFileScoreDeudor($id)
    {
       
        try
        {
            $client = new Client();
            $url = $this->API_URL .$id.'/creditBureauAuthorizationWarranty';
            $option = array('exceptions' => false);
            $header = array('authorization' => $this->accessToken,'Content-type' => 'application/json');
            $response = $client->get($url, array('headers' => $header));
            $result = $response->getBody()->getContents();
            $result = json_decode($result);
        
         return ($result->data == null) ? null : $result->data->path;
        }
        catch (RequestException $e)
        {
            $response = $e;
            return $response;
        }
    }

    Public function getFileScoreAval($id)
    {
        try
        {
            $client = new Client();
            $url = $this->API_URL.$id.'/creditBureauAuthorizationAllWarranty';
            $option = array('exceptions' => false);
            $header = array('authorization' => $this->accessToken,'Content-type' => 'application/json');
            $response = $client->get($url, array('headers' => $header));
            $result = $response->getBody()->getContents();
            $result = json_decode($result);
         return $result->status; 
        }
        catch (RequestException $e)
        {
            $response = $e;
            return $response;
        }
    }

    Public function getPrePositiveAuthorization($idUserCourse)
    {
        try
        {
            $client = new Client();
            $url = $this->API_URL .'excel/'.$idUserCourse.'/prePositiveAuthorization';
            $option = array('exceptions' => false);
            $header = array('authorization' => $this->accessToken,'Content-type' => 'application/json');
            $response = $client->get($url, array('headers' => $header));
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

    Public function getPreAuthorizationNegative($idUserCourse)
    {
        try
        {
            $client = new Client();
            $url = $this->API_URL .'excel/'.$idUserCourse.'/preAuthorizationNegative';
            $option = array('exceptions' => false);
            $header = array('authorization' => $this->accessToken,'Content-type' => 'application/json');
            $response = $client->get($url, array('headers' => $header));
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

    
    Public function getOrganizationchart($imageBase64)
    {

        try
        {
            // url del servicio
            $url = $this->API_URL .'save/organizationchart';
            // asigna token
            $authToken =  $this->accessToken;
            // The data to send to the API
            $postData = array(
                'baseImg' => $imageBase64,
            );
            // Create the context for the request
            $context = stream_context_create(array(
                'http' => array(
                    // http://www.php.net/manual/en/context.http.php
                    'method' => 'POST',
                    'header' => "authorization: {$authToken}\r\n".
                    "Content-Type: application/json\r\n",
                    'content' => json_encode($postData)
                )
            ));
            // Send the request
            $response = file_get_contents($url, FALSE, $context);
          
            // Check for errors
            if($response === FALSE){
                die('Error');
            }
            // Decode the response
            $responseData = json_decode($response, TRUE);
            
            // Print the date from the response
            return ($responseData["data"] == null) ? null : $responseData["data"]["path"];

        }
        catch (ClientErrorResponseException  $e)
        {
            $response = $e->getResponse()->getBody(true);
            return $response;
        }
    }

}