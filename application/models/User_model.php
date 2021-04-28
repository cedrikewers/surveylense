<?php
class User_Model extends CI_Model {
    public function __construct(){
        $this->load->database();
    }

    public function surveyTemp($randomId, $name, $description, $user, $visibility){
        $this->db->set('randomId',$randomId);
        $this->db->set('name', $name);
        $this->db->set('description', $description);
        $this->db->set('userId', $user);
        $this->db->set('visibility', $visibility);
        $this->db->insert('surveyTemp');
        return $this->db->insert_id();
    }   

    public function randomIdExists($randomId){
        $this->db->select('randomId');
        $this->db->where('randomId', $randomId);
        $result = $this->db->get('surveyTemp');
        return $result->row();
    }

    public function surveyTempData($surveyTempId, $number, $type, $data){
        $this->db->set('surveyTempId',$surveyTempId);
        $this->db->set('number', $number);
        $this->db->set('type', $type);
        $this->db->set('data', $data);
        $this->db->insert('surveyTempData');
        return $this->db->insert_id();
    }

    public function surveyTempDataAnswers($surveyTemDataId, $number, $data){
        $this->db->set('surveyTempDataId',$surveyTemDataId);
        $this->db->set('number', $number);
        $this->db->set('data', $data);
        $this->db->insert('surveyTempDataAnswers');
    }

    public function getUserData($id){
        $this->db->select('username');
        $this->db->select('email');
        $this->db->where('id', $id);
        $result = $this->db->get('users');
        return $result->row();
    }

    public function check_username($data){
        $this->db->where('username', $data);
        $result = $this->db->get('users')->row();
        return $result;
    }

    public function check_password($data){
        $this->db->select('password');
        $this->db->where('id', $data);
        $result = $this->db->get('users')->row();
        return $result;
    }

    public function update_username($data){
        $this->db->where('id', $data['id_user']);
        $this->db->set('username', $data['username']);
        $this->db->update('users');
    }

    public function update_password($data){
        $this->db->where('id', $data['id_user']);
        $this->db->set('password', md5($data['password']));
        $this->db->update('users');
    }

    public function update_email($data){
        $this->db->where('id', $data['id_user']);
        $this->db->set('email', $data['email']);
        $this->db->update('users');
    }

    public function getSurveyTempByUser($userId){
        $query = $this->db->query('SELECT surveyTemp.randomId, surveyTemp.name, surveyTemp.timestamp, COUNT(survey.id) AS count FROM surveyTemp LEFT JOIN survey ON surveyTemp.id = survey.surveyTempId WHERE userId = '.$userId.' GROUP BY surveyTemp.id');
        return $query->result_array();
    }

    public function getEditTemp($randomId){
        $this->db->select('name, description, visibility, id');
        $this->db->where('randomId', $randomId);
        $result = $this->db->get('surveyTemp')->row_array();
        $questions = $this->db->query('SELECT data, number, id, type FROM surveyTempData WHERE surveyTempId = '.$result['id'].' ORDER BY number');
        foreach($questions->result_array() as $questionTemp){
            $question = $questionTemp;
            $answers = $this->db->query('SELECT data, number FROM surveyTempDataAnswers WHERE surveyTempDataId = '.$question['id']);
            foreach($answers->result_array() as $answer){
                $question['answers'][$answer['number']] = $answer['data'];
            }
            $result['questions'][$question['number']] = $question;
        }
        $result['randomId'] = $randomId;
        // $i = 0;
        // while(array_key_exists($i, $result['questions'])){
        //     $result['questions'][$i] = $this->db->query('SELECT data, number FROM surveyTempDataAnswers WHERE surveyTempDataId = '.$result['questions'][$i]['id'])->result_array();   
        // }
        return $result;
    }

    public function updateSurveyTemp($randomId, $name, $description, $visibility){
        $this->db->query('UPDATE surveyTemp SET name =  '.$this->db->escape($name).', description = '.$this->db->escape($description).', visibility = '.$this->db->escape($visibility).' WHERE randomId = "'.$randomId.'"');
        $this->db->select('id');
        $this->db->where('randomId', $randomId);
        return $this->db->get('surveyTemp')->row_array()['id'];
    }

    public function updateSurveyTempData($surveyTempId, $number, $data){
        $this->db->query('UPDATE surveyTempData SET data =  '.$this->db->escape($data).' WHERE surveyTempId = '.$surveyTempId.' AND number = '.$number);
        $this->db->select('id');
        $this->db->where('surveyTempId', $surveyTempId);
        $this->db->where('number', $number);
        return $this->db->get('surveyTempData')->row_array()['id'];
    }

    public function clearAnswers($dataId)
    {
        $this->db->where('surveyTempDataId', $dataId);
        $this->db->delete('surveyTempDataAnswers');
    }

    public function updateQuestionOrder($order, $randomId){//i've tried manny other methods of doing this, trust me.
        $this->db->select('id');
        $this->db->where('randomId', $randomId);
        $surveyTempId = $this->db->get('surveyTemp')->row_array()['id'];

        $this->db->select('id, number');
        $this->db->where('surveyTempId', $surveyTempId);
        $questions = $this->db->get('surveyTempData')->result_array();

        foreach($questions as $question){
            reset($order);
            for($i = 0; $i < count($order); $i++){
                if($question['number'] == current($order)){
                    $this->db->query('UPDATE surveyTempData SET number = '.strval(key($order)+1).' WHERE id = '.$question['id']);
                    break;
                }
                next($order);
            }
        }
    }

    public function deleteQuestionModal($number, $randomId)
    {
        $this->db->select('id');
        $this->db->where('randomId', $randomId);
        $surveyTempId = $this->db->get('surveyTemp')->row_array()['id'];

        $this->db->query('DELETE FROM surveyTempData WHERE number = '.$this->db->escape($number).' AND surveyTempId = '.$surveyTempId);
        
    }

}