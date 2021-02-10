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
            $this->template->set('title', ucfirst($page));
            $this->template->load('templates/homepageTemplate','homepage/'.$page);
        }
	}
}