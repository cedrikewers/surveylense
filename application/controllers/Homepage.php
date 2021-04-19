<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Homepage extends CI_Controller {
    function __construct(){
        parent::__construct();
        $this->load->model('Homepage_model');
    }

	public function index($page = 'homepageView')
	{
		if ( ! file_exists(APPPATH.'views/homepage/'.$page.'.php'))
        {
        // Whoops, we don't have a page for that!
        show_404();
        }
        else{
            $data['content'] = $this->Homepage_model->get_last_surveys();
            $this->load->library('template');
            $this->template->set('title', ucfirst(substr($page, 0, -4)));
            $this->template->load('templates/homepageTemplate','homepage/'.$page, $data);
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
}