<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Homepage extends CI_Controller {
    function __construct(){
        parent::__construct(); 
        $this->load->model('Result_model');
        $this->load->model('Survey_model');
	$this->load->model('Homepage_model');
    }

	public function index($page = 'homepageView')
	{
        $this->load->library('template');
        $this->template->set('title', ucfirst(substr($page, 0, -4)));
        if($page == 'homepageView'){
            $viewdata['publicSurveys'] = $this->Survey_model->getRandomPublic();
            $viewdata['content'] = $this->Homepage_model->get_last_surveys();
            $this->template->load('templates/homepageTemplate','homepage/'.$page, $viewdata);
        }
        else{
            $this->template->load('templates/homepageTemplate','homepage/'.$page);
        }
        
        
	}

    public function create(){
        if(isset($_SESSION['id_user'])){
            redirect('create?title='.$_GET['title']);
        }
        else{
            redirect('login?redirect=create&title='.$_GET['title']);
        }
    }

    public function contactMail()
    {
        $this->load->model("Email_model");
        $this->Email_model->mailTo(array('contact@surveylese.de'), $_POST['subject'], $_POST['message'].'\n \n Gesendet von '.$_POST['name'].' über das Konaktformular', null, $_POST['name'], $_POST['email']);
        $this->load->library('template');
        $this->template->set('title', 'Your email has been send');
        $this->template->load('templates/homepageTemplate','homepage/'.'emailHasBeenSend');
    }

}
