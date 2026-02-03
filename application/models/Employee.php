<?php
    defined('BASEPATH') OR exit('No direct script access allowed');

    class Employee extends CI_Model {

        private $table = "employees";

        public function get($id = NULL) {
            if($id) {
                return $this->db->select("employees.*, 
                                          categories.name as category,
                                          religions.name as religion,
                                          nationalities.name as nationality,
                                          departments.name as department,
                                          employee_types.name as emp_type,
                                          job_status.name as job_status,
                                          designations.name as designation,
                                        ")
                                ->from($this->table)
                                ->join("categories",    "employees.category_id = categories.id")
                                ->join("religions",     "employees.religion_id = religions.id")
                                ->join("nationalities", "employees.nationality_id = nationalities.id")
                                ->join("departments",   "employees.department_id = departments.id")
                                ->join("employee_types","employees.emp_type_id = employee_types.id")
                                ->join("job_status",    "employees.job_status_id = job_status.id")
                                ->join("designations",  "employees.designation_id = designations.id")
                                ->where(["employees.id" => $id, "employees.deleted" => 0])
                                ->get()
                                ->row_array();

                // return $this->db->where(["id" => $id, "deleted" => 0])->get($this->table)->row_array();
            }
            else {
                return $this->db->where("deleted", 0)->where('id !=', 1)->get($this->table)->result_array();
            }
        }
        
        public function get_where($clauses) {
            $records = $this->db
                ->select("employees.*")
                ->from($this->table)
                ->where('id !=', 1)
                ->where($clauses)
                ->get()
                ->result_array();
                
            return $records;
        }

        public function search($parameteres) {
            $parameteres["deleted"] = 0;
            $employees = $this->db->where($parameteres)->where('id !=', 1)->get($this->table)->result_array();

            for($i = 0 ; $i < count($employees) ; $i++) {
                $employees[$i] = $this->get($employees[$i]["id"]);
            }

            return $employees;
        }

        
        public function insert($data) {
            return $this->db->insert($this->table, $data);
        }

        public function update($id, $data) {
            return $this->db->where(["id" => $id, "deleted" => 0])->update($this->table, $data);
        }

        public function delete($id) {
            return $this->db->where("id", $id)->update($this->table, ["deleted" => 1]);
        }

        public function restore($id) {
            return $this->db->where("id", $id)->update($this->table, ["deleted" => 0]);
        }
        
        public function get_retired_employee() {
            $data = $this->db->select("employee_retires.*")->from("employee_retires")->get()->result_array();
            $records = [];
            
            foreach($data as $d) {
                $r = $this->Employee->get($d['employee_id']);    
                $r['retired_date'] = $d['date'];
                
                $records[] = $r; 
            }
            
            return $records;
        }
        
        public function store_retirement($data) {
            return $this->db->insert('employee_retires', $data);
        }
    
        public function get_resigned_employee() {
            $data = $this->db->select("employee_resignations.*")->from("employee_resignations")->get()->result_array();
            $records = [];
            
            foreach($data as $d) {
                $r = $this->Employee->get($d['employee_id']);    
                $r['resigned_date'] = $d['date'];
                $r['resigned_reason'] = $d['reason'];
                
                $records[] = $r;    
            }
            
            return $records;
        }

        public function store_resignation($data) {
            return $this->db->insert('employee_resignations', $data);
        }
    }