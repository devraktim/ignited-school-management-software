<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class EmployeeAttendance extends CI_Model {

    public function saveAttendance($data)
    {
        $employee_id = $data['employee_id'];
        $session     = $data['session'];
        $datetime    = $data['attendance_date'];
        $dateOnly    = date('Y-m-d', strtotime($datetime));
    
        // Common WHERE condition
        $where = [
            'employee_id' => $employee_id,
            'session'     => $session
        ];
    
        // Check if record exists for the same DATE
        $this->db->where($where);
        $this->db->where(
            "DATE(attendance_date) = ".$this->db->escape($dateOnly),
            null,
            false
        );
    
        $query = $this->db->get('employee_attendance_store');
    
        if ($query->num_rows() > 0) {
    
            // Apply SAME where condition for update
            $this->db->where($where);
            $this->db->where(
                "DATE(attendance_date) = ".$this->db->escape($dateOnly),
                null,
                false
            );
    
            return $this->db->update('employee_attendance_store', $data);
        }
    
        return $this->db->insert('employee_attendance_store', $data);
    }


    public function getEmployees() {
        // Fetch employee records from the database
        $query = $this->db->get('employees'); // Adjust according to your employee table name
        return $query->result_array();
    }

    public function getDesignations() {
        // Fetch designations from the database
        $query = $this->db->get('designations'); // Adjust according to your designations table
        return $query->result_array();
    }
    
    public function getAttendanceByEmployeeAndDate($employee_id, $session, $date = null) {
        $this->db->where('employee_id', $employee_id);
        $this->db->where('session', $session);
        
        if ($date) {
             $this->db->where('DATE(attendance_date)', $date);
        }
    
        $query = $this->db->get('employee_attendance_store'); // Adjust according to your attendance table name
        
        // echo $this->db->last_query();
        // exit();
       
        return $query->row_array(); // Return a single attendance record or null if not found
    }
    
    // public function attendanceExists($employee_id, $session, $date) {
    //     $this->db->where('employee_id', $employee_id);
    //     $this->db->where('session', $session);
    //     $this->db->where('attendance_date', $date);
    //     $query = $this->db->get('employee_attendance_store'); // Adjust according to your table name
    
    //     return $query->num_rows() > 0; // Returns true if a record exists
    // }
    
    // public function updateAttendance($employee_id, $session, $date, $data) {
    //     $this->db->where('employee_id', $employee_id);
    //     $this->db->where('session', $session);
    //     $this->db->where('attendance_date', $date);
    //     return $this->db->update('employee_attendance_store', $data); // Adjust according to your table name
    // }
}
