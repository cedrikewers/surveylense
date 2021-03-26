<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Results extends CI_Controller {

	function __construct(){
        parent::__construct(); 
        $this->load->model('Result_model');
        $this->load->model('Survey_model');
        $this->load->model('Email_model');
        }

	public function index()
	{
		
	}

    public function generateResultsXLSX($randomId){
        //Hier werden die Spaltenüberschriften genneriert
        $surveyTemp = $this->Survey_model->checkRandomId($randomId);
        if($surveyTemp){
            if($this->Result_model->checkUser($randomId)){
                $this->load->library('SimpleXLSXGen'); #https://github.com/shuchkin/simplexlsxgen
                $print = array();

                $questions = $this->Survey_model->getQuestions($surveyTemp['id']);
                $temp = array();
                array_push($temp, '');
                foreach($questions as $row){
                    array_push($temp, $row['data']);
                }
                array_push($print, $temp);
                //Ende spaltenüberschriften

                //Hier werden die Antwortmöglichkeiten als Text ausgelesen
                $answers = $this->Survey_model->getAnswers($surveyTemp['id']);
                $posibleAnswers = array();
                foreach($answers as $row){
                    $posibleAnswers[$row['dataNumber']."_".$row['number']] = $row['data'];
                }

                $entry = $this->Result_model->getSurvey($randomId);
                $i = 0;
                foreach($entry as $row){
                    $i++;
                    $temp = array();
                    array_push($temp, $i);//Hier wird noch die Nummer des Datensatzes angegeben, gestartet mit 1.
                    $answers = $this->Result_model->getData($row['id']);
                    $tempAnswer = "";
                    $surveyTempDataId = 0;
                    foreach($answers as $aRow){
                        if($aRow['surveyTempDataId'] != $surveyTempDataId and $surveyTempDataId !== 0){
                            array_push($temp, $tempAnswer);
                            $tempAnswer = "";
                        }
                        if($tempAnswer != ""){
                            $tempAnswer .= ", ";
                        }
                        if(array_key_exists($aRow['data'], $posibleAnswers)){
                            $tempAnswer .= $posibleAnswers[$aRow['data']];
                            // array_push($temp, $posibleAnswers[$aRow['data']]);
                        }
                        else{
                            $tempAnswer .= $aRow['data'];
                            // array_push($temp, $aRow['data']);
                        }
                        $surveyTempDataId = $aRow['surveyTempDataId'];
                    }
                    array_push($temp, $tempAnswer);
                    $tempAnswer = "";
                    array_push($print, $temp);
                }
                return SimpleXLSXGen::fromArray($print);
            }
            else{
            $this->load->library('Template');
            $this->template->set('title', 'You dont have the rights to accses this survey');
            $this->template->load('templates/homepageTemplate','survey/noRightsToDownloadSurvey');
            }
        }
        else{
            $this->load->library('Template');
            $this->template->set('title', 'This survey does not exist');
            $this->template->load('templates/homepageTemplate','survey/surveyDoesNotExist');
        }
   }

    public function downloadXLSX($randomId){
        $this->generateResultsXLSX($randomId)->downloadAs('results.xlsx');          
        redirect();
    }

    public function mail($randomId){
            
        $this->generateResultsXLSX($randomId)->saveAs('./assets/temp/results.xlsx');
         $this->Email_model->mailTo(array($this->Result_model->getEmail()), 'Your Results', 'Here are your Results. Have fun.'.base_url('/assets/temp/results.xlsx'),  './assets/temp/results.xlsx');        
        redirect();            
    }

    public function results($randomId){
        $surveyTemp = $this->Survey_model->checkRandomId($randomId);//name, description, id FROM surveyTemp
        if($surveyTemp){
            $viewData = array();
            $questions = $this->Survey_model->getQuestions($surveyTemp['id']);//number, data, type, id FROM surveyTempData
            $result = array();
            $i = 1;
            foreach($questions as $question){
                $questionTemp = array();
                $questionTemp['name'] = $question['data'];
                $questionTemp['type'] = $question['type'];
                $questionTemp['dataset'] = $this->Result_model->getDataset($question['id'], $question['type']);//data, count FROM surveyAwnsers

                $answers = $this->Survey_model->getAnswers($surveyTemp['id']);
                $posibleAnswers = array();
                foreach($answers as $row){
                    $posibleAnswers[$row['dataNumber']."_".$row['number']] = $row['data'];
                }
                for($u = 0; $u < count($questionTemp['dataset']); $u++){
                    if(array_key_exists($questionTemp['dataset'][$u]['data'], $posibleAnswers)){
                        $questionTemp['dataset'][$u]['data'] = $posibleAnswers[$questionTemp['dataset'][$u]['data']];
                    }
                }
                array_push($result, $questionTemp);
                if($i > 2){
                    break;
                }
                $i++;
            }
            $viewData['result'] = $result;
            $this->load->library('Template');
            $this->template->set('title', $surveyTemp['name'].' - Results');
            $this->template->load('templates/homepageTemplate','result/resultView', $viewData);
        }
        else{
            $this->load->library('Template');
            $this->template->set('title', 'This survey does not exist');
            $this->template->load('templates/homepageTemplate','survey/surveyDoesNotExist');
        }
        
    }

       
}