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

    public function storeSurvey(){
        $x = true;
        $randomId ="";
        while($x){
            $randomId = substr(uniqid(), 0, 6);
            if($this->Create_model->check_randomId($randomId)==false){
                $x = false;
            }
        }// Hier wurde eine zufällige Id generiert und mit der Datenbank abgeglichen, damit diese sich nicht doppelt.
        $surveyTempId = $this->Create_model->surveyTemp($randomId, $_POST['name'], $_SESSION['id_user']); 
        /* Die gerade gennerierte, einzigartige Id wird nun zusammen mit dem Namen der Umfrage, die aus den Formulardaten
        übernommen wird, und der Id des Users, die aus dem Session-Cookie gelesen wurde, in die Datenbank eingefügt. 
        Die interne numerische ID wird für weitere zwecke gespeichert.*/
        $questions = array( );
        foreach ($_POST as $key => $iteam){
            if(strpos($key, "q")==0){
                $questions[str_replace("q", "", $key)] = $iteam;    // im $questions Array werden die ids der Fragen mit dem Key ihrer Nummer gespeichert.

            }
        }
        $answers = array();
        foreach ($_POST as $key => $iteam){
            if(strpos($key, "a")==0){
                $answers[strstr(str_replace("a", "", $key), ".", true)][str_replace(".", "", strstr($key, "."))] = $iteam; //im $answers Array werden die Antworten mit ihrer Nummer und er NUmmer der Frage gespeuichert.
            }
        }
        $questionId = array();
        foreach($questions as $number => $text){
            $questionId[$number] = $this->create_model->surveyTempData($surveyTempId, $number, "text", $text);
        }
        foreach($answers as $question => $answerList){
            foreach($answerList as $number => $content){
                $this->create_model->surveyTempDataAnswers($questionId[$question], $number, "text, $content");
            }
        }
    }

}