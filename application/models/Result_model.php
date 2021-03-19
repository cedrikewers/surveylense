<?php
class Result_model extends CI_Model {
    public function __construct(){
        $this->load->database();
    }

    public function getSurvey($randomId)
    {
        $this->db->select('id');
        $this->db->where('randomId', $randomId);
        $surveyTempId = $this->db->get('surveyTemp')->row_array()['id'];
        $this->db->select('id');
        $this->db->where('surveyTempId', $surveyTempId);
        $query = $this->db->get('survey');
        return $query->result_array();
    }

    public function getData($id)
    {
        $this->db->select('surveyTempDataId, data');
        $this->db->where('surveyId', $id);
        $query = $this->db->get('surveyAnswers');
        return $query->result_array();
    }

    public function getEmail()
    {
        $this->db->select('email');
        $this->db->where('id', $_SESSION['id_user']);
        $query = $this->db->get('users');
        return $query->row_array()['email'];
    }

    public function checkUser($randomId)
    {
        $this->db->select('userId');
        $this->db->where('randomId', $randomId);
        $query = $this->db->get('surveyTemp');
        if($query->row_array()['userId'] == $this->session->userdata('id_user')){
            return true;
        }
        return false; 
    }
    
}

?>