<?php

namespace App\Business\Academia\Mappers;

use App\Http\Responses\Academia\MyShopping\MyShoppingModel;
use App\Http\Responses\Academia\MyShopping\MyShoppingResponse;
use App\Business\Academia\Queries\MyShoppingQuery;




class MyShoppingMapper
{
    public static function fnMatchDataMyShoppingResponse($oModel)
    {
        $lstMyShopping = Collect();      
        foreach($oModel as $model)
        {
            $oPerson = MyShoppingQuery::fnGetTeacherDateByIdUserTeacher($model->aca_user_sale_course__details[0]->adm_aca_group->idUserTeacher);
            $oMyShoppingModel = new MyShoppingModel();
            $oMyShoppingModel->id_AcaUserSaleCourse = $model->id;
            $oMyShoppingModel->idUser = $model->idUser;
            $oMyShoppingModel->idPaymentType = $model->idpaymentType;
            $oMyShoppingModel->name_cAcaPaymentType = $model->c_aca_payment_type->name; 
            $oMyShoppingModel->subtotal = $model->subtotal;
            $oMyShoppingModel->total = $model->total;
            $oMyShoppingModel->price_acaUserSaleCourseDetails = $model->aca_user_sale_course__details[0]->price;
            $oMyShoppingModel->idUserTeacher = $model->aca_user_sale_course__details[0]->adm_aca_group->idUserTeacher;
            $oMyShoppingModel->id_AdmAcaCourse = $model->aca_user_sale_course__details[0]->adm_aca_group->adm_aca_course->id;
            $oMyShoppingModel->name_AdmAcaCourse = $model->aca_user_sale_course__details[0]->adm_aca_group->adm_aca_course->name;
            $oMyShoppingModel->firstName = $oPerson->firstName;
            $oMyShoppingModel->secondName = $oPerson->secondName;
            $oMyShoppingModel->lastName = $oPerson->lastName;
            $oMyShoppingModel->secondLastName = $oPerson->secondLastName;
            $oMyShoppingModel->created_at = $model->created_at->format('Y-m-d H:i:s');
            $lstMyShopping->push($oMyShoppingModel);
        }


        $oMyShoppingResponse = new MyShoppingResponse();
        $oMyShoppingResponse->lstMyShopping = $lstMyShopping;


        return $oMyShoppingResponse;
    }

}