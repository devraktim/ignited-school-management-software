<?php 
    defined('BASEPATH') OR exit('No direct script access allowed');

    class EvolutionPaperController extends CI_Controller {
        public function __construct() {
            parent::__construct();
            $this->load->model("Student");
            $this->load->model("AcademyClass");
            $this->load->model("ClassSection");
            $this->load->model("Section");
            $this->load->model("Exam");
            $this->load->model("EvolutionSubject");
            $this->load->model("StudentSubject");
            $this->load->model("EvolutionPaper");
            $this->load->model("ExamGrade");
            $this->load->model("Component");
            $this->load->model("Marks");
        }

        public function index() {
            if(!$this->session->user) {
                return redirect(base_url());
            }

            $evolution_papers = $this->EvolutionPaper->get();
            
            $papers = array();
            
            for($i = 0 ; $i < count($evolution_papers) ; $i++) {
                $paper = [
                    "id" => $evolution_papers[$i]["id"],
                    "class" => $this->AcademyClass->get($evolution_papers[$i]['class_id']),
                    "exam" => $this->Exam->get($evolution_papers[$i]['exam_id']),
                    "subjects" => array(),
                ];

                if($evolution_papers[$i]['subjects'] != "") {
                    $subjects = explode(",",  $evolution_papers[$i]['subjects']);

                    for($j = 0 ; $j < count($subjects) ; $j++) {
                        $paper['subjects'][] = $this->EvolutionSubject->get($subjects[$j]);
                    }
                }

                $papers[] = $paper;
            }

            $data = [
                "classes" => $this->AcademyClass->get(),
                "exams" => $this->Exam->get(),
                "papers" => $papers,
            ];
            
            // echo "<pre>";
            // // print_r($_GET);
            // print_r($data["papers"]);
            // // print_r($subjects);
            // echo "</pre>";
            // exit();

            $this->load->view("academics/evolution_paper", $data);
        }

        public function create() {
            if(!$this->session->user) {
                return redirect(base_url());
            }

            $data = [
                "classes"               => $this->AcademyClass->get(),
                "exams"                 => $this->Exam->get(),
                "evolution_subjects"    => $this->EvolutionSubject->get(),
            ];
    
            $this->load->view("academics/set_evolution_paper", $data);
            
        }

        public function get_exam_paper() {
            if(!$this->session->user) {
                return redirect(base_url());
            }

            $record = $this->EvolutionPaper->get_where([
                "class_id" => $_GET["class_id"],
                "exam_id" => $_GET['exam_id'],
                "paper_type" => "grade"
            ]);

            $subjects = explode(",", $record["subjects"]);
            
            $subject_list = [];
            foreach($subjects as $subject) {
                $subject_list[] = $this->Subject->get($subject);
            }

            echo json_encode(["subjects" => $subject_list]);

        }

        public function exam_paper_student() {
            if(!$this->session->user) {
                return redirect(base_url());
            }

            $students = $this->StudentSubject->get_students([
                "academy_class_id" => $_POST["class_id"],
                "section_id" => $_POST["section_id"],
                "subject_id" => $_POST["subject_id"],
                "current_session_id" => "1"
            ]);

            $student_list = [];

            foreach($students as $student) {
                $s = $this->Student->get($student["student_id"]);
                $student_list[] = [
                    "id"            => $s["id"],
                    "student_no"    => $s["student_no"],
                    "roll_no"       => $s["roll_no"],
                    "f_name"        => $s["f_name"],
                    "m_name"        => $s["m_name"],
                    "l_name"        => $s["l_name"],
                    "grade"         => $this->Marks->get_grade(["class_id" => $_POST["class_id"], "section_id" => $_POST["section_id"], "exam_id" => $_POST["exam_id"], "subject_id" => $_POST["subject_id"], "student_id" => $s["id"]]),
                ];
            }

            $academy_session_id = $this->session->academy_session['current_session']['id'];
            $classes = $this->AcademyClass->get();
            $sections = $this->ClassSection->get_sections($academy_session_id, $_POST["class_id"]);
            $exams = $this->Exam->get();
            $exam_grades = $this->ExamGrade->get();

            $record = $this->EvolutionPaper->get_where([
                "class_id" => $_POST["class_id"],
                "exam_id" => $_POST['exam_id'],
                "paper_type" => "grade"
            ]);

            $subject_list = explode(",", $record["subjects"]);
            
            $subjects = [];
            foreach($subject_list as $subject) {
                $subjects[] = $this->Subject->get($subject);
            }

            $this->load->view("academics/grade_entry", [
                "students"          => $student_list,
                "classes"           => $classes,
                "sections"          => $sections,
                "exams"             => $exams,
                "subjects"          => $subjects,
                "class_id"          => $_POST["class_id"],
                "section_id"        => $_POST["section_id"],
                "exam_id"           => $_POST["exam_id"],
                "subject_id"        => $_POST["subject_id"],
                "exam_grades"       => $exam_grades
            ]);
        }

        public function store() {
            if(!$this->session->user) {
                return redirect(base_url());
            }
            
            $class_id = $this->input->post("class_id");
            $exam_id = $this->input->post("exam_id");
            $subjects = implode(",", $_POST["subjects"]);
            
            $this->EvolutionPaper->insert([
                "class_id"              => $class_id,
                "exam_id"               => $exam_id,
                "subjects"              => $subjects
            ]);

            return redirect(base_url() . "academics/set-evolution-paper/");
        }

        public function search() {
            $class_id = $_GET["class_id"];
            $exam_id = $_GET["exam_id"];

            $exam_papers = $this->EvolutionPaper->search([
                "class_id" => $class_id,
                "exam_id" => $exam_id
            ]);

            header("Content-type: application/json");

            $used_subject = [];
            
            foreach($exam_papers as $exam_paper) {
                $subjects = explode(",", $exam_paper['subjects']);

                foreach($subjects as $subject) {
                    if(!in_array($subject, $used_subject)) {
                        $used_subject[] = $subject;
                    }
                }
            }

            $subject_data = [];

            if(count($used_subject) > 0)
                $subject_data = $this->Subject->get_where_id_not_in($used_subject);
            else
                $subject_data = $this->Subject->get();

            echo json_encode($subject_data);
        }

        public function delete($id) {
            if(!$this->session->user) {
                return redirect(base_url());
            }

            $this->EvolutionPaper->delete($id);
            
            $this->session->set_flashdata("success", "Success");
            return redirect(base_url() . "academics/evolution-paper/");
        }

        public function remove_subject() {
            if(!$this->session->user) {
                return redirect(base_url());
            }
            
            $id = $_GET["id"];
            $subject_id = $_GET["subject_id"];

            $record = $this->EvolutionPaper->get($id);

            $subjects = explode(",", $record["subjects"]);

            if (($key = array_search($subject_id, $subjects)) !== false) {
                unset($subjects[$key]);
            }

            $subjects = implode(",", $subjects);
            
            // echo "<pre>";
            // print_r($_GET);
            // print_r($record);
            // print_r($subjects);
            // echo "</pre>";
            // exit();

            $this->EvolutionPaper->update($id, array(
                "subjects" => $subjects
            ));

            $this->session->set_flashdata("success", "Success");
            return redirect(base_url() . "academics/evolution-paper/");
        }

    }