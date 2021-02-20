<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Create extends CI_Controller {

    function __construct(){
        parent::__construct(); 
        $this->load->model('Create_model');
        }

	public function index()
	{
            $this->load->library('template');
            $this->template->set('title', 'Create a new Survey');
            $this->template->load('templates/homepageTemplate','create/createView.php');
	}

    public function surveyTemp(){//funtioniert nicht
        $x = true;
        $randomId ="";
        while($x){
            $randomId = substr(uniqid(), 0, 6);
            if($this->Create_model->check_randomId($randomId)==false){
                $x = false;
            }
        }
        $name = $_POST['name'];
        //$user = $_SESSION['id_user'];
        $this->Create_model->surveyTemp($randomId, $name);
    }
}