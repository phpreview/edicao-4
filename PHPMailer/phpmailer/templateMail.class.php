<?php
   include_once("class.phpmailer.php");

   class TemplateMail extends PHPMailer{
      
      public function __contruct(){

          parent::__contruct();

          $this->IsSMTP();
          $this->CharSet = "utf-8";
          $this->SMTPAuth = true;
          $this->IsHTML(true);
          $this->Host = "smtp.gmail.com"; // voce coloca aqui o seu servidor smtp.
          $this->Port = 465;
          $this->SMTPSecure = "ssl";
          $this->Username = "enviador@gmail.com";
          $this->Password = "123456";
          $this->From = "enviador@gmail.com";
          $this->FromName = mb_convert_encoding("NOME REMETENTE",'UTF-8','HTML-ENTITIES');

      }

      public function sendTemplateEmail($templateData,$template){

          try{
             $this->informationPresent($templateData,$template);
             $this->isArray($templateData);

             $filename = $template;
             $fd = fopen($filename,"r");
             $emailcontent = fread($fd,filesize($filename));

             foreach($templateData as $key=>$value){
               $emailcontent = str_replace("%%$value[0]%%",$value[1],$emailcontent);
             }
             $emailcontent = stripslashes($emailcontent);

             fclose($fd);
             $tthis->Body = $emailcontent;
             $this->AltBody = 'Se este e-mail nуo aparecer corretamente, habilite a visualizaчуo de imagens em HTML.';
             
             if(!$this->Send()){
                  throw new Exception("Erro ao enviar email. ".$this->ErrorInfo);
             }
             else{
                 // ENVIADO COM SUCESSO...
                 // LIMPANDO TODOS OS RECIPIENTES
	         $this->clearAllRecipients();
             }
          }catch(Exception $ex){
            throw $e;
          }
      }

      private function informationPresent($templateData,$template){
         $to = $this->getTo();
         if(empty($templateData) || template == "" || $this->Form == "" || $this->Subject == "" || empty($to)){
            throw new Exception("As informaчѕes do email sуo invсlidas. ");
         }
      }

      private function isArray($arrayCandidate){
        if(!is_array($arraycandidate)){
           throw new Exception("As informaчѕes fornecidas nуo estуo no formato vсlido ");
        }
      }
}
?>