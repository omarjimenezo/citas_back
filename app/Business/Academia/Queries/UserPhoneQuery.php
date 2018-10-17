<?php


namespace App\Business\Academia\Queries;

// Repositories
use App\Business\Academia\Repositories\UserPhoneRepository;
// Mappers
use App\Business\Academia\Mappers\UserPhoneMapper;

/** Class User Query */
class UserPhoneQuery
{

    /** Guarda los datos del preregistro */
    public static function fnSavePhoneUser($oRequest)
    {
        // Hace un math de los datos de registro del usuario
        //$oModel = UserPhoneMapper::fnMapSavePhone($oRequest);

        // Guarda los datos de registro del usuario
        return UserPhoneRepository::fnSave($oRequest);
    }

}