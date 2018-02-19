<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @property Model_User $Model_User
 */
class Dashboard extends BackendController {

    function __construct()
    {
        parent::__construct();
        $this->load->model('Model_User');
    }



	public function index()
	{
	 /*   print_r($_SESSION);
	    exit();*/


		//$this->load->view('welcome_message');
        $this->twig->addGlobal('personal_data', $this->Model_User->read_personal_data($this->id));
        $this->twig->addGlobal("session", $this->session);
		$this->twig->display('admin/index');

	}
}
