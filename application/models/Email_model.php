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
        $config['smtp_user'] = "surveylense@flo-server.de";
        $config['smtp_pass'] = "MPG_Pr0jekt2021";
        $config['charset'] = "utf-8";
        $config['mailtype'] = "html";
        $config['newline'] = "\r\n";

        $this->email->initialize($config);

        $this->email->from('surveylense@flo-server.de', 'Surveylense');
        $this->email->to($to);
        $this->email->subject($title);
        $this->email->message($content);
        if($attach != null){
            $this->email->attach($attach);
        }
        $this->email->send();
    }
}