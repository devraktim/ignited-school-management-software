<?php 
    defined('BASEPATH') OR exit('No direct script access allowed');

    class TeacherRemarksController extends CI_Controller {
        public function __construct() {
            parent::__construct();
            $this->load->model("AcademyClass");
            $this->load->model("ClassSection");
            $this->load->model("StudentSubject");
            $this->load->model("Subject");
            $this->load->model("Student");
            $this->load->model("Exam");
            $this->load->model("Subject");
            $this->load->model("ExamPaper");
            $this->load->model("ExamGrade");
            $this->load->model("Component");
            $this->load->model("Marks");
            $this->load->model("Remarks");
            $this->load->model("ClassTeacher");
            $this->load->model("Setting");
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

                $this->load->view("academics/teacher_remarks", array("classes" => $classes, "sections" => $sections, "students" => $students));
            }
            else if($class_id) {
                $sections = $this->ClassSection->get_sections($academy_session_id, $class_id);
                
                $rows = $this->ExamPaper->get_exams([
                    "class_id" => $class_id, 
                ]);
                
                $exams = [];
                $l = [];
                foreach($rows as $row) {
                    if(!in_array($row["exam_id"], $l)) {
                        $exams[] = $this->Exam->get($row["exam_id"]);
                        $l[] = $row["exam_id"];
                    }
                }
                
                echo json_encode(array("sections" => $sections, "exams" => $exams));
            }
            else {
                $classes = $this->AcademyClass->get();
        
                $this->load->view("academics/teacher_remarks", ["classes" => $classes]);
            }   
        }

        public function get_students() {
            if(!$this->session->user) {
                return redirect(base_url());
            }

            $academics_settings = $this->Setting->get("academics");

            for($i = 0 ; $i < count($academics_settings) ; $i++) {
                $settings[$academics_settings[$i]['key_name']] = $academics_settings[$i]['value'];
            };

            $class_id = $_POST["class_id"];
            $section_id = $_POST["section_id"];
            $am_i_class_teacher = $this->ClassTeacher->am_i_class_teacher($class_id, $section_id);
            $class_teacher_can_enter_remarks = $settings['class_teacher_can_enter_remarks'];


            $rows = $this->ExamPaper->get_subjects(["class_id" => $_POST["class_id"], "exam_id" => $_POST['exam_id']]);
            $subjects = [];
            
            foreach($rows as $row) {
                $s = explode(",", $row["subjects"]);
                
                foreach($s as $d) {
                    $subjects[] = $d;
                }
            }

            $students = [];
            $student_list = [];
            $academy_session_id = $this->session->academy_session['current_session']['id'];
            
            foreach($subjects as $subject) {
                $rows = $this->StudentSubject->get_students([
                    'academy_class_id'   => $_POST["class_id"],
                    'section_id'         => $_POST["section_id"],
                    'subject_id'         => $subject,
                    "current_session_id" => $academy_session_id
                ]);

                foreach($rows as $row) {
                    if(!in_array($row["student_id"], $student_list))  {
                        $student = $this->Student->get($row["student_id"]);
                    
                        $students[] = [
                            "id"            => $student["id"],
                            "student_no"    => $student["student_no"],
                            "roll_no"       => $student["roll_no"],
                            "f_name"        => $student["f_name"],
                            "m_name"        => $student["m_name"],  
                            "l_name"        => $student["l_name"],
                            "remark"        => $this->Remarks->get_remark(["class_id" => $_POST["class_id"], "section_id" => $_POST["section_id"], "exam_id" => $_POST["exam_id"], "student_id" => $row["student_id"]]),
                        ];

                        $student_list[] = $row["student_id"];
                    }

                }
            }

            $academy_session_id = $this->session->academy_session['current_session']['id'];
            $classes = $this->AcademyClass->get();
            $sections = $this->ClassSection->get_sections($academy_session_id, $_POST["class_id"]);
            $exams = $this->Exam->get();

            $exam_list = $this->ExamPaper->get_exams([
                "class_id" => $_POST["class_id"], 
            ]);
            
            $exams = [];
            $l = [];
            foreach($exam_list as $e) {
                if(!in_array($e["exam_id"], $l)) {
                    $exams[] = $this->Exam->get($e["exam_id"]);
                    $l[] = $e["exam_id"];
                }
            }


            $this->load->view("academics/teacher_remarks", [
                "students"                          => $students,
                "classes"                           => $classes,
                "sections"                          => $sections,
                "exams"                             => $exams,
                "class_id"                          => $_POST["class_id"],
                "section_id"                        => $_POST["section_id"],
                "exam_id"                           => $_POST["exam_id"],
                "am_i_class_teacher"                => $am_i_class_teacher,
                "class_teacher_can_enter_remarks"   => $class_teacher_can_enter_remarks
            ]);
        }

        public function teacher_remarks_store() {
            $ids = $this->input->post("ids");
            $remarks = $this->input->post("remark");

            $class_id = $this->input->post("class_id");
            $section_id = $this->input->post("section_id");
            $exam_id = $this->input->post("exam_id");

            $data = [];
            
            $academy_session_id = $this->session->academy_session['current_session']['id'];

            for($i = 0 ; $i < count($ids) ; $i++) {
                $data[] = [
                    "class_id" => $class_id,
                    "section_id" => $section_id,
                    "exam_id" => $exam_id,
                    "student_id" => $ids[$i],
                    "remark" => $remarks[$i],
                    "session_id" => $academy_session_id
                ];
            }

            $this->Remarks->remarks_store($data);

            return redirect(base_url() . "academics/teacher-remarks-entry");
        }
    }