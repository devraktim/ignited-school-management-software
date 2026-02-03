<?php
    defined('BASEPATH') OR exit('No direct script access allowed');

    class Marks extends CI_Model {

        // Grade Entry
        public function grade_store($rows) {
            foreach($rows as $row) {
                $clauses = [
                    "class_id"      => $row["class_id"],
                    "section_id"    => $row["section_id"],
                    "exam_id"       => $row["exam_id"],
                    "subject_id"    => $row["subject_id"],
                    "student_id"    => $row["student_id"],
                    "session_id"    => $this->session->academy_session['current_session']['id']
                ];

                $r = $this->db->where($clauses)->get("students_grade")->row_array();

                if($r) {
                    $this->db->where($clauses)->update("students_grade", ["grade" => $row["grade"]]);
                }
                else {
                    $this->db->insert("students_grade", $row);
                }
            }
        }

        public function get_grade($clauses) {
            $clauses["session_id"] = $this->session->academy_session['current_session']['id'];
            
            $row = $this->db->where($clauses)->get("students_grade")->row_array();
            return $row ? $row["grade"] : "";
        }
        
        public function get_student_grade($class_id, $exam_id, $subject_id, $student_id) {
            $row = $this->db->where([
                "class_id"      => $class_id,
                "exam_id"       => $exam_id,
                "subject_id"    => $subject_id,
                "student_id"    => $student_id,
                "session_id"    => $this->session->academy_session['current_session']['id']
            ])->get("students_grade")->row_array();
            
            return $row ? $row["grade"] : "";
        }
        
        // Marks Entry
        public function marks_store($rows) {
            foreach($rows as $row) {
                $clauses = [
                    "class_id"      => $row["class_id"],
                    "section_id"    => $row["section_id"],
                    "exam_id"       => $row["exam_id"],
                    "subject_id"    => $row["subject_id"],
                    "student_id"    => $row["student_id"],
                    "session_id"    => $this->session->academy_session['current_session']['id']
                ];

                $r = $this->db->where($clauses)->get("students_marks")->row_array();

                if($r) {
                    $this->db->where($clauses)->update("students_marks", ["marks" => $row["marks"]]);
                }
                else {
                    $this->db->insert("students_marks", $row);
                }
            }
        }

        public function get_marks($clauses) {
            $clauses["session_id"] = $this->session->academy_session['current_session']['id'];
            
            $row = $this->db->where($clauses)->get("students_marks")->row_array();
            return $row ? $row["marks"] : "";
        }
        
        public function get_student_marks($class_id, $exam_id, $subject_id, $student_id) {
            $row =  $this->db->where([
                "class_id"      => $class_id,
                "exam_id"       => $exam_id,
                "subject_id"    => $subject_id,
                "student_id"    => $student_id,
                "session_id"    => $this->session->academy_session['current_session']['id']
            ])->get("students_marks")->row_array();
            
            return $row["marks"];
        }
        
        public function get_student_marks_by_subject_type($class_id, $student_id, $exam_id, $subject_type_id) {
            
            $student_subject = $this->StudentSubject->get_where([
                "student_id"            => $student_id,
                "academy_class_id"      => $class_id,
                "subject_type_id"       => $subject_type_id,
                "current_session_id"    => $this->session->academy_session["current_session"]["id"] ?? 1
            ]);
            
            $row =  $this->db->where([
                "class_id"      => $class_id,
                "exam_id"       => $exam_id,
                "subject_id"    => $student_subject['subject_id'],
                "student_id"    => $student_id,
                "session_id"    => $this->session->academy_session['current_session']['id'] ?? 1
            ])->get("students_marks")->row_array();
            
            return $row["marks"];
            
        }
        
        // Evolution
        public function evolution_store($rows) {
            foreach($rows as $row) {
                $clauses = [
                    "class_id"      => $row["class_id"],
                    "section_id"    => $row["section_id"],
                    "exam_id"       => $row["exam_id"],
                    "student_id"    => $row["student_id"],
                    "session_id"    => $this->session->academy_session['current_session']['id'] ?? 1
                ];

                $r = $this->db->where($clauses)->get("students_evolution")->row_array();

                if($r) {
                    $this->db->where($clauses)->update("students_evolution", ["grade" => $row["grade"]]);
                }
                else {
                    $this->db->insert("students_evolution", $row);
                }
            }
        }

        public function get_evolution($clauses) {
            $clauses["session_id"] = $this->session->academy_session['current_session']['id'];
            
            $row = $this->db->where($clauses)->get("students_evolution")->row_array();
            return $row ? $row["grade"] : "";
        }
        
        public function get_student_evolution($class_id, $exam_id, $student_id) {
            $row =  $this->db->where([
                "class_id"      => $class_id,
                "exam_id"       => $exam_id,
                "student_id"    => $student_id,
                "session_id"    => $this->session->academy_session['current_session']['id'] ?? 1
            ])->get("students_evolution")->row_array();
            
            return $row["grade"];
        }

    }