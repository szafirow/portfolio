<?php
/**
 * Created by PhpStorm.
 * User: patryk
 * Date: 2018-02-22
 * Time: 18:31
 */

/**
 * @property Model_Client $Model_Client
 */
class Client extends BackendController
{

    function __construct()
    {
        parent::__construct();
        $this->twig->addGlobal("session", $this->session);
    }

    public function index()
    {

        // $this->twig->addGlobal("users", $this->Model_User->show_users());

        $config['base_url'] = base_url() . 'admin/client/index/';
        $config['total_rows'] = $this->Model_Client->count_clients($this->id);
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
        $this->twig->addGlobal("clients", $this->Model_Client->show_clients($limit, $offset, $this->id));
        $this->twig->display('admin/index');


    }


    public function show(){
        $id = $uri = $this->uri->segment(4);
        $this->twig->addGlobal("clients",  $this->Model_Client->show_client_one($id));
        $this->twig->display('admin/index');
    }

/* pobrac dane do widoku show clients */


}