<?php

namespace App\Business\Academia\Mappers;
use App\Http\Responses\Academia\Pdf\proofPaymentResponse;

class proofPaymentMapper
{

    public static function fnMatchDataToPDF($oModel)
    {
        $oProofPaymentResponse = new proofPaymentResponse();
        $oProofPaymentResponse->idAcaUserSaleCourse = $oModel->id;
        $oProofPaymentResponse->CourseTotal = $oModel->total;
        $oProofPaymentResponse->CourseName = $oModel->aca_user_sale_course__details[0]->adm_aca_group->adm_aca_course->name;
        $oProofPaymentResponse->CourseModel = $oModel->aca_user_sale_course__details[0]->adm_aca_group->adm_aca_course->adm_aca_model->name;
        $oProofPaymentResponse->PaymentMethod = $oModel->c_aca_payment_type->name;
        $oProofPaymentResponse->PaymentDate = $oModel->created_at;
       
        return $oProofPaymentResponse;
    }
}
