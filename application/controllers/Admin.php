<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

    function __construct(){
        parent::__construct(); 
        $this->load->model('Admin_model');
    }
    // Login für den Adminbereich
    public function index(){

        $page = "Adminlogin";
        if($_POST){

            $result = $this->Admin_model->check_user($_POST);
            print_r($result);
            if(!empty($result)){
                if($result->active == 1){
                    $data = array(
                        'id_admin' => $result->id,
                        'admin_user' => $result->username
                    );
    
                    $this->session->set_userdata($data);
                    redirect('/admin/adminarea');
                }
                else{
                    $this->session->set_flashdata('flash_data', 'Account not active');
                redirect('/admin');
                }
            }
            else{
                $this->session->set_flashdata('flash_data', 'Username or Password wrong');
                redirect('/admin');
            }
        }
        $this->load->library('template');
        $this->template->set('title', ucfirst($page));
        $this->template->load('templates/loginTemplate','admin/'.$page);
    }

    //Logout für den Adminbereich
    public function logout() {
        $data = array('id_admin', 'admin_user');
        $this->session->unset_userdata($data);
        redirect('/');
    }

    //Adminarea und die Unterseiten
    public function adminarea($page = "home")
	{
		$session = $this->session->userdata('id_admin');
        if(empty($session)){
            redirect('/admin');
        }
        else{
            switch ($page) {
                case "home":
                    $data['users_total'] = $this->Admin_model->get_users();
                    $data['users_active'] = $this->Admin_model->get_active_users();
                    $data['users_disabled'] = $this->Admin_model->get_disabled_users();
                    $data['surveys_total'] = $this->Admin_model->get_surveys();
                    $data['surveys_public'] = $this->Admin_model->get_public_surveys();
                    $data['surveys_private'] = $this->Admin_model->get_private_surveys();
                    $data['surveys_questions'] = $this->Admin_model->get_surveys_questions();
                    $data['surveys_answers'] = $this->Admin_model->get_surveys_answers();
                    $this->load->library('template');
                    $this->template->set('title', 'adminarea');
                    $this->template->load('templates/adminTemplate','admin/adminarea', $data);
                    break;
                case "users":
                    if($_POST){
                        $data['users_list'] = $this->Admin_model->get_usernames_list_search($_POST['search']);
                    }
                    else{
                        $data['users_list'] = $this->Admin_model->get_usernames_list();
                    }
                    
                    $this->load->library('template');
                    $this->template->set('title', 'adminarea');
                    $this->template->load('templates/adminTemplate','admin/adminUsers', $data);
                    break;
                case "surveys":
                    if($_POST){
                        $data['surveys_list'] = $this->Admin_model->get_surveys_list_search($_POST['search']);
                    }
                    else{
                        $data['surveys_list'] = $this->Admin_model->get_surveys_list();
                    }
                    $this->load->library('template');
                    $this->template->set('title', 'adminarea');
                    $this->template->load('templates/adminTemplate','admin/adminSurveys', $data);
                    break;
            }
        }  
	}

    //Funktion für die Bearbeitung der Nutzereigenschaften
    public function modify($function, $id){
        $session = $this->session->userdata('id_admin');
        if(empty($session)){
            redirect('/admin');
        }
        else{
            switch ($function) {
                case "deactivateUser":
                    $this->Admin_model->deactivate_user($id);
                    echo $id;
                    redirect('/admin/adminarea/users');
                    break;
                case "activateUser":
                    $this->Admin_model->activate_user($id);
                    redirect('/admin/adminarea/users');
                    break;
                    

            }
        }
    }
}
?>