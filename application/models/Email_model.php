<?php
class Email_model extends CI_Model {
    /**
     * @attach the realative path of the file begining with a "./"
     */
    public function mailTo(array $to, string $title, string $content, string $attach = null)
    {
        $this->load->library('email');
        $config['protocol'] = "smtp";
        $config['smtp_host'] = "ssl://smtp.ionos.de";
        $config['smtp_port'] = "465";
        $config['smtp_user'] = "noreply@surveylense.de";
        $config['smtp_pass'] = "MPG_Pr0jekt2021";
        $config['charset'] = "utf-8";
        $config['mailtype'] = "html";
        $config['newline'] = "\r\n";

        $this->email->initialize($config);

        $this->email->from('noreply@surveylense.de', 'Surveylense');
        $this->email->to($to);
        $this->email->subject($title);
        $this->email->message($content);
        if($attach != null){
            $this->email->attach($attach);
        }
        $this->email->send();
    }

    function obfuscate_email($email){
        $em   = explode("@",$email);
        $name = implode('@', array_slice($em, 0, count($em)-1));
        $len  = floor(strlen($name)/2);

        return substr($name,0, $len) . str_repeat('*', $len) . "@" . end($em);   
    }
    }