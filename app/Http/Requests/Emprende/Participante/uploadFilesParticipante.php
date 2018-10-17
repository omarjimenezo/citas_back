<?php
namespace App\Http\Requests\Emprende\Solicitante;

use Joeldeval\Form\FormRequest;
use App\Http\Requests\ValidationRequest;

class uploadFilesParticipante extends ValidationRequest
{
    public function authorize()
	{
		return true;
	}

	public function rules()
	{
        // dd($this->input('idRegime'));
	
   
        return $rules;
    }

    public function rule()
	{
        $rules = [
            'idUser' =>'required',
            'idRegime' => 'required',
        ];

        ///Valida si el id de regimen fiscal es fisico
        if ($this->input('idFiscalRegimeGeneral') == 1) {
           $deudor_solidario = [
                    'rfcFile_deudor' =>'required',
                    'buroFile_deudor' =>'required',
                    'curpFile_deudor' =>'required',
                    'identificationFile_deudor' =>'required',
                    'formatBuro_deudor' =>'required',
            ];

                $rules = array_merge($rules, $deudor_solidario);
             return  $rules;
         }
             ///Valida si el id de regimen fiscal es fisico
        if ($this->input('idFiscalRegimeGeneral') == 2) {
            $deudor_solidario = [
                     'rfcFile_deudor' =>'required',
                     'buroFile_deudor' =>'required',
                     'curpFile_deudor' =>'required',
                     'identificationFile_deudor' =>'required',
                     'formatBuro_deudor' =>'required',

                     'rfcFile_accionistas' =>'required',
                     'buroFile_accionistas' =>'required',
                     'curpFile_accionistas' =>'required',
                     'identificationFile_accionistas' =>'required',
                     'formatBuro_accionistas' =>'required',

             ];
 
                 $rules = array_merge($rules, $deudor_solidario);

                 if ($this->input('deudor_solidario.idSolidarityDebtor') != 2) {

                    //accionista_mayoritario-----------------------------begin
                     
                    $rules_accionista = [
                        'rfcFile_mayoritario' =>'required',
                        'buroFile_mayoritario' =>'required',
                        'curpFile_mayoritario' =>'required',
                        'identificationFile_mayoritario' =>'required',
                        'formatBuro_mayoritario' =>'required',
                    ];
                    $rules = array_merge($rules, $rules_accionista);

                }
          }
        
       return  $rules;
	}


}