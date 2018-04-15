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
        $this->db->join('users_groups ug', 'u.id = ug.users_id');
        $this->db->join('groups g', 'g.id = ug.groups_id');
        $this->db->join('company c', 'c.id = u.company_id');
        $this->db->where('ug.groups_id', 3);
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
        $this->db->join('users_groups ug', 'u.id = ug.users_id');
        $this->db->join('groups g', 'g.id = ug.groups_id');
        $this->db->join('company c', 'c.id = u.company_id');
        $this->db->where('ug.groups_id', 3);
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
        $this->db->select('u.id,u.ident,u.email,u.name,u.surname,u.active,u.phone,
        c.name as name_company, a.street as street_company, a.street_number as street_number_company,
        home_number as home_number_company, postal_code as postal_code_company, city as city_company, country as country_company');
        $this->db->join('users_company uc', 'u.id = uc.users_id');
        $this->db->join('company c', 'c.id = uc.company_id');
        $this->db->join('address a', 'a.id = c.address_id');
        $this->db->from('users u ');
        $this->db->where('u.id', $id);
        $this->db->order_by("date_add", "asc");
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
    }

}