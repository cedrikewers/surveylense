<?php
class Survey_Model extends CI_Model {
    public function __construct(){
        $this->load->database();
    }

    // public function checkRandomId($randomId){
    //     $this->db->where('randomId', $randomId);
    //     $query = $this->db->get('surveyTemp');
    //     return $query->row_array();
    // }

    public function checkRandomId($randomId){
        $query = $this->db->query('SELECT name, id FROM surveyTemp WHERE randomId = "'.$randomId.'"');
        // $this->db->where('randomId', $randomId);
        // $query = $this->db->get('surveyTemp');
        return $query->row_array();
    }

    public function getQuestions($id){
        $this->db->select('number, data');
        $this->db->where('surveyTempId', $id);
        // $this->db->join('surveyTemp', 'surveyTempData.surveyTempId = surveyTemp.id');
        $query = $this->db->get('surveyTempData');
        return $query->result_array();
    }

    public function getAnswers($id){
        $this->db->select('surveyTempDataAnswers.number, surveyTempDataAnswers.data, surveyTempData.number AS dataNumber');
        $this->db->where('surveyTempData.surveyTempId', $id);
        $this->db->join('surveyTempData', 'surveyTempDataAnswers.surveyTempDataId = surveyTempData.id');
        $query = $this->db->get('surveyTempDataAnswers');
        return $query->result_array();
    }

    public function storeAnswers($surveyTempRandomId, $timestamp, $data){
        $this->db->set('surveyTempRandomId', $surveyTempRandomId);
        $this->db->set('timestamp', $timestamp);
        $this->db->set('data', $data);
        $this->db->insert('survey');
    }
}