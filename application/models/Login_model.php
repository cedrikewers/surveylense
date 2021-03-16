<?php
class Login_model extends CI_Model {
    public function __construct(){
        $this->load->database();
    }
    public function check_user($data){
        $this->db->where('username', $data['username']);
        $this->db->where('password', md5($data['password']));
        $result = $this->db->get('users')->row();
        return $result;
    }
    public function check_username($data){
        $this->db->where('username', $data['username']);
        $result = $this->db->get('users')->row();
        return $result;
    }
    public function create_user($data){
        $this->db->set('username', $data['username']);
        $this->db->set('email', $data['email']);
        $this->db->set('password', md5($data['password']));
        $this->db->insert('users');
        $insertId = $this->db->insert_id();
        return $insertId;
    }

    public function getUserData($id){
        $this->db->select('username');
        $this->db->select('email');
        $this->db->where('id', $id);
        $result = $this->db->get('users');
        return $result->row();
    }

    public function randomIdExists($randomId){
        $this->db->select('randomID');
        $this->db->where('randomID', $randomId);
        $result = $this->db->get('usersVerify');
        return $result->row();
    }

    public function verify($data){
        $this->db->set('randomId',$data['randomID']);
        $this->db->set('userId', $data['userID']);
        $this->db->insert('usersVerify');
        return $this->db->insert_id();
    }

    public function verifyUser($randomId){
        $this->db->select('UserID');
        $this->db->where('randomID', $randomId);
        $result = $this->db->get('usersVerify');
        return $result->row();
    }

    public function activateUser($data){
        $this->db->where('id', $data);
        $this->db->set('active', 1);
        $this->db->update('users');
    }
}