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


    public function show_users($limit = false, $offset = false)
    {
        $this->db->select('u.id,u.ident,u.email,u.name,u.surname,g.id as groups_id,g.name as name_groups,u.active');
        $this->db->from('users u ');
        $this->db->join('users_groups ug', 'u.id = ug.user_id');
        $this->db->join('groups g', 'g.id = ug.group_id');
        $this->db->limit($limit, $offset);
        $this->db->order_by("date_add", "asc");
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
    }

    public function show_one_users($id)
    {
        $this->db->select('u.id,u.ident,u.email,u.name,u.surname,g.id as groups_id,g.name as name_groups,u.active,u.company,u.phone');
        $this->db->from('users u ');
        $this->db->join('users_groups ug', 'u.id = ug.user_id');
        $this->db->join('groups g', 'g.id = ug.group_id');
        $this->db->where('u.id', $id);
        $this->db->order_by("date_add", "asc");
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
    }


    public function show_groups()
    {
        $this->db->select('g.id,g.name');
        $this->db->from('groups g ');
        $this->db->order_by("g.name", "desc");
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
    }


     public function show_groups_edit($id)
    {
        $this->db->select('g.id,g.name');
        $this->db->from('users_groups ug ');
        $this->db->join('groups g', 'g.id = ug.group_id');
        $this->db->where('ug.user_id', $id);
        $this->db->limit(1);

        print($this->db->last_query());
        $query1 = $this->db->get();
        $result1 = $query1->result_array();
        $name = $result1['0']['name'];


        $this->db->select('g.id,g.name');
        $this->db->from('groups g ');
        $this->db->where_not_in('g.name',  $name);
        $this->db->order_by("g.name", "desc");
        print($this->db->last_query());

        exit();

        $query2 = $this->db->get();
        if ($query2->num_rows() > 0) {
            return $query2->result_array();
        }

    }


    public function count_users()
    {
        $this->db->from('users');
        $query = $this->db->get();
        $count = $query->num_rows();
        return $count;
    }

    public function create_users()
    {
        //Tworzenie uzytkownika
        $email = $this->input->post('email');
        $ident = $this->input->post('ident');
        $password = $this->input->post('password');
        $name = $this->input->post('name');
        $surname = $this->input->post('surname');
        $company = $this->input->post('company');
        $phone = $this->input->post('phone');
        $active = $this->input->post('active');

        var_dump($active);

        $data = array(
            'id' => '',
            'email' => $email,
            'ident' => $ident,
            'password' => $this->hash_password($password),
            'name' => $name,
            'surname' => $surname,
            'company' => $company,
            'phone' => $phone,
            'active' => $active
        );
        $this->db->insert('users', $data);

        //Dodanie do grupy

        $id = $this->db->insert_id();
        $group = $this->input->post('group');

        $data = array(
            'id' => '',
            'user_id' => $id,
            'group_id' => $group,

        );
        $this->db->insert('users_groups', $data);

    }

    public function deactive_users($id)
    {
        $data = array('active' => 0, 'last_update' => date("Y-m-d H:i:s"));
        $this->db->where('id', $id);
        $this->db->update('users', $data);
        $this->db->limit(1);
        //var_dump($this->db->last_query());exit();
    }

    public function active_users($id)
    {
        $data = array('active' => 1, 'last_update' => date("Y-m-d H:i:s"));
        $this->db->where('id', $id);
        $this->db->update('users', $data);
        $this->db->limit(1);
    }

    public function delete_users($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('users');

        $this->db->where('user_id', $id);
        $this->db->delete('users_groups');
    }

    public function edit_users($id)
    {

echo  'test'.$id;
    }




    private function hash_password($password)
    {
        $options = array(
            'cost' => 11,
        );
        return password_hash($password, PASSWORD_BCRYPT, $options);
    }


}