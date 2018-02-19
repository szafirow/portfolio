<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @property Model_User $Model_User
 */
class User extends FrontendController
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('Model_User');
    }


    public function index()
    {
        $this->twig->display('login/index');


    }


    public function login()
    {

        //logowanie
        $this->form_validation->set_rules('email', 'Email', 'trim|required|callback_check_email');
        $this->form_validation->set_rules('password', 'Hasło', 'trim|required|callback_check_password');


        if ($this->form_validation->run() == FALSE) {
            //nie zalogowany
            $this->session->set_flashdata('item', array('message' => strip_tags(validation_errors()), 'class' => 'danger'));
            $this->twig->addGlobal('session', $this->session);
            $this->twig->display('login/index');
        } else {

            $result = $this->Model_User->login();
            if ($result == TRUE) {
                $sess_array = array();
                $result = $this->Model_User->read_user_information();
                if ($result != false) {
                    $sess_array = array(
                        'id' => $result[0]->id,
                        'online' => true
                    );
                }
                $this->session->set_userdata('logged_in', $sess_array);
                //$this->session->set_userdata($sess_array);
                $this->session->set_flashdata('item', array('message' => 'Zalogowany!', 'class' => 'success'));


                 redirect('admin/dashboard', 'refresh');

            }
        }

    }

    public function check_email()
    {

        if ($this->Model_User->isset_email() == FALSE) {
            $this->form_validation->set_message('check_email', 'Taki login nie istnieje w bazie danych.');
            return FALSE;
        } else {
            return TRUE;
        }
    }


    function check_password()
    {
        $result = $this->Model_User->login();
        if (!$result) {
            $this->form_validation->set_message('check_password', 'Wprowadzono błędne hasło.');
            return FALSE;
        } else {
            return TRUE;
        }
    }



    public function logout()
    {
       // $this->session->unset_userdata('logged_in');
       // $this->session->set_flashdata('item', array('message' => 'Wylogowany!', 'class' => 'danger'));
        $this->session->sess_destroy();
        redirect("user");
    }

}
