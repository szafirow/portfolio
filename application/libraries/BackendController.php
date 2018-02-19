<?php
/**
 * Created by PhpStorm.
 * User: patryk
 * Date: 2017-12-13
 * Time: 19:51
 */

class BackendController extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->is_logged_in();
    }
}