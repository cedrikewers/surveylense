<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Homepage extends CI_Controller {

	public function index($page = 'homepageView')
	{
		if ( ! file_exists(APPPATH.'views/homepage/'.$page.'.php'))
        {
        // Whoops, we don't have a page for that!
        show_404();
        }
        else{
            $this->load->library('template');
            $this->template->set('title', ucfirst(substr($page, 0, -4)));
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
}