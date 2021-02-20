<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Create extends CI_Controller {

	public function index()
	{
            $this->load->library('template');
            $this->template->set('title', 'Create a new Survey');
            $this->template->load('templates/homepageTemplate','create/createView.php');
	}
}