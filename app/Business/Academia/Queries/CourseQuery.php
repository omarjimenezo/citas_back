<?php
namespace App\Business\Academia\Queries;

//Repositories
use App\Business\Academia\Mappers\CourseModelPriceMapper;
use App\Business\Academia\Repositories\AcaUserSaleCourseDetailRepository;
use App\Business\Academia\Repositories\AcaUserSaleCourseRepository;
use App\Business\Academia\Repositories\CconfigurationRepository;
use App\Business\Academia\Repositories\CourseRepository;
use App\Business\Academia\Repositories\AcaUserCourseRepository;
//Mappers
use App\Business\Academia\Repositories\GroupRepository;
use App\Business\Acedemia\Mappers\AcaUserSaleCourseDetailMapper;
use App\Business\Acedemia\Mappers\AcaUserSaleCourseMapper;
use App\Business\Acedemia\Mappers\AcaUserCourseMapper;
//Model
use App\Models\AcaUserAcademy;
use App\Models\AdmAcaCourse;
use App\Models\CConfiguration;
use App\Models\AcaUserSaleCourse;
use DB;

class CourseQuery
{
    public static function fnSelectData()
    {
        $lstCourses = CourseRepository::fnGet();
        return $lstCourses;
    }
    public static function fnSearchCourse($sTag)
    {
        $lstCourses = CourseRepository::fnSearch($sTag);
        return $lstCourses;
    }
    public static function fnGetById($id)
    {
        $oCourse = CourseRepository::fnFind($id);
        return $oCourse;
    }
    public static function fnGetPriceById($id)
    {
        $oCourseModelPrice = AdmAcaCourse::select('id', 'idModel', 'name', 'description', 'price', 'imageBackground')->where('id', '=', $id)
            ->with(['adm_aca_model' => function ($query) {
                $query->select('id', 'name', 'description', 'imageBackground');
            }])->first();

        if ($oCourseModelPrice !== null) {
            return $oCourseModelPrice = CourseModelPriceMapper::fnMatchDataCourseModelPriceResponse($oCourseModelPrice);
        }
        return $oCourseModelPrice;
    }

    public static function CheckCoursesPending($id)
    {
        $oSaleCourse = AcaUserSaleCourse::where('idUser', $id)->where('idStatus', 1)->get();
        

        if($oSaleCourse != null && count($oSaleCourse))
            return true;
        else
            return false;
    }
    public static function fnSaveInscription($oRequest, $idGroup, $idUser)
    {
        DB::beginTransaction();
        try {
            $oGroup = GroupRepository::fnFind($idGroup);
            if ($oGroup !== null) {
                $oCourse = CourseRepository::fnFind($oGroup->idCourse);
                if ($oCourse !== null) {
                    $oAUSCourse = AcaUserSaleCourseMapper::fnAcaUserSaleCourse($idUser, $oRequest->idpaymentType, $oCourse->price);
                    $oAUSC = AcaUserSaleCourseRepository::fnSave($oAUSCourse);
                    $oAUSCourseDetail = AcaUserSaleCourseDetailMapper::fnAcaUserSaleCourseDetail($oAUSC->id, $idGroup, $oCourse->price);
                    AcaUserSaleCourseDetailRepository::fnSave($oAUSCourseDetail);
                    // Se quita para que no se creen registros a lo wey y lo haga el admin cuando el usuario valla  a pagar.
                    $oAUCourse = AcaUserCourseMapper::fnAcaUserCourse($oCourse->id, $idUser);
                    AcaUserCourseRepository::fnSave($oAUCourse);
                    DB::commit();
                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        } catch (\Exception $ex) {
             DB::rollback();
             return false;
        }
    }
    public static function fnVerifySesionTool($idCourse, $oUserCourse)
    {
        // obtiene ultima sesion del curso del usuario
        $oCourse = CourseRepository::fnFindSessionByCourse($idCourse)->first();
        //compara la ultima session de un curso con la sesion de la herramienta
        return ($oCourse->idSession == $oUserCourse->sessionTool) ? true : false;

    }

    public static function fnBuildFolioToSale($idUser)
    {
        $oUser = AcaUserAcademy::select('studentCode')->where('id', $idUser)->first();
        //dia a 2 digitos
        $CurrentDay = date("d");
        //mes a 2 digitos
        $CourrentMonth = date("m");
        //año a 2 digitos
        $CurrentYear = date("y");
        $lastFolio = CConfiguration::where('id', '18')->first();
        $CurrentFolio = $lastFolio->ValueConfig + 1;
        //Actualizar el folio en la tabla configuracion
        $lastFolio->ValueConfig = $CurrentFolio;
        DB::beginTransaction();
        try {
            $oResponse = CconfigurationRepository::fnSave($lastFolio);
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            return 0;
        }
        $folio = "" . $CurrentDay . "" . $CourrentMonth . "" . $CurrentYear . "-" . $oUser->studentCode . "-" . $CurrentFolio;
        return $folio;
    }
    public static function clopletedProfile($idUser)
    {
        $oUser = AcaUserAcademy::where('id', $idUser)->first();
        return $oUser->idAction === 1 ? false : true;
    }
}
