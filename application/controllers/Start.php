<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Start extends FrontendController {


	public function index()
	{
		//$this->load->view('welcome_message');


		$this->twig->display('default/index');

	}
}
