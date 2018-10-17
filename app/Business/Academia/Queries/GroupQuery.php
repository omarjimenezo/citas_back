<?php
namespace App\Business\Academia\Queries;

use App\Business\Academia\Mappers\CourseGroupsMapper;
use App\Models\AdmAcaGroup;
use App\Models\Catalogs\CStatus;


class GroupQuery
{
    public static function fnGetByCourse($oRequest, $id)
    {
        $lstGroup = AdmAcaGroup::where('idCourse', '=', $id)->where('idStatus', '=', CStatus::$ACTIVO)
            ->with(array('adm_aca_group_days' => function ($query) {
                $query->select('adm_aca_group_day.idGroup', 'adm_c_day.name')
                    ->join('adm_c_day', 'adm_aca_group_day.idDay', '=', 'adm_c_day.id');
            }))
            ->with(array('c_aca_schedule' => function ($query) {
                $query->select('id','name');
            }));
        if ($oRequest->get('start_date')) {
            $lstGroup->where('start_date', '>=', $oRequest->get('start_date'));
        }
        if ($oRequest->get('end_date')) {
            $lstGroup->where('end_date', '<=', $oRequest->get('end_date'));
        }
        if ($oRequest->get('idSchedule')) {
            $lstGroup->where('idSchedule', '=', $oRequest->get('idSchedule'));
        }
        $lstGroup = $lstGroup->get();
        $oCourseGroupsResponse = CourseGroupsMapper::fnMatchDataCourseGroupResponse($lstGroup);
        return $oCourseGroupsResponse;
    }
}
