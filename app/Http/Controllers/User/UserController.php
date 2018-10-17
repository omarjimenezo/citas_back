<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;

// Models
use App\Models\User;
use App\Models\Catalogs\CStatus;

// Repositories
use App\Bussiness\Academia\Repositories\UserRepository;

// responses
use App\Http\Responses\Response;
use App\Http\Responses\User\UserDataResponse;

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

class UserController extends Controller
{

    public function __construct() 
    {
        $this->oResponse = new Response();
    }

    /* GET */
    public function getUserData() 
    {    
        try 
        {
            // Encuentra usuario de la base de datos
            $oUser = User::where( 'id_status', cStatus::$ACTIVO )->first();
            dd(json_encode($oUser->user_datum));
            // Token y datos del usuario que serán enviados en la respuesta
            $data = new UserDataResponse($oUser);

            return response()->json($this->oResponse->fnResult(true, $data, "Respuesta exitosa", 0), 200);
        }
        catch(Exception $ex)
        {
            return response()->json($this->oResponse->fnResult(false, null, 'Exception: '.$ex, 1), 400);
        }
    }

}