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

    public function downloadXLSX($randomId){
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
                    foreach($answers as $aRow){
                        if(array_key_exists($aRow['data'], $posibleAnswers)){
                            array_push($temp, $posibleAnswers[$aRow['data']]);
                        }
                        else{
                            array_push($temp, $aRow['data']);
                        }
                    }
                    array_push($print, $temp);
                }
                $xlsx = SimpleXLSXGen::fromArray($print);
                $xlsx->downloadAs('results.xlsx');          
                redirect();
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

    public function mail($randomId){
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
                        foreach($answers as $aRow){
                            if(array_key_exists($aRow['data'], $posibleAnswers)){
                                array_push($temp, $posibleAnswers[$aRow['data']]);
                            }
                            else{
                                array_push($temp, $aRow['data']);
                            }
                        }
                        array_push($print, $temp);
                    }
                    $xlsx = SimpleXLSXGen::fromArray($print);
                    $xlsx->saveAs('./assets/temp/results.xlsx');
                    $this->Email_model->mailTo(array($this->Result_model->getEmail()), 'Your Results', 'Here are your Results. Have fun.', './assets/temp/results.xlsx');        
                    redirect();
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
}