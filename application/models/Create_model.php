<?php
class Create_Model extends CI_Model {
    public function __construct(){
        $this->load->database();
    }

    public function surveyTemp($randomId, $name){
        $this->db->set('randomId',$randomId);
        $this->db->set('name', $name);
        $this->db->insert('surveyTemp');
    }   

    public function check_randomId($randomId){
        return $this->db->query('
                SELECT EXISTS(
                        SELECT randomId FROM surveyTemp WHERE randomId ='.$randomId.'
                )'
                );
    }

}