<?php
/**
 * Created by PhpStorm.
 * User: patryk
 * Date: 2018-02-17
 * Time: 18:54
 */

class Model_Client extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
    }


    public function count_clients($id)
    {
        $this->db->from('users u');
        $this->db->join('users_groups ug', 'u.id = ug.user_id');
        $this->db->join('groups g', 'g.id = ug.group_id');
        $this->db->join('company c', 'c.id = u.company_id');
        $this->db->where('ug.group_id', 3);
        $this->db->where('u.active', 1);
        $this->db->where('c.active', 1);
        $this->db->where('u.id_parent', $id);
        $query = $this->db->get();
        $count = $query->num_rows();
        return $count;
        //print($this->db->last_query());exit();
    }



    public function show_clients($limit = false, $offset = false, $id)
    {
        $this->db->select('u.id,u.ident,u.email,u.name,u.surname,c.name as company_name,g.id as groups_id,g.name as name_groups,u.active');
        $this->db->from('users u ');
        $this->db->join('users_groups ug', 'u.id = ug.user_id');
        $this->db->join('groups g', 'g.id = ug.group_id');
        $this->db->join('company c', 'c.id = u.company_id');
        $this->db->where('ug.group_id', 3);
        $this->db->where('u.active', 1);
        $this->db->where('c.active', 1);
        $this->db->where('u.id_parent', $id);
        $this->db->limit($limit, $offset);
        $this->db->order_by("date_add", "asc");
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
    }


    public function show_client_one($id){
        $this->db->select('u.id,u.ident,u.email,u.name,u.surname,u.active,u.phone');
        $this->db->from('users u ');
        $this->db->where('u.id', $id);
        $this->db->order_by("date_add", "asc");
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
    }

}