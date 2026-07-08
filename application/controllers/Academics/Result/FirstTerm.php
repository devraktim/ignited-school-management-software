<?php 
    defined('BASEPATH') OR exit('No direct script access allowed');

    class FirstTerm extends CI_Controller {
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
                    "student_session.session_id" => $session_id,
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

            
            // CLASS I to IV
            if (in_array($class_id, [4, 5, 6, 7]) && $exam_id == 2) {
            
                $students = $this->Student->get_where([
                    "class_id"                 => $class_id,
                    "section_id"               => $section_id,
                    "student_session.promoted" => "ANY",
                    "student_session.session_id" => $session_id,
                ]);
            
                $records = [];
            
                // Fetch evolution paper subjects once per class/exam
                $evolution_paper = $this->EvolutionPaper->get_where([
                    "class_id" => $class_id,
                    "exam_id"  => 2
                ]);
                $evolution_subject_ids = isset($evolution_paper['subjects']) 
                    ? explode(",", $evolution_paper['subjects']) 
                    : [];
            
                // Common configs
                $subject_type_ids         = [1, 2, 3, 4, 5, 6, 7];
                $special_subject_type_ids = [12, 13];
            
                foreach ($students as $student) {
            
                    $student_id = $student['id'];
                    $minor_subjects = [];
            
                    // === Evolution Grades ===
                    $student_evolution = $this->Marks->get_student_evolution($class_id, 2, $student_id);
                    $grades = explode(",", $student_evolution);
            
                    foreach ($evolution_subject_ids as $i => $evolution_id) {
                        $subject_info = $this->EvolutionSubject->get($evolution_id);
                        $minor_subjects[$subject_info['name'] ?? 'Unknown'] = $grades[$i] ?? '';
                    }
            
                    // === Attendance & Remarks ===
                    $attendence = $this->ExamAttendence->get_student_attendence_percentage($class_id, $exam_id, $student_id) ?: '';
                    $remark     = $this->Remarks->get_student_remarks($class_id, $exam_id, $student_id);
            
                    // === Initialize accumulators ===
                    $subjects           = [];
                    $unit_test_marks    = [];
                    $mid_term_marks     = [];
                    $totals             = [];
            
                    $english_total       = null;
                    $major_subject_fails = 0;
                    $major_subject_absents = 0;
                    $grand_total         = 0;
                    $grand_total_max     = 0;
                    $ut1_absent          = 0;
                    $mid_absent          = 0;
            
                    // === Regular Subjects ===
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
            
                        $ut1 = $this->Marks->get_student_marks_by_subject_type($class_id, $student_id, 1, $id);
                        $mid = $this->Marks->get_student_marks_by_subject_type($class_id, $student_id, 2, $id);
            
                        // Handle absents
                        if ($ut1 === "AB") $ut1_absent++;
                        if ($mid === "AB") $mid_absent++;
            
                        // Treat "AB" as 0 for calculations
                        $ut1 = ($ut1 === "AB") ? 0 : $ut1;
                        $mid = ($mid === "AB") ? 0 : $mid;
            
                        $total = $ut1 + $mid;
            
                        $unit_test_marks["s$id"] = $ut1;
                        $mid_term_marks["s$id"]  = $mid;
                        $totals["s$id"]          = $total;
            
                        if ($subject_id == 39) $english_total = $total;
            
                        if ($total < 35) $major_subject_fails++;
                        if ($ut1 == 0 && $mid == 0) $major_subject_absents++;
            
                        $grand_total     += $total;
                        $grand_total_max += 100;
                    }
            
                    // === Special Subjects ===
                    $special_subjects         = [];
                    $special_unit_test_marks  = [];
                    $special_mid_term_marks   = [];
                    $special_totals           = [];
            
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
            
                        $ut1 = $this->Marks->get_student_marks_by_subject_type($class_id, $student_id, 1, $id);
                        $mid = $this->Marks->get_student_marks_by_subject_type($class_id, $student_id, 2, $id);
            
                        $ut1 = ($ut1 === "AB") ? 0 : $ut1;
                        $mid = ($mid === "AB") ? 0 : $mid;
                        $total = $ut1 + $mid;
            
                        $special_unit_test_marks[$key] = $ut1;
                        $special_mid_term_marks[$key]  = $mid;
                        $special_totals[$key]          = $total;
            
                        $grand_total     += $total;
                        $grand_total_max += 100;
                    }
            
                    // === Percentage & Result ===
                    $percentage = $grand_total_max > 0 ? round(($grand_total / $grand_total_max) * 100, 2) : 0;
            
                    $result = 'PASS';
                    if ($english_total === null || $major_subject_absents > 0 || $english_total == 0) {
                        $result = 'INC';
                    } elseif ($english_total < 35) {
                        $result = 'FAIL';
                    } elseif ($major_subject_fails == 1 || $major_subject_fails == 2) {
                        $result = 'PUC';
                    } elseif ($major_subject_fails == 3) {
                        $result = 'FAIL';
                    } elseif ($major_subject_fails >= 4) {
                        $result = 'PCNA';
                    }
            
                    // === Rank Eligibility ===
                    $rank_eligible = (
                        $result === 'PASS' &&
                        $english_total >= 35 &&
                        $major_subject_absents === 0 &&
                        $major_subject_fails === 0 &&
                        $ut1_absent == 0 &&
                        $mid_absent == 0
                    );
            
                    // === Save Student Record ===
                    $records[$student_id] = [
                        "name"                     => trim("{$student['f_name']} {$student['m_name']} {$student['l_name']}"),
                        "roll_no"                  => $student["roll_no"],
                        "student_no"               => $student["student_no"],
                        "student_id"               => $student_id,
                        "student_dob"              => $student["dob"],
            
                        "subject_type_ids"         => $subject_type_ids,
                        "special_subject_type_ids" => $special_subject_type_ids,
            
                        "minor_subjects"           => $minor_subjects,
                        "attendence"               => $attendence,
                        "remark"                   => $remark,
            
                        "unit_test_marks"          => $unit_test_marks,
                        "mid_term_marks"           => $mid_term_marks,
                        "totals"                   => $totals,
                        "subjects"                 => $subjects,
            
                        "special_unit_test_marks"  => $special_unit_test_marks,
                        "special_mid_term_marks"   => $special_mid_term_marks,
                        "special_totals"           => $special_totals,
                        "special_subjects"         => $special_subjects,
            
                        "grand_total"              => $grand_total,
                        "percentage"               => $percentage,
                        "result"                   => $result,
                        "rank_eligible"            => $rank_eligible,
                        "ut1_absent"               => $ut1_absent,
                        "mid_absent"               => $mid_absent
                    ];
                }
            
                // === RANK DISTRIBUTION ===
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
            
                // === STORE OR OUTPUT ===
                if (isset($store) && $store == "yes") {
                    $this->store_result($report_for == "individual" ? [$records[$student_id]] : $records);
                    echo json_encode(["status" => "success", "message" => "Result stored successfully."]);
                    return;
                }
            
                // === OUTPUT TO FRONTEND ===
                if ($request_from == "sfsjorethang") {
                    if ($user_found && $password_match) {
                        $html_output = $this->load->view(
                            "academics/result/half_yearly/class_i_iv",
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
                        "academics/" . $this->input->post('result_type') . "/half_yearly/class_i_iv",
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
            else if (in_array($class_id, [8, 9, 10, 11]) && $exam_id == 2) 
            {
                $students = $this->Student->get_where([
                    "class_id"                   => $class_id,
                    "section_id"                 => $section_id,
                    "student_session.promoted"   => "ANY",
                    "student_session.session_id" => $session_id,
                ]);
            
                $records = [];
                $subject_cache = [];
            
                foreach ($students as $student) {
                    // === Evolution (Minor) Subjects ===
                    $evolution_paper = $this->EvolutionPaper->get_where([
                        "class_id" => $class_id,
                        "exam_id"  => 2
                    ]);
            
                    $evolution_subject_ids = explode(",", $evolution_paper['subjects'] ?? '');
                    $student_evolution     = $this->Marks->get_student_evolution($class_id, 2, $student['id']);
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
                    $subject_type_ids = ($class_id == 8)
                        ? [1, 2, 3, 4, 5, 6, 7]
                        : [1, 2, 3, 4, 5, 6, 7, 8, 9, 10];
            
                    // === Initialize Variables ===
                    $subjects = $unit_test_marks = $mid_term_marks = $totals = $grades_per_subject = [];
                    $english_i_total = $english_ii_total = null;
                    $english_i_present = $english_ii_present = false;
                    $major_subject_fails = $major_subject_absents = $ut1_absent_subjects = 0;
                    $grand_total = $grand_total_max = $ut1_absent = $mid_absent = 0;
            
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
                        $subject_name = isset($subject_cache[$subject_id]) 
                            ? $subject_cache[$subject_id] 
                            : ($this->Subject->get($subject_id)['name'] ?? 'N/A');
                        $subject_cache[$subject_id] = $subject_name;
                        $subjects["s$id"] = $subject_name;
            
                        // Fetch marks
                        $ut1 = $this->Marks->get_student_marks_by_subject_type($class_id, $student['id'], 1, $id);
                        $mid = $this->Marks->get_student_marks_by_subject_type($class_id, $student['id'], 2, $id);
            
                        if ($ut1 === "AB") $ut1_absent++;
                        if ($mid === "AB") $mid_absent++;
                        $ut1 = is_numeric($ut1) ? $ut1 : 0;
                        $mid = is_numeric($mid) ? $mid : 0;
            
                        $total = $ut1 + $mid;
                        $unit_test_marks["s$id"] = $ut1;
                        $mid_term_marks["s$id"]  = $mid;
                        $totals["s$id"]          = $total;
            
                        // === Grade Mapping ===
                        if ($total >= 91) $grade = 1;
                        elseif ($total >= 81) $grade = 2;
                        elseif ($total >= 71) $grade = 3;
                        elseif ($total >= 61) $grade = 4;
                        elseif ($total >= 51) $grade = 5;
                        elseif ($total >= 41) $grade = 6;
                        elseif ($total >= 35) $grade = 7;
                        elseif ($total >= 25) $grade = 8;
                        else $grade = 9;
                        $grades_per_subject["s$id"] = $grade;
            
                        // Attendance / Fails
                        if ($ut1 == 0 && $mid == 0) $major_subject_absents++;
                        if ($ut1 == 0) $ut1_absent_subjects++;
                        if (!in_array($subject_id, [40, 41]) && $total < 35) $major_subject_fails++;
            
                        // English tracking
                        if ($subject_id == 40) { $english_i_total = $total; $english_i_present = true; }
                        if ($subject_id == 41) { $english_ii_total = $total; $english_ii_present = true; }
            
                        $grand_total += $total;
                        $grand_total_max += 100;
                    }
            
                    // === Combine English I & II ===
                    if ($english_i_total !== null && $english_ii_total !== null) {
                        $english_avg = ceil(($english_i_total + $english_ii_total) / 2);
                        $grand_total -= ($english_i_total + $english_ii_total);
                        $grand_total += $english_avg;
                        $grand_total_max = $grand_total_max - 200 + 100;
                        if ($english_avg < 35) $major_subject_fails++;
                    } else {
                        $english_avg = null;
                    }
            
                    // === Special Subjects ===
                    $special_subject_type_ids = ($class_id == 8) ? [12, 13, 14, 15] : [12, 13, 14];
                    $special_subjects = $special_unit_test_marks = $special_mid_term_marks = $special_totals = [];
            
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
                        $subject_name = isset($subject_cache[$subject_id]) 
                            ? $subject_cache[$subject_id] 
                            : ($this->Subject->get($subject_id)['name'] ?? 'N/A');
                        $subject_cache[$subject_id] = $subject_name;
            
                        $special_subjects[$key] = $subject_name;
            
                        $ut1 = (float) $this->Marks->get_student_marks_by_subject_type($class_id, $student['id'], 1, $id);
                        $mid = (float) $this->Marks->get_student_marks_by_subject_type($class_id, $student['id'], 2, $id);
                        $total = $ut1 + $mid;
            
                        $special_unit_test_marks[$key] = $ut1;
                        $special_mid_term_marks[$key]  = $mid;
                        $special_totals[$key]          = $total;
            
                        $grand_total += $total;
                        $grand_total_max += 100;
                    }
            
                    // === Result Logic (no match, PHP7 safe) ===
                    if ($english_avg === null || $english_avg < 35) {
                        $result = 'FAIL';
                    } elseif (!$english_i_present || !$english_ii_present || $major_subject_absents > 0) {
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
            
                    $percentage = $grand_total_max > 0 ? round(($grand_total / $grand_total_max) * 100, 2) : 0;
                    $rank_eligible = (
                        $result === 'PASS' &&
                        $english_avg >= 35 &&
                        !$major_subject_absents &&
                        !$ut1_absent_subjects &&
                        !$ut1_absent && !$mid_absent &&
                        $english_i_present && $english_ii_present
                    );
            
                    // === Record ===
                    $records[$student["id"]] = [
                        "name"                => trim("{$student['f_name']} {$student['m_name']} {$student['l_name']}"),
                        "roll_no"             => $student["roll_no"],
                        "student_no"          => $student["student_no"],
                        "student_id"          => $student["id"],
                        "student_dob"         => $student["dob"],
                        "subject_type_ids"    => $subject_type_ids,
                        "special_subject_type_ids" => $special_subject_type_ids,
                        "minor_subjects"      => $minor_subjects,
                        "attendence"          => round($attendance_percent, 2) ?: '',
                        "remark"              => $remark,
                        "unit_test_marks"     => $unit_test_marks,
                        "mid_term_marks"      => $mid_term_marks,
                        "totals"              => $totals,
                        "subjects"            => $subjects,
                        "grades"              => $grades_per_subject,
                        "special_subjects"    => $special_subjects,
                        "special_unit_test_marks" => $special_unit_test_marks,
                        "special_mid_term_marks"  => $special_mid_term_marks,
                        "special_totals"      => $special_totals,
                        "grand_total"         => $grand_total,
                        "percentage"          => $percentage,
                        "result"              => $result,
                        "rank_eligible"       => $rank_eligible,
                        "english_i_total"     => $english_i_total,
                        "english_ii_total"    => $english_ii_total,
                        "english_combined_total" => $english_avg,
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
                            "academics/result/half_yearly/class_v_viii",
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
                    $this->load->view("academics/" . $this->input->post('result_type') . "/half_yearly/class_v_viii", [
                        "students"       => $report_for === "individual" ? [$records[$student_id]] : $records,
                        "class_detail"   => $class_detail,
                        "section_detail" => $section_detail,
                        "header"         => $header
                    ]);
                }
}

            // Class IX to X
            else if (in_array($class_id, [12, 13]) && $exam_id == 2) {
            
                $students = $this->Student->get_where([
                    "class_id"                   => $class_id,
                    "section_id"                 => $section_id,
                    "student_session.promoted"   => "ANY",
                    "student_session.session_id" => $session_id,
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
            
                    $subjects = $unit_test_marks = $mid_term_marks = $totals = $grades_per_subject = [];
                    $english_i_present = $english_ii_present = false;
                    $english_i_total = $english_ii_total = null;
                    $physics_total = $chemistry_total = $biology_total = null;
                    $history_total = $geography_total = null;
            
                    $major_subject_fails = $major_subject_absents = $ut1_absent_subjects = 0;
                    $ut1_absent = $mid_absent = 0;
                    $grand_total = $grand_total_max = 0;
            
                    /* ---------- Major Subjects Loop ---------- */
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
            
                        $ut1 = $this->Marks->get_student_marks_by_subject_type($class_id, $student['id'], 1, $id);
                        $mid = $this->Marks->get_student_marks_by_subject_type($class_id, $student['id'], 2, $id);
            
                        if ($ut1 === "AB") $ut1_absent++;
                        if ($mid === "AB") $mid_absent++;
            
                        $ut1_val = is_numeric($ut1) ? (float)$ut1 : 0;
                        $mid_val = is_numeric($mid) ? (float)$mid : 0;
                        $total   = $ut1_val + $mid_val;
            
                        $unit_test_marks["s$id"] = is_numeric($ut1) ? $ut1 : '';
                        $mid_term_marks["s$id"]  = is_numeric($mid) ? $mid : '';
                        $totals["s$id"]          = $total;
            
                        /* --- Grade Mapping --- */
                        if ($total >= 91) $grade = 1;
                        elseif ($total >= 81) $grade = 2;
                        elseif ($total >= 71) $grade = 3;
                        elseif ($total >= 61) $grade = 4;
                        elseif ($total >= 51) $grade = 5;
                        elseif ($total >= 41) $grade = 6;
                        elseif ($total >= 35) $grade = 7;
                        elseif ($total >= 25) $grade = 8;
                        else $grade = 9;
                        $grades_per_subject["s$id"] = $grade;
            
                        /* --- Absences --- */
                        if ($ut1 === '' && $mid === '') $major_subject_absents++;
                        if ($ut1 === '') $ut1_absent_subjects++;
            
                        /* --- Fails (English, Science, Social excluded) --- */
                        if (!in_array($subject_id, [40, 41, 50, 51, 52, 53, 54]) && $total < 33) {
                            $major_subject_fails++;
                        }
            
                        /* --- English --- */
                        if ($subject_id == 40) { $english_i_total = $total; if ($ut1 !== '' || $mid !== '') $english_i_present = true; }
                        if ($subject_id == 41) { $english_ii_total = $total; if ($ut1 !== '' || $mid !== '') $english_ii_present = true; }
            
                        /* --- Science --- */
                        if ($subject_id == 50) $physics_total   = $total;
                        if ($subject_id == 51) $chemistry_total = $total;
                        if ($subject_id == 52) $biology_total   = $total;
            
                        /* --- Social --- */
                        if ($subject_id == 53) $history_total   = $total;
                        if ($subject_id == 54) $geography_total = $total;
            
                        $grand_total += $total;
                        $grand_total_max += 100;
                    }
            
                    /* ---------- Combine English ---------- */
                    if ($english_i_total !== null && $english_ii_total !== null) {
                        $english_avg = ceil(($english_i_total + $english_ii_total) / 2);
                        $grand_total = $grand_total - $english_i_total - $english_ii_total + $english_avg;
                        $grand_total_max = $grand_total_max - 200 + 100;
                        if ($english_avg < 33) $major_subject_fails++;
                    } else $english_avg = null;
            
                    /* ---------- Combine Science ---------- */
                    if ($physics_total !== null && $chemistry_total !== null && $biology_total !== null) {
                        $science_avg = ceil(($physics_total + $chemistry_total + $biology_total) / 3);
                        $grand_total = $grand_total - $physics_total - $chemistry_total - $biology_total + $science_avg;
                        $grand_total_max = $grand_total_max - 300 + 100;
                        if ($science_avg < 33) $major_subject_fails++;
                    } else $science_avg = null;
            
                    /* ---------- Combine Social ---------- */
                    if ($history_total !== null && $geography_total !== null) {
                        $social_avg = ceil(($history_total + $geography_total) / 2);
                        $grand_total = $grand_total - $history_total - $geography_total + $social_avg;
                        $grand_total_max = $grand_total_max - 200 + 100;
                        if ($social_avg < 33) $major_subject_fails++;
                    } else $social_avg = null;
            
                    /* ---------- GROUP 3 SUBJECTS ---------- */
                    $group_3_subject_type_ids = [11];
                    $group_3_subjects = $group_3_unit_test_marks = $group_3_mid_term_marks = $group_3_totals = [];
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
            
                        $ut1 = (float)$this->Marks->get_student_marks_by_subject_type($class_id, $student['id'], 1, $id);
                        $mid = (float)$this->Marks->get_student_marks_by_subject_type($class_id, $student['id'], 2, $id);
                        $total = ceil(($ut1 + $mid) / 2);
            
                        $group_3_unit_test_marks[$key] = $ut1;
                        $group_3_mid_term_marks[$key]  = $mid;
                        $group_3_totals[$key]          = $total;
                        $grand_total += $total;
                        $grand_total_max += 100;
                        if ($total < 33) $major_subject_fails++;
                    }
            
                    /* ---------- SPECIAL SUBJECTS ---------- */
                    $special_subject_type_ids = [12, 13];
                    $special_subjects = $special_unit_test_marks = $special_mid_term_marks = $special_totals = [];
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
            
                        $ut1 = (float)$this->Marks->get_student_marks_by_subject_type($class_id, $student['id'], 1, $id);
                        $mid = (float)$this->Marks->get_student_marks_by_subject_type($class_id, $student['id'], 2, $id);
                        $total = $ut1 + $mid;
                        $special_unit_test_marks[$key] = $ut1;
                        $special_mid_term_marks[$key]  = $mid;
                        $special_totals[$key]          = $total;
                    }
            
                    /* ---------- Result Logic ---------- */
                    if ($english_avg === null || $english_avg < 33) {
                        $result = 'FAIL';
                    } elseif (!$english_i_present || !$english_ii_present || $major_subject_absents > 0) {
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
            
                    $percentage = $grand_total_max > 0 ? round(($grand_total / $grand_total_max) * 100, 2) : 0;
                    $attendance_percent = is_numeric($attendence) ? round($attendence, 2) : '';
            
                    $rank_eligible = (
                        $result === 'PASS' &&
                        $english_avg >= 33 &&
                        !$major_subject_absents &&
                        !$ut1_absent_subjects &&
                        !$ut1_absent && !$mid_absent &&
                        $english_i_present && $english_ii_present
                    );
            
                    /* ---------- Store Record ---------- */
                    $records[$student["id"]] = [
                        "name"             => trim("{$student['f_name']} {$student['m_name']} {$student['l_name']}"),
                        "roll_no"          => $student["roll_no"],
                        "student_no"       => $student["student_no"],
                        "student_id"       => $student["id"],
                        "student_dob"      => $student["dob"],
            
                        "subject_type_ids" => $subject_type_ids,
                        "special_subject_type_ids" => $special_subject_type_ids,
                        "group_3_subject_type_ids"  => $group_3_subject_type_ids,
            
                        "minor_subjects"   => $minor_subjects,
                        "attendence"       => $attendance_percent,
                        "remark"           => $remark,
            
                        "unit_test_marks"  => $unit_test_marks,
                        "mid_term_marks"   => $mid_term_marks,
                        "totals"           => $totals,
                        "subjects"         => $subjects,
                        "grades"           => $grades_per_subject,
            
                        "special_subjects" => $special_subjects,
                        "special_unit_test_marks" => $special_unit_test_marks,
                        "special_mid_term_marks"  => $special_mid_term_marks,
                        "special_totals"   => $special_totals,
            
                        "group_3_subjects"        => $group_3_subjects,
                        "group_3_unit_test_marks" => $group_3_unit_test_marks,
                        "group_3_mid_term_marks"  => $group_3_mid_term_marks,
                        "group_3_totals"          => $group_3_totals,
            
                        "grand_total"     => $grand_total,
                        "grand_total_max" => $grand_total_max,
                        "percentage"      => $percentage,
                        "result"          => $result,
                        "rank_eligible"   => $rank_eligible,
            
                        "english_i_total" => $english_i_total,
                        "english_ii_total" => $english_ii_total,
                        "english_combined_total" => $english_avg,
            
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
                            "academics/result/half_yearly/class_ix_x",
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
                    $this->load->view(
                        "academics/" . $this->input->post('result_type') . "/half_yearly/class_ix_x",
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
            else if (in_array($class_id, [14, 15]) && $exam_id == 2) 
            {
                $students = $this->Student->get_where(array(
                    "class_id"                 => $class_id,
                    "section_id"               => $section_id,
                    "student_session.promoted" => "ANY",
                    "student_session.session_id" => $session_id,
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
                        // $grand_total += $total;
                        // $grand_total_max += 100;

                        if($subject_name != 'N/A') {
                            $grand_total += $total;
                            $grand_total_max += 100;
                        }
            
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
                            "academics/result/half_yearly/class_xi_xii",
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
                        "academics/" . $this->input->post('result_type') . "/half_yearly/class_xi_xii",
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
                    "session_id"    => $$session_id,
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