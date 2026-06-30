<?php
class Classes extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->auth();
    }

    public function index()
    {
        if ($this->role == 'student') {
            $student = $this->db->get_where('students',['id'=>$this->user_id])->row();

            $class = $this->db->get_where('classes',['id'=>$student->class_id])->row();
            $section = $this->db->get_where('sections',['id'=>$student->section_id])->row();

            $this->success([
                "classes"=>[
                    [
                        "id"=>$class->id,
                        "name"=>"Class ".$class->name,
                        "section"=>$section->name,
                        "studentCount"=>0,
                        "subject"=>"N/A"
                    ]
                ]
            ]);
        }

        if ($this->role == 'teacher') {
            $rows = $this->db->get_where('class_section_employee',[
                'employee_id'=>$this->user_id
            ])->result();

            $data=[];
            foreach($rows as $r){
                $class=$this->db->get_where('classes',['id'=>$r->class_id])->row();
                $section=$this->db->get_where('sections',['id'=>$r->section_id])->row();

                $data[]=[
                    "id"=>$class->id,
                    "name"=>"Class ".$class->name,
                    "section"=>$section->name,
                    "studentCount"=>0,
                    "subject"=>"N/A"
                ];
            }

            $this->success(["classes"=>$data]);
        }
    }
}