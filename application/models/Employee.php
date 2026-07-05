<?php
    defined('BASEPATH') OR exit('No direct script access allowed');

    class Employee extends CI_Model {

        private $table = "employees";

        public function get($id = NULL) {

            // Fetch personnel settings
            $settings = $this->db
                ->from("settings")
                ->where("module", "personnel")
                ->get()
                ->result_array();

            $config = [];
            foreach ($settings as $s) {
                $config[$s['key_name']] = $s['value'];
            }

            // Sorting map
            $sort_map = [
                "employee_code" => "emp_code",
                "first_name"    => "f_name",
                "last_name"     => "l_name"
            ];

            $sort_column = isset($sort_map[$config['employee_sort_by']]) 
                            ? $sort_map[$config['employee_sort_by']] 
                            : "emp_code";


            if($id) {

                $record = $this->db->select("employees.*, 
                                            categories.name as category,
                                            religions.name as religion,
                                            nationalities.name as nationality,
                                            departments.name as department,
                                            employee_types.name as emp_type,
                                            job_status.name as job_status,
                                            designations.name as designation")
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


                // Apply name display format
                if($record) {

                    $f = $record['f_name'];
                    $m = $record['m_name'];
                    $l = $record['l_name'];

                    switch($config['employee_name_display_format'] ?? "f_m_s") {

                        case "l_f_m":
                            $record['f_name'] = $l;
                            $record['m_name'] = $f;
                            $record['l_name'] = $m;
                            break;

                        case "l_m_f":
                            $record['f_name'] = $l;
                            $record['m_name'] = $m;
                            $record['l_name'] = $f;
                            break;
                    }
                }

                return $record;

            } 
            else {

                $this->db->select("employees.*, designations.name as designation_name")
                        ->from($this->table)
                        ->join("designations", "employees.designation_id = designations.id")
                        ->join("employee_retires", "employee_retires.employee_id = employees.id", "left")
                        ->join("employee_resignations", "employee_resignations.employee_id = employees.id", "left")
                        ->where("employees.deleted", 0);
                        // ->where("employees.id !=", 1);


                // Hide inactive employees
                if(isset($config['employee_display_inactive']) && $config['employee_display_inactive'] == 0) {
                    $this->db->where("employees.status", "ACTIVE");
                }

                // Hide retired employees
                if(isset($config['employee_display_retired']) && $config['employee_display_retired'] == 0) {
                    $this->db->where("employee_retires.id IS NULL");
                }

                // Hide resigned employees
                if(isset($config['employee_display_resigned']) && $config['employee_display_resigned'] == 0) {
                    $this->db->where("employee_resignations.id IS NULL");
                }

                // Apply sorting
                $this->db->order_by("employees.".$sort_column, "ASC");

                $records = $this->db->get()->result_array();


                // Apply name display format
                foreach($records as $i => $emp) {

                    $f = $emp['f_name'];
                    $m = $emp['m_name'];
                    $l = $emp['l_name'];

                    switch($config['employee_name_display_format'] ?? "f_m_s") {

                        case "l_f_m":
                            $records[$i]['f_name'] = $l;
                            $records[$i]['m_name'] = $f;
                            $records[$i]['l_name'] = $m;
                            break;

                        case "l_m_f":
                            $records[$i]['f_name'] = $l;
                            $records[$i]['m_name'] = $m;
                            $records[$i]['l_name'] = $f;
                            break;
                    }
                }

                return $records;
            }
        }
        
        public function get_where($clauses) {

            // Fetch personnel settings
            $settings = $this->db->from("settings")
                                ->where("module", "personnel")
                                ->get()
                                ->result_array();

            $config = [];
            foreach ($settings as $s) {
                $config[$s['key_name']] = $s['value'];
            }

            $this->db->select("employees.*")
                    ->from($this->table)
                    ->join("employee_retires", "employee_retires.employee_id = employees.id", "left")
                    ->join("employee_resignations", "employee_resignations.employee_id = employees.id", "left")
                    ->where("employees.id !=", 1)
                    ->where($clauses);

            // Hide inactive employees
            if(isset($config['employee_display_inactive']) && $config['employee_display_inactive'] == 0) {
                $this->db->where("employees.status", "ACTIVE");
            }

            // Hide retired employees
            if(isset($config['employee_display_retired']) && $config['employee_display_retired'] == 0) {
                $this->db->where("employee_retires.id IS NULL");
            }

            // Hide resigned employees
            if(isset($config['employee_display_resigned']) && $config['employee_display_resigned'] == 0) {
                $this->db->where("employee_resignations.id IS NULL");
            }

            $records = $this->db->get()->result_array();

            // Apply name format
            foreach($records as $i => $emp) {

                $f = $emp['f_name'];
                $m = $emp['m_name'];
                $l = $emp['l_name'];

                switch($config['employee_name_display_format'] ?? "f_m_s") {

                    case "l_f_m":
                        $records[$i]['f_name'] = $l;
                        $records[$i]['m_name'] = $f;
                        $records[$i]['l_name'] = $m;
                        break;

                    case "l_m_f":
                        $records[$i]['f_name'] = $l;
                        $records[$i]['m_name'] = $m;
                        $records[$i]['l_name'] = $f;
                        break;
                }
            }

            return $records;
        }


        public function search($parameters) {

            // Fetch personnel settings
            $settings = $this->db->from("settings")
                                ->where("module", "personnel")
                                ->get()
                                ->result_array();

            $config = [];
            foreach ($settings as $s) {
                $config[$s['key_name']] = $s['value'];
            }

            $parameters["deleted"] = 0;

            // Apply parameters only on employees table
            $employeeParams = [];
            foreach ($parameters as $key => $value) {
                $employeeParams["employees.$key"] = $value;
            }

            $this->db->from($this->table)
                    ->join("employee_retires", "employee_retires.employee_id = employees.id", "left")
                    ->join("employee_resignations", "employee_resignations.employee_id = employees.id", "left")
                    ->where($employeeParams)
                    ->where("employees.id !=", 1);

            // Hide inactive employees
            if(isset($config['employee_display_inactive']) && $config['employee_display_inactive'] == 0) {
                $this->db->where("employees.status", "ACTIVE");
            }

            // Hide retired employees
            if(isset($config['employee_display_retired']) && $config['employee_display_retired'] == 0) {
                $this->db->where("employee_retires.id IS NULL", null, false);
            }

            // Hide resigned employees
            if(isset($config['employee_display_resigned']) && $config['employee_display_resigned'] == 0) {
                $this->db->where("employee_resignations.id IS NULL", null, false);
            }
            
            $data = [];
            $employees = $this->db->get()->result_array();

            for($i = 0 ; $i < count($employees) ; $i++) {
                $data[$i] = $this->get($employees[$i]["id"]);
            }

            return $employees; // return all results
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