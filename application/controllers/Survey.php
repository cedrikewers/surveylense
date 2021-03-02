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
		$survey = $this->Survey_model->checkRandomId($randomId);
		if(isset($survey)){
			$this->load->library('Template');
			$this->template->set('title', $survey['name']);
			$survey['randomId'] = $randomId;
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
		$data = $_POST;
		unset($data['randomId']);
		$this->Survey_model->storeAnswers($_POST['randomId'], time(), serialize($data));
		redirect();
	}
}