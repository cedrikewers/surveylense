<?php
class Create_Model extends CI_Model {
    public function __construct(){
        $this->load->database();
    }

    public function surveyTemp($randomId, $name){
        $this->db->set('randomId',$randomId);
        $this->db->set('name', $name);
        $this->db->insert('surveyTemp');
        return $this->db->insert_id();
    }   

    public function surveyTempData($surveyTempId, $number, $type, $text){
        $this->db->set('surveyTempId',$surveyTempId);
        $this->db->set('number', $number);
        $this->db->set('type', $type);
        $this->db->set('text', $text);
        $this->db->insert('surveyTempData');
        return $this->db->insert_id();
    }

    public function surveyTempDataAnswers($surveyTempDataId,$number, $type, $content){
        $this->db->set('surveyTempDataId',$surveyTempDataId);
        $this->db->set('number', $number);
        $this->db->set('type', $type);
        $this->db->set('content', $content);
        $this->db->insert('surveyTempDataAnswers');
    }

    public function check_randomId($randomId){
        return $this->db->query('
                SELECT EXISTS(
                        SELECT randomId FROM surveyTemp WHERE randomId ='.$randomId.'
                )'
                );
    }

}