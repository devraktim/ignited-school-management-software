<?php
    defined('BASEPATH') OR exit('No direct script access allowed');

    class User extends CI_Model {

        private $table = "users";

        public function insert($data) {
            return $this->db->insert($this->table, $data);
        }

        public function update($id, $data) {
            return $this->db->where(["id" => $id])->update($this->table, $data);
        }
        
        public function reset_password($id, $data) {
            return $this->db->where(["employee_id" => $id])->update($this->table, $data);
        }

        public function get($username) {
            return $this->db->where('username', $username)->get($this->table)->row();
        }
        
        public function get_permissions($id) {
            return $this->db->where('employee_id', $id)->get("permissions")->result_array();
        }
    }