<?php
    defined('BASEPATH') OR exit('No direct script access allowed');

    class EvolutionPaper extends CI_Model {

        private $table = "evolution_papers";

        public function get($id = NULL) {
            if($id) {
                return $this->db->where("id", $id)->get($this->table)->row_array();
            }
            else {
                return $this->db->from($this->table)->where('session_id', $this->session->academy_session["current_session"]["id"])->get()->result_array();
            }
        }

        public function get_where($clauses) {
            $clauses["session_id"] = $this->session->academy_session["current_session"]["id"] ?? 1;

            return $this->db->where($clauses)->get($this->table)->row_array();
        }

        public function get_exams($clauses) {
            $clauses["session_id"] = $this->session->academy_session["current_session"]["id"];

            return $this->db->where($clauses)->get($this->table)->result_array();
        }

        public function get_subjects($clauses) {
            $clauses["session_id"] = $this->session->academy_session["current_session"]["id"];

            return $this->db->where($clauses)->get($this->table)->result_array();
        }

        public function insert($data) {
            
            $match = $this->db->where([
                "class_id" => $data["class_id"], 
                "exam_id" => $data["exam_id"], 
                "session_id" => $this->session->academy_session["current_session"]["id"]
            ])->get($this->table)->row_array();
            
            if($match) {
                
                $prev_subjects = explode(",", $match['subjects']); // Split the string into an array
                $new_subjects = is_array($data) ? $data : explode(",", $data); // Ensure $data is an array
                
                // Merge the arrays and remove duplicates
                $merged_subjects = array_unique(array_merge($prev_subjects, $new_subjects));
                
                // Optionally trim whitespace from each element
                $merged_subjects = array_map('trim', $merged_subjects);
                
                // Implode back into a comma-separated string
                $final_subjects = implode(",", $merged_subjects);
            
                $match["subjects"] = $final_subjects;
                
                return $this->db->where("id", $match["id"])->update($this->table, $match);
            }
            
            else {
                $data["session_id"] = $this->session->academy_session["current_session"]["id"];
                return $this->db->insert($this->table, $data);
            }
            
        }

        public function update($id, $data) {
            return $this->db->where("id", $id)->update($this->table, $data);
        }

        public function search($clauses) {

            $clauses["session_id"] = $this->session->academy_session["current_session"]["id"];

            return $this->db->select("*")
                            ->from($this->table)
                            ->where($clauses)
                            ->get()
                            ->result_array();
        }

        public function delete($id) {
            return $this->db->where("id", $id)->delete($this->table);
        }
    }