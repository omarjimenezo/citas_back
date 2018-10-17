<?php
namespace App\Business\Academia\Queries;

use App\Models\AdmAcaGroup;
use App\Models\AdmAcaSession;
use App\Business\Academia\Mappers\SessionMapper;
use App\Models\Catalogs\CStatus;
class SessionQuery
{
    public static function fnGetByGroup($id)
    {
        $oGroup = AdmAcaGroup::select('id', 'name','idCourse','idSchedule','start_date','end_date')->where('id', '=', $id)->where('idStatus', '=', CStatus::$ACTIVO)
        ->with(array('adm_aca_group_days' => function ($query) {
            $query->select('adm_aca_group_day.idGroup', 'adm_c_day.name')
                ->join('adm_c_day', 'adm_aca_group_day.idDay', '=', 'adm_c_day.id');
        }))
        ->with(['adm_aca_course' => function ($query) {
            $query->select('id','name','description');
        }])
        ->with(['c_aca_schedule' => function ($query) {
            // $query->select('id','name','description');
        }])
        ->with(['adm_aca_group_sessions' => function ($query) {
            $query->select('idGroup', 'idSession','startDate','endDate')
            ->with(['adm_aca_session' => function ($query) {
                $query->select('id','name','duration','temary');
            }]);
        }])
        ->first();
        if ($oGroup !== null) {
            return $oSessionResponse = SessionMapper::fnMatchDatasessionResponse($oGroup);
        }
        return $oGroup;
    }
}
