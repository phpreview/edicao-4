<?php
   class AreaRestrita extends Controller {
     function __construct(){
        parent::Controller();
     }
     function index(){
        $this->auth->check_logged(
            $this->router->class ,
            $this->router->method);
     }
   }
?>
