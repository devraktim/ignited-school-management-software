<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Holiday extends CI_Model {

    private $table = "holidays";

    public function get_all() {
        return $this->db->order_by("holiday_date", "ASC")->get($this->table)->result_array();
    }

    public function insert($data) {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    public function update($id, $data) {
        return $this->db->where("id", $id)->update($this->table, $data);
    }

    public function delete($id) {
        return $this->db->where("id", $id)->delete($this->table);
    }
    
    public function is_holiday($date)
    {
        $row = $this->db
            ->select('name')
            ->where('holiday_date', $date)
            ->get($this->table)
            ->row_array();
    
        return $row ? $row['name'] : false;
    }
}
