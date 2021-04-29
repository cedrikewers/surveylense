<?php
class Admin_model extends CI_Model {
    public function __construct(){
        $this->load->database();
    }

    public function check_user($data){
        $this->db->where('username', $data['username']);
        $this->db->where('password', md5($data['password']));
        $result = $this->db->get('adminUsers')->row();
        return $result;
    }
    public function get_users(){
        $query = $this->db->query('SELECT COUNT(id) as id FROM users');
        return $query->row_array()['id'];
    }

    public function get_active_users(){
        $query = $this->db->query('SELECT COUNT(id) as id FROM users WHERE active = 1');
        return $query->row_array()['id'];
    }

    public function get_disabled_users(){
        $query = $this->db->query('SELECT COUNT(id) as id FROM users WHERE active = 0');
        return $query->row_array()['id'];
    }

    public function get_surveys(){
        $query = $this->db->query('SELECT COUNT(id) as id FROM surveyTemp');
        return $query->row_array()['id'];
    }

    public function get_public_surveys(){
        $query = $this->db->query('SELECT COUNT(id) as id FROM surveyTemp WHERE visibility = "public"');
        return $query->row_array()['id'];
    }

    public function get_private_surveys(){
        $query = $this->db->query('SELECT COUNT(id) as id FROM surveyTemp WHERE visibility = "private"');
        return $query->row_array()['id'];
    }

    public function get_surveys_questions(){
        $query = $this->db->query('SELECT COUNT(id) as id FROM surveyTempData');
        return $query->row_array()['id'];
    }



    public function get_surveys_answers(){
        $query = $this->db->query('SELECT COUNT(DISTINCT surveyId) as id FROM surveyAnswers');
        return $query->row_array()['id'];
    }

    public function get_usernames_list(){
        $this->db->select('username');
        $this->db->select('id');
        $this->db->select('active');
        $this->db->order_by('username');
        $this->db->limit(100);
        $result = $this->db->get('users');
        return $result->result_array();
    }

    public function get_usernames_list_search($data){
        $this->db->select('username');
        $this->db->select('id');
        $this->db->select('active');
        $this->db->like('username', $data);
        $this->db->order_by('username');
        $this->db->limit(100);
        $result = $this->db->get('users');
        return $result->result_array();
    }

    public function deactivate_user($data){
        $this->db->where('id', $data);
        $this->db->set('active', 0);
        $this->db->update('users');
    }

    public function activate_user($data){
        $this->db->where('id', $data);
        $this->db->set('active', 1);
        $this->db->update('users');
    }

    public function get_surveys_list(){
        $this->db->select('name');
        $this->db->select('id');
        $this->db->order_by('name');
        $this->db->limit(100);
        $result = $this->db->get('surveyTemp');
        return $result->result_array();
    }

    public function get_surveys_list_search($data){
        $this->db->select('name');
        $this->db->select('id');
        $this->db->like('name', $data);
        $this->db->order_by('name');
        $this->db->limit(100);
        $result = $this->db->get('surveyTemp');
        return $result->result_array();
    }
    
}
?>