<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Userarea extends CI_Controller {

    function __construct(){
        parent::__construct(); 
        $this->load->model('User_model');
        $this->load->model('Result_model');
        $session = $this->session->userdata('id_user');
        if(empty($session)){
            redirect('/login');
        }
    }


	public function index()
	{

        $mostRecentSurvey = $this->User_model->getMostRecentSurvey();
        $mostTrafficSurvey = $this->User_model->getMostTrafficSurvey($mostRecentSurvey['randomId']);

        $viewdata['mostRecentSurvey'] = $mostRecentSurvey;
        $viewdata['mostRecentSurvey']['result'] = $this->Result_model->resultsData($mostRecentSurvey['randomId']);
        $viewdata['mostTrafficSurvey'] =  $mostTrafficSurvey;
        
        foreach($viewdata['mostTrafficSurvey'] as $number => $survey){
            $viewdata['mostTrafficSurvey'][$number]['result'] = $this->Result_model->resultsData($survey['randomId']);
        }

        $this->load->library('template');
        $this->template->set('title', 'Dashboard');
        $this->template->load('templates/homepageTemplate','userarea/dashboardView', $viewdata);   
	}

    public function profile(){
        $result = $this->User_model->getUserData($_SESSION['id_user']);
        if($_POST){
            # username and email changed
            if($_POST['username'] != $result->username && $_POST['email'] != $result->email){
                $emaildata = array(
                    'id_user' => $_SESSION['id_user'],
                    'email' => $_POST['email']
                    );
                $this->User_model->update_email($emaildata);
                $username = $this->User_model->check_username($_POST['username']);
                if(empty($username)){
                    $data = array(
                        'id_user' => $_SESSION['id_user'],
                        'username' => $_POST['username']
                        );
                    $this->User_model->update_username($data);
                    $result = $this->User_model->getUserData($_SESSION['id_user']);
                    $userdata = array(
                        'id_user' => $_SESSION['id_user'],
                        'username' => $result->username

                        );

                    $this->session->set_userdata($userdata);
                    $this->session->set_flashdata('userProfileMessage', 'Email and Username changed');
                }
                else{
                    $this->session->set_flashdata('userProfileMessage', 'Username is not available');
                }
            }
            # username changed
            elseif($_POST['username'] != $result->username){
                $username = $this->User_model->check_username($_POST['username']);
                if(empty($username)){
                    $data = array(
                        'id_user' => $_SESSION['id_user'],
                        'username' => $_POST['username']
                        );
                    $this->User_model->update_username($data);
                    $result = $this->User_model->getUserData($_SESSION['id_user']);
                    $userdata = array(
                        'id_user' => $_SESSION['id_user'],
                        'username' => $result->username

                        );

                    $this->session->set_userdata($userdata);
                    $this->session->set_flashdata('userProfileMessage', 'Username changed');
                }
                else{
                    $this->session->set_flashdata('userProfileMessage', 'Username is not available');
                }
            }
            # password changed
            elseif($_POST['oldPassword'] != null && $_POST['newPassword'] != null && $_POST['newPasswordRetype'] != null){
                $oldpassword = $this->User_model->check_password($_SESSION['id_user']);
                if($oldpassword->password == md5($_POST['oldPassword'])){
                    if($_POST['newPassword'] == $_POST['newPasswordRetype']){
                        $data = array(
                            'id_user' => $_SESSION['id_user'],
                            'password' => $_POST['newPassword']
                            );
                        $this->User_model->update_password($data);
                        $this->session->set_flashdata('userProfileMessage', 'password changed');
                    }
                    else{
                        $this->session->set_flashdata('userProfileMessage', 'new passwords do not match');
                    }
                }
                else{
                    $this->session->set_flashdata('userProfileMessage', 'old password is wrong');
                }
            }

            # email changed
            elseif($_POST['email'] != $result->email){
                $data = array(
                    'id_user' => $_SESSION['id_user'],
                    'email' => $_POST['email']
                    );
                $this->User_model->update_email($data);
                $this->session->set_flashdata('userProfileMessage', 'Email changed');
                redirect('/userarea/profile');
            }
            else{
                $this->session->set_flashdata('userProfileMessage', 'You have not changed anything or you have not filled every necessary field');
            }
        }
        $this->session->set_flashdata('email', $result->email);
        $this->load->library('template');
        $this->template->set('title', 'Profile');
        $this->template->load('templates/homepageTemplate','userarea/profileView');
        if($_POST){

        }
    }

    public function create(){
        $this->load->library('template');
        $this->template->set('title', 'Create Survey');
        if($_POST){
            $this->template->load('templates/homepageTemplate','userarea/createView', $_POST);
        }
        $this->template->load('templates/homepageTemplate','userarea/createView');
    }

    public function surveyCreated($randomId){
        $this->session->set_flashdata('randomId', $randomId);
        $this->load->library('template');
        $this->template->set('title', 'Survey created successfully');
        $this->template->load('templates/homepageTemplate','userarea/surveyCreated');
    }

    public function surveyUpdated($randomId){
        $this->session->set_flashdata('randomId', $randomId);
        $this->load->library('template');
        $this->template->set('title', 'Survey created successfully');
        $this->template->load('templates/homepageTemplate','userarea/surveyUpdated');
    }

    public function storeSurveyNew(){ 
        do{
            $randomId = substr(hash("md5", random_bytes(20)), 0, 6);
        }
        while($this->User_model->randomIdExists($randomId));
        // Hier wurde eine zufällige Id generiert und mit der Datenbank abgeglichen, damit diese sich nicht doppelt.
        $id = $this->User_model->surveyTemp($randomId, $_POST['name'], $_POST['description'], $_SESSION['id_user']);
        $data = $_POST;
        unset($data["name"]);
        $questionCount = 0;
        $dataId = 0;
        foreach($data as $key => $value){
            if(strpos($key, "q")===0){
                $questionCount++;
                $dataId = $this->User_model->surveyTempData($id, $questionCount, $value); 
            }
            elseif(strpos($key, "_")!==false){
                $this->User_model->surveyTempDataAnswers($dataId, str_replace(strstr($key, "_", true)."_", "", $key), $value);
            }
        } 
        redirect('/userarea/surveyCreated/'.$randomId);
        
    }

    public function storeSurvey(){//despite the name, this version is newer
        do{
            $randomId = substr(hash("md5", random_bytes(20)), 0, 6);
        }
        while($this->User_model->randomIdExists($randomId));
        //This generated a randomId and checked, that it is unique
        $id = $this->User_model->surveyTemp($randomId, $_POST['name'], $_POST['description'], $_SESSION['id_user'], $_POST['visibility']);
        $questions = array();
        foreach($_POST as $key => $value){
            if(strpos($key, "q")===0){
                $questions[str_replace("q", "", $key)] = $value;
            }
        }
        foreach($questions as $key => $value){
            $dataId = $this->User_model->surveyTempData($id, $key, $_POST[$key."_type"], $value);
            switch($_POST[$key."_type"]){
                case 0:
                case 1://It is a question with the "single choice" or "multible choice" answer type
                    $i = 1;
                    while(array_key_exists($key."_".$i, $_POST)){
                        $this->User_model->surveyTempDataAnswers($dataId, $i, $_POST[$key."_".$i]);
                        $i++;
                    }
                    if(array_key_exists($key."_others", $_POST)){
                        $this->User_model->surveyTempDataAnswers($dataId, 0, "others");
                    }
                    break;
                case 2://It is a question with the "scale" answer type
                    $this->User_model->surveyTempDataAnswers($dataId, $_POST[$key."_lower"], $_POST[$key."_labelLower"]);
                    $this->User_model->surveyTempDataAnswers($dataId, $_POST[$key."_higher"], $_POST[$key."_labelHigher"]);
                    break;
            }
        }
        redirect('/userarea/surveyCreated/'.$randomId);
    }

    public function manage()
    {
        $surveyTemp = $this->User_model->getSurveyTempByUser($_SESSION['id_user']); 
        $this->load->library('template');
        $this->template->set('title', 'Manage your Surveys');
        $this->template->load('templates/homepageTemplate','userarea/manageView.php', array('surveyTemp' => $surveyTemp));
    }

    public function editSurvey($randomId){
        $this->load->model('Result_model');
        $surveyTemp = $this->User_model->getEditTemp($randomId);
        if($surveyTemp){
            if($this->Result_model->checkUser($randomId)){
                $this->load->library('template');
                $this->template->set('title', 'Manage your Surveys');
                $this->template->load('templates/homepageTemplate','userarea/editView.php', array('surveyTemp' => $surveyTemp));
            }
            else{
                $this->load->library('Template');
                $this->template->set('title', 'You dont have the rights to accses this survey');
                $this->template->load('templates/homepageTemplate','survey/noRightsToDownloadSurvey');
            }
        }
        else{
            $this->load->library('Template');
            $this->template->set('title', 'This survey does not exist');
            $this->template->load('templates/homepageTemplate','survey/surveyDoesNotExist');
        }
    }

    public function updateSurvey()
    {
        if($this->Result_model->checkUser($_POST['randomId'])){
            $id = $this->User_model->updateSurveyTemp($_POST['randomId'], $_POST['name'], $_POST['description'], $_POST['visibility']);
            $questions = array();
            $newQuestions = array();
            foreach($_POST as $key => $value){
                if(strpos($key, "q")===0){
                    $questions[str_replace("q", "", $key)] = $value;
                }
            }
            foreach($questions as $key => $value){
                $dataId = $this->User_model->updateSurveyTempData($id, $key, $value);
                if($dataId == null){
                    $dataId = $this->User_model->surveyTempData($id, $key, $_POST[$key."_type"], $value);
                }
                $this->User_model->clearAnswers($dataId);
                switch($_POST[$key."_type"]){
                    case 0:
                    case 1://It is a question with the "single choice" or "multible choice" answer type
                        $i = 1;
                        while(array_key_exists($key."_".$i, $_POST)){
                            $this->User_model->surveyTempDataAnswers($dataId, $i, $_POST[$key."_".$i]);
                            $i++;
                        }
                        if(array_key_exists($key."_others", $_POST)){
                            $this->User_model->surveyTempDataAnswers($dataId, 0, "others");
                        }
                        break;
                    case 2://It is a question with the "scale" answer type
                        $this->User_model->surveyTempDataAnswers($dataId, $_POST[$key."_lower"], $_POST[$key."_labelLower"]);
                        $this->User_model->surveyTempDataAnswers($dataId, $_POST[$key."_higher"], $_POST[$key."_labelHigher"]);
                        break;
                }
            }
            redirect('/userarea/surveyUpdated/'.$_POST['randomId']);
        }
        else{
            $this->load->library('Template');
            $this->template->set('title', 'You dont have the rights to accses this survey');
            $this->template->load('templates/homepageTemplate','survey/noRightsToDownloadSurvey');
        }
    }

    public function manageQuestions()
    {
        if($this->Result_model->checkUser($_POST['randomId'])){
            $this->User_model->updateQuestionOrder($_POST['order'], $_POST['randomId']);
        }
        
    }

    public function deleteQuestionModal()
    {
        if($this->Result_model->checkUser($_POST['randomId'])){
            $this->User_model->deleteQuestionModal($_POST['number'], $_POST['randomId']);
        }
        
    }


}