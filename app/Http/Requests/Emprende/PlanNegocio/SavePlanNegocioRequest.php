<?php
namespace App\Http\Requests\Emprende\PlanNegocio;

use Joeldeval\Form\FormRequest;
use App\Http\Requests\ValidationRequest;

class SavePlanNegocioRequest extends ValidationRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            // business plan ---------

            'business_plan.describeBusinessBackground'  => 'required|min:2|max:1700',
            'business_plan.describeMarketCompetition'   => 'required|min:2|max:1700',
            // 'business_plan.descriptionProblems'         => 'required|max:1700',
            'business_plan.conclusions'                 => 'required|min:2|max:1700',

            // business plan ---------

            // talent management----------------
            
            'human_talent_management.idRotationProblems'        =>'required',
            'human_talent_management.monthlySalaryAdministrator'=>'max:10',
            'human_talent_management.monthlySalaryEmployees'    =>'max:20',
            'human_talent_management.ImageOrganizationChart'    =>'required',

            // talent management----------------
            
            // talent management----------------

            'employees_by_area.*.areaName'        =>'required|min:2|max:500',
            'employees_by_area.*.quantity'        =>'required',

            // talent management----------------

            /// product-----------------
            
            // 'product.*.name'                => 'required',
            // 'product.*.description'         => 'required|min:2|max:500',
            // 'product.*.capacity'            => 'required|min:1|max:30',
            // 'product.*.currentInstalled'    => 'required|min:1|max:10',
            // 'product.*.currentUsed'         => 'required|min:1|max:10',
            // 'product.*.currentPercentage'   => 'required',
            // 'product.*.projectedInstalled'  => 'required|min:1|max:10',
            // 'product.*.projectedUsed'       => 'required|min:1|max:10',
            // 'product.*.projectedPercentage' => 'required',
            
            /// product-----------------

        ];

        return $rules;

    }

    public function messages(){
        return [
            'business_plan.describeBusinessBackground.required'  => 'required|min:2|max:1700',
            'business_plan.describeMarketCompetition.required'   => 'required|min:2|max:1700',
            // 'business_plan.descriptionProblems.required'         => 'required|max:1700',
            'business_plan.conclusions.required'                 => 'required|min:2|max:1700',

        ];
    }
}