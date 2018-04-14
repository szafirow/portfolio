<?php
/**
 * Created by PhpStorm.
 * User: patryk
 * Date: 2017-12-13
 * Time: 19:51
 */


/**
 * @property Model_User $Model_User
 */
class BackendController extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->is_logged_in();
        $this->load->model('Model_User');
        $this->load->model('Model_Client');
        $this->twig->addGlobal('personal_data', $this->Model_User->read_personal_data($this->id));
        $this->twig->addGlobal("uri_2", $uri = $this->uri->segment(2));
        $this->twig->addGlobal("uri_3", $uri = $this->uri->segment(3));
        $this->twig->addGlobal("uri_4", $uri = $this->uri->segment(4));
    }
}