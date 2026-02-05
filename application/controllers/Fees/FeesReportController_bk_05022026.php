<?php 
    defined('BASEPATH') OR exit('No direct script access allowed');

    class FeesReportController extends CI_Controller {
        public function __construct() {
            parent::__construct();
            
            $this->load->model("Fees");
            $this->load->model("Setting");
            $this->load->model("Student");
            $this->load->model("AcademyClass");
            $this->load->model("Section");
            $this->load->model("State");
            $this->load->model("ClassSection");
            $this->load->model("StudentType");
        }

        public function index() {
            if(!$this->session->user) {
                return redirect(base_url());
            }
            
            $student_records = $this->Student->get_where(array(
                "student_session.promoted"  => "ANY"
            ));
            
            $students = [];
            
            foreach ($student_records as $student) {

                $students[] = [
                    "student_no"    => $student['student_no'],
                    "name"          => $student['f_name'] . ' ' . $student['m_name'] . ' ' . $student['l_name'],
                    "id"            => $student['id']
                ];
            }

            $data = array(
                "classes"       => $this->AcademyClass->get(),
                "sections"      => $this->Section->get(),
                "student_types" => $this->StudentType->get(),
                "states"        => $this->State->get(),
                "students"      => $students
            );

            $this->load->view("fees/reports/index", $data);
        }
        
        
        
        // ===== School Fees Collection Reports =====
        // public function feeCollectionReport()
        // {
        //     $academy_session_id = $this->session->academy_session['current_session']['id'];

        //     echo "<pre>";
        //     print_r($this->session->academy_session['current_session']);
        //     echo "</pre>";
        //     exit();

        //     $data = [];
        
        //     $filters = [
        //         'from_date'       => $this->input->get('from_date') ?: date('Y-01-01'), // Default to January 1st
        //         'to_date'         => $this->input->get('to_date') ?: date('Y-m-d'),     // Default to current date
        //         'class_id'        => $this->input->get('class_id'),
        //         'section_id'      => $this->input->get('section_id'),
        //         'student_type_id' => $this->input->get('student_type_id'),
        //         'payment_mode'    => $this->input->get('payment_mode'),
        //     ];
            
        //     // Default month_from to January if not provided
        //     $month_from = $this->input->get('month_from'); // Default to January if not provided
        //     if ($month_from) {
        //         // Set from_date to the first day of month_from of the current year
        //         $filters['from_date'] = date('Y-m-01', strtotime(date('Y') . '-' . date('m', strtotime($month_from)) . '-01'));
        //     }
            
        //     // Default month_to to current month if not provided
        //     $month_to = $this->input->get('month_to'); // Default to current month if not provided
        //     if ($month_to) {
        //         // Set to_date to the last day of month_to of the current year
        //         $filters['to_date'] = date('Y-m-t', strtotime(date('Y') . '-' . $month_to . '-01'));
        //     }

        //     $data['report'] = $this->Fees->feeCollectionReport($filters);
        
        //     $data['filters'] = $filters;
        //     $this->load->view('fees/reports/fee_collection_report', $data);
        // }

        public function feeCollectionReport()
        {
            $currentSession = $this->session->academy_session['current_session'];

            $academy_session_id = $currentSession['id'];
            $session_start      = $currentSession['start']; // 2025-01-01
            $session_end        = $currentSession['end'];   // 2025-12-31

            $data = [];

            $filters = [
                // Default to session start & end dates
                'from_date'       => $this->input->get('from_date') ?: $session_start,
                'to_date'         => $this->input->get('to_date')   ?: $session_end,
                'class_id'        => $this->input->get('class_id'),
                'section_id'      => $this->input->get('section_id'),
                'student_type_id' => $this->input->get('student_type_id'),
                'payment_mode'    => $this->input->get('payment_mode'),
            ];

            /**
             * Month From Filter
             * Overrides from_date if provided
             */
            $month_from = $this->input->get('month_from');
            if ($month_from) {
                $filters['from_date'] = date(
                    'Y-m-01',
                    strtotime(date('Y', strtotime($session_start)) . '-' . $month_from . '-01')
                );
            }

            /**
             * Month To Filter
             * Overrides to_date if provided
             */
            $month_to = $this->input->get('month_to');
            if ($month_to) {
                $filters['to_date'] = date(
                    'Y-m-t',
                    strtotime(date('Y', strtotime($session_start)) . '-' . $month_to . '-01')
                );
            }

            $data['report']  = $this->Fees->feeCollectionReport($filters);
            $data['filters'] = $filters;

            $this->load->view('fees/reports/fee_collection_report', $data);
        }

        public function feeHeadWiseCollectionReport()
        {
            $currentSession = $this->session->academy_session['current_session'];

            $data = [];

            $filters = [
                'from_date'       => $this->input->get('from_date') ?: date('Y-01-01'), // Default to January 1st
                'to_date'         => $this->input->get('to_date') ?: date('Y-m-d'),     // Default to current date
                'class_id'        => $this->input->get('class_id'),
                'section_id'      => $this->input->get('section_id'),
                'student_type_id' => $this->input->get('student_type_id'),
                'payment_mode'    => $this->input->get('payment_mode'),
            ];
            
            // Default month_from to January if not provided
            $month_from = $this->input->get('month_from'); // Default to January if not provided
            if ($month_from) {
                // Set from_date to the first day of month_from of the current year
                $filters['from_date'] = date('Y-m-01', strtotime(date('Y') . '-' . date('m', strtotime($month_from)) . '-01'));
            }
            
            // Default month_to to current month if not provided
            $month_to = $this->input->get('month_to'); // Default to current month if not provided
            if ($month_to) {
                // Set to_date to the last day of month_to of the current year
                $filters['to_date'] = date('Y-m-t', strtotime(date('Y') . '-' . $month_to . '-01'));
            }
            
            $data['report'] = $this->Fees->feeHeadWiseCollectionReport($filters);
        
            // Fetch all active Fee Heads from fees_type table
            $data['fee_heads'] = $this->db->select('id, name')
                                            ->from('fees_type')
                                            ->where('is_active', 1)
                                            ->where('deleted', 0)
                                            ->order_by('CAST(name AS CHAR)', 'ASC') // ensures text sorting
                                            ->get()
                                            ->result_array();
        
            $data['filters'] = $filters;
            $data['chunks']  = array_chunk($data['report'], 25);
        
            $this->load->view('fees/reports/fee_head_wise_collection_report', $data);
        }

        public function paymentWiseCollectionReport()
        {
            $data = [];
        
            $filters = [
                'from_date'       => $this->input->get('from_date') ?: date('Y-01-01'), // Default to January 1st
                'to_date'         => $this->input->get('to_date') ?: date('Y-m-d'),     // Default to current date
                'class_id'        => $this->input->get('class_id'),
                'section_id'      => $this->input->get('section_id'),
                'student_type_id' => $this->input->get('student_type_id'),
                'payment_mode'    => $this->input->get('payment_mode'),
            ];
            
            // Default month_from to January if not provided
            $month_from = $this->input->get('month_from'); // Default to January if not provided
            if ($month_from) {
                // Set from_date to the first day of month_from of the current year
                $filters['from_date'] = date('Y-m-01', strtotime(date('Y') . '-' . date('m', strtotime($month_from)) . '-01'));
            }
            
            // Default month_to to current month if not provided
            $month_to = $this->input->get('month_to'); // Default to current month if not provided
            if ($month_to) {
                // Set to_date to the last day of month_to of the current year
                $filters['to_date'] = date('Y-m-t', strtotime(date('Y') . '-' . $month_to . '-01'));
            }

            $data['report'] = $this->Fees->paymentWiseCollectionReport($filters);
        
            $data['filters'] = $filters;
        
            // chunk for 25-row print pagination
            $data['chunks'] = array_chunk($data['report'], 25);
        
            $this->load->view('fees/reports/payment_wise_collection_report', $data);
        }

        public function collectionPersonnelWiseCollectionReport() {
            $data = [];
        
            $filters = [
                'from_date'       => $this->input->get('from_date') ?: date('Y-01-01'), // Default to January 1st
                'to_date'         => $this->input->get('to_date') ?: date('Y-m-d'),     // Default to current date
                'class_id'        => $this->input->get('class_id'),
                'section_id'      => $this->input->get('section_id'),
                'student_type_id' => $this->input->get('student_type_id'),
                'payment_mode'    => $this->input->get('payment_mode'),
            ];
            
            // Default month_from to January if not provided
            $month_from = $this->input->get('month_from'); // Default to January if not provided
            if ($month_from) {
                // Set from_date to the first day of month_from of the current year
                $filters['from_date'] = date('Y-m-01', strtotime(date('Y') . '-' . date('m', strtotime($month_from)) . '-01'));
            }
            
            // Default month_to to current month if not provided
            $month_to = $this->input->get('month_to'); // Default to current month if not provided
            if ($month_to) {
                // Set to_date to the last day of month_to of the current year
                $filters['to_date'] = date('Y-m-t', strtotime(date('Y') . '-' . $month_to . '-01'));
            }
            
            $data['report'] = $this->Fees->feeCollectionReport($filters);
        
            $data['filters'] = $filters;
            $this->load->view('fees/reports/personnel_wise_collection_report', $data);
        }
    
        // ===== Other Reports =====
        public function totalConcessionReport()
        {
            $data = [];
            $data['title'] = "Total Concession Report";
        
            $filters = [
                'class_id' => $this->input->get('class_id'),
                'section_id' => $this->input->get('section_id'),
                'student_type_id' => $this->input->get('student_type_id'),
                'session_id' => $this->input->get('session_id')
            ];
        
            $data['records'] = [];
            $data['records'] = $this->Fees->totalConcessionReport($filters);
        
            // Dropdowns
            $data['classes'] = $this->db->get_where('classes', ['deleted' => 0])->result_array();
            $data['sections'] = $this->db->get_where('sections', ['deleted' => 0])->result_array();
            $data['student_types'] = $this->db->get_where('student_types', ['deleted' => 0])->result_array();
            $data['sessions'] = $this->db->get('sessions')->result_array();
        
            $this->load->view('fees/reports/total_concession_report', $data);
        }

        public function classWiseAllMonthsCollectionReport()
        {
            $data = [];
            $data['title'] = "Class Wise All Months Collection Report";
        
            $filters = [
                'class_id'        => $this->input->get('class_id'),
                'section_id'      => $this->input->get('section_id'),
                'student_type_id' => $this->input->get('student_type_id')
            ];
        
            $data['filters'] = $filters;
            $data['classes'] = $this->AcademyClass->get();
            $data['sections'] = $this->Section->get();
            $data['student_types'] = $this->StudentType->get();
        
            $data['report'] = [];
            $data['report'] = $this->Fees->classWiseAllMonthsCollectionReport($filters);
            
            $this->load->view('fees/reports/class_wise_all_months_collection_report', $data);
        }

        
        // public function classWiseOutstandingReport()
        // {
        //     $academy_session_id = $this->session->academy_session['current_session']['id'];

        //     $data = [];
        //     $data['title'] = "Class Wise Outstanding Report";
        
        //     $filters = [
        //         'from_date'       => $this->input->get('from_date') ?: date('Y-01-01'), // Default to January 1st
        //         'to_date'         => $this->input->get('to_date') ?: date('Y-m-d'),     // Default to current date
        //         'class_id'        => $this->input->get('class_id'),
        //         'section_id'      => $this->input->get('section_id'),
        //         'student_type_id' => $this->input->get('student_type_id'),
        //         'payment_mode'    => $this->input->get('payment_mode'),
        //     ];
            
        //     // Default month_from to January if not provided
        //     $month_from = $this->input->get('month_from'); // Default to January if not provided
        //     if ($month_from) {
        //         // Set from_date to the first day of month_from of the current year
        //         $filters['from_date'] = date('Y-m-01', strtotime(date('Y') . '-' . date('m', strtotime($month_from)) . '-01'));
        //     }
            
        //     // Default month_to to current month if not provided
        //     $month_to = $this->input->get('month_to'); // Default to current month if not provided
        //     if ($month_to) {
        //         // Set to_date to the last day of month_to of the current year
        //         $filters['to_date'] = date('Y-m-t', strtotime(date('Y') . '-' . $month_to . '-01'));
        //     }
        
        //     $data['report'] = [];
        //     $data['report'] = $this->Fees->classWiseOutstandingReport($filters);
        
        //     $data['filters'] = $filters;
        //     $data['classes'] = $this->AcademyClass->get();
        //     $data['sections'] = $this->Section->get();
        //     $data['student_types'] = $this->StudentType->get();
        
        //     $this->load->view('fees/reports/class_wise_outstanding_report', $data);
        // }

        public function classWiseOutstandingReport()
        {
            $current_session = $this->session->academy_session['current_session'];

            $academy_session_id = $current_session['id'];
            $session_start_date = $current_session['start']; // 2025-01-01
            $session_end_date   = $current_session['end'];   // 2025-12-31

            $data = [];
            $data['title'] = "Class Wise Outstanding Report";

            $filters = [
                'from_date'       => $this->input->get('from_date') ?: $session_start_date,
                'to_date'         => $this->input->get('to_date')   ?: $session_end_date,
                'class_id'        => $this->input->get('class_id'),
                'section_id'      => $this->input->get('section_id'),
                'student_type_id' => $this->input->get('student_type_id'),
                'payment_mode'    => $this->input->get('payment_mode'),
            ];

            // month_from override (within session year)
            $month_from = $this->input->get('month_from');
            if ($month_from) {
                $filters['from_date'] = date(
                    'Y-m-01',
                    strtotime(date('Y', strtotime($session_start_date)) . '-' . $month_from . '-01')
                );
            }

            // month_to override (within session year)
            $month_to = $this->input->get('month_to');
            if ($month_to) {
                $filters['to_date'] = date(
                    'Y-m-t',
                    strtotime(date('Y', strtotime($session_start_date)) . '-' . $month_to . '-01')
                );
            }

            $data['report'] = $this->Fees->classWiseOutstandingReport($filters);

            $data['filters'] = $filters;
            $data['classes'] = $this->AcademyClass->get();
            $data['sections'] = $this->Section->get();
            $data['student_types'] = $this->StudentType->get();

            $this->load->view('fees/reports/class_wise_outstanding_report', $data);
        }


        // public function stateWiseOutstandingReport()
        // {
        //     $data = [];
        
        //     $filters = [
        //         'from_date'       => $this->input->get('from_date') ?: date('Y-01-01'), // Default to January 1st
        //         'to_date'         => $this->input->get('to_date') ?: date('Y-m-d'),     // Default to current date
        //         'class_id'        => $this->input->get('class_id'),
        //         'section_id'      => $this->input->get('section_id'),
        //         'student_type_id' => $this->input->get('student_type_id'),
        //         'payment_mode'    => $this->input->get('payment_mode'),
        //     ];
            
        //     // Default month_from to January if not provided
        //     $month_from = $this->input->get('month_from'); // Default to January if not provided
        //     if ($month_from) {
        //         // Set from_date to the first day of month_from of the current year
        //         $filters['from_date'] = date('Y-m-01', strtotime(date('Y') . '-' . date('m', strtotime($month_from)) . '-01'));
        //     }
            
        //     // Default month_to to current month if not provided
        //     $month_to = $this->input->get('month_to'); // Default to current month if not provided
        //     if ($month_to) {
        //         // Set to_date to the last day of month_to of the current year
        //         $filters['to_date'] = date('Y-m-t', strtotime(date('Y') . '-' . $month_to . '-01'));
        //     }
            
        //     $data['report'] = $this->Fees->stateWiseOutstandingReport($filters);
            
        //     $data['filters'] = $filters;
            
        //     $data['classes'] = $this->AcademyClass->get();
        //     $data['sections'] = $this->Section->get();
        //     $data['states'] = $this->State->get();

        //     $this->load->view('fees/reports/state_wise_outstanding_report', $data);
        // }

        public function stateWiseOutstandingReport()
        {
            $current_session = $this->session->academy_session['current_session'];

            $session_start_date = $current_session['start']; // e.g. 2025-01-01
            $session_end_date   = $current_session['end'];   // e.g. 2025-12-31

            $data = [];

            $filters = [
                'from_date'       => $this->input->get('from_date') ?: $session_start_date,
                'to_date'         => $this->input->get('to_date')   ?: $session_end_date,
                'class_id'        => $this->input->get('class_id'),
                'section_id'      => $this->input->get('section_id'),
                'student_type_id' => $this->input->get('student_type_id'),
                'payment_mode'    => $this->input->get('payment_mode'),
                'state_id'        => $this->input->get('state_id'),
            ];

            // month_from override (session year)
            $month_from = $this->input->get('month_from');
            if ($month_from) {
                $filters['from_date'] = date(
                    'Y-m-01',
                    strtotime(date('Y', strtotime($session_start_date)) . '-' . $month_from . '-01')
                );
            }

            // month_to override (session year)
            $month_to = $this->input->get('month_to');
            if ($month_to) {
                $filters['to_date'] = date(
                    'Y-m-t',
                    strtotime(date('Y', strtotime($session_start_date)) . '-' . $month_to . '-01')
                );
            }

            $data['report'] = $this->Fees->stateWiseOutstandingReport($filters);
            $data['filters'] = $filters;

            $data['classes']  = $this->AcademyClass->get();
            $data['sections'] = $this->Section->get();
            $data['states']   = $this->State->get();

            $this->load->view('fees/reports/state_wise_outstanding_report', $data);
        }

 
        public function previousYearOutstandingReport()
        {
            $data = [];
            $data['title'] = "Previous Year Outstanding Report";
    
            // Get filters
            $filters = [
                'from_date' => $this->input->get('from_date'),
                'to_date'   => $this->input->get('to_date'),
                'class_id'  => $this->input->get('class_id'),
                'section_id' => $this->input->get('section_id'),
                'student_type_id' => $this->input->get('student_type_id'),
            ];
    
            // Validate required fields if any (date optional here)
            $data['records'] = [];
            $data['records'] = $this->Fees->previousYearOutstandingReport($filters);
    
            // Load dropdown dependencies
            $data['classes'] = $this->db->get_where('classes', ['deleted' => 0])->result_array();
            $data['sections'] = $this->db->get_where('sections', ['deleted' => 0])->result_array();
            $data['student_types'] = $this->db->get_where('student_types', ['deleted' => 0])->result_array();
    
            $this->load->view('fees/reports/previous_year_outstanding_report', $data);
        }
        
        public function studentMonthlyPaymentReport()
        {
            $student_id = $this->input->get('student_id');
            if (empty($student_id)) {
                show_error('Student ID is required to generate report.');
            }
            
            $student = $this->Student->get($student_id);
        
            $this->load->model('Fees');
            $data['report'] = $this->Fees->studentMonthlyPaymentReport($student_id);
            $data['student'] = $student;
            
            $data['title'] = 'Student Monthly Payment Report';
            
            $this->load->view('fees/reports/student_monthly_payment_report', $data);
        }
        
        public function consolidatedOutstandingReport()
        {
            $filters = [
                'class_id'  => $this->input->get('class_id'),
                'section_id' => $this->input->get('section_id'),
                'student_type_id' => $this->input->get('student_type_id'),
            ];
            
            $data['title'] = "Consolidated Outstanding Report - As on " . date('d-M-Y');
            $data['report'] = $this->Fees->consolidatedOutstandingReport($filters);
            $this->load->view('fees/reports/consolidated_outstanding_report', $data);
        }
        
    }