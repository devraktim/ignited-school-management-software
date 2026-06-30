<?php
class Teachers extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->auth();

        if ($this->role != 'student') {
            $this->error('FORBIDDEN','Only student allowed',403);
        }
    }

    // public function index()
    // {
    //     $teachers = $this->db
    //         ->where('status','ACTIVE')
    //         ->get('employees')
    //         ->result();

    //     $data=[];

    //     foreach($teachers as $t){
    //         $data[]=[
    //             "id"=>"t".$t->id,
    //             "name"=>$t->f_name." ".$t->l_name,
    //             "subject"=>"N/A"
    //         ];
    //     }

    //     $this->success(["teachers"=>$data]);
    // }

    public function index()
    {
        // Only for student
        if ($this->role != 'student') {
            $this->error('FORBIDDEN', 'Only students can access this');
        }

        // Step 1: Get student
        $student = $this->db
            ->get_where('students', ['id' => $this->user_id])
            ->row();

        if (!$student) {
            $this->error('NOT_FOUND', 'Student not found');
        }

        // Step 2: Get assigned class teachers
        $this->db->select('employees.id, employees.f_name, employees.l_name');
        $this->db->from('class_section_employee');
        $this->db->join('employees', 'employees.id = class_section_employee.employee_id');
        $this->db->where('class_section_employee.class_id', $student->class_id);
        $this->db->where('class_section_employee.section_id', $student->section_id);
        $this->db->where('employees.status', 'ACTIVE');

        $teachers = $this->db->get()->result();

        $data = [];

        foreach ($teachers as $t) {
            $data[] = [
                "id" => "t" . $t->id,
                "name" => $t->f_name . " " . $t->l_name,
                "subject" => "N/A"
            ];
        }

        $this->success(["teachers" => $data]);
    }
}