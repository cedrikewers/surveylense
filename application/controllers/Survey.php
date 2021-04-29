<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Survey extends CI_Controller {

	function __construct(){
        parent::__construct(); 
        $this->load->model('Survey_model');
        }

	public function index()
	{
		
	}
	public function loadSurvey($randomId = null)
	{
		$surveyTemp = $this->Survey_model->checkRandomId($randomId);
		if($surveyTemp){
			$survey = array('randomId' => $randomId);
			$survey['name'] = $surveyTemp['name'];
			$survey['description'] = $surveyTemp['description'];

			$data = array();

			$this->load->library('Template');
			$this->template->set('title', $surveyTemp['name']);

			$questions = $this->Survey_model->getQuestions($surveyTemp['id']);
			foreach($questions as $row){
				$data['q'.$row['number']] = $row['data'];
				$data[$row['number']."_type"] = $row['type'];
				
			}
			$answers = $this->Survey_model->getAnswers($surveyTemp['id']);
			foreach($answers as $row){
				$data[$row['dataNumber']."_".$row['number']] = $row['data'];
			}
			
			$survey['data'] = $data;
			$this->template->load('templates/homepageTemplate','survey/surveyView', $survey);
		}
		else{
			$this->load->library('Template');
			$this->template->set('title', 'This survey does not exist');
			$this->template->load('templates/homepageTemplate','survey/surveyDoesNotExist');	
		}
		
		
	}

	public function storeAnswers()
	{
		$id = $this->Survey_model->getSurveyTempId($_POST['randomId']);
		$randomId = $_POST['randomId'];
		unset($_POST['randomId']);
		$surveyId = $this->Survey_model->storeSurvey($id);
		foreach($_POST as $key => $value){
			$this->Survey_model->storeAnswers($id, $surveyId, str_replace(strstr($key, "_"), "", $key), $value);
		}
		for($i = 0; $i < 5; $i++){//failsafe
			$viewdata['randSurvey'] =  $this->Survey_model->getRandomSurvey();
			if($viewdata['randSurvey'] != $randomId){break;}
		}
		$this->load->library('Template');
		$this->template->set('title', 'Your anwers got submitted');
		$this->template->load('templates/homepageTemplate','survey/surveyCompleted', $viewdata);	
	}
}