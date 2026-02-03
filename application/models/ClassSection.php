<?php
    defined('BASEPATH') OR exit('No direct script access allowed');

    class ClassSection extends CI_Model {

        private $table = "session_class_sections";

        public function get($id = NULL) {
            if($id) {
                return $this->db->where(["id" => $id, "deleted" => 0])->get($this->table)->row_array();
            }
            else {
                return $this->db->select("classes.name as class, sections.name as section")
                                ->from($this->table)
                                ->join("classes", "classes.id = session_class_sections.class_id")
                                ->join("sections", "sections.id = session_class_sections.section_id")
                                ->where(["session_class_sections.deleted" => 0, "session_class_sections.session_id" => $this->session->user["academy_session_id"]])
                                ->get()
                                ->result_array();
            }
        }
        
        public function get_where($clauses) {
            return $this->db->select("classes.name as class, sections.name as section")
                ->from($this->table)
                ->join("classes", "classes.id = session_class_sections.class_id")
                ->join("sections", "sections.id = session_class_sections.section_id")
                ->where($clauses)
                ->get()
                ->result_array();
        }

        public function get_sections($session_id, $class_id) {
            $clauses["deleted"] = 0;
            return $this->db->select("sections.*, session_class_sections.id as class_section_id")
                            ->from($this->table)
                            ->join("sections", "session_class_sections.section_id = sections.id")
                            ->where(array("session_id" => $session_id, "class_id" => $class_id, "session_class_sections.deleted" => 0))
                            ->get()
                            ->result_array();
        }

        public function insert($data) {
            return $this->db->insert($this->table, $data);
        }
        
        public function copy_data($session_id) {
            $records = $this->db ->from($this->table)
                ->where(["deleted" => 0, "session_id" => 1])
                ->get()
                ->result_array();
            
            $data = [];
            
            foreach($records as $record) {
                $d = $record;
                
                $d["session_id"] = $session_id;
                    
                unset($d["id"]);
                 
                $data[] = $d;
            }

            return $this->db->insert_batch($this->table, $data);
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