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
    }
}