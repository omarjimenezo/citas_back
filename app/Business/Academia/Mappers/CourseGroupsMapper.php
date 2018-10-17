<?php

namespace App\Business\Academia\Mappers;
use App\Http\Responses\Academia\Course\CourseGroupsResponse;
class CourseGroupsMapper
{
    public static function fnMatchDataCourseGroupResponse($oModel)
    {
        $lstGroups = [];
        foreach ($oModel as $value) {
            $oGroup = new CourseGroupsResponse();
            $oGroup->id = $value->id;
            $oGroup->name = $value->name;
            $oGroup->schedule = $value->c_aca_schedule->name;
            $oGroup->start_date = $value->start_date === null? null : $value->start_date->format('Y-m-d H:i:s');
            $oGroup->end_date = $value->end_date === null? null : $value->end_date->format('Y-m-d H:i:s');
            $sDays = "";
            for ($i = 0; $i < count($value->adm_aca_group_days); $i++) {
                if($i == count($value->adm_aca_group_days)-1){
                    $sDays = $sDays.' y '.$value->adm_aca_group_days[$i]['name'];
                }else {
                    $sDays = $sDays.' '.$value->adm_aca_group_days[$i]['name'];
                }
            }
            $oGroup->days = $sDays;
            array_push($lstGroups,$oGroup);
        }
        return $lstGroups;
    }
}