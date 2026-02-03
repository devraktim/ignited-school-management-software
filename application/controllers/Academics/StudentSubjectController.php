<?php 
    defined('BASEPATH') OR exit('No direct script access allowed');

    class StudentSubjectController extends CI_Controller {
        public function __construct() {
            parent::__construct();
            $this->load->model("StudentSubject");
            $this->load->model("AcademyClass");
            $this->load->model("StudentType");
            $this->load->model("Section");
            $this->load->model("House");
            $this->load->model("Category");
            $this->load->model("Religion");
            $this->load->model("Nationality");
            $this->load->model("State");
            $this->load->model("Student");
            $this->load->model("ClassSection");
            $this->load->model("Subject");
            $this->load->model("SubjectType");
        }

        public function index() {
            if(!$this->session->user) {
                return redirect(base_url());
            }

            $data;
            $class_id   = $this->input->get("class_id");
            $section_id = $this->input->get("section_id");
            $subject_type_id = $this->input->get("subject_type_id");
            $academy_session_id = $this->session->academy_session["current_session"]["id"];
            $subject_types = $this->SubjectType->get();
            $subjects = $this->Subject->get();

            if($class_id && $section_id && $subject_type_id) {
                $classes = $this->AcademyClass->get();
                $sections = $this->ClassSection->get_sections($academy_session_id, $class_id);
                
                $students = $this->Student->get_where(array(
                    "class_id"      => $class_id,
                    "section_id"    => $section_id,
                    "student_session.promoted"  => "ANY"
                ));

                $all_students = [];
                
                for($i = 0 ; $i < count($students) ; $i++) {
                    $result =  $this->StudentSubject->get_where([
                        "student_id"            => $students[$i]["id"],
                        "academy_class_id"      => $class_id,
                        "section_id"            => $section_id,
                        "subject_type_id"       => $subject_type_id,
                        "current_session_id"    => $this->session->academy_session["current_session"]["id"]
                    ]);
                    
                    if($result) {
                        $students[$i]["subject_id"] = $result['subject_id'];
                    }
                    else {
                        $students[$i]["subject_id"] = 0;
                    }
                    
                    $all_students[] = [
                        "id"            => $students[$i]["id"],
                        "student_no"    => $students[$i]["student_no"],
                        "f_name"        => $students[$i]["f_name"],
                        "m_name"        => $students[$i]["m_name"],
                        "l_name"        => $students[$i]["l_name"],
                        "roll_no"       => $students[$i]["roll_no"],
                        "subject_id"    => $students[$i]["subject_id"],
                    ];
                }
        
                $this->load->view("academics/student_subject", array(
                    "classes" => $classes, 
                    "sections" => $sections, 
                    "students" => $all_students,
                    "subject_types" => $subject_types,
                    "subjects" => $subjects
                ));
            }
            else if($class_id) {
                $sections = $this->ClassSection->get_sections($academy_session_id, $class_id);
                echo json_encode(array("sections" => $sections));
            }
            else {
                $classes = $this->AcademyClass->get();
                $this->load->view("academics/student_subject", array(
                    "classes" => $classes,
                    "subject_types" => $subject_types,
                    "subjects" => $subjects
                ));
            }
        }

        public function store() {
            if(!$this->session->user) {
                return redirect(base_url());
            }

            $students = $this->input->post("student_id");
            $subjects = $this->input->post("subject_id");

            $subject_type_id = $this->input->post("subject_type_id");

            $data = array();

            for($i = 0 ; $i < count($students) ; $i++) {
                $student = $this->Student->get($students[$i]);
                
                $data[] = [
                    "student_id" => $students[$i],
                    "subject_id" => $subjects[$i],
                    "subject_type_id" => $subject_type_id,
                    "academy_class_id" => $student['class_id'],
                    "section_id" => $student['section_id'],
                    "current_session_id" => $this->session->academy_session["current_session"]["id"]
                ];
            }
            
            $this->StudentSubject->insert_or_update_batch($data);
            $this->session->set_flashdata("success", "New record inserted");

            return redirect(base_url() . "academics/student-subjects/");
        }

        public function update($id) {
            if(!$this->session->user) {
                return redirect(base_url());
            }
           
            $data = [
                "name" => $this->input->post('category')
            ];

            $this->Category->update($id, $data);

            $this->session->set_flashdata("success", "Record updated");
            return redirect(base_url() . "masters/categories/");

        }

        public function delete($id) {
            if(!$this->session->user) {
                return redirect(base_url());
            }

            $this->Category->delete($id);

         	$this->session->set_flashdata("success", "Record deleted");
            return redirect(base_url() . "masters/categories/");
        }
       
    //    public function restore($id) {
    //         if(!$this->session->user) {
    //             return redirect(base_url());
    //         }

    //         $this->User->restore($id);

    //      	$this->session->set_flashdata("success", "Record restored");
    //         return redirect(base_url() . "User");
    //     }
    }