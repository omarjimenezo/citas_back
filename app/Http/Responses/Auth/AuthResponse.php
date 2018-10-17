<?php

namespace  App\Http\Responses\Auth;

// JWT 
use Firebase\JWT\JWT;

use Illuminate\Http\Resources\Json\JsonResource;

class AuthResponse extends JsonResource
{
    public function toArray($request)
    {
        $Token = $this->fnJwt($this->first());

        $this->update(['token' => $Token]);

        return [
            "id"    => $this->id,
            "email" => $this->email,
            "token" => $Token
        ];
    }

    protected function fnJwt($oUser) 
    {    
        
        $aPayload = [
            'iss' => "lumen-jwt", 
            'sub' => $oUser, // Usuario del token.
            'iat' => time(), // Hora en que se emite el JWT. 
            'exp' => time() + 1000*1000 // Tiempo que expira el token.
        ];
        
        // se puede usar para decodificar el token en un futuro.
        return JWT::encode($aPayload, env('JWT_SECRET'));
    } 

}