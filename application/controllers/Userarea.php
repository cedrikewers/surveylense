<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Userarea extends CI_Controller {

    function __construct(){
        parent::__construct(); 
        $this->load->model('User_model');
        }


	public function index($page = 'dashboardView')
	{
		if ( ! file_exists(APPPATH.'views/userarea/'.$page.'.php'))
        {
        // Whoops, we don't have a page for that!
        show_404();
        }
        else{
            $this->load->library('template');
            $this->template->set('title', ucfirst(substr($page, 0, -4)));
            $this->template->load('templates/userareaTemplate','userarea/'.$page);
        }
        
	}

    public function manage()
	{
            $this->load->library('template');
            $this->template->set('title', 'Create a new Survey');
            $this->template->load('templates/userareaTemplate','userarea/manageView.php');
	}

    public function result()
	{
            $this->load->library('template');
            $this->template->set('title', 'Create a new Survey');
            $this->template->load('templates/userareaTemplate','userarea/resultView.php');
	}
    public function create(){
        $this->load->library('template');
        $this->template->set('title', 'Create Survey');
        $this->template->load('templates/userareaTemplate','userarea/createView');
    }

    public function storeSurvey(){ 
        do{
            $randomId = substr(hash("md5", random_bytes(20)), 0, 6);
        }
        while($this->User_model->randomIdExists($randomId));
        // Hier wurde eine zufällige Id generiert und mit der Datenbank abgeglichen, damit diese sich nicht doppelt.
        $data = $_POST;
        unset($data["name"]);
        $this->User_model->surveyTemp($randomId, $_POST['name'], $_SESSION['id_user'], serialize($data)); 
        redirect('/userarea/surveyCreated/'.$randomId);
        
    }

    public function surveyCreated($randomId){
        $this->session->set_flashdata('randomId', $randomId);
        $this->load->library('template');
        $this->template->set('title', 'Survey created successfully');
        $this->template->load('templates/userareaTemplate','userarea/surveyCreated');
    }
}

