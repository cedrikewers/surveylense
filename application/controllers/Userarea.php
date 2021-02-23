<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Userarea extends CI_Controller {

    function __construct(){
        parent::__construct(); 
        $this->load->model('Create_model');
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

    public function storeSurvey(){
        //$x = true;
        $randomId ="";
        //while($x){
            $randomId = substr(uniqid(), 0, 6);
            //if($this->Create_model->check_randomId($randomId)==false){
                //$x = false;
            //}
        //}// Hier wurde eine zufällige Id generiert und mit der Datenbank abgeglichen, damit diese sich nicht doppelt.
        $data = $_POST;
        unset($data["name"]);
        $this->Create_model->surveyTemp($randomId, $_POST['name'], $_SESSION['id_user'], serialize($data)); 
    }
}
?>
