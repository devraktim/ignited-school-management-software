<?php
    defined('BASEPATH') OR exit('No direct script access allowed');

    class ExamPaper extends CI_Model {

        private $table = "exam_papers";

        public function get($id = NULL) {
            if($id) {
                return $this->db->where("id", $id)->get($this->table)->row_array();
            }
            else {
                return $this->db->from($this->table)->where('session_id', $this->session->academy_session["current_session"]["id"])->get()->result_array();
            }
        }

        public function get_where($clauses) {
            $clauses["session_id"] = $this->session->academy_session["current_session"]["id"];

            return $this->db->where($clauses)->get($this->table)->row_array();
        }
        
        public function copy_data($session_id) {
            $records = $this->db->from($this->table)->where('session_id', 1)->get()->result_array();
            
            $data = [];
            
            foreach($records as $record) {
                $d = $record;
                
                $d["session_id"] = $session_id;
                
                unset($d["id"]);
                
                $data[] = $d;
            }
            
            return $this->db->insert_batch($this->table, $data);
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
            
            $data["session_id"] = $this->session->academy_session["current_session"]["id"];
            return $this->db->insert($this->table, $data);
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