<?php

namespace App\Business\Academia\Queries;
use App\Models\AcaUserSaleCourse;


use App\Business\Academia\Mappers\proofPaymentMapper;

class ProofPaymentQuery 
{
    public static function fnGetDataToProofPayment($idUser, $idCourse)
    {
        $oModel = AcaUserSaleCourse::select('id', 'idUser', 'idpaymentType', 'subtotal', 'total', 'created_at')
                        
                            ->with(['c_aca_payment_type' => function($query){
                                $query->select('id', 'name')->first();
                            }])
                            ->with(['aca_user_sale_course__details' => function($query){
                            $query->select('id', 'idUserSaleCourse', 'idGroup')
                            ->with(['adm_aca_group' => function($query){
                                $query->select('id', 'idCourse')
                                ->with(['adm_aca_course' => function($query){
                                    $query->select('id', 'idModel', 'name')->where('id', 1)
                                    ->with(['adm_aca_model' => function($query){
                                        $query->select('id', 'name')->first();
                                    }]);
                                }]);
                            }]);
                        }])->where('idUser', 16)->first();

        $oProofPaymentResponse = proofPaymentMapper::fnMatchDataToPDF($oModel);

        return $oProofPaymentResponse;

      
    }
}