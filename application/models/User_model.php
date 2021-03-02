<?php
class User_Model extends CI_Model {
    public function __construct(){
        $this->load->database();
    }

    public function surveyTemp($randomId, $name, $user, $data){
        $this->db->set('randomId',$randomId);
        $this->db->set('name', $name);
        $this->db->set('userId', $user);
        $this->db->set('data', $data);
        $this->db->insert('surveyTemp');
        return $this->db->insert_id();
    }   

    public function randomIdExists($randomId){
        $this->db->select('randomId');
        $this->db->where('randomId', $randomId);
        $result = $this->db->get('surveyTemp');
        return $result->row();
        // if(empty($result)){
        //     return true;
        // }
        // else{
        //     return false;
        // }
    }

}