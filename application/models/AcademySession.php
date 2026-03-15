<?php
    defined('BASEPATH') OR exit('No direct script access allowed');

    class AcademySession extends CI_Model {

        private $table = "sessions";

        public function get($id = NULL) {
            if($id) {
                return $this->db->from($this->table)->where(["id" => $id, "deleted" => 0])->order_by("start", "desc")->get()->row_array();
            }
            else {
                return $this->db->where("deleted", 0)->get($this->table)->result_array();
            }
        }

        public function insert($data) {
            $this->db->insert($this->table, $data);
            return $this->db->insert_id();
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

        public function get_previous_session($id) {
            $current = $this->db
                ->where(["id" => $id, "deleted" => 0])
                ->limit(1)
                ->get($this->table)
                ->row_array();

            if(!$current) {
                return NULL;
            }

            return $this->db
                ->where("deleted", 0)
                ->where("start <", $current['start'])
                ->order_by("start", "DESC")
                ->limit(1)
                ->get($this->table)
                ->row_array();
        }

        public function get_next_session($id) {
            $current = $this->db
                ->where(["id" => $id, "deleted" => 0])
                ->limit(1)
                ->get($this->table)
                ->row_array();

            if(!$current) {
                return NULL;
            }

            return $this->db
                ->where("deleted", 0)
                ->where("start >", $current['start'])
                ->order_by("start", "ASC")
                ->limit(1)
                ->get($this->table)
                ->row_array();
        }
    }