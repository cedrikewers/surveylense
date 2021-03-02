<?php
class Survey_Model extends CI_Model {
    public function __construct(){
        $this->load->database();
    }

    public function checkRandomId($randomId){
        $this->db->where('randomId', $randomId);
        $query = $this->db->get('surveyTemp');
        return $query->row_array();
    }

    public function storeAnswers($surveyTempRandomId, $timestamp, $data){
        $this->db->set('surveyTempRandomId', $surveyTempRandomId);
        $this->db->set('timestamp', $timestamp);
        $this->db->set('data', $data);
        $this->db->insert('survey');

    }
}