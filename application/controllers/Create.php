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

    public function test(){
        $this->Create_model->surveyTemp("12s3s5", "test", 145); 
    }

    
        //$surveyTempId = $this->Create_model->surveyTemp($randomId, "test1234", $_SESSION['id_user']); 
        /* Die gerade gennerierte, einzigartige Id wird nun zusammen mit dem Namen der Umfrage, die aus den Formulardaten
        übernommen wird, und der Id des Users, die aus dem Session-Cookie gelesen wurde, in die Datenbank eingefügt. 
        Die interne numerische ID wird für weitere zwecke gespeichert.*/

        /*
        $questions = array( );
        $answers = array();
        foreach ($_POST as $key => $iteam){
            if(substr($key, 0, 1)=="q"){
                $questions[str_replace("q", "", $key)] = $iteam;    // im $questions Array werden die ids der Fragen mit dem Key ihrer Nummer gespeichert.

            }
            else{
                if($key != "name"){
                    
                }
            }
        }
        */
        /*
        foreach ($_POST as $key => $iteam){
            if(substr($key, 0, 1)=="a"){
                $answers[strstr(str_replace("a", "", $key), ".", true)][str_replace(".", "", strstr($key, "."))] = $iteam; //im $answers Array werden die Antworten mit ihrer Nummer und er NUmmer der Frage gespeuichert.
            }
        }
        */
        /*
        $questionId = array();
        foreach($questions as $number => $text){
            $questionId[$number] = $this->Create_model->surveyTempData($surveyTempId, $number, "text", $text);
        }
        */
        /*
        foreach($answers as $question => $answerList){
            foreach($answerList as $number => $content){
                $this->Create_model->surveyTempDataAnswers($questionId[0], $number, "text", "test1");
            }
        }
        */
    }

