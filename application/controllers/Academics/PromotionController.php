<?php 
    defined('BASEPATH') OR exit('No direct script access allowed');

    class PromotionController extends CI_Controller {
        public function __construct() {
            parent::__construct();

            $this->load->model("AcademyClass");
            $this->load->model("AcademySession");
            $this->load->model("StudentType");
            $this->load->model("Section");
            $this->load->model("House");
            $this->load->model("Category");
            $this->load->model("Religion");
            $this->load->model("Nationality");
            $this->load->model("State");
            $this->load->model("Student");
            $this->load->model("ClassSection");
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
            $next_session_id = $this->AcademySession->get_next_session($academy_session_id);


            if($class_id && $section_id) {
                $classes = $this->AcademyClass->get();
                $sections = $this->ClassSection->get_sections($academy_session_id, $class_id);
                $next_class_sections = $this->ClassSection->get_sections((5), ($class_id + 1));
                
                $students = $this->Student->get_where(array(
                    "class_id"                  => $class_id,
                    "section_id"                => $section_id,
                    "student_session.promoted"  => 0
                ));
               
                $this->load->view("academics/promotion", array("classes" => $classes, "sections" => $sections, "next_class_sections" => $next_class_sections, "students" => $students, "next_session_id" => $next_session_id));
            }
            else if($class_id) {
                $sections = $this->ClassSection->get_sections($academy_session_id, $class_id);
                echo json_encode(array("sections" => $sections, "next_session_id" => $next_session_id));
            }
            else {
                $classes = $this->AcademyClass->get();
                $this->load->view("academics/promotion", array("classes" => $classes, "next_session_id" => $next_session_id));
            }
        }
        
        public function promote()
        {   

            $academy_session_id = $this->session->academy_session['current_session']['id'];
            $class_id = $_POST["class_id"];
            $ids = $_POST["id"];
            $statuses = $_POST["status"];
            $promotes = $_POST["promote_section_id"];
            $continues = $_POST["continue_section_id"];
            $selected = $_POST["selected"];
            $data = [];
            $passouts = [];
            $updates = [];
            
            for($i = 0 ; $i < count($ids); $i++)
            {
                $new_class_id = "";
                $new_section_id = "";
                $promoted = 0;
                $passout = 0;
                
                if(in_array($ids[$i], $selected)) 
                {
                    if($statuses[$i] == "Promote") {
                        $updates[] = [
                            "student_id"    => $ids[$i],
                            "session_id"    => $academy_session_id,
                            "promoted"      => 1,
                        ];
                        
                        $new_class_id = $class_id + 1;
                        $new_section_id = $promotes[$i];
                        
                        $data[] = [
                            "student_id"        => $ids[$i],
                            "session_id"        => 5,
                            "class_id"          => $new_class_id,
                            "section_id"        => $new_section_id,
                        ]; 
                        
                    }
                    elseif($statuses[$i] == "Continue") {
                        $updates[] = [
                            "student_id"    => $ids[$i],
                            "session_id"    => $academy_session_id,
                            "promoted"      => 1,
                        ];
                        
                        $new_class_id = $class_id;
                        $new_section_id = $continues[$i];
                        
                        $data[] = [
                            "student_id"        => $ids[$i],
                            "session_id"        => 5,
                            "class_id"          => $new_class_id,
                            "section_id"        => $new_section_id,
                        ];    
                    }
                    else {
                        $new_class_id = $class_id;
                        $new_section_id = $continues[$i];
                        $passout = 1;
                        
                        $passouts[] = [
                            "student_id"        => $ids[$i],
                            "session_id"        => $academy_session_id,
                            "class_id"          => $new_class_id,
                            "section_id"        => $new_section_id,
                        ]; 
                    }
                }
            }
            
            $this->Student->update_student_academy_session_batch($updates);
            $this->Student->create_student_academy_session_batch_inserts($data);
            $this->Student->passout_student_academy_session_batch($passouts);
            
            $this->session->set_flashdata("success", "New record inserted");
            return redirect(base_url() . "academics/promotion");
        }
        
        public function edit()
        {
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
                $next_class_sections = $this->ClassSection->get_sections((5), ($class_id + 1));
                
                $students = $this->Student->get_where(array(
                    "class_id"                  => $class_id,
                    "section_id"                => $section_id,
                    "student_session.promoted"  => "ANY"
                ));

                $this->load->view("academics/promotion_edit", array("classes" => $classes, "sections" => $sections, "next_class_sections" => $next_class_sections, "students" => $students));
            }
            else if($class_id) {
                $sections = $this->ClassSection->get_sections($academy_session_id, $class_id);
                echo json_encode(array("sections" => $sections));
            }
            else {
                $classes = $this->AcademyClass->get();
                $this->load->view("academics/promotion_edit", array("classes" => $classes));
            }
        }
        
        public function update()
        {
            $students = $_POST["id"];
            $this->Student->back_students_to_last_session($students);
            
            $this->session->set_flashdata("success", "Student record updated!");
            return redirect(base_url() . "academics/edit-promotion");
        }
    }