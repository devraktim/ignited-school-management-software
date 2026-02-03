<?php 
    defined('BASEPATH') OR exit('No direct script access allowed');

    class AnnualTerm extends CI_Controller {
        public function __construct() {
            parent::__construct();
            $this->load->model("AcademyClass");
            $this->load->model("Section");
            $this->load->model("ClassSection");
            $this->load->model("ExamPaper");
            $this->load->model("EvolutionGrade");
            $this->load->model("EvolutionSubject");
            $this->load->model("EvolutionPaper");
            $this->load->model("ExamAttendence");
            $this->load->model("StudentSubject");
            $this->load->model("Subject");
            $this->load->model("Remarks");
            $this->load->model("Exam");
            $this->load->model("Student");
            $this->load->model("Marks");
            $this->load->model("Result");
        }
        
        public function get_result() {
            // Set CORS headers
            header("Access-Control-Allow-Origin: *");
            header("Access-Control-Allow-Methods: POST, OPTIONS");

            $class_id =     $this->input->post("class_id");
            $section_id =   $this->input->post("section_id");
            $exam_id =      $this->input->post("exam_id");
            $session_id =   $this->session->academy_session['current_session']['id'];
            
            $report_for =   $this->input->post("report_for");
            $student_id =   $this->input->post("student_id");
            
            $header =   $this->input->post("header");
            $store =   $this->input->post("store");
            
            $class_detail = $this->AcademyClass->get($class_id);
            $section_detail = $this->Section->get($section_id);
            
            $request_from =  $this->input->post("request_from");
            
            if(isset($request_from) && $request_from == "sfsjorethang") {
               
                $s = $this->Student->get_where([
                    "s.student_no" => $this->input->post("student_no"),
                    "student_session.session_id" => 1,
                    "student_session.promoted"      => "ANY",
                ]);
                
                if(count($s) == 0) {
                    return $this->output
                             ->set_content_type('application/json')
                             ->set_output(json_encode([
                                 'status'  => 'error',
                                 'message' => 'No Student Found!'
                             ])); 
                }
                else {
                    $username =   $this->input->post("student_no");
                    $password =   $this->input->post("password");
                    
                    $user_found = true;
                    $user_id = $s[0]['id'];
 
                    $formatted_dob = date("d-m-Y", strtotime($s[0]['dob']));
                    $pass = str_replace('-', '', $formatted_dob);
                    
                    $password_match = $pass == $password;
                    
                    
                    $class_detail = $this->AcademyClass->get($class_id);
                    $section_id = $s[0]['student_session_section_id'];
                    $section_detail = $this->Section->get($section_id);
                }
                
            }

            
            // === CLASS I to IV - FINAL TERM ===
            if (in_array($class_id, [4, 5, 6, 7]) && $exam_id == 4) {
        
                $students = $this->Student->get_where([
                    "class_id"                 => $class_id,
                    "section_id"               => $section_id,
                    "student_session.promoted" => "ANY",
                    "student_session.session_id" => 1,
                ]);
        
                $records = [];
        
                $evolution_paper = $this->EvolutionPaper->get_where([
                    "class_id" => $class_id,
                    "exam_id"  => 4
                ]);
                $evolution_subject_ids = isset($evolution_paper['subjects']) 
                    ? explode(",", $evolution_paper['subjects']) 
                    : [];
        
                $subject_type_ids         = [1, 2, 3, 4, 5, 6, 7];
                $special_subject_type_ids = [12, 13];
        
                foreach ($students as $student) {
        
                    $student_id = $student['id'];
                    $minor_subjects = [];
        
                    // === Evolution Grades ===
                    $student_evolution = $this->Marks->get_student_evolution($class_id, 4, $student_id);
                    $grades = explode(",", $student_evolution);
        
                    foreach ($evolution_subject_ids as $i => $evolution_id) {
                        $subject_info = $this->EvolutionSubject->get($evolution_id);
                        $minor_subjects[$subject_info['name'] ?? 'Unknown'] = $grades[$i] ?? '';
                    }
        
                    // === Attendance & Remarks ===
                    $attendance_percent = (float) $this->ExamAttendence->get_student_attendence_percentage($class_id, $exam_id, $student['id']);
                    $remark             = $this->Remarks->get_student_remarks($class_id, $exam_id, $student['id']);
        
                    $subjects           = [];
                    $ut1_marks          = [];
                    $mid_marks          = [];
                    $ut2_marks          = [];
                    $final_marks        = [];
                    $annual_marks       = [];
                    $totals             = [];
        
                    $english_total       = null;
                    $major_subject_fails = 0;
                    $major_subject_absents = 0;
                    $grand_total         = 0;
                    $grand_total_max     = 0;
                    
                    $ut1_absent          = 0;
                    $mid_absent          = 0;
                    $ut2_absent          = 0;
                    $final_absent        = 0;
        
                    // === MAJOR SUBJECTS ===
                    foreach ($subject_type_ids as $id) {
        
                        $student_subject = $this->StudentSubject->get_where([
                            "academy_class_id"   => $class_id,
                            "student_id"         => $student_id,
                            "subject_type_id"    => $id,
                            "current_session_id" => 1
                        ]);
        
                        $subject_id   = $student_subject['subject_id'] ?? null;
                        $subject_name = $this->Subject->get($subject_id)['name'] ?? 'N/A';
                        $subjects["s$id"] = $subject_name;
        
                        // === FETCH MARKS ===
                        $ut1 = $this->Marks->get_student_marks_by_subject_type($class_id, $student_id, 1, $id); // UT1
                        $midt = $this->Marks->get_student_marks_by_subject_type($class_id, $student_id, 2, $id); // MID T
                        $ut2 = $this->Marks->get_student_marks_by_subject_type($class_id, $student_id, 3, $id); // UT2
                        $finalt = $this->Marks->get_student_marks_by_subject_type($class_id, $student_id, 4, $id); // Final Term

                        // === HANDLE ABSENT / REPORTED ===
                        if ($ut1 === "AB") $ut1_absent++;
                        if ($midt === "AB") $mid_absent++;
                        
                        if ($ut2 === "AB") $ut2_absent++;
                        if ($finalt === "AB") $final_absent++;
                        
                        $ut1 = ($ut1 === "AB" || $ut1 === "R" || $ut1 === '') ? ($ut1 === '' ? '' : $ut1) : $ut1;
                        $midt = ($midt === "AB" || $midt === "R" || $midt === '') ? ($midt === '' ? '' : $midt) : $midt;
                        $ut2 = ($ut2 === "AB" || $ut2 === "R" || $ut2 === '') ? ($ut2 === '' ? '' : $ut2) : $ut2;
                        $finalt = ($finalt === "AB" || $finalt === "R" || $finalt === '') ? ($finalt === '' ? '' : $finalt) : $finalt;
                        
                        // === MID TERM TOTAL (UT1 + MID T) ===
                        if ($ut1 === "AB" && $midt === "AB") {
                            $mid_total = "AB";
                        } elseif ($ut1 === "R" || $midt === "R") {
                            $mid_total = "R";
                        } elseif ($ut1 === '' && $midt === '') {
                            $mid_total = '';
                        } else {
                            $mid_total = (is_numeric($ut1) ? $ut1 : 0) + (is_numeric($midt) ? $midt : 0);
                        }
        
                        // === FINAL TERM TOTAL (UT2 + FINAL T) ===
                        if ($ut2 === "AB" && $finalt === "AB") {
                            $final_total = "AB";
                        } elseif ($ut2 === "R" || $finalt === "R") {
                            $final_total = "R";
                        } elseif ($ut2 === '' && $finalt === '') {
                            $final_total = '';
                        } else {
                            $final_total = (is_numeric($ut2) ? $ut2 : 0) + (is_numeric($finalt) ? $finalt : 0);
                        }
        
                        // === ANNUAL CALCULATION ===
                        if ($mid_total === "AB" && $final_total === "AB") {
                            $annual_total = "AB";
                        } elseif ($mid_total === "R" || $final_total === "R") {
                            $annual_total = "R";
                        } elseif ($mid_total === '' && $final_total === '') {
                            $annual_total = '';
                        } elseif (is_numeric($mid_total) && is_numeric($final_total)) {
                            $annual_total = ceil(($mid_total + $final_total) / 2);
                        } elseif (is_numeric($mid_total) && !is_numeric($final_total)) {
                            $annual_total = $mid_total;
                        } elseif (!is_numeric($mid_total) && is_numeric($final_total)) {
                            $annual_total = $final_total;
                        } else {
                            $annual_total = '';
                        }
        
                        $ut1_marks["s$id"]   = $ut1;
                        $mid_marks["s$id"]   = $midt;
                        $ut2_marks["s$id"]   = $ut2;
                        $final_marks["s$id"] = $finalt;
                        
                        $totals["s$id"]      = $final_total;
                        $annual_marks["s$id"]= $annual_total;
        
                        // if ($subject_id == 39) $english_total = $annual_total;
                        // if (is_numeric($annual_total) && $annual_total < 35) $major_subject_fails++;
                        // if ($ut2 == 0 && $finalt == 0) $major_subject_absents++;
                        
                        // === Identify English Total ===
                        if ($subject_id == 39) $english_total = $annual_total;
                        
                        // === Count Failures (<35%) ===
                        if (is_numeric($annual_total) && $annual_total < 35) {
                            $major_subject_fails++;
                        }
                        
                        // === Determine Absence Cases (for INC result) ===
                        // Case 1: Absent in both UT2 and Final Term
                        if (
                            ($ut2 === "AB" || $ut2 === 0 || $ut2 === '' || $ut2 === null) &&
                            ($finalt === "AB" || $finalt === 0 || $finalt === '' || $finalt === null)
                        ) {
                            $major_subject_absents++;
                        }
                        // Case 2: Appeared in UT2 but absent in Final Term
                        elseif (
                            ($ut2 !== "AB" && $ut2 !== 0 && $ut2 !== '' && $ut2 !== null) &&
                            ($finalt === "AB" || $finalt === 0 || $finalt === '' || $finalt === null)
                        ) {
                            $major_subject_absents++;
                        }
        
                        if (is_numeric($annual_total)) {
                            $grand_total += $annual_total;
                            $grand_total_max += 100;
                        }
                    }
                    
                    // === Special Subjects ===
                    $special_subjects         = [];
                    $special_ut1_marks        = [];
                    $special_mid_marks        = [];
                    $special_ut2_marks        = [];
                    $special_final_marks      = [];
                    $special_mid_totals       = [];
                    $special_final_totals     = [];
                    $special_annual_marks    = [];
                    
                    foreach ($special_subject_type_ids as $index => $id) {
                        $key = "sps" . ($index + 1);
                    
                        $student_subject = $this->StudentSubject->get_where([
                            "academy_class_id"   => $class_id,
                            "student_id"         => $student_id,
                            "subject_type_id"    => $id,
                            "current_session_id" => 1
                        ]);
                    
                        $subject_id   = $student_subject['subject_id'] ?? null;
                        $subject_name = $this->Subject->get($subject_id)['name'] ?? 'N/A';
                        $special_subjects[$key] = $subject_name;
                    
                        // === FETCH MARKS ===
                        $ut1     = $this->Marks->get_student_marks_by_subject_type($class_id, $student_id, 1, $id); // Unit Test 1
                        $midt    = $this->Marks->get_student_marks_by_subject_type($class_id, $student_id, 2, $id); // Mid Term
                        $ut2     = $this->Marks->get_student_marks_by_subject_type($class_id, $student_id, 3, $id); // Unit Test 2
                        $finalt  = $this->Marks->get_student_marks_by_subject_type($class_id, $student_id, 4, $id); // Final Term
                    
                        // === HANDLE ABSENT ===
                        $ut1    = ($ut1 === "AB" || $ut1 === "R" || $ut1 === '') ? ($ut1 === '' ? '' : $ut1) : (float)$ut1;
                        $midt   = ($midt === "AB" || $midt === "R" || $midt === '') ? ($midt === '' ? '' : $midt) : (float)$midt;
                        $ut2    = ($ut2 === "AB" || $ut2 === "R" || $ut2 === '') ? ($ut2 === '' ? '' : $ut2) : (float)$ut2;
                        $finalt = ($finalt === "AB" || $finalt === "R" || $finalt === '') ? ($finalt === '' ? '' : $finalt) : (float)$finalt;
                    
                        // === HALF YEARLY (UT1 + MID T) ===
                        if ($ut1 === "AB" && $midt === "AB") {
                            $mid_total = "AB";
                        } elseif ($ut1 === "R" || $midt === "R") {
                            $mid_total = "R";
                        } elseif ($ut1 === '' && $midt === '') {
                            $mid_total = '';
                        } else {
                            $mid_total = (is_numeric($ut1) ? $ut1 : 0) + (is_numeric($midt) ? $midt : 0);
                        }
                    
                        // === FINAL TERM (UT2 + FINAL T) ===
                        if ($ut2 === "AB" && $finalt === "AB") {
                            $final_total = "AB";
                        } elseif ($ut2 === "R" || $finalt === "R") {
                            $final_total = "R";
                        } elseif ($ut2 === '' && $finalt === '') {
                            $final_total = '';
                        } else {
                            $final_total = (is_numeric($ut2) ? $ut2 : 0) + (is_numeric($finalt) ? $finalt : 0);
                        }
                    
                        // === ANNUAL TOTAL (Average of Half-Yearly + Final Term) ===
                        if ($mid_total === "AB" && $final_total === "AB") {
                            $annual_total = "AB";
                        } elseif ($mid_total === "R" || $final_total === "R") {
                            $annual_total = "R";
                        } elseif ($mid_total === '' && $final_total === '') {
                            $annual_total = '';
                        } elseif (is_numeric($mid_total) && is_numeric($final_total)) {
                            $annual_total = ceil(($mid_total + $final_total) / 2);
                        } elseif (is_numeric($mid_total) && !is_numeric($final_total)) {
                            $annual_total = $mid_total;
                        } elseif (!is_numeric($mid_total) && is_numeric($final_total)) {
                            $annual_total = $final_total;
                        } else {
                            $annual_total = '';
                        }
                    
                        // === STORE VALUES ===
                        $special_ut1_marks[$key]        = $ut1;
                        $special_mid_marks[$key]        = $midt;
                        $special_ut2_marks[$key]        = $ut2;
                        $special_final_marks[$key]      = $finalt;
                        $special_mid_totals[$key]       = $mid_total;
                        $special_final_totals[$key]     = $final_total;
                        $special_annual_marks[$key]     = $annual_total;
                    
                        // === GRAND TOTAL UPDATE ===
                        if (is_numeric($annual_total)) {
                            $grand_total     += $annual_total;
                            $grand_total_max += 100;
                        }
                    }

                    // === RESULT CALCULATION ===
                    $percentage = $grand_total_max > 0 ? round(($grand_total / $grand_total_max) * 100, 2) : 0;
                    $result = 'PASS';
        
                    if ($english_total === null || $major_subject_absents > 0 || $english_total === '') {
                        $result = 'INC';
                    } elseif (is_numeric($english_total) && $english_total < 35) {
                        $result = 'FAIL';
                    } elseif ($major_subject_fails == 1 || $major_subject_fails == 2) {
                        $result = 'PUC';
                    } elseif ($major_subject_fails == 3) {
                        $result = 'FAIL';
                    } elseif ($major_subject_fails >= 4) {
                        $result = 'PCNA';
                    }
        
                    $rank_eligible = (
                        $result === 'PASS' &&
                        $english_total >= 35 &&
                        $major_subject_absents === 0 &&
                        $major_subject_fails === 0 &&
                        $ut2_absent == 0 &&
                        $final_absent == 0
                    );
                    
                    $mid_totals = array_combine(array_keys($ut1_marks), array_map(function($k) use($ut1_marks, $mid_marks){return ($ut1_marks[$k]+$mid_marks[$k]);}, array_keys($ut1_marks)));
        
                    // === STORE RECORD ===
                    $records[$student_id] = [
                        "name"                     => trim("{$student['f_name']} {$student['m_name']} {$student['l_name']}"),
                        "roll_no"                  => $student["roll_no"],
                        "student_no"               => $student["student_no"],
                        "student_id"               => $student_id,
                        "student_dob"              => $student["dob"],
                        "attendence"               => round($attendance_percent, 2) ?: '',
                        "remark"                   => $remark,
                        
                        "subject_type_ids"         => $subject_type_ids,
                        "special_subject_type_ids" => $special_subject_type_ids,
        
                        "minor_subjects"           => $minor_subjects,
                        "attendence"               => $attendence,
                        "remark"                   => $remark,
    
                        "subjects"                 => $subjects,
                        "ut1_marks"                => $ut1_marks,
                        "mid_marks"                => $mid_marks,
                        "mid_totals"               => $mid_totals,
                        "ut2_marks"                => $ut2_marks,
                        "final_marks"              => $final_marks,
                        "final_totals"             => $totals, // (UT2 + FINAL T)
                        "annual_marks"             => $annual_marks, // (((UT1 + MID T) + (UT2 + FINAL T)) / 2)
                        
                        "special_subjects"        => $special_subjects,
                        "special_ut1_marks"       => $special_ut1_marks,
                        "special_mid_marks"       => $special_mid_marks,
                        "special_mid_totals"      => $special_mid_totals,
                        "special_ut2_marks"       => $special_ut2_marks,
                        "special_final_marks"     => $special_final_marks,
                        "special_final_totals"    => $special_final_totals, // (UT2 + FINAL T)
                        "special_annual_marks"    => $special_annual_marks, // (((UT1 + MID T) + (UT2 + FINAL T)) / 2)
    
                        "grand_total"              => $grand_total,
                        "percentage"               => $percentage,
                        "result"                   => $result,
                        "rank_eligible"            => $rank_eligible,
                        "ut1_absent"               => $ut1_absent,
                        "mid_absent"               => $mid_absent,
                        "ut2_absent"               => $ut2_absent,
                        "final_absent"             => $final_absent
                    ];
                }
        
                // === RANK LOGIC ===
                $group_ranks = [];
                foreach ($records as $record) {
                    if ($record['rank_eligible']) {
                        $group_ranks[$record['grand_total']][] = $record['student_id'];
                    }
                }
                krsort($group_ranks);
                $group_totals = array_keys($group_ranks);
        
                foreach ($records as &$record) {
                    if ($record['rank_eligible']) {
                        $cur_total_position = array_search($record['grand_total'], $group_totals);
                        $record['rank'] = 1;
                        if ($cur_total_position > 0) {
                            $record['rank'] = array_sum(array_map('count', array_slice($group_ranks, 0, $cur_total_position))) + 1;
                        }
                    }
                }
        
                // === STORE / OUTPUT ===
                if (isset($store) && $store == "yes") {
                    $this->store_result($report_for == "individual" ? [$records[$student_id]] : $records);
                    echo json_encode(["status" => "success", "message" => "Final Term Result stored successfully."]);
                    return;
                }
        
                if ($request_from == "sfsjorethang") {
                    if ($user_found && $password_match) {
                        $html_output = $this->load->view(
                            "academics/result/final_term/class_i_iv",
                            [
                                "students"       => [$records[$user_id]],
                                "class_detail"   => $class_detail,
                                "section_detail" => $section_detail,
                                "header"         => "yes"
                            ],
                            TRUE
                        );
                        $this->output
                            ->set_content_type('application/json')
                            ->set_output(json_encode(['status' => 'success', 'html' => $html_output]));
                    } else {
                        $this->output
                            ->set_content_type('application/json')
                            ->set_output(json_encode(['status' => 'error', 'message' => 'Invalid credentials']));
                    }
                } else {

                    $this->load->view(
                        "academics/" . $this->input->post('result_type') . "/final_term/class_i_iv",
                        [
                            "students"       => $report_for == "individual" ? [$records[$student_id]] : $records,
                            "class_detail"   => $class_detail,
                            "section_detail" => $section_detail,
                            "header"         => $header
                        ]
                    );
                }
            }

            // Class V to VIII
            else if (in_array($class_id, [8, 9, 10, 11]) && $exam_id == 4) 
            {
                $students = $this->Student->get_where([
                    "class_id"                   => $class_id,
                    "section_id"                 => $section_id,
                    "student_session.promoted"   => "ANY",
                    "student_session.session_id" => 1,
                ]);
            
                $records = [];
                $subject_cache = [];
            
                foreach ($students as $student) {
                    // === Evolution (Minor) Subjects ===
                    $evolution_paper = $this->EvolutionPaper->get_where([
                        "class_id" => $class_id,
                        "exam_id"  => $exam_id
                    ]);
            
                    $evolution_subject_ids = explode(",", $evolution_paper['subjects'] ?? '');
                    $student_evolution     = $this->Marks->get_student_evolution($class_id, $exam_id, $student['id']);
                    $grades                = explode(",", $student_evolution ?? '');
                    $minor_subjects        = [];
            
                    foreach ($evolution_subject_ids as $index => $evolution_subject_id) {
                        $subject_data = $this->EvolutionSubject->get($evolution_subject_id);
                        if ($subject_data) {
                            $minor_subjects[$subject_data['name']] = $grades[$index] ?? '';
                        }
                    }
            
                    // === Attendance & Remarks ===
                    $attendance_percent = (float) $this->ExamAttendence->get_student_attendence_percentage($class_id, $exam_id, $student['id']);
                    $remark             = $this->Remarks->get_student_remarks($class_id, $exam_id, $student['id']);
            
                    // === Subject Type IDs ===
                    $subject_type_ids = ($class_id == 8) ? [1, 2, 3, 4, 5, 6, 7] : [1, 2, 3, 4, 5, 6, 7, 8, 9, 10];
            
                    // === Initialize Variables ===
                    $subjects           = [];
                    $ut1_marks          = [];
                    $mid_marks          = [];
                    $ut2_marks          = [];
                    $final_marks        = [];
                    $annual_marks       = [];
                    $totals             = [];
        
                    $english_i_total       = null;
                    $english_ii_total       = null;
                    $english_i_present       = null;
                    $english_ii_present       = null;
                    
                    $major_subject_fails = 0;
                    $major_subject_absents = 0;
                    $grand_total         = 0;
                    $grand_total_max     = 0;
                    
                    $ut1_absent          = 0;
                    $mid_absent          = 0;
                    $ut2_absent          = 0;
                    $final_absent        = 0;
                    
                    // === Major Subjects Processing ===
                    foreach ($subject_type_ids as $id) {
                        $student_subject = $this->StudentSubject->get_where([
                            "academy_class_id"   => $class_id,
                            "student_id"         => $student['id'],
                            "subject_type_id"    => $id,
                            "current_session_id" => 1
                        ]);
            
                        if (!$student_subject) continue;
            
                        $subject_id   = $student_subject['subject_id'];
                        $subject_name = isset($subject_cache[$subject_id]) ? $subject_cache[$subject_id] : ($this->Subject->get($subject_id)['name'] ?? 'N/A');
                        $subject_cache[$subject_id] = $subject_name;
                        $subjects["s$id"] = $subject_name;
            
                        // Fetch marks
                        $ut1 = $this->Marks->get_student_marks_by_subject_type($class_id, $student['id'], 1, $id);
                        $midt = $this->Marks->get_student_marks_by_subject_type($class_id, $student['id'], 2, $id);
                        $ut2 = $this->Marks->get_student_marks_by_subject_type($class_id, $student['id'], 3, $id);
                        $finalt = $this->Marks->get_student_marks_by_subject_type($class_id, $student['id'], 4, $id);
            
                        // === HANDLE ABSENT / REPORTED ===
                        if ($ut1 === "AB") $ut1_absent++;
                        if ($midt === "AB") $mid_absent++;
                        
                        if ($ut2 === "AB") $ut2_absent++;
                        if ($finalt === "AB") $final_absent++;
                        
                        $ut1 = ($ut1 === "AB" || $ut1 === "R" || $ut1 === '') ? ($ut1 === '' ? 0 : $ut1) : $ut1;
                        $midt = ($midt === "AB" || $midt === "R" || $midt === '') ? ($midt === 0 ? '' : $midt) : $midt;
                        $ut2 = ($ut2 === "AB" || $ut2 === "R" || $ut2 === '') ? ($ut2 === '' ? 0 : $ut2) : $ut2;
                        $finalt = ($finalt === "AB" || $finalt === "R" || $finalt === '') ? ($finalt === '' ? 0 : $finalt) : $finalt;
                        
                        // === MID TERM TOTAL (UT1 + MID T) ===
                        if ($ut1 === "AB" && $midt === "AB") {
                            $mid_total = "AB";
                        } elseif ($ut1 === "R" || $midt === "R") {
                            $mid_total = "R";
                        } elseif ($ut1 === '' && $midt === '') {
                            $mid_total = '';
                        } else {
                            $mid_total = (is_numeric($ut1) ? $ut1 : 0) + (is_numeric($midt) ? $midt : 0);
                        }
                        
                        // === FINAL TERM TOTAL (UT2 + FINAL T) ===
                        if ($ut2 === "AB" && $finalt === "AB") {
                            $final_total = "AB";
                        } elseif ($ut2 === "R" || $finalt === "R") {
                            $final_total = "R";
                        } elseif ($ut2 === '' && $finalt === '') {
                            $final_total = '';
                        } else {
                            $final_total = (is_numeric($ut2) ? $ut2 : 0) + (is_numeric($finalt) ? $finalt : 0);
                        }
                        
                        // === ANNUAL CALCULATION ===
                        if ($mid_total === "AB" && $final_total === "AB") {
                            $annual_total = "AB";
                        } elseif ($mid_total === "R" || $final_total === "R") {
                            $annual_total = "R";
                        } elseif ($mid_total === '' && $final_total === '') {
                            $annual_total = '';
                        } elseif (is_numeric($mid_total) && is_numeric($final_total)) {
                            $annual_total = ceil(($mid_total + $final_total) / 2);
                        } elseif (is_numeric($mid_total) && !is_numeric($final_total)) {
                            $annual_total = $mid_total;
                        } elseif (!is_numeric($mid_total) && is_numeric($final_total)) {
                            $annual_total = $final_total;
                        } else {
                            $annual_total = '';
                        }
                        
                        $ut1_marks["s$id"]    = $ut1;
                        $mid_marks["s$id"]    = $midt;
                        $ut2_marks["s$id"]    = $ut2;
                        $final_marks["s$id"]  = $finalt;
                        
                        $totals["s$id"]       = $final_total;
                        $annual_marks["s$id"] = $annual_total;
                                    
                        // Attendance / Fails
                        if ($ut2 == "AB" && $finalt == "AB") $major_subject_absents++;
                        if (!in_array($subject_id, [40, 41]) && $annual_total < 35) $major_subject_fails++;
            
                        // English Tracking
                        if ($subject_id == 40) { $english_i_total = $annual_total; $english_i_present = true; }
                        if ($subject_id == 41) { $english_ii_total = $annual_total; $english_ii_present = true; }
            
                        $grand_total += $annual_total;
                        $grand_total_max += 100;
                    }
            
                    // // === Combine English I & II ===
                    // if ($english_i_total !== null && $english_ii_total !== null) {
                    //     $english_avg = ceil(($english_i_total + $english_ii_total) / 2);
                    //     $grand_total -= ($english_i_total + $english_ii_total);
                    //     $grand_total += $english_avg;
                    //     $grand_total_max = $grand_total_max - 200 + 100;
                    //     if ($english_avg < 35) {
                    //         $result = 'FAIL';  // Fail if English average is below 35
                    //     }
                    // }
                    
                    // === Combine English I & II ===
                    if ($english_i_total !== null && $english_ii_total !== null) {
                        $english_avg = ceil(($english_i_total + $english_ii_total) / 2);
                        $grand_total -= ($english_i_total + $english_ii_total);
                        $grand_total += $english_avg;
                        $grand_total_max = $grand_total_max - 200 + 100;
                    
                        // === ENGLISH PASS/FAIL EDGE CASE ===
                        if ($english_avg < 35) {
                            $result = 'FAIL';  // Fail if English average below 35
                        } elseif ($english_avg >= 35 && ($english_i_total < 35 || $english_ii_total < 35)) {
                            $result = 'PASS';  // Pass if average >=35 but one of English I/II <35
                        }
                    }

                    // === Special Subjects ===
                    $special_subjects         = [];
                    $special_ut1_marks        = [];
                    $special_mid_marks        = [];
                    $special_ut2_marks        = [];
                    $special_final_marks      = [];
                    $special_mid_totals       = [];
                    $special_final_totals     = [];
                    $special_annual_marks     = [];
                    $special_subject_type_ids = ($class_id == 8) ? [12, 13, 14, 15] : [12, 13, 14];
            
                    foreach ($special_subject_type_ids as $index => $id) {
                        $key = "sps" . ($index + 1);
                        $student_subject = $this->StudentSubject->get_where([
                            "academy_class_id"   => $class_id,
                            "student_id"         => $student['id'],
                            "subject_type_id"    => $id,
                            "current_session_id" => 1
                        ]);
            
                        if (!$student_subject) continue;
            
                        $subject_id = $student_subject['subject_id'];
                        $subject_name = isset($subject_cache[$subject_id]) ? $subject_cache[$subject_id] : ($this->Subject->get($subject_id)['name'] ?? 'N/A');
                        $subject_cache[$subject_id] = $subject_name;
                        $special_subjects[$key] = $subject_name;
            
                        // === FETCH MARKS ===
                        $ut1     = $this->Marks->get_student_marks_by_subject_type($class_id, $student['id'], 1, $id); // Unit Test 1
                        $midt    = $this->Marks->get_student_marks_by_subject_type($class_id, $student['id'], 2, $id); // Mid Term
                        $ut2     = $this->Marks->get_student_marks_by_subject_type($class_id, $student['id'], 3, $id); // Unit Test 2
                        $finalt  = $this->Marks->get_student_marks_by_subject_type($class_id, $student['id'], 4, $id); // Final Term
                    
                        // === HANDLE ABSENT ===
                        $ut1    = ($ut1 === "AB" || $ut1 === "R" || $ut1 === '') ? ($ut1 === '' ? 0: $ut1) : $ut1;
                        $midt   = ($midt === "AB" || $midt === "R" || $midt === '') ? ($midt === '' ? 0: $midt) : $midt;
                        $ut2    = ($ut2 === "AB" || $ut2 === "R" || $ut2 === '') ? ($ut2 === '' ? 0 : $ut2) : $ut2;
                        $finalt = ($finalt === "AB" || $finalt === "R" || $finalt === '') ? ($finalt === '' ? 0 : $finalt) : $finalt;
                    
                        // === HALF YEARLY (UT1 + MID T) ===
                        if ($ut1 === "AB" && $midt === "AB") {
                            $mid_total = "AB";
                        } elseif ($ut1 === "R" || $midt === "R") {
                            $mid_total = "R";
                        } elseif ($ut1 === '' && $midt === '') {
                            $mid_total = '';
                        } else {
                            $mid_total = (is_numeric($ut1) ? $ut1 : 0) + (is_numeric($midt) ? $midt : 0);
                        }
                    
                        // === FINAL TERM (UT2 + FINAL T) ===
                        if ($ut2 === "AB" && $finalt === "AB") {
                            $final_total = "AB";
                        } elseif ($ut2 === "R" || $finalt === "R") {
                            $final_total = "R";
                        } elseif ($ut2 === '' && $finalt === '') {
                            $final_total = '';
                        } else {
                            $final_total = (is_numeric($ut2) ? $ut2 : 0) + (is_numeric($finalt) ? $finalt : 0);
                        }
                    
                        // === ANNUAL TOTAL (Average of Half-Yearly + Final Term) ===
                        if ($mid_total === "AB" && $final_total === "AB") {
                            $annual_total = "AB";
                        } elseif ($mid_total === "R" || $final_total === "R") {
                            $annual_total = "R";
                        } elseif ($mid_total === '' && $final_total === '') {
                            $annual_total = '';
                        } elseif (is_numeric($mid_total) && is_numeric($final_total)) {
                            $annual_total = ceil(($mid_total + $final_total) / 2);
                        } elseif (is_numeric($mid_total) && !is_numeric($final_total)) {
                            $annual_total = $mid_total;
                        } elseif (!is_numeric($mid_total) && is_numeric($final_total)) {
                            $annual_total = $final_total;
                        } else {
                            $annual_total = '';
                        }
                    
                        // === STORE VALUES ===
                        $special_ut1_marks[$key]        = $ut1;
                        $special_mid_marks[$key]        = $midt;
                        $special_ut2_marks[$key]        = $ut2;
                        $special_final_marks[$key]      = $finalt;
                        $special_mid_totals[$key]       = $mid_total;
                        $special_final_totals[$key]     = $final_total;
                        $special_annual_marks[$key]     = $annual_total;
                    
                        // === GRAND TOTAL UPDATE ===
                        if (is_numeric($annual_total)) {
                            $grand_total     += $annual_total;
                            $grand_total_max += 100;
                        }
                    }
            
                    // // === Result Logic (no match, PHP7 safe) ===
                    // if ($english_avg === null || $english_avg < 35) {
                    //     $result = 'FAIL';
                    // } elseif (!$english_i_present || !$english_ii_present || $major_subject_absents > 0) {
                    //     $result = 'INC';
                    // } elseif ($major_subject_fails >= 4) {
                    //     $result = 'PCNA';
                    // } elseif ($major_subject_fails == 3) {
                    //     $result = 'FAIL';
                    // } elseif ($major_subject_fails == 1 || $major_subject_fails == 2) {
                    //     $result = 'PUC';
                    // } else {
                    //     $result = 'PASS';
                    // }
                    
                    // === Result Logic for other subjects (PUC, PCNA, FAIL) ===
                    if (!isset($result)) {
                        if (!$english_i_present || !$english_ii_present || $major_subject_absents > 0) {
                            $result = 'INC';
                        } elseif ($major_subject_fails >= 4) {
                            $result = 'PCNA';
                        } elseif ($major_subject_fails == 3) {
                            $result = 'FAIL';
                        } elseif ($major_subject_fails == 1 || $major_subject_fails == 2) {
                            $result = 'PUC';
                        } else {
                            $result = 'PASS';
                        }
                    }
            
                    $percentage = $grand_total_max > 0 ? round(($grand_total / $grand_total_max) * 100, 2) : 0;
                    // $rank_eligible = (
                    //     $result === 'PASS' &&
                    //     $english_avg >= 35 &&
                    //     !$major_subject_absents &&
                    //     !$ut1_absent_subjects &&
                    //     !$ut1_absent && !$mid_absent &&
                    //     $english_i_present && $english_ii_present
                    // );
                    
                    // === Rank Eligibility & Pass Without Rank (UT2 absent but passed) ===
                    $pass_without_rank = false;
                    if ($result === 'PASS') {
                        // Check if absent in any UT2 but passed
                        $ut2_absent_in_major_subjects = $ut2_absent; // already counted in code
                        if ($ut2_absent_in_major_subjects > 0) {
                            $pass_without_rank = true;
                        }
                    }
                    
                    $rank_eligible = (
                        $result === 'PASS' &&
                        !$pass_without_rank &&
                        $english_avg >= 35 &&
                        $major_subject_fails === 0 &&
                        !$major_subject_absents &&
                        $english_i_present && $english_ii_present
                    );

                    $mid_totals = array_combine(array_keys($ut1_marks), array_map(function($k) use($ut1_marks, $mid_marks){return ($ut1_marks[$k]+$mid_marks[$k]);}, array_keys($ut1_marks)));
            
                    // === Record ===
                    $records[$student["id"]] = [
                        "name"                     => trim("{$student['f_name']} {$student['m_name']} {$student['l_name']}"),
                        "roll_no"                  => $student["roll_no"],
                        "student_no"               => $student["student_no"],
                        "student_id"               => $student["id"],
                        "student_dob"              => $student["dob"],
                        "attendence"               => round($attendance_percent, 2) ?: '',
                        "remark"                   => $remark,
                        
                        "subject_type_ids"         => $subject_type_ids,
                        "special_subject_type_ids" => $special_subject_type_ids,
        
                        "minor_subjects"           => $minor_subjects,
                        "attendence"               => $attendence,
                        "remark"                   => $remark,
    
                        "subjects"                 => $subjects,
                        "ut1_marks"                => $ut1_marks,
                        "mid_marks"                => $mid_marks,
                        "mid_totals"               => $mid_totals,
                        "ut2_marks"                => $ut2_marks,
                        "final_marks"              => $final_marks,
                        "final_totals"             => $totals, // (UT2 + FINAL T)
                        "annual_marks"             => $annual_marks, // (((UT1 + MID T) + (UT2 + FINAL T)) / 2)
                        
                        "special_subjects"        => $special_subjects,
                        "special_ut1_marks"       => $special_ut1_marks,
                        "special_mid_marks"       => $special_mid_marks,
                        "special_mid_totals"      => $special_mid_totals,
                        "special_ut2_marks"       => $special_ut2_marks,
                        "special_final_marks"     => $special_final_marks,
                        "special_final_totals"    => $special_final_totals, // (UT2 + FINAL T)
                        "special_annual_marks"    => $special_annual_marks, // (((UT1 + MID T) + (UT2 + FINAL T)) / 2)
    
                        "grand_total"              => $grand_total,
                        "percentage"               => $percentage,
                        "result"                   => $result,
                        "rank_eligible"            => $rank_eligible,
                        "ut1_absent"               => $ut1_absent,
                        "mid_absent"               => $mid_absent,
                        "ut2_absent"               => $ut2_absent,
                        "final_absent"             => $final_absent,
                        
                        "english_i_total"          => $english_i_total,
                        "english_ii_total"         => $english_ii_total,
                        "english_avg"              => $english_avg
                    ];
                }
            
                // === Rank Distribution ===
                $ranked = array_filter($records, function($r) { return $r['rank_eligible']; });
                usort($ranked, function($a, $b) { return $b['grand_total'] <=> $a['grand_total']; });
                $rank = 1;

                foreach ($ranked as $record) {
                    $records[$record['student_id']]['rank'] = $rank++;
                }
            
                // === Store or Output ===
                if (isset($store) && $store === "yes") {
                    $this->store_result($report_for === "individual" ? [$records[$student_id]] : $records);
                    echo json_encode(["status" => "success", "message" => "Result stored successfully."]);
                    return;
                }
            
                if ($request_from === "sfsjorethang") {
                    if ($user_found && $password_match) {
                        $html_output = $this->load->view(
                            "academics/result/final_term/class_v_viii",
                            [
                                "students"       => [$records[$user_id]],
                                "class_detail"   => $class_detail,
                                "section_detail" => $section_detail,
                                "header"         => "yes"
                            ],
                            TRUE
                        );
                        $this->output->set_content_type('application/json')
                                     ->set_output(json_encode(['status' => 'success', 'html' => $html_output]));
                    } else {
                        $this->output->set_content_type('application/json')
                                     ->set_output(json_encode(['status' => 'error', 'message' => 'Invalid credentials']));
                    }
                } else {
                    
                    $this->load->view("academics/" . $this->input->post('result_type') . "/final_term/class_v_viii", [
                        "students"       => $report_for === "individual" ? [$records[$student_id]] : $records,
                        "class_detail"   => $class_detail,
                        "section_detail" => $section_detail,
                        "header"         => $header
                    ]);
                }
            }

            // Class IX to X
            else if (in_array($class_id, [12, 13]) && $exam_id == 4) {
            
                $students = $this->Student->get_where([
                    "class_id"                   => $class_id,
                    "section_id"                 => $section_id,
                    "student_session.promoted"   => "ANY",
                    "student_session.session_id" => 1,
                ]);
            
                $records       = [];
                $subject_cache = [];
            
                foreach ($students as $student) {
            
                    /* ---------- MINOR / EVOLUTION SUBJECTS ---------- */
                    $minor_subjects = [];
                    $evolution_paper = $this->EvolutionPaper->get_where([
                        "class_id" => $class_id,
                        "exam_id"  => 2
                    ]);
                    if (!empty($evolution_paper['subjects'])) {
                        $evolution_subject_ids = explode(",", $evolution_paper['subjects']);
                        $student_evolution     = $this->Marks->get_student_evolution($class_id, 2, $student['id']);
                        $grades                = explode(",", $student_evolution);
                        foreach ($evolution_subject_ids as $i => $sid) {
                            $s = $this->EvolutionSubject->get($sid);
                            if ($s) $minor_subjects[$s['name']] = isset($grades[$i]) ? $grades[$i] : '';
                        }
                    }
            
                    /* ---------- Attendance / Remarks ---------- */
                    $attendence = $this->ExamAttendence->get_student_attendence_percentage($class_id, $exam_id, $student['id']);
                    $remark     = $this->Remarks->get_student_remarks($class_id, $exam_id, $student['id']);
            
                    /* ---------- Initialization ---------- */
                    $subject_type_ids = [1, 2, 3, 4, 5, 6, 7, 8, 9];

                    // === Initialize Variables ===
                    $subjects           = [];
                    $ut1_marks          = [];
                    $mid_marks          = [];
                    $ut2_marks          = [];
                    $final_marks        = [];
                    $annual_marks       = [];
                    $mid_totals         = [];
                    $totals             = [];
        
                    $english_i_total    = null;
                    $english_ii_total   = null;
                    $english_avg        = null;
                    $physics_total      = null;
                    $chemistry_total    = null;
                    $biology_total      = null;
                    $history_total      = null;
                    $geography_total    = null;
                    
                    $english_i_present  = null;
                    $english_ii_present = null;
                    
                    $major_subject_fails = 0;
                    $major_subject_absents = 0;
                    $grand_total         = 0;
                    $grand_total_max     = 0;
                    
                    $ut1_absent          = 0;
                    $mid_absent          = 0;
                    $ut2_absent          = 0;
                    $final_absent        = 0;
            
                    $major_subject_fails = $major_subject_absents = $ut1_absent_subjects = 0;
                    $ut1_absent = $mid_absent = 0;
                    $grand_total = $grand_total_max = 0;
            
                    /* ---------- MAJOR SUBJECTS LOOP ---------- */
                    foreach ($subject_type_ids as $id) {
            
                        $student_subject = $this->StudentSubject->get_where([
                            "academy_class_id"   => $class_id,
                            "student_id"         => $student['id'],
                            "subject_type_id"    => $id,
                            "current_session_id" => 1
                        ]);
                        if (!$student_subject) continue;
            
                        $subject_id   = $student_subject['subject_id'];
                        if (!isset($subject_cache[$subject_id])) {
                            $subject_cache[$subject_id] = $this->Subject->get($subject_id)['name'] ?? 'N/A';
                        }
                        $subject_name = $subject_cache[$subject_id];
                        $subjects["s$id"] = $subject_name;
            
                        $ut1    = $this->Marks->get_student_marks_by_subject_type($class_id, $student['id'], 1, $id);
                        $mid    = $this->Marks->get_student_marks_by_subject_type($class_id, $student['id'], 2, $id);
                        $ut2    = $this->Marks->get_student_marks_by_subject_type($class_id, $student['id'], 3, $id);
                        $finalt = $this->Marks->get_student_marks_by_subject_type($class_id, $student['id'], 4, $id);
            
                        // Handle absent or reported
                        $ut1    = ($ut1 === "AB" || $ut1 === "R" || $ut1 === '') ? ($ut1 === '' ? '' : $ut1) : (float)$ut1;
                        $mid    = ($mid === "AB" || $mid === "R" || $mid === '') ? ($mid === '' ? '' : $mid) : (float)$mid;
                        $ut2    = ($ut2 === "AB" || $ut2 === "R" || $ut2 === '') ? ($ut2 === '' ? '' : $ut2) : (float)$ut2;
                        $finalt = ($finalt === "AB" || $finalt === "R" || $finalt === '') ? ($finalt === '' ? '' : $finalt) : (float)$finalt;
            
                        // Count absents
                        if ($ut1 === "AB") $ut1_absent++;
                        if ($mid === "AB") $mid_absent++;
                        if ($ut2 === "AB") $ut2_absent++;
                        if ($finalt === "AB") $final_absent++;
            
                        // === MID TERM TOTAL (UT1 + MID T) ===
                        if ($ut1 === "AB" && $mid === "AB") {
                            $mid_total = "AB";
                        } elseif ($ut1 === "R" || $mid === "R") {
                            $mid_total = "R";
                        } elseif ($ut1 === '' && $mid === '') {
                            $mid_total = '';
                        } else {
                            $mid_total = (is_numeric($ut1) ? $ut1 : 0) + (is_numeric($mid) ? $mid : 0);
                        }
        
                        // === FINAL TERM TOTAL (UT2 + FINAL T) ===
                        if ($ut2 === "AB" && $finalt === "AB") {
                            $final_total = "AB";
                        } elseif ($ut2 === "R" || $finalt === "R") {
                            $final_total = "R";
                        } elseif ($ut2 === '' && $finalt === '') {
                            $final_total = '';
                        } else {
                            $final_total = (is_numeric($ut2) ? $ut2 : 0) + (is_numeric($finalt) ? $finalt : 0);
                        }
        
                        // === ANNUAL CALCULATION ===
                        if ($mid_total === "AB" && $final_total === "AB") {
                            $annual_total = "AB";
                        } elseif ($mid_total === "R" || $final_total === "R") {
                            $annual_total = "R";
                        } elseif ($mid_total === '' && $final_total === '') {
                            $annual_total = '';
                        } elseif (is_numeric($mid_total) && is_numeric($final_total)) {
                            $annual_total = ceil(($mid_total + $final_total) / 2);
                        } elseif (is_numeric($mid_total) && !is_numeric($final_total)) {
                            $annual_total = $mid_total;
                        } elseif (!is_numeric($mid_total) && is_numeric($final_total)) {
                            $annual_total = $final_total;
                        } else {
                            $annual_total = '';
                        }
            
                        // Store marks
                        $ut1_marks["s$id"] = $ut1;
                        $mid_marks["s$id"] = $mid;
                        $ut2_marks["s$id"] = $ut2;
                        $final_marks["s$id"] = $finalt;
                        $mid_totals["s$id"] = $mid_total;
                        $totals["s$id"] = $final_total;
                        $annual_marks["s$id"] = $annual_total;
            
                        // Fail logic (excluding English, Science, Social)
                        if (!in_array($subject_id, [40,41,50,51,52,53,54]) && is_numeric($annual_total) && $annual_total < 33) {
                            $major_subject_fails++;
                        }
            
                        // English
                        if ($subject_id == 40) {
                            $english_i_total = $annual_total;
                            $english_i_present = is_numeric($ut1) || is_numeric($mid);
                        }
                        if ($subject_id == 41) {
                            $english_ii_total = $annual_total;
                            $english_ii_present = is_numeric($ut1) || is_numeric($mid);
                        }
            
                        // Science
                        if ($subject_id == 50) $physics_total = $annual_total;
                        if ($subject_id == 51) $chemistry_total = $annual_total;
                        if ($subject_id == 52) $biology_total = $annual_total;
            
                        // Social
                        if ($subject_id == 53) $history_total = $annual_total;
                        if ($subject_id == 54) $geography_total = $annual_total;
            
                        // Grand total
                        if (is_numeric($annual_total)) $grand_total += $annual_total;
                        $grand_total_max += 100;
                    }

            
                    /* ---------- Merge English (I + II) ---------- */
                    if ($english_i_total !== null && $english_ii_total !== null) {
                        if (is_numeric($english_i_total) && is_numeric($english_ii_total)) {
                            $english_avg = ceil(($english_i_total + $english_ii_total)/2);
                        } else {
                            $english_avg = $english_i_total === "AB" || $english_ii_total === "AB" ? "AB" : "R";
                        }
                        $grand_total = $grand_total - ($english_i_total ?? 0) - ($english_ii_total ?? 0) + (is_numeric($english_avg) ? $english_avg : 0);
                        $grand_total_max = $grand_total_max - 200 + 100;
                        if (is_numeric($english_avg) && $english_avg < 33) $major_subject_fails++;
                    }
            
                    /* ---------- Merge Science ---------- */
                    if ($physics_total !== null && $chemistry_total !== null && $biology_total !== null) {
                        if (is_numeric($physics_total) && is_numeric($chemistry_total) && is_numeric($biology_total)) {
                            $science_avg = ceil(($physics_total + $chemistry_total + $biology_total)/3);
                        } else {
                            $science_avg = "R";
                        }
                        $grand_total = $grand_total - ($physics_total ?? 0) - ($chemistry_total ?? 0) - ($biology_total ?? 0) + (is_numeric($science_avg) ? $science_avg : 0);
                        $grand_total_max = $grand_total_max - 300 + 100;
                        if (is_numeric($science_avg) && $science_avg < 33) $major_subject_fails++;
                    }
            
                    /* ---------- Merge Social ---------- */
                    if ($history_total !== null && $geography_total !== null) {
                        if (is_numeric($history_total) && is_numeric($geography_total)) {
                            $social_avg = ceil(($history_total + $geography_total)/2);
                        } else {
                            $social_avg = "R";
                        }
                        $grand_total = $grand_total - ($history_total ?? 0) - ($geography_total ?? 0) + (is_numeric($social_avg) ? $social_avg : 0);
                        $grand_total_max = $grand_total_max - 200 + 100;
                        if (is_numeric($social_avg) && $social_avg < 33) $major_subject_fails++;
                    }
            
                    /* ---------- Group 3 Subjects ---------- */
                    $group_3_subject_type_ids = [11];
                    $group_3_subjects = $group_3_ut1_marks = $group_3_mid_marks = $group_3_ut2_marks = $group_3_final_marks = [];
                    $group_3_mid_totals = $group_3_totals = $group_3_annual_marks = [];

                    
                    foreach ($group_3_subject_type_ids as $i => $id) {
                        $key = "g3s" . ($i + 1);
                        $student_subject = $this->StudentSubject->get_where([
                            "academy_class_id"   => $class_id,
                            "student_id"         => $student['id'],
                            "subject_type_id"    => $id,
                            "current_session_id" => 1
                        ]);
                        if (!$student_subject) continue;
            
                        $subject_id = $student_subject['subject_id'];
                        if (!isset($subject_cache[$subject_id])) {
                            $subject_cache[$subject_id] = $this->Subject->get($subject_id)['name'] ?? 'N/A';
                        }
                        $subject_name = $subject_cache[$subject_id];
                        $group_3_subjects[$key] = $subject_name;
            
                        $ut1    = $this->Marks->get_student_marks_by_subject_type($class_id, $student['id'], 1, $id);
                        $mid    = $this->Marks->get_student_marks_by_subject_type($class_id, $student['id'], 2, $id);
                        $ut2    = $this->Marks->get_student_marks_by_subject_type($class_id, $student['id'], 3, $id);
                        $finalt = $this->Marks->get_student_marks_by_subject_type($class_id, $student['id'], 4, $id);
            
                        $ut1    = ($ut1 === "AB" || $ut1 === "R" || $ut1 === '') ? ($ut1 === '' ? '' : $ut1) : (float)$ut1;
                        $mid    = ($mid === "AB" || $mid === "R" || $mid === '') ? ($mid === '' ? '' : $mid) : (float)$mid;
                        $ut2    = ($ut2 === "AB" || $ut2 === "R" || $ut2 === '') ? ($ut2 === '' ? '' : $ut2) : (float)$ut2;
                        $finalt = ($finalt === "AB" || $finalt === "R" || $finalt === '') ? ($finalt === '' ? '' : $finalt) : (float)$finalt;
            
                        // === MID TERM TOTAL (UT1 + MID T) ===
                        if ($ut1 === "AB" && $mid === "AB") {
                            $mid_total = "AB";
                        } elseif ($ut1 === "R" || $mid === "R") {
                            $mid_total = "R";
                        } elseif ($ut1 === '' && $mid === '') {
                            $mid_total = '';
                        } else {
                            $mid_total = (is_numeric($ut1) ? $ut1 : 0) + (is_numeric($mid) ? $mid : 0);
                        }
        
                        // === FINAL TERM TOTAL (UT2 + FINAL T) ===
                        if ($ut2 === "AB" && $finalt === "AB") {
                            $final_total = "AB";
                        } elseif ($ut2 === "R" || $finalt === "R") {
                            $final_total = "R";
                        } elseif ($ut2 === '' && $finalt === '') {
                            $final_total = '';
                        } else {
                            $final_total = (is_numeric($ut2) ? $ut2 : 0) + (is_numeric($finalt) ? $finalt : 0);
                        }
        
                        // === ANNUAL CALCULATION ===
                        if ($mid_total === "AB" && $final_total === "AB") {
                            $annual_total = "AB";
                        } elseif ($mid_total === "R" || $final_total === "R") {
                            $annual_total = "R";
                        } elseif ($mid_total === '' && $final_total === '') {
                            $annual_total = '';
                        } elseif (is_numeric($mid_total) && is_numeric($final_total)) {
                            $annual_total = ceil(($mid_total + $final_total) / 2);
                        } elseif (is_numeric($mid_total) && !is_numeric($final_total)) {
                            $annual_total = $mid_total;
                        } elseif (!is_numeric($mid_total) && is_numeric($final_total)) {
                            $annual_total = $final_total;
                        } else {
                            $annual_total = '';
                        }
            
                        $group_3_ut1_marks[$key] = $ut1;
                        $group_3_mid_marks[$key] = $mid;
                        $group_3_ut2_marks[$key] = $ut2;
                        $group_3_final_marks[$key] = $finalt;
                        $group_3_mid_totals[$key] = $mid_total;
                        $group_3_totals[$key] = $final_total;
                        $group_3_annual_marks[$key] = $annual_total;
            
                        if (is_numeric($annual_total)) {
                            $grand_total += $annual_total;
                            $grand_total_max += 100;
                            if ($annual_total < 33) $major_subject_fails++;
                        }
                    }

            
                    /* ---------- Special Subjects ---------- */
                    $special_subject_type_ids = [12,13];
                    $special_subjects = $special_ut1_marks = $special_mid_marks = $special_ut2_marks = $special_final_marks = [];
                    $special_mid_totals = $special_final_totals = $special_annual_marks = [];
            
                    foreach ($special_subject_type_ids as $i => $id) {
                        $key = "sps" . ($i + 1);
                        $student_subject = $this->StudentSubject->get_where([
                            "academy_class_id"   => $class_id,
                            "student_id"         => $student['id'],
                            "subject_type_id"    => $id,
                            "current_session_id" => 1
                        ]);
                        if (!$student_subject) continue;
            
                        $subject_id = $student_subject['subject_id'];
                        if (!isset($subject_cache[$subject_id])) {
                            $subject_cache[$subject_id] = $this->Subject->get($subject_id)['name'] ?? 'N/A';
                        }
                        $subject_name = $subject_cache[$subject_id];
                        $special_subjects[$key] = $subject_name;
            
                        $ut1    = $this->Marks->get_student_marks_by_subject_type($class_id, $student['id'], 1, $id);
                        $mid    = $this->Marks->get_student_marks_by_subject_type($class_id, $student['id'], 2, $id);
                        $ut2    = $this->Marks->get_student_marks_by_subject_type($class_id, $student['id'], 3, $id);
                        $finalt = $this->Marks->get_student_marks_by_subject_type($class_id, $student['id'], 4, $id);
            
                        $ut1    = ($ut1 === "AB" || $ut1 === "R" || $ut1 === '') ? ($ut1 === '' ? '' : $ut1) : (float)$ut1;
                        $mid    = ($mid === "AB" || $mid === "R" || $mid === '') ? ($mid === '' ? '' : $mid) : (float)$mid;
                        $ut2    = ($ut2 === "AB" || $ut2 === "R" || $ut2 === '') ? ($ut2 === '' ? '' : $ut2) : (float)$ut2;
                        $finalt = ($finalt === "AB" || $finalt === "R" || $finalt === '') ? ($finalt === '' ? '' : $finalt) : (float)$finalt;
            
                        // === MID TERM TOTAL (UT1 + MID T) ===
                        if ($ut1 === "AB" && $mid === "AB") {
                            $mid_total = "AB";
                        } elseif ($ut1 === "R" || $mid === "R") {
                            $mid_total = "R";
                        } elseif ($ut1 === '' && $mid === '') {
                            $mid_total = '';
                        } else {
                            $mid_total = (is_numeric($ut1) ? $ut1 : 0) + (is_numeric($mid) ? $mid : 0);
                        }
        
                        // === FINAL TERM TOTAL (UT2 + FINAL T) ===
                        if ($ut2 === "AB" && $finalt === "AB") {
                            $final_total = "AB";
                        } elseif ($ut2 === "R" || $finalt === "R") {
                            $final_total = "R";
                        } elseif ($ut2 === '' && $finalt === '') {
                            $final_total = '';
                        } else {
                            $final_total = (is_numeric($ut2) ? $ut2 : 0) + (is_numeric($finalt) ? $finalt : 0);
                        }
        
                        // === ANNUAL CALCULATION ===
                        if ($mid_total === "AB" && $final_total === "AB") {
                            $annual_total = "AB";
                        } elseif ($mid_total === "R" || $final_total === "R") {
                            $annual_total = "R";
                        } elseif ($mid_total === '' && $final_total === '') {
                            $annual_total = '';
                        } elseif (is_numeric($mid_total) && is_numeric($final_total)) {
                            $annual_total = ceil(($mid_total + $final_total) / 2);
                        } elseif (is_numeric($mid_total) && !is_numeric($final_total)) {
                            $annual_total = $mid_total;
                        } elseif (!is_numeric($mid_total) && is_numeric($final_total)) {
                            $annual_total = $final_total;
                        } else {
                            $annual_total = '';
                        }
            
                        $special_ut1_marks[$key] = $ut1;
                        $special_mid_marks[$key] = $mid;
                        $special_ut2_marks[$key] = $ut2;
                        $special_final_marks[$key] = $finalt;
                        $special_mid_totals[$key] = $mid_total;
                        $special_final_totals[$key] = $final_total;
                        $special_annual_marks[$key] = $annual_total;
                    }

                    $percentage = $grand_total_max > 0 ? round(($grand_total / $grand_total_max) * 100, 2) : 0;
                    $attendance_percent = is_numeric($attendence) ? round($attendence, 2) : '';
                    
                    /* ---------- Result Logic (Modified) ---------- */

                    // Track major subject absences in UT2 and FINAL for INC and Rank
                    $major_subject_absent_ut2_ft = 0;
                    
                    foreach ($subject_type_ids as $id) {
                        $ut2 = $ut2_marks["s$id"] ?? '';
                        $finalt = $final_marks["s$id"] ?? '';
                    
                        if (($ut2 === "AB" || $finalt === "AB") && !in_array($id, [12, 13])) { 
                            // Exclude special subjects
                            $major_subject_absent_ut2_ft++;
                        }
                    }
                    
                    // English presence considering both UT2 and FINAL
                    $english_i_present = isset($ut2_marks['s1']) && is_numeric($ut2_marks['s1']) || is_numeric($final_marks['s1']);
                    $english_ii_present = isset($ut2_marks['s2']) && is_numeric($ut2_marks['s2']) || is_numeric($final_marks['s2']);
                    
                    // Determine result based on policies
                    if (is_numeric($english_avg) && $english_avg < 33) {
                        $result = 'FAIL';
                    } elseif ($major_subject_absent_ut2_ft > 0 || !$english_i_present || !$english_ii_present) {
                        $result = 'INC';
                    } elseif ($major_subject_fails >= 4) {
                        $result = 'PCNA';
                    } elseif ($major_subject_fails == 3) {
                        $result = 'FAIL';
                    } elseif ($major_subject_fails >= 1 && $major_subject_fails <= 2) {
                        $result = 'PUC';
                    } else {
                        $result = 'PASS';
                    }
                    
                    // Rank eligibility (only students who appeared for all major subjects in UT2 + FINAL and passed)
                    $rank_eligible = (
                        $result === 'PASS' &&
                        is_numeric($english_avg) && $english_avg >= 33 &&
                        $major_subject_absent_ut2_ft == 0
                    );
            
                    /* ---------- Store Record ---------- */
                    $records[$student["id"]] = [
                        "name"             => trim("{$student['f_name']} {$student['m_name']} {$student['l_name']}"),
                        "roll_no"          => $student["roll_no"],
                        "student_no"       => $student["student_no"],
                        "student_id"       => $student["id"],
                        "student_dob"      => $student["dob"],
                        "attendence"       => $attendance_percent,
                        "remark"           => $remark,
            
                        "subject_type_ids" => $subject_type_ids,
                        "special_subject_type_ids" => $special_subject_type_ids,
                        "group_3_subject_type_ids"  => $group_3_subject_type_ids,
                        "minor_subjects"   => $minor_subjects,
                        
                        "subjects"                 => $subjects,
                        "ut1_marks"                => $ut1_marks,
                        "mid_marks"                => $mid_marks,
                        "mid_totals"               => $mid_totals,
                        "ut2_marks"                => $ut2_marks,
                        "final_marks"              => $final_marks,
                        "final_totals"             => $totals, // (UT2 + FINAL T)
                        "annual_marks"             => $annual_marks, // (((UT1 + MID T) + (UT2 + FINAL T)) / 2)
                        
                        "group_3_subjects"        => $group_3_subjects,
                        "group_3_ut1_marks"       => $group_3_ut1_marks,
                        "group_3_mid_marks"       => $group_3_mid_marks,
                        "group_3_mid_totals"      => $group_3_mid_totals,
                        "group_3_ut2_marks"       => $group_3_ut2_marks,
                        "group_3_final_marks"     => $group_3_final_marks,
                        "group_3_final_totals"    => $group_3_totals, // (UT2 + FINAL T)
                        "group_3_annual_marks"    => $group_3_annual_marks, // (((UT1 + MID T) + (UT2 + FINAL T)) / 2)
            
                        "special_subjects"        => $special_subjects,
                        "special_ut1_marks"       => $special_ut1_marks,
                        "special_mid_marks"       => $special_mid_marks,
                        "special_mid_totals"      => $special_mid_totals,
                        "special_ut2_marks"       => $special_ut2_marks,
                        "special_final_marks"     => $special_final_marks,
                        "special_final_totals"    => $special_final_totals, // (UT2 + FINAL T)
                        "special_annual_marks"    => $special_annual_marks, // (((UT1 + MID T) + (UT2 + FINAL T)) / 2)
            
                        "grand_total"     => $grand_total,
                        "grand_total_max" => $grand_total_max,
                        "percentage"      => $percentage,
                        "result"          => $result,
                        "rank_eligible"   => $rank_eligible,
            
                        "english_i_total" => $english_i_total,
                        "english_ii_total" => $english_ii_total,
                        "english_avg" => $english_avg,
            
                        "physics_total" => $physics_total,
                        "chemistry_total" => $chemistry_total,
                        "biology_total" => $biology_total,
                        "science_avg" => $science_avg,
            
                        "history_total" => $history_total,
                        "geography_total" => $geography_total,
                        "social_avg" => $social_avg
                    ];
                }
            
                /* ---------- Rank Distribution ---------- */
                $eligible = [];
                foreach ($records as $r) {
                    if ($r['rank_eligible']) $eligible[] = $r;
                }
                usort($eligible, function ($a, $b) { return $b['grand_total'] - $a['grand_total']; });
                $rank = 1;
                foreach ($eligible as $r) {
                    $records[$r['student_id']]['rank'] = $rank++;
                }
            
                /* ---------- Store or Display ---------- */
                if (isset($store) && $store == "yes") {
                    $this->store_result($report_for == "individual" ? [$records[$student_id]] : $records);
                    echo json_encode(["status" => "success", "message" => "Result stored successfully."]);
                    return;
                }
            
                if ($request_from == "sfsjorethang") {
                    if ($user_found && $password_match) {
                        $html_output = $this->load->view(
                            "academics/result/final_term/class_ix_x",
                            [
                                "students"       => [$records[$user_id]],
                                "class_detail"   => $class_detail,
                                "section_detail" => $section_detail,
                                "header"         => "yes"
                            ],
                            TRUE
                        );
                        $this->output->set_content_type('application/json')
                                     ->set_output(json_encode(['status' => 'success', 'html' => $html_output]));
                    } else {
                        $this->output->set_content_type('application/json')
                                     ->set_output(json_encode(['status' => 'error', 'message' => 'Invalid credentials']));
                    }
                } else {
                    
                    // echo "<pre>";
                    // print_r($records);
                    // echo "</pre>";
                    // exit();
                    
                    $this->load->view(
                        "academics/" . $this->input->post('result_type') . "/final_term/class_ix_x",
                        [
                            "students"       => $report_for == "individual" ? [$records[$student_id]] : $records,
                            "class_detail"   => $class_detail,
                            "section_detail" => $section_detail,
                            "header"         => $header
                        ]
                    );
                }
            }

            // CLASS XI TO XII
            else if (in_array($class_id, [14, 15]) && $exam_id == 4) 
            {
                $students = $this->Student->get_where(array(
                    "class_id"                 => $class_id,
                    "section_id"               => $section_id,
                    "student_session.promoted" => "ANY",
                    "student_session.session_id" => 1,
                ));
            
                $records = array();
            
                foreach ($students as $student) {
            
                    // === EVOLUTION SUBJECTS ===
                    $evolution_paper = $this->EvolutionPaper->get_where(array("class_id" => $class_id, "exam_id" => 2));
                    $evolution_subjects = !empty($evolution_paper['subjects']) ? explode(",", $evolution_paper['subjects']) : array();
                    $student_evolution  = $this->Marks->get_student_evolution($class_id, 2, $student['id']);
                    $grades = !empty($student_evolution) ? explode(",", $student_evolution) : array();
            
                    $minor_subjects = array();
                    foreach ($evolution_subjects as $i => $subj_id) {
                        $subj_data = $this->EvolutionSubject->get($subj_id);
                        if (!empty($subj_data['name']) && isset($grades[$i])) {
                            $minor_subjects[$subj_data['name']] = $grades[$i];
                        }
                    }
            
                    // === ATTENDANCE AND REMARK ===
                    $attendence = $this->ExamAttendence->get_student_attendence_percentage($class_id, $exam_id, $student['id']);
                    $remark     = $this->Remarks->get_student_remarks($class_id, $exam_id, $student['id']);
            
                    $subject_type_ids = array(1, 2, 3, 4, 5, 6, 7);
            
                    $subjects = array();
                    $unit_test_marks = array();
                    $mid_term_marks = array();
                    $totals = array();
                    $grades_per_subject = array();
            
                    $english_i_total = null;
                    $english_ii_total = null;
                    $english_i_present = false;
                    $english_ii_present = false;
            
                    $major_subject_fails = 0;
                    $major_subject_absents = 0;
                    $ut1_absent_subjects = 0;
                    $grand_total = 0;
                    $grand_total_max = 0;
            
                    $ut1_absent = 0;
                    $mid_absent = 0;
            
                    // === MAIN SUBJECT LOOP ===
                    foreach ($subject_type_ids as $id) {
                        $student_subject = $this->StudentSubject->get_where(array(
                            "academy_class_id"   => $class_id,
                            "student_id"         => $student['id'],
                            "subject_type_id"    => $id,
                            "current_session_id" => 1
                        ));
            
                        $subject_id = isset($student_subject['subject_id']) ? $student_subject['subject_id'] : null;
                        $subject_name = $subject_id ? ($this->Subject->get($subject_id)['name'] ?? 'N/A') : 'N/A';
                        $subjects["s$id"] = $subject_name;
            
                        $ut1 = $this->Marks->get_student_marks_by_subject_type($class_id, $student['id'], 1, $id);
                        $mid = $this->Marks->get_student_marks_by_subject_type($class_id, $student['id'], 2, $id);
            
                        if ($ut1 === "AB") $ut1_absent++;
                        if ($mid === "AB") $mid_absent++;
            
                        $ut1 = is_numeric($ut1) ? $ut1 : '';
                        $mid = is_numeric($mid) ? $mid : '';
            
                        $total = (is_numeric($ut1) ? $ut1 : 0) + (is_numeric($mid) ? $mid : 0);
            
                        $unit_test_marks["s$id"] = $ut1;
                        $mid_term_marks["s$id"] = $mid;
                        $totals["s$id"] = $total;
            
                        // Grade Mapping
                        $grades_per_subject["s$id"] = $total >= 91 ? 1 :
                                                      ($total >= 81 ? 2 :
                                                      ($total >= 71 ? 3 :
                                                      ($total >= 61 ? 4 :
                                                      ($total >= 51 ? 5 :
                                                      ($total >= 41 ? 6 :
                                                      ($total >= 35 ? 7 :
                                                      ($total >= 25 ? 8 : 9)))))));
            
                        if ($ut1 === '' && $mid === '') $major_subject_absents++;
                        if ($ut1 === '') $ut1_absent_subjects++;
            
                        // Fail check (excluding English I & II)
                        if ($subject_id != 40 && $subject_id != 41 && $total < 35) {
                            $major_subject_fails++;
                        }
            
                        // Grand Total
                        $grand_total += $total;
                        $grand_total_max += 100;
            
                        // English I & II
                        if ($subject_id == 40) {
                            $english_i_total = $total;
                            if ($ut1 !== '' || $mid !== '') $english_i_present = true;
                        }
                        if ($subject_id == 41) {
                            $english_ii_total = $total;
                            if ($ut1 !== '' || $mid !== '') $english_ii_present = true;
                        }
                    }
            
                    // === COMBINE ENGLISH I & II ===
                    if ($english_i_total !== null && $english_ii_total !== null) {
                        $english_combined_total = ceil(($english_i_total + $english_ii_total) / 2);
            
                        $grand_total -= ($english_i_total + $english_ii_total);
                        $grand_total += $english_combined_total;
            
                        $grand_total_max -= 200;
                        $grand_total_max += 100;
            
                        if ($english_combined_total < 35) $major_subject_fails++;
                    }
            
                    // === SPECIAL SUBJECTS ===
                    $special_subject_type_ids = array(12, 13);
                    $special_subjects = array();
                    $special_unit_test_marks = array();
                    $special_mid_term_marks = array();
                    $special_totals = array();
            
                    foreach ($special_subject_type_ids as $index => $id) {
                        $key = "sps" . ($index + 1);
                        $student_subject = $this->StudentSubject->get_where(array(
                            "academy_class_id"   => $class_id,
                            "student_id"         => $student['id'],
                            "subject_type_id"    => $id,
                            "current_session_id" => 1
                        ));
            
                        $subject_id = isset($student_subject['subject_id']) ? $student_subject['subject_id'] : null;
                        $subject_name = $subject_id ? ($this->Subject->get($subject_id)['name'] ?? 'N/A') : 'N/A';
            
                        $special_subjects[$key] = $subject_name;
            
                        $ut1 = $this->Marks->get_student_marks_by_subject_type($class_id, $student['id'], 1, $id);
                        $mid = $this->Marks->get_student_marks_by_subject_type($class_id, $student['id'], 2, $id);
                        $ut1 = is_numeric($ut1) ? $ut1 : 0;
                        $mid = is_numeric($mid) ? $mid : 0;
            
                        $total = $ut1 + $mid;
            
                        $special_unit_test_marks[$key] = $ut1;
                        $special_mid_term_marks[$key] = $mid;
                        $special_totals[$key] = $total;
                    }
            
                    // === RESULT EVALUATION ===
                    $english_avg = ($english_i_total !== null && $english_ii_total !== null)
                        ? ceil(($english_i_total + $english_ii_total) / 2)
                        : null;
            
                    $result = 'PASS';
                    if ($english_avg === null || $english_avg == 0 || $english_avg < 35) {
                        $result = 'FAIL';
                    } elseif (!$english_i_present || !$english_ii_present || $major_subject_absents > 0) {
                        $result = 'INC';
                    } elseif ($major_subject_fails >= 4) {
                        $result = 'PCNA';
                    } elseif ($major_subject_fails == 3) {
                        $result = 'FAIL';
                    } elseif ($major_subject_fails == 1 || $major_subject_fails == 2) {
                        $result = 'PUC';
                    }
            
                    $percentage = $grand_total_max > 0 ? round(($grand_total / $grand_total_max) * 100, 2) : 0;
                    $attendance_percent = is_numeric($attendence) ? round($attendence, 2) : '';
            
                    $rank_eligible = (
                        $result === 'PASS' &&
                        $english_avg >= 35 &&
                        $major_subject_absents === 0 &&
                        $ut1_absent_subjects === 0 &&
                        $ut1_absent == 0 &&
                        $mid_absent == 0 &&
                        $english_i_present && $english_ii_present
                    );
            
                    $records[$student["id"]] = array(
                        "name"                    => trim($student["f_name"] . " " . $student["m_name"] . " " . $student["l_name"]),
                        "roll_no"                 => $student["roll_no"],
                        "student_no"              => $student["student_no"],
                        "student_dob"             => $student["dob"],
                        "student_id"              => $student["id"],
                        "subject_type_ids"        => $subject_type_ids,
                        "special_subject_type_ids"=> $special_subject_type_ids,
                        "minor_subjects"          => $minor_subjects,
                        "attendence"              => $attendance_percent,
                        "remark"                  => $remark,
                        "unit_test_marks"         => $unit_test_marks,
                        "mid_term_marks"          => $mid_term_marks,
                        "totals"                  => $totals,
                        "subjects"                => $subjects,
                        "grades"                  => $grades_per_subject,
                        "special_unit_test_marks" => $special_unit_test_marks,
                        "special_mid_term_marks"  => $special_mid_term_marks,
                        "special_totals"          => $special_totals,
                        "special_subjects"        => $special_subjects,
                        "grand_total"             => $grand_total,
                        "percentage"              => $percentage,
                        "result"                  => $result,
                        "rank_eligible"           => $rank_eligible,
                        "english_i_total"         => $english_i_total,
                        "english_ii_total"        => $english_ii_total,
                        "english_combined_total"  => $english_avg
                    );
                }
            
                // === RANK DISTRIBUTION ===
                $group_ranks = array();
                foreach ($records as $record) {
                    if ($record['rank_eligible']) {
                        $group_ranks[$record['grand_total']][] = $record['student_id'];
                    }
                }
            
                krsort($group_ranks);
                $group_totals = array_keys($group_ranks);
            
                foreach ($records as &$record) {
                    if ($record['rank_eligible']) {
                        $cur_total_position = array_search($record['grand_total'], $group_totals);
                        if ($cur_total_position === 0) {
                            $record['rank'] = 1;
                        } else {
                            $total_prev_students = 0;
                            for ($i = 0; $i < $cur_total_position; $i++) {
                                $total_prev_students += count($group_ranks[$group_totals[$i]]);
                            }
                            $record['rank'] = $total_prev_students + 1;
                        }
                    }
                }
            
                // === STORE OR DISPLAY RESULT ===
                if (isset($store) && $store == "yes") {
                    $this->store_result($report_for == "individual" ? array($records[$student_id]) : $records);
                    echo json_encode(array("status" => "success", "message" => "Result stored successfully."));
                    return;
                }
            
                if ($request_from == "sfsjorethang") {
                    if ($user_found && $password_match) {
                        $html_output = $this->load->view(
                            "academics/result/annual_term/class_xi_xii",
                            array(
                                "students" => array($records[$user_id]),
                                "class_detail" => $class_detail,
                                "section_detail" => $section_detail,
                                "header" => "yes"
                            ),
                            TRUE
                        );
            
                        $this->output
                             ->set_content_type('application/json')
                             ->set_output(json_encode(array('status' => 'success', 'html' => $html_output)));
                    } else {
                        $this->output
                             ->set_content_type('application/json')
                             ->set_output(json_encode(array('status' => 'error', 'message' => 'Invalid credentials')));
                    }
                } else {
                    $this->load->view(
                        "academics/" . $this->input->post('result_type') . "/annual_term/class_xi_xii",
                        array(
                            "students" => $report_for == "individual" ? array($records[$student_id]) : $records,
                            "class_detail" => $class_detail,
                            "section_detail" => $section_detail,
                            "header" => $header
                        )
                    );
                }
            }

            else 
            {
                echo "Report Not Available";
            }
            //END
        }
        
        public function store_result($records) {
            $data = [];
            
            foreach ($records as $student_id => $record) {
                $data[] = [
                    "student_id"    => $student_id, 
                    "class_id"      => $class_id,
                    "section_id"    => $section_id,
                    "session_id"    => $session_id,
                    "exam_id"       => $exam_id,
                    "username"      => $record['student_no'],
                    "password"      => str_replace('-', '', $record['student_sob']),
                    "result"        => json_encode($record)
                ];
            }
            
            $this->Result->create_or_update($data);
            
            return;
        }
    }
    