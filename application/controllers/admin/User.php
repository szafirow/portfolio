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
        $this->twig->addGlobal("session", $this->session);
    }

    public function index()
    {

        // $this->twig->addGlobal("users", $this->Model_User->show_users());

        $config['base_url'] = base_url() . 'admin/user/index/';
        $config['total_rows'] = $this->Model_User->count_users();
        $config['use_page_numbers'] = TRUE;
        $config['per_page'] = 10;
        $config['uri_segment'] = 4;

        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';
        $config['first_link'] = false;
        $config['last_link'] = false;
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['prev_link'] = '«';
        $config['prev_tag_open'] = '<li class="prev">';
        $config['prev_tag_close'] = '</li>';
        $config['next_link'] = '»';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';


        $this->pagination->initialize($config);

        $limit = $config['per_page'];
        $offset = ($this->uri->segment($config['uri_segment']));

/*var_dump($this->Model_User->show_users($limit, $offset));*/
        $this->twig->addGlobal("pagination", $this->pagination->create_links());
        $this->twig->addGlobal("users", $this->Model_User->show_users($limit, $offset));
        $this->twig->display('admin/index');



    }


    public function create()
    {
        //wzomcnic walidacje
       // var_dump($_SESSION);
        //$this->session->unset_userdata('session');
        //nowe_konto
        $this->form_validation->set_rules('email', 'Email', 'trim|required');
        $this->form_validation->set_rules('ident', 'IDENT', 'trim|required');
        //$this->form_validation->set_rules('password', 'Hasło', 'trim|required|callback_check_password');


        $action = $this->input->post('action');

        if ($action) {
            if ($this->form_validation->run() == FALSE) {
                //blednie wypelniony formularz
                $this->session->set_flashdata('item', array('message' => validation_errors(), 'class' => 'danger'));
                redirect('admin/user/create');

            } else {
                $this->Model_User->create_users();
                $this->session->set_flashdata('item', array('message' => 'Konto założone!', 'class' => 'success'));
                redirect('admin/user');
            }

        } else {
            $this->twig->addGlobal("groups", $this->Model_User->show_groups());
            $this->twig->display('admin/index');
        }


    }


    public function edit()
    {
        $this->twig->addGlobal("session", $this->session);
        $this->twig->display('admin/index');
    }


}