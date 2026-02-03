<?php 
    defined('BASEPATH') OR exit('No direct script access allowed');

    class GradeEntryController extends CI_Controller {
        public function __construct() {
            parent::__construct();
            $this->load->model("AcademyClass");
            $this->load->model("ClassSection");
            $this->load->model("Subject");
            $this->load->model("Exam");
            $this->load->model("Subject");
            $this->load->model("ExamPaper");
            $this->load->model("ExamGrade");
            $this->load->model("Component");
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


            if($class_id && $section_id) {
                $classes = $this->AcademyClass->get();
                $sections = $this->ClassSection->get_sections($academy_session_id, $class_id);
                
                $students = $this->Student->get_where(array(
                    "class_id"      => $class_id,
                    "section_id"    => $section_id,
                ));
                
    
                $this->load->view("academics/grade_entry", array("classes" => $classes, "sections" => $sections, "students" => $students));
            }
            else if($class_id) {
                $sections = $this->ClassSection->get_sections($academy_session_id, $class_id);
                
                $rows = $this->ExamPaper->get_exams([
                    "class_id" => $class_id, 
                    "paper_type" => "grade", 
                ]);
                
                $exams = [];
                foreach($rows as $row) {
                    $exams[] = $this->Exam->get($row["exam_id"]);
                }
                
                echo json_encode(array("sections" => $sections, "exams" => $exams));
            }
            else {
                $classes = $this->AcademyClass->get();
        
                $this->load->view("academics/grade_entry", ["classes" => $classes]);
            }   
        }

        public function grade_store() {
            $ids = $this->input->post("ids");
            $grades = $this->input->post("grades");

            $class_id = $this->input->post("class_id");
            $section_id = $this->input->post("section_id");
            $exam_id = $this->input->post("exam_id");
            $subject_id = $this->input->post("subject_id");

            $marks = [];
            
            $academy_session_id = $this->session->academy_session['current_session']['id'];
            
            for($i = 0 ; $i < count($ids) ; $i++) {
                $marks[] = [
                    "class_id" => $class_id,
                    "section_id" => $section_id,
                    "exam_id" => $exam_id,
                    "subject_id" => $subject_id,
                    "student_id" => $ids[$i],
                    "grade" => $grades[$i],
                    "session_id" => $academy_session_id
                ];
            }

            $this->Marks->grade_store($marks);

            return redirect(base_url() . "academics/grade-entry");
        }
    }