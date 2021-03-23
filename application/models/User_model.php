<?php
class User_Model extends CI_Model {
    public function __construct(){
        $this->load->database();
    }

    public function surveyTemp($randomId, $name, $description, $user, $visibility){
        $this->db->set('randomId',$randomId);
        $this->db->set('name', $name);
        $this->db->set('description', $description);
        $this->db->set('userId', $user);
        $this->db->set('visibility', $visibility);
        $this->db->insert('surveyTemp');
        return $this->db->insert_id();
    }   

    public function randomIdExists($randomId){
        $this->db->select('randomId');
        $this->db->where('randomId', $randomId);
        $result = $this->db->get('surveyTemp');
        return $result->row();
    }

    public function surveyTempData($surveyTempId, $number, $type, $data){
        $this->db->set('surveyTempId',$surveyTempId);
        $this->db->set('number', $number);
        $this->db->set('type', $type);
        $this->db->set('data', $data);
        $this->db->insert('surveyTempData');
        return $this->db->insert_id();
    }

    public function surveyTempDataAnswers($surveyTemDataId, $number, $data){
        $this->db->set('surveyTempDataId',$surveyTemDataId);
        $this->db->set('number', $number);
        $this->db->set('data', $data);
        $this->db->insert('surveyTempDataAnswers');
    }

    public function getUserData($id){
        $this->db->select('username');
        $this->db->select('email');
        $this->db->where('id', $id);
        $result = $this->db->get('users');
        return $result->row();
    }

    public function check_username($data){
        $this->db->where('username', $data);
        $result = $this->db->get('users')->row();
        return $result;
    }

    public function check_password($data){
        $this->db->select('password');
        $this->db->where('id', $data);
        $result = $this->db->get('users')->row();
        return $result;
    }

    public function update_username($data){
        $this->db->where('id', $data['id_user']);
        $this->db->set('username', $data['username']);
        $this->db->update('users');
    }

    public function update_password($data){
        $this->db->where('id', $data['id_user']);
        $this->db->set('password', md5($data['password']));
        $this->db->update('users');
    }

    public function update_email($data){
        $this->db->where('id', $data['id_user']);
        $this->db->set('email', $data['email']);
        $this->db->update('users');
    }

}