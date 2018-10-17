<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;

// Facades
use Illuminate\Support\Facades\Hash;

// Models
use App\Models\User;
use App\Models\modelUser;
use App\Models\Catalogs\CStatus;

// Repositories
use App\Bussiness\Academia\Repositories\UserRepository;

// responses
use App\Http\Responses\Response;
use App\Http\Responses\Auth\AuthResponse;

// requests
use Illuminate\Http\Request;


/** MATRIZ DE RASTREABILIDAD
 * <proyectot version="1.0.0">
 *  <casos de uso>
 *      <cu codigo = "AU01" >Autorización</cu>
 *  </casos de uso>
 *  <cambios></cambios>
 *  <info>
 *      <fecha>15/10/2018</fecha>
 *      <autores>
 *          <autor>Oscar Jimenez</autor>
 *      </autores>
 *      <descripción>
 *          1. Valida el usuario y contraseña sean los adecuados.
 *          2. Verifica que exista el usuario y esté activo.
 *          3. Genera un token si el usuario es válido.
 *          4. Responde con el token y datos del usuario.
 *      </descripción>
 *  </info>
 * </proyectot>
 */

class AuthController extends Controller
{

    public function __construct() 
    {
        $this->oResponse = new Response();
    }

    public function fnAuthenticate(Request  $oRequest) 
    {    
    	try {
            
             // Encuentra usuario de la base de datos
            $oUser = User::where( 'email', $oRequest->email )->where( 'id_status', cStatus::$ACTIVO )->first();
            
            // verifica si el usuario existe con el status activo sino responde con error
            if(!$oUser)
            {
                return response()->json($this->oResponse->fnResult(false, null, 'Credenciales inválidas', 1), 401);
            }
                
            // Verifica la contraseña y genera un token sino responde con error
            if (Hash::check($oRequest->input('password'), $oUser->password))
            {
                // Token y datos del usuario que serán enviados en la respuesta
                $data = new AuthResponse($oUser);
                
                // respuesta HTTP (status, data, message, code)
                return response()->json($this->oResponse->fnResult(true, $data, "Autenticación exitosa", 0), 200);
            } 
            else
            {
                // El usuario es incorrecto. asigna error de credenciales inválidas y codigo error
                return response()->json($this->oResponse->fnResult(false, null, 'Credenciales inválidas', 1), 401);               
            }
            
    	} catch(Exception $ex) {
            // Error
            return response()->json($this->oResponse->fnResult(false, null, 'Exception: '.$ex, 1), 400);
        }       
    }

    public function fnLogout(){
        try{
            JWTAuth::invalidate($token);
             // response el resultado con su codigo Http
             return response()->json($this->oResponse->fnResult(true, null, "Token invalidado.", 1), 200);
        }
        catch(Exception $ex){
             // Error
             return response()->json($this->oResponse->fnResult(false, null, 'Exception: '.$ex, 1), 400);
        }
    }
}
