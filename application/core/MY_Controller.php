<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class MY_Controller extends CI_Controller
{
    public $id;

    function __construct()
    {
        parent::__construct();

        $logged_in = $this->session->userdata('logged_in');
        if (!empty($logged_in)) {
            $this->id = $logged_in['id'];
        }

    }


      function is_logged_in()
      {
          $logged_in = $this->session->userdata('logged_in');
          if (empty($logged_in)) {
              show_error('You don\'t have permission to access this page.', 401);
              die();
          }
      }





}