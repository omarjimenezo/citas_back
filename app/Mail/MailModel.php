<?php
namespace App\Mail;

use Illuminate\Queue\SerializesModels;

 class MailModel
 {
    public $sFrom; // mail origen del mensaje
    public $sSubject; //asunto del mail
    public $sContent; // texto contenido
    public $sView; // diseño de la vista del mail
    public $receiverName; // Nombre del destinatario
    public $receiverSex; // Sexo del destinatario
    public $receiverHash; //hash que se envia cómo parametro en la llamada del metodo del controlador register para crear el código de alumno
    public $image;
    public $sUrl; //url para redireccionar.
}