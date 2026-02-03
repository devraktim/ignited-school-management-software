<?php 
    defined('BASEPATH') OR exit('No direct script access allowed');

    class FeesController extends CI_Controller {
        public function __construct() {
            parent::__construct();
            
            $this->load->model("Fees");
            $this->load->model("Setting");
            $this->load->model("Student");
            $this->load->model("AcademyClass");
            $this->load->model("Section");
            $this->load->model("ClassSection");
            $this->load->model("StudentType");
        }

        // Due Fees
        public function fees_due_list() {
            if(!$this->session->user) {
                return redirect(base_url());
            }
            
            $data;
            $class_id           = $this->input->get("class_id");
            $section_id         = $this->input->get("section_id");
            $student_type_id    = $this->input->get("student_type_id");
            $academy_session_id = $this->session->academy_session['current_session']['id'];

            if($class_id && $section_id && $student_type_id) {
                
                $classes = $this->AcademyClass->get();
                $student_types = $this->StudentType->get();
                $sections = $this->ClassSection->get_sections($academy_session_id, $class_id);
                
                $students = $this->Student->get_where(array(
                    "class_id"      => $class_id,
                    "section_id"    => $section_id,
                    "student_type_id"   => $student_type_id,
                    "student_session.promoted"  => "ANY"
                ));
                
                $records = [];
                
                foreach ($students as $student) {
                    $fees = $this->Fees->get_outstanding_fees([
                                "student_id"        => $student['id'],
                                "current_session_id"=>  $this->session->academy_session['current_session']['id'],
                            ]);
                    
                    $student['amount'] = $fees['amount'];
                    
                    $records[] = $student;
                }
                
                $this->load->view("fees/due_fees_list", array(
                    "classes" => $classes, 
                    "sections" => $sections, 
                    "student_types" => $student_types,
                    "students" =>  $records
                ));
                
            }
            else {
                
                $classes = $this->AcademyClass->get();
                $student_types = $this->StudentType->get();
                $this->load->view("fees/due_fees_list", array(
                    "classes" => $classes, 
                    "student_types"  => $student_types
                ));
                
            }
        }
        
        public function fees_due_create() {
            if(!$this->session->user) {
                return redirect(base_url());
            }
            
            $data;
            $class_id           = $this->input->get("class_id");
            $section_id         = $this->input->get("section_id");
            $student_type_id    = $this->input->get("student_type_id");
            $academy_session_id = $this->session->academy_session['current_session']['id'];

            if($class_id && $section_id && $student_type_id) {
                
                $classes = $this->AcademyClass->get();
                $student_types = $this->StudentType->get();
                $sections = $this->ClassSection->get_sections($academy_session_id, $class_id);
                
                $students = $this->Student->get_where(array(
                    "class_id"      => $class_id,
                    "section_id"    => $section_id,
                    "student_type_id"   => $student_type_id,
                    "student_session.promoted"  => "ANY"
                ));
                
                $records = [];
                
                foreach ($students as $student) {
                    $fees = $this->Fees->get_outstanding_fees([
                                "student_id"        => $student['id'],
                                "current_session_id"=>  $this->session->academy_session['current_session']['id'],
                            ]);
                    
                    $student['amount'] = $fees['amount'];
                    
                    $records[] = $student;
                }
                
                $this->load->view("fees/due_fees_create", array(
                    "classes" => $classes, 
                    "sections" => $sections, 
                    "student_types" => $student_types,
                    "students" =>  $records
                ));
                
            }
            else {
                
                $classes = $this->AcademyClass->get();
                $student_types = $this->StudentType->get();
                $this->load->view("fees/due_fees_create", array(
                    "classes" => $classes, 
                    "student_types"  => $student_types
                ));
                
            }
        }

        public function fees_due_store() {
            if(!$this->session->user) {
                return redirect(base_url());
            }
            
            $records = $_POST;
            
            for($i = 0 ; $i < count($records['student_id']) ; $i++) {
                
                $this->Fees->insert_or_update_outstanding_fees([
                    "student_id"    => $records['student_id'][$i],
                    "amount"        => $records['amount'][$i],
                ]);
                
            }
            
            $this->session->set_flashdata("success", "New record inserted");
            
            return redirect(base_url() . "fees/fees-due/create");
        }
        
        
        // Payment Plan Routes
        public function payment_plan_view() {
            if(!$this->session->user) {
                return redirect(base_url());
            }
            
            $fees = $this->Setting->get("fees");
            $records = [];
            
            
            foreach($fees as $fee) {
                $records[$fee["key_name"]] = $fee["value"];
            }
            
            $data  = [];
            $data['type'] = $records['type'];
            $data['display'] = $records['display'];

            if($data['type'] == "installments") {
                $installments =  [];
                
                foreach($records as $key => $value) {
                    if (substr_count($key, '_') == 2) {
                        
                    }
                }
            }
      
            $this->load->view("master/payment_plan_view", ["data" => $data]);
            
        }
        
        public function payment_plan_create() {
            if(!$this->session->user) {
                return redirect(base_url());
            }
            
            $fees = $this->Setting->get("fees");
            $records = [];
            
            foreach($fees as $fee) {
                $records[$fee["key_name"]] = $fee["value"];
            }
            
            $data  = [];
            $data['type'] = $record['type'];
            
            
            if($data['type'] == "installments_months") {
                $installments =  [];
                
                foreach($records as $key => $value) {
                    if (substr_count($key, '_') == 2) {
                        
                    }
                }
            }
            
            $this->load->view("master/payment_plan", ["records" => $records]);
        }
    
        public function payment_plan_store() {
            if(!$this->session->user) {
                return redirect(base_url());
            }
            
            $records = [];
            
            foreach ($_POST as $key => $value) {
                $records[] = [
                    "module"    => "fees",
                    "key_name"  => $key,
                    "value"     => $value
                ];
            }
            
            $this->Setting->delete_module("fees");
            $this->Setting->insert_or_update($records);
            
            $this->session->set_flashdata("success", "New record inserted");
            
            return redirect(base_url() . "master/payment-plan/create");
        }
        
        
        // Fees concession
        public function fees_concession_list() {
            if(!$this->session->user) {
                return redirect(base_url());
            }
            
            $data;
            $class_id           = $this->input->get("class_id");
            $section_id         = $this->input->get("section_id");
            $student_type_id    = $this->input->get("student_type_id");
            $academy_session_id = $this->session->academy_session['current_session']['id'];
            
            $classes = $this->AcademyClass->get();
            $student_types = $this->StudentType->get();
            $sections = $this->ClassSection->get_sections($academy_session_id, $class_id);
            
            $fees = $this->Setting->get("fees");
            $fees_setting = [];
            
            foreach($fees as $fee) {
                $fees_setting[$fee["key_name"]] = $fee["value"];
            }
            
            $payment_plan_type = $fees_setting["type"];
            $payment_plan_type_display = $fees_setting["display"];
            
            if($class_id && $section_id && $student_type_id) {
                $students = $this->Student->get_where(array(
                    "class_id"      => $class_id,
                    "section_id"    => $section_id,
                    "student_type_id"   => $student_type_id,
                    "student_session.promoted"  => "ANY"
                ));
                
                $records = [];
                
                foreach ($students as $student) {
                    $concession = $this->Fees->get_concession_fees($student['id']);
                    $student['concession'] =  $concession;
                    $records[] = $student; 
                }

                // echo "<pre>";
                // print_r($this->session->academy_session);
                // echo "</pre>";
                // exit();
                
                $this->load->view("fees/fees_concession_list", array(
                    "classes"                   => $classes, 
                    "sections"                  => $sections, 
                    "student_types"             => $student_types,
                    "students"                  => $records,
                    "payment_plan_type"         => $payment_plan_type,
                    "payment_plan_type_display" => $payment_plan_type_display
                ));
            }
            else {
                $this->load->view("fees/fees_concession_list", array(
                    "classes" => $classes, 
                    "sections" => $sections, 
                    "student_types" => $student_types,
                ));
            }
        }
        
        public function fees_concession_create() {
            if(!$this->session->user) {
                return redirect(base_url());
            }
            
            $data;
            $class_id           = $this->input->get("class_id");
            $section_id         = $this->input->get("section_id");
            $student_type_id    = $this->input->get("student_type_id");
            $academy_session_id = $this->session->academy_session['current_session']['id'];
            
            $classes = $this->AcademyClass->get();
            $student_types = $this->StudentType->get();
            $sections = $this->ClassSection->get_sections($academy_session_id, $class_id);
            
            $fees = $this->Setting->get("fees");
            $fees_setting = [];
            
            foreach($fees as $fee) {
                $fees_setting[$fee["key_name"]] = $fee["value"];
            }
            
            $payment_plan_type = $fees_setting["type"];
            $payment_plan_type_display = $fees_setting["display"];
            
            if($class_id && $section_id && $student_type_id) {
                $students = $this->Student->get_where(array(
                    "class_id"      => $class_id,
                    "section_id"    => $section_id,
                    "student_type_id"   => $student_type_id,
                    "student_session.promoted"  => "ANY"
                ));
                
                $records = [];
                
                foreach ($students as $student) {
                    $concession = $this->Fees->get_concession_fees($student['id']);
                    
                    if(!$concession) {
                        $student['concession'] =  $concession;
                        $records[] = $student; 
                    }
    
                }

                $this->load->view("fees/fees_concession", array(
                    "classes"                   => $classes, 
                    "sections"                  => $sections, 
                    "student_types"             => $student_types,
                    "students"                  => $records,
                    "payment_plan_type"         => $payment_plan_type,
                    "payment_plan_type_display" => $payment_plan_type_display
                ));
            }
            else {
                $this->load->view("fees/fees_concession", array(
                    "classes" => $classes, 
                    "sections" => $sections, 
                    "student_types" => $student_types,
                ));
            }
        }

        public function fees_concession_store() {
            if(!$this->session->user) {
                return redirect(base_url());
            }

            foreach ($_POST as $key => $value) {
                if ($key != "student_id") {
                    $this->Fees->store_concession_fees($key, $value, $_POST['student_id']);
                }
            }

            $this->session->set_flashdata("success", "New record inserted");
            
            return redirect(base_url() . "fees/fees-concession/create");
        }
        
        public function fees_concession_update() {
            if(!$this->session->user) {
                return redirect(base_url());
            }
            
            foreach ($_POST as $key => $value) {
                if ($key != "student_id") {
                    $this->Fees->update_concession_fees($key, $value, $_POST['student_id']);
                }
            }
            
            // Set the Content-Type header to tell the browser this is JSON
            header('Content-Type: application/json');
            
            // Create an associative array (or data) to send back
            $response = [
                'success' => 1,
                'message' => 'Data updated successfully!',
            ];
            
            // Encode the array into JSON format and return it
            echo json_encode($response);
        }
        
        
        // Fees Setting
        public function fees_setting_create() {
            if(!$this->session->user) {
                return redirect(base_url());
            }

            $settings = [];
            $student_settings = $this->Setting->get("fees_setting");

            for($i = 0 ; $i < count($student_settings) ; $i++) {
                $settings[$student_settings[$i]['key_name']] = $student_settings[$i]['value'];
            };

            $data = array(
                "settings"      => $settings
            );  

            $this->load->view("fees/setting", $data);
        }

        public function fees_setting_store() {
            if(!$this->session->user) {
                return redirect(base_url());
            }
            

            $keys = array_keys($_POST);
            $values = array_values($_POST);

            $data = array();

            for($i = 0 ; $i < count($keys) ; $i++) {
                $data[] = [
                    "module" => "fees_setting",
                    "key_name" => $keys[$i],
                    "value" => $values[$i]
                ];
            };

            $this->Setting->insert_or_update($data);

            $this->session->set_flashdata("success", "Data stored successfully");
            return redirect(base_url() . "fees/setting/create");
            
        }
        
        
        // Month Fees
        public function school_fees_list() {
            if(!$this->session->user) {
                return redirect(base_url());
            }
            
            $class_id           = $this->input->get("class_id");
            $section_id         = $this->input->get("section_id");
            $student_type_id    = $this->input->get("student_type_id");
            $academy_session_id = $this->session->academy_session['current_session']['id'];
            
            $classes        = $this->AcademyClass->get();
            $sections       = $this->ClassSection->get_sections($academy_session_id, $class_id);
            $student_types  = $this->StudentType->get();
            $fees_heads     = $this->Fees->get();
            $records        = [];

            if($class_id && $section_id && $student_type_id) {
            
                $students = $this->Student->get_where(array(
                    "class_id"              => $class_id,
                    "section_id"            => $section_id,
                ));
                
                
                foreach ($students as $student) {
                    
                    $fees_records = $this->Fees->get_all_fees(array(
                        "class_id"              => $class_id,
                        "section_id"            => $section_id,
                        "session_id"            => $academy_session_id,
                        "student_id"            => $student['id'],
                    ));
                    
                    if(!$fees_records) {
                        continue;
                    }
                
                    $outstanding_fee = $this->Fees->get_outstanding_fees(array(
                        "student_id"            => $student['id'],
                        "previous_session_id"   => ($academy_session_id - 1),
                        "current_session_id"    => $academy_session_id
                    ));
                    
                    $concession_fees = $this->Fees->get_concession_fees($student['id']);
                    
                    $record["student_id"]           =   $student['id'];
                    $record["student_no"]           =   $student['student_no'];
                    $record["student_name"]         =   $student['f_name'] . ' ' . $student['m_name'] . ' ' . $student['l_name'];
                    $record["outstanding_amount"]   =   $outstanding_fee['amount'];
                    $record["monthly_fees"]         =   $fees_records;
                    $record["concession_fees"]      =   $concession_fees;
                    
                    $records[] = $record;
                }
                
                $new_records = $this->generate_fees_summary($records);
                
                // echo "<pre>";
                // print_r(array(
                //     "classes"           =>  $classes,
                //     "sections"          =>  $sections,
                //     "student_types"     =>  $student_types,
                //     "records"           =>  $new_records
                // ));
                // echo "</pre>";
                // exit();

                $this->load->view("fees/school_fees_summary", array(
                    "classes"           =>  $classes,
                    "sections"          =>  $sections,
                    "student_types"     =>  $student_types,
                    "records"           =>  $new_records
                ));
                
            }
            
            else {
                $this->load->view("fees/school_fees_summary", array(
                    "classes"           =>  $classes,
                    "sections"          =>  $sections,
                    "student_types"     =>  $student_types,
                ));
            }
        }
        
        public function generate_fees_summary($data) {

            $processedData = [];
            
            foreach ($data as $student) {
                $studentId = $student['student_id'];
                $studentEntry = [
                    'student_id' => $studentId,
                    'student_no' => $student['student_no'],
                    'student_name' => $student['student_name'],
                    'outstanding_amount' => $student['outstanding_amount'],
                    'monthly_payable' => [],
                ];
            
                // Step 1: Collect Monthly Fee Totals
                $monthlyFees = [];
                foreach ($student['monthly_fees'] as $fee) {
                    $month = $fee['month']; // 0-based month
                    if (!isset($monthlyFees[$month])) {
                        $monthlyFees[$month] = 0;
                    }
                    $monthlyFees[$month] += $fee['amount'];
                }
            
                // Step 2: Collect Concession by Month
                $concessionFees = [];
                foreach ($student['concession_fees'] as $concession) {
                    $installmentId = $concession['installment_id'];
                    $month = intval(str_replace('ins_', '', $installmentId)) - 1;
                    $concessionFees[$month] = $concession['amount'];
                }
            
                // Step 3: Merge both into monthly_payable
                $allMonths = array_unique(array_merge(array_keys($monthlyFees), array_keys($concessionFees)));
                sort($allMonths);
            
                $total_concession_fees = 0;
                $total_monthly_fees = 0;
                
                foreach ($allMonths as $month) {
                    $totalFees = $monthlyFees[$month] ?? 0;
                    $concession = $concessionFees[$month] ?? 0;
                    // $payable = $totalFees - $concession;
                    $payable = $totalFees;
            
                    $studentEntry['monthly_payable'][$month] = [
                        'month' => $month,
                        'total_fees' => $totalFees,
                        'concession' => $concession,
                        'payable' => $payable,
                    ];
                    
                    $total_concession_fees  += $concession;
                    $total_monthly_fees += $totalFees;
        
                }
                
                $studentEntry["total_monthly_fees"] = $total_monthly_fees;
                $studentEntry["total_concession_fees"] = $total_concession_fees;
            
                $processedData[] = $studentEntry;
            }
            
            return $processedData;
        }

        public function school_fees_create() {
            if(!$this->session->user) {
                return redirect(base_url());
            }
            
            $class_id           = $this->input->get("class_id");
            $section_id         = $this->input->get("section_id");
            $student_type_id    = $this->input->get("student_type_id");
            $academy_session_id = $this->session->academy_session['current_session']['id'];
            
            $classes        = $this->AcademyClass->get();
            $class          = $this->AcademyClass->get($class_id);
            
            $sections       = $this->ClassSection->get_sections($academy_session_id, $class_id);
            $section        = $this->Section->get($section_id);
            
            $student_types  = $this->StudentType->get();
            $student_type   = $this->StudentType->get($student_type_id);
            
            $fees_heads     = $this->Fees->get();

            if($class_id && $section_id && $student_type_id) {
                
                $assign_fees_heads = $this->Fees->get_fees_heads(array(
                    "class_id" => $class_id,
                    "student_type_id"   => $student_type_id,
                    "session_id"    => $academy_session_id,
                    "status"    => 1
                ));

                $students = $this->Student->get_where(array(
                    "class_id"              => $class_id,
                    "section_id"            => $section_id,
                    "student_type_id"       => $student_type_id,
                ));
                
                $outstanding_fees = [];
                
                foreach ($students as $student) {
                    
                    // $is_exist = $this->Fees->get_fees(array(
                    //     "student_id"        => $student['id'],
                    //     "session_id"        => $academy_session_id,
                    //     "class_id"          => $class_id,
                    //     "section_id"        => $section_id,
                    //     "student_type_id"   => $student_type_id
                    // ));
                    
                    // if($is_exist) {
                    //     continue;
                    // }
                    
                    $record = $this->Fees->get_outstanding_fees(array(
                        "student_id"            => $student['id'],
                        "previous_session_id"   => ($academy_session_id - 1),
                        "current_session_id"    => $academy_session_id
                    ));
                    
                    $record["student_id"]       = $student['id'];
                    $record["student_name"]     = $student['f_name'] . ' ' . $student['m_name'] . ' ' . $student['l_name'];
                    $record["student_no"]       = $student['student_no'];
                    $record["class_id"]         = $class_id;
                    $record["section_id"]       = $section_id;
                    $record["student_type_id"]  = $student_type_id;
                    
                    $outstanding_fees[] = $record;
                }

                // echo "<pre>";
                // print_r($this->session->academy_session);
                // echo "</pre>";
                // exit();
                
                $this->load->view("fees/school_fees_create", array(
                    "classes"                    =>  $classes,
                    "sections"                   =>  $sections,
                    "student_types"              =>  $student_types,
                    "selected_class"             =>  $class,
                    "selected_section"           =>  $section,
                    "selected_student_type"      =>  $student_type,
                    "fees_heads"                 =>  $fees_heads,
                    "outstanding_fees"           =>  $outstanding_fees,
                    "assign_fees_heads"          =>  $assign_fees_heads
                ));
                
            }
            else {
                
                $classes = $this->AcademyClass->get();
                $student_types = $this->StudentType->get();
                $fees_heads = $this->Fees->get();
                
                $this->load->view("fees/school_fees_create", array(
                    "classes"        => $classes, 
                    "student_types"  => $student_types,
                    "fees_heads"     => $fees_heads,
                ));
                
            }
        }
        
        public function school_fees_store() {
            if(!$this->session->user) {
                return redirect(base_url());
            }
            
            // Capture basic identifiers
            $class_id = $_POST['class_id'] ?? null;
            $section_id = $_POST['section_id'] ?? null;
            $student_type_id = $_POST['student_type_id'] ?? null;
        
            // Capture student selection
            $selected_students = $_POST['selected_students'] ?? [];
        
            // Capture selected months
            $months = $_POST['months'] ?? [];
        
            // Capture due dates per month
            $month_dates = $_POST['month_dates'] ?? [];
        
            // Capture selected fee heads
            $fees_head_ids = $_POST['fees_head_id'] ?? [];
        
            // Capture amounts for each fee head per month (Assume structure from JS matches this)
            // Example: $_POST['amounts']['student_id']['month']['fee_head_id'] = amount;
            $amounts = $_POST['amounts'] ?? [];
        
            $final_data = [];
        
            // Construct the array
            foreach ($selected_students as $student_id) {
                foreach ($months as $month) {
                    $due_date = $_POST['month_dates_' . $month];
                    foreach ($fees_head_ids as $fees_head_id) {
                        $amount = $_POST['fee_amounts_' . $fees_head_id] ?? 0;
        
                        $final_data[] = [
                            'student_id'            => $student_id,
                            'class_id'              => $class_id,
                            'section_id'            => $section_id,
                            'student_type_id'       => $section_id,
                            'session_id'            => $this->session->academy_session['current_session']['id'],
                            'month'                 => $month,
                            'due_date'              => $due_date,
                            'fees_head_id'          => $fees_head_id,
                            'amount'                => $amount
                        ];
                    }
                }
            }
        
            $this->Fees->insert_update_fees($final_data);
            
            $this->session->set_flashdata("success", "Data stored successfully");
            return redirect(base_url() . "fees/school-fees/create");
        }
        
        public function school_fees_edit() {
            if(!$this->session->user) {
                return redirect(base_url());
            }
            
            $class_id           = $this->input->get("class_id");
            $section_id         = $this->input->get("section_id");
            $student_type_id    = $this->input->get("student_type_id");
            $month_id           = $this->input->get("month_id");
            $academy_session_id = $this->session->academy_session['current_session']['id'];
            
            $classes        = $this->AcademyClass->get();
            $sections       = $this->ClassSection->get_sections($academy_session_id, $class_id);
            $student_types  = $this->StudentType->get();
            
            $records = [];
            
            if($class_id && $section_id && $student_type_id && $month_id >= 0) {
                
                $fees_heads     = $this->Fees->get_fees_heads(array(
                    "class_id" => $class_id,
                    "student_type_id"   => $student_type_id,
                    "session_id"    => $academy_session_id,
                    "status"    => 1
                ));
                
                
                    
                $students = $this->Student->get_where(array(
                    "class_id"              => $class_id,
                    "section_id"            => $section_id,
                    "student_type_id"       => $student_type_id,
                ));
               
               foreach ($students as $student) {
                    
                    $fees = $this->Fees->get_all_fees(array(
                        "student_id"        => $student['id'],
                        "session_id"        => $academy_session_id,
                        "class_id"          => $class_id,
                        "section_id"        => $section_id,
                        "student_type_id"   => $student_type_id,
                        "month"             => $month_id
                    ));
                    
                    if(!$fees) { continue; }
                  
                    $record["student_id"]       = $student['id'];
                    $record["student_name"]     = $student['f_name'] . ' ' . $student['m_name'] . ' ' . $student['l_name'];
                    $record["student_no"]       = $student['student_no'];
                    $record["class_id"]         = $class_id;
                    $record["section_id"]       = $section_id;
                    $record["student_type_id"]  = $student_type_id;
                    $record["fees"]             = $fees;
                    
                    $records[] = $record;
                }
                
                
                $this->load->view("fees/school_fees_edit", array(
                    "classes"           =>  $classes,
                    "sections"          =>  $sections,
                    "student_types"     =>  $student_types,
                    "fees_heads"        =>  $fees_heads,
                    "records"           =>  $records
                ));
                
                // echo "<pre>";
                // print_r($records);
                // echo "</pre>";
                // exit();
                
            }
            else {
             
                $this->load->view("fees/school_fees_edit", array(
                    "classes"        =>     $classes, 
                    "sections"       =>     $sections,
                    "student_types"  =>     $student_types,
                    "fees_heads"     =>     $fees_heads,
                ));
                
            }
        }
        
        public function school_fees_update() {
            // Check if user is logged in
            if (!$this->session->user) {
                return redirect(base_url());
            }
            
            $final_data = [];

            $student_id       = $_POST['student_id'];
            $class_id         = $_POST['class_id'];
            $section_id       = $_POST['section_id'];
            $student_type_id  = $_POST['student_type_id'];
            $month            = $_POST['month_id'];
            $due_date         = $_POST['dueDate'];
            $session_id       = $this->session->academy_session['current_session']['id'];
            
            foreach ($_POST as $key => $value) {
                if (strpos($key, 'feesHead_') === 0) {
                    // Extract the fee head ID from the key (e.g., "feesHead_3" -> 3)
                    $fee_head_id = str_replace('feesHead_', '', $key);
            
                    // Get the corresponding amount field
                    $amount_key = 'amount_' . $fee_head_id;
                    $amount = isset($_POST[$amount_key]) ? $_POST[$amount_key] : 0;
            
                    // Create the row
                    $final_data[] = [
                        'student_id'       => $student_id,
                        'class_id'         => $class_id,
                        'section_id'       => $section_id,
                        'student_type_id'  => $student_type_id,
                        'session_id'       => $session_id,
                        'month'            => $month,
                        'due_date'         => $due_date,
                        'fees_head_id'     => $fee_head_id,
                        'amount'           => $amount
                    ];
                }
            }
            
            $this->Fees->insert_update_fees($final_data);
            
            $this->session->set_flashdata("success", "Data updated successfully");
            
            return redirect(
                base_url() . "fees/school-fees/edit?class_id=" . $class_id .
                "&section_id=" . $section_id .
                "&student_type_id=" . $student_type_id .
                "&month_id=" . $month
            );
        }

        public function school_fees_delete($id = null) {
            // Check if user is logged in
            if (!$this->session->user) {
                return redirect(base_url());
            }
         
            // Validate ID
            if (!$id || !is_numeric($id)) {
                $this->session->set_flashdata("error", "Invalid Rule ID.");
                return redirect(base_url("fees/school-fees/index"));
            }
        
            // Load model and delete the rule
            $deleted = $this->Fees->delete_fees($id);
        
            if ($deleted) {
                $this->session->set_flashdata("success", "Rule deleted successfully.");
            } else {
                $this->session->set_flashdata("error", "Rule not found or could not be deleted.");
            }
        
            return redirect(base_url("fees/school-fees/index"));
        }
        
        
        // Fees Collection
        // public function fees_collection_list($id = null) {
        //     // Check if user is logged in
        //     if (!$this->session->user) {
        //         return redirect(base_url());
        //     }
            
        //     $data;
        //     $class_id           = $this->input->get("class_id");
        //     $section_id      = $this->input->get("section_id") ?? 1;
        //     $student_type_id = $this->input->get("student_type_id") ?? 1;
        //     $academy_session_id = $this->session->academy_session['current_session']['id'];
            
        //     $from_date          = $this->input->get("from_date");
        //     $to_date            = $this->input->get("to_date");
            
        //     if($section_id == null) {
        //         $section_id = 1;
        //     }
            
             
        //     if($student_type_id == null) {
        //         $student_type_id = 1;
        //     }

        //     if($class_id && $section_id && $student_type_id) {
                
        //         $records = [];
        //         $students = $this->Student->get_where(array(
        //             "class_id"      => $class_id,
        //             "section_id"    => $section_id,
        //             "student_type_id"   => $student_type_id,
        //             "student_session.promoted"  => "ANY"
        //         ));

        //         foreach ($students as $student) 
        //         {
                 
        //             $datas = $this->Fees->get_fees_collection($student['id'], $from_date, $to_date);
                    
        //             foreach ($datas as $data) {
        //                 if($data) {
        //                     $collection = $data;
                            
        //                     $collection['student_no'] = $student['student_no'];
        //                     $collection['student_name'] = $student['f_name'] . ' ' . $student['m_name'] . ' ' . $student['l_name'];
    
        //                     $records[] = $collection;
        //                 }
        //             }
                    
        //         }
                
        //         $classes = $this->AcademyClass->get();
        //         $student_types = $this->StudentType->get();
        //         $sections = $this->ClassSection->get_sections($academy_session_id, $class_id);
                
        //         $this->load->view("fees/collection_list", array(
        //             "classes"       => $classes, 
        //             "sections"      => $sections, 
        //             "student_types" => $student_types,
        //             "records"       => $records
        //         ));
                
        //     }
        //     else {
                
        //         $classes = $this->AcademyClass->get();
        //         $student_types = $this->StudentType->get();
        //         $this->load->view("fees/collection_list", array(
        //             "classes" => $classes, 
        //             "student_types"  => $student_types
        //         ));
                
        //     }
  
        // }
        
        public function fees_collection_list($id = null) {
            // Check if user is logged in
            if (!$this->session->user) {
                return redirect(base_url());
            }
            
            $data;
            $class_id           = $this->input->get("class_id");
            $section_id         = $this->input->get("section_id") ?? 1;
            $student_type_id    = $this->input->get("student_type_id") ?? 1;
            $academy_session_id = $this->session->academy_session['current_session']['id'];
            
            $from_date          = $this->input->get("from_date");
            $to_date            = $this->input->get("to_date");
            
            $classes            = $this->AcademyClass->get();
            $student_types      = $this->StudentType->get();
            
            if($class_id == null && $from_date == null && $to_date == null) {
                // Load the view with merged data
                $this->load->view("fees/collection_list", array(
                    "classes"       => $classes,
                    "sections"      => $sections,
                    "student_types" => $student_types,
                    "records"       => []
                ));
                
                return;
            }
            
            if($section_id == null) {
                $section_id = 1;
            }

         
            if($student_type_id == null) {
                $student_type_id = 1;
            }

            $records = [];
            
            if ($class_id && $section_id && $student_type_id) {
                // Single class case
                $students = $this->Student->get_where(array(
                    "class_id"                => $class_id,
                    "section_id"              => $section_id,
                    "student_type_id"         => $student_type_id,
                    "student_session.promoted"=> "ANY"
                ));
                           
                foreach ($students as $student) {
                    $datas = $this->Fees->get_fees_collection($student['id'], $from_date, $to_date);
            
                    foreach ($datas as $data) {
                        if ($data) {
                            $collection = $data;
                            $collection['student_no']   = $student['student_no'];
                            $collection['student_name'] = $student['f_name'] . ' ' . $student['m_name'] . ' ' . $student['l_name'];
                            $collection['class_id']     = $class_id; // optional, helps in view
                            $records[] = $collection;
                        }
                    }
                }
            
                $sections = $this->ClassSection->get_sections($academy_session_id, $class_id);
            
            } 
            else {
                // Multiple classes case (loop class 1 to 15)
                for ($c = 1; $c <= 15; $c++) {
                    $students = $this->Student->get_where(array(
                        "class_id"                => $c,
                        "section_id"              => $section_id,
                        "student_type_id"         => $student_type_id,
                        "student_session.promoted"=> "ANY"
                    ));
            
                    foreach ($students as $student) {
                        $datas = $this->Fees->get_fees_collection($student['id'], $from_date, $to_date);
            
                        foreach ($datas as $data) {
                            if ($data) {
                                $collection = $data;
                                $collection['student_no']   = $student['student_no'];
                                $collection['student_name'] = $student['f_name'] . ' ' . $student['m_name'] . ' ' . $student['l_name'];
                                $collection['class_id']     = $c;
                                $records[] = $collection;
                            }
                        }
                    }
                }
            
                $sections = []; // no specific sections if looping all classes
            }

            // Load the view with merged data
            $this->load->view("fees/collection_list", array(
                "classes"       => $classes,
                "sections"      => $sections,
                "student_types" => $student_types,
                "records"       => $records
            ));
        }
        
        
        public function fees_collection_create_temp($id = null) {
            // Check if user is logged in
            if (!$this->session->user) {
                return redirect(base_url());
            }

            $students = $this->Student->get_where(array(
                "student_session.promoted"  => "ANY"
            ));
            
            $data                   = [];
            $st                     = null;
            $student_fees_heads     = null;
            $installments           = null;
            $concession             = null;
            $outstanding_fees       = null;
            
            foreach ($students as $student) {
            
                if(isset($_GET['student_id']) && ($_GET['student_id'] == $student['id'])) {
                    $st = $student;
                }
                
                $data[] = [
                    "student_no"    => $student['student_no'],
                    "name"          => $student['f_name'] . ' ' . $student['m_name'] . ' ' . $student['l_name'],
                    "id"            => $student['id']
                ];
            }
            
            if($st != null) {
                $installments = $this->Fees->get_all_fees(array(
                    "class_id"          => $st['student_session_class_id'],
                    "section_id"        => $st['student_session_section_id'], 
                    "student_type_id"   => $st['student_type_id'],
                    "student_id"        => $st['id'],
                    "session_id"        => $this->session->academy_session['current_session']['id']
                ));
                
                $student_fees_heads = $this->Fees->get_class_student_fees([$st['student_session_class_id']], [$st['student_type_id']]);
                
       
                $concession = $this->Fees->get_concession_fees($st['id']);
                
                $outstanding_fees = $this->Fees->get_outstanding_fees(array(
                    "student_id"        => $st['id'],
                    "current_session_id"=>  $this->session->academy_session['current_session']['id'],
                ));
            }
            
            $fine_counting = null;
            $fine_amount = null;
            
            $fees_setting = $this->Setting->get("fees_setting");
            
            foreach ($fees_setting as $fs) {
                if($fs['key_name'] == 'school_late_fine_fees') {
                    $fine_counting = $fs['value'];
                }
                
                if($fs['key_name'] == 'school_late_fine_amount') {
                    $fine_amount = $fs['value'];
                }
            }

            $this->load->view("fees/new_collection", array(
                "students"              =>  $data, 
                "st"                    =>  $st,
                "student_fees_heads"    =>  $student_fees_heads,
                "installments"          =>  $installments,
                "concession"            =>  $concession,
                "outstanding_fees"      =>  $outstanding_fees,
                "fine_counting"         =>  $fine_counting,
                "fine_amount"           =>  $fine_amount,
                "classes"               =>  $this->AcademyClass->get()
            ));
            
        }

        
        public function fees_collection_create($id = null) {
            // Check if user is logged in
            if (!$this->session->user) {
                return redirect(base_url());
            }

            $students = $this->Student->get_where(array(
                "student_session.promoted"  => "ANY"
            ));
            
            $data                   = [];
            $st                     = null;
            $student_fees_heads     = null;
            $installments           = null;
            $concession             = null;
            $outstanding_fees       = null;
            $other_payments         = null;
            
            foreach ($students as $student) {

                // $installments = $this->Fees->get_collection_adjusted_fees(array(
                //     "class_id"          => $student['student_session_class_id'],
                //     "section_id"        => $student['student_session_section_id'], 
                //     "student_type_id"   => $student['student_type_id'],
                //     "student_id"        => $student['id'],
                //     "session_id"        => $this->session->academy_session['current_session']['id']
                // ));

                // if(count($installments) == 0) continue;            
           
                if(isset($_GET['student_id']) && ($_GET['student_id'] == $student['id'])) {
                    $st = $student;
                }
                
                $data[] = [
                    "student_no"    => $student['student_no'],
                    "name"          => $student['f_name'] . ' ' . $student['m_name'] . ' ' . $student['l_name'],
                    "id"            => $student['id']
                ];
            }
            
            if($st != null) {
                $installments = $this->Fees->get_collection_adjusted_fees(array(
                    "class_id"          => $st['student_session_class_id'],
                    "section_id"        => $st['student_session_section_id'], 
                    "student_type_id"   => $st['student_type_id'],
                    "student_id"        => $st['id'],
                    "session_id"        => $this->session->academy_session['current_session']['id']
                ));
                
                $student_fees_heads = $this->Fees->get_class_student_fees([$st['student_session_class_id']], [$st['student_type_id']]);
                
                $concession = $this->Fees->get_concession_fees($st['id']);
                
                $outstanding_fees = $this->Fees->get_outstanding_fees(array(
                    "student_id"        => $st['id'],
                    "current_session_id"=>  $this->session->academy_session['current_session']['id'],
                ));
                
                $other_payments = $this->Fees->get_collection_adjusted_fees_other(array(
                    "class_id"          => $st['student_session_class_id'],
                    "section_id"        => $st['student_session_section_id'], 
                    "student_type_id"   => $st['student_type_id'],
                    "student_id"        => $st['id'],
                    "session_id"        => $this->session->academy_session['current_session']['id']
                ));
        
            }
            

            $fine_counting = null;
            $fine_amount = null;
            
            $fees_setting = $this->Setting->get("fees_setting");
            
            foreach ($fees_setting as $fs) {
                if($fs['key_name'] == 'school_late_fine_fees') {
                    $fine_counting = $fs['value'];
                }
                
                if($fs['key_name'] == 'school_late_fine_amount') {
                    $fine_amount = $fs['value'];
                }
            }
         
            $this->load->view("fees/new_collection", array(
                "students"              =>  $data, 
                "st"                    =>  $st,
                "student_fees_heads"    =>  $student_fees_heads,
                "installments"          =>  $installments,
                "concession"            =>  $concession,
                "outstanding_fees"      =>  $outstanding_fees,
                "other_payments"        =>  $other_payments,
                "fine_counting"         =>  $fine_counting,
                "fine_amount"           =>  $fine_amount,
                "classes"               =>  $this->AcademyClass->get()
            ));
            
        }
        
        public function fees_collection_store() {
            if (!$this->session->user) {
                redirect(base_url());
                return;
            }
        
            $academy_session_id = $this->session->academy_session['current_session']['id'];
            $data = $_POST;
            $student_id = $data['student_id'];
            $receipt_id  = $data['receipt_no'];
            $receipt_date = $data['receipt_date'];
            $months = [];
        
            // Get all month values from keys like fine_amount_0, previous_year_due_0, concession_amount_0
            foreach ($_POST as $key => $value) {
                if (preg_match('/^(\d+)_(\d+)$/', $key, $matches)) {
                    $fee_head_id = $matches[1];
                    $months[]       = $matches[2];
                }
            }
        
            // New collection store
            $collection_id = $this->Fees->new_fees_collection([
                "student_id"        => $student_id, 
                "session_id"        => $academy_session_id,
                "receipt_id"        => $receipt_id, 
                "receipt_date"      => $receipt_date,
                "payment_method"    => $data['payment_mode'],
                "gross_amount"      => $data['gross_amount_total'],
                "net_amount"        => $data['net_amount_total'],
                "months"            => json_encode(array_values(array_unique($months))),
                "summary"           => $data['summary']
            ]);
        
            // Store installment of the collection
            if($collection_id) {
                $entries = [];
        
                // Loop through the POST data and prepare installments for each fee head
                foreach ($_POST as $key => $value) {
                    if (preg_match('/^(\d+)_(\d+)$/', $key, $matches)) {
                        $fee_head_id = $matches[1];
                        $month       = $matches[2];
        
                        $entries[] = [
                            'collection_id'     =>  $collection_id,
                            'fee_head_id'       =>  $fee_head_id,
                            'month'             =>  $month,
                            'amount'            =>  $value,
                            'gross_amount'      =>  $_POST['gross_amount_' . $month],
                            'concession_amount' =>  $_POST['concession_amount_' . $month], 
                            'previous_year_due' =>  $_POST['previous_year_due_' . $month],
                            'net_amount'        =>  $_POST['net_amount_' . $month]
                        ];
                    }
                }
        
                // Insert fee collection installments
                $this->Fees->new_fees_collection_installments($entries);
        
                // Now, add data for fine_amount, previous_year_due, and concession_amount (for all months)
                $other_entries = [];
        
                // Handle fine_amount keys (e.g., fine_amount_0, fine_amount_1, ...)
                foreach ($data as $key => $value) {
                    if (preg_match('/^fine_amount_(\d+)$/', $key, $matches)) {
                        $month = $matches[1];
                        $other_entries[] = [
                            'collection_id' => $collection_id,
                            'name'          => 'Late Fine', // or use a mapping for fee types
                            'month'         => $month,
                            'amount'        => (float) $value
                        ];
                    }
        
                    // Handle previous_year_due keys (e.g., previous_year_due_0, previous_year_due_1, ...)
                    if (preg_match('/^previous_year_due_(\d+)$/', $key, $matches)) {
                        $month = $matches[1];
                        $other_entries[] = [
                            'collection_id' => $collection_id,
                            'name'          => 'Previous Year Due', // or a different name as needed
                            'month'         => $month,
                            'amount'        => (float) $value
                        ];
                    }
        
                    // Handle concession_amount keys (e.g., concession_amount_0, concession_amount_1, ...)
                    if (preg_match('/^concession_amount_(\d+)$/', $key, $matches)) {
                        $month = $matches[1];
                        $other_entries[] = [
                            'collection_id' => $collection_id,
                            'name'          => 'Concession', // or a different name as needed
                            'month'         => $month,
                            'amount'        => (float) $value
                        ];
                    }
                }
        
                // If there are any other fees like fine, concession, or previous year dues, insert them
                if (!empty($other_entries)) {
                    $this->Fees->new_fees_collection_other($other_entries);
                }
            }
        
            // Handle printing or redirecting
            if ($_POST['print'] == "yes") {
                $this->session->set_flashdata('success', 'Fees collected successfully.');
                redirect(base_url('fees/fees-collection/print?receipt_id=' . $receipt_id));
            } else {
                $this->session->set_flashdata('success', 'Fees collected successfully.');
                redirect(base_url('fees/fees-collection/create'));
            }
        }

        
        public function fees_collection_print() {
            // Check if user is logged in
            if (!$this->session->user) {
                return redirect(base_url());
            }
            
            $data = $this->Fees->get_fees_by_receipt($_GET['receipt_id']);
            $student = $this->Student->get($data['student_id']);

            $this->load->view("fees/receipt_print", array(
               "data"   => $data,
               "student" => $student
            ));
                
        }
        
        public function fees_collection_delete() { 
            // Check if user is logged in
            if (!$this->session->user) {
                return redirect(base_url());
            }
            
            $this->Fees->delete_collection($_GET['receipt_id']);
            
            $this->session->set_flashdata('success', 'Collection deleted successfully.');
            
            return redirect(base_url("fees/fees-collection/index"));

        }

    }