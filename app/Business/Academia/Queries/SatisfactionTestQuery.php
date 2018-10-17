<?php

namespace App\Business\Academia\Queries;
use App\Models\AdmAcaTestSession;
use App\Models\AdmCSectionQuestion;
use App\Business\Academia\Mappers\SatisfactionTestMapper;
use App\Business\Academia\Mappers\AcaUserCourseTestMapper;
use App\Business\Academia\Mappers\AcaUserCourseTestAnswerMapper;
use App\Business\Academia\Repositories\AcaUserCourseTestRepository;
use App\Business\Academia\Repositories\AcaUserCourseTestAnswerRepository;
use App\Business\Academia\Repositories\AcaUserCourseGroupSessionRepository;
use App\Business\Academia\Mappers\AcaUserCourseGroupSessionMapper;
use App\Business\Academia\Services\FileServices;
use App\Models\AcaUserCourse;
use App\Models\AcaUserCourseGroupSession;
use App\Models\AdmAcaGroupSession;
use App\Models\AcaUserCourseTest;
use App\Models\AdmAcaCourse;

//Hash
use Illuminate\Support\Facades\Hash;
use DB;

class SatisfactionTestQuery
{
    public static function fnGetQuestions($idGroupSession)
    {
        $oSatisfactionTest = AdmAcaTestSession::select('id', 'idTest', 'idGroupSession')
                                                ->with(['adm_aca_test' => function($query){
                                                        $query->select('id', 'idTypeTest', 'idCourse', 'name')
                                                        ->with(['adm_aca_questions' => function($query){
                                                            $query->select('id', 'idSection', 'idTest', 'name', 'mainQuestion')
                                                                    ->with(['adm_c_section_question' => function($query){
                                                                    $query->select('id', 'name', 'description')->get();
                                                                    }])
                                                                    ->with(['adm_aca_options' => function($query){
                                                                        $query->select('id', 'idQuestion', 'name', 'clause', 'isCorrect');
                                                                    }]);
                                                        }]);                                                   
                                            }])->where('idGroupSession', $idGroupSession)->where('idTest', 1)->first();


        $oSatisfactionTest = SatisfactionTestMapper::fnMatchDataToResponse($oSatisfactionTest);

        return $oSatisfactionTest;
    }

    
    public static function fnGetDistinctSections()
    {
        $oSections = AdmCSectionQuestion::select('id', 'name', 'description')->where('idStatus', 1)->get();
        return $oSections;
    }

    public static function fnGetIdUserCourse($idUser, $idCourse)
    {
        $idUserCourse = AcaUserCourse::select('id')->where('idUser', $idUser)->where('idCourse', $idCourse)->first();

        return $idUserCourse->id;
    }

    public static function fnGetIdGroupByUser($idUserCourse)
    {
        $idGroupSession = AcaUserCourseGroupSession::select('idGroupSession')->where('idUserCourse', $idUserCourse)->first();
        $idGroup = AdmAcaGroupSession::Select('idGroup')->where('idGroup', $idGroupSession->idGroupSession)->first();
        return $idGroup->idGroup;
    }

    public static function fnGetIdUserCourseTest($idUserCourse)
    {
        $idUserCourseTest = AcaUserCourseTest::select('id')->where('idUserCourse', $idUserCourse)->where('idTest', 2)->first(); 
        return $idUserCourseTest->id;
    }

    public static function fnGetIdSessionIdGroupSession($idGroupSession)
    {
        $idSession = AdmAcaGroupSession::select('idSession')->where('id', $idGroupSession)->first();
        
        return $idSession; 
    } 

    
    public static function fnGetIdGroupIdGroupSession($idGroupSession)
    {
        $idGroup = AdmAcaGroupSession::select('idGroup')->where('id', $idGroupSession)->first();
        
        return $idGroup; 
    } 

    public static function fnGetSessionsFinished($idUserCourse){
        $SessionFinished = AcaUserCourseGroupSession::where('idUserCourse', $idUserCourse)->count();

         return $SessionFinished;
    }

    public static function fnGetSessionsTotal($idCourse)
    {
        $totalSessions = AdmAcaCourse::select('totalSessions')->where('id', $idCourse)->first();
        
        return $totalSessions;
    }

    
    public static function fnSaveSatisfactionTest($oSatisfactionTestRequest, $idUser, $token)
    {
        
        DB::beginTransaction();
        try
        {
            $idUserCourse = SatisfactionTestQuery::fnGetIdUserCourse($idUser, $oSatisfactionTestRequest->idCourse);       
            $idGroup = SatisfactionTestQuery::fnGetIdGroupByUser($idUserCourse);    
            $oAcaUserCourseTest = AcaUserCourseTestMapper::fnMatchDataFromRequest($idUserCourse, $oSatisfactionTestRequest->idGroupSession, 2);
            $oResponseAcaUserCourseTest = AcaUserCourseTestRepository::fnSave($oAcaUserCourseTest);
            $idUserCourseTest = SatisfactionTestQuery::fnGetIdUserCourseTest($idUserCourse);
            
            foreach($oSatisfactionTestRequest->lstAnswers as $answerToSave)
            {
                $oAcaUserCourseTestAnswer = AcaUserCourseTestAnswerMapper::fnMatchDataFromRequest($answerToSave, $idUserCourseTest);
                $oResponseAcaUserCourseTestAnswer = AcaUserCourseTestAnswerRepository::fnSave($oAcaUserCourseTestAnswer);  
            }
            
            $oAssistance = SatisfactionTestQuery::fnSaveCourseAssistance($oSatisfactionTestRequest, $idUserCourse);
            $totalSessions = SatisfactionTestQuery::fnGetSessionsTotal($oSatisfactionTestRequest->idCourse);
            $SessionsFinished = SatisfactionTestQuery::fnGetSessionsFinished($idUserCourse);
            $porcent = (($SessionsFinished * 100) / $totalSessions->totalSessions);
            
            DB::commit();
            if($porcent >= 80)
                $oFile = FileServices::BuildConstancy($token, $idUserCourse);
            
        }
        catch(Exception $err)
        {
            DB::rollback();
            return false;
        }

        return true;
    
    }

    public static function fnGetDataAcaUserCourseGroupSession($idUserCourse){   
        $lstModels = AcaUserCourseGroupSession::where('idUserCourse', $idUserCourse)->where('actual', 1)->get();
         return $lstModels;
    }
    
    public static function fnSaveCourseAssistance($oSatisfactionTestRequest, $idUserCourse)
     {
         try
         {
            $oAcaUserGS = AcaUserCourseGroupSessionMapper::fnMatchDataToSave($oSatisfactionTestRequest, $idUserCourse);
            $lstModels = SatisfactionTestQuery::fnGetDataAcaUserCourseGroupSession($idUserCourse);

            foreach($lstModels as $model)
            {
                $model->actual = 0;
                $oResponse = AcaUserCourseGroupSessionRepository::fnSave($model);
            }
            $oResponse = AcaUserCourseGroupSessionRepository::fnSave($oAcaUserGS);
        }
        catch(Exception $err)
        {
            return false;
        }
        return true;
    }
    
}