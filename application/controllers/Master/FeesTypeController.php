<?php 
    defined('BASEPATH') OR exit('No direct script access allowed');

    class FeesTypeController extends CI_Controller {
        public function __construct() {
            parent::__construct();
            $this->load->model("Fees");
            $this->load->model("AcademyClass");
            $this->load->model("ClassSection");
            $this->load->model("StudentType");
        }

        public function index() {
            if(!$this->session->user) {
                return redirect(base_url());
            }

            $data = array(
                "records" => $this->Fees->get()
            );
            
            $this->load->view("master/fees_types.php", $data);
        }

        public function store() {
            if(!$this->session->user) {
                return redirect(base_url());
            }

            $data = array(
                "name" => $this->input->post('fees_type'),
                "created_at" => date("Y-m-d")
            );

            $this->Fees->insert($data);
            $this->session->set_flashdata("success", "New record inserted");
            
            return redirect(base_url() . "masters/fees-types/");
        }

        public function update($id) {
            if(!$this->session->user) {
                return redirect(base_url());
            }
           
            $data = [
                "name"      => $this->input->post('fees_type'),
            ];

            $this->Fees->update($id, $data);

            $this->session->set_flashdata("success", "Record updated");
            return redirect(base_url() . "masters/fees-types/");

        }

        public function delete($id) {
            if(!$this->session->user) {
                return redirect(base_url());
            }

            $this->Fees->delete($id);

         	$this->session->set_flashdata("success", "Record deleted");
            return redirect(base_url() . "masters/fees-types/");
        }
        
        
        
        // Assign Fees Type
        public function class_student_fees_index() {
            if(!$this->session->user) {
                return redirect(base_url());
            }
            
            $data = array(
                "fees_types"    => $this->Fees->get(),
                "classes"       => $this->AcademyClass->get(),
                "student_types" => $this->StudentType->get(),
            ); 
      
            $this->load->view("master/class_studentType_feesType.php", $data);
        }
        
        // Class Student Type Fees Head List
        public function class_student_get_fees() {
            if(!$this->session->user) {
                return redirect(base_url());
            }
            
            $fees_types     = $this->Fees->get();
            $classes        = $this->AcademyClass->get();
            $student_types  = $this->StudentType->get();
            $records         = $this->Fees->get_class_student_fees($classes, $student_types);

            // echo "<pre>";
            // print_r($records);
            // echo "</pre>";
            // exit();
            
            $this->load->view("master/class_studentType_feesType_list.php", ['records' => $records, 
            "fees_types" => $fees_types, "classes" => $classes, "student_types" => $student_types]);
        }

        // Function to generate combinations
        function generateCombinations($arrays) {
            // Start with an array containing an empty array
            $result = [[]];
            
            // Loop through each array
            foreach ($arrays as $array) {
                $temp = [];
                
                // For each combination generated so far
                foreach ($result as $combination) {
                    // For each element in the current array
                    foreach ($array as $element) {
                        // Combine the previous combinations with the current element
                        $temp[] = array_merge($combination, [$element]);
                    }
                }
                
                // Update the result with the new combinations
                $result = $temp;
            }
            
            return $result;
        }
            
        public function class_student_fees_store() {
            if(!$this->session->user) {
                return redirect(base_url());
            }
            
            $selected_class_ids = $_POST['class_ids'];
            $student_type_ids = $_POST['student_type_ids'];
            $fees_heads = $_POST['fees_ids'];

            // Combine all three arrays
            $combinations = $this->generateCombinations([$selected_class_ids, $student_type_ids, $fees_heads]);
            
            foreach($combinations as $combination) {
                $this->Fees->update_class_student_fees($combination);
            }
            
            $this->session->set_flashdata("success", "Operation Performed Successfully");
            
            return redirect(base_url() . "masters/assign-fees-types");
        }
        
        public function class_student_fees_change_status($data) {
            if(!$this->session->user) {
                return redirect(base_url());
            }
            
            $records = explode("_", $data);
            
            $this->Fees->class_student_fees_change_status($records);
            
            $this->session->set_flashdata("success", "Record deleted successfully");
            
            return redirect(base_url() . "masters/assign-fees-types-list");
        }
        
        
        public function class_student_fees_delete($data) {
            if(!$this->session->user) {
                return redirect(base_url());
            }
            
            $records = explode("_", $data);
            
            $this->Fees->delete_class_student_fees($records);
            
            $this->session->set_flashdata("success", "Record deleted successfully");
            
            return redirect(base_url() . "masters/assign-fees-types-list");
        }

        
        // Due Fees Type
        // public function fees_due_index() {
        //     if(!$this->session->user) {
        //         return redirect(base_url());
        //     }
            
        //     $data = array(
        //         "fees_types"    => $this->Fees->get(),
        //         "classes"       => $this->AcademyClass->get(),
        //         "student_types" => $this->StudentType->get(),
        //     ); 
      
        //     $this->load->view("master/class_studentType_feesType.php", $data);
        // }
        
        // public function fees_due_create() {
        //     if(!$this->session->user) {
        //         return redirect(base_url());
        //     }
            
        //     $data;
        //     $class_id           = $this->input->get("class_id");
        //     $section_id         = $this->input->get("section_id");
        //     $student_type_id    = $this->input->get("student_type_id");
        //     $academy_session_id = $this->session->academy_session['current_session']['id'];

        //     if($class_id && $section_id && $student_type_id) {
                
        //         $students = $this->Student->get_where(array(
        //             "class_id"      => $class_id,
        //             "section_id"    => $section_id,
        //             "student_type_id"   => $student_type_id,
        //             "student_session.promoted"  => "ANY"
        //         ));

        //         $this->load->view("fees/due_fees_create", array(
        //             "classes" => $classes, 
        //             "sections" => $sections, 
        //             "student_types" => $student_types,
        //             "students" =>  $students
        //         ));
                
        //     }
        //     else {
                
        //         $classes = $this->AcademyClass->get();
        //         $student_types = $this->StudentType->get();
        //         $this->load->view("fees/due_fees_create", array(
        //             "classes" => $classes, 
        //             "student_types"  => $student_types
        //         ));
                
        //     }
        // }

        // public function fees_due_store() {
        //     if(!$this->session->user) {
        //         return redirect(base_url());
        //     }
            
        //     $selected_class_ids = $_POST['class_ids'];
        //     $student_type_ids = $_POST['student_type_ids'];
        //     $fees_heads = $_POST['fees_ids'];

        //     // Combine all three arrays
        //     $combinations = $this->generateCombinations([$selected_class_ids, $student_type_ids, $fees_heads]);


        //     foreach($combinations as $combination) {
        //         $this->Fees->update_class_student_fees($combination);
        //     }
            
        //     $this->session->set_flashdata("success", "New record inserted");
            
        //     return redirect(base_url() . "masters/assign-fees-types");
        // }

        // public function fees_due_update($id) {
        //     if(!$this->session->user) {
        //         return redirect(base_url());
        //     }
           
        //     $data = [
        //         "name" => $this->input->post('fees_type')
        //     ];

        //     $this->Fees->update($id, $data);

        //     $this->session->set_flashdata("success", "Record updated");
        //     return redirect(base_url() . "masters/fees-types/");

        // }

        // public function fees_due_delete($id) {
        //     if(!$this->session->user) {
        //         return redirect(base_url());
        //     }

        //     $this->Fees->delete($id);

        //  	$this->session->set_flashdata("success", "Record deleted");
        //     return redirect(base_url() . "masters/fees-types/");
        // }
    }