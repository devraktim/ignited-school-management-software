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

       public function get_active_non_user_employee()
        {
            $this->db->select('employees.*');
            $this->db->from('employees');

            $this->db->join(
                'users',
                'users.employee_id = employees.id',
                'left'
            );

            $this->db->join(
                'employee_resignations',
                'employee_resignations.employee_id = employees.id',
                'left'
            );

            $this->db->join(
                'employee_retires',
                'employee_retires.employee_id = employees.id',
                'left'
            );

            // Employee must be active
            $this->db->where('employees.status', 'ACTIVE');

            // Employee must not be deleted
            $this->db->where('employees.deleted', 0);

            // No user account
            $this->db->where('users.employee_id IS NULL', null, false);

            // Not resigned
            $this->db->where('employee_resignations.employee_id IS NULL', null, false);

            // Not retired
            $this->db->where('employee_retires.employee_id IS NULL', null, false);

            return $this->db->get()->result_array();
        }
    }