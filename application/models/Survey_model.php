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
        $query = $this->db->query('SELECT name, description, id FROM surveyTemp WHERE randomId = "'.$randomId.'"');
        // $this->db->where('randomId', $randomId);
        // $query = $this->db->get('surveyTemp');
        return $query->row_array();
    }

    public function getQuestions($id){
        $this->db->select('number, data, type, id');
        $this->db->where('surveyTempId', $id);
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

    public function storeSurvey($id)
    {
        $this->db->set('surveyTempId', $id);
        $this->db->insert('survey');
        return $this->db->insert_id();
    }


    public function storeAnswers($surveyTempid, $surveyId, $number, $data)
    {
        $this->db->select('id');
        $this->db->where('surveyTempId', $surveyTempid);
        $this->db->where('number', $number);
        $query = $this->db->get('surveyTempData');

        $surveyTempDataId = $query->row_array()['id'];
        
        $this->db->set('surveyId', $surveyId);
        $this->db->set('surveyTempDataId', $surveyTempDataId);
        $this->db->set('data', $data);
        $this->db->insert('surveyAnswers');
    }

    public function getSurveyTempId($randomId){
        $this->db->select('id');
        $this->db->where('randomId', $randomId);
        $query = $this->db->get('surveyTemp');
        return $query->row_array()['id'];
    }

    public function getRandomPublic(){
        $query = $this->db->query('SELECT surveyTemp.randomId, surveyTemp.name, surveyTemp.description, surveyTemp.timestamp, COUNT(survey.surveyTempId) AS count FROM surveyTemp LEFT JOIN survey ON surveyTemp.id = survey.surveyTempId WHERE visibility = "public" GROUP BY surveyTemp.id ORDER BY count DESC LIMIT 1');
        $result['top'] = $query->row_array();
        $query = $this->db->query('SELECT surveyTemp.randomId, surveyTemp.name, surveyTemp.description, surveyTemp.timestamp, COUNT(survey.surveyTempId) AS count FROM surveyTemp LEFT JOIN survey ON surveyTemp.id = survey.surveyTempId WHERE visibility = "public" GROUP BY surveyTemp.id ORDER BY RAND() DESC LIMIT 5');
        $random = $query->result_array();
        $i = 0;
        foreach($random as $survey){
            $result[$i] = $survey;
            $i++;
        }
        return $result;
    }   

}
