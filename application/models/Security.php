<?php
    defined('BASEPATH') OR exit('No direct script access allowed');

    class Security extends CI_Model {

        private $table = "permissions";

        public function get($employee_id = NULL) {
            if($employee_id) {
                return $this->db->select("
                                    employees.id as employee_id,
                                    users.id as user_id,
                                    employees.emp_code,
                                    employees.f_name, 
                                    employees.m_name, 
                                    employees.l_name, 
                                    employees.status,
                                    employees.image, 
                                    users.username,
                                    departments.name as department,
                                    designations.name as designation,
                                    permissions.*"
                                )
                                ->from($this->table)
                                ->join("employees", "permissions.employee_id = employees.id")
                                ->join("users", "permissions.employee_id = users.employee_id")
                                ->join("departments", "employees.department_id = departments.id")
                                ->join("designations", "employees.designation_id = designations.id")
                                ->where(["employees.id" => $employee_id, "employees.deleted" => 0])
                                ->get()
                                ->row_array();
            }
            else {
                return $this->db->select("
                                    employees.id as employee_id,
                                    employees.f_name, 
                                    employees.m_name, 
                                    employees.l_name, 
                                    employees.status, 
                                    users.username, 
                                    permissions.*"
                                )
                                ->from($this->table)
                                ->join("employees", "permissions.employee_id = employees.id")
                                ->join("users", "permissions.employee_id = users.employee_id")
                                ->where("employees.deleted", 0)
                                ->get()
                                ->result_array();
            }
        }

        public function search($parameteres) {
           
            $parameteres["employees.deleted"] = 0;

            return $this->db->select("employees.f_name, employees.m_name, employees.l_name, employees.status, users.username, permissions.*")
                            ->from($this->table)
                            ->join("employees", "permissions.employee_id = employees.id")
                            ->join("users", "permissions.employee_id = users.employee_id")
                            ->where($parameteres)
                            ->get()
                            ->result_array();
        

        }

        public function insert($data) {
            return $this->db->insert($this->table, $data);
        }

        public function update($id, $data) {
            return $this->db->where("employee_id",  $id)->update($this->table, $data);
        }

    }