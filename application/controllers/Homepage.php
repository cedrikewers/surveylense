<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Homepage extends CI_Controller {

    function __construct(){
        parent::__construct(); 
        $this->load->model('Result_model');
        $this->load->model('Survey_model');
    }

	public function index($page = 'homepageView')
	{
        $viewdata['publicSurveys'] = $this->Survey_model->getRandomPublic();
        $this->load->library('template');
        $this->template->set('title', ucfirst(substr($page, 0, -4)));
        $this->template->load('templates/homepageTemplate','homepage/'.$page, $viewdata);
	}

    public function create(){
        if(isset($_SESSION['id_user'])){
            redirect('create?title='.$_GET['title']);
        }
        else{
            redirect('login?redirect=create&title='.$_GET['title']);
        }
    }
}