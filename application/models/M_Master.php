<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_Master extends CI_Model
{
    public function getAssetsData()
    {
        return $this->db->get('monitoringassets_typeassets');
    }

    public function getItamData()
    {
        return $this->db->get('monitoringassets_dataitam');
    }

    public function Datatables($dt)
    {

        $columns = implode(', ', $dt['col-display']) . ', ' . $dt['id-table'];
        // $join = $dt['join'];
        $sql  = "SELECT {$columns} FROM {$dt['table']}";
        $data = $this->db->query($sql);
        $rowCount = $data->num_rows();
        $data->free_result();
        // pengkondisian aksi seperti next, search dan limit
        $columnd = $dt['col-display'];
        $count_c = count($columnd);
        // search
        $search = $dt['search']['value'];
        /**
         * Search Global
         * pencarian global pada pojok kanan atas
         */
        $where = '';
        if ($search != '') {
            for ($i = 0; $i < $count_c; $i++) {
                $where .= $columnd[$i] . ' LIKE "%' . $search . '%"';

                if ($i < $count_c - 1) {
                    $where .= ' OR ';
                }
            }
        }

        /**
         * Search Individual Kolom
         * pencarian dibawah kolom
         */
        for ($i = 0; $i < $count_c; $i++) {
            $searchCol = $dt['columns'][$i]['search']['value'];
            if ($searchCol != '') {
                $where = $columnd[$i] . ' LIKE "%' . $searchCol . '%" ';
                break;
            }
        }
        /**
         * pengecekan Form pencarian
         * pencarian aktif jika ada karakter masuk pada kolom pencarian.
         */
        if ($where != '') {
            $sql .= " WHERE " . $where;
        }

        // sorting
        $sql .= " ORDER BY {$columnd[$dt['order'][0]['column']]} {$dt['order'][0]['dir']}";

        // limit
        $start  = $dt['start'];
        $length = $dt['length'];
        $sql .= " LIMIT {$start}, {$length}";

        $list = $this->db->query($sql);
        /**
         * convert to json
         */
        $option['draw']            = $dt['draw'];
        $option['recordsTotal']    = $rowCount;
        $option['recordsFiltered'] = $rowCount;
        $option['data']            = array();
        foreach ($list->result() as $row) {
            /**
             * custom gunakan
             * $option['data'][] = array(
             *                       $row->columnd[0],
             *                       $row->columnd[1],
             *                       $row->columnd[2],
             *                       $row->columnd[3],
             *                       $row->columnd[4],
             *                       .....
             *                     );
             */
            $rows = array();
            for ($i = 0; $i < $count_c; $i++) {
                $rows[] = $row->$columnd[$i];
            }
            $option['data'][] = $rows;
        }
        // eksekusi json
        echo json_encode($option);
    }

    function get_tables_where($tables, $cari, $where, $iswhere)
    {
        // Ambil data yang di ketik user pada textbox pencarian
        $search = htmlspecialchars($_POST['search']['value']);
        // Ambil data limit per page
        $limit = preg_replace("/[^a-zA-Z0-9.]/", '', "{$_POST['length']}");
        // Ambil data start
        $start = preg_replace("/[^a-zA-Z0-9.]/", '', "{$_POST['start']}");

        $setWhere = array();
        foreach ($where as $key => $value) {
            $setWhere[] = $key . "='" . $value . "'";
        }

        $fwhere = implode(' AND ', $setWhere);

        if (!empty($iswhere)) {
            $sql = $this->db->query("SELECT * FROM " . $tables . " WHERE $iswhere AND " . $fwhere);
        } else {
            $sql = $this->db->query("SELECT * FROM " . $tables . " WHERE " . $fwhere);
        }
        $sql_count = $sql->num_rows();

        $query = $tables;
        $cari = implode(" LIKE '%" . $search . "%' OR ", $cari) . " LIKE '%" . $search . "%'";

        // Untuk mengambil nama field yg menjadi acuan untuk sorting
        $order_field = $_POST['order'][0]['column'];

        // Untuk menentukan order by "ASC" atau "DESC"
        $order_ascdesc = $_POST['order'][0]['dir'];
        $order = " ORDER BY " . $_POST['columns'][$order_field]['data'] . " " . $order_ascdesc;

        if (!empty($iswhere)) {
            $sql_data = $this->db->query("SELECT * FROM " . $query . " WHERE $iswhere AND " . $fwhere . " AND (" . $cari . ")" . $order . " LIMIT " . $limit . " OFFSET " . $start);
        } else {
            $sql_data = $this->db->query("SELECT * FROM " . $query . " WHERE " . $fwhere . " AND (" . $cari . ")" . $order . " LIMIT " . $limit . " OFFSET " . $start);
        }

        if (isset($search)) {
            if (!empty($iswhere)) {
                $sql_cari =  $this->db->query("SELECT * FROM " . $query . " WHERE $iswhere AND " . $fwhere . " AND (" . $cari . ")");
            } else {
                $sql_cari =  $this->db->query("SELECT * FROM " . $query . " WHERE " . $fwhere . " AND (" . $cari . ")");
            }
            $sql_filter_count = $sql_cari->num_rows();
        } else {
            if (!empty($iswhere)) {
                $sql_filter = $this->db->query("SELECT * FROM " . $tables . " WHERE $iswhere AND " . $fwhere);
            } else {
                $sql_filter = $this->db->query("SELECT * FROM " . $tables . " WHERE " . $fwhere);
            }
            $sql_filter_count = $sql_filter->num_rows();
        }

        $data = $sql_data->result_array();

        $callback = array(
            'draw' => $_POST['draw'], // Ini dari datatablenya    
            'recordsTotal' => $sql_count,
            'recordsFiltered' => $sql_filter_count,
            'data' => $data
        );
        return json_encode($callback); // Convert array $callback ke json
    }

    public function getItamDataById($id)
    {
        return $this->db->get_where('monitoringassets_dataitam', array('id' => $id));
    }
}
