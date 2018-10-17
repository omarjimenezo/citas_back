<?php

namespace App\Business\Academia\Mappers;
use App\Http\Responses\Academia\Course\CourseModelPriceResponse;
use App\Http\Responses\Academia\Course\CourseModel;
use App\Http\Responses\Academia\Course\ModelModel;
class CourseModelPriceMapper
{
    public static function fnMatchDataCourseModelPriceResponse($oCourseModel)
    {
        $oCourse = new CourseModel();
        $oCourse->id = $oCourseModel->id;
        $oCourse->name = $oCourseModel->name;
        $oCourse->description = $oCourseModel->description;
        $oCourse->price = $oCourseModel->price;
        $oCourse->imageBackground = $oCourseModel->imageBackground;

        $oModel = new ModelModel();
        $oModel->id = $oCourseModel->adm_aca_model->id;
        $oModel->name = $oCourseModel->adm_aca_model->name;
        $oModel->description = $oCourseModel->adm_aca_model->description;
        $oModel->imageBackground = $oCourseModel->adm_aca_model->imageBackground;

        $oSessionResponse = new CourseModelPriceResponse();
        $oSessionResponse->oCourse = $oCourse;
        $oSessionResponse->oModel = $oModel;
        return $oSessionResponse;
    }
}