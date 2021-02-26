<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Survey extends CI_Controller {

	function __construct(){
        parent::__construct(); 
        $this->load->model('Survey_Model');
        }

	public function index()
	{
		
	}

	public function loadSurvey($randomId = null)
	{
		$survey = $this->Survey_Model->checkRandomId($randomId);
		if(isset($survey)){
			$this->load->library('template');
			$this->template->set('title', $survey['name']);
			$this->template->load('templates/homepageTemplate','survey/surveyView', $survey);
		}
		else{
			$this->load->library('template');
			$this->template->set('title', 'This survey does not exist');
			$this->template->load('templates/homepageTemplate','survey/surveyDoesNotExist');	
		}
		
		
	}
}