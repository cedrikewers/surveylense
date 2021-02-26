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
}