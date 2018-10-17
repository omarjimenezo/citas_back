<?php


namespace App\Http\Responses;

use App\Http\Responses\ViewModels\ResponseViewModel;

class Response
{
    private $oResults;

    public function __construct() 
    {
        $this->oResults = new ResponseViewModel();
    }

    public function fnResult($bStatus = null, $dcData = null, $sMessage = null, $code = null){
        $this->oResults->status = $bStatus;
        $this->oResults->data = $dcData;
        $this->oResults->message = $sMessage;
        $this->oResults->code = $code;
        
        return $this->oResults;
    }

}

