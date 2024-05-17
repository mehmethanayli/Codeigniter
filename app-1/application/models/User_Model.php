<?php

class User_Model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    /* Tabloya veri ekleme işlemi */
    public function add($data = array())
    {
        return $this->db->insert("users", $data);
    }

    /* Tablodaki tüm kayıtların getirilmesi */

    public function get_all($order = "id ASC")
    {
        return $this->db->order_by($order)->get("users")->result();
    }


    /* Tablodan şarta göre bir kaydın getirilmesi */

    public function get($param = array())
    {
        return $this->db->where($param)->get("users")->row();
    }
}
