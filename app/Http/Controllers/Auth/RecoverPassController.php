<?php


namespace App\Http\Controllers\Auth;

/**
 * Created by Christian Sánchez.
 * Date: 19 Jun 2018
 */
use App\Http\Controllers\Controller;
// JWT 
use Firebase\JWT\JWT;
// Facades
use Illuminate\Support\Facades\Hash;
// Models
use App\Models\AcaUserAcademy;
use App\Models\Catalogs\CStatus;
//Query

use App\Business\Academia\Queries\RecoverPassQuery;
// Repositories
use App\Business\Academia\Repositories\UserRepository;
//responses
use App\Http\Responses\Response;

use App\Http\Response\Academia\Auth\LoginResponse;
// requests
//Mappers
use App\Business\Academia\Mappers\UserMapper;
use Illuminate\Support\Facades\Mail;
use App\Mail\UserMail;
use App\Mail\MailModel;

use App\Http\Requests\Academia\Auth\RecoverPassRequest;
use App\Http\Requests\Academia\Auth\ValidateTokenPass;


/** MATRIZ DE RASTREABILIDAD
 * <bioxor version="1.0.0">
 *  <casos de uso>
 *      <cu codigo = "AC03" >Recuperar contraseña</cu>
 *  </casos de uso>
 *  <cambios></cambios>
 *  <info>
 *      <fecha>19/06/2018</fecha>
 *      <autores>
 *          <autor>Christian Sánchez</autor>
 *      </autores>
 *      <descripción>
 *          1. Valida el correo electronico en la base de datos para confirmar si existe.
 *          2. Verifica que el correo electronico se encuentre activo para un usuario.
 *          3. Genera y almacena en base de datos un token y su fecha de caducidad
 *          4. Construye la ruta accesible desde el navegador y envia el email.
 *          5. Verifica la caducidad del token y almacena la nueva contraseñañ.
 *      </descripción>
 *  </info>
 * </bioxor>
 */
class RecoverPassController extends Controller
{
    public $oResponse;
    public function __construct() {
        $this->oResponse = new Response();
    }

    /** Crea Token
     * 
     * Created by Christian Sánchez
     * Created date: 19 Jun 2018
     *
     * @param App\Models\Admin\User $oUser
     * @return string
     */
    
    protected function fnJwt($oUser) {  
        
        $aPayload = [
            'sub' => $oUser->id, // Usuario del token.
            'iat' => time(), // Hora en que se emite el JWT. 
            'exp' => time() + 60 * 60, // Tiempo que expira el token.
            //'aud' => self::Aud(),
            'data' => [
                'username' => $oUser->username,
                'email' => $oUser->email
            ]
        ];
        
        // se puede usar para decodificar el token en un futuro.
        return JWT::encode($aPayload, env('JWT_SECRET'));
    }

    
    /*Valida la información, actualiza la base de datos.
     * 
     * Created by Christian Sánchez.
     * Created date: 27 Jun 2018
     *
     * @param App\Http\Requests\Academia\Auth\RecoverPassRequest $oRecoverPassRequest
     * @return string
     */
    public function ValidateData(RecoverPassRequest $oRecoverPassRequest)
    {
//        $oAcaUser = RecoverPassQuery::fnFindByEmail($oRecoverPassRequest);
  //      $token = $this->fnJwt($oAcaUser);
        try
        {
            // obtiene un usuario valido desde base de datos.
            //$oAcaUser = AcaUserAcademy::where('email', $oRecoverPassRequest->input('email'))->where('idStatus', cStatus::$ACTIVO)->first();
            $oAcaUser = RecoverPassQuery::fnFindByEmail($oRecoverPassRequest);

            if($oAcaUser == null)
                return response()->json($this->oResponse->fnResult(false, null, 'No existe email'), 400);
            
            $token = $this->fnJwt($oAcaUser);
            
           
            //EnviarEmail

            $content = 'Para restablecer su contraseña haz clic en el siguiente enlace:';
            
             $oMailModel = new MailModel();
             $oMailModel->sContent = $content;
             $oMailModel->sSubject = 'Recuperar contraseña';
             $oMailModel->sFrom = 'biotest09@gmail.com';
             $oMailModel->sView = 'emails.recoverPass';
             //$oMailModel->sUrl = 'http://academia.bioxor.net/#/index?token='. $token;
             $oMailModel->sUrl = env('ACADEMIA_URL').'index?token='. $token; 
             $oMailModel->receiverName = $oAcaUser->firstName;
            //Mail::to($oAcaUser->email, 'Fojal')->send(new UserMail('biotest09@gmail.com', 'test', $content, 'emails.recoverPass'));
            Mail::to($oAcaUser->email, 'Fojal')->send(new UserMail($oMailModel));
            //Mail::to('csanchez@bioxor.com', 'Fojal')->send(new UserMail($oMailModel));
            
            $oAcaUser->token = $token;
            $oResult = RecoverPassQuery::fnUpdateUserToken($oAcaUser);
        
        }
        catch(Exception $err)
        {
           return response()->json($this->oResponse->fnResult(false,null,$err), 400);
        }
        
        return response()->json($this->oResponse->fnResult(true,null,"Tu email ha sido enviado con exito"), 200);
    }


    /*Actualiza el password del usuario
     * 
     * Created by Christian Sánchez.
     * Created date: 27 Jun 2018
     *
     * @param App\Http\Requests\Academia\Auth\ValidateTokenPass $oValidateTokenPass
     * @return string
     */

    public function UpdateUserPassword(ValidateTokenPass $oValidateTokenPass)
    {

        //Obtener la información de data.
        //$data = JWT::decode($oValidateTokenPass->token, $key, ['HS256'])->data;
       // dd($data->email);  
        try
        {
            $oUser = AcaUserAcademy::where('token', $oValidateTokenPass->input('token'))->where('idStatus', cStatus::$ACTIVO)->first();
            // $oUser = RecoverPassQuery::fnFindByEmail($oValidateTokenPass);
            
            if($oUser == null)
                return response()->json($this->oResponse->fnResult(false, null, 'No existe email'), 400);
            if($oUser->token == $oValidateTokenPass->input('token'))
            {
                $key = env('JWT_SECRET');
                try
                {
                    $credentials = JWT::decode($oValidateTokenPass->token, $key, ['HS256']);
                }
                catch(\Firebase\JWT\ExpiredException  $e)
                {
                    return response()->json($this->oResponse->fnResult(false,null,$e->getMessage()), 400);
                }    //Validar si el token ya caduco al momento de descodificarlo de otra forma se actualiza el password.
           
                $oUser->password = $oValidateTokenPass->input('password');
                $oResult = RecoverPassQuery::fnUpdateUserPassword($oUser);
            }
        }
        catch(Exception $err)
        {
           return response()->json($this->oResponse->fnResult(false,null,$err), 400);
        }

        return response()->json($this->oResponse->fnResult(true,null,"La contraseña a sido actualizada con exito"), 200);
    }
    
}
