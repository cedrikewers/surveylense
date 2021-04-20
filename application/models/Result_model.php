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
        if($query->row_array()['userId'] == $this->session->userdata('id_user') or $this->session->userdata('id_user')==1){
            return true;
        }
        return false; 
    }

    public function getDataset($surveyTempDataId ,$type){
        switch($type){
            case 0:
            case 1: 
            case 2:
                $query = $this->db->query('SELECT data, COUNT(data) AS count FROM surveyAnswers WHERE surveyTempDataId = '.$surveyTempDataId.' GROUP BY data ORDER BY count DESC');
                return $query->result_array();
                break;
            case 3:
                $query = $this->db->query('SELECT data, COUNT(data) AS count FROM surveyAnswers WHERE surveyTempDataId = '.$surveyTempDataId.' GROUP BY data ORDER BY count DESC LIMIT 5');
                return $query->result_array();
                break;
            
        }
    }

    // public function getAnswers($surveyTempDataId){
    //     $query = $this->db->query('SELECT surveyTempData.number AS questionNumber, surveyTempDataAnswers.number AS answerNumber, surveyTempDataAnswers.data FROM surveyTempData JOIN surveyTempDataAnswers ON surveyTempData.id = surveyTempDataAnswers.surveyTempDataId WHERE surveyTempDataAnswers.surveyTempDataId = '.$surveyTempDataId);
    //     $result = array();
    //     foreach($query->result_array() as $answer){
    //         $result[$answer['questionNumber'].'_'.$answer['answerNumber']] = $answer['data'];
    //     }
    //     return $result;
    // }

    
}

?>