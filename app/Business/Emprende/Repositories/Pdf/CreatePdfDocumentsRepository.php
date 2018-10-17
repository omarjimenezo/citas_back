<?php
/**
 * Created by PhpStorm.
 * User: Bioxor
 * Date: 24/05/2018
 * Time: 03:05 PM
 */

namespace App\Business\Emprende\Repositories\Pdf;


use App\Business\Emprende\Constants\ConstantsEmprende;

use App\Business\Emprende\Mappers\DataAcaUserFileMapper;
use App\Business\Emprende\Mappers\DataCreatePdfMapper;
use App\Business\Emprende\Queries\CreatePdfDocumentsQuery;
use App\Http\Responses\Emprende\Solicitante\preAuthorizationNegativeModel;
use App\Business\Interfaces\PdfRepo;
use App\Models\AcaUserAcademy;
use App\Models\AdmCTabulatorMunicipalityBlock;
use Carbon\Carbon;
use http\Env\Url;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;
use App\Models\modelUser;
use App\Models\CMunicipality;

class CreatePdfDocumentsRepository implements PdfRepo
{
    /**
     * CreatePdfDocumentsRepository constructor.
     */


    /**
     * CreatePdfDocumentsRepository constructor.
     */

    public static function preAuthorizationNegative($id)
    {
        $oModel = DataCreatePdfMapper::DataAcaUserAcademy($id);
        $nameEncrypt = $oModel['oUserAcademy']->studentCode;
        $BaseUrl = ConstantsEmprende::$basePathUrlFilesStudents.$nameEncrypt. "/preAuthorizationNegative/";
        $path = base_path() . ConstantsEmprende::$basePathFilesStudents .$nameEncrypt . "/preAuthorizationNegative/";
        if (!File::exists($path)) {
            File::makeDirectory($path, '0777', true, true);
        }
        $view = View::make('Pdf.preAuthorizationNegative', $oModel)->render();
        $pdf = App::make('dompdf.wrapper');
        $paper_size = array(0, 0, 678, 890);
        $pdf->setPaper($paper_size, 'portrait');
        $pdf->loadHTML($view);
        $pdf->save($path . "preAuthorizationNegative.pdf");
        $oModelFile = DataAcaUserFileMapper::ModelAcaUserFile(['idUser' => $oModel['oUserAcademy']->id,'idFileName'=>1,'pathFile'=>$BaseUrl . "preAuthorizationNegative.pdf",'idParticipantsGuarantee'=>null]);
        $oModelFile->save();
    }

    public static function creditApplicationFojalEmprende($id)
    {
        $oModel = CreatePdfDocumentsQuery::EmpInitialData($id);
        $nameEncrypt = $oModel['oModel']->studentCode;
        $BaseUrl = ConstantsEmprende::$basePathUrlFilesStudents.$nameEncrypt. "/creditApplicationFojalEmprende/";
        $path = base_path() . ConstantsEmprende::$basePathFilesStudents .$nameEncrypt . "/creditApplicationFojalEmprende/";
        if (!File::exists($path)) {
            File::makeDirectory($path, '0777', true, true);
        }
        $view = View::make('Pdf.creditApplicationFojalEmprende',$oModel)->render();
        $pdf = App::make('dompdf.wrapper');
        $paper_size = array(0, 0, 830, 1000);
        $pdf->setPaper($paper_size, 'portrait');
        $pdf->loadHTML($view);
        $pdf->save($path . "creditApplicationFojalEmprende.pdf");
        $oModelFile = DataAcaUserFileMapper::ModelAcaUserFile(['idUser' => $oModel['oModel']->id,'idFileName'=>2,'pathFile'=>$BaseUrl . "creditApplicationFojalEmprende.pdf",'idParticipantsGuarantee'=>null]);
        $oModelFile->save();
    }

    public static function identityOfParticipants($id)
    {
        $oModel = CreatePdfDocumentsQuery::LParticipantsGuaranteeData($id);
        $nameEncrypt = $oModel['oModel']->studentCode;
        $BaseUrl = ConstantsEmprende::$basePathUrlFilesStudents.$nameEncrypt. "/identityOfParticipants/";
        $path = base_path() . ConstantsEmprende::$basePathFilesStudents .$nameEncrypt . "/identityOfParticipants/";
        if (!File::exists($path)) {
            File::makeDirectory($path, '0777', true, true);
        }
        foreach ($oModel['lParticipantsGuarantee'] as $item) {
            $view = View::make('Pdf.identityOfParticipants', array('oModel'=>$oModel['oModel'],'item'=>$item))->render();
            $pdf = App::make('dompdf.wrapper');
            $paper_size = array(0, 0, 830, 1000);
            $pdf->setPaper($paper_size, 'portrait');
            $pdf->loadHTML($view);
            $pdf->save($path . "identityOfParticipants.pdf");
            $oModelFile = DataAcaUserFileMapper::ModelAcaUserFile(['idUser' => $oModel['oModel']->id, 'idFileName' => 3, 'pathFile' => $BaseUrl . "identityOfParticipants.pdf", 'idParticipantsGuarantee' => null]);
            $oModelFile->save();
        }
    }

    public static function conditionsOfTheSector($id)
    {
        $oModel = AcaUserAcademy::where('id', '=', $id)->first();
        $oBlockModel = AdmCTabulatorMunicipalityBlock::where('idMunicipality',$oModel->idMunicipality)->with('c_block')->first();
        $oDate = Carbon::now();
        $nameEncrypt = $oModel->studentCode;
        $BaseUrl = ConstantsEmprende::$basePathUrlFilesStudents.$nameEncrypt. "/conditionsOfTheSector/";
        $path = base_path() . ConstantsEmprende::$basePathFilesStudents .$nameEncrypt . "/conditionsOfTheSector/";
        if (!File::exists($path)) {
            File::makeDirectory($path, '0777', true, true);
        }
        $view = View::make('Pdf.conditionsOfTheSector', array('oModel'=>$oModel,'oDate'=>$oDate,'oBlockModel'=>$oBlockModel))->render();
        $pdf = App::make('dompdf.wrapper');
        $paper_size = array(0, 0, 830, 1000);
        $pdf->setPaper($paper_size, 'portrait');
        $pdf->loadHTML($view);
        $pdf->save($path . "conditionsOfTheSector.pdf");
        $oModelFile = DataAcaUserFileMapper::ModelAcaUserFile(['idUser' => $oModel->id,'idFileName'=>4,'pathFile'=>$BaseUrl . "conditionsOfTheSector.pdf",'idParticipantsGuarantee'=>null]);
        $oModelFile->save();
    }

    public static function patrimonialRelationship($id)
    {
        $oModel = CreatePdfDocumentsQuery::PatrimonialRelationshipData($id);
        $nameEncrypt = $oModel['oModel']->studentCode;
        $BaseUrl = ConstantsEmprende::$basePathUrlFilesStudents.$nameEncrypt. "/patrimonialRelationship/";
        $path = base_path() . ConstantsEmprende::$basePathFilesStudents .$nameEncrypt . "/patrimonialRelationship/";
        if (!File::exists($path)) {
            File::makeDirectory($path, '0777', true, true);
        }
        $view = View::make('Pdf.patrimonialRelationship', $oModel)->render();
        $pdf = App::make('dompdf.wrapper');
        $paper_size = array(0, 0, 830, 1000);
        $pdf->setPaper($paper_size, 'portrait');
        $pdf->loadHTML($view);
        $pdf->save($path . "patrimonialRelationship.pdf");
        $oModelFile = DataAcaUserFileMapper::ModelAcaUserFile(['idUser' => $oModel['oModel']->id,'idFileName'=>5,'pathFile'=>$BaseUrl . "patrimonialRelationship.pdf",'idParticipantsGuarantee'=>null]);
        $oModelFile->save();
    }

    public static function prePositiveAuthorization($id)
    {
        $oModel = DataCreatePdfMapper::DataAcaUserAcademy($id);
        $nameEncrypt = $oModel['oUserAcademy']->studentCode;
        $BaseUrl = ConstantsEmprende::$basePathUrlFilesStudents.$nameEncrypt. "/prePositiveAuthorization/";
        $path = base_path() . ConstantsEmprende::$basePathFilesStudents .$nameEncrypt . "/prePositiveAuthorization/";
        if (!File::exists($path)) {
            File::makeDirectory($path, '0777', true, true);
        }
        $view = View::make('Pdf.prePositiveAuthorization', $oModel)->render();
        $pdf = App::make('dompdf.wrapper');
        $paper_size = array(0, 0, 830, 1000);
        $pdf->setPaper($paper_size, 'portrait');
        $pdf->loadHTML($view);
        $pdf->save($path . "prePositiveAuthorization.pdf");
        $oModelFile = DataAcaUserFileMapper::ModelAcaUserFile(['idUser' => $oModel['oUserAcademy']->id,'idFileName'=>6,'pathFile'=>$BaseUrl . "prePositiveAuthorization.pdf",'idParticipantsGuarantee'=>null]);
        $oModelFile->save();
    }

    public static function creditBureauAuthorization($id)
    {
        $oModel = CreatePdfDocumentsQuery::DataParticipantAndGuarantee($id);
        $nameEncrypt = $oModel['oUserAcademy']->studentCode;
        $BaseUrl = ConstantsEmprende::$basePathUrlFilesStudents.$nameEncrypt. "/creditBureauAuthorization/";
        $path = base_path() . ConstantsEmprende::$basePathFilesStudents .$nameEncrypt . "/creditBureauAuthorization/";
        if (!File::exists($path)) {
            File::makeDirectory($path, '0777', true, true);
        }
        $view = View::make('Pdf.creditBureauAuthorization', $oModel)->render();
        $pdf = App::make('dompdf.wrapper');
        $paper_size = array(0, 0, 830, 1000);
        $pdf->setPaper($paper_size, 'portrait');
        $pdf->loadHTML($view);
        $pdf->save($path ."applicant_CreditBureauAuthorization.pdf");
        $oModelFile = DataAcaUserFileMapper::ModelAcaUserFile(['idUser' => $oModel['oUserAcademy']->id,'idFileName'=>7,'pathFile'=>$BaseUrl . "applicant_CreditBureauAuthorization.pdf",'idParticipantsGuarantee'=>null]);
        $oModelFile->save();
        foreach ($oModel['oUserAcademy']->emp_participants_guarantees_status_1 as $oItemModel){
            $view = View::make('Pdf.creditBureauAuthorization', array('oDate'=>$oModel['oDate'],'oUserAcademy'=>$oItemModel))->render();
            $pdf = App::make('dompdf.wrapper');
            $paper_size = array(0, 0, 830, 1000);
            $pdf->setPaper($paper_size, 'portrait');
            $pdf->loadHTML($view);
            $pdf->save($path .$oItemModel->id."_CreditBureauAuthorization.pdf");
            $oModelFile = DataAcaUserFileMapper::ModelAcaUserFile(['idUser' => $oModel['oUserAcademy']->id,'idFileName'=>7,'pathFile'=>$BaseUrl .$oItemModel->id."_CreditBureauAuthorization.pdf",'idParticipantsGuarantee'=>$oItemModel->id]);
            $oModelFile->save();
        }
    }
}