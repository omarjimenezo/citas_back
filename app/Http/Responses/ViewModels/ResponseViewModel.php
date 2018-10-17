<?php

namespace App\Http\Responses\ViewModels;

class ResponseViewModel 
{
    public $status;
    public $data;
    public $message;

    public function __construct(){
        $this->status = true;
    }

}