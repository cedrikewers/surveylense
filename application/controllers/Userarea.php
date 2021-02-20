<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Userarea extends CI_Controller {

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
}
