<?php
/**
 * Created by PhpStorm.
 * User: Bioxor
 * Date: 05/06/2018
 * Time: 04:12 PM
 */

namespace App\Business\Emprende\Queries;

use App\Models\AcaUserAcademy;
use App\Models\EmpApplicantDetail;
use App\Models\EmpBusinessDatum;
use App\Models\EmpCreditDatum;
use App\Models\EmpInitialDatum;
use App\Models\EmpParticipantsGuarantee;
use App\Models\EmpReference;
use App\Models\Emprende\CustomAcaUserAcademy;
use App\Models\Emprende\CustomEmpParticipantsGuarantee;
use App\Models\Emprende\CustomEmpWarranty;
use App\Models\Vwrequestfojalemprende;
use Carbon\Carbon;

class CreatePdfDocumentsQuery
{
    public static function EmpInitialData($id)
    {
        $oModel = Vwrequestfojalemprende::where('id', '=', $id)->where('idStatus', '=', 1)->first();
        $oInitialData = EmpInitialDatum::where('idUserCourse', '=', $id)->where('idStatus', '=', 1)
            ->with('c_municipality')
            ->with('c_sector')
            ->first();
        $oApplicant = EmpApplicantDetail::where('idUserCourse', '=', $id)->where('idStatus', '=', 1)
            ->with('c_score')
            ->with('c_country')
            ->with('c_id_type')
            ->with('c_identification_issuer')
            ->first();
        $oBusinessData = EmpBusinessDatum::where('idUserCourse', '=', $id)->where('idStatus', '=', 1)
            ->with('c_municipality')
            ->first();
        $oRepresentLegal = CustomEmpParticipantsGuarantee::where('idUserCourse', '=', $id)->where('idStatus', '=', 1)
            ->where('idParticipantsGuarantee', '=', 2)
            ->with('c_municipality')
            ->with('c_id_type')
            ->with('c_identification_issuer')
            ->with('c_score')
            ->with('c_emp_participants_guarantee')
            ->with('c_gender')
            ->with('c_civil_status')
            ->with('c_matrimonial_regime')
            ->with('c_country')
            ->with('c_country1')
            ->with('c_state')
            ->with('c_emp_relationship_applicant')
            ->first();
        $oSolidarityDebtor = CustomEmpParticipantsGuarantee::where('idUserCourse', '=', $id)->where('idStatus', '=', 1)
            ->where('idParticipantsGuarantee', '=', 1)
            ->with('c_municipality')
            ->with('c_id_type')
            ->with('c_identification_issuer')
            ->with('c_score')
            ->with('c_emp_participants_guarantee')
            ->with('c_gender')
            ->with('c_civil_status')
            ->with('c_matrimonial_regime')
            ->with('c_country')
            ->with('c_country1')
            ->with('c_state')
            ->with('c_emp_relationship_applicant')
            ->first();
        $oEndorsement = CustomEmpParticipantsGuarantee::where('idUserCourse', '=', $id)->where('idStatus', '=', 1)
            ->where('idParticipantsGuarantee', '=', 5)
            ->with('c_municipality')
            ->with('c_id_type')
            ->with('c_identification_issuer')
            ->with('c_score')
            ->with('c_emp_participants_guarantee')
            ->with('c_gender')
            ->with('c_civil_status')
            ->with('c_matrimonial_regime')
            ->with('c_country')
            ->with('c_country1')
            ->with('c_state')
            ->with('c_emp_relationship_applicant')
            ->first();

        $oCreditData = EmpCreditDatum::where('idUserCourse', '=', $id)->where('idStatus', '=', 1)
            ->with('c_short_term')
            ->with('c_another_credit')
            ->first();
        $oReference = EmpReference::where('idUserCourse', '=', $id)->where('idStatus', '=', 1)
            ->with('c_reference')
            ->take(3)->get();
        $oModelDate = Carbon::now();
        return array(
            'oModel' => $oModel,
            'oModelDate' => $oModelDate,
            'oInitialData' => $oInitialData,
            'oApplicant' => $oApplicant,
            'oBusinessData' => $oBusinessData,
            'oRepresentLegal' => $oRepresentLegal,
            'oSolidarityDebtor' => $oSolidarityDebtor,
            'oEndorsement' => $oEndorsement,
            'oCreditData' => $oCreditData,
            'oReference' => $oReference
        );
    }

    public static function LParticipantsGuaranteeData($id)
    {
        $oModel = Vwrequestfojalemprende::where('id', '=', $id)->where('idStatus', '=', 1)->first();
        $oDeudor = CustomEmpParticipantsGuarantee::where('idUserCourse', '=', $id)
                                                   ->where('idStatus', '=', 1)
                                                   ->where('idParticipantsGuarantee', '=', 1)->first();
        $oRepresentante = CustomEmpParticipantsGuarantee::where('idUserCourse', '=', $id)
                                                          ->where('idStatus', '=', 1)
                                                          ->where('idParticipantsGuarantee', '=', 2)->first();
        $oAval = CustomEmpParticipantsGuarantee::where('idUserCourse', '=', $id)
                                                ->where('idStatus', '=', 1)
                                                ->where('idParticipantsGuarantee', '=', 5)->first();
        $lParticipantsGuarantee = CustomEmpParticipantsGuarantee::where('idUserCourse', '=', $id)
            ->where([['id', '<>', $oDeudor->id],['id','<>',$oRepresentante->id],['id','<>',$oAval->id]])
            ->with('c_municipality')
            ->with('c_id_type')
            ->with('c_identification_issuer')
            ->with('c_score')
            ->with('c_emp_participants_guarantee')
            ->with('c_gender')
            ->with('c_civil_status')
            ->with('c_matrimonial_regime')
            ->with('c_country')
            ->with('c_country1')
            ->with('c_state')
            ->with('c_emp_relationship_applicant')
            ->where('idStatus', '=', 1)->get();
        return array(
            'oModel' => $oModel,
            'lParticipantsGuarantee' => array_chunk($lParticipantsGuarantee->toArray(),3)
        );
    }

    public static function PatrimonialRelationshipData($id)
    {
        $oModel = AcaUserAcademy::where('id', '=', $id)
                  ->where('idStatus', '=', 1)
                  ->with('emp_credit_data')
                  ->first();
        $oDate = Carbon::now();
        $lEmpWarraty = CustomEmpWarranty::where('idUserCourse', '=', $id)
                                    ->with('emp_property_receipts')
                                    ->with('emp_participants_guarantee')
                                    ->where('idStatus', '=', 1)
                                    ->get();
        return array(
            'oModel' => $oModel,
            'oDate' => $oDate,
            'lEmpWarraty' => array_chunk($lEmpWarraty->toArray(),2)
        );
    }
    public static function DataParticipantAndGuarantee($id){
        $oUserAcademy = CustomAcaUserAcademy::where('id', '=', $id)
            ->with('emp_participants_guarantees_status_1')
            ->with('c_fiscal_regime')
            ->with('c_municipality')
            ->with('c_state')
            ->first();
        $oDate = Carbon::now();
        return array('oDate'=>$oDate,'oUserAcademy'=>$oUserAcademy);
    }
}