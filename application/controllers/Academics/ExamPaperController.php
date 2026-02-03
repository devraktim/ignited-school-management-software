<?php 
    defined('BASEPATH') OR exit('No direct script access allowed');

    class ExamPaperController extends CI_Controller {
        public function __construct() {
            parent::__construct();
            $this->load->model("Student");
            $this->load->model("AcademyClass");
            $this->load->model("ClassSection");
            $this->load->model("Section");
            $this->load->model("Exam");
            $this->load->model("Subject");
            $this->load->model("StudentSubject");
            $this->load->model("ExamPaper");
            $this->load->model("ExamGrade");
            $this->load->model("Component");
            $this->load->model("Marks");
        }

        public function index() {
            if(!$this->session->user) {
                return redirect(base_url());
            }

            $exam_papers = $this->ExamPaper->get();

            $papers = array();

            for($i = 0 ; $i < count($exam_papers) ; $i++) {
                $paper = [
                    "id" => $exam_papers[$i]["id"],
                    "class" => $this->AcademyClass->get($exam_papers[$i]['class_id']),
                    "exam" => $this->Exam->get($exam_papers[$i]['exam_id']),
                    "paper_type" => $exam_papers[$i]['paper_type'],
                    "subjects" => array(),
                ];

                if($exam_papers[$i]['subjects'] != "") {
                    $subjects = explode(",",  $exam_papers[$i]['subjects']);

                    for($j = 0 ; $j < count($subjects) ; $j++) {
                        $paper['subjects'][] = $this->Subject->get($subjects[$j]);
                    }
                }

                if($paper["paper_type"] == "component") {
                    $obj = json_decode($exam_papers[$i]['marks']);

                    $paper["marks"] = json_decode($exam_papers[$i]['marks']);
    
                    $paper["component"] = $this->Component->get($obj->component_id);
                    $paper["full_marks"] = $obj->marks->full_marks;
                    $paper["pass_marks"] = $obj->marks->pass_marks;
                }
                
                if($paper["paper_type"] == "mark_grade") {
                    $paper["marks"] = json_decode($exam_papers[$i]['marks']);
                }

                $papers[] = $paper;
            }
            
            $data = [
                "classes" => $this->AcademyClass->get(),
                "exams" => $this->Exam->get(),
                "papers" => $papers,
                "grades" => $this->ExamGrade->get()
            ]; 
            
            // Start Formatted Exam
            $formattedData = [];
        
            foreach ($data["papers"] as $entry) {
                $id = $entry['id'];
                $classId = $entry['class']['id'];
                $className = $entry['class']['name'];
                $examId = $entry['exam']['id'];
                $examName = $entry['exam']['name'];
            
                // Initialize class if not already
                if (!isset($formattedData[$classId])) {
                    $formattedData[$classId] = [
                        'class_name' => $className,
                        'exams' => []
                    ];
                }
            
                // Initialize exam under the class if not already
                if (!isset($formattedData[$classId]['exams'][$examId])) {
                    $formattedData[$classId]['exams'][$examId] = [
                        'exam_id' => $id,
                        'exam_name' => $examName,
                        'subjects' => []
                    ];
                }
            
                // Loop through subjects
                foreach ($entry['subjects'] as $subject) {
                    // Skip if subject is empty
                    if (empty($subject)) {
                        continue;
                    }
            
                    $subjectId = $subject['id'];
            
                    $formattedData[$classId]['exams'][$examId]['subjects'][$subjectId] = [
                        'subject_name' => $subject['name'],
                        'component_name' => $entry['component']['name'],
                        'full_marks' => $entry['marks']->marks->full_marks,
                        'pass_marks' => $entry['marks']->marks->pass_marks
                    ];
                }
            }
            // End Formatted Exam
            
            $data["papers"] = $formattedData;

            $this->load->view("academics/examination_paper", $data);
        }

        public function create() {
            if(!$this->session->user) {
                return redirect(base_url());
            }

            $data = [
                "classes" => $this->AcademyClass->get(),
                "exams" => $this->Exam->get(),
                "subjects" => $this->Subject->get(),
                "components" => $this->Component->get(),
            ];

            $this->load->view("academics/set_examination_paper", $data);
            
        }

        public function get_exam_paper() {
            if(!$this->session->user) {
                return redirect(base_url());
            }

            $record = $this->ExamPaper->get_where([
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
            
            $academy_session_id = $this->session->academy_session['current_session']['id'];

            $students = $this->StudentSubject->get_students([
                "academy_class_id" => $_POST["class_id"],
                "section_id" => $_POST["section_id"],
                "subject_id" => $_POST["subject_id"],
                "current_session_id" => $academy_session_id
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

            $record = $this->ExamPaper->get_where([
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
            
            $paper_type = trim($this->input->post('paper_type'));

            $data = [
                "class_id" => trim($this->input->post('class_id')),
                "exam_id" => trim($this->input->post('exam_id')),
                "subjects" => implode(",", $this->input->post('subject')),
                "paper_type" => trim($this->input->post('paper_type')),
                "marks" => json_encode([])
            ];

            if($paper_type == "component") {
                $obj = [
                    "component_id" => trim($this->input->post('component_id')),
                    "marks" => [
                        "full_marks" => trim($this->input->post('full_marks')),
                        "pass_marks" => trim($this->input->post('pass_marks'))
                    ]
                ];

                $data['marks'] = json_encode($obj);
            }

            if($paper_type == "mark_grade") {
                $mins = $this->input->post('min');
                $maxs = $this->input->post('max');
                $grades = $this->input->post('grade');

                $marks = [];

                for($i = 0 ; $i < count($mins) ; $i++) {
                    $marks[] = [
                        "min" => trim($mins[$i]),
                        "max" => trim($maxs[$i]),
                        "grade" => trim($grades[$i])
                    ];
                }

                $data['marks'] = json_encode([
                    "mark_grade_full_marks" => trim($this->input->post('mark_grade_full_marks')),
                    "mark_grade_pass_marks" => trim($this->input->post('mark_grade_pass_marks')),
                    "marks" => $marks
                ]);
            }

            $record = $this->ExamPaper->search([
                "class_id"      => $data['class_id'],
                "exam_id"       => $data['exam_id'],
                "paper_type"    => $data['paper_type'],
            ]);
            
            if($record["marks"] == $data['marks']) {
                
                $d = [];
                $d['subjects'] = $data['subjects'];
                $this->ExamPaper->update($record[0]['id'], $d);
                
                $this->session->set_flashdata("success", "Success");

                return redirect(base_url() . "academics/examination-paper/");

            }
            else {
                
                $this->ExamPaper->insert($data);
                
                $this->session->set_flashdata("success", "Success");

                return redirect(base_url() . "academics/set-examination-paper/create/");
                               
            }

        }

        public function search() {
            $class_id = $_GET["class_id"];
            $exam_id = $_GET["exam_id"];

            $exam_papers = $this->ExamPaper->search([
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
        
        public function edit($id = NULL) {
            if (!$this->session->user) {
                return redirect(base_url());
            }
        
            // Fetch data for select fields
            $data = [
                "classes" => $this->AcademyClass->get(),
                "exams" => $this->Exam->get(),
                "subjects" => $this->Subject->get(),
                "components" => $this->Component->get(),
                "exam_paper"    => $this->ExamPaper->get($id)
            ];
            
            $data['exam_paper']['marks'] = json_decode($data['exam_paper']['marks'], true);
        
            // Load the view
            $this->load->view("academics/edit_examination_paper", $data);
        }

        public function delete($id) {
            if(!$this->session->user) {
                return redirect(base_url());
            }

            $this->ExamPaper->delete($id);
            
            $this->session->set_flashdata("success", "Success");
            return redirect(base_url() . "academics/examination-paper/");
        }

        public function remove_subject() {
            if(!$this->session->user) {
                return redirect(base_url());
            }
            
            $id = $_GET["id"];
            $subject_id = $_GET["subject_id"];

            $record = $this->ExamPaper->get($id);

            $subjects = explode(",", $record["subjects"]);

            if (($key = array_search($subject_id, $subjects)) !== false) {
                unset($subjects[$key]);
            }

            $subjects = implode(",", $subjects);

            $this->ExamPaper->update($id, array(
                "subjects" => $subjects
            ));

            $this->session->set_flashdata("success", "Success");
            return redirect(base_url() . "academics/examination-paper/");
        }
    }