<?php
    defined('BASEPATH') OR exit('No direct script access allowed');

    class WithdrawnReason extends CI_Model {

        private $table = "withdrawn_reasons";

        public function get($id = NULL) {
            if($id) {
                return $this->db->where(["id" => $id, "deleted" => 0])->get($this->table)->row_array();
            }
            else {
                return $this->db->where("deleted", 0)->get($this->table)->result_array();
            }
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
        
        public function new_withdrawn($data) {
            $this->db->insert("withdrawn_students", $data);
            return $this->db->where([
                "class_id"   => $data['class_id'], 
                "section_id" => $data['section_id'], 
                "session_id" => $data['session_id'],
                "student_id" => $data['student_id']])->update("student_session", ["withdraw" => 1]);
        }
        
        public function get_withdrawn_students($data) {
            
            $data["session_id"] = $this->session->academy_session['current_session']['id'];
          
            return $this->db->select("students.f_name as f_name, 
                                        students.m_name as m_name, 
                                        students.l_name as l_name, 
                                        students.student_no as student_no, 
                                        students.roll_no as roll_no, 
                                        withdrawn_students.*")
                                    ->from("withdrawn_students")
                                    ->join("students", "students.id = withdrawn_students.student_id")
                                    ->where($data)
                                    ->get()
                                    ->result_array();
        }
        
        public function get_all_withdrawn_students($data) {
            
            return $this->db->select("students.f_name as f_name, 
                                    students.m_name as m_name, 
                                    students.l_name as l_name, 
                                    students.student_no as student_no, 
                                    students.roll_no as roll_no, 
                                    withdrawn_students.*")
                                    ->from("withdrawn_students")
                                    ->join("students", "students.id = withdrawn_students.student_id")
                                    ->where($data)
                                    ->get()
                                    ->result_array();
        }
        
        public function get_withdrawn_students_saved_data($student_id) {
            return $this->db->where("student_id", $student_id)->get("withdrawn_students")->result();
        }
        
        public function update_withdrawn_students($student_id, $data) {
            return $this->db->where("student_id", $student_id)->update("withdrawn_students", $data);
        }
        
        public function delete_withdrawn_student($id) {
            
            $academy_session_id = $this->session->academy_session['current_session']['id'];
            
            $data = $this->db->where(["id" => $id])->get("withdrawn_students")->row_array();
            
            $this->db->delete('withdrawn_students', array('id' => $id));
            
            $this->db->where(["student_id" => $data['student_id'], "session_id" => $academy_session_id])->update("student_session", ['withdraw' => 0]);
        }
    }