<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

    function __construct(){
        parent::__construct();
        $this->load->model('Login_model');
        $this->load->model('Email_model');
    }

    //LoginSeite
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
                    if(isset($_GET['redirect'])){
                      redirect($_GET['redirect'].'?title='.$_GET['title']);
                    }
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

    //RegistrierungsSeite
    public function register()
    {
        $page = "register";
        if($_POST){
            if($_POST['password'] != null && $_POST['password_repeat'] != null && $_POST['username'] != null && $_POST['email'] != null){
                if($_POST['password'] == $_POST['password_repeat']){
                    $email = $this->Login_model->check_email($_POST);
                    $username = $this->Login_model->check_username($_POST);
                    if(empty($email)){
                        if(empty($username)){
                            $createUser = $this->Login_model->create_user($_POST);
                            $userData = $this->Login_model->getUserData($createUser);
                            do{
                                $randomId = substr(hash("md5", random_bytes(20)), 0, 10);
                            }
                            while($this->Login_model->randomIdExists($randomId));
                            $data = array(
                                'randomID' => $randomId,
                                'userID' => $createUser,
                                'type' => 1
                
                                );
                            $this->Login_model->verify($data);

                            $this->Email_model->mailTo(array($userData->email),"Verify your Email address",'Hello ' . $userData->username . '<br> please verify your email address by opening this link: https://surveylense.de/login/verify/' . $randomId . '<br><br>Please do not respond to this message. If you would like to contact the Surveylense Team, please send an email to <a href="mailto:contact@surveylense.de">contact@surveylense.de</a>.');
                            $page = 'email';
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
                        $this->session->set_flashdata('flash_data', 'Email is used by another account');
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
        if($page == 'register'){
            $this->load->library('template');
            $this->template->set('title', ucfirst($page));
            $this->template->load('templates/loginTemplate','login/'.$page);
        }
    }

    //Logout für den Adminbereich
    public function logout() {
        $data = array('id_user', 'username');
        $this->session->unset_userdata($data);
        redirect('/');
        }

    //Verifizierung für Passwort Reset und Registrierung
    public function verify($randomId){
        if(null !== $randomId){
            $verify = $this->Login_model->verifyUser($randomId);
            switch ($verify->type) {
                case 0:
                    redirect('/');
                    break;
                case 1:
                    $this->Login_model->activateUser($verify->UserID);
                    $this->Login_model->verifySetDisabled($randomId);

                    $this->load->library('template');
                    $this->template->set('title', "Your account was verified");
                    $this->template->load('templates/loginTemplate','login/activationView');
                    break;
                case 2:
                    $this->Login_model->verifySetDisabled($randomId);
                    $newPassword = substr(hash("md5", random_bytes(20)), 0, 10);
                    $data = array(
                        'id' => $verify->UserID,
                        'password' => $newPassword
                        );
                    $this->Login_model->resetPassword($data);
                    $userData = $this->Login_model->getUserData($verify->UserID);
                    $this->Email_model->mailTo(array($userData->email),"Verify your password reset",'Hello ' . $userData->username . ',<br>your new password is: ' . $newPassword . '<br>Even though this is a relatively safe password we highly recommend that you change your password through your userarea after you have logged in with this new password.<br><br>Please do not respond to this message. If you would like to contact the Surveylense Team, please send an email to <a href="mailto:contact@surveylense.de">contact@surveylense.de</a>.');
                    $this->load->library('template');
                    $this->template->set('title', "Your passoword has been reset");
                    $this->template->load('templates/loginTemplate','login/passwordHasBeenResetView');
                    break;
                default:
                    redirect('/');
            }
        }
        else{
        redirect('/');
        }
    }
    //Passwort Reset Seite
     public function passwordreset(){
        if($_POST){
            $userData = $this->Login_model->getUserEmail($_POST['email']);
            if(!empty($userData)){
                do{
                    $randomId = substr(hash("md5", random_bytes(20)), 0, 10);
                }
                while($this->Login_model->randomIdExists($randomId));
                $data = array(
                    'randomID' => $randomId,
                    'userID' => $userData->id,
                    'type' => 2
                    );
                $this->Login_model->verify($data);
                $this->Email_model->mailTo(array($userData->email),"Verify your password reset",'Hello ' . $userData->username . ',<br>please verify your password reset request by opening this link: https://surveylense.de/login/verify/' . $randomId . '<br> If you have not made this request we highly recommend that you change your password through your userarea.<br><br>Please do not respond to this message. If you would like to contact the Surveylense Team, please send an email to <a href="mailto:contact@surveylense.de">contact@surveylense.de</a>.');
            }
            $this->session->set_flashdata('flash_data', 'If this email address exists in our Database you will receive an verification email shortly');
        }
        $this->load->library('template');
        $this->template->set('title', 'Reset your password');
        $this->template->load('templates/loginTemplate','login/passwordResetView');
     }
}