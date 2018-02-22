<?php
/**
 * Created by PhpStorm.
 * User: patryk
 * Date: 2018-02-22
 * Time: 18:31
 */

/**
 * @property Model_User $Model_User
 */
class User extends BackendController
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('Model_User');
    }

    public function index()
    {
        $this->twig->addGlobal('personal_data', $this->Model_User->read_personal_data($this->id));
        $this->twig->addGlobal("session", $this->session);
        $this->twig->display('admin/index');
    }


    public function edit(){
        $this->twig->addGlobal('personal_data', $this->Model_User->read_personal_data($this->id));
        $this->twig->addGlobal("session", $this->session);
        $this->twig->display('admin/index');
    }



}