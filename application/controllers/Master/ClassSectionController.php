<?php 
    defined('BASEPATH') OR exit('No direct script access allowed');

    class ClassSectionController extends CI_Controller {
        public function __construct() {
            parent::__construct();
            $this->load->model("AcademyClass");
            $this->load->model("Section");
            $this->load->model("ClassSection");
        }

        public function index() {
            if(!$this->session->user) {
                return redirect(base_url());
            }

            $records = array();
            $classes = $this->AcademyClass->get();

            foreach($classes as $class) {

                $class_sections = $this->ClassSection->get_sections($this->session->user["academy_session_id"], $class['id']);

                $records[] = [
                    'class'     => $class['name'],
                    'sections'  => $class_sections 
                ];
            }

            $data = array(
                "classes"       => $this->AcademyClass->get(),
                "sections"      => $this->Section->get(),
                "records"       => $records
            );

            $this->load->view("class_section/index", $data);
        }

        public function store() {
            if(!$this->session->user) {
                return redirect(base_url());
            }

            $academy_session_id = $this->session->user["academy_session_id"];
            $class_id = $this->input->post("class_id");
            $sections = $this->input->post("sections");

            foreach($sections as $section_id) {
                $this->ClassSection->insert(array(
                    "session_id" => $academy_session_id,
                    "class_id" => $class_id,
                    "section_id" => $section_id
                ));
            }

            return redirect(base_url("masters/class-section"));
        }

        public function update($id) {
            if(!$this->session->user) {
                return redirect(base_url());
            }
           
            $data = [
                "name" => $this->input->post('class')
            ];

            $this->AcademyClass->update($id, $data);

            $this->session->set_flashdata("success", "Record updated");
            return redirect(base_url() . "masters/class-section/");

        }

        public function delete($id) {
            if(!$this->session->user) {
                return redirect(base_url());
            }

            $this->ClassSection->delete($id);

         	$this->session->set_flashdata("success", "Record deleted");
            return redirect(base_url() . "masters/class-section/");
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