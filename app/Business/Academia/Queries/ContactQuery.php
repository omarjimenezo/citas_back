<?php

namespace App\Business\Academia\Queries;


use App\Business\Academia\Mappers\ContactMapper;
use App\Models\CConfiguration;


class ContactQuery
{
    public static function fnGetContact()
    {
        $oModel = CConfiguration::where('idStatus', 1)->get();
        $oContactResponse = ContactMapper::fnMatchData($oModel);
        return $oContactResponse;
    }

}