<?php 
    defined('BASEPATH') OR exit('No direct script access allowed');

    class StudentController extends CI_Controller {
        public function __construct() {
            parent::__construct();

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
            $this->load->model("Setting");
            $this->load->model("WithdrawnReason");
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
                    "student_session.promoted"  => "ANY"
                ));

                $this->load->view("student/index", array("classes" => $classes, "sections" => $sections, "students" => $students));
            }
            else if($class_id) {
                $sections = $this->ClassSection->get_sections($academy_session_id, $class_id);
                echo json_encode(array("sections" => $sections));
            }
            else {
                $classes = $this->AcademyClass->get();
                $this->load->view("student/index", array("classes" => $classes));
            }
        }

        public function create() {
            if(!$this->session->user) {
                return redirect(base_url());
            }

            $settings = [];
            $student_settings = $this->Setting->get("student");

            for($i = 0 ; $i < count($student_settings) ; $i++) {
                $settings[$student_settings[$i]['key_name']] = $student_settings[$i]['value'];
            };

            $data = array(
                "classes"       => $this->AcademyClass->get(),
                "sections"      => $this->Section->get(),
                "student_types" => $this->StudentType->get(),
                "houses"        => $this->House->get(),
                "categories"    => $this->Category->get(),
                "religions"     => $this->Religion->get(),
                "nationalities" => $this->Nationality->get(),
                "states"        => $this->State->get(),
                "student_no"    => $this->Student->get_the_last_insert_id(),
                "settings"      => $settings
            );

            $this->load->view("student/create", $data);
        }

        public function store() {
            if(!$this->session->user) {
                return redirect(base_url());
            }

            if($this->form_validation->run("student") == FALSE) {
                $settings = [];
                $student_settings = $this->Setting->get("student");
    
                for($i = 0 ; $i < count($student_settings) ; $i++) {
                    $settings[$student_settings[$i]['key_name']] = $student_settings[$i]['value'];
                };

                $academy_session_id = $this->session->academy_session['current_session']['id'];
                $class_id = trim($this->input->post('class_id'));
                $data = array(
                    "classes"       => $this->AcademyClass->get(),
                    "sections"      => $this->ClassSection->get_sections($academy_session_id, $class_id),
                    "student_types" => $this->StudentType->get(),
                    "houses"        => $this->House->get(),
                    "categories"    => $this->Category->get(),
                    "religions"     => $this->Religion->get(),
                    "nationalities" => $this->Nationality->get(),
                    "states"        => $this->State->get(),
                    "settings"      => $settings
                );

                $this->load->view("student/create", $data);
            }
            else {
                $data = array(
                    "status" => "ACTIVE",
                    "student_no" => $this->input->post('student_no'),
                    "roll_no" => $this->input->post('roll_no'),
                    "class_of_admission" => $this->input->post('class_of_admission'),
                    "admission_date" => date("Y-m-d", strtotime($this->input->post('admission_date'))),
                    "f_name" => $this->input->post('f_name'),
                    "m_name" => $this->input->post('m_name'),
                    "l_name" => $this->input->post('l_name'),
                    "sex" => $this->input->post('sex'),
                    "dob" => date("Y-m-d", strtotime($this->input->post('dob'))),
                    "blood_group" => $this->input->post('blood_group'),
                    "house_id" => $this->input->post('house_id'),
                    "category_id" => $this->input->post('category_id'),
                    "student_type_id" => $this->input->post('student_type_id'),
                    "religion_id" => $this->input->post('religion_id'),
                    "nationality_id" => $this->input->post('nationality_id'),
                    "state_id" => $this->input->post('state_id'),
                    "medical_status" => $this->input->post('medical_status'),
                    "class_id" => $this->input->post('class_id'),
                    "section_id" => $this->input->post('section_id'),
                    "ssid" => $this->input->post('ssid'),
                    "phone" => $this->input->post('phone'),
                    "email" => $this->input->post('email'),
                    "board_registration_no" => $this->input->post('board_registration_no'),
                    "aadhaar_no" => $this->input->post('aadhaar_no'),
                    "passport_no" => $this->input->post('passport_no'),
                    "passport_date_of_issue" => $this->input->post('passport_date_of_issue'),
                    "passport_valid_from" => $this->input->post('passport_valid_from'),
                    "passport_valid_to" => $this->input->post('passport_valid_to'),
                    "father_name" => $this->input->post('father_name'),
                    "mother_name" => $this->input->post('mother_name'),
                    "father_emp_no" => $this->input->post('father_emp_no'),
                    "mother_emp_no" => $this->input->post('mother_emp_no'),
                    "father_school_stuff" => $this->input->post('father_school_stuff'),
                    "mother_school_stuff" => $this->input->post('mother_school_stuff'),
                    "father_profession" => $this->input->post('father_profession'),
                    "mother_profession" => $this->input->post('mother_profession'),
                    "father_education" => $this->input->post('father_education'),
                    "mother_education" => $this->input->post('mother_education'),
                    "father_year_of_passing" => $this->input->post('father_year_of_passing'),
                    "mother_year_of_passing" => $this->input->post('mother_year_of_passing'),
                    "father_board" => $this->input->post('father_board'),
                    "mother_board" => $this->input->post('mother_board'),
                    "father_ex_student" => $this->input->post('father_ex_student'),
                    "mother_ex_student" => $this->input->post('mother_ex_student'),
                    "father_mobile" => $this->input->post('father_mobile'),
                    "mother_mobile" => $this->input->post('mother_mobile'),
                    "father_email" => $this->input->post('father_email'),
                    "father_passport_no" => $this->input->post('father_passport_no'),
                    "father_passport_date_of_issue" => $this->input->post('father_passport_date_of_issue'),
                    "father_passport_valid_from" => $this->input->post('father_passport_valid_from'),
                    "father_passport_valid_to" => $this->input->post('father_passport_valid_to'),
                    "mother_email" => $this->input->post('mother_email'),
                    "mother_passport_no" => $this->input->post('mother_passport_no'),
                    "mother_passport_date_of_issue" => $this->input->post('mother_passport_date_of_issue'),
                    "mother_passport_valid_from" => $this->input->post('mother_passport_valid_from'),
                    "mother_passport_valid_to" => $this->input->post('mother_passport_valid_to'),
                    "local_address" => $this->input->post('local_address'),
                    "permanent_address" => $this->input->post('permanent_address'),
                    "local_phone" => $this->input->post('local_phone'),
                    "permanent_phone" => $this->input->post('permanent_phone'),
                    "local_gurdian_name" => $this->input->post('local_gurdian_name'),
                    "local_gurdian_mobile" => $this->input->post('local_gurdian_mobile'),
                    "local_gurdian_address" => $this->input->post('local_gurdian_address'),
                    "local_gurdian_email" => $this->input->post('local_gurdian_email'),
                    "previous_school_name" => $this->input->post('previous_school_name'),
                    "previous_school_address" => $this->input->post('previous_school_address'),
                    "previous_school_phone" => $this->input->post('previous_school_phone'),
                    "previous_school_last_class_attend" => $this->input->post('previous_school_last_class_attend'),
                    "previous_school_year_of_leaving" => $this->input->post('previous_school_year_of_leaving'),
                    "previous_school_remarks" => $this->input->post('previous_school_remarks'),
                    "created_at" => date("Y-m-d", time())
                );

                $file = $this->upload_file("image");

                if($file["status"]) {
                    $data["image"] = $file['upload_data']['file_name'];
                }

                $student_id = $this->Student->insert($data);
                
                $this->Student->create_student_academy_session([
                    "student_id" => $student_id,
                    "session_id" => $this->session->academy_session['current_session']['id'],
                    "class_id" => $this->input->post('class_id'),
                    "section_id" => $this->input->post('section_id')
                ]);

                $this->session->set_flashdata("success", "New record inserted");
                return redirect(base_url() . "students/create");
            }
        }

        public function show($id) {
            if(!$this->session->user) {
                return redirect(base_url());
            }

            $student = $this->Student->get($id);
            
            $this->load->view("student/show", array('student' => $student));
        }


        public function search() {
            if(!$this->session->user) {
                return redirect(base_url());
            }
            
            $arr = $_GET;

            foreach($arr as $key=>$value)
            {
                if(is_null($value) || $value == '' || empty($value))
                    unset($arr[$key]);
            }
            
            if(array_key_exists("class_id", $arr)) {
                $arr["student_session.class_id"] = $arr["class_id"];
                unset($arr["class_id"]);
            }
            
            if(array_key_exists("section_id", $arr)) {
                $arr["student_session.section_id"] = $arr["section_id"];
                unset($arr["section_id"]);
            }

            $data = array(
                "classes"       => $this->AcademyClass->get(),
                "sections"      => $this->Section->get(),
                "student_types" => $this->StudentType->get(),
                "houses"        => $this->House->get(),
                "categories"    => $this->Category->get(),
                "religions"     => $this->Religion->get(),
                "nationalities" => $this->Nationality->get(),
                "states"        => $this->State->get()
            );

            if(count($arr) > 0)
                $data['students'] = $this->Student->search($arr);

            $this->load->view("student/search.php", $data);
        }

        public function batch_edits() {
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
                $houses = $this->House->get();
                $student_types = $this->StudentType->get();

                
                $students = $this->Student->get_where(array(
                    "student_session.class_id"      => $class_id,
                    "student_session.section_id"    => $section_id,
                ));
                
                $this->load->view("student/batch_edit", array("classes" => $classes, "sections" => $sections, "students" => $students, "houses" => $houses, "student_types" => $student_types));
            }
            else if($class_id) {
                $sections = $this->ClassSection->get_sections($academy_session_id, $class_id);
                echo json_encode(array("sections" => $sections));
            }
            else {
                $classes = $this->AcademyClass->get();
                $this->load->view("student/batch_edit", array("classes" => $classes));
            }
        }

        public function edit($id) {
            if(!$this->session->user) {
                return redirect(base_url());
            }

            $academy_session_id = $this->session->academy_session['current_session']['id'];
            $student = $this->Student->get($id);

            $data = array(
                "classes"       => $this->AcademyClass->get(),
                "sections"      => $this->ClassSection->get_sections($academy_session_id, $student['class_id']),
                "student_types" => $this->StudentType->get(),
                "houses"        => $this->House->get(),
                "categories"    => $this->Category->get(),
                "religions"     => $this->Religion->get(),
                "nationalities" => $this->Nationality->get(),
                "states"        => $this->State->get(),
                "student"       => $student
            );

            $this->load->view("student/edit", $data);
        }

        public function update() {
            if(!$this->session->user) {
                return redirect(base_url());
            }

            $id = $this->input->post("id");

            if($this->form_validation->run("student_edit") == FALSE) {

                $settings = [];
                $student_settings = $this->Setting->get("student");
    
                for($i = 0 ; $i < count($student_settings) ; $i++) {
                    $settings[$student_settings[$i]['key_name']] = $student_settings[$i]['value'];
                };

                $academy_session_id = $this->session->academy_session['current_session']['id'];
                $class_id = trim($this->input->post("class_id"));
                $data = array(
                    "classes"       => $this->AcademyClass->get(),
                    "sections"      => $this->ClassSection->get_sections($academy_session_id, $class_id),
                    "student_types" => $this->StudentType->get(),
                    "houses"        => $this->House->get(),
                    "categories"    => $this->Category->get(),
                    "religions"     => $this->Religion->get(),
                    "nationalities" => $this->Nationality->get(),
                    "states"        => $this->State->get(),
                    "settings" =>   $settings
                );

                $this->load->view("student/edit", $data);
            }
            else {
                $file = $this->upload_file("image");


                if($file["status"]) {
                    $prev_image = $this->input->post('prev_image');
                    unlink('storage/students/' . $prev_image);
                    $_POST["image"] = $file['upload_data']['file_name'];
                }

                unset($_POST['prev_image']);
                $this->Student->update($id, $_POST);
                $this->session->set_flashdata("success", "Record Updated");
                return redirect(base_url() . "students/show/".$id);
            }
        }

        public function batch_updates() {

            if(!$this->session->user) {
                return redirect(base_url());
            }
            
            $ids = $this->input->post('id');
            $roll_nos = $this->input->post('roll_no');
            $section_ids = $this->input->post('section_id');
            $class_ids = $this->input->post('class_id');
            $house_ids = $this->input->post('house_id');
            $student_type_ids = $this->input->post('student_type_id');

            $data = array();

            for($i = 0; $i < count($ids); $i++) {
                $data[] = array(
                    "id" => $ids[$i],
                    "roll_no" => $roll_nos[$i],
                    "house_id" => $house_ids[$i],
                    "student_type_id" => $student_type_ids[$i]
                );
                
                $student_session_data[] = [
                    "id" => $ids[$i],
                    'class_id' =>   $class_ids[$i],
                    "section_id" => $section_ids[$i],
                    "session_id" => $this->session->academy_session['current_session']['id']
                ];
            }

            $this->Student->update_batch($data, $student_session_data);
            $this->session->set_flashdata("success", "Record updated successfully");
            return redirect(base_url() . "students/batch/edits");

        }

        public function passport() {
            if(!$this->session->user) {
                return redirect(base_url());
            }

            $params = [];
            $students = [];
            
            if($_GET['class_id'] != "") {
                $params["student_session.class_id"] = $_GET['class_id'];
            }
            
            if($_GET['section_id'] != "") {
                $params["student_session.section_id"] = $_GET['section_id'];
            }
            
            if($_GET['nationality_id'] != "") {
                $params["students.nationality_id"] = $_GET['nationality_id'];
            }
        
            if(count($params) > 0) {
                $students = $this->Student->search($params);
            }
            
            $data = [
                "classes" => $this->AcademyClass->get(),
                "sections" => $this->Section->get(),
                "nationalities" => $this->Nationality->get(),
                "students" => $students
            ];

            $this->load->view("student/passport", $data);
        }

        public function passport_show($id) {
            if(!$this->session->user) {
                return redirect(base_url());
            }

            $data = [
                "student" => $this->Student->get($id)
            ];

            $this->load->view("student/passport_show", $data);

        }

        public function passport_update() {
            if(!$this->session->user) {
                return redirect(base_url());
            }

            $id = $this->input->post('id');

            $this->Student->update($id, $_POST);

            $this->session->set_flashdata("success", "Record updated");
            return redirect(base_url() . "students/passport/show/" . $id);
        }

        public function report() {

            $report_id = $this->input->get("report_id");
            $student_id = $this->input->get("student_id");
            $serial_no = $this->input->get("serial_no");
            $total_years = $this->input->get("total_years");
            $start_year = $this->input->get("start_year");

            $data = [
                "student" => $this->Student->get($student_id),
                "serial_no" => $serial_no,
                "total_years" => $total_years,
                "start_year" => $start_year,
                "session_start" => $this->session->academy_session['current_session']['start'],
                "session_end" => $this->session->academy_session['current_session']['end'],
            ];

            if($report_id == "1") {
                $this->load->view("student/non_indian_existing_student_bonafide", $data);
            }
            else if($report_id == "2") {
                $this->load->view("student/non_indian_new_student_bonafide", $data);
            }
            else if($report_id == "3") {
                $this->load->view("student/visa_1_non_indian", $data);
            }
            else {
                $this->load->view("student/visa_2_non_indian", $data);
            }
        }

        public function delete($id) {
            if(!$this->session->user) {
                return redirect(base_url());
            }
 
        }

        // Student List
        public function get_withdrawn_students_list() {
            if(!$this->session->user) {
                return redirect(base_url());
            }
  
            if($_SERVER["REQUEST_METHOD"] == "GET") {
                
                $class_id   = $this->input->get("class_id");
                $section_id = $this->input->get("section_id");
                
                if($class_id) {
                    $sections = $this->ClassSection->get_sections($academy_session_id, $class_id);
                    echo json_encode(array("sections" => $sections));
                }
                else {
                    $classes = $this->AcademyClass->get();
                    $students = [];
                    
                    $this->load->view("student/withdrawn_students", array("classes" => $classes, "students" => $students));
                }
            }
            
            else {
                $params = [];    
                
                if(isset($_POST['class_id']) && $_POST['class_id'] != "") {
                    $params["withdrawn_students.class_id"] = $_POST['class_id'];
                }
                
                if(isset($_POST['section_id']) && $_POST['section_id'] != "") {
                    $params["withdrawn_students.section_id"] = $_POST['section_id'];
                }
                
                if(isset($_POST['student_no']) && $_POST['student_no'] != "") {
                    $params["students.student_no"] = $_POST['student_no'];
                }
                
                if(isset($_POST['student_name']) && $_POST['student_name'] != "") {
                    $names = explode(" ", $_POST['student_name']);
                    
                    if(count($names) >= 1) {
                        $params["students.f_name"] = $names[0];
                    }
                    
                    if(count($names) >= 2) {
                        $params["students.l_name"] = $names[1];
                    }
                    
                    if(count($names) >= 3) {
                        $params["students.m_name"] = $names[1];
                        $params["students.l_name"] = $names[2];
                    }
                }
                
                $classes = $this->AcademyClass->get();
                $students = $this->WithdrawnReason->get_withdrawn_students($params);
                $academy_session_id = $this->session->academy_session['current_session']['id'];
                $sections = $this->ClassSection->get_sections($academy_session_id, $_POST['class_id']);
                
                $this->load->view("student/withdrawn_students", array("classes" => $classes, "sections" => $sections, "students" => $students, "data" => $_POST));
            }
            
        }
        
        // Student List
        public function get_all_withdrawn_students_list() {
            if(!$this->session->user) {
                return redirect(base_url());
            }
            
            $params = [];    
                
            if(isset($_POST['class_id']) && $_POST['class_id'] != "") {
                $params["withdrawn_students.class_id"] = $_POST['class_id'];
            }
            
            if(isset($_POST['section_id']) && $_POST['section_id'] != "") {
                $params["withdrawn_students.section_id"] = $_POST['section_id'];
            }
            
            if(isset($_POST['student_no']) && $_POST['student_no'] != "") {
                $params["students.student_no"] = $_POST['student_no'];
            }
            
            if(isset($_POST['student_name']) && $_POST['student_name'] != "") {
                $names = explode(" ", $_POST['student_name']);
                
                if(count($names) >= 1) {
                    $params["students.f_name"] = $names[0];
                }
                
                if(count($names) >= 2) {
                    $params["students.l_name"] = $names[1];
                }
                
                if(count($names) >= 3) {
                    $params["students.m_name"] = $names[1];
                    $params["students.l_name"] = $names[2];
                }
            }
            
            $classes = $this->AcademyClass->get();
            $students = $this->WithdrawnReason->get_all_withdrawn_students($params);
            
            $this->load->view("student/all_withdrawn_students", array("classes" => $classes, "students" => $students, "data" => $_POST));
        }
        
        // Student List
        public function withdrawn_students_list() {
            $students = $this->WithdrawnReason->get_withdrawn_students([
                "class_id" => $this->input->post('class_id'), 
                "section_id" => $this->input->post('section_id'),
                "session_id" => $this->session->academy_session['current_session']['id']
            ]);
            
            // echo "<pre>";
            // print_r($students);
            // echo "</pre>";
            // return;
            
            $this->load->view("student/withdrawn_students", array("students" => $students));
        }

        // New Student Withdrawn
        public function new_withdrawn_student() {
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
                
                $reasons = $this->WithdrawnReason->get();
                
                $students = $this->Student->get_where(array(
                    "class_id"      => $class_id,
                    "section_id"    => $section_id,
                ));

                $this->load->view("student/new_withdrawal", array("classes" => $classes, "sections" => $sections, "students" => $students, "reasons" => $reasons));
            }
            else if($class_id) {
                $sections = $this->ClassSection->get_sections($academy_session_id, $class_id);
                echo json_encode(array("sections" => $sections));
            }
            else {
                $classes = $this->AcademyClass->get();
                $this->load->view("student/new_withdrawal", array("classes" => $classes));
            }
        }
        
        // Student List
        public function withdrawn_student() {
            $data = [
                "class_id" => $this->input->post('class_id'),
                "section_id" => $this->input->post('section_id'),
                "student_id" => $this->input->post('id'),
                "tc_no" => $this->input->post('tc_no'),
                "tc_date" => $this->input->post('tc_date'),
                "date_of_leaving" => $this->input->post('date_of_leaving'),
                "session_id" => $this->session->academy_session['current_session']['id'],
                "reason" => $this->input->post('reason')
            ];
            
            $this->WithdrawnReason->new_withdrawn($data);
            
            $this->session->set_flashdata("success", "Record updated");
            return redirect(base_url() . "students/new-withdrawal");
        }
        
        public function delete_withdrawn_student() {
            $this->WithdrawnReason->delete_withdrawn_student($this->input->post('id'));
            
            $this->session->set_flashdata("success", "Record deleted");
            
            $referrer = $this->input->server('HTTP_REFERER');

            redirect($referrer, 'refresh');
        }
        
        public function generate_transfer_certificate() {
            $student_id         = $this->input->get("student_id");
            $tc_no              = $this->input->get("tc_no");
            $tc_date            = $this->input->get("tc_date");
            $date_of_leaving    = $this->input->get("date_of_leaving");
            $reason             = $this->input->get("reason");
            
            $student_data = $this->Student->get($student_id);
            $saved_data = $this->WithdrawnReason->get_withdrawn_students_saved_data($student_id)[0];
            
            $this->load->view("student/create_transfer_certificate", array("student_id" => $student_id, "student_data" => $student_data, "saved_data" => $saved_data, "tc_no" => $tc_no, "tc_date" => $tc_date, "date_of_leaving" => $date_of_leaving, "reason" => $reason));
        }
        
        public function store_transfer_certificate() {
           
            $student_id = $this->input->post("student_id");
            $student_data = $this->Student->get($student_id);
            
            $data = [
              "field_1"         =>  $this->input->post("field_1"),
              "field_2"         =>  $this->input->post("field_2"),
              "field_3"         =>  $this->input->post("field_3"),
              "field_4"         =>  $this->input->post("field_4"),
              "field_5"         =>  $this->input->post("field_5"),
              "field_6"         =>  $this->input->post("field_6"),
              "field_7"         =>  $this->input->post("field_7"),
              "field_8"         =>  $this->input->post("field_8"),
              "field_9"         =>  $this->input->post("field_9"),
              "field_10"        =>  $this->input->post("field_10"),
              "field_11"        =>  $this->input->post("field_11"),
              "field_12"        =>  $this->input->post("field_12"),
            ];
            
            $this->WithdrawnReason->update_withdrawn_students($student_id, ["transfer_certificate" => json_encode($data)]);
            
            $this->load->view("student/view_transfer_certificate.php", [
                "data"              =>  $data,
                "tc_no"             =>  $this->input->post("tc_no"),
                "tc_date"           =>  $this->input->post("tc_date"),
                "date_of_leaving"   =>  $this->input->post("date_of_leaving"),
                "reason"            =>  $this->input->post("reason"),
                "student_data"      =>  $student_data
            ]);
        }
        
                
        public function generate_charecter_certificate() {
            $student_id         = $this->input->get("student_id");
            $tc_no              = $this->input->get("tc_no");
            $tc_date            = $this->input->get("tc_date");
            $date_of_leaving    = $this->input->get("date_of_leaving");
            $reason             = $this->input->get("reason");
            
            $student_data = $this->Student->get($student_id);
            $saved_data = $this->WithdrawnReason->get_withdrawn_students_saved_data($student_id)[0];

            $this->load->view("student/create_charecter_certificate", array("student_id" => $student_id, "student_data" => $student_data, "saved_data" => $saved_data, "tc_no" => $tc_no, "tc_date" => $tc_date, "date_of_leaving" => $date_of_leaving, "reason" => $reason));
        }
        
        public function store_charecter_certificate() {
           
            $student_id = $this->input->post("student_id");
            
            $data = [
              "field_1"         =>  $this->input->post("field_1"),
              "field_2"         =>  $this->input->post("field_2"),
              "field_3"         =>  $this->input->post("field_3"),
              "field_4"         =>  $this->input->post("field_4"),
              "field_5"         =>  $this->input->post("field_5"),
              "field_6"         =>  $this->input->post("field_6"),
            ];

            $this->WithdrawnReason->update_withdrawn_students($student_id, ["charecter_certificate" => json_encode($data)]);
            
            $this->load->view("student/view_charecter_certificate.php", [
                "data"              =>  $data,
                "tc_no"             =>  $this->input->post("tc_no"),
                "tc_date"           =>  $this->input->post("tc_date"),
                "date_of_leaving"   =>  $this->input->post("date_of_leaving"),
                "reason"            =>  $this->input->post("reason"),
            ]);
        }
        
        
        public function get_passout_students_list() {
            if(isset($_GET['class_id']) && isset($_GET["section_id"])) {
                $students = $this->Student->get_where([
                    "student_session.passout" => 1,
                    "class_id" => $_GET['class_id'],
                    "section_id" => $_GET["section_id"]
                ]);    
                
                $already_saved_data = $this->Student->get_passout_student_date([
                    "class_id" => $_GET['class_id'],
                    "section_id" => $_GET["section_id"]
                ]);
            }
            else {
                $students = $this->Student->get_where([
                    "student_session.passout" => 1,
                ]);
                
                $already_saved_data = $this->Student->get_passout_student_date([]);
            }
            
            $saved_students = [];
            foreach($already_saved_data as $s) {
                $saved_students[] = $s["id"];
            }
            
            $data = [];
            
            
            foreach($students as $student) {
                $matched = 0;
                foreach($already_saved_data as $asd)  {
                    if($student['id'] == $asd['student_id']) {
                        $data[] = [
                            "student_no" => $student["student_no"],
                            "f_name" => $student["f_name"],
                            "m_name" => $student["m_name"],
                            "l_name" => $student["l_name"],
                            "roll_no" => $student["roll_no"],
                            "class_id" => $asd['class_id'],
                            "section_id" => $asd['section_id'],
                            "student_id" => $asd['student_id'],
                            "tc_no" => $asd['tc_no'],
                            "tc_date" => $asd['tc_date'],
                            "date_of_leaving" => $asd['date_of_leaving'],
                            "session_id" => $asd['session_id'],
                        ];
                        
                        $matched = 1;
                        break;
                    }
                }
                
                if($matched == 0) {
                    $data[] = [
                        "student_no" => $student["student_no"],
                        "f_name" => $student["f_name"],
                        "m_name" => $student["m_name"],
                        "l_name" => $student["l_name"],
                        "roll_no" => $student["roll_no"],
                        "class_id" => $student['class_id'],
                        "section_id" => $student['section_id'],
                        "student_id" => $student['id'],
                        "tc_no" => "",
                        "tc_date" => "",
                        "date_of_leaving" => "",
                        "session_id" => $this->session->academy_session['current_session']['id'],
                    ];
                }
            }
            
            
            $this->load->view("student/passout_students", [
                "students"  =>  $data,
                "classes"   => $this->AcademyClass->get(),
            ]);
        }
        
        public function store_passout_students_data() {

            $data = [
                "class_id" => $this->input->post("class_id"),
                "section_id" => $this->input->post("section_id"),
                "student_id" => $this->input->post("student_id"),
                "tc_no" => $this->input->post('tc_no'),
                "tc_date" => $this->input->post('tc_date'),
                "date_of_leaving" => $this->input->post('date_of_leaving'),
                "session_id" => $this->input->post("session_id"),
            ];
            
            $saved_data = $this->Student->store_passout_student_date($data);
            
            $this->session->set_flashdata("success", "Record updated");
            return redirect(base_url() . "students/passout-students");
        }
        
        public function delete_passout_student() {}
        public function generate_transfer_certificate_for_passout() {}
        public function store_transfer_certificate_for_passout() {}
        public function generate_charecter_certificate_for_passout() {}
        public function store_charecter_certificate_for_passout() {}
        

        protected function upload_file($photo){
            $config['upload_path']          = 'storage/students';
            $config['allowed_types']        = 'jpg|jpeg|png';
            $config['file_name']            = 'student-' . time(); 
    
            $this->load->library('upload', $config);
    
            if ( $this->upload->do_upload($photo))
            {
                return array(
                    'status' => true,
                    'upload_data' => $this->upload->data()
                );                
            }
            else
            {
                return array(
                    'status' => false,
                    'error' => $this->upload->display_errors()
                );    
            }
        }
        
        public function is_student_no_exist() {
            if(!$this->session->user) {
                return redirect(base_url());
            }
            
            $student_no = $this->input->get('student_no');
            
            $exist = $this->Student->is_student_no_exist($student_no);
            
            echo json_encode(['exist' => $exist]);
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