<?php
    defined('BASEPATH') OR exit('No direct script access allowed');

    class Result extends CI_Model {
        
        public function store_result($records) {
            foreach ($records as $record) {
                $this->db->where([
                    'class_id'    => $record['class_id'],
                    'section_id'  => $record['section_id'],
                    'session_id'  => $record['session_id'],
                    'student_id'  => $record['student_id'],
                    'exam_id'     => $record['exam_id']
                ]);
                
                $query = $this->db->get('student_results');
        
                if ($query->num_rows() > 0) {
                    // Update existing record
                    $this->db->where([
                        'class_id'    => $record['class_id'],
                        'section_id'  => $record['section_id'],
                        'session_id'  => $record['session_id'],
                        'student_id'  => $record['student_id'],
                        'exam_id'     => $record['exam_id']
                    ]);
                    $this->db->update('student_results', $record);
                } else {
                    // Insert new record
                    $this->db->insert('student_results', $record);
                }
            }
        }
        
        public function get_result($data) {
            $this->db->where([
                'class_id'      => $data['class_id'],
                'username'      => $data['username'],
                'password'      => $data['password'],
                'session_id'    => 1,
                'exam_id'       => 4
            ]);
            
            $query = $this->db->get('student_results');
            
            if ($query->num_rows() > 0) {
                return $query->row_array();
            }
            else {
                return null;
            }
        }

    }