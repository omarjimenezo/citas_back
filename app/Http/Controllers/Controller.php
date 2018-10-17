<?php
/**
 * Created by Joel Valdivia.
 * Date: 11 May 2018
 */

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use App\Http\Controllers\Auth\AuthController;
use Illuminate\Http\Request;
//Repositories
use App\Business\Academia\Repositories\UserRepository;
//Responses
use App\Http\Responses\Response;

class Controller extends BaseController
{
    # PROPIERTIES
    public $oRequest;
    public $iCodeResponse;
    public $oResponse;
    public $oResult;
    public $oCurrenUser;
    public $oUserCourse;
    #END PROPIERTIES

    public function __construct(){

         $this->oCurrenUser = app('request')->auth;
         $this->currenToken = $this->oCurrenUser->token;
         $this->oUserCourse = UserRepository::fnFind($this->oCurrenUser->id)->first();
         $this->oResult = new Response();
         
    }
}