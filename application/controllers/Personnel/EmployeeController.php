<?php 
    defined('BASEPATH') OR exit('No direct script access allowed');

    class EmployeeController extends CI_Controller {
        public function __construct() {
            parent::__construct();
            $this->load->model("Employee");
            $this->load->model("Department");
            $this->load->model("Designation");
            $this->load->model("EmployeeType");
            $this->load->model("JobStatus");
            $this->load->model("Category");
            $this->load->model("Religion");
            $this->load->model("Nationality");
            $this->load->model("Leave");
            $this->load->model("Holiday");
            $this->load->model("AbsentReason");
            $this->load->model("EmployeeAttendance");
        }

        public function index() {
            if(!$this->session->user) {
                return redirect(base_url());
            }

            $employee_types = $this->EmployeeType->get();
            $employees = $this->Employee->get();
            
            // echo "<pre>";
            // print_r(array("employees" => $employees, "employee_types" => $employee_types));
            // echo "</pre>";
            // exit();

            $this->load->view("employee/index.php", array("employees" => $employees, "employee_types" => $employee_types));

        }

        public function create() {
            if(!$this->session->user) {
                return redirect(base_url());
            }

            $data = array(
                "employees"         => $this->Employee->get(),
                "departments"       => $this->Department->get(),
                "designations"      => $this->Designation->get(),
                "employee_types"    => $this->EmployeeType->get(),
                "job_status"        => $this->JobStatus->get(),
                "categories"        => $this->Category->get(),
                "religions"         => $this->Religion->get(),
                "nationalities"     => $this->Nationality->get(),
            );

            $this->load->view("employee/create.php", $data);
        }

        public function store() {
            if(!$this->session->user) {
                return redirect(base_url());
            }

            if($this->form_validation->run("employee") == FALSE) {
                
                $data = array(
                    "departments"       => $this->Department->get(),
                    "designations"      => $this->Designation->get(),
                    "employee_types"    => $this->EmployeeType->get(),
                    "job_status"        => $this->JobStatus->get(),
                    "categories"        => $this->Category->get(),
                    "religions"         => $this->Religion->get(),
                    "nationalities"     => $this->Nationality->get(),
                );
    

                $this->load->view("employee/create", $data);
            }
            else {
                $data = array(
                    "status" => "ACTIVE",
                    "f_name" => $this->input->post('f_name'),
                    "m_name" => $this->input->post('m_name'),
                    "l_name" => $this->input->post('l_name'),
                    "emp_code" => $this->input->post('emp_code'),
                    "sex" => $this->input->post('sex'),
                    "dob" => $this->input->post('dob'),
                    "since" => $this->input->post('since'),
                    "emp_type_id" => $this->input->post('emp_type_id'),
                    "department_id" => $this->input->post('department_id'),
                    "designation_id" => $this->input->post('designation_id'),
                    "job_status_id" => $this->input->post('job_status_id'),
                    "mobile_no" => $this->input->post('mobile_no'),
                    "email" => $this->input->post('email'),
                    "category_id" => $this->input->post('category_id'),
                    "father" => $this->input->post('father'),
                    "mother" => $this->input->post('mother'),
                    "marital_status" => $this->input->post('marital_status'),
                    "spouse" => $this->input->post('spouse'),
                    "religion_id" => $this->input->post('religion_id'),
                    "nationality_id" => $this->input->post('nationality_id'),
                    "pan_no" => $this->input->post('pan_no'),
                    "voter_id" => $this->input->post('voter_id'),
                    "aadhar_no" => $this->input->post('aadhar_no'),
                    "miscellaneous" => $this->input->post('miscellaneous'),
                    "local_address" => $this->input->post('local_address'),
                    "local_phone" => $this->input->post('local_phone'),
                    "permanent_address" => $this->input->post('permanent_address'),
                    "permanent_phone" => $this->input->post('permanent_phone'),
                    "created_at" => date("Y-m-d", time())
                );

                $file = $this->upload_file("image");

                if($file["status"]) {
                    $data["image"] = $file['upload_data']['file_name'];
                }

                $this->Employee->insert($data);
                $this->session->set_flashdata("success", "New record inserted");
                return redirect(base_url() . "personnel/employee/create");
            }

        }

        public function show($id) {
            if(!$this->session->user) {
                return redirect(base_url());
            }

            $employee = $this->Employee->get($id);
            $this->load->view("employee/show.php", array("employee" => $employee) );
        }

        public function search() {
            if(!$this->session->user) {
                return redirect(base_url());
            }

            foreach($_GET as $key=>$value)
            {
                if(is_null($value) || $value == '' || empty($value))
                    unset($_GET[$key]);
            }

            $data = array(
                "departments"       => $this->Department->get(),
                "designations"      => $this->Designation->get(),
                "employee_types"    => $this->EmployeeType->get(),
                "job_status"        => $this->JobStatus->get(),
                "categories"        => $this->Category->get(),
                "religions"         => $this->Religion->get(),
                "nationalities"     => $this->Nationality->get(),
            );

            $data['employees'] = $this->Employee->search($_GET);

            $this->load->view("employee/search.php", $data);
        }


        public function edit($id) {
            if(!$this->session->user) {
                return redirect(base_url());
            }

            $data = array(
                "employee"          => $this->Employee->get($id),
                "departments"       => $this->Department->get(),
                "designations"      => $this->Designation->get(),
                "employee_types"    => $this->EmployeeType->get(),
                "job_status"        => $this->JobStatus->get(),
                "categories"        => $this->Category->get(),
                "religions"         => $this->Religion->get(),
                "nationalities"     => $this->Nationality->get(),
            );


            $this->load->view("employee/edit.php", $data);
        }

        public function update() {
            if(!$this->session->user) {
                return redirect(base_url());
            }
           
            if($this->form_validation->run("employee") == FALSE) {
                
                $data = array(
                    "departments"       => $this->Department->get(),
                    "designations"      => $this->Designation->get(),
                    "employee_types"    => $this->EmployeeType->get(),
                    "job_status"        => $this->JobStatus->get(),
                    "categories"        => $this->Category->get(),
                    "religions"         => $this->Religion->get(),
                    "nationalities"     => $this->Nationality->get(),
                );
    

                $this->load->view("employee/edit", $data);
            }

            else {
                $data = array(
                    "status" => $this->input->post('status'),
                    "f_name" => $this->input->post('f_name'),
                    "m_name" => $this->input->post('m_name'),
                    "l_name" => $this->input->post('l_name'),
                    "emp_code" => $this->input->post('emp_code'),
                    "sex" => $this->input->post('sex'),
                    "dob" => $this->input->post('dob'),
                    "since" => $this->input->post('since'),
                    "emp_type_id" => $this->input->post('emp_type_id'),
                    "department_id" => $this->input->post('department_id'),
                    "designation_id" => $this->input->post('designation_id'),
                    "job_status_id" => $this->input->post('job_status_id'),
                    "mobile_no" => $this->input->post('mobile_no'),
                    "email" => $this->input->post('email'),
                    "category_id" => $this->input->post('category_id'),
                    "father" => $this->input->post('father'),
                    "mother" => $this->input->post('mother'),
                    "marital_status" => $this->input->post('marital_status'),
                    "spouse" => $this->input->post('spouse'),
                    "religion_id" => $this->input->post('religion_id'),
                    "nationality_id" => $this->input->post('nationality_id'),
                    "pan_no" => $this->input->post('pan_no'),
                    "voter_id" => $this->input->post('voter_id'),
                    "aadhar_no" => $this->input->post('aadhar_no'),
                    "miscellaneous" => $this->input->post('miscellaneous'),
                    "local_address" => $this->input->post('local_address'),
                    "local_phone" => $this->input->post('local_phone'),
                    "permanent_address" => $this->input->post('permanent_address'),
                    "permanent_phone" => $this->input->post('permanent_phone'),
                    "created_at" => date("Y-m-d", time())
                );

                $file = $this->upload_file("image");

                if($file["status"]) {
                    $prev_image = $this->input->post('prev_image');
                    unlink('storage/employees/' . $prev_image);
                    $data["image"] = $file['upload_data']['file_name'];
                }

                $id = $this->input->post('id');
                $this->Employee->update($id, $data);
                $this->session->set_flashdata("success", "Record Updated");
                return redirect(base_url() . "personnel/employee/");
            }
        }

        public function delete($id) {
            if(!$this->session->user) {
                return redirect(base_url());
            }

        }

        protected function upload_file($photo){
            $config['upload_path']          = 'storage/employees';
            $config['allowed_types']        = 'jpg|jpeg|png';
            $config['file_name']            = 'employee-' . time(); 
    
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
        
        public function attendance() {
            if (!$this->session->user) {
                return redirect(base_url());
            }
        
            $departments = $this->Department->get();
            $designations = $this->Designation->get();
            $employee_types = $this->EmployeeType->get();
            $absent_reasons = $this->AbsentReason->get();
            
            $clauses = $_GET;
            
            // Use array_filter to remove empty values
            $filteredClauses = array_filter($clauses, function($value) {
                return !empty($value);
            });
            
            if(isset($filteredClauses['date'])) {
                unset($filteredClauses['date']);
            }
            
            $holiday = $this->Holiday->is_holiday($clauses['date']);

            if (empty($holiday)) {
                // Set timezone to Asia/Kolkata
                $tz = new DateTimeZone('Asia/Kolkata');
                $today = new DateTime('now', $tz);
            
                // Use the required format (example: Y-m-d)
                $holiday = $this->Holiday->is_holiday($today->format('Y-m-d'));
            }
            
            // Get the employee records based on any filters from $_GET
            $records = $this->Employee->get_where($filteredClauses);
        
            // Initialize an array to hold attendance data
            $attendanceData = [];
        
            // Check for existing attendance records for the employees
            foreach ($records as $record) {
              
                $attendanceDate = $_GET['date'] ?? date('Y-m-d');
                $attendance = $this->EmployeeAttendance->getAttendanceByEmployeeAndDate($record['id'], 1, $attendanceDate);

                $attendanceData[$record['id']] = $attendance; // Store attendance data indexed by employee ID
            }
        
            $data = [
                "absent_reasons"    => $absent_reasons,
                "holiday"           => $holiday,
                "holiday_date"      => $clauses['date'] ? $clauses['date'] : $today->format('Y-m-d'),
                "departments"       => $departments,
                "designations"      => $designations,
                "employee_types"    => $employee_types,
                "records"           => $records,
                "attendance_data"   => $attendanceData // Pass attendance data to the view
            ];
            
            // echo "<pre>";
            // print_r($data);
            // echo "</pre>";
            // exit();
        
            $this->load->view("employee/create_attendance", $data);
        }


        public function attendance_store()
        {
            if ($this->input->post()) {
        
                $date          = $this->input->post('date');
                $attendances   = $this->input->post('attendance');
                $reasons       = $this->input->post('reason');
                $remarks       = $this->input->post('remarks');
                $checkin_times = $this->input->post('checkin_time');
                $session       = $this->session->academy_session['current_session']['id'];
        
                foreach ($attendances as $employee_id => $attendance) {
        
                    if ($attendance === 'P') {
        
                        if (empty($checkin_times[$employee_id])) {
                            continue; // Skip if present but no time
                        }
        
                        $datetime = date(
                            'Y-m-d H:i:s',
                            strtotime($date . ' ' . $checkin_times[$employee_id])
                        );
        
                        $data = [
                            'employee_id'     => $employee_id,
                            'session'         => $session,
                            'attendance_date' => $datetime,
                            'attendance'      => 'P',
                            'reason'          => null,
                            'remarks'         => null
                        ];
                    }
        
                    if ($attendance === 'A') {
        
                        $datetime = date(
                            'Y-m-d H:i:s',
                            strtotime($date . ' 00:00:00')
                        );
        
                        $data = [
                            'employee_id'     => $employee_id,
                            'session'         => $session,
                            'attendance_date' => $datetime,
                            'attendance'      => 'A',
                            'reason'          => $reasons[$employee_id] ?? null,
                            'remarks'         => $remarks[$employee_id] ?? null
                        ];
                    }
        
                    $this->EmployeeAttendance->saveAttendance($data);
                }
        
                $this->session->set_flashdata('success', 'Attendance recorded successfully!');
                redirect('personnel/attendance');
            }
        }

        public function resign_retire() {
            if (!$this->session->user) {
                return redirect(base_url());
            }
            
            $departments = $this->Department->get();
            $designations = $this->Designation->get();
            $employee_types = $this->EmployeeType->get();
            $job_statuses = $this->JobStatus->get();
            
            $clauses = $_GET;
            
            // Use array_filter to remove empty values
            $filteredClauses = array_filter($clauses, function($value) {
                return !empty($value);
            });
            
            if(isset($filteredClauses['date'])) {
                unset($filteredClauses['date']);
            }
            
            // Get the employee records based on any filters from $_GET
            $retired_employees = $this->Employee->get_retired_employee();
            $resigned_employees = $this->Employee->get_resigned_employee();
            $records = $this->Employee->get_where($filteredClauses);
            
            
            // Create an array of IDs for retired and resigned employees for quick lookup
            $retired_ids = array_column($retired_employees, 'id');
            $resigned_ids = array_column($resigned_employees, 'id');
            
            // Filter out records that exist in either retired or resigned employees
            $filtered_records = array_filter($records, function($record) use ($retired_ids, $resigned_ids) {
                return !in_array($record['id'], $retired_ids) && !in_array($record['id'], $resigned_ids);
            });
            
            // Re-index the array if necessary (optional)
            $filtered_records = array_values($filtered_records);

            $data = [
                "departments"       => $departments,
                "designations"      => $designations,
                "employee_types"    => $employee_types,
                "job_statuses"      => $job_statuses,
                "records"           => $filtered_records,
            ];
            
            $this->load->view("employee/new_retire_resign", $data);

        }
        
        public function resign_retire_list() {
            if (!$this->session->user) {
                return redirect(base_url());
            }
            
            $departments = $this->Department->get();
            $designations = $this->Designation->get();
            $employee_types = $this->EmployeeType->get();
            $job_statuses = $this->JobStatus->get();
            
            $retired_employees = $this->Employee->get_retired_employee();
            $resigned_employees = $this->Employee->get_resigned_employee();
            
            $data = [
                "departments"           => $departments,
                "designations"          => $designations,
                "employee_types"        => $employee_types,
                "job_statuses"          => $job_statuses,
                "retired_employees"     => $retired_employees,
                "resigned_employees"    => $resigned_employees
            ];
            
            $this->load->view("employee/retire_resign_list", $data);
        }
        
        public function resign_retire_store() {
            // Get form data
            $employee_id = $this->input->post('employee_id');
            $date = date('Y-m-d'); // Current date
    
            if ($this->input->post('date-retirement')) {
                // Store retirement data
                $retirement_data = [
                    'employee_id' => $employee_id,
                    'date' => $this->input->post('date-retirement'),
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ];
                $this->Employee->store_retirement($retirement_data);
            }
    
            if ($this->input->post('date-resignation')) {
                // Store resignation data
                $resignation_data = [
                    'employee_id' => $employee_id,
                    'date' => $this->input->post('date-resignation'),
                    'reason' => $this->input->post('reason-resignation'),
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ];
                $this->Employee->store_resignation($resignation_data);
            }
    
            // Redirect or load a view
            redirect('personnel/resign-retire'); // Change to your success route
        }
        
        
        public function leave()
        {
            if (!$this->session->user) {
                return redirect(base_url());
            }
        
            $data = [
                'employee' => $this->Employee->get($this->session->user['employee_id'])
            ];
        
            // This is the view we created earlier (Leave Application UI)
            $this->load->view('employee/leave_application', $data);
        }
        
        public function leave_list()
        {
            if (!$this->session->user) {
                return redirect(base_url());
            }
        
            $leaves = $this->Leave->get(); // Fetch all leaves
            $data = [];
            
            foreach ($leaves as $leave) {
                // Fetch employee info
                $employee = $this->Employee->get($leave['employee_id']);
            
                // Check if $leave is an object or array
                if (is_object($leave)) {
                    $leave->employee = $employee;
                } elseif (is_array($leave)) {
                    $leave['employee'] = $employee;
                }
            
                $data[] = $leave;
            }
            
            // echo "<pre>";
            // print_r($data);
            // echo "</pre>";
            // exit();
        
            $this->load->view('employee/leave_list', ["leaves" => $data]);
        }
        
        public function leave_store()
        {
            if (!$this->session->user) {
                return redirect(base_url());
            }
        
            $employee_id = $this->session->user['id'];
        
            /**
             * IMPORTANT:
             * application field should contain the FULL formatted HTML
             * generated from the leave form
             */
           
            // Collect input fields from POST
            $application_date = $this->input->post('application_date');
            $leave_reason     = $this->input->post('leave_reason');
            $leave_range      = $this->input->post('leaveRange'); // e.g., "31-12-2025 to 01-01-2026" or "18-12-2025"
            
            // Parse leave_range
            $dates = explode(' to ', $leave_range);
            
            // Convert DD-MM-YYYY to Y-m-d safely
            $from_date_obj = DateTime::createFromFormat('d-m-Y', $dates[0]);
            $from_date = $from_date_obj ? $from_date_obj->format('Y-m-d') : null;
            
            if (isset($dates[1])) {
                $to_date_obj = DateTime::createFromFormat('d-m-Y', $dates[1]);
                $to_date = $to_date_obj ? $to_date_obj->format('Y-m-d') : $from_date;
            } else {
                $to_date = null;
            }
            
            // Prepare JSON data
            $application_data = json_encode([
                'employee_name'    => $employee_name,
                'designation'      => $designation,
                'application_date' => $application_date,
                'leave_reason'     => $leave_reason,
                'from_date'        => $from_date,
                'to_date'          => $to_date
            ]);
                        
       
            $data = [
                'employee_id' => $this->session->user["employee_id"],
                'application' => $application_data,
                'status'      => 'PENDING'
            ];
            
            $this->Leave->insert($data);
            
            $this->session->set_flashdata('success', 'Leave applied successfully!');
            return redirect(base_url('personnel/leave-list'));
        }
        
        public function delete_leave($id)
        {
            if (!$this->session->user) {
                return redirect(base_url());
            }
        
            $this->Leave->delete($id); // Assuming your Leave model has a delete method
            $this->session->set_flashdata('success', 'Leave deleted successfully!');
            return redirect(base_url('personnel/leave-list'));
        }

    }