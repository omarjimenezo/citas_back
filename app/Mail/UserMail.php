<?php
namespace App\Mail;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class UserMail extends Mailable
{
    use Queueable, SerializesModels;

    public $sFrom; // mail origen del mensaje
    public $sSubject; //asunto del mail
    public $sContent; // texto contenido
    public $sView; // diseño de la vista del mail
    public $receiverName; // Nombre del destinatario
    public $receiverSex; // Sexo del destinatario
    public $receiverHash; // hash del destinatario
    public $image; // string de imagen en base 64
    public $sUrl;



    /**
     * Constructor para una instancia de mensaje de activación de registro a cuenta Fojal Academia
     *
     * @return void
     */
    public function __construct($mailModel)
    {
        $this->sFrom = $mailModel->sFrom;
        $this->sSubject = $mailModel->sSubject;
        $this->sContent = $mailModel->sContent;
        $this->sView = $mailModel->sView;
        $this->receiverName = $mailModel->receiverName;
        $this->receiverSex = $mailModel->receiverSex;
        $this->receiverHash =  $mailModel->receiverHash;
        $this->image = $mailModel->image;
        $this->sUrl = $mailModel->sUrl;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
       return   $this->view($this->sView)
                     ->from($this->sFrom, 'Fojal Academia')
                     ->subject($this->sSubject);
    }
}
