<?php
    defined('BASEPATH') OR exit('No direct script access allowed');

    class ClassTeacher extends CI_Model {

        private $table = "class_section_employee";

        public function get() {
            $records = $this->db->get($this->table)->result_array();

            $data = array();

            for($i = 0 ; $i < count($records) ; $i++) {

                $class = $this->AcademyClass->get($records[$i]["class_id"]);
                $section = $this->Section->get($records[$i]["section_id"]);
                $employee = $this->Employee->get($records[$i]["employee_id"]);

                $data[] = [
                    "id"             =>  $records[$i]['id'],
                    "class_id"       =>  $records[$i]["class_id"],
                    "section_id"     =>  $records[$i]["section_id"],
                    "employee_id"    =>  $records[$i]["employee_id"],
                    "class"          =>  $class['name'],  
                    "section"        =>  $section['name'],
                    "employee_name"  =>  $employee['f_name']. " " . $employee['m_name']. " " . $employee['l_name']
                ];

            }

            return $data;
        }

        public function insert($data) {
            return $this->db->insert($this->table, $data);
        }

        public function insert_or_update($data) {
            
            for($i = 0; $i < count($data); $i++) {
                $record = $this->db->where([
                    "class_id" => $data[$i]["class_id"], 
                    "section_id" => $data[$i]["section_id"],
                ])
                ->get($this->table)
                ->row_array();

                if($record) {
                    $this->db->where("id", $record['id'])->update($this->table, $data[$i]);
                }
                else {
                    $this->db->insert($this->table, $data[$i]);
                }
            }
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

    }