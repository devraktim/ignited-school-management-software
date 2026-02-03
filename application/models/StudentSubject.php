<?php
    defined('BASEPATH') OR exit('No direct script access allowed');

    class StudentSubject extends CI_Model {

        private $table = "student_subjecttype_subjects";

        public function get($id = NULL) {
            if($id) {
                return $this->db->where(["id" => $id])->get($this->table)->row_array();
            }
            else {
                return $this->db->where("deleted", 0)->get($this->table)->result_array();
            }
        }
        
        public function get_where_v2($clauses) {
            return $this->db->where($clauses)->get($this->table)->result_array();
        }
        
        public function get_where($clauses) {
            return $this->db->where($clauses)->get($this->table)->row_array();
        }

        public function get_students($clauses) {
            
            $academy_class_id = $clauses['academy_class_id'];
            $section_id = $clauses['section_id'];
            
            unset($clauses['academy_class_id']);
            unset($clauses['section_id']);
            
            $clauses['student_subjecttype_subjects.academy_class_id'] = $academy_class_id;
            $clauses['student_subjecttype_subjects.section_id'] = $section_id;
            
            
            // Fetch the sort by value from settings table
            $sort_by = $this->db->from("settings")->where("key_name", "student_sort_by")->get()->row_array();
            
            // Build the base query
            $base_query = $this->db
                ->select("student_subjecttype_subjects.*")
                ->from("students")
                ->join("student_subjecttype_subjects", "student_subjecttype_subjects.student_id = students.id")
                ->where($clauses);
            
            // Apply additional conditions or joins if needed for student_subjecttype_subjects
            
            // Apply sorting based on $sort_by['value']
            if ($sort_by && isset($sort_by['value'])) {
                switch ($sort_by['value']) {
                    case "student_no":
                        $base_query->order_by('students.student_no', 'ASC');
                        break;
                    case "first_name":
                        $base_query->order_by('students.f_name', 'ASC');
                        break;
                    case "last_name":
                        $base_query->order_by('students.l_name', 'ASC');
                        break;
                    case "day_scholar":
                        // Prioritize student_type_id = 1 (day scholars)
                        $base_query->order_by('students.student_type_id', 'ASC');
                        break;
                    case "boarders":
                        // Prioritize student_type_id = 3 (boarders)
                        $base_query->order_by('students.student_type_id', 'DESC');
                        break;
                    default:
                        // Default sorting if no specific sorting is applied
                        break;
                }
            }
            
            // Execute the final query and fetch results
            $records = $base_query->get()->result_array();
        
            return $records;
            
            // return $this->db->where($clauses)->get($this->table)->result_array();
        }

        public function insert($data) {
            return $this->db->insert($this->table, $data);
        }
        
        public function copy_data($session_id) {
            $records = $this->db->where(["current_session_id" => 1])->get($this->table)->result_array();
            
            $data = [];
            
            foreach($records as $record) {
                $d = $record;
                
                $d["current_session_id"] = $session_id;
                
                unset($d["id"]);
                
                $data[] = $d;
            }
            
            return $this->db->insert_batch($this->table, $data);
        }

        public function insert_batch($data) {
            return $this->db->insert_batch($this->table, $data);
        }

        public function update($id, $data) {
            return $this->db->where(["id" => $id, "deleted" => 0])->update($this->table, $data);
        }

        public function insert_or_update_batch($data) {
            
            foreach($data as $record) {
                $saved_record = $this->db->where([
                    "student_id"            => $record["student_id"], 
                    "subject_type_id"       => $record["subject_type_id"],
                    "academy_class_id"      => $record["academy_class_id"],
                    "section_id"            => $record["section_id"],
                    "current_session_id"    => $record["current_session_id"],
                ])->get($this->table)->row_array();
                
                if($saved_record) {
                    $this->db->where(["id" => $saved_record["id"]])->update($this->table, $record);
                }
                else {
                    $this->db->insert($this->table, $record);
                }
            }
            return;
        }
        

        public function delete($id) {
            return $this->db->where("id", $id)->update($this->table, ["deleted" => 1]);
        }

        public function restore($id) {
            return $this->db->where("id", $id)->update($this->table, ["deleted" => 0]);
        }

    }