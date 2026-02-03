<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Leave extends CI_Model {

    protected $table = "leaves";

    /**
     * Get single leave or all leaves
     */
    public function get($id = NULL)
    {
        if ($id) {
            return $this->db
                ->where("id", $id)
                ->get($this->table)
                ->row_array();
        }

        return $this->db
            ->order_by("id", "DESC")
            ->get($this->table)
            ->result_array();
    }

    /**
     * Get leaves by employee
     */
    public function getByEmployee($employee_id)
    {
        return $this->db
            ->where("employee_id", $employee_id)
            ->order_by("id", "DESC")
            ->get($this->table)
            ->result_array();
    }

    /**
     * Insert new leave application
     */
    public function insert($data)
    {
        return $this->db->insert($this->table, [
            'employee_id' => $data['employee_id'],
            'application' => $data['application'], // HTML / JSON / text
            'status'      => isset($data['status']) ? $data['status'] : 'PENDING'
        ]);
    }

    /**
     * Update leave application
     */
    public function update($id, $data)
    {
        return $this->db
            ->where("id", $id)
            ->update($this->table, $data);
    }

    /**
     * Change leave status
     */
    public function updateStatus($id, $status)
    {
        return $this->db
            ->where("id", $id)
            ->update($this->table, [
                'status' => $status
            ]);
    }

    /**
     * Delete leave permanently (optional)
     */
    public function delete($id)
    {
        return $this->db
            ->where("id", $id)
            ->delete($this->table);
    }
}
