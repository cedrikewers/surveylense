<?php
class Homepage_model extends CI_Model {
    public function __construct(){
        $this->load->database();
    }
    public function get_last_surveys(){
        $this->db->select('name');
        $this->db->select('randomId');
        $this->db->select('description');
        $this->db->where('visibility', 'public');
        $this->db->order_by("id", "desc");
        $this->db->limit(5);
        $result = $this->db->get('surveyTemp');
        return $result->result_array();;
    }
}
?>