<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_Admin extends CI_Model
{
    public function countItamData()
    {
        $query = $this->db->get('monitoringassets_dataitam');
        if ($query->num_rows() > 0) {
            return $query->num_rows();
        } else {
            return 0;
        }
    }
    public function countAssetsData()
    {
        $query = $this->db->get('monitoringassets_typeassets');
        if ($query->num_rows() > 0) {
            return $query->num_rows();
        } else {
            return 0;
        }
    }
    public function countUserData()
    {
        $query = $this->db->get('user');
        if ($query->num_rows() > 0) {
            return $query->num_rows();
        } else {
            return 0;
        }
    }

    public function countUserEmail()
    {
        $query = $this->db->get('user_email');
        if ($query->num_rows() > 0) {
            return $query->num_rows();
        } else {
            return 0;
        }
    }

    public function getUserData()
    {
        return $this->db->get_where('user', array('is_active' => 1));
    }

    function deleteUser($where, $data, $table)
    {
        $this->db->where($where);
        $this->db->update($table, $data);
    }

    function getUsers($postData)
    {
        $response = array();
        if (isset($postData['search'])) {
            // Select record
            $this->db->select('*');
            $this->db->where("email like '%" . $postData['search'] . "%' ");

            $records = $this->db->get('user')->result();

            foreach ($records as $row) {
                $response[] = array("value" => $row->id, "label" => $row->email);
            }
        }
        return $response;
    }
}
