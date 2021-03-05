<?php
class Result_model extends CI_Model {
    public function __construct(){
        $this->load->database();
    }

    public function getData($randomId){
        $this->db->select('data');
        $this->db->where('surveyTempRandomId' , $randomId);
        $query = $this->db->get('survey');
        return $query->result_array(); 
    }

    public function getTemp($randomId){
        $this->db->select('name, data');
        $this->db->where('randomId', $randomId);
        $query = $this->db->get('surveyTemp');
        return $query->row_array();
    }
    
}

?>