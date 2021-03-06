<?php
class Result_model extends CI_Model {
    public function __construct(){
        $this->load->database();
    }

    public function getSurvey($randomId)
    {
        $this->db->select('id');
        $this->db->where('surveyTempRandomId', $randomId);
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
    
}

?>