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

        public function insert_or_update($data = [])
        {
            if (empty($data)) {
                return true;
            }

            $this->db->trans_start();

            foreach ($data as $row) {

                $record = $this->db
                    ->where([
                        'class_id'   => $row['class_id'],
                        'section_id' => $row['section_id'],
                        'session_id' => $row['session_id']
                    ])
                    ->get($this->table)
                    ->row();

                if ($record) {

                    $this->db
                        ->where('id', $record->id)
                        ->update($this->table, [
                            'employee_id' => $row['employee_id']
                        ]);

                } else {

                    $this->db->insert($this->table, $row);

                }
            }

            $this->db->trans_complete();

            return $this->db->trans_status();
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

        public function am_i_class_teacher($class_id, $section_id)
        {
            $user = $this->session->userdata('user');

            if (empty($user) || empty($user['employee_id'])) {
                return false;
            }

            $record = $this->db
                ->where([
                    'class_id'      => $class_id,
                    'section_id'    => $section_id,
                    'employee_id'   => $user['employee_id'],
                    'session_id'    => $this->session->academy_session["current_session"]["id"]
                ])
                ->get($this->table)
                ->row();

            return !empty($record);
        }

    }