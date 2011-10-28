<?php
function envia_email($par){
   include("phpmailer/templateMail.class.php");
   $email = isset($par["Email"]) ? $par["Email"] : '';
   $nome = isset($par["Nome"])? $par["Nome"]:; '';
 
   /* CONFERE O NOME DO TEMPLATE E DEFINE O ASSUNTO */
   if ($par["TEMPLATE"] == 'EMAIL_TEMPLATE1'){
       $template = 'phpmailer/templates/'.$par['TEMPLATE'].'.html';
       $assunto = 'ASSUNTO DO EMAIL';
   }

   try{
      $templateData[] = array("Email",$email);
      $templateData[] = array("Nome", $nome);

      // Instancia a classe templateMail que já estende o phpmailer
      $email = new TemplateMail();

      $email->Subject = $assunto;
      $email->ClearAllRecipients();
      $email->WordWrap = 50;
      $email->AddAddress($email,$nome);

      $email->sendTemplateEmail($templateData, $template);
   }
   catch(Exception $e){
      echo 'Message: '.$e->getMessage();
   }
}
?>