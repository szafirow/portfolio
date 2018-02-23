<?php
/**
 * Created by PhpStorm.
 * User: patryk
 * Date: 2018-02-17
 * Time: 18:54
 */

class Model_User extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
    }


    /**
     * Funckja do logowania użytkownika w systemie
     * @return bool
     */
    public function login()
    {
        $email = $this->input->post('email');
        $password = $this->input->post('password');


        //pobranie hash
        $this->db->select('password');
        $this->db->from('users');
        $this->db->where('active', 1);
        $this->db->where('email', $email);

        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            $hash = $result['0']['password'];

            if (password_verify($password, $hash)) {
                /*$value = array(
                    'id' => $result['0']['id'],
                    'login' => $result['0']['login']
                );
                return $value;*/
                return TRUE;
            } else {
                return FALSE;
            }
        } else {
            return FALSE;
        }

    }

    public function read_user_information()
    {
        $email = $this->input->post('email');

        $this->db->select('*');
        $this->db->from('users');
        $this->db->where('email', $email);
        $this->db->limit(1);
        $query = $this->db->get();

        if ($query->num_rows() == 1) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function read_personal_data($id)
    {
        $this->db->select('name,surname');
        $this->db->from('users');
        $this->db->where('id', $id);
        $this->db->limit(1);
        $query = $this->db->get();

        if ($query->num_rows() == 1) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function isset_email()
    {
        $email = $this->input->post('email');

        $this->db->select('email');
        $this->db->from('users');
        $this->db->where('active', 1);
        $this->db->where('email', $email);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }



    public function show_users(){

        $this->db->select('*');
        $this->db->from('users');
        $this->db->join('users_groups', 'users.id = users_groups.user_id');
        $this->db->join('groups', 'groups.id = users_groups.group_id');
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
    }




}