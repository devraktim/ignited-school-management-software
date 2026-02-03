<?php 
    defined('BASEPATH') OR exit('No direct script access allowed');

    class ResultIndex extends CI_Controller {
        public function __construct() {
            parent::__construct();
            $this->load->model("AcademyClass");
            $this->load->model("Section");
            $this->load->model("ClassSection");
            $this->load->model("ExamPaper");
            $this->load->model("EvolutionGrade");
            $this->load->model("EvolutionSubject");
            $this->load->model("EvolutionPaper");
            $this->load->model("ExamAttendence");
            $this->load->model("StudentSubject");
            $this->load->model("Subject");
            $this->load->model("Remarks");
            $this->load->model("Exam");
            $this->load->model("Student");
            $this->load->model("Marks");
        }

        public function index() {
            if(!$this->session->user) {
                return redirect(base_url());
            }
            
            $data;
            $class_id   = $this->input->get("class_id");
            $section_id = $this->input->get("section_id");
            $academy_session_id = $this->session->academy_session['current_session']['id'];


            if($class_id) {
                $sections = $this->ClassSection->get_sections($academy_session_id, $class_id);
                
                $rows = $this->ExamPaper->get_exams([
                    "class_id" => $class_id, 
                    "paper_type" => "component", 
                ]);
                
                $exams = [];
                foreach($rows as $row) {
                    $exams[] = $this->Exam->get($row["exam_id"]);
                }
                
                echo json_encode(array("sections" => $sections, "exams" => $exams));
            }
            else {
                $classes = $this->AcademyClass->get();
        
                $this->load->view("academics/report", ["classes" => $classes]);
            }   
        }
        
        public function get_students() {
            $academy_session_id = $this->session->academy_session['current_session']['id'];
            $class_id = $this->input->get("class_id");
            $section_id = $this->input->get("section_id");
            
            $students = [];
            
            $data = $this->Student->get_where([
                "class_id"                      => $class_id,
                "section_id"                    => $section_id,
                "student_session.promoted"      => "ANY"
            ]);
            
            foreach($data as $d) {
                $students[] = [
                    "id"            => $d["id"],
                    "student_no"    => $d["student_no"]
                ];
            }
            
            echo json_encode(["data" => $students]);
            
        }
    }