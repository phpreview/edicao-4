<?php defined('SYSPATH') or die('No direct script access.');


class Controller_Site extends Controller_Template {


	public function action_contact() {

		$notice = '';

		$fields = $_POST;

		$validate = Validate::factory($_POST)

		->rule('name', 'not_empty')

		->rule('email', 'email')
		->rule('message', 'not_empty');

		if(isset($_POST['name']) && isset($_POST['email']) && isset($_POST['message'])) {

			if($validate->check()) {

				// DISCLAIMER: educational purpose only

				mail('Your Name <you@domain.com>',

				'Contact form',

				$_POST['message'],
 
				'From: '.$_POST['name'].' <'.$_POST['email'].">\r\n");

			} else {

				$notice = 'All fields required';

			}

		} else {

			$fields = array('name' => '', 'email' => '', 'message' => '');

		}


		$this->template->title = 'Contact page';

		$this->template->content = new View('contact');

		$this->template->content->notice = $notice;

		$this->template->content->fields = $fields;

	}


}


?>