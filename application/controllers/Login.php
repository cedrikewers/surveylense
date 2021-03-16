<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

    function __construct(){
        parent::__construct();
        $this->load->model('Login_model');
    }

	public function index(){

        $page = "login";
        if($_POST){

            $result = $this->Login_model->check_user($_POST);
            print_r($result);
            if(!empty($result)){

                $data = array(
                'id_user' => $result->id,
                'username' => $result->username

                );

                $this->session->set_userdata($data);
                if(isset($_GET['redirect'])){
                    redirect($_GET['redirect'].'?title='.$_GET['title']);
                }
                redirect('/userarea'); // eure Datenseite !!!!!!!!!!!!!!!

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
                        $this->Login_model->create_user($_POST);
                        $loginResult = $this->Login_model->check_user($_POST);
                        if(!empty($loginResult)){
    
                            $data = array(
                            'id_user' => $result->id,
                            'username' => $result->User
    
                            );
    
                            $this->session->set_userdata($data);
                            redirect('/userarea'); // eure Datenseite !!!!!!!!!!!!!!!
    
                        }
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
                $result = $this->Login_model->check_user($_POST);
                if(!empty($result)){
    
                    $data = array(
                    'id_user' => $result->id,
                    'username' => $result->User
    
                    );
    
                    $this->session->set_userdata($data);
                    redirect('/'); // eure Datenseite !!!!!!!!!!!!!!!
    
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

}