<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

    function __construct(){
        parent::__construct();
        $this->load->model('Login_model');
        $this->load->model('Email_model');
    }

	public function index(){

        $page = "login";
        if($_POST){

            $result = $this->Login_model->check_user($_POST);
            print_r($result);
            if(!empty($result)){
                if($result->active == 1){
                    $data = array(
                        'id_user' => $result->id,
                        'username' => $result->username
                    );
    
                    $this->session->set_userdata($data);
                    redirect('/userarea');
                }
                else{
                    $this->session->set_flashdata('flash_data', 'Account not active');
                redirect('/login');
                }
            }
            else{
                $this->session->set_flashdata('flash_data', 'Username or Password wrong');
                redirect('/login');
            }
        }

        $this->load->library('template');
        $this->template->set('title', ucfirst($page));
        $this->template->load('templates/loginTemplate','login/'.$page);

    }

    public function register()
    {
        $page = "register";
        if($_POST){
            if($_POST['password'] != null && $_POST['password_repeat'] != null && $_POST['username'] != null && $_POST['email'] != null){
                if($_POST['password'] == $_POST['password_repeat']){
                    $result = $this->Login_model->check_username($_POST);
                    if(empty($result)){
                        $createUser = $this->Login_model->create_user($_POST);
                        $userData = $this->Login_model->getUserData($createUser);
                        do{
                            $randomId = substr(hash("md5", random_bytes(20)), 0, 10);
                        }
                        while($this->Login_model->randomIdExists($randomId));
                        $data = array(
                            'randomID' => $randomId,
                            'userID' => $createUser
            
                            );
                        $this->Login_model->verify($data);

                        $this->Email_model->mailTo(array($userData->email),"Verify your Email address",'Hello ' . $userData->username . '</br> please verify your email address by opening this link: https://surveylense.de/login/verify/' . $randomId);
                        
                        $data['email'] = $this->Email_model->obfuscate_email($userData->email);
                        $this->load->library('template');
                        $this->template->set('title', "verify your account");
                        $this->template->load('templates/loginTemplate','login/verificationView', $data);
                    }
                    else{
                        $this->session->set_flashdata('flash_data', 'Username is not available');
                        redirect('/register');
                    }
                }
                else{
                    $this->session->set_flashdata('flash_data', 'Passwords do not match');
                    redirect('/register');
                }
            }
            else{
                $this->session->set_flashdata('flash_data', 'All fields are required');
                    redirect('/register');
            }
            
            
        }
        
        $this->load->library('template');
        $this->template->set('title', ucfirst($page));
        $this->template->load('templates/loginTemplate','login/'.$page);
    }

    public function logout() {
        $data = array('id_user', 'username');
        $this->session->unset_userdata($data);
        redirect('/');
        }

    public function verify($randomId){
        if(null !== $randomId){
            $userId = $this->Login_model->verifyUser($randomId);
            $this->Login_model->activateUser($userId->UserID);

            $this->load->library('template');
            $this->template->set('title', "Your account was verified");
            $this->template->load('templates/loginTemplate','login/activationView');
        }
        else{
        redirect('/');
        }
    }

}