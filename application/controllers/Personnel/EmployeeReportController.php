<?php 
    defined('BASEPATH') OR exit('No direct script access allowed');

    class EmployeeReportController extends CI_Controller {
        public function __construct() {
            parent::__construct();

            $this->load->model("Department");
            $this->load->model("Designation");
            $this->load->model("Employee");
            $this->load->model("EmployeeType");
            $this->load->model("JobStatus");
            $this->load->model("Category");
            $this->load->model("Religion");
            $this->load->model("Nationality");
            $this->load->model("EmployeeAttendance");
            $this->load->model("Holiday");
            $this->load->model("Leave");
            $this->load->model("Setting");
        }

        public function index() {
            if(!$this->session->user) {
                return redirect(base_url());
            }

            $data = array(
                "departments"           => $this->Department->get(),
                "designations"          => $this->Designation->get(),
                "employee_types"        => $this->EmployeeType->get(),
                "job_statuses"          => $this->JobStatus->get(),
                "retired_employees"     => $this->Employee->get_retired_employee(),
                "resigned_employees"    => $this->Employee->get_resigned_employee(),
            );

            // echo "<pre>";
            // print_r($data);
            // echo "</pre>";
            // exit();

            $this->load->view("employee/reports/index", $data);
        }
        
        
        public function employee_list() {
            if(!$this->session->user) {
                return redirect(base_url());
            }
            
            $clauses = $_GET;
            
            // Use array_filter to remove empty values
            $filteredClauses = array_filter($clauses, function($value) {
                return !empty($value);
            });
            

            $departments        = $this->Department->get();
            $designations       = $this->Designation->get();
            $employee_types     = $this->EmployeeType->get();
            $job_statuses       = $this->JobStatus->get();
            $records            = $this->Employee->get_where($filteredClauses);
            
            $data = [
                "departments"       => $departments,
                "designations"      => $designations,
                "employee_types"    => $employee_types,
                "job_statuses"      => $job_statuses,
                "records"           => $records
            ];

            // echo "<pre>";
            // print_r($data);
            // echo "</pre>";
            // exit();

            $this->load->view("employee/reports/employee_list", $data);
        }
        
        public function inactive_employee_list() {
            if(!$this->session->user) {
                return redirect(base_url());
            }
            
            $clauses = $_GET;
            
            // Use array_filter to remove empty values
            $filteredClauses = array_filter($clauses, function($value) {
                return !empty($value);
            });
            
            $filteredClauses["status"] = "INACTIVE";

            $departments        = $this->Department->get();
            $designations       = $this->Designation->get();
            $employee_types     = $this->EmployeeType->get();
            $job_statuses       = $this->JobStatus->get();
            $records            = $this->Employee->get_where($filteredClauses);
            
            $data = [
                "departments"       => $departments,
                "designations"      => $designations,
                "employee_types"    => $employee_types,
                "job_statuses"      => $job_statuses,
                "records"           => $records
            ];

            $this->load->view("employee/reports/inactive_employee_list", $data);
        }
        
        public function employee_personal_details() {
            if(!$this->session->user) {
                return redirect(base_url());
            }
            
            $clauses = $_GET;
            
            // Use array_filter to remove empty values
            $filteredClauses = array_filter($clauses, function($value) {
                return !empty($value);
            });
            
            $departments        = $this->Department->get();
            $designations       = $this->Designation->get();
            $employee_types     = $this->EmployeeType->get();
            $job_statuses       = $this->JobStatus->get();
            $categories         = $this->Category->get();
            $religions          = $this->Religion->get();
            $nationalities      = $this->Nationality->get();
            $records            = $this->Employee->get_where($filteredClauses);
            
            $data = [
                "departments"       => $departments,
                "designations"      => $designations,
                "employee_types"    => $employee_types,
                "job_statuses"      => $job_statuses,
                "categories"        => $categories,
                "religions"         => $religions,
                "nationalities"     => $nationalities,
                "records"           => $records
            ];
            
            $this->load->view("employee/reports/employee_personal_details", $data);
        }

        public function retired_employee_list() {
            if(!$this->session->user) {
                return redirect(base_url());
            }
            
            // $clauses = $_GET;
            
            // // Use array_filter to remove empty values
            // $filteredClauses = array_filter($clauses, function($value) {
            //     return !empty($value);
            // });
            
            // $departments        = $this->Department->get();
            // $designations       = $this->Designation->get();
            // $employee_types     = $this->EmployeeType->get();
            // $job_statuses       = $this->JobStatus->get();
            // $categories         = $this->Category->get();
            // $religions          = $this->Religion->get();
            // $nationalities      = $this->Nationality->get();
            // $records            = $this->Employee->get_where($filteredClauses);
            
            $data = [
                "records"     => $this->Employee->get_retired_employee(),
            ];

            $this->load->view("employee/reports/retired_employee_list", $data);
        }

        public function resigned_employee_list() {
            if(!$this->session->user) {
                return redirect(base_url());
            }
            
            // $clauses = $_GET;
            
            // // Use array_filter to remove empty values
            // $filteredClauses = array_filter($clauses, function($value) {
            //     return !empty($value);
            // });
            
            // $departments        = $this->Department->get();
            // $designations       = $this->Designation->get();
            // $employee_types     = $this->EmployeeType->get();
            // $job_statuses       = $this->JobStatus->get();
            // $categories         = $this->Category->get();
            // $religions          = $this->Religion->get();
            // $nationalities      = $this->Nationality->get();
            // $records            = $this->Employee->get_where($filteredClauses);
           
            $data = [
                "records"     => $this->Employee-> get_resigned_employee(),
            ];

            // echo "<pre>";
            // print_r($data);
            // echo "</pre>";
            // exit();

            $this->load->view("employee/reports/resigned_employee_list", $data);
        }

        public function monthly_attendance_report() {
            if (!$this->session->user) {
                return redirect(base_url());
            }
    
            $departments    = $this->Department->get();
            $designations   = $this->Designation->get();
            $employee_types = $this->EmployeeType->get();
            $job_statuses   = $this->JobStatus->get();
            $session = $this->session->academy_session['current_session']['id'];
    
            $clauses = $_GET;
    
            // Use array_filter to remove empty values
            $filteredClauses = array_filter($clauses, function($value) {
                return !empty($value);
            });
    
            // Get selected months
            $fromMonth = isset($filteredClauses['from_month']) ? (int)$filteredClauses['from_month'] : null;
            $toMonth = isset($filteredClauses['to_month']) ? (int)$filteredClauses['to_month'] : null;
            
            // if($fromMonth == null || $toMonth == null) {
            //     $data = [
            //         "departments"       => $departments,
            //         "designations"      => $designations,
            //         "employee_types"    => $employee_types,
            //         "job_statuses"      => $job_statuses,
            //         "employeeRecords"   => $records,
            //         "attendanceData"   => [] // Pass attendance data to the view
            //     ];
        
            //     // Load the view with attendance data
            //     $this->load->view("employee/monthly_attendance_report", $data);
            //     return;
            // }
    
            unset($filteredClauses['from_month']);
            unset($filteredClauses['to_month']);
    
            // Get the employee records based on any filters from $_GET
            $records = $this->Employee->get_where($filteredClauses);
    
            // Initialize an array to hold attendance data
            $attendanceData = [];
    
            // Get the current year
            $currentYear = date('Y');
    
            // Iterate through months
            for ($month = $fromMonth; $month <= $toMonth; $month++) {
            
                $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $currentYear);
                $monthKey = $currentYear . '-' . str_pad($month, 2, '0', STR_PAD_LEFT);
            
                if (!isset($attendanceData[$monthKey])) {
                    $attendanceData[$monthKey] = [];
                }
            
                for ($day = 1; $day <= $daysInMonth; $day++) {
            
                    $attendanceDate = sprintf('%04d-%02d-%02d', $currentYear, $month, $day);
            
                    // IMPORTANT: initialize day
                    $attendanceData[$monthKey][$attendanceDate] = [];
            
                    foreach ($records as $record) {
                        $attendance = $this->EmployeeAttendance
                            ->getAttendanceByEmployeeAndDate(
                                $record['id'],
                                $session,
                                $attendanceDate
                            );
            
                        $attendanceData[$monthKey][$attendanceDate][$record['id']] = $attendance;
                    }
                }
            }

            $holidays = $this->Holiday->get_all();
            
            // echo "<pre>";
            // print_r($holidays);
            // echo "</pre>";
            // exit();
            
            
            $data = [
                "holidays"          => $holidays,
                "departments"       => $departments,
                "designations"      => $designations,
                "employee_types"    => $employee_types,
                "employeeRecords"   => $records,
                "attendanceData"   => $attendanceData // Pass attendance data to the view
            ];
            
            // echo "<pre>";
            // print_r($data);
            // echo "</pre>";
            // exit();
            
            // Load the view with attendance data
            $this->load->view("employee/reports/monthly_attendance_report", $data);
        }
        
        public function month_wise_report() 
        {
            if (!$this->session->user) {
                return redirect(base_url());
            }
    
            $departments    = $this->Department->get();
            $designations   = $this->Designation->get();
            $employee_types = $this->EmployeeType->get();
            $job_statuses   = $this->JobStatus->get();
            $session = $this->session->academy_session['current_session']['id'];
    
            $clauses = $_GET;
    
            // Use array_filter to remove empty values
            $filteredClauses = array_filter($clauses, function($value) {
                return !empty($value);
            });
    
            // Get selected months
            $fromMonth = isset($filteredClauses['from_month']) ? (int)$filteredClauses['from_month'] : null;
            $toMonth = isset($filteredClauses['to_month']) ? (int)$filteredClauses['to_month'] : null;
            
            if($fromMonth == null || $toMonth == null) {
                $data = [
                    "departments"       => $departments,
                    "designations"      => $designations,
                    "employee_types"    => $employee_types,
                    "job_statuses"      => $job_statuses,
                    "employeeRecords"   => $records,
                    "attendanceData"   => [] // Pass attendance data to the view
                ];
        
                // Load the view with attendance data
                $this->load->view("employee/monthly_attendance_report", $data);
                return;
            }
    
            unset($filteredClauses['from_month']);
            unset($filteredClauses['to_month']);
    
            // Get the employee records based on any filters from $_GET
            $records = $this->Employee->get_where($filteredClauses);
    
            // Initialize an array to hold attendance data
            $attendanceData = [];
    
            // Get the current year
            $currentYear = date('Y');
    
            // Iterate through months
            for ($month = $fromMonth; $month <= $toMonth; $month++) {
            
                $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $currentYear);
                $monthKey = $currentYear . '-' . str_pad($month, 2, '0', STR_PAD_LEFT);
            
                if (!isset($attendanceData[$monthKey])) {
                    $attendanceData[$monthKey] = [];
                }
            
                for ($day = 1; $day <= $daysInMonth; $day++) {
            
                    $attendanceDate = sprintf('%04d-%02d-%02d', $currentYear, $month, $day);
            
                    // IMPORTANT: initialize day
                    $attendanceData[$monthKey][$attendanceDate] = [];
            
                    foreach ($records as $record) {
                        $attendance = $this->EmployeeAttendance
                            ->getAttendanceByEmployeeAndDate(
                                $record['id'],
                                $session,
                                $attendanceDate
                            );
            
                        $attendanceData[$monthKey][$attendanceDate][$record['id']] = $attendance;
                    }
                }
            }

            $holidays = $this->Holiday->get_all();
            
            // echo "<pre>";
            // print_r($holidays);
            // echo "</pre>";
            // exit();
            
            
            $data = [
                "holidays"          => $holidays,
                "departments"       => $departments,
                "designations"      => $designations,
                "employee_types"    => $employee_types,
                "job_statuses"      => $job_statuses,
                "employeeRecords"   => $records,
                "attendanceData"    => $attendanceData // Pass attendance data to the view
            ];
            
            // echo "<pre>";
            // print_r($data);
            // echo "</pre>";
            // exit();
            
            // Load the view with attendance data
            $this->load->view("employee/monthly_attendance_report", $data);
        }

        public function year_wise_report()
        {
            if (!$this->session->user) {
                return redirect(base_url());
            }

            $departments    = $this->Department->get();
            $designations   = $this->Designation->get();
            $employee_types = $this->EmployeeType->get();
            $job_statuses   = $this->JobStatus->get();
            $session        = $this->session->academy_session['current_session']['id'];

            $clauses = $_GET;

            $filteredClauses = array_filter($clauses, function ($value) {
                return !empty($value);
            });

            // ✅ Dynamic year
            $selectedYear = isset($_GET['year']) ? (int)$_GET['year'] : date('Y');

            unset($filteredClauses['year']);

            // Employees
            $records = $this->Employee->get_where($filteredClauses);
            $employeeIds = array_column($records, 'id');

            // Fetch full year attendance in ONE query
            $attendanceList = $this->EmployeeAttendance->getYearAttendance(
                $employeeIds,
                $session,
                $selectedYear
            );

            /*
            ------------------------------------------------
            Convert DATETIME to DATE (VERY IMPORTANT)
            ------------------------------------------------
            */
            $attendanceMap = [];

            foreach ($attendanceList as $row) {
                $dateOnly = date('Y-m-d', strtotime($row['attendance_date']));
                $attendanceMap[$row['employee_id']][$dateOnly] = $row['attendance'];
            }

            // Holidays
            $holidays = $this->Holiday->get_all();
            $holidayMap = [];

            foreach ($holidays as $holiday) {
                $holidayMap[$holiday['holiday_date']] = true;
            }

            $attendanceData = [];
            $monthlyWorkingDays = [];
            $yearlyWorkingDays  = 0;

            // Initialize employees
            foreach ($records as $record) {
                $attendanceData[$record['id']] = [
                    'monthly' => [],
                    'yearly_total' => 0
                ];
            }

            // Loop 12 months
            for ($month = 1; $month <= 12; $month++) {

                $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $selectedYear);
                $monthKey = $selectedYear . '-' . str_pad($month, 2, '0', STR_PAD_LEFT);

                $workingDays = 0;

                for ($day = 1; $day <= $daysInMonth; $day++) {

                    $date = sprintf('%04d-%02d-%02d', $selectedYear, $month, $day);

                    $dayOfWeek = date('N', strtotime($date)); // 7 = Sunday

                    // Skip Sunday
                    if ($dayOfWeek == 7) {
                        continue;
                    }

                    // Skip Holiday
                    if (isset($holidayMap[$date])) {
                        continue;
                    }

                    $workingDays++;

                    foreach ($records as $record) {

                        $empId = $record['id'];

                        if (
                            isset($attendanceMap[$empId][$date]) &&
                            $attendanceMap[$empId][$date] === 'P'
                        ) {
                            if (!isset($attendanceData[$empId]['monthly'][$monthKey])) {
                                $attendanceData[$empId]['monthly'][$monthKey] = 0;
                            }

                            $attendanceData[$empId]['monthly'][$monthKey]++;
                            $attendanceData[$empId]['yearly_total']++;
                        }
                    }
                }

                $monthlyWorkingDays[$monthKey] = $workingDays;
                $yearlyWorkingDays += $workingDays;
            }

            $data = [
                "departments"        => $departments,
                "designations"       => $designations,
                "employee_types"     => $employee_types,
                "job_statuses"       => $job_statuses,
                "employeeRecords"    => $records,
                "attendanceData"     => $attendanceData,
                "monthlyWorkingDays" => $monthlyWorkingDays,
                "yearlyWorkingDays"  => $yearlyWorkingDays,
                "holidays"           => $holidays
            ];

            $this->load->view("employee/yearly_attendance_report", $data);
        }

        public function session_attendance_report()
        {
            if (!$this->session->user) {
                return redirect(base_url());
            }

            $departments    = $this->Department->get();
            $designations   = $this->Designation->get();
            $employee_types = $this->EmployeeType->get();
            $session        = $this->session->academy_session['current_session']['id'];

            $clauses = $_GET;

            $filteredClauses = array_filter($clauses, function ($value) {
                return !empty($value);
            });

            // ✅ Dynamic year
            $selectedYear = isset($_GET['year']) ? (int)$_GET['year'] : date('Y');

            unset($filteredClauses['year']);

            // Employees
            $records = $this->Employee->get_where($filteredClauses);
            $employeeIds = array_column($records, 'id');

            // Fetch full year attendance in ONE query
            $attendanceList = $this->EmployeeAttendance->getYearAttendance(
                $employeeIds,
                $session,
                $selectedYear
            );

            /*
            ------------------------------------------------
            Convert DATETIME to DATE (VERY IMPORTANT)
            ------------------------------------------------
            */
            $attendanceMap = [];

            foreach ($attendanceList as $row) {
                $dateOnly = date('Y-m-d', strtotime($row['attendance_date']));
                $attendanceMap[$row['employee_id']][$dateOnly] = $row['attendance'];
            }

            // Holidays
            $holidays = $this->Holiday->get_all();
            $holidayMap = [];

            foreach ($holidays as $holiday) {
                $holidayMap[$holiday['holiday_date']] = true;
            }

            $attendanceData = [];
            $monthlyWorkingDays = [];
            $yearlyWorkingDays  = 0;

            // Initialize employees
            foreach ($records as $record) {
                $attendanceData[$record['id']] = [
                    'monthly' => [],
                    'yearly_total' => 0
                ];
            }

            // Loop 12 months
            for ($month = 1; $month <= 12; $month++) {

                $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $selectedYear);
                $monthKey = $selectedYear . '-' . str_pad($month, 2, '0', STR_PAD_LEFT);

                $workingDays = 0;

                for ($day = 1; $day <= $daysInMonth; $day++) {

                    $date = sprintf('%04d-%02d-%02d', $selectedYear, $month, $day);

                    $dayOfWeek = date('N', strtotime($date)); // 7 = Sunday

                    // Skip Sunday
                    if ($dayOfWeek == 7) {
                        continue;
                    }

                    // Skip Holiday
                    if (isset($holidayMap[$date])) {
                        continue;
                    }

                    $workingDays++;

                    foreach ($records as $record) {

                        $empId = $record['id'];

                        if (
                            isset($attendanceMap[$empId][$date]) &&
                            $attendanceMap[$empId][$date] === 'P'
                        ) {
                            if (!isset($attendanceData[$empId]['monthly'][$monthKey])) {
                                $attendanceData[$empId]['monthly'][$monthKey] = 0;
                            }

                            $attendanceData[$empId]['monthly'][$monthKey]++;
                            $attendanceData[$empId]['yearly_total']++;
                        }
                    }
                }

                $monthlyWorkingDays[$monthKey] = $workingDays;
                $yearlyWorkingDays += $workingDays;
            }

            $data = [
                "departments"        => $departments,
                "designations"       => $designations,
                "employee_types"     => $employee_types,
                "employeeRecords"    => $records,
                "attendanceData"     => $attendanceData,
                "monthlyWorkingDays" => $monthlyWorkingDays,
                "yearlyWorkingDays"  => $yearlyWorkingDays,
                "holidays"           => $holidays
            ];

            $this->load->view("employee/reports/session_attendance_report", $data);
        }

        public function leave_applications() {
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
                    
            $this->load->view('employee/reports/leave_list', ["leaves" => $data]);
        }

        // public function year_wise_report()
        // {
        //     if (!$this->session->user) {
        //         return redirect(base_url());
        //     }
        
        //     $departments    = $this->Department->get();
        //     $designations   = $this->Designation->get();
        //     $employee_types = $this->EmployeeType->get();
        //     $session        = $this->session->academy_session['current_session']['id'];
        
        //     $clauses = $_GET;
        
        //     // Remove empty filters
        //     $filteredClauses = array_filter($clauses, function ($value) {
        //         return !empty($value);
        //     });
        
        //     // Selected year
        //     $selectedYear = 2026;
            
        //     // echo "<pre>";
        //     // print_r($selectedYear);
        //     // echo "</pre>";
        //     // exit();
            
        //     if ($selectedYear === null) {
        //         $data = [
        //             "departments"      => $departments,
        //             "designations"     => $designations,
        //             "employee_types"   => $employee_types,
        //             "employeeRecords"  => [],
        //             "attendanceData"   => [],
        //             "monthlyWorkingDays" => [],
        //             "yearlyWorkingDays"  => 0,
        //             "holidays"         => []
        //         ];
        
        //         $this->load->view("employee/yearly_attendance_report", $data);
        //         return;
        //     }
        
        //     unset($filteredClauses['year']);
        
        //     // Employees
        //     $records = $this->Employee->get_where($filteredClauses);
        
        //     // Holidays
        //     $holidays = $this->Holiday->get_all();
        
        //     // Holiday date map
        //     $holidayMap = [];
        //     foreach ($holidays as $holiday) {
        //         $holidayMap[$holiday['holiday_date']] = $holiday['name'];
        //     }
        
        //     /*
        //     ------------------------------------------------
        //     attendanceData STRUCTURE:
        //     [emp_id][YYYY-MM] => present_count
        //     ------------------------------------------------
        //     */
        //     $attendanceData = [];
        //     $monthlyWorkingDays = [];
        //     $yearlyWorkingDays  = 0;
        
        //     // Initialize employee containers
        //     foreach ($records as $record) {
        //         $attendanceData[$record['id']] = [
        //             'monthly' => [],
        //             'yearly_total' => 0
        //         ];
        //     }
        
        //     // Loop months
        //     for ($month = 1; $month <= 12; $month++) {
        
        //         $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $selectedYear);
        //         $monthKey    = $selectedYear . '-' . str_pad($month, 2, '0', STR_PAD_LEFT);
        
        //         $holidayCount = 0;
        
        //         // Count holidays in month
        //         for ($day = 1; $day <= $daysInMonth; $day++) {
        //             $date = sprintf('%04d-%02d-%02d', $selectedYear, $month, $day);
        //             if (isset($holidayMap[$date])) {
        //                 $holidayCount++;
        //             }
        //         }
        
        //         $workingDays = $daysInMonth - $holidayCount;
        //         $monthlyWorkingDays[$monthKey] = $workingDays;
        //         $yearlyWorkingDays += $workingDays;
        
        //         // Attendance per employee
        //         foreach ($records as $record) {
        
        //             $presentCount = 0;
        
        //             for ($day = 1; $day <= $daysInMonth; $day++) {
        
        //                 $attendanceDate = sprintf('%04d-%02d-%02d', $selectedYear, $month, $day);
        
        //                 // Skip holidays
        //                 if (isset($holidayMap[$attendanceDate])) {
        //                     continue;
        //                 }
        
        //                 $attendance = $this->EmployeeAttendance
        //                     ->getAttendanceByEmployeeAndDate(
        //                         $record['id'],
        //                         $session,
        //                         $attendanceDate
        //                     );
        
        //                 if ($attendance && $attendance['attendance'] === 'P') {
        //                     $presentCount++;
        //                 }
        //             }
        
        //             $attendanceData[$record['id']]['monthly'][$monthKey] = $presentCount;
        //             $attendanceData[$record['id']]['yearly_total'] += $presentCount;
        //         }
        //     }
        
        //     $data = [
        //         "departments"        => $departments,
        //         "designations"       => $designations,
        //         "employee_types"     => $employee_types,
        //         "employeeRecords"    => $records,
        //         "attendanceData"     => $attendanceData,
        //         "monthlyWorkingDays" => $monthlyWorkingDays,
        //         "yearlyWorkingDays"  => $yearlyWorkingDays,
        //         "holidays"           => $holidays
        //     ];
            
        //     // echo "<pre>";
        //     // print_r($data);
        //     // echo "</pre>";
        //     // exit();

        //     $this->load->view("employee/yearly_attendance_report", $data);
        // }

        
        public function user_defined_report() {
            
            $departments = $this->Department->get();
            $designations = $this->Designation->get();
            $employee_types = $this->EmployeeType->get();
            $job_statuses = $this->JobStatus->get();
            
            
            $data = array(
                "departments"       => $departments,
                "designations"      => $designations,
                "employee_types"    => $employee_types,
                "job_statuses"      => $job_statuses,
            );
     
            $this->load->view("employee/reports/user_defined_reports.php", $data);
        } 

        public function generate_user_defined_report() {
            if(!$this->session->user) {
                return redirect(base_url());
            }
            
            $emp_ids        = $_POST['emp_ids'];
            $fields         = $_POST['fields'];
            $blank_column   = $_POST['blank_column'];
            $employee_data  = [];
            
            $key = array_search("blank_columns", $fields);
            if ($key !== false) {
                unset($fields[$key]);
            }
            
            foreach($emp_ids as $id) {
                $employee_data[] = $this->Employee->get($id);
            }
            
            $departments        = $this->Department->get();
            $designations       = $this->Designation->get();
            $employee_types     = $this->EmployeeType->get();
            $job_statuses       = $this->JobStatus->get();
            $categories         = $this->Category->get();
            $religions          = $this->Religion->get();
            $nationalities      = $this->Nationality->get();
            
            $data = [
                "departments"   =>  $departments,
                "designations"  =>  $designations,
                "employee_types"=>  $employee_types,
                "job_statuses"  =>  $job_statuses,
                "categories"    => $categories,
                "religions"     => $religions,
                "nationalities" => $nationalities,
                "employees"     =>  $employee_data,
                "fields"        =>  $fields,
                "blank_columns" =>  $blank_column,
                "heading"       =>  $_POST['heading'],
                "subheading"    =>  $_POST['subheading'],
            ];
            
            $this->load->view("employee/reports/user_defined_report_view", $data); 
        } 
        
        public function user_defined_report_get_employees() {
            $clauses = $_GET;
            
            // Use array_filter to remove empty values
            $filteredClauses = array_filter($clauses, function($value) {
                return !empty($value);
            });
            
            $departments        = $this->Department->get();
            $designations       = $this->Designation->get();
            $employee_types     = $this->EmployeeType->get();
            $job_statuses       = $this->JobStatus->get();
            $records            = $this->Employee->get_where($filteredClauses);
            
            $data = [
                "departments"       => $departments,
                "designations"      => $designations,
                "employee_types"    => $employee_types,
                "job_statuses"      => $job_statuses,
                "employees"        => $records
            ];
            
            $this->load->view("employee/reports/user_defined_reports", $data);
            
        } 

        
    }