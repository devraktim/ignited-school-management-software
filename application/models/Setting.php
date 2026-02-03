<?php
    defined('BASEPATH') OR exit('No direct script access allowed');

    class Setting extends CI_Model {

        private $table = "settings";

        public function get($module) {
            return $this->db->where("module", $module)->get($this->table)->result_array();
        }

        public function insert($data) {
            return $this->db->insert($this->table, $data);
        }

        public function insert_or_update($data) {
            
            for($i = 0; $i < count($data); $i++) {
                $setting = $this->db->where(["module" => $data[$i]["module"], "key_name" => $data[$i]["key_name"]])->get($this->table)->row_array();

                if($setting) {
                    $this->db->where("id", $setting['id'])->update($this->table, $data[$i]);
                }
                else {
                    $this->db->insert($this->table, $data[$i]);
                }
            }
        }

        public function update($id, $data) {
            return $this->db->where(["id" => $id, "deleted" => 0])->update($this->table, $data);
        }

        public function delete($id) {
            return $this->db->where("id", $id)->update($this->table, ["deleted" => 1]);
        }
        
        public function delete_module($id) {
            return $this->db->where("module", "fees")->delete($this->table); 
        }
        
        public function restore($id) {
            return $this->db->where("id", $id)->update($this->table, ["deleted" => 0]);
        }

    }