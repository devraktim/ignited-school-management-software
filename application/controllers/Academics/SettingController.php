<?php 
    defined('BASEPATH') OR exit('No direct script access allowed');

    class SettingController extends CI_Controller {
        public function __construct() {
            parent::__construct();

            $this->load->model("AcademyClass");
            $this->load->model("ClassSection");
            $this->load->model("Section");
            $this->load->model("Employee");
            $this->load->model("Designation");
            $this->load->model("ClassTeacher");
            $this->load->model("Setting");
        }

        public function index() {
            if(!$this->session->user) {
                return redirect(base_url());
            }
        }


        public function create() {
            if(!$this->session->user) {
                return redirect(base_url());
            }

            $settings = [];
            $student_settings = $this->Setting->get("academics");

            for($i = 0 ; $i < count($student_settings) ; $i++) {
                $settings[$student_settings[$i]['key_name']] = $student_settings[$i]['value'];
            };

            $data = array(
                "settings"      => $settings
            );  

            $this->load->view("academics/settings", $data);
        }
        
        
        public function store() {
            if(!$this->session->user) {
                return redirect(base_url());
            }
            

            $keys = array_keys($_POST);
            $values = array_values($_POST);

            $data = array();

            for($i = 0 ; $i < count($keys) ; $i++) {
                $data[] = [
                    "module" => "academics",
                    "key_name" => $keys[$i],
                    "value" => $values[$i]
                ];
            };

            $this->Setting->insert_or_update($data);

            $this->session->set_flashdata("success", "New record inserted");
            return redirect(base_url() . "academics/setting");

        }

        // public function assign_teacher_class_create() {
        //     if(!$this->session->user) {
        //         return redirect(base_url());
        //     }

        //     // $data = [
        //     //     "classes" => $this->AcademyClass->get(),
        //     //     "sections" => $this->Section->get(),
        //     //     "employees" => $this->Employee->get(),
        //     //     "records" => $this->ClassTeacher->get(), 
        //     //     "selected" => []
        //     // ];


        //     $classes = $this->AcademyClass->get();

        //     $sections = [];

        //     foreach ($classes as $class) {

        //         $classSections = $this->ClassSection->get_sections(
        //             $this->session->academy_session["current_session"]["id"],
        //             $class["id"]
        //         );

        //         foreach ($classSections as $section) {

        //             $sections[$section["id"]] = $section;

        //         }
        //     }

        //     $data = [
        //         "classes"   => $classes,
        //         "sections"  => array_values($sections),
        //         "employees" => $this->Employee->get(),
        //         "records"   => $this->ClassTeacher->get(),
        //         "selected"  => []
        //     ];

        //     $selected = [];

        //     for($i = 0 ; $i < count($data['records']) ;  $i++) {
        //         $key = $data['records'][$i]['class_id'] . "_" . $data['records'][$i]['section_id'];
        //         $selected[$key] = $data['records'][$i]['employee_id'];
        //     }

        //     $data["selected"] = $selected;

        //     $this->load->view("academics/setting_assign_teacher_class_create", $data);
        // }

        public function assign_teacher_class_create()
        {
            if (!$this->session->user) {
                return redirect(base_url());
            }
            
            // $d = $this->ClassTeacher->get();

            // echo "<pre>";
            // print_r($d);
            // echo "</pre>";
            // exit();

            $academySessionId =
                $this->session
                    ->academy_session["current_session"]["id"];

            $classes =
                $this->AcademyClass->get();

            $classList = [];

            foreach ($classes as $class) {

                $class["sections"] =
                    $this->ClassSection->get_sections(
                        $academySessionId,
                        $class["id"]
                    );

                $classList[] = $class;
            }

            $records =
                $this->ClassTeacher->get();

            $selected = [];

            foreach ($records as $record) {

                $key =
                    $record["class_id"] .
                    "_" .
                    $record["section_id"];

                $selected[$key] =
                    $record["employee_id"];
            }

            $data = [

                "classes"   => $classList,

                "employees" => $this->Employee->get(),

                "records"   => $records,

                "selected"  => $selected

            ];

            $this->load->view(
                "academics/setting_assign_teacher_class_create",
                $data
            );
        }

        public function assign_teacher_class_store() {
            if(!$this->session->user) {
                return redirect(base_url());
            }
            
            $classes    =   $this->input->post('class_id');
            $sections   =   $this->input->post('section_id');
            $employees  =   $this->input->post('employee_id');

            $data = array();

            for($i = 0 ; $i < count($classes) ; $i++) {
                $data[] = [
                    "class_id" => $classes[$i],
                    "section_id" => $sections[$i],
                    "employee_id" => $employees[$i]
                ];
            };

            $this->ClassTeacher->insert_or_update($data);

            $this->session->set_flashdata("success", "Record Saved Successfully");
            return redirect(base_url() . "academics/setting/assign-teacher-class");

        }

        public function show_class_teacher() {
            if(!$this->session->user) {
                return redirect(base_url());
            }

            $data = [
                "records" => $this->ClassTeacher->get(), 
            ];

            $this->load->view("academics/show_class_teacher", $data);
        }  

        public function update($id) {
            if(!$this->session->user) {
                return redirect(base_url());
            }
           

        }

        public function delete($id) {
            if(!$this->session->user) {
                return redirect(base_url());
            }
 
        }
    }