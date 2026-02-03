<?php 
    defined('BASEPATH') OR exit('No direct script access allowed');

    class StudentReportController extends CI_Controller {
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
            $this->load->model("ClassSection");
            $this->load->model("Setting");
            $this->load->model("Student");
            $this->load->model("ExamPaper");
            $this->load->model("Marks");
            $this->load->model("Result");
            $this->load->model("ExamAttendence");
            $this->load->model("Remarks");
            $this->load->model("StudentSubject");
            $this->load->model("Subject");
            $this->load->model("SubjectType");
            

            $this->load->model("ApprisalOther");
            $this->load->model("ExtraCurricular");
            $this->load->model("Game");
            $this->load->model("Participation");
            $this->load->model("Expressivenesses");
            $this->load->model("Leadership");
            $this->load->model("Interaction");
            $this->load->model("Conduct");
            $this->load->model("Behaviour");
            $this->load->model("Attendance");
            $this->load->model("Punctuality");
        }

        public function index() {
            if(!$this->session->user) {
                return redirect(base_url());
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

            $this->load->view("student/reports/index", $data);
        }


        public function student_list_report() {
            if(!$this->session->user) {
                return redirect(base_url());
            }
         
            $clauses = $this->format_search_key($_POST);

            foreach($clauses as $key=>$value)
            {
                if(is_null($value) || $value == '' || empty($value))
                    unset($clauses[$key]);
            }
            
            $clauses["student_session.promoted"] = "ANY";

            $data['students'] = $this->Student->get_where($clauses);

            $this->load->view("student/reports/student_list", $data);
        }

        public function student_new_admission_report() {
            if(!$this->session->user) {
                return redirect(base_url());
            }

            $clauses = $this->format_search_key($_POST);
            
            foreach($clauses as $key=>$value)
            {
                if(is_null($value) || $value == '' || empty($value))
                    unset($clauses[$key]);
            }
            
            $clauses["student_session.new_session_id"] = $this->session->academy_session['current_session']['id'];

            $data['students'] = $this->Student->get_where($clauses);

            $this->load->view("student/reports/new_admission", $data);
        }

        public function student_inactive_report() {
            if(!$this->session->user) {
                return redirect(base_url());
            }

            $clauses = $this->format_search_key($_POST);
            
            foreach($clauses as $key=>$value)
            {
                if(is_null($value) || $value == '' || empty($value))
                    unset($clauses[$key]);
            }
            
            $clauses["students.status"] = "INACTIVE";

            $data['students'] = $this->Student->get_where($clauses);
            
            $this->load->view("student/reports/inactive_students", $data);
        }
        
        public function student_password_report() {
            if(!$this->session->user) {
                return redirect(base_url());
            }
            
            $clauses = $this->format_search_key($_POST);
            
            foreach($clauses as $key=>$value)
            {
                if(is_null($value) || $value == '' || empty($value))
                    unset($clauses[$key]);
            }

            $clauses["student_session.promoted"] = "ANY";
            
            $data['students'] = $this->Student->get_where($clauses);
            
            $this->load->view("student/reports/student_password", $data);
        }
        
        // public function breakup_class() {
        //     if(!$this->session->user) {
        //         return redirect(base_url());
        //     }
            
        //     foreach($_POST as $key=>$value)
        //     {
        //         if(is_null($value) || $value == '' || empty($value))
        //             unset($_POST[$key]);
        //     }

        //     $records = $this->Student->class_wise_breakup();
           
        //     $this->load->view("student/reports/breakup_class", ['records' => $records]);
        // }
        
        public function breakup_class() {
            if (!$this->session->user) {
                return redirect(base_url());
            }
        
            // Format the search keys from POST data
            $clauses = $this->format_search_key($_GET);
            foreach ($clauses as $key => $value) {
                if (is_null($value) || $value == '' || empty($value)) {
                    unset($clauses[$key]);
                }
            }
        
            // Fetch records based on class-wise breakup
            $records = $this->Student->breakup_class($clauses);
            
            $print_param = $this->input->get('print');
            
            if ($print_param !== null) { 
                $this->load->view("student/reports/print_class", ['records' => $records]);
                
            }
            else {
                $this->load->view("student/reports/breakup_class", ['records' => $records]);
            }
        }

        public function breakup_student_type() {
            if(!$this->session->user) {
                return redirect(base_url());
            }
            
            $clauses = $this->format_search_key($_GET);
            foreach($clauses as $key=>$value)
            {
                if(is_null($value) || $value == '' || empty($value))
                    unset($clauses[$key]);
            }
    
            $records = $this->Student->breakup_student_type($clauses);
            
            $print_param = $this->input->get('print');
            
            if ($print_param !== null) { 
                $this->load->view("student/reports/print_student_type", ['records' => $records]);
                
            }
            else {
                $this->load->view("student/reports/breakup_student_type", ['records' => $records]);
            }
            
        }
        
        public function breakup_house() {
            if(!$this->session->user) {
                return redirect(base_url());
            }
            
            $clauses = $this->format_search_key($_GET);
            foreach($clauses as $key=>$value)
            {
                if(is_null($value) || $value == '' || empty($value))
                    unset($clauses[$key]);
            }
            
            $records = $this->Student->breakup_house($clauses);
            
            $print_param = $this->input->get('print');
            
            if ($print_param !== null) { 
                $this->load->view("student/reports/print_house", ['records' => $records]);
                
            }
            else {
                $this->load->view("student/reports/breakup_house", ['records' => $records]);
            }
            
        }
        
        public function breakup_category() {
            if(!$this->session->user) {
                return redirect(base_url());
            }
            
            $clauses = $this->format_search_key($_GET);
            foreach($clauses as $key=>$value)
            {
                if(is_null($value) || $value == '' || empty($value))
                    unset($clauses[$key]);
            }

            $records = $this->Student->breakup_category($clauses);
            
            $print_param = $this->input->get('print');
            
            if ($print_param !== null) { 
                $this->load->view("student/reports/print_category", ['records' => $records]);
                
            }
            else {
                $this->load->view("student/reports/breakup_category", ['records' => $records]);
            }
        }
        
        public function breakup_religion() {
            if(!$this->session->user) {
                return redirect(base_url());
            }
            
            $clauses = $this->format_search_key($_GET);
            foreach($clauses as $key=>$value)
            {
                if(is_null($value) || $value == '' || empty($value))
                    unset($clauses[$key]);
            }

            $records = $this->Student->breakup_religion($clauses);
            
            $print_param = $this->input->get('print');
            
            if ($print_param !== null) { 
                $this->load->view("student/reports/print_religion", ['records' => $records]);
                
            }
            else {
                $this->load->view("student/reports/breakup_religion", ['records' => $records]);
            }
    
        }
        
        public function breakup_state() {
            if(!$this->session->user) {
                return redirect(base_url());
            }
            
            $clauses = $this->format_search_key($_GET);
            foreach($clauses as $key=>$value)
            {
                if(is_null($value) || $value == '' || empty($value))
                    unset($clauses[$key]);
            }

            $records = $this->Student->breakup_state($clauses);
            
            $print_param = $this->input->get('print');
            
            if ($print_param !== null) { 
                $this->load->view("student/reports/print_state", ['records' => $records]);
                
            }
            else {
                $this->load->view("student/reports/breakup_state", ['records' => $records]);
            }
            
        }
        
        public function breakup_nationality() {
            if(!$this->session->user) {
                return redirect(base_url());
            }
            
            $clauses = $this->format_search_key($_GET);
            foreach($clauses as $key=>$value)
            {
                if(is_null($value) || $value == '' || empty($value))
                    unset($clauses[$key]);
            }

            $records = $this->Student->breakup_nationality($clauses);
            
            $print_param = $this->input->get('print');
            
            if ($print_param !== null) { 
                $this->load->view("student/reports/print_nationality", ['records' => $records]);
                
            }
            else {
                $this->load->view("student/reports/breakup_nationality", ['records' => $records]);
            }
            
        }
        
        public function breakup_sex() {
            if(!$this->session->user) {
                return redirect(base_url());
            }
            
            $clauses = $this->format_search_key($_GET);
            foreach($clauses as $key=>$value)
            {
                if(is_null($value) || $value == '' || empty($value))
                    unset($clauses[$key]);
            }

            $records = $this->Student->breakup_sex($clauses);
            
            $print_param = $this->input->get('print');
            
            if ($print_param !== null) { 
                $this->load->view("student/reports/print_sex", ['records' => $records]);
                
            }
            else {
                $this->load->view("student/reports/breakup_sex", ['records' => $records]);
            }
            
        }
        
        public function format_search_key(array $array) {
            $result = [];
            foreach ($array as $key => $value) {
                $newKey = preg_replace('/_/', '.', $key, 1); // Replace first underscore with dot
                $result[$newKey] = $value;
            }
            return $result;
        }
        
        public function biodata() {
            if(!$this->session->user) {
                return redirect(base_url());
            }
            
            $student_id = $this->input->post("student_id");
            
            $student = $this->Student->get($student_id);
            
            $appraisal_academic = $this->download_appraisal_academic($student_id);
            $appraisal_extra_curricular = $this->download_appraisal_extra_curricular($student_id);
            $appraisal_game_and_sports = $this->download_appraisal_game_and_sports($student_id);
            $appraisal_others = $this->download_appraisal_others($student_id);
            $appraisal_discipline = $this->download_appraisal_discipline($student_id);
            
            $this->load->view("student/reports/biodata", [
                "record" => $student, 
                "appraisal_academic"            => $appraisal_academic,
                "appraisal_extra_curricular"    => $appraisal_extra_curricular[0],
                "appraisal_game_and_sports"     => $appraisal_game_and_sports[0], 
                "appraisal_others"              => $appraisal_others[0],
                "appraisal_discipline"          => $appraisal_discipline[0]
            ]);
        }
        
        public function generate_horizental_id_cards() {
            if(!$this->session->user) {
                return redirect(base_url());
            }
            
            $clauses = $this->format_search_key($_POST);
            foreach($clauses as $key=>$value)
            {
                if(is_null($value) || $value == '' || empty($value))
                    unset($clauses[$key]);
            }

            $records = $this->Student->generate_id_cards($clauses);

            $this->load->view("student/reports/horizental_id_card", ['records' => $records]);
        }
        
        public function generate_individual_horizental_id_card() {
            if(!$this->session->user) {
                return redirect(base_url());
            }
            
            $student_no = $this->input->post("student_no");
            
            $records = $this->Student->generate_individual_id_card($student_no);
            
            $this->load->view("student/reports/horizental_id_card", ['records' => $records]);
        }
        
        public function generate_vertical_id_cards() {
            if(!$this->session->user) {
                return redirect(base_url());
            }
            
            $clauses = $this->format_search_key($_POST);
            foreach($clauses as $key=>$value)
            {
                if(is_null($value) || $value == '' || empty($value))
                    unset($clauses[$key]);
            }

            $records = $this->Student->generate_id_cards($clauses);
            
            $this->load->view("student/reports/vertical_id_card", ['records' => $records]);
        }
        
        public function generate_individual_vertical_id_card() {
            if(!$this->session->user) {
                return redirect(base_url());
            }
            
            $student_no = $this->input->post("student_no");
            
            $records = $this->Student->generate_individual_id_card($student_no);
            
            $this->load->view("student/reports/vertical_id_card", ['records' => $records]);
        }
        
        public function generate_all_biodata() {
            if(!$this->session->user) {
                return redirect(base_url());
            }
            
            $clauses = $this->format_search_key($_POST);
            foreach($clauses as $key=>$value)
            {
                if(is_null($value) || $value == '' || empty($value))
                    unset($clauses[$key]);
            }

            $records = $this->Student->get_where($clauses);
            
            // Assuming $records is your original array
            $records = array_slice($records, 0, 2);
           
            // Initialize a variable to hold all rendered biodata
            $biodata_views = '';
            
            // Loop through each student record
            foreach ($records as $record) {
                $appraisal_academic = $this->download_appraisal_academic($record['id']);
                $appraisal_extra_curricular = $this->download_appraisal_extra_curricular($record['id']);
                $appraisal_game_and_sports = $this->download_appraisal_game_and_sports($record['id']);
                $appraisal_others = $this->download_appraisal_others($record['id']);
                $appraisal_discipline = $this->download_appraisal_discipline($record['id']);
                
                // Capture the rendered view for the individual student biodata
                $biodata_views .= $this->load->view("student/reports/biodata", [
                    "record" => $record, // Ensure you use the current record
                    "appraisal_academic" => $appraisal_academic,
                    "appraisal_extra_curricular" => $appraisal_extra_curricular[0],
                    "appraisal_game_and_sports" => $appraisal_game_and_sports[0],
                    "appraisal_others" => $appraisal_others[0],
                    "appraisal_discipline" => $appraisal_discipline[0]
                ], true); // Pass true to return the rendered view as a string
            }

            // Pass the complete biodata to the actual view file
            $this->load->view("student/reports/biodata_list", [
                "biodata_views" => $biodata_views
            ]);
 
        }
        
        public function generate_individual_biodata() {
            if(!$this->session->user) {
                return redirect(base_url());
            }
            
            $student_no = $this->input->post("student_no");
            
            $student = $this->Student->get_where(["students.student_no" => $student_no])[0];
            
            $appraisal_academic = $this->download_appraisal_academic($student['id']);
            $appraisal_extra_curricular = $this->download_appraisal_extra_curricular($student['id']);
            $appraisal_game_and_sports = $this->download_appraisal_game_and_sports($student['id']);
            $appraisal_others = $this->download_appraisal_others($student['id']);
            $appraisal_discipline = $this->download_appraisal_discipline($student['id']);
            
            $this->load->view("student/reports/biodata", [
                "record" => $student, 
                "appraisal_academic"            => $appraisal_academic,
                "appraisal_extra_curricular"    => $appraisal_extra_curricular[0],
                "appraisal_game_and_sports"     => $appraisal_game_and_sports[0], 
                "appraisal_others"              => $appraisal_others[0],
                "appraisal_discipline"          => $appraisal_discipline[0]
            ]);
            
        }
        
        public function report_promotion() {
            if(!$this->session->user) {
                return redirect(base_url());
            }
            
            $clauses = $this->format_search_key($_POST);
            foreach($clauses as $key=>$value)
            {
                if(is_null($value) || $value == '' || empty($value))
                    unset($clauses[$key]);
            }

            $records = $this->Student->report_promotion($clauses);
            
            $this->load->view("student/reports/report_promotion", ['records' => $records]);
        }
        
        public function report_passout() {
            if(!$this->session->user) {
                return redirect(base_url());
            }
            
            $clauses = $this->format_search_key($_POST);
            foreach($clauses as $key=>$value)
            {
                if(is_null($value) || $value == '' || empty($value))
                    unset($clauses[$key]);
            }

            $records = $this->Student->report_passout($clauses);
            
            $this->load->view("student/reports/report_passout", ['students' => $records]);
        }
        
        public function student_subject_list() {
            if(!$this->session->user) {
                return redirect(base_url());
            }
            
            $clauses = $this->format_search_key($_POST);
            foreach($clauses as $key=>$value)
            {
                if(is_null($value) || $value == '' || empty($value))
                    unset($clauses[$key]);
            }

            $records = $this->Student->student_subject_list($clauses);
            
            $this->load->view("student/reports/student_subject_list", ['records' => $records]);
        }
        
        public function report_withdraw() {
            if(!$this->session->user) {
                return redirect(base_url());
            }
            
            $clauses = $this->format_search_key($_POST);
            foreach($clauses as $key=>$value)
            {
                if(is_null($value) || $value == '' || empty($value))
                    unset($clauses[$key]);
            }

            $records = $this->Student->report_withdraw($clauses);
            
            $this->load->view("student/reports/report_withdraw", ['students' => $records]);
        }
        
        public function appraisal_academic() {
            if(!$this->session->user) {
                return redirect(base_url());
            }
            
        }
        public function store_appraisal_academic() {
            if(!$this->session->user) {
                return redirect(base_url());
            }
        }
        
        public function appraisal_extra_curricular() {
            if(!$this->session->user) {
                return redirect(base_url());
            }
            
            $extra_curriculars = $this->ExtraCurricular->get();
          
            $clauses = $this->format_search_key($_GET);
            foreach($_GET as $key=>$value)
            {
                if(is_null($value) || $value == '' || empty($value))
                    unset($clauses[$key]);
            }
            
            $records = [];
            
            if(count($clauses) > 0) {
                $records = $this->Student->appraisal_extra_curricular($clauses);
            }
    
            $sections = null;
            
            if(isset($_GET['ss_section_id'])) {
                $sections = $this->Section->get();
            }
            
            $this->load->view("student/appraisal/extra_curricular", ['records' => $records, "extra_curriculars" => $extra_curriculars, "classes" => $this->AcademyClass->get(), "sections" => $sections]);
        }
        public function store_appraisal_extra_curricular() {
            if(!$this->session->user) {
                return redirect(base_url());
            }
            
            // Initialize the output array
            $data = [];
        
            $participated_in = isset($_POST['participated_in']) ? $_POST['participated_in'] : [];
            $result = isset($_POST['result']) ? $_POST['result'] : [];
            $remarks = isset($_POST['remarks']) ? $_POST['remarks'] : [];
            $student_id = isset($_POST['student_id']) ? $_POST['student_id'] : [];
            $class_id = isset($_POST['class_id']) ? $_POST['class_id'] : [];
            $section_id = isset($_POST['section_id']) ? $_POST['section_id'] : [];
        
            // Process each record
            foreach ($student_id as $index => $id) {
                $data[] = [
                    'session_id' => $this->session->academy_session['current_session']['id'],
                    'student_id' => $id,
                    'remarks' => isset($remarks[$index]) ? $remarks[$index] : '',
                    'participated_in' => isset($participated_in[$index]) ? $participated_in[$index] : '',
                    'result' => isset($result[$index]) ? $result[$index] : '',
                ];
            }
            
            $this->Student->store_appraisal_extra_curricular($data);
           
            return redirect(base_url() . '/students/reports/generate-appraisal-extra-curricular');
        }
        
        public function appraisal_game_and_sports() {
            if(!$this->session->user) {
                return redirect(base_url());
            }
            
            $games = $this->Game->get();
          
            $clauses = $this->format_search_key($_GET);
            foreach($_GET as $key=>$value)
            {
                if(is_null($value) || $value == '' || empty($value))
                    unset($clauses[$key]);
            }
            
            $records = [];
            
            $sections = null;
            
            if(isset($_GET['ss_section_id'])) {
                $sections = $this->Section->get();
            }
            
            if(count($clauses) > 0) {
                $records = $this->Student->appraisal_game_sports($clauses);
            }
            
            $this->load->view("student/appraisal/game_sports", ['records' => $records, "games" => $games, "classes" => $this->AcademyClass->get(), "sections" => $sections]);
        }
        public function store_appraisal_game_and_sports() {
            if(!$this->session->user) {
                return redirect(base_url());
            }
            
            // Initialize the output array
            $data = [];
        
            $participated_in = isset($_POST['participated_in']) ? $_POST['participated_in'] : [];
            $result = isset($_POST['result']) ? $_POST['result'] : [];
            $remarks = isset($_POST['remarks']) ? $_POST['remarks'] : [];
            $student_id = isset($_POST['student_id']) ? $_POST['student_id'] : [];
            $class_id = isset($_POST['class_id']) ? $_POST['class_id'] : [];
            $section_id = isset($_POST['section_id']) ? $_POST['section_id'] : [];
        
            // Process each record
            foreach ($student_id as $index => $id) {
                $data[] = [
                    'session_id' => $this->session->academy_session['current_session']['id'],
                    'student_id' => $id,
                    'remarks' => isset($remarks[$index]) ? $remarks[$index] : '',
                    'participated_in' => isset($participated_in[$index]) ? $participated_in[$index] : '',
                    'result' => isset($result[$index]) ? $result[$index] : '',
                ];
            }
            
            $this->Student->store_appraisal_game_sports($data);
           
            return redirect(base_url() . '/students/reports/generate-appraisal-game-and-sports');
        }
        

        public function appraisal_others() {
            if(!$this->session->user) {
                return redirect(base_url());
            }
            
            $others = $this->ApprisalOther->get();
          
            $clauses = $this->format_search_key($_GET);
            foreach($_GET as $key=>$value)
            {
                if(is_null($value) || $value == '' || empty($value))
                    unset($clauses[$key]);
            }
            
            $records = [];
            
            $sections = null;
            
            if(isset($_GET['ss_section_id'])) {
                $sections = $this->Section->get();
            }
            
            if(count($clauses) > 0) {
                $records = $this->Student->appraisal_others($clauses);
            }
            
            $this->load->view("student/appraisal/others", ['records' => $records, "others" => $others, "classes" => $this->AcademyClass->get(), "sections" => $sections]);
        }
        public function store_appraisal_others() {
            if(!$this->session->user) {
                return redirect(base_url());
            }
            
            // Initialize the output array
            $data = [];
        
            $particular = isset($_POST['particular']) ? $_POST['particular'] : [];
            $remarks = isset($_POST['remarks']) ? $_POST['remarks'] : [];
            $student_id = isset($_POST['student_id']) ? $_POST['student_id'] : [];
            $class_id = isset($_POST['class_id']) ? $_POST['class_id'] : [];
            $section_id = isset($_POST['section_id']) ? $_POST['section_id'] : [];
        
            // Process each record
            foreach ($student_id as $index => $id) {
                $data[] = [
                    'session_id' => $this->session->academy_session['current_session']['id'],
                    'student_id' => $id,
                    'remarks' => isset($remarks[$index]) ? $remarks[$index] : '',
                    'particular' => isset($particular[$index]) ? $particular[$index] : '',
                ];
            }
            
            $this->Student->store_appraisal_others($data);
           
            return redirect(base_url() . '/students/reports/generate-appraisal-others');
        }
        
        
        public function appraisal_discipline() {
            if(!$this->session->user) {
                return redirect(base_url());
            }
            
            $participations     = $this->Participation->get();
            $expressiveness     = $this->Expressivenesses->get();
            $leaderships        = $this->Leadership->get();
            $interactions       = $this->Interaction->get();
            $conducts           = $this->Conduct->get();
            $behaviours         = $this->Behaviour->get();
            $attendancees       = $this->Attendance->get();
            $punctualities      = $this->Punctuality->get();
          
            $clauses = $this->format_search_key($_GET);
            foreach($_GET as $key=>$value)
            {
                if(is_null($value) || $value == '' || empty($value))
                    unset($clauses[$key]);
            }
            
            $records = [];
            
            if(count($clauses) > 0) {
                $records = $this->Student->appraisal_discipline($clauses);
            }
            
            $this->load->view("student/appraisal/discipline", [
                "records"   => $records, 
                "others"    => $others, 
                "classes"   => $this->AcademyClass->get(),
                
                "participations" => $participations,
                "expressiveness" => $expressiveness,
                "leaderships" => $leaderships,
                "interactions" => $interactions,
                "conducts" => $conducts,
                "behaviours" => $behaviours,
                "attendancees" => $attendancees,
                "punctualities" => $punctualities
            ]);
        }
        
        public function store_appraisal_discipline() {
            if(!$this->session->user) {
                return redirect(base_url());
            }
            
            // Initialize the output array
            $data = [];
        
            $conduct_id = isset($_POST['conduct_id']) ? $_POST['conduct_id'] : [];
            $behaviour_id = isset($_POST['behaviour_id']) ? $_POST['behaviour_id'] : [];
            $punctuality_id = isset($_POST['punctuality_id']) ? $_POST['punctuality_id'] : [];
            $attendence_id = isset($_POST['attendance_id']) ? $_POST['attendance_id'] : [];
            $leadership_id = isset($_POST['leadership_id']) ? $_POST['leadership_id'] : [];
            $interaction_id = isset($_POST['interaction_id']) ? $_POST['interaction_id'] : [];
            $expressiveness_id = isset($_POST['expressiveness_id']) ? $_POST['expressiveness_id'] : [];
            $participation_id = isset($_POST['participation_id']) ? $_POST['participation_id'] : [];
            $student_id = isset($_POST['student_id']) ? $_POST['student_id'] : [];
            
        
            // Process each record
            foreach ($student_id as $index => $id) {
                $data[] = [
                    'session_id' => $this->session->academy_session['current_session']['id'],
                    'student_id' => $id,
                    
                    'conduct_id' => isset($conduct_id[$index]) ? $conduct_id[$index] : '',
                    'behaviour_id' => isset($behaviour_id[$index]) ? $behaviour_id[$index] : '',
                    'punctuality_id' => isset($punctuality_id[$index]) ? $punctuality_id[$index] : '',
                    'attendence_id' => isset($attendence_id[$index]) ? $attendence_id[$index] : '',
                    'leadership_id' => isset($leadership_id[$index]) ? $leadership_id[$index] : '',
                    'interaction_id' => isset($interaction_id[$index]) ? $interaction_id[$index] : '',
                    'expressiveness_id' => isset($expressiveness_id[$index]) ? $expressiveness_id[$index] : '',
                    'participation_id' => isset($participation_id[$index]) ? $participation_id[$index] : '',
                    
                ];
            }
            
            $this->Student->store_appraisal_discipline($data);
           
            return redirect(base_url() . '/students/reports/generate-appraisal-discipline');
        }
        
        public function download_appraisal_academic($student_id = null) {
            if(!$this->session->user) {
                return redirect(base_url());
            } 
            
            $clauses = $this->format_search_key($_POST);
            foreach($clauses as $key=>$value)
            {
                if(is_null($value) || $value == '' || empty($value))
                    unset($clauses[$key]);
            }
            
            // if(isset($clauses["ss.class_id"])) {
            //     $exams = $this->ExamPaper->get_exams([
            //         "class_id" => $clauses["ss.class_id"], 
            //         "paper_type" => "component", 
            //     ]);
            // }
            // else {
            //     $exams = $this->ExamPaper->get_exams([
            //         "paper_type" => "component", 
            //     ]);
            // }
           
            // $first_unit_test = $this->ExamPaper->get_exams(["class_id" => $clauses["ss.class_id"], "paper_type" => "component", "exam_id" => 1]);
            // $first_term_test = $this->ExamPaper->get_exams(["class_id" => $clauses["ss.class_id"], "paper_type" => "component", "exam_id" => 2]);
            
            // $second_unit_test = $this->ExamPaper->get_exams(["class_id" => $clauses["ss.class_id"], "paper_type" => "component", "exam_id" => 3]);
            // $second_term_test = $this->ExamPaper->get_exams(["class_id" => $clauses["ss.class_id"], "paper_type" => "component", "exam_id" => 4]);
            

            if($student_id) {
                $student = $this->Student->get($student_id);
             
                $at = $this->Result->get_annual_term_result($student['student_session_class_id'], $student['student_session_section_id'] , 4, 'indiviual', $student_id);
            }
            else {
                $at = $this->Result->get_annual_term_result($clauses["ss.class_id"], $clauses["ss.section_id"] , 4);
            }
            
            if($student_id) {
                $student = $this->Student->get($student_id);
                
                $ft = $this->Result->get_first_term_result($student['student_session_class_id'], $student['student_session_section_id'] , 2, 'indiviual', $student_id);
            }
            else {
                $ft = $this->Result->get_first_term_result($clauses["ss.class_id"], $clauses["ss.section_id"] , 2);
            }
          
          
            if($student_id) { 
                return [$at, $ft, $student['student_session_class_id']];
            }
            else {
                // echo "<pre>";
                // print_r($ft);
                // echo "</pre>";
                // exit();
                
                $this->load->view("student/reports/apprisal_academic", ['at' => $at, "ft" => $ft, "clauses" => $_POST]);
            }
        }
        
        public function download_appraisal_extra_curricular($student_id = null) {
            if(!$this->session->user) {
                return redirect(base_url());
            }
        
            if(!$student_id) 
            {
                $clauses = $this->format_search_key($_POST);
                foreach($clauses as $key=>$value)
                {
                    if(is_null($value) || $value == '' || empty($value))
                        unset($clauses[$key]);
                }
            }
            else
            {
                $clauses["ss.student_id"] = $student_id;
                
                $clauses["ss.promoted"] = "ANY";
                $clauses["ss.withdraw"] = "ANY";
                $clauses["ss.passout"] = "ANY";
            }
            
            $records = $this->Student->download_extra_curricular($clauses);
            
            if(!$student_id) 
            {
                $this->load->view("student/reports/apprisal_extra_curricular", ['records' => $records]);
            }
            else 
            {
                return $records;
            }
        }
        
        public function download_appraisal_game_and_sports($student_id = null) {
            if(!$this->session->user) {
                return redirect(base_url());
            }
            
            if(!$student_id)
            {
                $clauses = $this->format_search_key($_POST);
                foreach($clauses as $key=>$value)
                {
                    if(is_null($value) || $value == '' || empty($value))
                        unset($clauses[$key]);
                }
            }
            else
            {
                $clauses["ss.student_id"] = $student_id;
                
                $clauses["ss.promoted"] = "ANY";
                $clauses["ss.withdraw"] = "ANY";
                $clauses["ss.passout"] = "ANY";
            }
        
            $records = $this->Student->download_game_sports($clauses);
            
            if(!$student_id) 
            {
                $this->load->view("student/reports/apprisal_game_sports", ['records' => $records]);
            }
            else 
            {
                return $records;
            }
           
        }
        
        public function download_appraisal_others($student_id = null) {
            if(!$this->session->user) {
                return redirect(base_url());
            }
            
            if(!$student_id)
            {
                $clauses = $this->format_search_key($_POST);
                foreach($clauses as $key=>$value)
                {
                    if(is_null($value) || $value == '' || empty($value))
                        unset($clauses[$key]);
                }
            }
            else 
            {
                $clauses["ss.student_id"] = $student_id;
                
                $clauses["ss.promoted"] = "ANY";
                $clauses["ss.withdraw"] = "ANY";
                $clauses["ss.passout"] = "ANY";
            }
            
            $records = $this->Student->download_appraisal_others($clauses);
           
            if(!$student_id)
            {
                $this->load->view("student/reports/apprisal_others", ['records' => $records]);  
            }
            else 
            {
                return $records;
            }
            
        }
        
        public function download_appraisal_discipline($student_id = null) {
            if(!$this->session->user) {
                return redirect(base_url());
            }
        
            if(!$student_id)
            {
                $clauses = $this->format_search_key($_POST);
                foreach($clauses as $key=>$value)
                {
                    if(is_null($value) || $value == '' || empty($value))
                        unset($clauses[$key]);
                }
            }
            else 
            {
                $clauses["ss.student_id"] = $student_id;
                
                $clauses["ss.promoted"] = "ANY";
                $clauses["ss.withdraw"] = "ANY";
                $clauses["ss.passout"] = "ANY"; 
            }
        
            $records = $this->Student->download_discipline($clauses);
            
            if(!$student_id)
            {
                $this->load->view("student/reports/apprisal_discipline", ['records' => $records]);
            }
            else
            {
                return $records;
            }
        }
        
        public function user_defined_report() {
            if(!$this->session->user) {
                return redirect(base_url());
            }
            
            $data = array(
                "classes"       => $this->AcademyClass->get(),
                "sections"      => $this->Section->get(),
                "student_types" => $this->StudentType->get(),
                "houses"        => $this->House->get(),
                "categories"    => $this->Category->get(),
                "religions"     => $this->Religion->get(),
                "nationalities" => $this->Nationality->get(),
                "states"        => $this->State->get(),
                "subject_types" => $this->SubjectType->get(),
            );
     
            $this->load->view("student/reports/user_defined_reports", $data);
        }
        
        public function user_defined_report_get_students() {
            if(!$this->session->user) {
                return redirect(base_url());
            }
            
            
            $clauses = $this->format_search_key($_GET);
            
            foreach($clauses as $key=>$value)
            {
                if(is_null($value) || $value == '' || empty($value))
                    unset($clauses[$key]);
            }
            
            $clauses["ss.withdraw"] = 0;
            $clauses["ss.passout"] = 0;
            $clauses["ss.promoted"] = "ANY";
            $clauses["s.deleted"] = 0;
            
            $transformed = array();
            
            foreach ($clauses as $key => $value) {
                if (strpos($key, 'ss.') === 0) {
                    // Replace 'ss.' with 'student_session.'
                    $newKey = 'student_session.' . substr($key, 3);
                } elseif (strpos($key, 's.') === 0) {
                    // Replace 's.' with 'students.'
                    $newKey = 'students.' . substr($key, 2);
                } else {
                    // For normal keys, prefix with 'students.'
                    $newKey = 'students.' . $key;
                }
                
                $transformed[$newKey] = $value;
            }
            
        
            $data = array(
                "classes"       => $this->AcademyClass->get(),
                "sections"      => $this->Section->get(),
                "student_types" => $this->StudentType->get(),
                "houses"        => $this->House->get(),
                "categories"    => $this->Category->get(),
                "religions"     => $this->Religion->get(),
                "nationalities" => $this->Nationality->get(),
                "states"        => $this->State->get(),
                "students"      => $this->Student->get_where($transformed),
                "subject_types" => $this->SubjectType->get(),
            );
            
            $this->load->view("student/reports/user_defined_reports", $data);
            
        }
        
        public function generate_user_defined_report() {
            if(!$this->session->user) {
                return redirect(base_url());
            }
            
            $students       = $_POST['student_ids'];
            $fields         = $_POST['fields'];
            $blank_column   = $_POST['blank_column'];
            
            $student_data = [];
            foreach($students as $student) {
                $student_data[] = $this->Student->get($student);
            }
            
            $key = array_search("blank_columns", $fields);
            if ($key !== false) {
                unset($fields[$key]);
            }
            
            $student_records = [];
            foreach($student_data as $sd) {
                $r = [
                    "student_no"    => $sd['student_no'],
                    "f_name"        => $sd['f_name'],
                    "m_name"        => $sd['m_name'],
                    "l_name"        => $sd['l_name'],
                    "class_id"      => $sd['student_session_class_id'],
                    "section_id"    => $sd['student_session_section_id'],
                ];
                
                
                // Convert foreach to for loop
                for($i = 0; $i < count($fields); $i++) {
                    $field = $fields[$i];
                    
                    $p = explode("_", $field);
                    
                    if($p[0] == "subjecttype") {
                
                        $student_subject = $this->StudentSubject->get_where([
                            "current_session_id" => $this->session->academy_session['current_session']['id'],
                            "subject_type_id"   => $p[1],
                            "student_id"    => $sd['id']
                        ]);
                        
                        if($student_subject) {
                            $subject = $this->Subject->get($student_subject['subject_id']);
                            
                            $r[$field] = $subject['name'];
                        }
                        else {
                            $r[$field] = "";
                        }
                        
                    }
                    else {
                        if (array_key_exists($field, $sd)) {
                            $r[$field] = $sd[$field];
                        }
                        else {
                            $r[$field] = "";
                        }
                    }
                }

                
                $student_records[] = $r;
            }
            
            $data = [
                "students"      =>  $student_records,
                "fields"        =>  $fields,
                "blank_columns" =>  $blank_column,
                "heading"       =>  $_POST['heading'],
                "subheading"    =>  $_POST['subheading'],
            ];
           
            $this->load->view("student/reports/user_defined_report_view", $data); 
        }
    }