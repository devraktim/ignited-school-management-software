<?php
    defined('BASEPATH') OR exit('No direct script access allowed');

    class Remarks extends CI_Model {

        public function remarks_store($rows) {
            foreach($rows as $row) {
                $clauses = [
                    "class_id"      => $row["class_id"],
                    "section_id"    => $row["section_id"],
                    "exam_id"       => $row["exam_id"],
                    "student_id"    => $row["student_id"],
                    "session_id"    => $this->session->academy_session['current_session']['id']
                ];

                $r = $this->db->where($clauses)->get("students_remark")->row_array();

                if($r) {
                    $this->db->where($clauses)->update("students_remark", ["remark" => $row["remark"]]);
                }
                else {
                    $this->db->insert("students_remark", $row);
                }
            }
        }

        public function get_remark($clauses) {
            $clauses["session_id"] = $this->session->academy_session['current_session']['id'];
            
            $row = $this->db->where($clauses)->get("students_remark")->row_array();
            return $row ? $row["remark"] : "";
        }

        public function get_student_remarks($class_id, $exam_id, $student_id) {
            $clauses = [
                "class_id"      => $class_id,
                "exam_id"       => $exam_id,
                "student_id"    => $student_id,
                "session_id"    => $this->session->academy_session['current_session']['id'] ?? 1
            ];
            
            $row = $this->db->where($clauses)->get("students_remark")->row_array();
            return $row ? $row["remark"] : "";
        }
    }