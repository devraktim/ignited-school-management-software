<?php 
    defined('BASEPATH') OR exit('No direct script access allowed');

    class EvolutionEntryController extends CI_Controller {
        public function __construct() {
            parent::__construct();
            $this->load->model("AcademyClass");
            $this->load->model("ClassSection");
            $this->load->model("EvolutionGrade");
            $this->load->model("EvolutionSubject");
            $this->load->model("EvolutionPaper");
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
            $exam_id    = $this->input->get("exam_id");
            $academy_session_id = $this->session->academy_session['current_session']['id'];


            if($class_id && $section_id && $exam_id) {
                $classes = $this->AcademyClass->get();
                $sections = $this->ClassSection->get_sections($academy_session_id, $class_id);
                
                $students = $this->Student->get_where(array(
                    "class_id"      => $class_id,
                    "section_id"    => $section_id,
                ));
                
                
                $rows = $this->EvolutionPaper->get_exams(["class_id" => $class_id]);
                
                $papers = [];
                foreach($rows as $row) {
                    $papers[] = explode(",", $row["subjects"]);    
                }
                $filter_papers = array_unique($papers);
                
                $paper_list = [];
                foreach($filter_papers as $paper) {
                    $paper_list = $this->EvolutionSubject->get($paper);
                }
                
                $grades = $this->EvolutionGrade->get();
                
                
                $this->load->view("academics/evolution_entry", array(
                    "classes"   => $classes, 
                    "sections"  => $sections, 
                    "students"  => $students,
                    "papers"    => $paper_list,
                    "graedes"   => $grades
                ));
            }
            else if($class_id) {
                $sections = $this->ClassSection->get_sections($academy_session_id, $class_id);
                
                $rows = $this->EvolutionPaper->get_exams(["class_id" => $class_id]);
                
                $exams = [];
                foreach($rows as $row) {
                    $exams[] = $row["exam_id"];
                }
                
                $exam_list = array_unique($exams);
                $exams = [];
                
                foreach($exam_list as $exam) {
                    $exams[] = $this->Exam->get($exam);
                }
                
                
                echo json_encode(array("sections" => $sections, "exams" => $exams));
            }
            else {
                $classes = $this->AcademyClass->get();
        
                $this->load->view("academics/evolution_entry", ["classes" => $classes]);
            }   
        }
        
        public function get_students() {
            if(!$this->session->user) {
                return redirect(base_url());
            }
            
            $data;
            $class_id   = $this->input->post("class_id");
            $section_id = $this->input->post("section_id");
            $exam_id    = $this->input->post("exam_id");
            $academy_session_id = $this->session->academy_session['current_session']['id'];

            $classes = $this->AcademyClass->get();
            $sections = $this->ClassSection->get_sections($academy_session_id, $class_id);
            
            $students = $this->Student->get_where(array(
                "class_id"      => $class_id,
                "section_id"    => $section_id,
                "student_session.promoted" => "ANY"
            ));
        
            $student_list = [];
            foreach($students as $student) {
                $student_list[] = [
                    "id"            => $student["id"],
                    "student_no"    => $student["student_no"],
                    "roll_no"       => $student["roll_no"],
                    "f_name"        => $student["f_name"],
                    "m_name"        => $student["m_name"],
                    "l_name"        => $student["l_name"],
                    "grade"         => explode(",", $this->Marks->get_evolution(["class_id" => $_POST["class_id"], "section_id" => $_POST["section_id"], "exam_id" => $_POST["exam_id"], "student_id" => $student["id"]]))
                ];
            }
            
            // Papers
            $rows = $this->EvolutionPaper->get_exams(["class_id" => $class_id, "exam_id" => $exam_id]);
            
            $papers = [];
            foreach($rows as $row) {
                $d = explode(",", $row["subjects"]);
                
                foreach($d as $s) {
                    $papers[] = $s;
                }
            }
            $filter_papers = array_unique($papers);
            
            $paper_list = [];
            foreach($filter_papers as $paper) {
                $paper_list[] = $this->EvolutionSubject->get($paper);
            }
            
            
            // Exams
            $rows = $this->EvolutionPaper->get_exams(["class_id" => $class_id]);
            
            $exams = [];
            foreach($rows as $row) {
                $exams[] = $row["exam_id"];
            }
            
            $exam_list = array_unique($exams);
            $exams = [];
            
            foreach($exam_list as $exam) {
                $exams[] = $this->Exam->get($exam);
            }
                
            // Grades
            $grades = $this->EvolutionGrade->get();
            
            // echo "<pre>";
            // print_r(array(
            //     "classes"       => $classes, 
            //     "sections"      => $sections, 
            //     "students"      => $student_list,
            //     "papers"        => $paper_list,
            //     "grades"        => $grades,
            //     "exams"         => $exams,
            //     "class_id"      => $class_id,
            //     "section_id"    => $section_id,
            //     "exam_id"       => $exam_id
            // ));
            // echo "</pre>";
            
            $this->load->view("academics/evolution_entry", array(
                "classes"       => $classes, 
                "sections"      => $sections, 
                "students"      => $student_list,
                "papers"        => $paper_list,
                "grades"        => $grades,
                "exams"         => $exams,
                "class_id"      => $class_id,
                "section_id"    => $section_id,
                "exam_id"       => $exam_id
            ));
        }

        public function grade_store() {
            $ids = $this->input->post("ids");
            
            $class_id = $this->input->post("class_id");
            $section_id = $this->input->post("section_id");
            $exam_id = $this->input->post("exam_id");

            $students = $this->Student->get_where(array(
                "class_id"      => $class_id,
                "section_id"    => $section_id,
            ));
            
            // Papers
            $rows = $this->EvolutionPaper->get_exams(["class_id" => $class_id, "exam_id" => $exam_id]);
            
            $papers = [];
            foreach($rows as $row) {
                $d = explode(",", $row["subjects"]);
                
                foreach($d as $s) {
                    $papers[] = $s;
                }
            }
            
            $filter_papers = array_unique($papers);
            
            $data = [];
            
            $academy_session_id = $this->session->academy_session['current_session']['id'];
            
            foreach($students as $student) {
                $grades = implode(",", $_POST["grades_".$student["id"]]);
                
                $data[] = [
                    "class_id"      => $class_id,
                    "section_id"    => $section_id,
                    "exam_id"       => $exam_id,
                    "student_id"    => $student["id"],
                    "grade"         => $grades,
                    "session_id" => $academy_session_id
                ];
            }
            
            // echo "<pre>";
            // print_r($data);
            // echo "<pre>";
            // return;
            
            $this->Marks->evolution_store($data);

            return redirect(base_url() . "academics/evolution-entry");
        }
    }