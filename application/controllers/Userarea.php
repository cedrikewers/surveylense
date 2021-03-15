<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Userarea extends CI_Controller {

    function __construct(){
        parent::__construct(); 
        $this->load->model('User_model');
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

    public function profile(){
        $result = $this->User_model->getUserData($_SESSION['id_user']);
        if($_POST){
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
                        'id_user' => $result->id,
                        'username' => $result->User

                        );

                        $this->session->set_userdata($userdata);
                }
                else{
                    $this->session->set_flashdata('userProfileMessage', 'Username is not available');
                }
            }
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
                        'id_user' => $result->id,
                        'username' => $result->User

                        );

                        $this->session->set_userdata($userdata);
                }
                else{
                    $this->session->set_flashdata('userProfileMessage', 'Username is not available');
                }
            }

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

            elseif($_POST['email'] != $result->email){
                $data = array(
                    'id_user' => $_SESSION['id_user'],
                    'email' => $_POST['email']
                    );
                $this->User_model->update_email($data);
                redirect('/userarea/profile');
            }
            else{
                $this->session->set_flashdata('userProfileMessage', 'You have not changed anything or you have not filled every necessary field');
            }
        }
        $this->session->set_flashdata('email', $result->email);
        $this->load->library('template');
        $this->template->set('title', 'Profile');
        $this->template->load('templates/userareaTemplate','userarea/profileView');
        if($_POST){

        }
    }

    public function create(){
        $this->load->library('template');
        $this->template->set('title', 'Create Survey');
        if($_POST){
            $this->template->load('templates/userareaTemplate','userarea/createView', $_POST);
        }
        $this->template->load('templates/userareaTemplate','userarea/createView');
    }

    public function surveyCreated($randomId){
        $this->session->set_flashdata('randomId', $randomId);
        $this->load->library('template');
        $this->template->set('title', 'Survey created successfully');
        $this->template->load('templates/userareaTemplate','userarea/surveyCreated');
    }

    public function storeSurveyNew(){ 
        do{
            $randomId = substr(hash("md5", random_bytes(20)), 0, 6);
        }
        while($this->User_model->randomIdExists($randomId));
        // Hier wurde eine zufällige Id generiert und mit der Datenbank abgeglichen, damit diese sich nicht doppelt.
        $id = $this->User_model->surveyTemp($randomId, $_POST['name'], $_SESSION['id_user']);
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
}

