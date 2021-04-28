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
                        }
                        else{
                            $tempAnswer .= $aRow['data'];
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
                return 2;
            }
        }
        else{
            return 1;
        }
   }

    public function downloadXLSX($randomId){
        $results = $this->generateResultsXLSX($randomId);    
            if($results == 2){
                $this->load->library('Template');
                $this->template->set('title', 'You dont have the rights to accses this survey');
                $this->template->load('templates/homepageTemplate','survey/noRightsToDownloadSurvey');
            }  
            if($results == 1){
                $this->load->library('Template');
                $this->template->set('title', 'This survey does not exist');
                $this->template->load('templates/homepageTemplate','survey/surveyDoesNotExist');
            }   
            if($results != 2 && $results != 1){
                $results->downloadAs('Results.xlsx');
            }
    }

    public function mail($randomId){
        $this->session->set_flashdata('result', 'Please choose at least one option.');
        if(isset($_POST)){
            $title = $this->Survey_model->checkRandomId($randomId)['name'];

            $results = $this->generateResultsXLSX($randomId);    
            if($results == 2){
                $this->load->library('Template');
                $this->template->set('title', 'You dont have the rights to accses this survey');
                $this->template->load('templates/homepageTemplate','survey/noRightsToDownloadSurvey');
            }  
            if($results == 1){
                $this->load->library('Template');
                $this->template->set('title', 'This survey does not exist');
                $this->template->load('templates/homepageTemplate','survey/surveyDoesNotExist');
            }   
            if($results != 2 && $results != 1){
                $results->saveAs('./assets/temp/'.$title.'_Results.xlsx');;
            }

            if($_POST['email'] != null){
                $this->Email_model->mailTo(array($_POST['email']), 'Your Results', 'Here are your Results. Have fun.',  './assets/temp/'.$title.'_Results.xlsx');
                $this->session->set_flashdata('result', 'Email(s) have been send.');
            }
            if($_POST['self'] == 'self'){
                $this->Email_model->mailTo(array($this->Result_model->getEmail()), 'Your Results', 'Here are your Results. Have fun.',  './assets/temp/'.$title.'_Results.xlsx');
                $this->session->set_flashdata('result', 'Email(s) have been send.');
            } 
            unlink('./assets/temp/'.$title.'_Results.xlsx'); 
        }       
        redirect('/results/results/'.$randomId.'#mail');
        
    }

    public function results($randomId){
        $surveyTemp = $this->Survey_model->checkRandomId($randomId);//name, description, id FROM surveyTemp
        if($surveyTemp){
            if($this->Result_model->checkUser($randomId)){
                $viewData = array();
                $questions = $this->Survey_model->getQuestions($surveyTemp['id']);//number, data, type, id FROM surveyTempData
                $result = array();
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
                    if($question['type'] < 2){

                        $othersData = array();
                        $others = 0;
                        $limit = count($questionTemp['dataset']);
                        $j = 0;

                        while($j < $limit){
                            if(isset($questionTemp['dataset'][$j])){
                                if(array_key_exists($questionTemp['dataset'][$j]['data'], $posibleAnswers)){
                                    $key = $posibleAnswers[$questionTemp['dataset'][$j]['data']];
                                    $questionTemp['dataset'][$j]['data'] = substr($key, 0, 10);
                                    if($questionTemp['dataset'][$j]['data'] != $key){
                                        $questionTemp['dataset'][$j]['data'] .= '...';
                                    }
                                }
                                else{
                                    $othersData[$questionTemp['dataset'][$j]['data']] =  $questionTemp['dataset'][$j]['count'];
                                    $others += $questionTemp['dataset'][$j]['count'];
                                    unset($questionTemp['dataset'][$j]);
                                    $limit++;
                                }                           
                            }
                            $j++;
                        }
                        if($others > 0){
                            array_push($questionTemp['dataset'], array('data' => 'Others', 'count' => $others));
                            arsort($othersData);
                            $questionTemp['othersData'] = $othersData;
                        }   
                        $questionTemp['entryCount'] = $this->Result_model->getEntryCount($surveyTemp['id']);
                    }
                    array_push($result, $questionTemp);
                }
                $viewData['result'] = $result;
                $viewData['title'] = $surveyTemp['name'];
                $viewData['randomId'] = $randomId;
                $this->load->library('Template');
                $this->template->set('title', $surveyTemp['name'].' - Results');
                $this->template->load('templates/homepageTemplate','result/resultView', $viewData);
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