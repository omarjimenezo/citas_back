<?php

namespace App\Business\Academia\Mappers;

use App\Http\Responses\Academia\SatisfactionTest\SatisfactionTestResponse;
use App\Http\Responses\Academia\SatisfactionTest\QuestionsModel;
use App\Http\Responses\Academia\SatisfactionTest\AnswersModel;
use App\Http\Responses\Academia\SatisfactionTest\SectionsModel;
use App\Business\Academia\Queries\SatisfactionTestQuery;




class SatisfactionTestMapper
{
    public static function fnMatchDataToResponse($oModel)
    {
        $oSatisfactionTestResponse = new SatisfactionTestResponse();
        
        //Se agrega el encabezado del json
        $oSatisfactionTestResponse->id = $oModel->adm_aca_test->id;
        $oSatisfactionTestResponse->idCourse = $oModel->adm_aca_test->idTypeTest;
        $oSatisfactionTestResponse->nameTest = $oModel->adm_aca_test->name;
        $oSatisfactionTestResponse->idGroupSession = $oModel->idGroupSession; 
      //$oSatisfactionTestResponse->idSession = SatisfactionTestQuery::fnGetIdSessionIdGroupSession($oModel->idGroupSession); 
        //$oSatisfactionTestResponse->idGroup = SatisfactionTestQuery::fnGetIdGroupIdGroupSession($oModel->idGroupSession);


        //Se crean las dos sublistas que pueden o no llenarse
        $lstQuestions = Collect();
        $lstSubQuestions = Collect();

        //Se recorre el modelo para llenar el json de respuestas sin considerar si tienen o no mainQuestion
        foreach($oModel->adm_aca_test->adm_aca_questions as $model)
        {
            $oQuestionsModel = new QuestionsModel();
            $oQuestionsModel->id = $model->id;
            $oQuestionsModel->nameQuestion = $model->name;
            $oQuestionsModel->mainQuestion = $model->mainQuestion;
            if($model->adm_c_section_question != null)
            {
                $oSectionsModel = new SectionsModel();
                $oSectionsModel->idSection = $model->adm_c_section_question->id;
                $oSectionsModel->nameSectiown = $model->adm_c_section_question->name;
                $oSectionsModel->descriptionSection = $model->adm_c_section_question->description;
                $oQuestionsModel->idSection = $model->adm_c_section_question->id;
            }
            $lstAnswers = Collect();
            foreach($model->adm_aca_options as $answer)
            {
                $oAnswersModel = new AnswersModel();
                $oAnswersModel->id = $answer->id;
                $oAnswersModel->idQuestion = $answer->idQuestion;
                $oAnswersModel->name = $answer->name;
                $oAnswersModel->clause = $answer->clause;
                $oAnswersModel->isCorrect = $answer->isCorrect;
                $lstAnswers->push($oAnswersModel);
            }
            
            //Se agrega la lista de respuestas a la pregunta correspondiente
            $oQuestionsModel->lstAnswers = $lstAnswers;

            //Saber si se va a agregar a la lista principal porque es una 
            //pregunta principal o a la lista de sub preguntas que despues 
            ///se agregara a una lista de la pregunta principal
            if($model->mainQuestion != null && $model->mainQuestion > 0)
                $lstSubQuestions->push($oQuestionsModel);
            else
                $lstQuestions->push($oQuestionsModel);
        }

        //Se recorre la sublista creada con anterioridad con las preguntas que tienen una mainQuestion
        foreach($lstSubQuestions as $subQuestion)
        { 
            $idQuestion = $subQuestion->mainQuestion;
            $QuestionUp = $lstQuestions->firstWhere('id', '=', $idQuestion);
            
            $lstSubquestionByQ = Collect();
            if(!empty($QuestionUp->lstSubQuestions))
            {
                //se obtiene la lista de subpreguntas de la lista principal ya creada antes de agregar la nueva subpregunta.
                foreach($QuestionUp->lstSubQuestions as $subQ)
                {
                    $lstSubquestionByQ->push($subQ);
                }
            }
            
            //se agrega la subpregunta ala lista y posteriormente se agrega a la pregunta
            $lstSubquestionByQ->push($subQuestion);
            $QuestionUp->lstSubQuestions = $lstSubquestionByQ;
           /* $filtered = $lstQuestions->filter(function($value, $key) use($idQuestion){
                return $value->id != $idQuestion;
            });
            */
            $filtered = SatisfactionTestMapper::filterlst($lstQuestions, $idQuestion);

            //se elimina de la lista de preguntas la pregunta que se edito con las subpreguntas
            $lstQuestions = null;
            $lstQuestions = $filtered;
            $lstQuestions->push($QuestionUp);
        }

        $lstSections = SatisfactionTestQuery::fnGetDistinctSections();
        $lstSections = SatisfactionTestMapper::fnMatchDataSections($lstSections);
        $lstSections = SatisfactionTestMapper::fnBuildQuestionToSections($lstSections, $lstQuestions);
        $oSatisfactionTestResponse->lstSections = $lstSections;

        return $oSatisfactionTestResponse;
    }

    public static function fnMatchDataSections($lstSections)
    {
        $lstSectionsNew = Collect();
        foreach($lstSections as $section)
        {
            $oSection = new SectionsModel();
            $oSection->idSection = $section->id;
            $oSection->nameSection = $section->name;
            $oSection->descriptionSection = $section->description;

            $lstSectionsNew->push($oSection);
        }

        return $lstSectionsNew;
    } 

    public static function filterlst($lstQuestions, $idQuestion)
    {
        $lstQuestionsNew = Collect();
        foreach($lstQuestions as $question)
        {
            if($question->id != $idQuestion)
                $lstQuestionsNew->push($question);
        }

        return $lstQuestionsNew;
    }

    public static function fnBuildQuestionToSections($lstSections, $lstQuestions)
    {
        $lstSectionNew = Collect();

        foreach($lstSections as $section)
        {
            $lstQuestionsNew = Collect();
            foreach($lstQuestions as $question)
            {
                if($question->idSection == $section->idSection)
                    $lstQuestionsNew->push($question);
            }
            $section->lstQuestions = $lstQuestionsNew;
            $lstSectionNew->push($section);
        }

        return $lstSectionNew;
    }
}