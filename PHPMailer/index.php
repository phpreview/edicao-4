<?php
 include 'funcao.php';

// ENFIM, MANDA O E-MAIL.
envia_email(
       array(
           "TEMPLATE" => "EMAIL_TEMPLATE1",
           "Email" => "seuemail@dominio.com.br",
           "Nome" => "Seu Nome"));
?>