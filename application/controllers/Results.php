<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Results extends CI_Controller {

	function __construct(){
        parent::__construct(); 
        $this->load->model('Result_model');
        $this->load->model('Result_model');
        }

	public function index()
	{
		
	}

    public function downloadXLSX($randomId){
        $this->load->library('SimpleXLSXGen'); #https://github.com/shuchkin/simplexlsxgen
        $data = $this->Result_model->getData($randomId);
        $template = $this->Result_model->getTemp($randomId);
        $templateData = unserialize($template['data']);
        $print = [];
        foreach($data as $row){
            array_push($print,unserialize($row['data']));
        }
        $printTemp = [];
        //Hier werden die Spaltenüberschriften genneriert
        $questionsTemp = [];
        array_push($questionsTemp, "");
        foreach($templateData as $key => $value){
            if(strpos($key, "q") === 0){
                array_push($questionsTemp, $value);
            }
        }
        array_push($printTemp, $questionsTemp);
        //Hier werden die Keys in die Values umgewandelt
        $i = 0;
        foreach($print as $row){
            $i++;
            $temp = [];
            array_push($temp, $i);//Hier wird noch die Nummer des Datensatzes angegeben, gestartet mit 1.
            foreach($row as $item){
                array_push($temp, $templateData[$item]);
            }
            array_push($printTemp, $temp);
        }
        $print = $printTemp;
        $xlsx = SimpleXLSXGen::fromArray($print);
        $xlsx->downloadAs('results.xlsx');
    }
}