<?php 
    defined('BASEPATH') OR exit('No direct script access allowed');

    class MarksEntryController extends CI_Controller {
        public function __construct() {
            parent::__construct();
            $this->load->model("AcademyClass");
            $this->load->model("ClassSection");
            $this->load->model("Subject");
            $this->load->model("Exam");
            $this->load->model("StudentSubject");
            $this->load->model("ExamPaper");
            $this->load->model("ExamGrade");
            $this->load->model("Component");
            $this->load->model("Student");
            $this->load->model("Marks");
        }

        public function index() {
            if(!$this->session->user) {
                return redirect(base_url());
            }
            $data;
            $class_id       = $this->input->get("class_id");
            $section_id     = $this->input->get("section_id");
            $exam_id        = $this->input->get("exam_id");
            $component_id   = $this->input->get("component_id");
            $subject_id     = $this->input->get("subject_id");
            
            $academy_session_id = $this->session->academy_session['current_session']['id'];
    
            if($class_id && $exam_id) {
                $rows = $this->ExamPaper->get_exams([
                    "class_id"      => $class_id, 
                    "exam_id"       => $exam_id,
                    "paper_type"    => "component"
                ]);
                
                $components = [];
                $subjects = [];
                
                for($i = 0 ; $i < count($rows) ; $i++) { 

                    $r = json_decode($rows[$i]["marks"]);
                    
                    $subjects[] = explode(",", $rows[$i]["subjects"]);
                    
                    $components[] = $this->Component->get($r->component_id);
                }
                
                $subjects = array_merge(...$subjects);
                $subjects = array_unique($subjects);
                $subject_list = [];
                
                foreach($subjects as $subject) {
                    $subject_list[] = $this->Subject->get($subject);
                }
            
                
                echo json_encode(array("components" => $components, "subjects" => $subject_list));
            }
            else if($class_id) {
                $sections = $this->ClassSection->get_sections($academy_session_id, $class_id);
                
                $rows = $this->ExamPaper->get_exams([
                    "class_id" => $class_id, 
                    "paper_type" => "component", 
                ]);
                
                $exams = [];
                $temp = [];
                
                foreach($rows as $row) {
                    
                    if(!in_array($row["exam_id"], $temp)) {
                        $temp[] = $row["exam_id"]; 
                        $exams[] = $this->Exam->get($row["exam_id"]);
                    }
                        
                }
                
                echo json_encode(array("sections" => $sections, "exams" => $exams));
            }
            else {
                $classes = $this->AcademyClass->get();
        
                $this->load->view("academics/marks_entry", ["classes" => $classes]);
            }   
        }

        public function get_students() {
            $class_id       = $this->input->post("class_id");
            $section_id     = $this->input->post("section_id");
            $exam_id        = $this->input->post("exam_id");
            $component_id   = $this->input->post("component_id");
            $subject_id     = $this->input->post("subject_id");
            
            $academy_session_id = $this->session->academy_session['current_session']['id'];
            
            $student_list = [];
            $rows = $this->StudentSubject->get_students([
                "academy_class_id" => $class_id,
                "section_id" => $section_id,
                "subject_id" => $subject_id,
                "current_session_id" => $academy_session_id
            ]);
          
            foreach($rows as $row) {
                $student_list[] = $row["student_id"];
            } 
            
            $rows = $this->ExamPaper->get_exams([
                "class_id"      => $class_id, 
                "exam_id"       => $exam_id,
                "paper_type"    => "component"
            ]);
            
            $components = [];
            $subjects = [];
            
            $full_marks = "";
            $pass_marks = "";
            $component_name = "";
            
            $subject = $this->Subject->get($subject_id);
            $subject_name = $subject["name"];
            
        
       
            
            for($i = 0 ; $i < count($rows) ; $i++) { 

                $r = json_decode($rows[$i]["marks"]);
                
                $subjects[] = explode(",", $rows[$i]["subjects"]);
                $ss = explode(",", $rows[$i]["subjects"]);
                
                if($r->component_id && $component_id && in_array($subject_id, $ss)) {
                    $component = $this->Component->get($r->component_id);
                    
                    $component_name = $component["name"];
                    $full_marks     = $r->marks->full_marks;
                    $pass_marks     = $r->marks->pass_marks;
                }
                
                $components[] = $this->Component->get($r->component_id);
            }
        
            $subjects = array_merge(...$subjects);
            $subjects = array_unique($subjects);
            $subject_list = [];
            
            foreach($subjects as $subject) {
                $subject_list[] = $this->Subject->get($subject);
            }
        
            $sections = $this->ClassSection->get_sections($academy_session_id, $class_id);
        
            $rows = $this->ExamPaper->get_exams([
                "class_id" => $class_id, 
                "paper_type" => "component", 
            ]);
            
            $exams = [];
            foreach($rows as $row) {
                $exams[] = $this->Exam->get($row["exam_id"]);
            }
            
         
            $students = [];    
            foreach($student_list as $student) {
                $s = $this->Student->get($student);
                $students[] = [
                    "id"            => $s["id"],
                    "student_no"    => $s["student_no"],
                    "roll_no"       => $s["roll_no"],
                    "f_name"        => $s["f_name"],
                    "m_name"        => $s["m_name"],
                    "l_name"        => $s["l_name"],
                    "marks"         => $this->Marks->get_marks([
                                                                "class_id"      => $_POST["class_id"], 
                                                                "section_id"    => $_POST["section_id"], 
                                                                "exam_id"       => $_POST["exam_id"], 
                                                                "subject_id"    => $_POST["subject_id"], 
                                                                "student_id"    => $s["id"],
                                                            ]),
                ];
            }
            
          
            $data = [
                "students"      => $students,
                "classes"       => $this->AcademyClass->get(),
                "sections"      => $sections,
                "exams"         => $exams,
                "components"    => $components,
                "subjects"      => $subject_list,
                "class_id"      => $class_id,
                "section_id"    => $section_id,
                "exam_id"       => $exam_id,
                "component_id"  => $component_id,
                "subject_id"    => $subject_id,
                "full_marks"    => $full_marks,
                "pass_marks"    => $pass_marks,
                "subject_name"  => $subject_name,
                "component_name"  => $component_name,
            ];  
            
            
            $this->load->view("academics/marks_entry", $data);
            
        }

        public function marks_store() {
            $ids = $this->input->post("ids");
            $marks = $this->input->post("marks");

            $class_id = $this->input->post("class_id");
            $section_id = $this->input->post("section_id");
            $exam_id = $this->input->post("exam_id");
            $subject_id = $this->input->post("subject_id");
            
            $academy_session_id = $this->session->academy_session['current_session']['id'];
            
            $rows = [];
            for($i = 0 ; $i < count($ids) ; $i++) {
                $rows[] = [
                    "class_id" => $class_id,
                    "section_id" => $section_id,
                    "exam_id" => $exam_id,
                    "subject_id" => $subject_id,
                    "student_id" => $ids[$i],
                    "marks" => $marks[$i],
                    "session_id" => $academy_session_id
                ];
            }

            $this->Marks->marks_store($rows);

            return redirect(base_url() . "academics/marks-entry");
        }
    }