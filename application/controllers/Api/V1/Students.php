<?php
class Students extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->auth();

        if ($this->role != 'teacher') {
            $this->error('FORBIDDEN','Only teacher allowed',403);
        }
    }

    // public function index()
    // {
    //     $students = $this->db
    //         ->where('deleted',0)
    //         ->get('students')
    //         ->result();

    //     $data=[];

    //     foreach($students as $s){
    //         $data[]=[
    //             "id"=>"s".$s->id,
    //             "name"=>$s->f_name." ".$s->l_name,
    //             "class"=>"Class ".$s->class_id,
    //             "section"=>$s->section_id,
    //             "rollNumber"=>$s->student_no
    //         ];
    //     }

    //     $this->success(["students"=>$data]);
    // }

    public function index()
    {
        $students = $this->db
            ->select('students.id, students.f_name, students.l_name, students.student_no, students.class_id, students.section_id, classes.name as class_name, sections.name as section_name')
            ->from('students')
            ->join('classes', 'classes.id = students.class_id', 'left')
            ->join('sections', 'sections.id = students.section_id', 'left')
            ->where('students.deleted', 0)
            ->get()
            ->result();

        $data = [];

        foreach ($students as $s) {
            $data[] = [
                "id" => "s" . $s->id,
                "name" => $s->f_name . " " . $s->l_name,

                // 🔹 OLD (UNCHANGED)
                "class" => "Class " . $s->class_id,
                "section" => $s->section_id,

                // 🔹 NEW (ADDED)
                "class_name" => "Class " . $s->class_name,
                "section_name" => $s->section_name,

                "rollNumber" => $s->student_no
            ];
        }

        $this->success(["students" => $data]);
    }
}