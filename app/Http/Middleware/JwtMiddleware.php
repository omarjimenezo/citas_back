<?php

namespace App\Http\Middleware;

// Facades
use Closure;
use Exception;
// JWT
use Firebase\JWT\JWT;
use Firebase\JWT\ExpiredException;
// responses
use App\Http\Responses\Response;
// models
use App\Business\Academia\Repositories\UserRepository;

/** MATRIZ DE RASTREABILIDAD
 * <bioxor version="1.0.0">
 *  <casos de uso>
 *      <cu codigo = "NF05" >Seguridad</cu>
 *  </casos de uso>
 *  <cambios></cambios>
 *  <info>
 *      <fecha>11/05/2018</fecha>
 *      <autores>
 *          <autor>Joel Valdivia</autor>
 *      </autores>
 *      <descripción>
 *          1. Verifica que el token esté en los headers de Authorization.
 *          2. Verifica que el token sea correcto.
 *          4. Continua con la petición en caso de ser autorizado.
 *      </descripción>
 *  </info>
 * </bioxor>
 */
class JwtMiddleware
{
    private $oResponse;

    /**
     * Crea una instancia nueva del controlador iniciando la respuesta por default.
     *
     * Created by Joel Valdivia.
     * Created date: 11 May 2018
     * @return void
     */
    public function __construct() {
        $this->oResponse = new Response();
    }

    /** Filtro
     * Valida que el token venga en las cabeceras de la petición y lo valida con uno existente.
     * 
     * Created by Joel Valdivia.
     * Created date: 11 May 2018
     * @param $request, Clousure $next, $guard
     * @return App\Responses\Response
     */
    public function handle($request, Closure $next, $guard = null) {
        $sToken = $request->headers->get('Authorization');
        
        // verifica que exista el token en el request
        if(!$sToken)
        {
            return response()->json($this->oResponse->fnResult(false, null, 'Token inválido.'), 401);
        }

        try {
            
            // decodifica el token
            $oCredentials = JWT::decode($sToken, env('JWT_SECRET'), ['HS256']);
            
            // busca el usuario en base de datos con los datos extraidos del token
            $oCurrentUser = UserRepository::fnFind($oCredentials->sub->id);
            $oCurrentUser->token =$sToken;
           
            if(!$oCurrentUser)
                return response()->json($this->oResponse->fnResult(false, null, 'Token inválido.'), 401);

            // Asinga los datos del usuario al $request->auth para usarlo en todo el sistema
            $request->auth = $oCurrentUser;
            return $next($request);

        } catch(ExpiredException $e) {

            // Expira el token y regresa error. Debe hacer login de nuevo
            return response()->json($this->oResponse->fnResult(false, null, 'Token expirado.'), 400);

        } catch(Exception $e) {

            // Error al decodificar el token
            return response()->json($this->oResponse->fnResult(false, null, 'Error en el token.'+ $e), 400);

        }
    }
}