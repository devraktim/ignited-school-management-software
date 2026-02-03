<?php
    defined('BASEPATH') OR exit('No direct script access allowed');

    class ExamAttendence extends CI_Model {

        public function attendence_store($rows) {
            foreach($rows as $row) {
                $clauses = [
                    "class_id"      => $row["class_id"],
                    "section_id"    => $row["section_id"],
                    "exam_id"       => $row["exam_id"],
                    "student_id"    => $row["student_id"],
                    "session_id"    => $this->session->academy_session['current_session']['id']
                ];

                $r = $this->db->where($clauses)->get("students_exam_attendence")->row_array();

                if($r) {
                    $this->db->where($clauses)->update("students_exam_attendence", ["present" => $row["present"], "total_days" => $row["total_days"]]);
                }
                else {
                    $this->db->insert("students_exam_attendence", $row);
                }
            }
        }

        public function get_attendence($clauses) {
            $clauses["session_id"] = $this->session->academy_session['current_session']['id'];
            
            $row = $this->db->where($clauses)->get("students_exam_attendence")->row_array();
            return $row ? [
                "present" => $row["present"],
                "total_days" => $row["total_days"]
            ] : "";
        }
        
        public function get_student_attendence_percentage($class_id, $exam_id, $student_id) {
            $row = $this->db->where([
                "class_id"      => $class_id,
                "exam_id"       => $exam_id,
                "student_id"    => $student_id,
                "session_id"    => $this->session->academy_session['current_session']['id'] ?? 1
            ])->get("students_exam_attendence")->row_array();

            $percentage = ($row["present"] / $row["total_days"]) * 100;
            return number_format($percentage);
        }

    }