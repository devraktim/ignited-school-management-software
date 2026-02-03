<?php
    defined('BASEPATH') OR exit('No direct script access allowed');

    class Result extends CI_Model {

   
        public function get_first_term_result($class_id, $section_id, $exam_id, $report_for = "all", $selected_student_id = NULL) {
            
            // Class I to II
            if(in_array($class_id, [2, 3])) 
            { 
            
                $students = $this->Student->get_where([
                    "class_id"                      => $class_id,
                    "section_id"                    => $section_id,
                    "student_session.promoted"      => "ANY",
                    "student_session.withdraw"      => "ANY",
                ]);
                
                $records = [];
                $ranks = [];
                
                $class_teacher = "";
                if($class_id == 2) {
                    if($section_id == 1) {
                        $class_teacher = "MS. JEENY";
                    }
                    
                    if($section_id == 2) {
                        $class_teacher = "MS. KALPANA";
                    }
                }
                
                if($class_id == 3) {
                    if($section_id == 1) {
                        $class_teacher = "MS. TULSI";
                    }
                    
                    if($section_id == 2) {
                        $class_teacher = "MS. LIPIKA";
                    }
                }
                
                foreach($students as $student) {
                    $student_evolution = $this->Marks->get_student_evolution($class_id, $exam_id, $student['id']);
                    $grades = explode(",", $student_evolution);
                    
                    $attendence = $this->ExamAttendence->get_student_attendence_percentage($class_id, $exam_id, $student['id']);
                    $remark     = $this->Remarks->get_student_remarks($class_id, $exam_id, $student['id']);
                    
                    // Grade Subjects
                    $grade_subjects = [
                        "gk"            => $this->Marks->get_student_grade($class_id, 2, 22,  $student['id']), 
                        "moral_science" => $this->Marks->get_student_grade($class_id, 2, 23,  $student['id']),
                        "catechism"     => $this->Marks->get_student_grade($class_id, 2, 24,  $student['id']),
                        "handwriting"   => $this->Marks->get_student_grade($class_id, 2, 27,  $student['id']),
                        "drawing"       => $this->Marks->get_student_grade($class_id, 2, 30,  $student['id'])
                    ];
                    
                    // Marks Subject UNIT TEST
                    $unit_test_marks = [
                        "english_language"      => $this->Marks->get_student_marks($class_id, 1, 2,  $student['id']),
                        "english_literature"    => $this->Marks->get_student_marks($class_id, 1, 1,  $student['id']),
                        "second_language"       => $this->Marks->get_student_marks($class_id, 1, 25, $student['id']),
                        "mathematics"           => $this->Marks->get_student_marks($class_id, 1, 3,  $student['id']),
                        "evs"                   => $this->Marks->get_student_marks($class_id, 1, 8,  $student['id']),
                        "computer"              => $this->Marks->get_student_marks($class_id, 1, 16, $student['id']),
                    ];
                    
                    // Marks Subject First Term
                    $first_term_marks = [
                        "english_language"      => $this->Marks->get_student_marks($class_id, 2, 2,  $student['id']),
                        "english_literature"    => $this->Marks->get_student_marks($class_id, 2, 1,  $student['id']),
                        "second_language"       => $this->Marks->get_student_marks($class_id, 2, 25, $student['id']),
                        "mathematics"           => $this->Marks->get_student_marks($class_id, 2, 3,  $student['id']),
                        "evs"                   => $this->Marks->get_student_marks($class_id, 2, 8,  $student['id']),
                        "computer"              => $this->Marks->get_student_marks($class_id, 2, 16, $student['id']),
                    ];
                    
                    $totals = [
                        "english_language"      =>  $unit_test_marks["english_language"]    + $first_term_marks["english_language"],
                        "english_literature"    =>  $unit_test_marks["english_literature"]  + $first_term_marks["english_literature"],
                        "second_language"       =>  $unit_test_marks["second_language"]     + $first_term_marks["second_language"],
                        "mathematics"           =>  $unit_test_marks["mathematics"]         + $first_term_marks["mathematics"],
                        "evs"                   =>  $unit_test_marks["evs"]                 + $first_term_marks["evs"],
                        "computer"              =>  $unit_test_marks["computer"]            + $first_term_marks["computer"],
                    ];
                    
                    $percentage = [
                        "english"           => number_format(($totals["english_language"] + $totals["english_literature"]) / 2),
                        "second_language"   => $totals["second_language"],
                        "mathematics"       => $totals["mathematics"],
                        "evs"               => $totals["evs"],
                        "computer"          => $totals["computer"]
                    ];
                    
                    $total_percentage = $percentage["english"] + $percentage["second_language"] + $percentage["mathematics"] + $percentage["evs"] + $percentage["computer"] ;
                    $total_avg_percentage = number_format($total_percentage / 5);
                    
                    
                    $division = "";
                    
                    if($total_avg_percentage >= 85 && $total_avg_percentage <= 100) {
                        $division = "1st Div";
                    }
                    elseif($total_avg_percentage >= 65 && $total_avg_percentage <= 84) {
                        $division = "2nd Div";
                    }
                    elseif($total_avg_percentage >= 45 && $total_avg_percentage <= 64) {
                        $division = "3rd Div";
                    }
                    elseif($total_avg_percentage < 45) {
                        $division = "Unsatisfactory";
                    }
                    else {
                        $division = "";
                    }
                    
                    
                    $numberOfSubjectMarksIsLessThan45 = 0;
                    
                    if($totals["english_language"] < 45) {$numberOfSubjectMarksIsLessThan45++;}
                    if($totals["english_literature"] < 45) {$numberOfSubjectMarksIsLessThan45++;}
                    if($totals["second_language"] < 45) {$numberOfSubjectMarksIsLessThan45++;}
                    if($totals["mathematics"] < 45) {$numberOfSubjectMarksIsLessThan45++;}
                    if($totals["evs"] < 45) {$numberOfSubjectMarksIsLessThan45++;}
                    if($totals["computer"] < 45) {$numberOfSubjectMarksIsLessThan45++;}
                    
                    
                    // Direct Condidiotion
                    $passed = false;
                    $eligible_for_rank = false;
                    
                    if($percentage["english"] >= 45 && $percentage["second_language"] >= 25 && $percentage["mathematics"] >= 25) {
                        $passed = true;
                    }
                    else {
                        $passed = false;
                    }
                    
                    if($passed) {
                        if($numberOfSubjectMarksIsLessThan45 == 1 || $numberOfSubjectMarksIsLessThan45 == 2) {
                            $passed = true;
                            $eligible_for_rank = false;
                        }
                        else if($numberOfSubjectMarksIsLessThan45 >= 3) {
                            $passed = false;
                            $eligible_for_rank = false;
                        }
                        else {
                            $passed = true;
                            $eligible_for_rank = true;
                            $ranks[] = $total_percentage;
                        }
                    }
                    

                    $data = [
                        "name"                  => $student["f_name"] . " " . $student["m_name"] . " " . $student["l_name"],
                        "roll_no"               => $student["roll_no"],
                        "student_no"            => $student["student_no"],
                        "student_id"            => $student["id"],               
                        "remarks"               => $remark,
                        "unit_test_marks"       => $unit_test_marks,
                        "first_term_marks"      => $first_term_marks,
                        "evolution_grades"      => $grades,
                        "totals"                => $totals,
                        "percentage"            => $percentage,
                        "total_avg"             => $total_avg,
                        "points"                => $points,
                        "total_percentage"      => $total_percentage,
                        "total_avg_percentage"  => $total_avg_percentage,
                        "division"              => $division,
                        "attendence"            => $attendence,
                        "subject"               => $subject,
                        "passed"                => $passed,
                        "eligible_for_rank"     => $eligible_for_rank,
                        "grade_subjects"        => $grade_subjects,
                        "class_teacher"         => $class_teacher
                    ];
                    
                    $records[] = $data;
                }
            
                if($report_for != "all") {
                    $student_id = $selected_student_id;
                    
                    $temp = [];
                    
                    foreach($records as $record) {
                        if($record["student_id"] == $student_id) {
                            $temp[] = $record;
                        }
                    }
                    
                    $records = $temp;
                }
                
                $class = $this->AcademyClass->get($class_id);
                $section = $this->Section->get($section_id);
                
                $all_ranks = array_unique($ranks);
                rsort($all_ranks);
            
                return ["students" => $records, "ranks" => $all_ranks];
            }
            
            // Class III to IV
            else if(in_array($class_id, [4, 5]))
            {
                $students = $this->Student->get_where([
                    "class_id"                      => $class_id,
                    "section_id"                    => $section_id,
                    "student_session.promoted"      => "ANY",
                    "student_session.withdraw"      => "ANY",
                ]);
            
                $records = [];
                $ranks = [];
                
                $class_teacher = "";
                if($class_id == 4) {
                    if($section_id == 1) {
                        $class_teacher = "SR. RUPOLA";
                    }
                    
                    if($section_id == 2) {
                        $class_teacher = "MS. PRISCILLA";
                    }
                }
                
                if($class_id == 5) {
                    if($section_id == 1) {
                        $class_teacher = "MS. CHRISTABEL";
                    }
                    
                    if($section_id == 2) {
                        $class_teacher = "MS. SUSHMA";
                    }
                }
                
                foreach($students as $student) {
                    $student_evolution = $this->Marks->get_student_evolution($class_id, $exam_id, $student['id']);
                    $grades = explode(",", $student_evolution);
                    
                    $attendence = $this->ExamAttendence->get_student_attendence_percentage($class_id, $exam_id, $student['id']);
                    $remark     = $this->Remarks->get_student_remarks($class_id, $exam_id, $student['id']);
                    
                    // Grade Subjects
                    $grade_subjects = [
                        "gk"            => $this->Marks->get_student_grade($class_id, 2, 22,  $student['id']), 
                        "moral_science" => $this->Marks->get_student_grade($class_id, 2, 23,  $student['id']),
                        "catechism"     => $this->Marks->get_student_grade($class_id, 2, 24,  $student['id']),
                        "handwriting"   => $this->Marks->get_student_grade($class_id, 2, 27,  $student['id']),
                        "third_language"=> $this->Marks->get_student_grade($class_id, 2, 27,  $student['id']),
                        "drawing"       => $this->Marks->get_student_grade($class_id, 2, 30,  $student['id'])
                    ];
                    
                    // Marks Subject UNIT TEST
                    $unit_test_marks = [
                        "english_language"      => $this->Marks->get_student_marks($class_id, 1, 2,  $student['id']),
                        "english_literature"    => $this->Marks->get_student_marks($class_id, 1, 1,  $student['id']),
                        "second_language"       => $this->Marks->get_student_marks($class_id, 1, 25, $student['id']),
                        "mathematics"           => $this->Marks->get_student_marks($class_id, 1, 3,  $student['id']),
                        "science"               => $this->Marks->get_student_marks($class_id, 1, 4,  $student['id']),
                        "social_studies"        => $this->Marks->get_student_marks($class_id, 1, 20, $student['id']),
                        "computer"              => $this->Marks->get_student_marks($class_id, 1, 16, $student['id']),
                    ];
                    
                    // Marks Subject First Term
                    $first_term_marks = [
                        "english_language"      => $this->Marks->get_student_marks($class_id, 2, 2,  $student['id']),
                        "english_literature"    => $this->Marks->get_student_marks($class_id, 2, 1,  $student['id']),
                        "second_language"       => $this->Marks->get_student_marks($class_id, 2, 25, $student['id']),
                        "mathematics"           => $this->Marks->get_student_marks($class_id, 2, 3,  $student['id']),
                        "science"               => $this->Marks->get_student_marks($class_id, 2, 4,  $student['id']),
                        "social_studies"        => $this->Marks->get_student_marks($class_id, 2, 20, $student['id']),
                        "computer"              => $this->Marks->get_student_marks($class_id, 2, 16, $student['id']),
                    ];
                    
                    $totals = [
                        "english_language"      =>  $unit_test_marks["english_language"]    + $first_term_marks["english_language"],
                        "english_literature"    =>  $unit_test_marks["english_literature"]  + $first_term_marks["english_literature"],
                        "second_language"       =>  $unit_test_marks["second_language"]     + $first_term_marks["second_language"],
                        "mathematics"           =>  $unit_test_marks["mathematics"]         + $first_term_marks["mathematics"],
                        "science"               =>  $unit_test_marks["science"]             + $first_term_marks["science"],
                        "social_studies"        =>  $unit_test_marks["social_studies"]      + $first_term_marks["social_studies"],
                        "computer"              =>  $unit_test_marks["computer"]            + $first_term_marks["computer"],
                    ];
                    
                    $percentage = [
                        "english"           => number_format(($totals["english_language"] + $totals["english_literature"]) / 2),
                        "second_language"   => $totals["second_language"],
                        "mathematics"       => $totals["mathematics"],
                        "science"           => $totals["science"],
                        "social_studies"    => $totals["social_studies"],
                        "computer"          => $totals["computer"]
                    ];
                    
                    $total_percentage = $percentage["english"] + $percentage["second_language"] + $percentage["mathematics"] + $percentage["science"] + $percentage["social_studies"] + $percentage["computer"] ;
                    $total_avg_percentage = number_format($total_percentage / 6);
                    
                    $division = "";
                    
                    if($total_avg_percentage >= 85 && $total_avg_percentage <= 100) {
                        $division = "1st Div";
                    }
                    elseif($total_avg_percentage >= 65 && $total_avg_percentage <= 84) {
                        $division = "2nd Div";
                    }
                    elseif($total_avg_percentage >= 45 && $total_avg_percentage <= 64) {
                        $division = "3rd Div";
                    }
                    elseif($total_avg_percentage < 45) {
                        $division = "Unsatisfactory";
                    }
                    else {
                        $division = "";
                    }
                    
                    
                    $numberOfSubjectMarksIsLessThan45 = 0;
                    
                    if($totals["english_language"] < 45) {$numberOfSubjectMarksIsLessThan45++;}
                    if($totals["english_literature"] < 45) {$numberOfSubjectMarksIsLessThan45++;}
                    if($totals["second_language"] < 45) {$numberOfSubjectMarksIsLessThan45++;}
                    if($totals["mathematics"] < 45) {$numberOfSubjectMarksIsLessThan45++;}
                    if($totals["science"] < 45) {$numberOfSubjectMarksIsLessThan45++;}
                    if($totals["social_studies"] < 45) {$numberOfSubjectMarksIsLessThan45++;}
                    if($totals["computer"] < 45) {$numberOfSubjectMarksIsLessThan45++;}
                    
                    
                    // Direct Condidiotion
                    $passed = false;
                    $eligible_for_rank = false;
                    
                    if($percentage["english"] >= 45 && $percentage["second_language"] >= 25 && $percentage["mathematics"] >= 25) {
                        $passed = true;
                    }
                    else {
                        $passed = false;
                    }
                    
                    if($passed) {
                        if($numberOfSubjectMarksIsLessThan45 == 1 || $numberOfSubjectMarksIsLessThan45 == 2) {
                            $passed = true;
                            $eligible_for_rank = false;
                        }
                        else if($numberOfSubjectMarksIsLessThan45 >= 3) {
                            $passed = false;
                            $eligible_for_rank = false;
                        }
                        else {
                            $passed = true;
                            $eligible_for_rank = true;
                            $ranks[] = $total_percentage;
                        }
                    }
                    

                    $data = [
                        "name"                  => $student["f_name"] . " " . $student["m_name"] . " " . $student["l_name"],
                        "roll_no"               => $student["roll_no"],
                        "student_no"            => $student["student_no"],
                        "student_id"            => $student["id"],
                        "remarks"               => $remark,
                        "unit_test_marks"       => $unit_test_marks,
                        "first_term_marks"      => $first_term_marks,
                        "evolution_grades"      => $grades,
                        "totals"                => $totals,
                        "percentage"            => $percentage,
                        "total_avg"             => $total_avg,
                        "points"                => $points,
                        "total_percentage"      => $total_percentage,
                        "total_avg_percentage"  => $total_avg_percentage,
                        "division"              => $division,
                        "attendence"            => $attendence,
                        "subject"               => $subject,
                        "passed"                => $passed,
                        "eligible_for_rank"     => $eligible_for_rank,
                        "grade_subjects"        => $grade_subjects,
                        "class_teacher"         => $class_teacher
                    ];
                    
                    $records[] = $data;
                }
                
                if($report_for != "all") {
                    $student_id = $selected_student_id;
                    
                    $temp = [];
                    
                    foreach($records as $record) {
                        if($record["student_id"] == $student_id) {
                            $temp[] = $record;
                        }
                    }
                    
                    $records = $temp;
                }
                
                $class = $this->AcademyClass->get($class_id);
                $section = $this->Section->get($section_id);
                
                $all_ranks = array_unique($ranks);
                rsort($all_ranks);
            
                // echo "<pre>";
                // print_r($all_ranks);
                // echo "</pre>";
                
                return ["students" => $records, "ranks" => $all_ranks];
            }
            
            // Class V
            else if(in_array($class_id, [6]))
            {
                $students = $this->Student->get_where([
                    "class_id"                      => $class_id,
                    "section_id"                    => $section_id,
                    "student_session.promoted"      => "ANY",
                    "student_session.withdraw"      => "ANY",
                ]);
            
                $records = [];
                $ranks = [];
                
                $class_teacher = "";
                if($class_id == 6) {
                    if($section_id == 1) {
                        $class_teacher = "MS. MARINA";
                    }
                    
                    if($section_id == 2) {
                        $class_teacher = "MS. REETU";
                    }
                }
                
                foreach($students as $student) {
                    $student_evolution = $this->Marks->get_student_evolution($class_id, $exam_id, $student['id']);
                    $grades = explode(",", $student_evolution);
                    
                    $attendence = $this->ExamAttendence->get_student_attendence_percentage($class_id, $exam_id, $student['id']);
                    $remark     = $this->Remarks->get_student_remarks($class_id, $exam_id, $student['id']);
                    
                    // Grade Subjects
                    $grade_subjects = [
                        "gk"                => $this->Marks->get_student_grade($class_id, 2, 22,  $student['id']), 
                        "moral_science"     => $this->Marks->get_student_grade($class_id, 2, 23,  $student['id']),
                        "catechism"         => $this->Marks->get_student_grade($class_id, 2, 24,  $student['id']),
                        "handwriting"       => $this->Marks->get_student_grade($class_id, 2, 27,  $student['id']),
                        "third_language"    => $this->Marks->get_student_grade($class_id, 2, 26,  $student['id']),
                        "drawing"           => $this->Marks->get_student_grade($class_id, 2, 30,  $student['id'])
                    ];
                    
                    // Marks Subject UNIT TEST
                    $unit_test_marks = [
                        "english_language"      => $this->Marks->get_student_marks($class_id, 1, 2,  $student['id']),
                        "english_literature"    => $this->Marks->get_student_marks($class_id, 1, 1,  $student['id']),
                        "second_language"       => $this->Marks->get_student_marks($class_id, 1, 25, $student['id']),
                        "mathematics"           => $this->Marks->get_student_marks($class_id, 1, 3,  $student['id']),
                        "science"               => $this->Marks->get_student_marks($class_id, 1, 4,  $student['id']),
                        "social_studies"        => $this->Marks->get_student_marks($class_id, 1, 20, $student['id']),
                        "computer"              => $this->Marks->get_student_marks($class_id, 1, 16, $student['id']),
                    ];
                    
                    // Marks Subject First Term
                    $first_term_marks = [
                        "english_language"      => $this->Marks->get_student_marks($class_id, 2, 2,  $student['id']),
                        "english_literature"    => $this->Marks->get_student_marks($class_id, 2, 1,  $student['id']),
                        "second_language"       => $this->Marks->get_student_marks($class_id, 2, 25, $student['id']),
                        "mathematics"           => $this->Marks->get_student_marks($class_id, 2, 3,  $student['id']),
                        "science"               => $this->Marks->get_student_marks($class_id, 2, 4,  $student['id']),
                        "social_studies"        => $this->Marks->get_student_marks($class_id, 2, 20, $student['id']),
                        "computer"              => $this->Marks->get_student_marks($class_id, 2, 16, $student['id']),
                    ];
                    
                    $totals = [
                        "english_language"      =>  $unit_test_marks["english_language"]    + $first_term_marks["english_language"],
                        "english_literature"    =>  $unit_test_marks["english_literature"]  + $first_term_marks["english_literature"],
                        "second_language"       =>  $unit_test_marks["second_language"]     + $first_term_marks["second_language"],
                        "mathematics"           =>  $unit_test_marks["mathematics"]         + $first_term_marks["mathematics"],
                        "science"               =>  $unit_test_marks["science"]             + $first_term_marks["science"],
                        "social_studies"        =>  $unit_test_marks["social_studies"]      + $first_term_marks["social_studies"],
                        "computer"              =>  $unit_test_marks["computer"]            + $first_term_marks["computer"],
                    ];
                    
                    $percentage = [
                        "english"           => number_format(($totals["english_language"] + $totals["english_literature"]) / 2),
                        "second_language"   => $totals["second_language"],
                        "mathematics"       => $totals["mathematics"],
                        "science"           => $totals["science"],
                        "social_studies"    => $totals["social_studies"],
                        "computer"          => $totals["computer"]
                    ];
                    
                    $total_percentage = $percentage["english"] + $percentage["second_language"] + $percentage["mathematics"] + $percentage["science"] + $percentage["social_studies"] + $percentage["computer"] ;
                    $total_avg_percentage = number_format($total_percentage / 6);
                    
                    
                    $division = "";
                    
                    if($total_avg_percentage >= 85 && $total_avg_percentage <= 100) {
                        $division = "1st Div";
                    }
                    elseif($total_avg_percentage >= 65 && $total_avg_percentage <= 84) {
                        $division = "2nd Div";
                    }
                    elseif($total_avg_percentage >= 45 && $total_avg_percentage <= 64) {
                        $division = "3rd Div";
                    }
                    elseif($total_avg_percentage < 45) {
                        $division = "Unsatisfactory";
                    }
                    else {
                        $division = "";
                    }
                    
                    
                    $numberOfSubjectMarksIsLessThan45 = 0;
                    
                    if($totals["english_language"] < 45) {$numberOfSubjectMarksIsLessThan45++;}
                    if($totals["english_literature"] < 45) {$numberOfSubjectMarksIsLessThan45++;}
                    if($totals["second_language"] < 45) {$numberOfSubjectMarksIsLessThan45++;}
                    if($totals["mathematics"] < 45) {$numberOfSubjectMarksIsLessThan45++;}
                    if($totals["science"] < 45) {$numberOfSubjectMarksIsLessThan45++;}
                    if($totals["social_studies"] < 45) {$numberOfSubjectMarksIsLessThan45++;}
                    if($totals["computer"] < 45) {$numberOfSubjectMarksIsLessThan45++;}
                    
                    
                    // Direct Condidiotion
                    $passed = false;
                    $eligible_for_rank = false;
                    
                    if($percentage["english"] >= 45 && $percentage["second_language"] >= 25 && $percentage["mathematics"] >= 25) {
                        $passed = true;
                    }
                    else {
                        $passed = false;
                    }
                    
                    if($passed) {
                        if($numberOfSubjectMarksIsLessThan45 == 1 || $numberOfSubjectMarksIsLessThan45 == 2) {
                            $passed = true;
                            $eligible_for_rank = false;
                        }
                        else if($numberOfSubjectMarksIsLessThan45 >= 3) {
                            $passed = false;
                            $eligible_for_rank = false;
                        }
                        else {
                            $passed = true;
                            $eligible_for_rank = true;
                            $ranks[] = $total_percentage;
                        }
                    }
                    

                    $data = [
                        "name"                  => $student["f_name"] . " " . $student["m_name"] . " " . $student["l_name"],
                        "roll_no"               => $student["roll_no"],
                        "student_no"            => $student["student_no"],
                        "student_id"            => $student["id"],
                        "remarks"               => $remark,
                        "unit_test_marks"       => $unit_test_marks,
                        "first_term_marks"      => $first_term_marks,
                        "evolution_grades"      => $grades,
                        "totals"                => $totals,
                        "percentage"            => $percentage,
                        "total_avg"             => $total_avg,
                        "points"                => $points,
                        "total_percentage"      => $total_percentage,
                        "total_avg_percentage"  => $total_avg_percentage,
                        "division"              => $division,
                        "attendence"            => $attendence,
                        "subject"               => $subject,
                        "passed"                => $passed,
                        "eligible_for_rank"     => $eligible_for_rank,
                        "grade_subjects"        => $grade_subjects,
                        "class_teacher"         => $class_teacher
                    ];
                    
                    $records[] = $data;
                }
                
                if($report_for != "all") {
                    $student_id = $selected_student_id;
                    
                    $temp = [];
                    
                    foreach($records as $record) {
                        if($record["student_id"] == $student_id) {
                            $temp[] = $record;
                        }
                    }
                    
                    $records = $temp;
                }
                
                $class = $this->AcademyClass->get($class_id);
                $section = $this->Section->get($section_id);
                
                $all_ranks = array_unique($ranks);
                rsort($all_ranks);
            
                // echo "<pre>";
                // print_r($all_ranks);
                // echo "</pre>";
                
                return ["students" => $records, "ranks" => $all_ranks];
            }
            
            // Class VI, VII, VIII
            else if(in_array($class_id, [7, 8, 9]))
            {
               $students = $this->Student->get_where([
                    "class_id"                      => $class_id,
                    "section_id"                    => $section_id,
                    "student_session.promoted"      => "ANY",
                    "student_session.withdraw"      => "ANY",
                ]);
                
                $records = [];
                $ranks = [];
                
                $class_teacher = "";
                if($class_id == 7) {
                    if($section_id == 1) {
                        $class_teacher = "MS. SAROJ";
                    }
                    
                    if($section_id == 2) {
                        $class_teacher = "MS. YOGITA";
                    }
                }
                if($class_id == 8) {
                    if($section_id == 1) {
                        $class_teacher = "MS. NIKHAT";
                    }
                    
                    if($section_id == 2) {
                        $class_teacher = "MS. JYOTIKA";
                    }
                }
                if($class_id == 9) {
                    if($section_id == 1) {
                        $class_teacher = "MS. TERESA";
                    }
                    
                    if($section_id == 2) {
                        $class_teacher = "MS. DONA";
                    }
                }
                
                foreach($students as $student) {
                    $student_evolution = $this->Marks->get_student_evolution($class_id, $exam_id, $student['id']);
                    $grades = explode(",", $student_evolution);
                    
                    $attendence = $this->ExamAttendence->get_student_attendence_percentage($class_id, $exam_id, $student['id']);
                    $remark     = $this->Remarks->get_student_remarks($class_id, $exam_id, $student['id']);
                    
                    
                    // Get the subject_id of Subject 10
                    $row = $this->StudentSubject->get_where([
                        "academy_class_id"  => $class_id,
                        "subject_type_id"   => 24,
                        "student_id"        => $student['id'],
                    ]);
                    
                    $subject_id = $row["subject_id"];
                    $subject = $this->Subject->get($subject_id);
                    
                    // Grade Subjects
                    $grade_subjects = [
                        "moral_science"     => $this->Marks->get_student_grade($class_id, 2, 23,  $student['id']),
                        "catechism"         => $this->Marks->get_student_grade($class_id, 2, 24,  $student['id']),
                        "third_language"    => $this->Marks->get_student_grade($class_id, 2, 26,  $student['id'])
                    ];
                    
                    // Marks Subject UNIT TEST
                    $unit_test_marks = [
                        "english_language"      => $this->Marks->get_student_marks($class_id, 1, 2,  $student['id']),
                        "english_literature"    => $this->Marks->get_student_marks($class_id, 1, 1,  $student['id']),
                        "second_language"       => $this->Marks->get_student_marks($class_id, 1, 25, $student['id']),
                        "mathematics"           => $this->Marks->get_student_marks($class_id, 1, 3,  $student['id']),
                        "physics"               => $this->Marks->get_student_marks($class_id, 1, 6,  $student['id']),
                        "chemistry"             => $this->Marks->get_student_marks($class_id, 1, 7,  $student['id']),
                        "biology"               => $this->Marks->get_student_marks($class_id, 1, 5,  $student['id']),
                        "history"               => $this->Marks->get_student_marks($class_id, 1, 15, $student['id']),
                        "geography"             => $this->Marks->get_student_marks($class_id, 1, 10, $student['id']),
                        "subject_10_marks"      => $this->Marks->get_student_marks($class_id, 1, $subject_id, $student['id']),
                    ];
                    
                    // Marks Subject First Term
                    $first_term_marks = [
                        "english_language"      => $this->Marks->get_student_marks($class_id, 2, 2,  $student['id']),
                        "english_literature"    => $this->Marks->get_student_marks($class_id, 2, 1,  $student['id']),
                        "second_language"       => $this->Marks->get_student_marks($class_id, 2, 25, $student['id']),
                        "mathematics"           => $this->Marks->get_student_marks($class_id, 2, 3,  $student['id']),
                        "physics"               => $this->Marks->get_student_marks($class_id, 2, 6,  $student['id']),
                        "chemistry"             => $this->Marks->get_student_marks($class_id, 2, 7,  $student['id']),
                        "biology"               => $this->Marks->get_student_marks($class_id, 2, 5,  $student['id']),
                        "history"               => $this->Marks->get_student_marks($class_id, 2, 15, $student['id']),
                        "geography"             => $this->Marks->get_student_marks($class_id, 2, 10, $student['id']),
                        "subject_10_marks"      => $this->Marks->get_student_marks($class_id, 2, $subject_id, $student['id']),
                    ];
                    
                    $totals = [
                        "english_language"      =>  $unit_test_marks["english_language"]    + $first_term_marks["english_language"],
                        "english_literature"    =>  $unit_test_marks["english_literature"]  + $first_term_marks["english_literature"],
                        "second_language"       =>  $unit_test_marks["second_language"]     + $first_term_marks["second_language"],
                        "mathematics"           =>  $unit_test_marks["mathematics"]         + $first_term_marks["mathematics"],
                        "physics"               =>  $unit_test_marks["physics"]             + $first_term_marks["physics"],
                        "chemistry"             =>  $unit_test_marks["chemistry"]           + $first_term_marks["chemistry"],
                        "biology"               =>  $unit_test_marks["biology"]             + $first_term_marks["biology"],
                        "history"               =>  $unit_test_marks["history"]             + $first_term_marks["history"],
                        "geography"             =>  $unit_test_marks["geography"]           + $first_term_marks["geography"],
                        "subject_10_marks"      =>  $unit_test_marks["subject_10_marks"]    + $first_term_marks["subject_10_marks"],
                    ];
                    
                    $avgs = [
                        "english"           => number_format(($totals["english_language"] + $totals["english_literature"]) / 2),
                        "second_language"   => $totals["second_language"],
                        "mathematics"       => $totals["mathematics"],
                        "pcb"               => number_format(($totals["physics"] + $totals["chemistry"] + $totals["biology"]) / 3),
                        "hg"                => number_format(($totals["history"] + $totals["geography"]) / 2),
                        "subject_10_marks"  => $totals["subject_10_marks"]
                    ];
                    
                    $total_avg = $avgs["english"] + $avgs["second_language"] + $avgs["mathematics"] + $avgs["pcb"] + $avgs["hg"] + $avgs["subject_10_marks"];
                    
                    
                    $points = [];
                    $total_point = 0;
                    $division = "";
                    
                    foreach($avgs as $key => $value) {
                        
                        $point = "";
                        
                        if($value >= 90 && $value <= 100) {
                            $point = 1;
                        }
                        elseif($value >= 80 && $value <= 89) {
                            $point = 2;
                        }
                        elseif($value >= 70 && $value <= 79) {
                            $point = 3;
                        }
                        elseif($value >= 60 && $value <= 69) {
                            $point = 4;
                        }
                        elseif($value >= 50 && $value <= 59) {
                            $point = 5;
                        }
                        elseif($value >= 46 && $value <= 49) {
                            $point = 6;
                        }
                        elseif($value == 45) {
                            $point = 7;
                        }
                        else {
                            $point = 8;
                        }
                        
                        $total_point += $point;
                        $points[$key] = $point;
                    }
                    
                    
                    if($total_point > 44) {
                        $division = "Unsatisfactory";
                    }
                    elseif($total_point >= 39 && $total_point <= 44) {
                        $division = "Pass";
                    }
                    elseif($total_point >= 31 && $total_point <= 38) {
                        $division = "3rd";
                    }
                    elseif($total_point >= 21 && $total_point <= 30) {
                        $division = "2nd";
                    }
                    elseif($total_point <= 21) {
                        $division = "1st";
                    }
                    else {
                        $division = "";
                    }
                
                    
                    $numberOfSubjectMarksIsLessThan45 = 0;
                    
                    if($totals["english_language"] < 45) {$numberOfSubjectMarksIsLessThan45++;}
                    if($totals["english_literature"] < 45) {$numberOfSubjectMarksIsLessThan45++;}
                    if($totals["second_language"] < 45) {$numberOfSubjectMarksIsLessThan45++;}
                    if($totals["mathematics"] < 45) {$numberOfSubjectMarksIsLessThan45++;}
                    if($totals["physics"] < 45) {$numberOfSubjectMarksIsLessThan45++;}
                    if($totals["chemistry"] < 45) {$numberOfSubjectMarksIsLessThan45++;}
                    if($totals["biology"] < 45) {$numberOfSubjectMarksIsLessThan45++;}
                    if($totals["history"] < 45) {$numberOfSubjectMarksIsLessThan45++;}
                    if($totals["geography"] < 45) {$numberOfSubjectMarksIsLessThan45++;}
                    if($totals["subject_10_marks"] < 45) {$numberOfSubjectMarksIsLessThan45++;}
                    
                    
                    // Direct Condidiotion
                    $passed = false;
                    $eligible_for_rank = false;
                    
                    if($avgs["english"] >= 45 && $avgs["second_language"] >= 25 && $avgs["mathematics"] >= 25) {
                        $passed = true;
                    }
                    else {
                        $passed = false;
                    }
                    
                    if($passed) {
                        if($numberOfSubjectMarksIsLessThan45 == 1 || $numberOfSubjectMarksIsLessThan45 == 2) {
                            $passed = true;
                            $eligible_for_rank = false;
                        }
                        else if($numberOfSubjectMarksIsLessThan45 >= 3) {
                            $passed = false;
                            $eligible_for_rank = false;
                        }
                        else {
                            $passed = true;
                            $eligible_for_rank = true;
                            $ranks[] = $total_avg;
                        }
                    }
                    

                    $data = [
                        "name"                  => $student["f_name"] . " " . $student["m_name"] . " " . $student["l_name"],
                        "roll_no"               => $student["roll_no"],
                        "student_no"            => $student["student_no"],
                        "student_id"            => $student["id"],
                        "remarks"               => $remark,
                        "unit_test_marks"       => $unit_test_marks,
                        "first_term_marks"      => $first_term_marks,
                        "evolution_grades"      => $grades,
                        "totals"                => $totals,
                        "avgs"                  => $avgs,
                        "total_avg"             => $total_avg,
                        "points"                => $points,
                        "total_point"           => $total_point,
                        "division"              => $division,
                        "attendence"            => $attendence,
                        "subject"               => $subject,
                        "passed"                => $passed,
                        "eligible_for_rank"     => $eligible_for_rank,
                        "grade_subjects"        => $grade_subjects,
                        "class_teacher"         => $class_teacher
                    ];
                    
                    $records[] = $data;
                }
                
                if($report_for != "all") {
                    $student_id = $selected_student_id;
                    
                    $temp = [];
                    
                    foreach($records as $record) {
                        if($record["student_id"] == $student_id) {
                            $temp[] = $record;
                        }
                    }
                    
                    $records = $temp;
                }
                
                $class = $this->AcademyClass->get($class_id);
                $section = $this->Section->get($section_id);
                
                $all_ranks = array_unique($ranks);
                rsort($all_ranks);
            
                // echo "<pre>";
                // print_r($all_ranks);
                // echo "</pre>";
                
                return ["students" => $records, "ranks" => $all_ranks];
            }
            
            // Class IX to X
            else if(in_array($class_id, [10, 11])) 
            { 
            
                $students = $this->Student->get_where([
                    "class_id"                      => $class_id,
                    "section_id"                    => $section_id,
                    "student_session.promoted"      => "ANY",
                    "student_session.withdraw"      => "ANY",
                ]);
                
                
                $records = [];
                
                $ranks = [];
                
                $class_teacher = "";
                if($class_id == 10) {
                    if($section_id == 1) {
                        $class_teacher = "MS. TAPASYA";
                    }
                    
                    if($section_id == 2) {
                        $class_teacher = "MS. SMRITA";
                    }
                }
                
                if($class_id == 11) {
                    if($section_id == 1) {
                        $class_teacher = "MS. PRATIMA";
                    }
                    
                    if($section_id == 2) {
                        $class_teacher = "MS. PRASANSA";
                    }
                }
                
                foreach($students as $student) {
                    $student_evolution = $this->Marks->get_student_evolution($class_id, $exam_id, $student['id']);
                    $grades = explode(",", $student_evolution);
                    
                    $attendence = $this->ExamAttendence->get_student_attendence_percentage($class_id, $exam_id, $student['id']);
                    $remark     = $this->Remarks->get_student_remarks($class_id, $exam_id, $student['id']);
                    
                    // Get the subject_id of Subject 10
                    $row = $this->StudentSubject->get_where([
                        "academy_class_id"  => $class_id,
                        "subject_type_id"   => 24,
                        "student_id"        => $student['id'],
                    ]);
                    
                    $subject_id = $row["subject_id"];
                    $subject = $this->Subject->get($subject_id);
                    
                    $grade_subjects = [
                        "moral_science" => $this->Marks->get_student_grade($class_id, 2, 23,  $student['id']),
                        "catechism"     => $this->Marks->get_student_grade($class_id, 2, 24,  $student['id'])
                    ];
                    
                    $unit_test_marks = [
                        "english_language"      => $this->Marks->get_student_marks($class_id, 1, 2,  $student['id']),
                        "english_literature"    => $this->Marks->get_student_marks($class_id, 1, 1,  $student['id']),
                        "second_language"       => $this->Marks->get_student_marks($class_id, 1, 25,  $student['id']),
                        "mathematics"           => $this->Marks->get_student_marks($class_id, 1, 3,  $student['id']),
                        "physics"               => $this->Marks->get_student_marks($class_id, 1, 6,  $student['id']),
                        "chemistry"             => $this->Marks->get_student_marks($class_id, 1, 7,  $student['id']),
                        "biology"               => $this->Marks->get_student_marks($class_id, 1, 5, $student['id']),
                        "history"               => $this->Marks->get_student_marks($class_id, 1, 15, $student['id']),
                        "geography"             => $this->Marks->get_student_marks($class_id, 1, 10, $student['id']),
                        "subject_10_marks"      => $this->Marks->get_student_marks($class_id, 1, $subject_id, $student['id']),
                    ];
                    
                    $first_term_marks = [
                        "english_language"      => $this->Marks->get_student_marks($class_id, 2, 2,  $student['id']),
                        "english_literature"    => $this->Marks->get_student_marks($class_id, 2, 1,  $student['id']),
                        "second_language"       => $this->Marks->get_student_marks($class_id, 2, 25,  $student['id']),
                        "mathematics"           => $this->Marks->get_student_marks($class_id, 2, 3,  $student['id']),
                        "physics"               => $this->Marks->get_student_marks($class_id, 2, 6,  $student['id']),
                        "chemistry"             => $this->Marks->get_student_marks($class_id, 2, 7,  $student['id']),
                        "biology"               => $this->Marks->get_student_marks($class_id, 2, 5, $student['id']),
                        "history"               => $this->Marks->get_student_marks($class_id, 2, 15, $student['id']),
                        "geography"             => $this->Marks->get_student_marks($class_id, 2, 10, $student['id']),
                        "subject_10_marks"      => $this->Marks->get_student_marks($class_id, 2, $subject_id, $student['id']),
                    ];
                    
                    $totals = [
                        "english_language"      =>  $unit_test_marks["english_language"]    + $first_term_marks["english_language"],
                        "english_literature"    =>  $unit_test_marks["english_literature"]  + $first_term_marks["english_literature"],
                        "second_language"       =>  $unit_test_marks["second_language"]     + $first_term_marks["second_language"],
                        "mathematics"           =>  $unit_test_marks["mathematics"]         + $first_term_marks["mathematics"],
                        "physics"               =>  $unit_test_marks["physics"]             + $first_term_marks["physics"],
                        "chemistry"             =>  $unit_test_marks["chemistry"]           + $first_term_marks["chemistry"],
                        "biology"               =>  $unit_test_marks["biology"]             + $first_term_marks["biology"],
                        "history"               =>  $unit_test_marks["history"]             + $first_term_marks["history"],
                        "geography"             =>  $unit_test_marks["geography"]           + $first_term_marks["geography"],
                        "subject_10_marks"      =>  $unit_test_marks["subject_10_marks"]    + $first_term_marks["subject_10_marks"],
                    ];
                    
                    $avgs = [
                        "english"           => number_format(($totals["english_language"] + $totals["english_literature"]) / 2),
                        "pcb"               => number_format(($totals["physics"] + $totals["chemistry"] + $totals["biology"]) / 3),
                        "hg"                => number_format(($totals["history"] + $totals["geography"]) / 2),
                        "second_language"   => $totals["second_language"],
                        "mathematics"       => $totals["mathematics"],
                        "subject_10_marks"  => $totals["subject_10_marks"],
                    ];
                    
                    $total_avg = $avgs["english"] + $avgs["pcb"] + $avgs["hg"] + $avgs["second_language"] + $avgs["mathematics"] + $avgs["subject_10_marks"];
                    
                    
                    $points = [];
                    $total_point = 0;
                    $division = "";
                    
                    foreach($avgs as $key => $value) {
                        
                        $point = "";
                        
                        if($value >= 90 && $value <= 100) {
                            $point = 1;
                        }
                        elseif($value >= 80 && $value <= 89) {
                            $point = 2;
                        }
                        elseif($value >= 70 && $value <= 79) {
                            $point = 3;
                        }
                        elseif($value >= 60 && $value <= 69) {
                            $point = 4;
                        }
                        elseif($value >= 50 && $value <= 59) {
                            $point = 5;
                        }
                        elseif($value >= 46 && $value <= 49) {
                            $point = 6;
                        }
                        elseif($value == 45) {
                            $point = 7;
                        }
                        else {
                            $point = 8;
                        }
                        
                        $total_point += $point;
                        $points[$key] = $point;
                    }
                    
                    
                    if($total_point > 44) {
                        $division = "Unsatisfactory";
                    }
                    elseif($total_point >= 39 && $total_point <= 44) {
                        $division = "Pass";
                    }
                    elseif($total_point >= 31 && $total_point <= 38) {
                        $division = "3rd";
                    }
                    elseif($total_point >= 21 && $total_point <= 30) {
                        $division = "2nd";
                    }
                    elseif($total_point <= 21) {
                        $division = "1st";
                    }
                    else {
                        $division = "";
                    }
                    
                    $passed_in_english = $avgs["english"] >= 33 ? true : false;
                    $number_of_failed_subject = 0;
                    $eligible_for_rank = true;
                    $passed = true;
                    
                    if($avgs["pcb"] < 33)  {$number_of_failed_subject++;}
                    if($avgs["hg"] < 33)  {$number_of_failed_subject++;}
                    if($avgs["second_language"] < 33)  {$number_of_failed_subject++;}
                    if($avgs["mathematics"] < 33)  {$number_of_failed_subject++;}
                    if($avgs["subject_10_marks"] < 33)  {$number_of_failed_subject++;}
                    
                    
                    if(!$passed_in_english || $number_of_failed_subject >=3) {
                        $passed = false;
                        $eligible_for_rank = false;
                    }
                    else {
                        $passed = true;
                         
                        if($number_of_failed_subject == 1 || $number_of_failed_subject == 2){
                            $eligible_for_rank = false;    
                        }
                    }
                    
                    
                    if($eligible_for_rank) {
                        if(!in_array($total_avg, $ranks)) {
                            $ranks[] = $total_avg;
                        }    
                    }
                    
                    $data = [
                        "name"              => $student["f_name"] . " " . $student["m_name"] . " " . $student["l_name"],
                        "roll_no"           => $student["roll_no"],
                        "student_no"        => $student["student_no"],
                        "student_id"        => $student["id"],
                        "remarks"           => $remark,
                        "unit_test_marks"   => $unit_test_marks,
                        "first_term_marks"  => $first_term_marks,
                        "evolution_grades"  => $grades,
                        "totals"            => $totals,
                        "avgs"              => $avgs,
                        "total_avg"         => $total_avg,
                        "points"            => $points,
                        "total_point"       => $total_point,
                        "division"          => $division,
                        "attendence"        => $attendence,
                        "subject"           => $subject,
                        "passed"            => $passed,
                        "eligible_for_rank" => $eligible_for_rank,
                        "grade_subjects"    => $grade_subjects,
                        "class_teacher"     => $class_teacher
                    ];
                    
                    $records[] = $data;
                }
                
                if($report_for != "all") {
                    $student_id = $selected_student_id;
                    
                    $temp = [];
                    
                    foreach($records as $record) {
                        if($record["student_id"] == $student_id) {
                            $temp[] = $record;
                        }
                    }
                    
                    $records = $temp;
                }
                
                $class = $this->AcademyClass->get($class_id);
                $section = $this->Section->get($section_id);
                    
                rsort($ranks);
            
                return ["students" => $records, "ranks" => $ranks];
            }
            
            // Class XI Section SC
            else if(in_array($class_id, [12]) && $section_id == 3 ) 
            { 
            
                $students = $this->Student->get_where([
                    "class_id"                      => $class_id,
                    "section_id"                    => $section_id,
                    "student_session.promoted"      => "ANY",
                    "student_session.withdraw"      => "ANY",
                ]);
                
                
                $records = [];
                
                $ranks = [];
                
                $class_teacher = "";
                if($class_id == 12) {
                    // SC
                    if($section_id == 3) {
                        $class_teacher = "MS. ROSELINE";
                    }
                    
                    // AR
                    if($section_id == 4) {
                        $class_teacher = "MS. KARMA";
                    }
                }
                
                
                foreach($students as $student) {
                    $student_evolution = $this->Marks->get_student_evolution($class_id, $exam_id, $student['id']);
                    $grades = explode(",", $student_evolution);
                    
                    $attendence = $this->ExamAttendence->get_student_attendence_percentage($class_id, $exam_id, $student['id']);
                    $remark     = $this->Remarks->get_student_remarks($class_id, $exam_id, $student['id']);
                    
                    $optional_papers = [];
                    
                    // Subject 3
                    $row = $this->StudentSubject->get_where([
                        "academy_class_id"  => $class_id,
                        "subject_type_id"   => 12,
                        "student_id"        => $student['id'],
                    ]);
                    
                    if($row["subject_id"]) {
                        $subject_id = $row["subject_id"];
                        $subject = $this->Subject->get($subject_id);
                        
                        $optional_papers[] = $subject;
                    }
                    
                    // Subject 8
                    $row = $this->StudentSubject->get_where([
                        "academy_class_id"  => $class_id,
                        "subject_type_id"   => 17,
                        "student_id"        => $student['id'],
                    ]);
                    
                    if($row["subject_id"]) {
                        $subject_id = $row["subject_id"];
                        $subject = $this->Subject->get($subject_id);
                        
                        $optional_papers[] = $subject;
                    }
                    
                    
                    
                    // SC
                    if($section_id == 3) {
                        // Subject 4
                        $row = $this->StudentSubject->get_where([
                            "academy_class_id"  => $class_id,
                            "subject_type_id"   => 13,
                            "student_id"        => $student['id'],
                        ]);
                        
                        if($row["subject_id"]) {
                            $subject_id = $row["subject_id"];
                            $subject = $this->Subject->get($subject_id);
                            
                            $optional_papers[] = $subject;
                        }
                    }
                    
                    // AR
                    if($section_id == 4) {
                        // Subject 7
                        $row = $this->StudentSubject->get_where([
                            "academy_class_id"  => $class_id,
                            "subject_type_id"   => 16,
                            "student_id"        => $student['id'],
                        ]);
                        
                        if($row["subject_id"]) {
                            $subject_id = $row["subject_id"];
                            $subject = $this->Subject->get($subject_id);
                            
                            $optional_papers[] = $subject;
                        }
                    }
                   
                    
                    $grade_subjects = [
                        "moral_science" => $this->Marks->get_student_grade($class_id, 2, 23,  $student['id']),
                        "catechism"     => $this->Marks->get_student_grade($class_id, 2, 24,  $student['id'])
                    ];
                    
                    $first_term_marks = [
                        "english_language"      => $this->Marks->get_student_marks($class_id, 2, 2,  $student['id']),
                        "english_literature"    => $this->Marks->get_student_marks($class_id, 2, 1,  $student['id']),
                        "physics"               => $this->Marks->get_student_marks($class_id, 2, 6,  $student['id']),
                        "chemistry"             => $this->Marks->get_student_marks($class_id, 2, 7,  $student['id']),
                        "biology"               => $this->Marks->get_student_marks($class_id, 2, 5,  $student['id']),
                    ];
                    
                    if(count($optional_papers) == 1) {
                        $first_term_marks["optional_paper_1"] = $this->Marks->get_student_marks($class_id, 2, $optional_papers[0]["id"],  $student['id']);
                    }
                    
                    if(count($optional_papers) == 2) {
                        $first_term_marks["optional_paper_1"] = $this->Marks->get_student_marks($class_id, 2, $optional_papers[0]["id"],  $student['id']);
                        $first_term_marks["optional_paper_2"] = $this->Marks->get_student_marks($class_id, 2, $optional_papers[1]["id"],  $student['id']);
                    }
                    
                    $totals = [];
                    
                    // english_language
                    if(strtoupper($first_term_marks["english_language"]) == "AB") {
                        $totals["english_language"] = "AB";
                    }
                    else {
                        $totals["english_language"] = (int)$first_term_marks["english_language"] * 2;
                    }
                    
                    // english_literature
                    if(strtoupper($first_term_marks["english_literature"]) == "AB") {
                        $totals["english_literature"] = "AB";
                    }
                    else {
                        $totals["english_literature"] = (int)$first_term_marks["english_literature"] * 2;
                    }
                    
                    // physics
                    if(strtoupper($first_term_marks["physics"]) == "AB") {
                        $totals["physics"] = "AB";
                    }
                    else {
                        $totals["physics"] = (int)$first_term_marks["physics"] * 2;
                    }
                    
                    // chemistry
                    if(strtoupper($first_term_marks["chemistry"]) == "AB") {
                        $totals["chemistry"] = "AB";
                    }
                    else {
                        $totals["chemistry"] = (int)$first_term_marks["chemistry"] * 2;
                    }
                    
                    // biology
                    if(strtoupper($first_term_marks["biology"]) == "AB") {
                        $totals["biology"] = "AB";
                    }
                    else {
                        $totals["biology"] = (int)$first_term_marks["biology"] * 2;
                    }
                    
                    // optional_paper_1
                    if(strtoupper($first_term_marks["optional_paper_1"]) == "AB") {
                        $totals["optional_paper_1"] = "AB";
                    }
                    else {
                        $totals["optional_paper_1"] = (int)$first_term_marks["optional_paper_1"] * 2;
                    }
                    
                    // optional_paper_2
                    if(strtoupper($first_term_marks["optional_paper_2"]) == "AB") {
                        $totals["optional_paper_2"] = "AB";
                    }
                    else {
                        $totals["optional_paper_2"] = (int)$first_term_marks["optional_paper_2"] * 2;
                    }
                
                    $avgs = [];
                    
                    if($totals["english_language"] == "AB" ||  $totals["english_literature"] == "AB") {
                        $avgs["english"] = 0;
                    }
                    else {
                        $avgs["english"] =  number_format(($totals["english_language"] + $totals["english_literature"]) / 2);
                    }
                    
                    if($totals["physics"] == "AB") {
                        $avgs["physics"] = 0;    
                    }
                    else {
                        $avgs["physics"] = $totals["physics"];
                    }
                    
                    if($totals["chemistry"] == "AB") {
                        $avgs["chemistry"] = 0;    
                    }
                    else {
                        $avgs["chemistry"] = $totals["chemistry"];
                    }
                    
                    if($totals["biology"] == "AB") {
                        $avgs["biology"] = 0;    
                    }
                    else {
                        $avgs["biology"] = $totals["biology"];
                    }
                    
                    if($totals["optional_paper_1"] == "AB") {
                        $avgs["optional_paper_1"] = 0;    
                    }
                    else {
                        $avgs["optional_paper_1"] = $totals["optional_paper_1"];
                    }
                    
                    if($totals["optional_paper_2"] == "AB") {
                        $avgs["optional_paper_2"] = 0;    
                    }
                    else {
                        $avgs["optional_paper_2"] = $totals["optional_paper_2"];
                    }
                    
                    $total_avg = $avgs["english"] + $avgs["physics"] + $avgs["chemistry"] + $avgs["biology"] + $avgs["second_language"] + $avgs["mathematics"];
                    
                    if(isset($avgs["optional_paper_1"])){
                        $total_avg+=$avgs["optional_paper_1"];
                    }
                    
                    if(isset($avgs["optional_paper_2"])){
                        $total_avg+=$avgs["optional_paper_2"];
                    }
                
                    $has_ab = "NO";
                    $points = [];
                    $total_point = 0;
                    $division = "";
                    
                    foreach($avgs as $key => $value) {
                        
                        $point = "";
                        
                        if($value == "AB") {
                            $point = 8;
                            $has_ab = "YES";
                            
                        }
                        elseif($value >= 90 && $value <= 100) {
                            $point = 1;
                        }
                        elseif($value >= 80 && $value <= 89) {
                            $point = 2;
                        }
                        elseif($value >= 70 && $value <= 79) {
                            $point = 3;
                        }
                        elseif($value >= 60 && $value <= 69) {
                            $point = 4;
                        }
                        elseif($value >= 50 && $value <= 59) {
                            $point = 5;
                        }
                        elseif($value >= 46 && $value <= 49) {
                            $point = 6;
                        }
                        elseif($value == 45) {
                            $point = 7;
                        }
                        else {
                            $point = 8;
                        }
                        
                        $total_point += $point;
                        $points[$key] = $point;
                    }
                    
                    
                    if($total_point > 44) {
                        $division = "Unsatisfactory";
                    }
                    elseif($total_point >= 39 && $total_point <= 44) {
                        $division = "Pass";
                    }
                    elseif($total_point >= 31 && $total_point <= 38) {
                        $division = "3rd";
                    }
                    elseif($total_point >= 21 && $total_point <= 30) {
                        $division = "2nd";
                    }
                    elseif($total_point <= 21) {
                        $division = "1st";
                    }
                    else {
                        $division = "";
                    }
                    
                    $passed_in_english = $avgs["english"] >= 35 ? true : false;
                    $number_of_failed_subject = 0;
                    $eligible_for_rank = true;
                    $passed = true;
                    
                    if($avgs["physics"] < 35)  {$number_of_failed_subject++;}
                    if($avgs["chemistry"] < 35)  {$number_of_failed_subject++;}
                    if($avgs["biology"] < 35)  {$number_of_failed_subject++;}
                    
                    if(isset($avgs["optional_paper_1"]))
                    { 
                        if($avgs["optional_paper_1"] < 35) {$number_of_failed_subject++;}
                    }
                    
                    if(isset($avgs["optional_paper_2"]))
                    { 
                        if($avgs["optional_paper_2"] < 35) {$number_of_failed_subject++;}
                    }
                    
                    
                    if(!$passed_in_english || $number_of_failed_subject >=3) {
                        $passed = false;
                        $eligible_for_rank = false;
                    }
                    else {
                        $passed = true;
                         
                        if($number_of_failed_subject == 1 || $number_of_failed_subject == 2){
                            $eligible_for_rank = false;    
                        }
                    }
                    
                    
                    if($eligible_for_rank) {
                        if(!in_array($total_avg, $ranks)) {
                            $ranks[] = $total_avg;
                        }    
                    }
                    
                    $data = [
                        "name"              => $student["f_name"] . " " . $student["m_name"] . " " . $student["l_name"],
                        "roll_no"           => $student["roll_no"],
                        "student_no"        => $student["student_no"],
                        "student_id"        => $student["id"],
                        "remarks"           => $remark,
                        "optional_papers"   => $optional_papers,
                        "unit_test_marks"   => $unit_test_marks,
                        "first_term_marks"  => $first_term_marks,
                        "evolution_grades"  => $grades,
                        "totals"            => $totals,
                        "avgs"              => $avgs,
                        "total_avg"         => $total_avg,
                        "points"            => $points,
                        "total_point"       => $total_point,
                        "division"          => $division,
                        "attendence"        => $attendence,
                        "subject"           => $subject,
                        "passed"            => $passed,
                        "eligible_for_rank" => $eligible_for_rank,
                        "grade_subjects"    => $grade_subjects,
                        "class_teacher"     => $class_teacher,
                        "has_ab"            => $has_ab
                    ];
                    
                    $records[] = $data;
                }
                
                if($report_for != "all") {
                    $student_id = $selected_student_id;
                    
                    $temp = [];
                    
                    foreach($records as $record) {
                        if($record["student_id"] == $student_id) {
                            $temp[] = $record;
                        }
                    }
                    
                    $records = $temp;
                }
                
                $class = $this->AcademyClass->get($class_id);
                $section = $this->Section->get($section_id);
                    
                rsort($ranks);
            
                // echo "<pre>";
                // print_r($ranks);
                // echo "</pre>";
    
                return ["students" => $records, "ranks" => $ranks];
            }
            
            // Class XI Section AR
            else if(in_array($class_id, [12]) && $section_id == 4) 
            { 
            
                $students = $this->Student->get_where([
                    "class_id"                      => $class_id,
                    "section_id"                    => $section_id,
                    "student_session.promoted"      => "ANY",
                    "student_session.withdraw"      => "ANY",
                ]);
                
                
                $records = [];
                
                $ranks = [];
                
                $class_teacher = "";
                if($class_id == 12) {
                    // SC
                    if($section_id == 3) {
                        $class_teacher = "MS. ROSELINE";
                    }
                    
                    // AR
                    if($section_id == 4) {
                        $class_teacher = "MS. KARMA";
                    }
                }
                
                foreach($students as $student) {
                    $student_evolution = $this->Marks->get_student_evolution($class_id, $exam_id, $student['id']);
                    $grades = explode(",", $student_evolution);
                    
                    $attendence = $this->ExamAttendence->get_student_attendence_percentage($class_id, $exam_id, $student['id']);
                    $remark     = $this->Remarks->get_student_remarks($class_id, $exam_id, $student['id']);
                    
                    $optional_papers = [];
                    
                    // Subject 3
                    $row = $this->StudentSubject->get_where([
                        "academy_class_id"  => $class_id,
                        "subject_type_id"   => 12,
                        "student_id"        => $student['id'],
                    ]);
                    
                    if($row["subject_id"]) {
                        $subject_id = $row["subject_id"];
                        $subject = $this->Subject->get($subject_id);
                        
                        $optional_papers[] = $subject;
                    }
                    
                    // Subject 8
                    $row = $this->StudentSubject->get_where([
                        "academy_class_id"  => $class_id,
                        "subject_type_id"   => 17,
                        "student_id"        => $student['id'],
                    ]);
                    
                    if($row["subject_id"]) {
                        $subject_id = $row["subject_id"];
                        $subject = $this->Subject->get($subject_id);
                        
                        $optional_papers[] = $subject;
                    }
                    
                    
                    
                    // SC
                    if($section_id == 3) {
                        // Subject 4
                        $row = $this->StudentSubject->get_where([
                            "academy_class_id"  => $class_id,
                            "subject_type_id"   => 13,
                            "student_id"        => $student['id'],
                        ]);
                        
                        if($row["subject_id"]) {
                            $subject_id = $row["subject_id"];
                            $subject = $this->Subject->get($subject_id);
                            
                            $optional_papers[] = $subject;
                        }
                    }
                    
                    // AR
                    if($section_id == 4) {
                        // Subject 7
                        $row = $this->StudentSubject->get_where([
                            "academy_class_id"  => $class_id,
                            "subject_type_id"   => 16,
                            "student_id"        => $student['id'],
                        ]);
                        
                        if($row["subject_id"]) {
                            $subject_id = $row["subject_id"];
                            $subject = $this->Subject->get($subject_id);
                            
                            $optional_papers[] = $subject;
                        }
                    }
                   
                    
                    $grade_subjects = [
                        "moral_science" => $this->Marks->get_student_grade($class_id, 2, 23,  $student['id']),
                        "catechism"     => $this->Marks->get_student_grade($class_id, 2, 24,  $student['id'])
                    ];
                    
                    $first_term_marks = [
                        "english_language"      => $this->Marks->get_student_marks($class_id, 2, 2,  $student['id']),
                        "english_literature"    => $this->Marks->get_student_marks($class_id, 2, 1,  $student['id']),
                        "history"               => $this->Marks->get_student_marks($class_id, 2, 9,  $student['id']),
                        "political_science"     => $this->Marks->get_student_marks($class_id, 2, 21,  $student['id']),
                        "sociology"             => $this->Marks->get_student_marks($class_id, 2, 29,  $student['id']),
                    ];
                    
                    if(count($optional_papers) == 1) {
                        $first_term_marks["optional_paper_1"] = $this->Marks->get_student_marks($class_id, 2, $optional_papers[0]["id"],  $student['id']);
                    }
                    
                    if(count($optional_papers) == 2) {
                        $first_term_marks["optional_paper_1"] = $this->Marks->get_student_marks($class_id, 2, $optional_papers[0]["id"],  $student['id']);
                    
                        $first_term_marks["optional_paper_2"] = $this->Marks->get_student_marks($class_id, 2, $optional_papers[1]["id"],  $student['id']);
                    }
                    
                    $totals = [];
                    
                    // english_language
                    if(strtoupper($first_term_marks["english_language"]) == "AB") {
                        $totals["english_language"] = "AB";
                    }
                    else {
                        $totals["english_language"] = (int)$first_term_marks["english_language"] * 2;
                    }
                    
                    // english_literature
                    if(strtoupper($first_term_marks["english_literature"]) == "AB") {
                        $totals["english_literature"] = "AB";
                    }
                    else {
                        $totals["english_literature"] = (int)$first_term_marks["english_literature"] * 2;
                    }
                    
                    // history
                    if(strtoupper($first_term_marks["history"]) == "AB") {
                        $totals["history"] = "AB";
                    }
                    else {
                        $totals["history"] = (int)$first_term_marks["history"] * 2;
                    }
                    
                    // political_science
                    if(strtoupper($first_term_marks["political_science"]) == "AB") {
                        $totals["political_science"] = "AB";
                    }
                    else {
                        $totals["political_science"] = (int)$first_term_marks["political_science"] * 2;
                    }
                    
                    // sociology
                    if(strtoupper($first_term_marks["sociology"]) == "AB") {
                        $totals["sociology"] = "AB";
                    }
                    else {
                        $totals["sociology"] = (int)$first_term_marks["sociology"] * 2;
                    }
                    
                    // optional_paper_1
                    if(strtoupper($first_term_marks["optional_paper_1"]) == "AB") {
                        $totals["optional_paper_1"] = "AB";
                    }
                    else {
                        $totals["optional_paper_1"] = (int)$first_term_marks["optional_paper_1"] * 2;
                    }
                    
                    // optional_paper_2
                    if(strtoupper($first_term_marks["optional_paper_2"]) == "AB") {
                        $totals["optional_paper_2"] = "AB";
                    }
                    else {
                        $totals["optional_paper_2"] = (int)$first_term_marks["optional_paper_2"] * 2;
                    }
                
                    $avgs = [];
                    
                    if($totals["english_language"] == "AB" ||  $totals["english_literature"] == "AB") {
                        $avgs["english"] = 0;
                    }
                    else {
                        $avgs["english"] =  number_format(($totals["english_language"] + $totals["english_literature"]) / 2);
                    }
                    
                    if($totals["history"] == "AB") {
                        $avgs["history"] = 0;    
                    }
                    else {
                        $avgs["history"] = $totals["history"];
                    }
                    
                    if($totals["political_science"] == "AB") {
                        $avgs["political_science"] = 0;    
                    }
                    else {
                        $avgs["political_science"] = $totals["political_science"];
                    }
                    
                    if($totals["sociology"] == "AB") {
                        $avgs["sociology"] = 0;    
                    }
                    else {
                        $avgs["sociology"] = $totals["sociology"];
                    }
                    
                    if($totals["optional_paper_1"] == "AB") {
                        $avgs["optional_paper_1"] = 0;    
                    }
                    else {
                        $avgs["optional_paper_1"] = $totals["optional_paper_1"];
                    }
                    
                    if($totals["optional_paper_2"] == "AB") {
                        $avgs["optional_paper_2"] = 0;    
                    }
                    else {
                        $avgs["optional_paper_2"] = $totals["optional_paper_2"];
                    }
                    
                    
                    // if(isset($unit_test_marks["optional_paper_1"])) {
                    //     $totals["optional_paper_1"] = $unit_test_marks["optional_paper_1"] + $first_term_marks["optional_paper_1"];
                    // }
                    
                    // if(isset($unit_test_marks["optional_paper_2"])) {
                    //     $totals["optional_paper_2"] = $unit_test_marks["optional_paper_2"] + $first_term_marks["optional_paper_2"];
                    // }
                    
                    // $avgs = [
                    //     "english"           => number_format(($totals["english_language"] + $totals["english_literature"]) / 2),
                    //     "history"           => $totals["history"],
                    //     "political_science" => $totals["political_science"],
                    //     "sociology"         => $totals["sociology"],
                    // ];
                    
                    // if(isset($totals["optional_paper_1"])) { 
                    //     $avgs["optional_paper_1"] = $totals["optional_paper_1"];
                    // }
                    
                    // if(isset($totals["optional_paper_2"])) { 
                    //     $avgs["optional_paper_2"] = $totals["optional_paper_2"];
                    // }
                    
                    $total_avg = $avgs["english"] + $avgs["history"] + $avgs["political_science"] + $avgs["sociology"] + $avgs["second_language"] + $avgs["mathematics"];
                    
                    if(isset($avgs["optional_paper_1"])){
                        $total_avg+=$avgs["optional_paper_1"];
                    }
                    
                    if(isset($avgs["optional_paper_2"])){
                        $total_avg+=$avgs["optional_paper_2"];
                    }
                
                    $has_ab = "NO";
                    $points = [];
                    $total_point = 0;
                    $division = "";
                    
                    foreach($avgs as $key => $value) {
                        
                        $point = "";
                        
                        if($value == "AB") {
                            $point = 8;
                            $has_ab = "YES";
                        }
                        elseif($value >= 90 && $value <= 100) {
                            $point = 1;
                        }
                        elseif($value >= 80 && $value <= 89) {
                            $point = 2;
                        }
                        elseif($value >= 70 && $value <= 79) {
                            $point = 3;
                        }
                        elseif($value >= 60 && $value <= 69) {
                            $point = 4;
                        }
                        elseif($value >= 50 && $value <= 59) {
                            $point = 5;
                        }
                        elseif($value >= 46 && $value <= 49) {
                            $point = 6;
                        }
                        elseif($value == 45) {
                            $point = 7;
                        }
                        else {
                            $point = 8;
                        }
                        
                        $total_point += $point;
                        $points[$key] = $point;
                    }
                    
                    
                    if($total_point > 44) {
                        $division = "Unsatisfactory";
                    }
                    elseif($total_point >= 39 && $total_point <= 44) {
                        $division = "Pass";
                    }
                    elseif($total_point >= 31 && $total_point <= 38) {
                        $division = "3rd";
                    }
                    elseif($total_point >= 21 && $total_point <= 30) {
                        $division = "2nd";
                    }
                    elseif($total_point <= 21) {
                        $division = "1st";
                    }
                    else {
                        $division = "";
                    }
                    
                    $passed_in_english = $avgs["english"] >= 35 ? true : false;
                    $number_of_failed_subject = 0;
                    $eligible_for_rank = true;
                    $passed = true;
                    
                    if($avgs["history"] < 35)  {$number_of_failed_subject++;}
                    if($avgs["political_science"] < 35)  {$number_of_failed_subject++;}
                    if($avgs["sociology"] < 35)  {$number_of_failed_subject++;}
                    
                    if(isset($avgs["optional_paper_1"]))
                    { 
                        if($avgs["optional_paper_1"] < 35) {$number_of_failed_subject++;}
                    }
                    
                    if(isset($avgs["optional_paper_2"]))
                    { 
                        if($avgs["optional_paper_2"] < 35) {$number_of_failed_subject++;}
                    }
                    
                    
                    if(!$passed_in_english || $number_of_failed_subject >=3) {
                        $passed = false;
                        $eligible_for_rank = false;
                    }
                    else {
                        $passed = true;
                         
                        if($number_of_failed_subject == 1 || $number_of_failed_subject == 2){
                            $eligible_for_rank = false;    
                        }
                    }
                    
                    
                    if($eligible_for_rank) {
                        if(!in_array($total_avg, $ranks)) {
                            $ranks[] = $total_avg;
                        }    
                    }
                    
                    $data = [
                        "name"              => $student["f_name"] . " " . $student["m_name"] . " " . $student["l_name"],
                        "roll_no"           => $student["roll_no"],
                        "student_no"        => $student["student_no"],
                        "student_id"        => $student["id"],
                        "remarks"           => $remark,
                        "optional_papers"   => $optional_papers,
                        "unit_test_marks"   => $unit_test_marks,
                        "first_term_marks"  => $first_term_marks,
                        "evolution_grades"  => $grades,
                        "totals"            => $totals,
                        "avgs"              => $avgs,
                        "total_avg"         => $total_avg,
                        "points"            => $points,
                        "total_point"       => $total_point,
                        "division"          => $division,
                        "attendence"        => $attendence,
                        "subject"           => $subject,
                        "passed"            => $passed,
                        "eligible_for_rank" => $eligible_for_rank,
                        "grade_subjects"    => $grade_subjects,
                        "class_teacher"     => $class_teacher,
                        "has_ab"            => $has_ab
                    ];
                    
                    $records[] = $data;
                }
                
                if($report_for != "all") {
                    $student_id = $selected_student_id;
                    
                    $temp = [];
                    
                    foreach($records as $record) {
                        if($record["student_id"] == $student_id) {
                            $temp[] = $record;
                        }
                    }
                    
                    $records = $temp;
                }
                
                $class = $this->AcademyClass->get($class_id);
                $section = $this->Section->get($section_id);
                    
                rsort($ranks);
            
                // echo "<pre>";
                // print_r($ranks);
                // echo "</pre>";
    
                return ["students" => $records, "ranks" => $ranks];
            }


            // Class XII Section SC
            else if(in_array($class_id, [13]) && $section_id == 3 ) 
            { 
            
                $students = $this->Student->get_where([
                    "class_id"                      => $class_id,
                    "section_id"                    => $section_id,
                    "student_session.promoted"      => "ANY",
                    "student_session.withdraw"      => "ANY",
                ]);
                
                $records = [];
                
                $ranks = [];
                
                $class_teacher = "";
                if($class_id == 12) {
                    // SC
                    if($section_id == 3) {
                        $class_teacher = "MS. ROSELINE";
                    }
                    
                    // AR
                    if($section_id == 4) {
                        $class_teacher = "MS. KARMA";
                    }
                }
                
                if($class_id == 13) {
                    // SC
                    if($section_id == 3) {
                        $class_teacher = "MS. ANITA";
                    }
                    
                    // AR
                    if($section_id == 4) {
                        $class_teacher = "MS. ONGMU";
                    }
                }
                
                foreach($students as $student) {
                    $student_evolution = $this->Marks->get_student_evolution($class_id, $exam_id, $student['id']);
                    $grades = explode(",", $student_evolution);
                    
                    $attendence = $this->ExamAttendence->get_student_attendence_percentage($class_id, $exam_id, $student['id']);
                    $remark     = $this->Remarks->get_student_remarks($class_id, $exam_id, $student['id']);
                    
                    $optional_papers = [];
                    
                    // Subject 3
                    $row = $this->StudentSubject->get_where([
                        "academy_class_id"  => $class_id,
                        "subject_type_id"   => 12,
                        "student_id"        => $student['id'],
                    ]);
                    
                    if($row["subject_id"]) {
                        $subject_id = $row["subject_id"];
                        $subject = $this->Subject->get($subject_id);
                        
                        $optional_papers[] = $subject;
                    }
                    
                    // Subject 8
                    $row = $this->StudentSubject->get_where([
                        "academy_class_id"  => $class_id,
                        "subject_type_id"   => 17,
                        "student_id"        => $student['id'],
                    ]);
                    
                    if($row["subject_id"]) {
                        $subject_id = $row["subject_id"];
                        $subject = $this->Subject->get($subject_id);
                        
                        $optional_papers[] = $subject;
                    }
                    
                    
                    
                    // SC
                    if($section_id == 3) {
                        // Subject 4
                        $row = $this->StudentSubject->get_where([
                            "academy_class_id"  => $class_id,
                            "subject_type_id"   => 13,
                            "student_id"        => $student['id'],
                        ]);
                        
                        if($row["subject_id"]) {
                            $subject_id = $row["subject_id"];
                            $subject = $this->Subject->get($subject_id);
                            
                            $optional_papers[] = $subject;
                        }
                    }
                    
                    // AR
                    if($section_id == 4) {
                        // Subject 7
                        $row = $this->StudentSubject->get_where([
                            "academy_class_id"  => $class_id,
                            "subject_type_id"   => 16,
                            "student_id"        => $student['id'],
                        ]);
                        
                        if($row["subject_id"]) {
                            $subject_id = $row["subject_id"];
                            $subject = $this->Subject->get($subject_id);
                            
                            $optional_papers[] = $subject;
                        }
                    }
                   
                    
                    $grade_subjects = [
                        "moral_science" => $this->Marks->get_student_grade($class_id, 2, 23,  $student['id']),
                        "catechism"     => $this->Marks->get_student_grade($class_id, 2, 24,  $student['id'])
                    ];
                    
                    $unit_test_marks = [
                        "english_language"      => $this->Marks->get_student_marks($class_id, 1, 2,  $student['id']),
                        "english_literature"    => $this->Marks->get_student_marks($class_id, 1, 1,  $student['id']),
                        "physics"               => $this->Marks->get_student_marks($class_id, 1, 6,  $student['id']),
                        "chemistry"             => $this->Marks->get_student_marks($class_id, 1, 7,  $student['id']),
                        "biology"               => $this->Marks->get_student_marks($class_id, 1, 5,  $student['id']),
                    ];
                    
                    $first_term_marks = [
                        "english_language"      => $this->Marks->get_student_marks($class_id, 2, 2,  $student['id']),
                        "english_literature"    => $this->Marks->get_student_marks($class_id, 2, 1,  $student['id']),
                        "physics"               => $this->Marks->get_student_marks($class_id, 2, 6,  $student['id']),
                        "chemistry"             => $this->Marks->get_student_marks($class_id, 2, 7,  $student['id']),
                        "biology"               => $this->Marks->get_student_marks($class_id, 2, 5,  $student['id']),
                    ];
                    
                    if(count($optional_papers) == 1) {
                        $unit_test_marks["optional_paper_1"] = $this->Marks->get_student_marks($class_id, 1, $optional_papers[0]["id"],  $student['id']);
                        $first_term_marks["optional_paper_1"] = $this->Marks->get_student_marks($class_id, 2, $optional_papers[0]["id"],  $student['id']);
                    }
                    
                    if(count($optional_papers) == 2) {
                        $unit_test_marks["optional_paper_1"] = $this->Marks->get_student_marks($class_id, 1, $optional_papers[0]["id"],  $student['id']);
                        $first_term_marks["optional_paper_1"] = $this->Marks->get_student_marks($class_id, 2, $optional_papers[0]["id"],  $student['id']);
                        
                        $unit_test_marks["optional_paper_2"] = $this->Marks->get_student_marks($class_id, 1, $optional_papers[1]["id"],  $student['id']);
                        $first_term_marks["optional_paper_2"] = $this->Marks->get_student_marks($class_id, 2, $optional_papers[1]["id"],  $student['id']);
                    }
                    
                    $totals = [
                        "english_language"      =>  $unit_test_marks["english_language"]    + $first_term_marks["english_language"],
                        "english_literature"    =>  $unit_test_marks["english_literature"]  + $first_term_marks["english_literature"],
                        "physics"               =>  $unit_test_marks["physics"]             + $first_term_marks["physics"],
                        "chemistry"             =>  $unit_test_marks["chemistry"]           + $first_term_marks["chemistry"],
                        "biology"               =>  $unit_test_marks["biology"]             + $first_term_marks["biology"]
                    ];
                    
                    if(isset($unit_test_marks["optional_paper_1"])) {
                        $totals["optional_paper_1"] = $unit_test_marks["optional_paper_1"] + $first_term_marks["optional_paper_1"];
                    }
                    
                    if(isset($unit_test_marks["optional_paper_2"])) {
                        $totals["optional_paper_2"] = $unit_test_marks["optional_paper_2"] + $first_term_marks["optional_paper_2"];
                    }
                    
                    $avgs = [
                        "english"           => number_format(($totals["english_language"] + $totals["english_literature"]) / 2),
                        "physics"           => $totals["physics"],
                        "chemistry"         => $totals["chemistry"],
                        "biology"           => $totals["biology"],
                    ];
                    
                    if(isset($totals["optional_paper_1"])) { 
                        $avgs["optional_paper_1"] = $totals["optional_paper_1"];
                    }
                    
                    if(isset($totals["optional_paper_2"])) { 
                        $avgs["optional_paper_2"] = $totals["optional_paper_2"];
                    }
                    
                    $total_avg = $avgs["english"] + $avgs["physics"] + $avgs["chemistry"] + $avgs["biology"] + $avgs["second_language"] + $avgs["mathematics"];
                    
                    if(isset($avgs["optional_paper_1"])){
                        $total_avg+=$avgs["optional_paper_1"];
                    }
                    
                    if(isset($avgs["optional_paper_2"])){
                        $total_avg+=$avgs["optional_paper_2"];
                    }
                
                    $points = [];
                    $total_point = 0;
                    $division = "";
                    
                    foreach($avgs as $key => $value) {
                        
                        $point = "";
                        
                        if($value >= 90 && $value <= 100) {
                            $point = 1;
                        }
                        elseif($value >= 80 && $value <= 89) {
                            $point = 2;
                        }
                        elseif($value >= 70 && $value <= 79) {
                            $point = 3;
                        }
                        elseif($value >= 60 && $value <= 69) {
                            $point = 4;
                        }
                        elseif($value >= 50 && $value <= 59) {
                            $point = 5;
                        }
                        elseif($value >= 46 && $value <= 49) {
                            $point = 6;
                        }
                        elseif($value == 45) {
                            $point = 7;
                        }
                        else {
                            $point = 8;
                        }
                        
                        $total_point += $point;
                        $points[$key] = $point;
                    }
                    
                    
                    if($total_point > 44) {
                        $division = "Unsatisfactory";
                    }
                    elseif($total_point >= 39 && $total_point <= 44) {
                        $division = "Pass";
                    }
                    elseif($total_point >= 31 && $total_point <= 38) {
                        $division = "3rd";
                    }
                    elseif($total_point >= 21 && $total_point <= 30) {
                        $division = "2nd";
                    }
                    elseif($total_point <= 21) {
                        $division = "1st";
                    }
                    else {
                        $division = "";
                    }
                    
                    $passed_in_english = $avgs["english"] >= 35 ? true : false;
                    $number_of_failed_subject = 0;
                    $eligible_for_rank = true;
                    $passed = true;
                    
                    if($avgs["physics"] < 35)  {$number_of_failed_subject++;}
                    if($avgs["chemistry"] < 35)  {$number_of_failed_subject++;}
                    if($avgs["biology"] < 35)  {$number_of_failed_subject++;}
                    
                    if(isset($avgs["optional_paper_1"]))
                    { 
                        if($avgs["optional_paper_1"] < 35) {$number_of_failed_subject++;}
                    }
                    
                    if(isset($avgs["optional_paper_2"]))
                    { 
                        if($avgs["optional_paper_2"] < 35) {$number_of_failed_subject++;}
                    }
                    
                    
                    if(!$passed_in_english || $number_of_failed_subject >=3) {
                        $passed = false;
                        $eligible_for_rank = false;
                    }
                    else {
                        $passed = true;
                         
                        if($number_of_failed_subject == 1 || $number_of_failed_subject == 2){
                            $eligible_for_rank = false;    
                        }
                    }
                    
                    
                    if($eligible_for_rank) {
                        if(!in_array($total_avg, $ranks)) {
                            $ranks[] = $total_avg;
                        }    
                    }
                    
                    $data = [
                        "name"              => $student["f_name"] . " " . $student["m_name"] . " " . $student["l_name"],
                        "roll_no"           => $student["roll_no"],
                        "student_no"        => $student["student_no"],
                        "student_id"        => $student["id"],
                        "remarks"           => $remark,
                        "optional_papers"   => $optional_papers,
                        "unit_test_marks"   => $unit_test_marks,
                        "first_term_marks"  => $first_term_marks,
                        "evolution_grades"  => $grades,
                        "totals"            => $totals,
                        "avgs"              => $avgs,
                        "total_avg"         => $total_avg,
                        "points"            => $points,
                        "total_point"       => $total_point,
                        "division"          => $division,
                        "attendence"        => $attendence,
                        "subject"           => $subject,
                        "passed"            => $passed,
                        "eligible_for_rank" => $eligible_for_rank,
                        "grade_subjects"    => $grade_subjects,
                        "class_teacher"     => $class_teacher,
                    ];
                    
                    $records[] = $data;
                }
                
                if($report_for != "all") {
                    $student_id = $selected_student_id;
                    
                    $temp = [];
                    
                    foreach($records as $record) {
                        if($record["student_id"] == $student_id) {
                            $temp[] = $record;
                        }
                    }
                    
                    $records = $temp;
                }
                
                $class = $this->AcademyClass->get($class_id);
                $section = $this->Section->get($section_id);
                    
                rsort($ranks);
            
                // echo "<pre>";
                // print_r($ranks);
                // echo "</pre>";
    
                return ["students" => $records, "ranks" => $ranks];
            }
            
            // Class XII Section AR
            else if(in_array($class_id, [13]) && $section_id == 4) 
            { 
            
                $students = $this->Student->get_where([
                    "class_id"                      => $class_id,
                    "section_id"                    => $section_id,
                    "student_session.promoted"      => "ANY",
                    "student_session.withdraw"      => "ANY",
                ]);
                
                
                $records = [];
                
                $ranks = [];
                
                $class_teacher = "";
                if($class_id == 12) {
                    // SC
                    if($section_id == 3) {
                        $class_teacher = "MS. ROSELINE";
                    }
                    
                    // AR
                    if($section_id == 4) {
                        $class_teacher = "MS. KARMA";
                    }
                }
                
                if($class_id == 13) {
                    // SC
                    if($section_id == 3) {
                        $class_teacher = "MS. ANITA";
                    }
                    
                    // AR
                    if($section_id == 4) {
                        $class_teacher = "MS. ONGMU";
                    }
                }
                
                foreach($students as $student) {
                    $student_evolution = $this->Marks->get_student_evolution($class_id, $exam_id, $student['id']);
                    $grades = explode(",", $student_evolution);
                    
                    $attendence = $this->ExamAttendence->get_student_attendence_percentage($class_id, $exam_id, $student['id']);
                    $remark     = $this->Remarks->get_student_remarks($class_id, $exam_id, $student['id']);
                    
                    $optional_papers = [];
                    
                    // Subject 3
                    $row = $this->StudentSubject->get_where([
                        "academy_class_id"  => $class_id,
                        "subject_type_id"   => 12,
                        "student_id"        => $student['id'],
                    ]);
                    
                    if($row["subject_id"]) {
                        $subject_id = $row["subject_id"];
                        $subject = $this->Subject->get($subject_id);
                        
                        $optional_papers[] = $subject;
                    }
                    
                    // Subject 8
                    $row = $this->StudentSubject->get_where([
                        "academy_class_id"  => $class_id,
                        "subject_type_id"   => 17,
                        "student_id"        => $student['id'],
                    ]);
                    
                    if($row["subject_id"]) {
                        $subject_id = $row["subject_id"];
                        $subject = $this->Subject->get($subject_id);
                        
                        $optional_papers[] = $subject;
                    }
                    
                    
                    
                    // SC
                    if($section_id == 3) {
                        // Subject 4
                        $row = $this->StudentSubject->get_where([
                            "academy_class_id"  => $class_id,
                            "subject_type_id"   => 13,
                            "student_id"        => $student['id'],
                        ]);
                        
                        if($row["subject_id"]) {
                            $subject_id = $row["subject_id"];
                            $subject = $this->Subject->get($subject_id);
                            
                            $optional_papers[] = $subject;
                        }
                    }
                    
                    // AR
                    if($section_id == 4) {
                        // Subject 7
                        $row = $this->StudentSubject->get_where([
                            "academy_class_id"  => $class_id,
                            "subject_type_id"   => 16,
                            "student_id"        => $student['id'],
                        ]);
                        
                        if($row["subject_id"]) {
                            $subject_id = $row["subject_id"];
                            $subject = $this->Subject->get($subject_id);
                            
                            $optional_papers[] = $subject;
                        }
                    }
                   
                    
                    $grade_subjects = [
                        "moral_science" => $this->Marks->get_student_grade($class_id, 2, 23,  $student['id']),
                        "catechism"     => $this->Marks->get_student_grade($class_id, 2, 24,  $student['id'])
                    ];
                    
                    $unit_test_marks = [
                        "english_language"      => $this->Marks->get_student_marks($class_id, 1, 2,  $student['id']),
                        "english_literature"    => $this->Marks->get_student_marks($class_id, 1, 1,  $student['id']),
                        "history"               => $this->Marks->get_student_marks($class_id, 1, 9,  $student['id']),
                        "political_science"     => $this->Marks->get_student_marks($class_id, 1, 21,  $student['id']),
                        "sociology"             => $this->Marks->get_student_marks($class_id, 1, 29,  $student['id']),
                    ];
                    
                    $first_term_marks = [
                        "english_language"      => $this->Marks->get_student_marks($class_id, 2, 2,  $student['id']),
                        "english_literature"    => $this->Marks->get_student_marks($class_id, 2, 1,  $student['id']),
                        "history"               => $this->Marks->get_student_marks($class_id, 2, 9,  $student['id']),
                        "political_science"     => $this->Marks->get_student_marks($class_id, 2, 21,  $student['id']),
                        "sociology"             => $this->Marks->get_student_marks($class_id, 2, 29,  $student['id']),
                    ];
                    
                    if(count($optional_papers) == 1) {
                        $unit_test_marks["optional_paper_1"] = $this->Marks->get_student_marks($class_id, 1, $optional_papers[0]["id"],  $student['id']);
                        $first_term_marks["optional_paper_1"] = $this->Marks->get_student_marks($class_id, 2, $optional_papers[0]["id"],  $student['id']);
                    }
                    
                    if(count($optional_papers) == 2) {
                        $unit_test_marks["optional_paper_1"] = $this->Marks->get_student_marks($class_id, 1, $optional_papers[0]["id"],  $student['id']);
                        $first_term_marks["optional_paper_1"] = $this->Marks->get_student_marks($class_id, 2, $optional_papers[0]["id"],  $student['id']);
                        
                        $unit_test_marks["optional_paper_2"] = $this->Marks->get_student_marks($class_id, 1, $optional_papers[1]["id"],  $student['id']);
                        $first_term_marks["optional_paper_2"] = $this->Marks->get_student_marks($class_id, 2, $optional_papers[1]["id"],  $student['id']);
                    }
                    
                    $totals = [
                        "english_language"      =>  $unit_test_marks["english_language"]    + $first_term_marks["english_language"],
                        "english_literature"    =>  $unit_test_marks["english_literature"]  + $first_term_marks["english_literature"],
                        "history"               =>  $unit_test_marks["history"]             + $first_term_marks["history"],
                        "political_science"     =>  $unit_test_marks["political_science"]           + $first_term_marks["political_science"],
                        "sociology"             =>  $unit_test_marks["sociology"]             + $first_term_marks["sociology"]
                    ];
                    
                    if(isset($unit_test_marks["optional_paper_1"])) {
                        $totals["optional_paper_1"] = $unit_test_marks["optional_paper_1"] + $first_term_marks["optional_paper_1"];
                    }
                    
                    if(isset($unit_test_marks["optional_paper_2"])) {
                        $totals["optional_paper_2"] = $unit_test_marks["optional_paper_2"] + $first_term_marks["optional_paper_2"];
                    }
                    
                    $avgs = [
                        "english"           => number_format(($totals["english_language"] + $totals["english_literature"]) / 2),
                        "history"           => $totals["history"],
                        "political_science" => $totals["political_science"],
                        "sociology"         => $totals["sociology"],
                    ];
                    
                    if(isset($totals["optional_paper_1"])) { 
                        $avgs["optional_paper_1"] = $totals["optional_paper_1"];
                    }
                    
                    if(isset($totals["optional_paper_2"])) { 
                        $avgs["optional_paper_2"] = $totals["optional_paper_2"];
                    }
                    
                    $total_avg = $avgs["english"] + $avgs["history"] + $avgs["political_science"] + $avgs["sociology"] + $avgs["second_language"] + $avgs["mathematics"];
                    
                    if(isset($avgs["optional_paper_1"])){
                        $total_avg+=$avgs["optional_paper_1"];
                    }
                    
                    if(isset($avgs["optional_paper_2"])){
                        $total_avg+=$avgs["optional_paper_2"];
                    }
                
                    $points = [];
                    $total_point = 0;
                    $division = "";
                    
                    foreach($avgs as $key => $value) {
                        
                        $point = "";
                        
                        if($value >= 90 && $value <= 100) {
                            $point = 1;
                        }
                        elseif($value >= 80 && $value <= 89) {
                            $point = 2;
                        }
                        elseif($value >= 70 && $value <= 79) {
                            $point = 3;
                        }
                        elseif($value >= 60 && $value <= 69) {
                            $point = 4;
                        }
                        elseif($value >= 50 && $value <= 59) {
                            $point = 5;
                        }
                        elseif($value >= 46 && $value <= 49) {
                            $point = 6;
                        }
                        elseif($value == 45) {
                            $point = 7;
                        }
                        else {
                            $point = 8;
                        }
                        
                        $total_point += $point;
                        $points[$key] = $point;
                    }
                    
                    
                    if($total_point > 44) {
                        $division = "Unsatisfactory";
                    }
                    elseif($total_point >= 39 && $total_point <= 44) {
                        $division = "Pass";
                    }
                    elseif($total_point >= 31 && $total_point <= 38) {
                        $division = "3rd";
                    }
                    elseif($total_point >= 21 && $total_point <= 30) {
                        $division = "2nd";
                    }
                    elseif($total_point <= 21) {
                        $division = "1st";
                    }
                    else {
                        $division = "";
                    }
                    
                    $passed_in_english = $avgs["english"] >= 35 ? true : false;
                    $number_of_failed_subject = 0;
                    $eligible_for_rank = true;
                    $passed = true;
                    
                    if($avgs["history"] < 35)  {$number_of_failed_subject++;}
                    if($avgs["political_science"] < 35)  {$number_of_failed_subject++;}
                    if($avgs["sociology"] < 35)  {$number_of_failed_subject++;}
                    
                    if(isset($avgs["optional_paper_1"]))
                    { 
                        if($avgs["optional_paper_1"] < 35) {$number_of_failed_subject++;}
                    }
                    
                    if(isset($avgs["optional_paper_2"]))
                    { 
                        if($avgs["optional_paper_2"] < 35) {$number_of_failed_subject++;}
                    }
                    
                    
                    if(!$passed_in_english || $number_of_failed_subject >=3) {
                        $passed = false;
                        $eligible_for_rank = false;
                    }
                    else {
                        $passed = true;
                         
                        if($number_of_failed_subject == 1 || $number_of_failed_subject == 2){
                            $eligible_for_rank = false;    
                        }
                    }
                    
                    
                    if($eligible_for_rank) {
                        if(!in_array($total_avg, $ranks)) {
                            $ranks[] = $total_avg;
                        }    
                    }
                    
                    $data = [
                        "name"              => $student["f_name"] . " " . $student["m_name"] . " " . $student["l_name"],
                        "roll_no"           => $student["roll_no"],
                        "student_no"        => $student["student_no"],
                        "student_id"        => $student["id"],
                        "remarks"           => $remark,
                        "optional_papers"   => $optional_papers,
                        "unit_test_marks"   => $unit_test_marks,
                        "first_term_marks"  => $first_term_marks,
                        "evolution_grades"  => $grades,
                        "totals"            => $totals,
                        "avgs"              => $avgs,
                        "total_avg"         => $total_avg,
                        "points"            => $points,
                        "total_point"       => $total_point,
                        "division"          => $division,
                        "attendence"        => $attendence,
                        "subject"           => $subject,
                        "passed"            => $passed,
                        "eligible_for_rank" => $eligible_for_rank,
                        "grade_subjects"    => $grade_subjects,
                        "class_teacher"     => $class_teacher,
                    ];
                    
                    $records[] = $data;
                }
                
                if($report_for != "all") {
                    $student_id = $selected_student_id;
                    
                    $temp = [];
                    
                    foreach($records as $record) {
                        if($record["student_id"] == $student_id) {
                            $temp[] = $record;
                        }
                    }
                    
                    $records = $temp;
                }
                
                $class = $this->AcademyClass->get($class_id);
                $section = $this->Section->get($section_id);
                    
                rsort($ranks);
            
                // echo "<pre>";
                // print_r($ranks);
                // echo "</pre>";
                    
                return ["students" => $records, "ranks" => $ranks];
            }
        }
        

        public function get_annual_term_result($class_id, $section_id, $exam_id, $report_for = "all", $selected_student_id = NULL) {
           
            // Class I to II
            if(in_array($class_id, [2, 3])) 
            { 
            
                $students = $this->Student->get_where([
                    "class_id"                      => $class_id,
                    "section_id"                    => $section_id,
                    "student_session.promoted"      => "ANY",
                    "student_session.withdraw"      => "ANY",
                ]);
                
                $records = [];
                $ranks = [];
                $rank_eligible_students = [];
                
                $class_teacher = "";
                if($class_id == 2) {
                    if($section_id == 1) {
                        $class_teacher = "MS. JEENY";
                    }
                    
                    if($section_id == 2) {
                        $class_teacher = "MS. KALPANA";
                    }
                }
                
                if($class_id == 3) {
                    if($section_id == 1) {
                        $class_teacher = "MS. TULSI";
                    }
                    
                    if($section_id == 2) {
                        $class_teacher = "MS. LIPIKA";
                    }
                }
                
                foreach($students as $student) {
                    $student_evolution = $this->Marks->get_student_evolution($class_id, $exam_id, $student['id']);
                    $grades = explode(",", $student_evolution);
                    
                    $attendence = $this->ExamAttendence->get_student_attendence_percentage($class_id, $exam_id, $student['id']);
                    $remark     = $this->Remarks->get_student_remarks($class_id, $exam_id, $student['id']);
                    $is_absent  = false; 
                  
                    // Grade Subjects First TERM
                    $first_term_grade_subjects = [
                        "gk"            => $this->Marks->get_student_grade($class_id, 2, 22,  $student['id']), 
                        "moral_science" => $this->Marks->get_student_grade($class_id, 2, 23,  $student['id']),
                        "catechism"     => $this->Marks->get_student_grade($class_id, 2, 24,  $student['id']),
                        "handwriting"   => $this->Marks->get_student_grade($class_id, 2, 27,  $student['id']),
                        "drawing"       => $this->Marks->get_student_grade($class_id, 2, 30,  $student['id'])
                    ];

                    // Grade Subjects Annual TERM
                    $annual_term_grade_subjects = [
                        "gk"            => $this->Marks->get_student_grade($class_id, 4, 22,  $student['id']), 
                        "moral_science" => $this->Marks->get_student_grade($class_id, 4, 23,  $student['id']),
                        "catechism"     => $this->Marks->get_student_grade($class_id, 4, 24,  $student['id']),
                        "handwriting"   => $this->Marks->get_student_grade($class_id, 4, 27,  $student['id']),
                        "drawing"       => $this->Marks->get_student_grade($class_id, 4, 30,  $student['id'])
                    ];
                    
                    // Marks Subject First UNIT TEST
                    $first_unit_test_marks = [
                        "english_language"      => $this->Marks->get_student_marks($class_id, 1, 2,  $student['id']),
                        "english_literature"    => $this->Marks->get_student_marks($class_id, 1, 1,  $student['id']),
                        "second_language"       => $this->Marks->get_student_marks($class_id, 1, 25, $student['id']),
                        "mathematics"           => $this->Marks->get_student_marks($class_id, 1, 3,  $student['id']),
                        "evs"                   => $this->Marks->get_student_marks($class_id, 1, 8,  $student['id']),
                        "computer"              => $this->Marks->get_student_marks($class_id, 1, 16, $student['id']),
                    ];
                    
                    // Marks Subject First Term
                    $first_term_marks = [
                        "english_language"      => $this->Marks->get_student_marks($class_id, 2, 2,  $student['id']),
                        "english_literature"    => $this->Marks->get_student_marks($class_id, 2, 1,  $student['id']),
                        "second_language"       => $this->Marks->get_student_marks($class_id, 2, 25, $student['id']),
                        "mathematics"           => $this->Marks->get_student_marks($class_id, 2, 3,  $student['id']),
                        "evs"                   => $this->Marks->get_student_marks($class_id, 2, 8,  $student['id']),
                        "computer"              => $this->Marks->get_student_marks($class_id, 2, 16, $student['id']),
                    ];
                    
                    // Marks Subject Second UNIT TEST
                    $second_unit_test_marks = [
                        "english_language"      => $this->Marks->get_student_marks($class_id, 3, 2,  $student['id']),
                        "english_literature"    => $this->Marks->get_student_marks($class_id, 3, 1,  $student['id']),
                        "second_language"       => $this->Marks->get_student_marks($class_id, 3, 25, $student['id']),
                        "mathematics"           => $this->Marks->get_student_marks($class_id, 3, 3,  $student['id']),
                        "evs"                   => $this->Marks->get_student_marks($class_id, 3, 8,  $student['id']),
                        "computer"              => $this->Marks->get_student_marks($class_id, 3, 16, $student['id']),
                    ];
                    
                    
                    // Marks Subject First Term
                    $annual_term_marks = [
                        "english_language"      => $this->Marks->get_student_marks($class_id, 4, 2,  $student['id']),
                        "english_literature"    => $this->Marks->get_student_marks($class_id, 4, 1,  $student['id']),
                        "second_language"       => $this->Marks->get_student_marks($class_id, 4, 25, $student['id']),
                        "mathematics"           => $this->Marks->get_student_marks($class_id, 4, 3,  $student['id']),
                        "evs"                   => $this->Marks->get_student_marks($class_id, 4, 8,  $student['id']),
                        "computer"              => $this->Marks->get_student_marks($class_id, 4, 16, $student['id']),
                    ];
                    
                    // First Term Total
                    $first_term_totals = [
                        "english_language"      =>  $first_unit_test_marks["english_language"]    + $first_term_marks["english_language"],
                        "english_literature"    =>  $first_unit_test_marks["english_literature"]  + $first_term_marks["english_literature"],
                        "second_language"       =>  $first_unit_test_marks["second_language"]     + $first_term_marks["second_language"],
                        "mathematics"           =>  $first_unit_test_marks["mathematics"]         + $first_term_marks["mathematics"],
                        "evs"                   =>  $first_unit_test_marks["evs"]                 + $first_term_marks["evs"],
                        "computer"              =>  $first_unit_test_marks["computer"]            + $first_term_marks["computer"],
                    ];

                    // Annual Term Total
                    $annual_term_totals = [
                        "english_language"      =>  $second_unit_test_marks["english_language"]    + $annual_term_marks["english_language"],
                        "english_literature"    =>  $second_unit_test_marks["english_literature"]  + $annual_term_marks["english_literature"],
                        "second_language"       =>  $second_unit_test_marks["second_language"]     + $annual_term_marks["second_language"],
                        "mathematics"           =>  $second_unit_test_marks["mathematics"]         + $annual_term_marks["mathematics"],
                        "evs"                   =>  $second_unit_test_marks["evs"]                 + $annual_term_marks["evs"],
                        "computer"              =>  $second_unit_test_marks["computer"]            + $annual_term_marks["computer"],
                    ];
                    
                    
                    // First Term AVG
                    $first_term_avg = [
                        "english"               =>  ceil(($first_term_totals["english_language"] + $first_term_totals["english_literature"]) / 2),
                        "second_language"       =>  $first_term_totals["second_language"],
                        "mathematics"           =>  $first_term_totals["mathematics"],
                        "evs"                   =>  $first_term_totals["evs"],
                        "computer"              =>  $first_term_totals["computer"],
                    ];
                    
                    
                    // Annual Term AVG
                    $annual_term_avg = [
                        "english"               =>  ceil(($annual_term_totals["english_language"] + $annual_term_totals["english_literature"]) / 2),
                        "second_language"       =>  $annual_term_totals["second_language"],
                        "mathematics"           =>  $annual_term_totals["mathematics"],
                        "evs"                   =>  $annual_term_totals["evs"],
                        "computer"              =>  $annual_term_totals["computer"],
                    ];
                    
                    
                    // Final Term AVG
                    $final_avg = [
                        "english"               =>  ceil(($first_term_avg["english"]            + $annual_term_avg["english"]) / 2),
                        "second_language"       =>  ceil(($first_term_avg["second_language"]    + $annual_term_avg["second_language"]) / 2),
                        "mathematics"           =>  ceil(($first_term_avg["mathematics"]        + $annual_term_avg["mathematics"]) / 2),
                        "evs"                   =>  ceil(($first_term_avg["evs"]                + $annual_term_avg["evs"]) / 2),
                        "computer"              =>  ceil(($first_term_avg["computer"]           + $annual_term_avg["computer"]) / 2),
                    ];
                    
                    $first_term_merks_values  = array_values($first_term_marks);
                    $annual_term_merks_values = array_values($annual_term_marks);
                    $values = array_merge($first_term_merks_values, $annual_term_merks_values);
                    
                    foreach($values as &$value)
                        $value = strtolower($value);
                    
                    if(in_array("ab", $values))
                        $is_absent = true;
                    
                    $final_avg_total    =  $final_avg["english"] + $final_avg["second_language"] + $final_avg["mathematics"] + $final_avg["evs"] + $final_avg["computer"] ; 
                    $final_percentage   =  ceil($final_avg_total / 5);
                    
                    $division = "";
                    
                    if($final_percentage >= 85 && $final_percentage <= 100) {
                        $division = "1st Div";
                    }
                    elseif($final_percentage >= 65 && $final_percentage <= 84) {
                        $division = "2nd Div";
                    }
                    elseif($final_percentage >= 45 && $final_percentage <= 64) {
                        $division = "3rd Div";
                    }
                    elseif($final_percentage < 45) {
                        $division = "Unsatisfactory";
                    }
                    else {
                        $division = "";
                    }
                    
                    
                    $numberOfSubjectMarksIsLessThan45 = 0;
                    
                    if($final_avg["english"] < 45) {$numberOfSubjectMarksIsLessThan45++;}
                    if($final_avg["second_language"] < 45) {$numberOfSubjectMarksIsLessThan45++;}
                    if($final_avg["mathematics"] < 45) {$numberOfSubjectMarksIsLessThan45++;}
                    if($final_avg["evs"] < 45) {$numberOfSubjectMarksIsLessThan45++;}
                    if($final_avg["computer"] < 45) {$numberOfSubjectMarksIsLessThan45++;}
                    
                    
                    // Direct Condition
                    $passed = false;
                    $eligible_for_rank = false;

                    if($final_avg["english"] >= 45 && $final_avg["second_language"] >= 25 && $final_avg["mathematics"] >= 25) {
                        $passed = true;
                    }
                    else {
                        $passed = false;
                    }
                    
                    if($passed) {
                        if($numberOfSubjectMarksIsLessThan45 == 1 || $numberOfSubjectMarksIsLessThan45 == 2) {
                            $passed = true;
                            $eligible_for_rank = false;
                        }
                        elseif($numberOfSubjectMarksIsLessThan45 >= 3) {
                            $passed = false;
                            $eligible_for_rank = false;
                        }
                        else {
                            $passed = true;
                            $eligible_for_rank = true;
                            // $ranks[] = $final_percentage;
                            $ranks[] = $final_avg_total;
                            $rank_eligible_students[] = $student["student_no"];
                        }
                    }
                    

                    $data = [
                        "name"                      => $student["f_name"] . " " . $student["m_name"] . " " . $student["l_name"],
                        "roll_no"                   => $student["roll_no"],
                        "student_no"                => $student["student_no"],
                        "student_id"                => $student["id"],               
                        "remarks"                   => $remark,
                        "evolution_grades"          => $grades,
                        "first_unit_test_marks"     => $first_unit_test_marks,
                        "first_term_marks"          => $first_term_marks,
                        "second_unit_test_marks"    => $second_unit_test_marks,
                        "annual_term_marks"         => $annual_term_marks,
                        "first_term_totals"         => $first_term_totals,
                        "annual_term_totals"        => $annual_term_totals,
                        "first_term_avg"            => $first_term_avg,
                        "annual_term_avg"           => $annual_term_avg,
                        "final_avg"                 => $final_avg,
                        "final_avg_total"           => $final_avg_total,
                        "final_percentage"          => $final_percentage,
                        "first_term_grade_subjects" => $first_term_grade_subjects,
                        "annual_term_grade_subjects" => $annual_term_grade_subjects,
                        "division"                  => $division,
                        "attendence"                => $attendence,
                        "subject"                   => $subject,
                        "passed"                    => $passed,
                        "eligible_for_rank"         => $eligible_for_rank,
                        "class_teacher"             => $class_teacher,
                        "is_absent"                 => $is_absent
                    ];
                    
                    $records[] = $data;
                }
                
                if($report_for != "all") {
                    $student_id = $selected_student_id;
                    
                    $temp = [];
                    
                    foreach($records as $record) {
                        if($record["student_id"] == $student_id) {
                            $temp[] = $record;
                        }
                    }
                    
                    $records = $temp;
                }
                
                $class = $this->AcademyClass->get($class_id);
                $section = $this->Section->get($section_id);
                
                $all_ranks = array_unique($ranks);
                rsort($all_ranks);
            
                // echo "<pre>";
                // print_r($all_ranks);
                // echo "</pre>";
                
                return ["students" => $records, "ranks" => $all_ranks];
            }
            
            // Class III to IV
            else if(in_array($class_id, [4, 5]))
            {
                $students = $this->Student->get_where([
                    "class_id"                      => $class_id,
                    "section_id"                    => $section_id,
                    "student_session.promoted"      => "ANY",
                    "student_session.withdraw"      => "ANY",
                ]);
            
                $records = [];
                $ranks = [];
                
                $class_teacher = "";
                if($class_id == 4) {
                    if($section_id == 1) {
                        $class_teacher = "SR. RUPOLA";
                    }
                    
                    if($section_id == 2) {
                        $class_teacher = "MS. PRISCILLA";
                    }
                }
                
                if($class_id == 5) {
                    if($section_id == 1) {
                        $class_teacher = "MS. CHRISTABEL";
                    }
                    
                    if($section_id == 2) {
                        $class_teacher = "MS. SUSHMA";
                    }
                }
                
                foreach($students as $student) {
                    $student_evolution = $this->Marks->get_student_evolution($class_id, $exam_id, $student['id']);
                    $grades = explode(",", $student_evolution);
                    $is_absent = false;
                    
                    $attendence = $this->ExamAttendence->get_student_attendence_percentage($class_id, $exam_id, $student['id']);
                    $remark     = $this->Remarks->get_student_remarks($class_id, $exam_id, $student['id']);
                    
                    // First Term Grade Subjects
                    $first_term_grade_subjects = [
                        "gk"            => $this->Marks->get_student_grade($class_id, 2, 22,  $student['id']), 
                        "moral_science" => $this->Marks->get_student_grade($class_id, 2, 23,  $student['id']),
                        "catechism"     => $this->Marks->get_student_grade($class_id, 2, 24,  $student['id']),
                        "handwriting"   => $this->Marks->get_student_grade($class_id, 2, 27,  $student['id']),
                        "drawing"       => $this->Marks->get_student_grade($class_id, 2, 30,  $student['id'])
                    ];
                    
                    // Annual Term Grade Subjects
                    $annual_term_grade_subjects = [
                        "gk"            => $this->Marks->get_student_grade($class_id, 4, 22,  $student['id']), 
                        "moral_science" => $this->Marks->get_student_grade($class_id, 4, 23,  $student['id']),
                        "catechism"     => $this->Marks->get_student_grade($class_id, 4, 24,  $student['id']),
                        "handwriting"   => $this->Marks->get_student_grade($class_id, 4, 27,  $student['id']),
                        "drawing"       => $this->Marks->get_student_grade($class_id, 4, 30,  $student['id'])
                    ];
                    
                    
                    // Marks Subject UNIT TEST
                    $first_unit_test_marks = [
                        "english_language"      => $this->Marks->get_student_marks($class_id, 1, 2,  $student['id']),
                        "english_literature"    => $this->Marks->get_student_marks($class_id, 1, 1,  $student['id']),
                        "second_language"       => $this->Marks->get_student_marks($class_id, 1, 25, $student['id']),
                        "mathematics"           => $this->Marks->get_student_marks($class_id, 1, 3,  $student['id']),
                        "science"               => $this->Marks->get_student_marks($class_id, 1, 4,  $student['id']),
                        "social_studies"        => $this->Marks->get_student_marks($class_id, 1, 20, $student['id']),
                        "computer"              => $this->Marks->get_student_marks($class_id, 1, 16, $student['id']),
                    ];
                    
                    // Marks Subject First Term
                    $first_term_marks = [
                        "english_language"      => $this->Marks->get_student_marks($class_id, 2, 2,  $student['id']),
                        "english_literature"    => $this->Marks->get_student_marks($class_id, 2, 1,  $student['id']),
                        "second_language"       => $this->Marks->get_student_marks($class_id, 2, 25, $student['id']),
                        "mathematics"           => $this->Marks->get_student_marks($class_id, 2, 3,  $student['id']),
                        "science"               => $this->Marks->get_student_marks($class_id, 2, 4,  $student['id']),
                        "social_studies"        => $this->Marks->get_student_marks($class_id, 2, 20, $student['id']),
                        "computer"              => $this->Marks->get_student_marks($class_id, 2, 16, $student['id']),
                    ];
                    
                    // Marks Subject UNIT TEST
                    $second_unit_test_marks = [
                        "english_language"      => $this->Marks->get_student_marks($class_id, 3, 2,  $student['id']),
                        "english_literature"    => $this->Marks->get_student_marks($class_id, 3, 1,  $student['id']),
                        "second_language"       => $this->Marks->get_student_marks($class_id, 3, 25, $student['id']),
                        "mathematics"           => $this->Marks->get_student_marks($class_id, 3, 3,  $student['id']),
                        "science"               => $this->Marks->get_student_marks($class_id, 3, 4,  $student['id']),
                        "social_studies"        => $this->Marks->get_student_marks($class_id, 3, 20, $student['id']),
                        "computer"              => $this->Marks->get_student_marks($class_id, 3, 16, $student['id']),
                    ];
                    
                    // Marks Subject First Term
                    $annual_term_marks = [
                        "english_language"      => $this->Marks->get_student_marks($class_id, 4, 2,  $student['id']),
                        "english_literature"    => $this->Marks->get_student_marks($class_id, 4, 1,  $student['id']),
                        "second_language"       => $this->Marks->get_student_marks($class_id, 4, 25, $student['id']),
                        "mathematics"           => $this->Marks->get_student_marks($class_id, 4, 3,  $student['id']),
                        "science"               => $this->Marks->get_student_marks($class_id, 4, 4,  $student['id']),
                        "social_studies"        => $this->Marks->get_student_marks($class_id, 4, 20, $student['id']),
                        "computer"              => $this->Marks->get_student_marks($class_id, 4, 16, $student['id']),
                    ];
                    
                    $first_term_totals = [
                        "english_language"      =>  $first_unit_test_marks["english_language"]    + $first_term_marks["english_language"],
                        "english_literature"    =>  $first_unit_test_marks["english_literature"]  + $first_term_marks["english_literature"],
                        "second_language"       =>  $first_unit_test_marks["second_language"]     + $first_term_marks["second_language"],
                        "mathematics"           =>  $first_unit_test_marks["mathematics"]         + $first_term_marks["mathematics"],
                        "science"               =>  $first_unit_test_marks["science"]             + $first_term_marks["science"],
                        "social_studies"        =>  $first_unit_test_marks["social_studies"]      + $first_term_marks["social_studies"],
                        "computer"              =>  $first_unit_test_marks["computer"]            + $first_term_marks["computer"],
                    ];
                    
                    $annual_term_totals = [
                        "english_language"      =>  $second_unit_test_marks["english_language"]    + $annual_term_marks["english_language"],
                        "english_literature"    =>  $second_unit_test_marks["english_literature"]  + $annual_term_marks["english_literature"],
                        "second_language"       =>  $second_unit_test_marks["second_language"]     + $annual_term_marks["second_language"],
                        "mathematics"           =>  $second_unit_test_marks["mathematics"]         + $annual_term_marks["mathematics"],
                        "science"               =>  $second_unit_test_marks["science"]             + $annual_term_marks["science"],
                        "social_studies"        =>  $second_unit_test_marks["social_studies"]      + $annual_term_marks["social_studies"],
                        "computer"              =>  $second_unit_test_marks["computer"]            + $annual_term_marks["computer"],
                    ];
                    
                    
                    $first_term_avg = [
                        "english"           => ceil(($first_term_totals["english_language"] + $first_term_totals["english_literature"]) / 2),
                        "second_language"   => $first_term_totals["second_language"],
                        "mathematics"       => $first_term_totals["mathematics"],
                        "science"           => $first_term_totals["science"],
                        "social_studies"    => $first_term_totals["social_studies"],
                        "computer"          => $first_term_totals["computer"]
                    ];
                    
                    
                    $annual_term_avg = [
                        "english"           => ceil(($annual_term_totals["english_language"] + $annual_term_totals["english_literature"]) / 2),
                        "second_language"   => $annual_term_totals["second_language"],
                        "mathematics"       => $annual_term_totals["mathematics"],
                        "science"           => $annual_term_totals["science"],
                        "social_studies"    => $annual_term_totals["social_studies"],
                        "computer"          => $annual_term_totals["computer"]
                    ];
                    
                    $final_avg = [
                        "english"           => ceil(($first_term_avg["english"] + $annual_term_avg["english"]) / 2),
                        "second_language"   => ceil(($first_term_avg["second_language"] + $annual_term_avg["second_language"]) / 2),
                        "mathematics"       => ceil(($first_term_avg["mathematics"] + $annual_term_avg["mathematics"]) / 2),
                        "science"           => ceil(($first_term_avg["science"] + $annual_term_avg["science"]) / 2),
                        "social_studies"    => ceil(($first_term_avg["social_studies"] + $annual_term_avg["social_studies"]) / 2),
                        "computer"          => ceil(($first_term_avg["computer"] + $annual_term_avg["computer"]) / 2)
                    ];
                    
                    $first_term_merks_values  = array_values($first_term_marks);
                    $annual_term_merks_values = array_values($annual_term_marks);
                    $values = array_merge($first_term_merks_values, $annual_term_merks_values);
                    
                    foreach($values as &$value)
                        $value = strtolower($value);
                    
                    if(in_array("ab", $values))
                        $is_absent = true;
                    
                    $final_avg_total    =  $final_avg["english"] + $final_avg["second_language"] + $final_avg["mathematics"] + $final_avg["science"] + $final_avg["social_studies"] + $final_avg["computer"]; 
                    $final_percentage   =  ceil($final_avg_total / 6);
                    
                    $division = "";
                    
                    if($final_percentage >= 85 && $final_percentage <= 100) {
                        $division = "1st Div";
                    }
                    elseif($final_percentage >= 65 && $final_percentage <= 84) {
                        $division = "2nd Div";
                    }
                    elseif($final_percentage >= 45 && $final_percentage <= 64) {
                        $division = "3rd Div";
                    }
                    elseif($final_percentage < 45) {
                        $division = "Unsatisfactory";
                    }
                    else {
                        $division = "";
                    }
                    
                    
                    $numberOfSubjectMarksIsLessThan45 = 0;
                    
                    if($final_avg["english"] < 45) {$numberOfSubjectMarksIsLessThan45++;}
                    if($final_avg["second_language"] < 45) {$numberOfSubjectMarksIsLessThan45++;}
                    if($final_avg["mathematics"] < 45) {$numberOfSubjectMarksIsLessThan45++;}
                    if($final_avg["science"] < 45) {$numberOfSubjectMarksIsLessThan45++;}
                    if($final_avg["social_studies"] < 45) {$numberOfSubjectMarksIsLessThan45++;}
                    if($final_avg["computer"] < 45) {$numberOfSubjectMarksIsLessThan45++;}
                    
                    
                    // Direct Condidiotion
                    $passed = false;
                    $eligible_for_rank = false;
                    
                    if($final_avg["english"] >= 45 && $final_avg["second_language"] >= 25 && $final_avg["mathematics"] >= 25) {
                        $passed = true;
                    }
                    else {
                        $passed = false;
                    }
                    
                    if($passed) {
                        if($numberOfSubjectMarksIsLessThan45 == 1 || $numberOfSubjectMarksIsLessThan45 == 2) {
                            $passed = true;
                            $eligible_for_rank = false;
                        }
                        else if($numberOfSubjectMarksIsLessThan45 >= 3) {
                            $passed = false;
                            $eligible_for_rank = false;
                        }
                        else {
                            $passed = true;
                            $eligible_for_rank = true;
                            $ranks[] = $final_avg_total;
                        }
                    }
                    

                    $data = [
                        "name"                          => $student["f_name"] . " " . $student["m_name"] . " " . $student["l_name"],
                        "roll_no"                       => $student["roll_no"],
                        "student_no"                    => $student["student_no"],
                        "student_id"                    => $student["id"],
                        "remarks"                       => $remark,
                        "evolution_grades"              => $grades,
                        "first_unit_test_marks"         => $first_unit_test_marks,
                        "first_term_marks"              => $first_term_marks,
                        "second_unit_test_marks"        => $second_unit_test_marks,
                        "annual_term_marks"             => $annual_term_marks,
                        "first_term_totals"             => $first_term_totals,
                        "annual_term_totals"            => $annual_term_totals,
                        "first_term_avg"                => $first_term_avg,
                        "annual_term_avg"               => $annual_term_avg,
                        "final_avg"                     => $final_avg,
                        "final_avg_total"               => $final_avg_total,
                        "final_percentage"              => $final_percentage,
                        "first_term_grade_subjects"     => $first_term_grade_subjects,
                        "annual_term_grade_subjects"    => $annual_term_grade_subjects,
                        "division"                      => $division,
                        "attendence"                    => $attendence,
                        "subject"                       => $subject,
                        "passed"                        => $passed,
                        "eligible_for_rank"             => $eligible_for_rank,
                        "grade_subjects"                => $grade_subjects,
                        "class_teacher"                 => $class_teacher,
                        "is_absent"                     => $is_absent
                    ];
                    
                    $records[] = $data;
                }
                
                if($report_for != "all") {
                    $student_id = $selected_student_id;
                    
                    $temp = [];
                    
                    foreach($records as $record) {
                        if($record["student_id"] == $student_id) {
                            $temp[] = $record;
                        }
                    }
                    
                    $records = $temp;
                }
                
                $class = $this->AcademyClass->get($class_id);
                $section = $this->Section->get($section_id);
                
                $all_ranks = array_unique($ranks);
                rsort($all_ranks);
            
                // echo "<pre>";
                // print_r($all_ranks);
                // echo "</pre>";
                
                return ["students" => $records, "ranks" => $all_ranks];
            }
            
            // Class V
            else if(in_array($class_id, [6]))
            {
                $students = $this->Student->get_where([
                    "class_id"                      => $class_id,
                    "section_id"                    => $section_id,
                    "student_session.promoted"      => "ANY",
                    "student_session.withdraw"      => "ANY",
                ]);
            
                $records = [];
                $ranks = [];
                
                $class_teacher = "";
                if($class_id == 6) {
                    if($section_id == 1) {
                        $class_teacher = "MS. MARINA";
                    }
                    
                    if($section_id == 2) {
                        $class_teacher = "MS. REETU";
                    }
                }
                
                foreach($students as $student) {
                    $student_evolution = $this->Marks->get_student_evolution($class_id, $exam_id, $student['id']);
                    $grades = explode(",", $student_evolution);
                    $is_absent = false;
                    
                    $attendence = $this->ExamAttendence->get_student_attendence_percentage($class_id, $exam_id, $student['id']);
                    $remark     = $this->Remarks->get_student_remarks($class_id, $exam_id, $student['id']);
                    
                    // First Term Grade Subjects
                    $first_term_grade_subjects = [
                        "gk"                => $this->Marks->get_student_grade($class_id, 2, 22,  $student['id']), 
                        "moral_science"     => $this->Marks->get_student_grade($class_id, 2, 23,  $student['id']),
                        "catechism"         => $this->Marks->get_student_grade($class_id, 2, 24,  $student['id']),
                        "handwriting"       => $this->Marks->get_student_grade($class_id, 2, 27,  $student['id']),
                        "third_language"    => $this->Marks->get_student_grade($class_id, 2, 26,  $student['id']),
                        "drawing"           => $this->Marks->get_student_grade($class_id, 2, 30,  $student['id'])
                    ];
                    
                    // Annual Term Grade Subjects
                    $annual_term_grade_subjects = [
                        "gk"                => $this->Marks->get_student_grade($class_id, 4, 22,  $student['id']), 
                        "moral_science"     => $this->Marks->get_student_grade($class_id, 4, 23,  $student['id']),
                        "catechism"         => $this->Marks->get_student_grade($class_id, 4, 24,  $student['id']),
                        "handwriting"       => $this->Marks->get_student_grade($class_id, 4, 27,  $student['id']),
                        "third_language"    => $this->Marks->get_student_grade($class_id, 2, 26,  $student['id']),
                        "drawing"           => $this->Marks->get_student_grade($class_id, 4, 30,  $student['id'])
                    ];
                    
                    
                    // Marks Subject UNIT TEST
                    $first_unit_test_marks = [
                        "english_language"      => $this->Marks->get_student_marks($class_id, 1, 2,  $student['id']),
                        "english_literature"    => $this->Marks->get_student_marks($class_id, 1, 1,  $student['id']),
                        "second_language"       => $this->Marks->get_student_marks($class_id, 1, 25, $student['id']),
                        "mathematics"           => $this->Marks->get_student_marks($class_id, 1, 3,  $student['id']),
                        "science"               => $this->Marks->get_student_marks($class_id, 1, 4,  $student['id']),
                        "social_studies"        => $this->Marks->get_student_marks($class_id, 1, 20, $student['id']),
                        "computer"              => $this->Marks->get_student_marks($class_id, 1, 16, $student['id']),
                    ];
                    
                    // Marks Subject First Term
                    $first_term_marks = [
                        "english_language"      => $this->Marks->get_student_marks($class_id, 2, 2,  $student['id']),
                        "english_literature"    => $this->Marks->get_student_marks($class_id, 2, 1,  $student['id']),
                        "second_language"       => $this->Marks->get_student_marks($class_id, 2, 25, $student['id']),
                        "mathematics"           => $this->Marks->get_student_marks($class_id, 2, 3,  $student['id']),
                        "science"               => $this->Marks->get_student_marks($class_id, 2, 4,  $student['id']),
                        "social_studies"        => $this->Marks->get_student_marks($class_id, 2, 20, $student['id']),
                        "computer"              => $this->Marks->get_student_marks($class_id, 2, 16, $student['id']),
                    ];
                    
                    // Marks Subject UNIT TEST
                    $second_unit_test_marks = [
                        "english_language"      => $this->Marks->get_student_marks($class_id, 3, 2,  $student['id']),
                        "english_literature"    => $this->Marks->get_student_marks($class_id, 3, 1,  $student['id']),
                        "second_language"       => $this->Marks->get_student_marks($class_id, 3, 25, $student['id']),
                        "mathematics"           => $this->Marks->get_student_marks($class_id, 3, 3,  $student['id']),
                        "science"               => $this->Marks->get_student_marks($class_id, 3, 4,  $student['id']),
                        "social_studies"        => $this->Marks->get_student_marks($class_id, 3, 20, $student['id']),
                        "computer"              => $this->Marks->get_student_marks($class_id, 3, 16, $student['id']),
                    ];
                    
                    // Marks Subject First Term
                    $annual_term_marks = [
                        "english_language"      => $this->Marks->get_student_marks($class_id, 4, 2,  $student['id']),
                        "english_literature"    => $this->Marks->get_student_marks($class_id, 4, 1,  $student['id']),
                        "second_language"       => $this->Marks->get_student_marks($class_id, 4, 25, $student['id']),
                        "mathematics"           => $this->Marks->get_student_marks($class_id, 4, 3,  $student['id']),
                        "science"               => $this->Marks->get_student_marks($class_id, 4, 4,  $student['id']),
                        "social_studies"        => $this->Marks->get_student_marks($class_id, 4, 20, $student['id']),
                        "computer"              => $this->Marks->get_student_marks($class_id, 4, 16, $student['id']),
                    ];
                    
                    $first_term_totals = [
                        "english_language"      =>  $first_unit_test_marks["english_language"]    + $first_term_marks["english_language"],
                        "english_literature"    =>  $first_unit_test_marks["english_literature"]  + $first_term_marks["english_literature"],
                        "second_language"       =>  $first_unit_test_marks["second_language"]     + $first_term_marks["second_language"],
                        "mathematics"           =>  $first_unit_test_marks["mathematics"]         + $first_term_marks["mathematics"],
                        "science"               =>  $first_unit_test_marks["science"]             + $first_term_marks["science"],
                        "social_studies"        =>  $first_unit_test_marks["social_studies"]      + $first_term_marks["social_studies"],
                        "computer"              =>  $first_unit_test_marks["computer"]            + $first_term_marks["computer"],
                    ];
                    
                    $annual_term_totals = [
                        "english_language"      =>  $second_unit_test_marks["english_language"]    + $annual_term_marks["english_language"],
                        "english_literature"    =>  $second_unit_test_marks["english_literature"]  + $annual_term_marks["english_literature"],
                        "second_language"       =>  $second_unit_test_marks["second_language"]     + $annual_term_marks["second_language"],
                        "mathematics"           =>  $second_unit_test_marks["mathematics"]         + $annual_term_marks["mathematics"],
                        "science"               =>  $second_unit_test_marks["science"]             + $annual_term_marks["science"],
                        "social_studies"        =>  $second_unit_test_marks["social_studies"]      + $annual_term_marks["social_studies"],
                        "computer"              =>  $second_unit_test_marks["computer"]            + $annual_term_marks["computer"],
                    ];
                    
                    
                    $first_term_avg = [
                        "english"           => ceil(($first_term_totals["english_language"] + $first_term_totals["english_literature"]) / 2),
                        "second_language"   => $first_term_totals["second_language"],
                        "mathematics"       => $first_term_totals["mathematics"],
                        "science"           => $first_term_totals["science"],
                        "social_studies"    => $first_term_totals["social_studies"],
                        "computer"          => $first_term_totals["computer"]
                    ];
                    
                    
                    $annual_term_avg = [
                        "english"           => ceil(($annual_term_totals["english_language"] + $annual_term_totals["english_literature"]) / 2),
                        "second_language"   => $annual_term_totals["second_language"],
                        "mathematics"       => $annual_term_totals["mathematics"],
                        "science"           => $annual_term_totals["science"],
                        "social_studies"    => $annual_term_totals["social_studies"],
                        "computer"          => $annual_term_totals["computer"]
                    ];
                    
                    $final_avg = [
                        "english"           => ceil(($first_term_avg["english"] + $annual_term_avg["english"]) / 2),
                        "second_language"   => ceil(($first_term_avg["second_language"] + $annual_term_avg["second_language"]) / 2),
                        "mathematics"       => ceil(($first_term_avg["mathematics"] + $annual_term_avg["mathematics"]) / 2),
                        "science"           => ceil(($first_term_avg["science"] + $annual_term_avg["science"]) / 2),
                        "social_studies"    => ceil(($first_term_avg["social_studies"] + $annual_term_avg["social_studies"]) / 2),
                        "computer"          => ceil(($first_term_avg["computer"] + $annual_term_avg["computer"]) / 2)
                    ];
                    
                    $first_term_merks_values  = array_values($first_term_marks);
                    $annual_term_merks_values = array_values($annual_term_marks);
                    $values = array_merge($first_term_merks_values, $annual_term_merks_values);
                    
                    foreach($values as &$value)
                        $value = strtolower($value);
                    
                    if(in_array("ab", $values))
                        $is_absent = true;
                    
                    $final_avg_total    =  $final_avg["english"] + $final_avg["second_language"] + $final_avg["mathematics"] + $final_avg["science"] + $final_avg["social_studies"] + $final_avg["computer"]; 
                    $final_percentage   =  ceil($final_avg_total / 6);
                    
                    $division = "";
                    
                    if($final_percentage >= 85 && $final_percentage <= 100) {
                        $division = "1st Div";
                    }
                    elseif($final_percentage >= 65 && $final_percentage <= 84) {
                        $division = "2nd Div";
                    }
                    elseif($final_percentage >= 45 && $final_percentage <= 64) {
                        $division = "3rd Div";
                    }
                    elseif($final_percentage < 45) {
                        $division = "Unsatisfactory";
                    }
                    else {
                        $division = "";
                    }
                    
                    
                    $numberOfSubjectMarksIsLessThan45 = 0;
                    
                    if($final_avg["english"] < 45) {$numberOfSubjectMarksIsLessThan45++;}
                    if($final_avg["second_language"] < 45) {$numberOfSubjectMarksIsLessThan45++;}
                    if($final_avg["mathematics"] < 45) {$numberOfSubjectMarksIsLessThan45++;}
                    if($final_avg["science"] < 45) {$numberOfSubjectMarksIsLessThan45++;}
                    if($final_avg["social_studies"] < 45) {$numberOfSubjectMarksIsLessThan45++;}
                    if($final_avg["computer"] < 45) {$numberOfSubjectMarksIsLessThan45++;}
                    
                    
                    // Direct Condidiotion
                    $passed = false;
                    $eligible_for_rank = false;
                    
                    if($final_avg["english"] >= 45 && $final_avg["second_language"] >= 25 && $final_avg["mathematics"] >= 25) {
                        $passed = true;
                    }
                    else {
                        $passed = false;
                    }
                    
                    if($passed) {
                        if($numberOfSubjectMarksIsLessThan45 == 1 || $numberOfSubjectMarksIsLessThan45 == 2) {
                            $passed = true;
                            $eligible_for_rank = false;
                        }
                        else if($numberOfSubjectMarksIsLessThan45 >= 3) {
                            $passed = false;
                            $eligible_for_rank = false;
                        }
                        else {
                            $passed = true;
                            $eligible_for_rank = true;
                            $ranks[] = $final_avg_total;
                        }
                    }
                    

                    $data = [
                        "name"                          => $student["f_name"] . " " . $student["m_name"] . " " . $student["l_name"],
                        "roll_no"                       => $student["roll_no"],
                        "student_no"                    => $student["student_no"],
                        "student_id"                    => $student["id"],
                        "remarks"                       => $remark,
                        "evolution_grades"              => $grades,
                        "first_unit_test_marks"         => $first_unit_test_marks,
                        "first_term_marks"              => $first_term_marks,
                        "second_unit_test_marks"        => $second_unit_test_marks,
                        "annual_term_marks"             => $annual_term_marks,
                        "first_term_totals"             => $first_term_totals,
                        "annual_term_totals"            => $annual_term_totals,
                        "first_term_avg"                => $first_term_avg,
                        "annual_term_avg"               => $annual_term_avg,
                        "final_avg"                     => $final_avg,
                        "final_avg_total"               => $final_avg_total,
                        "final_percentage"              => $final_percentage,
                        "first_term_grade_subjects"     => $first_term_grade_subjects,
                        "annual_term_grade_subjects"    => $annual_term_grade_subjects,
                        "division"                      => $division,
                        "attendence"                    => $attendence,
                        "subject"                       => $subject,
                        "passed"                        => $passed,
                        "eligible_for_rank"             => $eligible_for_rank,
                        "grade_subjects"                => $grade_subjects,
                        "class_teacher"                 => $class_teacher,
                        "is_absent"                     => $is_absent
                    ];
                    
                    $records[] = $data;
                }
                
                if($report_for != "all") {
                    $student_id = $selected_student_id;
                    
                    $temp = [];
                    
                    foreach($records as $record) {
                        if($record["student_id"] == $student_id) {
                            $temp[] = $record;
                        }
                    }
                    
                    $records = $temp;
                }
                
                $class = $this->AcademyClass->get($class_id);
                $section = $this->Section->get($section_id);
                
                $all_ranks = array_unique($ranks);
                rsort($all_ranks);
            
                // echo "<pre>";
                // print_r($all_ranks);
                // echo "</pre>";
                
                return ["students" => $records, "ranks" => $all_ranks];
            }
            
            // Class VI, VII, VIII
            else if(in_array($class_id, [7, 8, 9]))
            {
               $students = $this->Student->get_where([
                    "class_id"                      => $class_id,
                    "section_id"                    => $section_id,
                    "student_session.promoted"      => "ANY",
                    "student_session.withdraw"      => "ANY",
                ]);
                
                $records = [];
                $ranks = [];
                
                $class_teacher = "";
                if($class_id == 7) {
                    if($section_id == 1) {
                        $class_teacher = "MS. SAROJ";
                    }
                    
                    if($section_id == 2) {
                        $class_teacher = "MS. YOGITA";
                    }
                }
                if($class_id == 8) {
                    if($section_id == 1) {
                        $class_teacher = "MS. NIKHAT";
                    }
                    
                    if($section_id == 2) {
                        $class_teacher = "MS. JYOTIKA";
                    }
                }
                if($class_id == 9) {
                    if($section_id == 1) {
                        $class_teacher = "MS. TERESA";
                    }
                    
                    if($section_id == 2) {
                        $class_teacher = "MS. DONA";
                    }
                }
                
                foreach($students as $student) {
                    $student_evolution = $this->Marks->get_student_evolution($class_id, $exam_id, $student['id']);
                    $grades = explode(",", $student_evolution);
                    
                    $attendence = $this->ExamAttendence->get_student_attendence_percentage($class_id, $exam_id, $student['id']);
                    $remark     = $this->Remarks->get_student_remarks($class_id, $exam_id, $student['id']);
                    $is_absent  = false;
                    
                    // Get the subject_id of Subject 10
                    $row = $this->StudentSubject->get_where([
                        "academy_class_id"  => $class_id,
                        "subject_type_id"   => 24,
                        "student_id"        => $student['id'],
                    ]);
                    
                    $subject_id = $row["subject_id"];
                    $subject = $this->Subject->get($subject_id);
                    
                    // Grade Subjects
                    $first_term_grade_subjects = [
                        "moral_science"     => $this->Marks->get_student_grade($class_id, 2, 23,  $student['id']),
                        "catechism"         => $this->Marks->get_student_grade($class_id, 2, 24,  $student['id']),
                        "third_language"    => $this->Marks->get_student_grade($class_id, 2, 26,  $student['id'])
                    ];
                    
                    // Grade Subjects
                    $annual_term_grade_subjects = [
                        "moral_science"     => $this->Marks->get_student_grade($class_id, 4, 23,  $student['id']),
                        "catechism"         => $this->Marks->get_student_grade($class_id, 4, 24,  $student['id']),
                        "third_language"    => $this->Marks->get_student_grade($class_id, 4, 26,  $student['id'])
                    ];
                    
                    // Marks Subject UNIT TEST
                    $first_unit_test_marks = [
                        "english_language"      => $this->Marks->get_student_marks($class_id, 1, 2,  $student['id']),
                        "english_literature"    => $this->Marks->get_student_marks($class_id, 1, 1,  $student['id']),
                        "second_language"       => $this->Marks->get_student_marks($class_id, 1, 25, $student['id']),
                        "mathematics"           => $this->Marks->get_student_marks($class_id, 1, 3,  $student['id']),
                        "physics"               => $this->Marks->get_student_marks($class_id, 1, 6,  $student['id']),
                        "chemistry"             => $this->Marks->get_student_marks($class_id, 1, 7,  $student['id']),
                        "biology"               => $this->Marks->get_student_marks($class_id, 1, 5,  $student['id']),
                        "history"               => $this->Marks->get_student_marks($class_id, 1, 15, $student['id']),
                        "geography"             => $this->Marks->get_student_marks($class_id, 1, 10, $student['id']),
                        "subject_10_marks"      => $this->Marks->get_student_marks($class_id, 1, $subject_id, $student['id']),
                    ];
                    
                    // Marks Subject UNIT TEST
                    $first_term_marks = [
                        "english_language"      => $this->Marks->get_student_marks($class_id, 2, 2,  $student['id']),
                        "english_literature"    => $this->Marks->get_student_marks($class_id, 2, 1,  $student['id']),
                        "second_language"       => $this->Marks->get_student_marks($class_id, 2, 25, $student['id']),
                        "mathematics"           => $this->Marks->get_student_marks($class_id, 2, 3,  $student['id']),
                        "physics"               => $this->Marks->get_student_marks($class_id, 2, 6,  $student['id']),
                        "chemistry"             => $this->Marks->get_student_marks($class_id, 2, 7,  $student['id']),
                        "biology"               => $this->Marks->get_student_marks($class_id, 2, 5,  $student['id']),
                        "history"               => $this->Marks->get_student_marks($class_id, 2, 15, $student['id']),
                        "geography"             => $this->Marks->get_student_marks($class_id, 2, 10, $student['id']),
                        "subject_10_marks"      => $this->Marks->get_student_marks($class_id, 2, $subject_id, $student['id']),
                    ];
                    
                    
                    // Marks Subject UNIT TEST
                    $second_unit_test_marks = [
                        "english_language"      => $this->Marks->get_student_marks($class_id, 3, 2,  $student['id']),
                        "english_literature"    => $this->Marks->get_student_marks($class_id, 3, 1,  $student['id']),
                        "second_language"       => $this->Marks->get_student_marks($class_id, 3, 25, $student['id']),
                        "mathematics"           => $this->Marks->get_student_marks($class_id, 3, 3,  $student['id']),
                        "physics"               => $this->Marks->get_student_marks($class_id, 3, 6,  $student['id']),
                        "chemistry"             => $this->Marks->get_student_marks($class_id, 3, 7,  $student['id']),
                        "biology"               => $this->Marks->get_student_marks($class_id, 3, 5,  $student['id']),
                        "history"               => $this->Marks->get_student_marks($class_id, 3, 15, $student['id']),
                        "geography"             => $this->Marks->get_student_marks($class_id, 3, 10, $student['id']),
                        "subject_10_marks"      => $this->Marks->get_student_marks($class_id, 3, $subject_id, $student['id']),
                    ];
                    
                    // Marks Subject UNIT TEST
                    $annual_term_marks = [
                        "english_language"      => $this->Marks->get_student_marks($class_id, 4, 2,  $student['id']),
                        "english_literature"    => $this->Marks->get_student_marks($class_id, 4, 1,  $student['id']),
                        "second_language"       => $this->Marks->get_student_marks($class_id, 4, 25, $student['id']),
                        "mathematics"           => $this->Marks->get_student_marks($class_id, 4, 3,  $student['id']),
                        "physics"               => $this->Marks->get_student_marks($class_id, 4, 6,  $student['id']),
                        "chemistry"             => $this->Marks->get_student_marks($class_id, 4, 7,  $student['id']),
                        "biology"               => $this->Marks->get_student_marks($class_id, 4, 5,  $student['id']),
                        "history"               => $this->Marks->get_student_marks($class_id, 4, 15, $student['id']),
                        "geography"             => $this->Marks->get_student_marks($class_id, 4, 10, $student['id']),
                        "subject_10_marks"      => $this->Marks->get_student_marks($class_id, 4, $subject_id, $student['id']),
                    ];
                    
                    $first_term_totals = [
                        "english_language"      =>  $first_unit_test_marks["english_language"]    + $first_term_marks["english_language"],
                        "english_literature"    =>  $first_unit_test_marks["english_literature"]  + $first_term_marks["english_literature"],
                        "second_language"       =>  $first_unit_test_marks["second_language"]     + $first_term_marks["second_language"],
                        "mathematics"           =>  $first_unit_test_marks["mathematics"]         + $first_term_marks["mathematics"],
                        "physics"               =>  $first_unit_test_marks["physics"]             + $first_term_marks["physics"],
                        "chemistry"             =>  $first_unit_test_marks["chemistry"]           + $first_term_marks["chemistry"],
                        "biology"               =>  $first_unit_test_marks["biology"]             + $first_term_marks["biology"],
                        "history"               =>  $first_unit_test_marks["history"]             + $first_term_marks["history"],
                        "geography"             =>  $first_unit_test_marks["geography"]           + $first_term_marks["geography"],
                        "subject_10_marks"      =>  $first_unit_test_marks["subject_10_marks"]    + $first_term_marks["subject_10_marks"],
                    ];
                    
                    $annual_term_totals = [
                        "english_language"      =>  $second_unit_test_marks["english_language"]    + $annual_term_marks["english_language"],
                        "english_literature"    =>  $second_unit_test_marks["english_literature"]  + $annual_term_marks["english_literature"],
                        "second_language"       =>  $second_unit_test_marks["second_language"]     + $annual_term_marks["second_language"],
                        "mathematics"           =>  $second_unit_test_marks["mathematics"]         + $annual_term_marks["mathematics"],
                        "physics"               =>  $second_unit_test_marks["physics"]             + $annual_term_marks["physics"],
                        "chemistry"             =>  $second_unit_test_marks["chemistry"]           + $annual_term_marks["chemistry"],
                        "biology"               =>  $second_unit_test_marks["biology"]             + $annual_term_marks["biology"],
                        "history"               =>  $second_unit_test_marks["history"]             + $annual_term_marks["history"],
                        "geography"             =>  $second_unit_test_marks["geography"]           + $annual_term_marks["geography"],
                        "subject_10_marks"      =>  $second_unit_test_marks["subject_10_marks"]    + $annual_term_marks["subject_10_marks"],
                    ];
                    
                    $first_term_avg = [
                        "english"           => ceil(($first_term_totals["english_language"] + $first_term_totals["english_literature"]) / 2),
                        "second_language"   => $first_term_totals["second_language"],
                        "mathematics"       => $first_term_totals["mathematics"],
                        "pcb"               => ceil(($first_term_totals["physics"] + $first_term_totals["chemistry"] + $first_term_totals["biology"]) / 3),
                        "hg"                => ceil(($first_term_totals["history"] + $first_term_totals["geography"]) / 2),
                        "subject_10_marks"  => $first_term_totals["subject_10_marks"]
                    ];
                    
                    $annual_term_avg = [
                        "english"           => ceil(($annual_term_totals["english_language"] + $annual_term_totals["english_literature"]) / 2),
                        "second_language"   => $annual_term_totals["second_language"],
                        "mathematics"       => $annual_term_totals["mathematics"],
                        "pcb"               => ceil(($annual_term_totals["physics"] + $annual_term_totals["chemistry"] + $annual_term_totals["biology"]) / 3),
                        "hg"                => ceil(($annual_term_totals["history"] + $annual_term_totals["geography"]) / 2),
                        "subject_10_marks"  => $annual_term_totals["subject_10_marks"]
                    ];
                    
                    $final_avg = [
                        "english"           => ceil(($first_term_avg["english"] + $annual_term_avg["english"]) / 2),
                        "second_language"   => ceil(($first_term_avg["second_language"] + $annual_term_avg["second_language"]) / 2),
                        "mathematics"       => ceil(($first_term_avg["mathematics"] + $annual_term_avg["mathematics"]) / 2),
                        "pcb"               => ceil(($first_term_avg["pcb"] + $annual_term_avg["pcb"]) / 2),
                        "hg"                => ceil(($first_term_avg["hg"] + $annual_term_avg["hg"]) / 2),
                        "subject_10_marks"  => ceil(($first_term_avg["subject_10_marks"] + $annual_term_avg["subject_10_marks"]) / 2),
                    ];
                    
                    $first_term_merks_values  = array_values($first_term_marks);
                    $annual_term_merks_values = array_values($annual_term_marks);
                    $values = array_merge($first_term_merks_values, $annual_term_merks_values);
                    
                    foreach($values as &$value)
                        $value = strtolower($value);
                    
                    if(in_array("ab", $values))
                        $is_absent = true;
                    
                    $final_avg_total    =  $final_avg["english"] + $final_avg["second_language"] + $final_avg["mathematics"] + $final_avg["pcb"] + $final_avg["hg"] + $final_avg["subject_10_marks"]; 
                    $final_percentage   =  ceil($final_avg_total / 6);
                    
                    $points = [];
                    $total_point = 0;
                    $division = "";
                    
                    foreach($final_avg as $key => $value) {
                        
                        $point = "";
                        
                        if($value >= 90 && $value <= 100) {
                            $point = 1;
                        }
                        elseif($value >= 80 && $value <= 89) {
                            $point = 2;
                        }
                        elseif($value >= 70 && $value <= 79) {
                            $point = 3;
                        }
                        elseif($value >= 60 && $value <= 69) {
                            $point = 4;
                        }
                        elseif($value >= 50 && $value <= 59) {
                            $point = 5;
                        }
                        elseif($value >= 46 && $value <= 49) {
                            $point = 6;
                        }
                        elseif($value == 45) {
                            $point = 7;
                        }
                        else {
                            $point = 8;
                        }
                        
                        $total_point += $point;
                        $points[$key] = $point;
                    }
                    
                    
                    if($total_point > 44) {
                        $division = "Unsatisfactory";
                    }
                    elseif($total_point >= 39 && $total_point <= 44) {
                        $division = "Pass";
                    }
                    elseif($total_point >= 31 && $total_point <= 38) {
                        $division = "3rd";
                    }
                    elseif($total_point >= 21 && $total_point <= 30) {
                        $division = "2nd";
                    }
                    elseif($total_point <= 21) {
                        $division = "1st";
                    }
                    else {
                        $division = "";
                    }
                
                    
                    $numberOfSubjectMarksIsLessThan45 = 0;
                    
                    if($final_avg["english"] < 45) {$numberOfSubjectMarksIsLessThan45++;}
                    if($final_avg["second_language"] < 45) {$numberOfSubjectMarksIsLessThan45++;}
                    if($final_avg["mathematics"] < 45) {$numberOfSubjectMarksIsLessThan45++;}
                    if($final_avg["pcb"] < 45) {$numberOfSubjectMarksIsLessThan45++;}
                    if($final_avg["hg"] < 45) {$numberOfSubjectMarksIsLessThan45++;}
                    if($final_avg["subject_10_marks"] < 45) {$numberOfSubjectMarksIsLessThan45++;}
                    
                    
                    // Direct Condidiotion
                    $passed = false;
                    $eligible_for_rank = false;
                    
                    if($final_avg["english"] >= 45 && $final_avg["second_language"] >= 25 && $final_avg["mathematics"] >= 25) {
                        $passed = true;
                    }
                    else {
                        $passed = false;
                    }
                    
                    if($passed) {
                        if($numberOfSubjectMarksIsLessThan45 == 1 || $numberOfSubjectMarksIsLessThan45 == 2) {
                            $passed = true;
                            $eligible_for_rank = false;
                        }
                        else if($numberOfSubjectMarksIsLessThan45 >= 3) {
                            $passed = false;
                            $eligible_for_rank = false;
                        }
                        else {
                            $passed = true;
                            $eligible_for_rank = true;
                            $ranks[] = $final_avg_total;
                        }
                    }
                    

                    $data = [
                        "name"                  => $student["f_name"] . " " . $student["m_name"] . " " . $student["l_name"],
                        "roll_no"               => $student["roll_no"],
                        "student_no"            => $student["student_no"],
                        "student_id"            => $student["id"],
                        "remarks"               => $remark,
                        "evolution_grades"              => $grades,
                        "first_unit_test_marks"         => $first_unit_test_marks,
                        "first_term_marks"              => $first_term_marks,
                        "second_unit_test_marks"        => $second_unit_test_marks,
                        "annual_term_marks"             => $annual_term_marks,
                        "first_term_totals"             => $first_term_totals,
                        "annual_term_totals"            => $annual_term_totals,
                        "first_term_avg"                => $first_term_avg,
                        "annual_term_avg"               => $annual_term_avg,
                        "final_avg"                     => $final_avg,
                        "final_avg_total"               => $final_avg_total,
                        "final_percentage"              => $final_percentage,
                        "first_term_grade_subjects"     => $first_term_grade_subjects,
                        "annual_term_grade_subjects"    => $annual_term_grade_subjects,
                        "points"                => $points,
                        "total_point"           => $total_point,
                        "division"                      => $division,
                        "attendence"                    => $attendence,
                        "subject"                       => $subject,
                        "passed"                => $passed,
                        "eligible_for_rank"     => $eligible_for_rank,
                        "grade_subjects"        => $grade_subjects,
                        "class_teacher"         => $class_teacher,
                        "is_absent" => $is_absent
                    ];
                    
                    $records[] = $data;
                }
                
                if($report_for != "all") {
                    $student_id = $selected_student_id;
                    
                    $temp = [];
                    
                    foreach($records as $record) {
                        if($record["student_id"] == $student_id) {
                            $temp[] = $record;
                        }
                    }
                    
                    $records = $temp;
                }
                
                $class = $this->AcademyClass->get($class_id);
                $section = $this->Section->get($section_id);
                
                $all_ranks = array_unique($ranks);
                rsort($all_ranks);
            
                // echo "<pre>";
                // print_r($all_ranks);
                // echo "</pre>";
                
                return ["students" => $records, "ranks" => $all_ranks];
            }
            
            // Class IX to X
            else if(in_array($class_id, [10, 11])) 
            { 
            
                $students = $this->Student->get_where([
                    "class_id"                      => $class_id,
                    "section_id"                    => $section_id,
                    "student_session.promoted"      => "ANY",
                    "student_session.withdraw"      => "ANY",
                ]);
                
                
                $records = [];
                
                $ranks = [];
                
                $class_teacher = "";
                if($class_id == 10) {
                    if($section_id == 1) {
                        $class_teacher = "MS. TAPASYA";
                    }
                    
                    if($section_id == 2) {
                        $class_teacher = "MR. DHIRAJ";
                    }
                }
                
                if($class_id == 11) {
                    if($section_id == 1) {
                        $class_teacher = "MS. PRATIMA";
                    }
                    
                    if($section_id == 2) {
                        $class_teacher = "MS. PRASANSA";
                    }
                }
                
                foreach($students as $student) {
                    $student_evolution = $this->Marks->get_student_evolution($class_id, $exam_id, $student['id']);
                    $grades = explode(",", $student_evolution);
                    
                    $attendence = $this->ExamAttendence->get_student_attendence_percentage($class_id, $exam_id, $student['id']);
                    $remark     = $this->Remarks->get_student_remarks($class_id, $exam_id, $student['id']);
                    $is_absent  = false;
                    
                    // Get the subject_id of Subject 10
                    $row = $this->StudentSubject->get_where([
                        "academy_class_id"  => $class_id,
                        "subject_type_id"   => 24,
                        "student_id"        => $student['id'],
                    ]);
                    
                    $subject_id = $row["subject_id"];
                    $subject = $this->Subject->get($subject_id);
                    
                    // Grade Subjects
                    $first_term_grade_subjects = [
                        "moral_science"     => $this->Marks->get_student_grade($class_id, 2, 23,  $student['id']),
                        "catechism"         => $this->Marks->get_student_grade($class_id, 2, 24,  $student['id']),
                    ];
                    
                    // Grade Subjects
                    $annual_term_grade_subjects = [
                        "moral_science"     => $this->Marks->get_student_grade($class_id, 4, 23,  $student['id']),
                        "catechism"         => $this->Marks->get_student_grade($class_id, 4, 24,  $student['id']),
                    ];
                    
                    // Marks Subject UNIT TEST
                    $first_unit_test_marks = [
                        "english_language"      => $this->Marks->get_student_marks($class_id, 1, 2,  $student['id']),
                        "english_literature"    => $this->Marks->get_student_marks($class_id, 1, 1,  $student['id']),
                        "second_language"       => $this->Marks->get_student_marks($class_id, 1, 25, $student['id']),
                        "mathematics"           => $this->Marks->get_student_marks($class_id, 1, 3,  $student['id']),
                        "physics"               => $this->Marks->get_student_marks($class_id, 1, 6,  $student['id']),
                        "chemistry"             => $this->Marks->get_student_marks($class_id, 1, 7,  $student['id']),
                        "biology"               => $this->Marks->get_student_marks($class_id, 1, 5,  $student['id']),
                        "history"               => $this->Marks->get_student_marks($class_id, 1, 15, $student['id']),
                        "geography"             => $this->Marks->get_student_marks($class_id, 1, 10, $student['id']),
                        "subject_10_marks"      => $this->Marks->get_student_marks($class_id, 1, $subject_id, $student['id']),
                    ];
                    
                    // Marks Subject UNIT TEST
                    $first_term_marks = [
                        "english_language"      => $this->Marks->get_student_marks($class_id, 2, 2,  $student['id']),
                        "english_literature"    => $this->Marks->get_student_marks($class_id, 2, 1,  $student['id']),
                        "second_language"       => $this->Marks->get_student_marks($class_id, 2, 25, $student['id']),
                        "mathematics"           => $this->Marks->get_student_marks($class_id, 2, 3,  $student['id']),
                        "physics"               => $this->Marks->get_student_marks($class_id, 2, 6,  $student['id']),
                        "chemistry"             => $this->Marks->get_student_marks($class_id, 2, 7,  $student['id']),
                        "biology"               => $this->Marks->get_student_marks($class_id, 2, 5,  $student['id']),
                        "history"               => $this->Marks->get_student_marks($class_id, 2, 15, $student['id']),
                        "geography"             => $this->Marks->get_student_marks($class_id, 2, 10, $student['id']),
                        "subject_10_marks"      => $this->Marks->get_student_marks($class_id, 2, $subject_id, $student['id']),
                    ];
                    
                    
                    // Marks Subject UNIT TEST
                    $second_unit_test_marks = [
                        "english_language"      => $this->Marks->get_student_marks($class_id, 3, 2,  $student['id']),
                        "english_literature"    => $this->Marks->get_student_marks($class_id, 3, 1,  $student['id']),
                        "second_language"       => $this->Marks->get_student_marks($class_id, 3, 25, $student['id']),
                        "mathematics"           => $this->Marks->get_student_marks($class_id, 3, 3,  $student['id']),
                        "physics"               => $this->Marks->get_student_marks($class_id, 3, 6,  $student['id']),
                        "chemistry"             => $this->Marks->get_student_marks($class_id, 3, 7,  $student['id']),
                        "biology"               => $this->Marks->get_student_marks($class_id, 3, 5,  $student['id']),
                        "history"               => $this->Marks->get_student_marks($class_id, 3, 15, $student['id']),
                        "geography"             => $this->Marks->get_student_marks($class_id, 3, 10, $student['id']),
                        "subject_10_marks"      => $this->Marks->get_student_marks($class_id, 3, $subject_id, $student['id']),
                    ];
                    
                    // Marks Subject UNIT TEST
                    $annual_term_marks = [
                        "english_language"      => $this->Marks->get_student_marks($class_id, 4, 2,  $student['id']),
                        "english_literature"    => $this->Marks->get_student_marks($class_id, 4, 1,  $student['id']),
                        "second_language"       => $this->Marks->get_student_marks($class_id, 4, 25, $student['id']),
                        "mathematics"           => $this->Marks->get_student_marks($class_id, 4, 3,  $student['id']),
                        "physics"               => $this->Marks->get_student_marks($class_id, 4, 6,  $student['id']),
                        "chemistry"             => $this->Marks->get_student_marks($class_id, 4, 7,  $student['id']),
                        "biology"               => $this->Marks->get_student_marks($class_id, 4, 5,  $student['id']),
                        "history"               => $this->Marks->get_student_marks($class_id, 4, 15, $student['id']),
                        "geography"             => $this->Marks->get_student_marks($class_id, 4, 10, $student['id']),
                        "subject_10_marks"      => $this->Marks->get_student_marks($class_id, 4, $subject_id, $student['id']),
                    ];
                    
                    $first_term_totals = [
                        "english_language"      =>  $first_unit_test_marks["english_language"]    + $first_term_marks["english_language"],
                        "english_literature"    =>  $first_unit_test_marks["english_literature"]  + $first_term_marks["english_literature"],
                        "second_language"       =>  $first_unit_test_marks["second_language"]     + $first_term_marks["second_language"],
                        "mathematics"           =>  $first_unit_test_marks["mathematics"]         + $first_term_marks["mathematics"],
                        "physics"               =>  $first_unit_test_marks["physics"]             + $first_term_marks["physics"],
                        "chemistry"             =>  $first_unit_test_marks["chemistry"]           + $first_term_marks["chemistry"],
                        "biology"               =>  $first_unit_test_marks["biology"]             + $first_term_marks["biology"],
                        "history"               =>  $first_unit_test_marks["history"]             + $first_term_marks["history"],
                        "geography"             =>  $first_unit_test_marks["geography"]           + $first_term_marks["geography"],
                        "subject_10_marks"      =>  $first_unit_test_marks["subject_10_marks"]    + $first_term_marks["subject_10_marks"],
                    ];
                    
                    $annual_term_totals = [
                        "english_language"      =>  $second_unit_test_marks["english_language"]    + $annual_term_marks["english_language"],
                        "english_literature"    =>  $second_unit_test_marks["english_literature"]  + $annual_term_marks["english_literature"],
                        "second_language"       =>  $second_unit_test_marks["second_language"]     + $annual_term_marks["second_language"],
                        "mathematics"           =>  $second_unit_test_marks["mathematics"]         + $annual_term_marks["mathematics"],
                        "physics"               =>  $second_unit_test_marks["physics"]             + $annual_term_marks["physics"],
                        "chemistry"             =>  $second_unit_test_marks["chemistry"]           + $annual_term_marks["chemistry"],
                        "biology"               =>  $second_unit_test_marks["biology"]             + $annual_term_marks["biology"],
                        "history"               =>  $second_unit_test_marks["history"]             + $annual_term_marks["history"],
                        "geography"             =>  $second_unit_test_marks["geography"]           + $annual_term_marks["geography"],
                        "subject_10_marks"      =>  $second_unit_test_marks["subject_10_marks"]    + $annual_term_marks["subject_10_marks"],
                    ];
                    
                    $first_term_avg = [
                        "english"           => ceil(($first_term_totals["english_language"] + $first_term_totals["english_literature"]) / 2),
                        "second_language"   => $first_term_totals["second_language"],
                        "mathematics"       => $first_term_totals["mathematics"],
                        "pcb"               => ceil(($first_term_totals["physics"] + $first_term_totals["chemistry"] + $first_term_totals["biology"]) / 3),
                        "hg"                => ceil(($first_term_totals["history"] + $first_term_totals["geography"]) / 2),
                        "subject_10_marks"  => $first_term_totals["subject_10_marks"]
                    ];
                    
                    $annual_term_avg = [
                        "english"           => ceil(($annual_term_totals["english_language"] + $annual_term_totals["english_literature"]) / 2),
                        "second_language"   => $annual_term_totals["second_language"],
                        "mathematics"       => $annual_term_totals["mathematics"],
                        "pcb"               => ceil(($annual_term_totals["physics"] + $annual_term_totals["chemistry"] + $annual_term_totals["biology"]) / 3),
                        "hg"                => ceil(($annual_term_totals["history"] + $annual_term_totals["geography"]) / 2),
                        "subject_10_marks"  => $annual_term_totals["subject_10_marks"]
                    ];
                    
                    $final_avg = [
                        "english"           => ceil(($first_term_avg["english"] + $annual_term_avg["english"]) / 2),
                        "second_language"   => ceil(($first_term_avg["second_language"] + $annual_term_avg["second_language"]) / 2),
                        "mathematics"       => ceil(($first_term_avg["mathematics"] + $annual_term_avg["mathematics"]) / 2),
                        "pcb"               => ceil(($first_term_avg["pcb"] + $annual_term_avg["pcb"]) / 2),
                        "hg"                => ceil(($first_term_avg["hg"] + $annual_term_avg["hg"]) / 2),
                        "subject_10_marks"  => ceil(($first_term_avg["subject_10_marks"] + $annual_term_avg["subject_10_marks"]) / 2),
                    ];
                    
                    $first_term_merks_values  = array_values($first_term_marks);
                    $annual_term_merks_values = array_values($annual_term_marks);
                    $values = array_merge($first_term_merks_values, $annual_term_merks_values);
                    
                    foreach($values as &$value)
                        $value = strtolower($value);
                    
                    if(in_array("ab", $values))
                        $is_absent = true;
                    
                    $final_avg_total    =  $final_avg["english"] + $final_avg["second_language"] + $final_avg["mathematics"] + $final_avg["pcb"] + $final_avg["hg"] + $final_avg["subject_10_marks"]; 
                    $final_percentage   =  ceil($final_avg_total / 6);
                    
                    $points = [];
                    $total_point = 0;
                    $division = "";
                    
                    foreach($final_avg as $key => $value) {
                        
                        $point = "";
                        
                        if($value >= 90 && $value <= 100) {
                            $point = 1;
                        }
                        elseif($value >= 80 && $value <= 89) {
                            $point = 2;
                        }
                        elseif($value >= 70 && $value <= 79) {
                            $point = 3;
                        }
                        elseif($value >= 60 && $value <= 69) {
                            $point = 4;
                        }
                        elseif($value >= 50 && $value <= 59) {
                            $point = 5;
                        }
                        elseif($value >= 46 && $value <= 49) {
                            $point = 6;
                        }
                        elseif($value == 45) {
                            $point = 7;
                        }
                        else {
                            $point = 8;
                        }
                        
                        $total_point += $point;
                        $points[$key] = $point;
                    }
                    
                    
                    if($total_point > 44) {
                        $division = "Unsatisfactory";
                    }
                    elseif($total_point >= 39 && $total_point <= 44) {
                        $division = "Pass";
                    }
                    elseif($total_point >= 31 && $total_point <= 38) {
                        $division = "3rd";
                    }
                    elseif($total_point >= 21 && $total_point <= 30) {
                        $division = "2nd";
                    }
                    elseif($total_point <= 21) {
                        $division = "1st";
                    }
                    else {
                        $division = "";
                    }
    
                    
                    $passed_in_english = $final_avg["english"] >= 33 ? true : false;
                    $number_of_failed_subject = 0;
                    $eligible_for_rank = true;
                    $passed = true;
                    
                    if($final_avg["pcb"] < 33)  {$number_of_failed_subject++;}
                    if($final_avg["hg"] < 33)  {$number_of_failed_subject++;}
                    if($final_avg["second_language"] < 33)  {$number_of_failed_subject++;}
                    if($final_avg["mathematics"] < 33)  {$number_of_failed_subject++;}
                    if($final_avg["subject_10_marks"] < 33)  {$number_of_failed_subject++;}
                    
                    
                    if(!$passed_in_english || $number_of_failed_subject >=3) {
                        $passed = false;
                        $eligible_for_rank = false;
                    }
                    else {
                        $passed = true;
                         
                        if($number_of_failed_subject == 1 || $number_of_failed_subject == 2){
                            $eligible_for_rank = false;    
                        }
                    }
                    
                    
                    if($eligible_for_rank) {
                        $ranks[] = $final_avg_total;
                    }
                    

                    $data = [
                        "name"                  => $student["f_name"] . " " . $student["m_name"] . " " . $student["l_name"],
                        "roll_no"               => $student["roll_no"],
                        "student_no"            => $student["student_no"],
                        "student_id"            => $student["id"],
                        "remarks"               => $remark,
                        "evolution_grades"              => $grades,
                        "first_unit_test_marks"         => $first_unit_test_marks,
                        "first_term_marks"              => $first_term_marks,
                        "second_unit_test_marks"        => $second_unit_test_marks,
                        "annual_term_marks"             => $annual_term_marks,
                        "first_term_totals"             => $first_term_totals,
                        "annual_term_totals"            => $annual_term_totals,
                        "first_term_avg"                => $first_term_avg,
                        "annual_term_avg"               => $annual_term_avg,
                        "final_avg"                     => $final_avg,
                        "final_avg_total"               => $final_avg_total,
                        "final_percentage"              => $final_percentage,
                        "first_term_grade_subjects"     => $first_term_grade_subjects,
                        "annual_term_grade_subjects"    => $annual_term_grade_subjects,
                        "points"                => $points,
                        "total_point"           => $total_point,
                        "division"                      => $division,
                        "attendence"                    => $attendence,
                        "subject"                       => $subject,
                        "passed"                => $passed,
                        "eligible_for_rank"     => $eligible_for_rank,
                        "grade_subjects"        => $grade_subjects,
                        "class_teacher"         => $class_teacher
                    ];
                    
                    $records[] = $data;
                }
                
                if($report_for != "all") {
                    $student_id = $selected_student_id;
                    
                    $temp = [];
                    
                    foreach($records as $record) {
                        if($record["student_id"] == $student_id) {
                            $temp[] = $record;
                        }
                    }
                    
                    $records = $temp;
                }
                
                $class = $this->AcademyClass->get($class_id);
                $section = $this->Section->get($section_id);
                    
                $all_ranks = array_unique($ranks);
                rsort($all_ranks);
            
                // echo "<pre>";
                // print_r($all_ranks);
                // echo "</pre>";
                
                return ["students" => $records, "ranks" => $all_ranks];
            }
            
            // Class XI Section SC
            else if(in_array($class_id, [12]) && $section_id == 3) 
            { 
            
                $students = $this->Student->get_where([
                    "class_id"                      => $class_id,
                    "section_id"                    => $section_id,
                    "student_session.promoted"      => "ANY",
                    "student_session.withdraw"      => "ANY",
                ]);
                
                
                $records = [];
                
                $ranks = [];
                
                $class_teacher = "";
                if($class_id == 12) {
                    // SC
                    if($section_id == 3) {
                        $class_teacher = "MS. ROSELINE";
                    }
                    
                    // AR
                    if($section_id == 4) {
                        $class_teacher = "MS. KARMA";
                    }
                }
                
                foreach($students as $student) {
                    $student_evolution = $this->Marks->get_student_evolution($class_id, $exam_id, $student['id']);
                    $grades = explode(",", $student_evolution);
                    
                    $attendence = $this->ExamAttendence->get_student_attendence_percentage($class_id, $exam_id, $student['id']);
                    $remark     = $this->Remarks->get_student_remarks($class_id, $exam_id, $student['id']);
                    $is_absent  = false;
                    
                    $optional_papers = [];
                    
                    // Subject 3
                    $row = $this->StudentSubject->get_where([
                        "academy_class_id"  => $class_id,
                        "subject_type_id"   => 12,
                        "student_id"        => $student['id'],
                    ]);
                    
                    if($row["subject_id"]) {
                        $subject_id = $row["subject_id"];
                        $subject = $this->Subject->get($subject_id);
                        
                        $optional_papers[] = $subject;
                    }
                    
                    // Subject 8
                    $row = $this->StudentSubject->get_where([
                        "academy_class_id"  => $class_id,
                        "subject_type_id"   => 17,
                        "student_id"        => $student['id'],
                    ]);
                    
                    if($row["subject_id"]) {
                        $subject_id = $row["subject_id"];
                        $subject = $this->Subject->get($subject_id);
                        
                        $optional_papers[] = $subject;
                    }
                    
                    // Subject 7
                    if($section_id == 3) {
                        $row = $this->StudentSubject->get_where([
                            "academy_class_id"  => $class_id,
                            "subject_type_id"   => 13,
                            "student_id"        => $student['id'],
                        ]);
                        
                        if($row["subject_id"]) {
                            $subject_id = $row["subject_id"];
                            $subject = $this->Subject->get($subject_id);
                            
                            $optional_papers[] = $subject;
                        }
                    }
                    
                    // Grade Subjects
                    $first_term_grade_subjects = [
                        "moral_science"     => $this->Marks->get_student_grade($class_id, 2, 23,  $student['id']),
                        "catechism"         => $this->Marks->get_student_grade($class_id, 2, 24,  $student['id']),
                    ];
                    
                    // Grade Subjects
                    $annual_term_grade_subjects = [
                        "moral_science"     => $this->Marks->get_student_grade($class_id, 4, 23,  $student['id']),
                        "catechism"         => $this->Marks->get_student_grade($class_id, 4, 24,  $student['id']),
                    ];
                    
                    
                    // First Term Marks
                    $first_term_marks = [
                        "english_language"      => $this->Marks->get_student_marks($class_id, 2, 2,  $student['id']),
                        "english_literature"    => $this->Marks->get_student_marks($class_id, 2, 1,  $student['id']),
                        "physics"               => $this->Marks->get_student_marks($class_id, 2, 6,  $student['id']),
                        "chemistry"             => $this->Marks->get_student_marks($class_id, 2, 7,  $student['id']),
                        "biology"               => $this->Marks->get_student_marks($class_id, 2, 5,  $student['id']),
                    ];
                    
                    if(count($optional_papers) == 1) {
                        $first_term_marks["optional_paper_1"] = $this->Marks->get_student_marks($class_id, 2, $optional_papers[0]["id"],  $student['id']);
                    }
                    
                    if(count($optional_papers) == 2) {
                        $first_term_marks["optional_paper_1"] = $this->Marks->get_student_marks($class_id, 2, $optional_papers[0]["id"],  $student['id']);
                    
                        $first_term_marks["optional_paper_2"] = $this->Marks->get_student_marks($class_id, 2, $optional_papers[1]["id"],  $student['id']);
                    }
                    
                    
                    // Second Unit Test Marks
                    $second_unit_test_marks = [
                        "english_language"      => $this->Marks->get_student_marks($class_id, 3, 2,  $student['id']),
                        "english_literature"    => $this->Marks->get_student_marks($class_id, 3, 1,  $student['id']),
                        "physics"               => $this->Marks->get_student_marks($class_id, 3, 6,  $student['id']),
                        "chemistry"             => $this->Marks->get_student_marks($class_id, 3, 7,  $student['id']),
                        "biology"               => $this->Marks->get_student_marks($class_id, 3, 5,  $student['id']),
                    ];
                    
                    if(count($optional_papers) == 1) {
                        $second_unit_test_marks["optional_paper_1"] = $this->Marks->get_student_marks($class_id, 3, $optional_papers[0]["id"],  $student['id']);
                    }
                    
                    if(count($optional_papers) == 2) {
                        $second_unit_test_marks["optional_paper_1"] = $this->Marks->get_student_marks($class_id, 3, $optional_papers[0]["id"],  $student['id']);
                    
                        $second_unit_test_marks["optional_paper_2"] = $this->Marks->get_student_marks($class_id, 3, $optional_papers[1]["id"],  $student['id']);
                    }
                    
                    // Annual Term Marks
                    $annual_term_marks = [
                        "english_language"      => $this->Marks->get_student_marks($class_id, 4, 2,  $student['id']),
                        "english_literature"    => $this->Marks->get_student_marks($class_id, 4, 1,  $student['id']),
                        "physics"               => $this->Marks->get_student_marks($class_id, 4, 6,  $student['id']),
                        "chemistry"             => $this->Marks->get_student_marks($class_id, 4, 7,  $student['id']),
                        "biology"               => $this->Marks->get_student_marks($class_id, 4, 5,  $student['id']),
                    ];
                    
                    if(count($optional_papers) == 1) {
                        $annual_term_marks["optional_paper_1"] = $this->Marks->get_student_marks($class_id, 4, $optional_papers[0]["id"],  $student['id']);
                    }
                    
                    if(count($optional_papers) == 2) {
                        $annual_term_marks["optional_paper_1"] = $this->Marks->get_student_marks($class_id, 4, $optional_papers[0]["id"],  $student['id']);
                    
                        $annual_term_marks["optional_paper_2"] = $this->Marks->get_student_marks($class_id, 4, $optional_papers[1]["id"],  $student['id']);
                    }
                    
                    // First Term Totals
                    $first_term_totals = [
                        "english_language"      =>  $first_term_marks["english_language"] * 2,
                        "english_literature"    =>  $first_term_marks["english_literature"] * 2,
                        "physics"               =>  $first_term_marks["physics"] * 2,
                        "chemistry"             =>  $first_term_marks["chemistry"] * 2,
                        "biology"               =>  $first_term_marks["biology"] * 2,
                    ];
                    
                    if(count($optional_papers) == 1)
                    {
                        $first_term_totals["optional_paper_1"] = $first_term_marks["optional_paper_1"] * 2;
                    }
                    
                    if(count($optional_papers) == 2)
                    {
                        $first_term_totals["optional_paper_1"] = $first_term_marks["optional_paper_1"] * 2;
                        $first_term_totals["optional_paper_2"] = $first_term_marks["optional_paper_2"] * 2;
                    }
                    
                    $annual_term_totals = [
                        "english_language"      =>  $second_unit_test_marks["english_language"]     + $annual_term_marks["english_language"],
                        "english_literature"    =>  $second_unit_test_marks["english_literature"]   + $annual_term_marks["english_literature"],
                        "physics"               =>  $second_unit_test_marks["physics"]              + $annual_term_marks["physics"],
                        "chemistry"             =>  $second_unit_test_marks["chemistry"]            + $annual_term_marks["chemistry"],
                        "biology"               =>  $second_unit_test_marks["biology"]              + $annual_term_marks["biology"],
                    ];
                    
                    if(count($optional_papers) == 1)
                    {
                        $annual_term_totals["optional_paper_1"] = $second_unit_test_marks["optional_paper_1"]     + $annual_term_marks["optional_paper_1"];
                    }
                    
                    if(count($optional_papers) == 2)
                    {
                        $annual_term_totals["optional_paper_1"] = $second_unit_test_marks["optional_paper_1"]     + $annual_term_marks["optional_paper_1"];
                        $annual_term_totals["optional_paper_2"] = $second_unit_test_marks["optional_paper_2"]     + $annual_term_marks["optional_paper_2"];
                    }
                    
                    $first_term_avg = [
                        "english"               => ceil(($first_term_totals["english_language"] + $first_term_totals["english_literature"]) / 2),
                        "physics"               => $first_term_totals["physics"],
                        "chemistry"             => $first_term_totals["chemistry"],
                        "biology"               => $first_term_totals["biology"],
                    ];
                    
                    if(count($optional_papers) == 1)
                    {
                        $first_term_avg["optional_paper_1"] = $first_term_totals["optional_paper_1"];
                    }
                    
                    if(count($optional_papers) == 2)
                    {
                        $first_term_avg["optional_paper_1"] = $first_term_totals["optional_paper_1"];
                        $first_term_avg["optional_paper_2"] = $first_term_totals["optional_paper_2"];
                    }
                    

                    $annual_term_avg = [
                        "english"               => ceil(($annual_term_totals["english_language"] + $annual_term_totals["english_literature"]) / 2),
                        "physics"               => $annual_term_totals["physics"],
                        "chemistry"             => $annual_term_totals["chemistry"],
                        "biology"               => $annual_term_totals["biology"]
                    ];
                    
                    if(count($optional_papers) == 1)
                    {
                        $annual_term_avg["optional_paper_1"] = $annual_term_totals["optional_paper_1"];
                    }
                    
                    if(count($optional_papers) == 2)
                    {
                        $annual_term_avg["optional_paper_1"] = $annual_term_totals["optional_paper_1"];
                        $annual_term_avg["optional_paper_2"] = $annual_term_totals["optional_paper_2"];
                    }
                    
                    
                    $final_avg = [
                        "english"           => ceil(($first_term_avg["english"]     + $annual_term_avg["english"]) / 2),
                        "physics"           => ceil(($first_term_avg["physics"]     + $annual_term_avg["physics"]) / 2),
                        "chemistry"         => ceil(($first_term_avg["chemistry"]   + $annual_term_avg["chemistry"]) / 2),
                        "biology"           => ceil(($first_term_avg["biology"]     + $annual_term_avg["biology"]) / 2),
                    ];
                    
                    if(count($optional_papers) == 1)
                    {
                        $final_avg["optional_paper_1"] = ceil(($first_term_avg["optional_paper_1"] + $annual_term_avg["optional_paper_1"]) / 2);
                    }
                    
                    if(count($optional_papers) == 2)
                    {
                        $final_avg["optional_paper_1"] = ceil(($first_term_avg["optional_paper_1"] + $annual_term_avg["optional_paper_1"]) / 2);
                        $final_avg["optional_paper_2"] = ceil(($first_term_avg["optional_paper_2"] + $annual_term_avg["optional_paper_2"]) / 2);
                    }
                    
                    $first_term_merks_values  = array_values($first_term_marks);
                    $annual_term_merks_values = array_values($annual_term_marks);
                    $values = array_merge($first_term_merks_values, $annual_term_merks_values);
                    
                    foreach($values as &$value)
                        $value = strtolower($value);
                    
                    if(in_array("ab", $values))
                        $is_absent = true;
                    
                    $final_avg_total    =  $final_avg["english"] + $final_avg["physics"] + $final_avg["chemistry"] + $final_avg["biology"]; 
                    
                    if(count($optional_papers) == 1){
                        $final_avg_total = $final_avg_total + $final_avg["optional_paper_1"];
                    }
                    
                    if(count($optional_papers) == 2){
                        $final_avg_total = $final_avg_total + $final_avg["optional_paper_1"];
                        $final_avg_total = $final_avg_total + $final_avg["optional_paper_2"];
                    }
                    
                    
                    $final_percentage   =  ceil($final_avg_total / count($final_avg));
                    
                    $points = [];
                    $total_point = 0;
                    $division = "";
                    
                    foreach($final_avg as $key => $value) {
                        
                        $point = "";
                        
                        if($value >= 90 && $value <= 100) {
                            $point = 1;
                        }
                        elseif($value >= 80 && $value <= 89) {
                            $point = 2;
                        }
                        elseif($value >= 70 && $value <= 79) {
                            $point = 3;
                        }
                        elseif($value >= 60 && $value <= 69) {
                            $point = 4;
                        }
                        elseif($value >= 50 && $value <= 59) {
                            $point = 5;
                        }
                        elseif($value >= 46 && $value <= 49) {
                            $point = 6;
                        }
                        elseif($value == 45) {
                            $point = 7;
                        }
                        else {
                            $point = 8;
                        }
                        
                        $total_point += $point;
                        $points[$key] = $point;
                    }
                    
                    
                    if($total_point > 44) {
                        $division = "Unsatisfactory";
                    }
                    elseif($total_point >= 39 && $total_point <= 44) {
                        $division = "Pass";
                    }
                    elseif($total_point >= 31 && $total_point <= 38) {
                        $division = "3rd";
                    }
                    elseif($total_point >= 21 && $total_point <= 30) {
                        $division = "2nd";
                    }
                    elseif($total_point <= 21) {
                        $division = "1st";
                    }
                    else {
                        $division = "";
                    }
                
                    if($final_avg["english"] >= 35)
                    {
                        $passed_in_english = true;
                    }
                    else
                    {
                        $number_of_failed_subject++;
                    }
                    
                    // $passed_in_english = $final_avg["english"] >= 35 ? true : false;
                    $number_of_failed_subject = 0;
                    $eligible_for_rank = true;
                    $passed = true;

                     
                    if($final_avg["physics"] < 35)  {$number_of_failed_subject++;}
                    if($final_avg["chemistry"] < 35)  {$number_of_failed_subject++;}
                    if($final_avg["biology"] < 35)  {$number_of_failed_subject++;}
                    
                    
                    if(isset($final_avg["optional_paper_1"])) {
                        if($final_avg["optional_paper_1"] < 35) {$number_of_failed_subject++;}
                    }
                    
                    if(isset($final_avg["optional_paper_2"])) {
                        if($final_avg["optional_paper_2"] < 35) {$number_of_failed_subject++;}
                    }
                    
                    // Pass & Fail Condition
                    if(!$passed_in_english || $number_of_failed_subject >=3) {
                        $passed = false;
                        $eligible_for_rank = false;
                    }
                    else {
                        $passed = true;
                         
                        if($number_of_failed_subject == 1 || $number_of_failed_subject == 2){
                            $eligible_for_rank = false;    
                        }
                    }
                    
                    
                    if($eligible_for_rank) {
                        if(!in_array($final_avg_total, $ranks)) {
                            $ranks[] = $final_avg_total;
                        }    
                    }

                    $data = [
                        "name"                          => $student["f_name"] . " " . $student["m_name"] . " " . $student["l_name"],
                        "roll_no"                       => $student["roll_no"],
                        "student_no"                    => $student["student_no"],
                        "student_id"                    => $student["id"],
                        "remarks"                       => $remark,
                        "evolution_grades"              => $grades,
                        "first_unit_test_marks"         => $first_unit_test_marks,
                        "first_term_marks"              => $first_term_marks,
                        "second_unit_test_marks"        => $second_unit_test_marks,
                        "annual_term_marks"             => $annual_term_marks,
                        "first_term_totals"             => $first_term_totals,
                        "annual_term_totals"            => $annual_term_totals,
                        "first_term_avg"                => $first_term_avg,
                        "annual_term_avg"               => $annual_term_avg,
                        "final_avg"                     => $final_avg,
                        "final_avg_total"               => $final_avg_total,
                        "final_percentage"              => $final_percentage,
                        "first_term_grade_subjects"     => $first_term_grade_subjects,
                        "annual_term_grade_subjects"    => $annual_term_grade_subjects,
                        "points"                        => $points,
                        "total_point"                   => $total_point,
                        "division"                      => $division,
                        "attendence"                    => $attendence,
                        "subject"                       => $subject,
                        "is_absent"                     => $is_absent,
                        "passed"                        => $passed,
                        "eligible_for_rank"             => $eligible_for_rank,
                        "grade_subjects"                => $grade_subjects,
                        "class_teacher"                 => $class_teacher,
                        "optional_papers"               => $optional_papers,
                    ];
                    
                    $records[] = $data;
                }
                
                if($report_for != "all") {
                    $student_id = $selected_student_id;
                    
                    $temp = [];
                    
                    foreach($records as $record) {
                        if($record["student_id"] == $student_id) {
                            $temp[] = $record;
                        }
                    }
                    
                    $records = $temp;
                }
                
                $class = $this->AcademyClass->get($class_id);
                $section = $this->Section->get($section_id);
                    
                rsort($ranks);
            
                // echo "<pre>";
                // print_r($ranks);
                // echo "</pre>";
    
                return ["students" => $records, "ranks" => $all_ranks];
            }
            
            // Class XI Section AR
            else if(in_array($class_id, [12]) && $section_id == 4) 
            { 
            
                $students = $this->Student->get_where([
                    "class_id"                      => $class_id,
                    "section_id"                    => $section_id,
                    "student_session.promoted"      => "ANY",
                    "student_session.withdraw"      => "ANY",
                ]);
                
                
                $records = [];
                
                $ranks = [];
                
                $class_teacher = "";
                if($class_id == 12) {
                    // SC
                    if($section_id == 3) {
                        $class_teacher = "MS. ROSELINE";
                    }
                    
                    // AR
                    if($section_id == 4) {
                        $class_teacher = "MS. KARMA";
                    }
                }
                
                foreach($students as $student) {
                    $student_evolution = $this->Marks->get_student_evolution($class_id, $exam_id, $student['id']);
                    $grades = explode(",", $student_evolution);
                    
                    $attendence = $this->ExamAttendence->get_student_attendence_percentage($class_id, $exam_id, $student['id']);
                    $remark     = $this->Remarks->get_student_remarks($class_id, $exam_id, $student['id']);
                    $is_absent  = false;
                    
                    $optional_papers = [];
                    
                    // Subject 3
                    $row = $this->StudentSubject->get_where([
                        "academy_class_id"  => $class_id,
                        "subject_type_id"   => 12,
                        "student_id"        => $student['id'],
                    ]);
                    
                    if($row["subject_id"]) {
                        $subject_id = $row["subject_id"];
                        $subject = $this->Subject->get($subject_id);
                        
                        $optional_papers[] = $subject;
                    }
                    
                    // Subject 8
                    $row = $this->StudentSubject->get_where([
                        "academy_class_id"  => $class_id,
                        "subject_type_id"   => 17,
                        "student_id"        => $student['id'],
                    ]);
                    
                    if($row["subject_id"]) {
                        $subject_id = $row["subject_id"];
                        $subject = $this->Subject->get($subject_id);
                        
                        $optional_papers[] = $subject;
                    }
                    
                    // Subject 7
                    if($section_id == 4) {
                        $row = $this->StudentSubject->get_where([
                            "academy_class_id"  => $class_id,
                            "subject_type_id"   => 16,
                            "student_id"        => $student['id'],
                        ]);
                        
                        if($row["subject_id"]) {
                            $subject_id = $row["subject_id"];
                            $subject = $this->Subject->get($subject_id);
                            
                            $optional_papers[] = $subject;
                        }
                    }
                    
                    // Grade Subjects
                    $first_term_grade_subjects = [
                        "moral_science"     => $this->Marks->get_student_grade($class_id, 2, 23,  $student['id']),
                        "catechism"         => $this->Marks->get_student_grade($class_id, 2, 24,  $student['id']),
                    ];
                    
                    // Grade Subjects
                    $annual_term_grade_subjects = [
                        "moral_science"     => $this->Marks->get_student_grade($class_id, 4, 23,  $student['id']),
                        "catechism"         => $this->Marks->get_student_grade($class_id, 4, 24,  $student['id']),
                    ];
                    
                    
                    // First Term Marks
                    $first_term_marks = [
                        "english_language"      => $this->Marks->get_student_marks($class_id, 2, 2,  $student['id']),
                        "english_literature"    => $this->Marks->get_student_marks($class_id, 2, 1,  $student['id']),
                        "history"               => $this->Marks->get_student_marks($class_id, 2, 9,  $student['id']),
                        "political_science"     => $this->Marks->get_student_marks($class_id, 2, 21,  $student['id']),
                        "sociology"             => $this->Marks->get_student_marks($class_id, 2, 29,  $student['id']),
                    ];
                    
                    if(count($optional_papers) == 1) {
                        $first_term_marks["optional_paper_1"] = $this->Marks->get_student_marks($class_id, 2, $optional_papers[0]["id"],  $student['id']);
                    }
                    
                    if(count($optional_papers) == 2) {
                        $first_term_marks["optional_paper_1"] = $this->Marks->get_student_marks($class_id, 2, $optional_papers[0]["id"],  $student['id']);
                    
                        $first_term_marks["optional_paper_2"] = $this->Marks->get_student_marks($class_id, 2, $optional_papers[1]["id"],  $student['id']);
                    }
                    
                    
                    // Second Unit Test Marks
                    $second_unit_test_marks = [
                        "english_language"      => $this->Marks->get_student_marks($class_id, 3, 2,  $student['id']),
                        "english_literature"    => $this->Marks->get_student_marks($class_id, 3, 1,  $student['id']),
                        "history"               => $this->Marks->get_student_marks($class_id, 3, 9,  $student['id']),
                        "political_science"     => $this->Marks->get_student_marks($class_id, 3, 21,  $student['id']),
                        "sociology"             => $this->Marks->get_student_marks($class_id, 3, 29,  $student['id']),
                    ];
                    
                    if(count($optional_papers) == 1) {
                        $second_unit_test_marks["optional_paper_1"] = $this->Marks->get_student_marks($class_id, 3, $optional_papers[0]["id"],  $student['id']);
                    }
                    
                    if(count($optional_papers) == 2) {
                        $second_unit_test_marks["optional_paper_1"] = $this->Marks->get_student_marks($class_id, 3, $optional_papers[0]["id"],  $student['id']);
                    
                        $second_unit_test_marks["optional_paper_2"] = $this->Marks->get_student_marks($class_id, 3, $optional_papers[1]["id"],  $student['id']);
                    }
                    
                    // Annual Term Marks
                    $annual_term_marks = [
                        "english_language"      => $this->Marks->get_student_marks($class_id, 4, 2,  $student['id']),
                        "english_literature"    => $this->Marks->get_student_marks($class_id, 4, 1,  $student['id']),
                        "history"               => $this->Marks->get_student_marks($class_id, 4, 9,  $student['id']),
                        "political_science"     => $this->Marks->get_student_marks($class_id, 4, 21,  $student['id']),
                        "sociology"             => $this->Marks->get_student_marks($class_id, 4, 29,  $student['id']),
                    ];
                    
                    if(count($optional_papers) == 1) {
                        $annual_term_marks["optional_paper_1"] = $this->Marks->get_student_marks($class_id, 4, $optional_papers[0]["id"],  $student['id']);
                    }
                    
                    if(count($optional_papers) == 2) {
                        $annual_term_marks["optional_paper_1"] = $this->Marks->get_student_marks($class_id, 4, $optional_papers[0]["id"],  $student['id']);
                    
                        $annual_term_marks["optional_paper_2"] = $this->Marks->get_student_marks($class_id, 4, $optional_papers[1]["id"],  $student['id']);
                    }
                    
                    // First Term Totals
                    $first_term_totals = [
                        "english_language"      =>  $first_term_marks["english_language"] * 2,
                        "english_literature"    =>  $first_term_marks["english_literature"] * 2,
                        "history"               =>  $first_term_marks["history"] * 2,
                        "political_science"     =>  $first_term_marks["political_science"] * 2,
                        "sociology"             =>  $first_term_marks["sociology"] * 2,
                    ];
                    
                    if(count($optional_papers) == 1)
                    {
                        $first_term_totals["optional_paper_1"] = $first_term_marks["optional_paper_1"] * 2;
                    }
                    
                    if(count($optional_papers) == 2)
                    {
                        $first_term_totals["optional_paper_1"] = $first_term_marks["optional_paper_1"] * 2;
                        $first_term_totals["optional_paper_2"] = $first_term_marks["optional_paper_2"] * 2;
                    }
                    
                    $annual_term_totals = [
                        "english_language"      =>  $second_unit_test_marks["english_language"]     + $annual_term_marks["english_language"],
                        "english_literature"    =>  $second_unit_test_marks["english_literature"]   + $annual_term_marks["english_literature"],
                        "history"               =>  $second_unit_test_marks["history"]              + $annual_term_marks["history"],
                        "political_science"     =>  $second_unit_test_marks["political_science"]    + $annual_term_marks["political_science"],
                        "sociology"             =>  $second_unit_test_marks["sociology"]            + $annual_term_marks["sociology"],
                    ];
                    
                    if(count($optional_papers) == 1)
                    {
                        $annual_term_totals["optional_paper_1"] = $second_unit_test_marks["optional_paper_1"]     + $annual_term_marks["optional_paper_1"];
                    }
                    
                    if(count($optional_papers) == 2)
                    {
                        $annual_term_totals["optional_paper_1"] = $second_unit_test_marks["optional_paper_1"]     + $annual_term_marks["optional_paper_1"];
                        $annual_term_totals["optional_paper_2"] = $second_unit_test_marks["optional_paper_2"]     + $annual_term_marks["optional_paper_2"];
                    }
                    
                    $first_term_avg = [
                        "english"               => ceil(($first_term_totals["english_language"] + $first_term_totals["english_literature"]) / 2),
                        "history"               => $first_term_totals["history"],
                        "political_science"     => $first_term_totals["political_science"],
                        "sociology"             => $first_term_totals["sociology"],
                    ];
                    
                    if(count($optional_papers) == 1)
                    {
                        $first_term_avg["optional_paper_1"] = $first_term_totals["optional_paper_1"];
                    }
                    
                    if(count($optional_papers) == 2)
                    {
                        $first_term_avg["optional_paper_1"] = $first_term_totals["optional_paper_1"];
                        $first_term_avg["optional_paper_2"] = $first_term_totals["optional_paper_2"];
                    }
                    

                    $annual_term_avg = [
                        "english"               => ceil(($annual_term_totals["english_language"] + $annual_term_totals["english_literature"]) / 2),
                        "history"               => $annual_term_totals["history"],
                        "political_science"     => $annual_term_totals["political_science"],
                        "sociology"             => $annual_term_totals["sociology"]
                    ];
                    
                    if(count($optional_papers) == 1)
                    {
                        $annual_term_avg["optional_paper_1"] = $annual_term_totals["optional_paper_1"];
                    }
                    
                    if(count($optional_papers) == 2)
                    {
                        $annual_term_avg["optional_paper_1"] = $annual_term_totals["optional_paper_1"];
                        $annual_term_avg["optional_paper_2"] = $annual_term_totals["optional_paper_2"];
                    }
                    
                    
                    $final_avg = [
                        "english"           => ceil(($first_term_avg["english"]             + $annual_term_avg["english"]) / 2),
                        "history"           => ceil(($first_term_avg["history"]             + $annual_term_avg["history"]) / 2),
                        "political_science" => ceil(($first_term_avg["political_science"]   + $annual_term_avg["political_science"]) / 2),
                        "sociology"         => ceil(($first_term_avg["sociology"]           + $annual_term_avg["sociology"]) / 2),
                    ];
                    
                    if(count($optional_papers) == 1)
                    {
                        $final_avg["optional_paper_1"] = ceil(($first_term_avg["optional_paper_1"] + $annual_term_avg["optional_paper_1"]) / 2);
                    }
                    
                    if(count($optional_papers) == 2)
                    {
                        $final_avg["optional_paper_1"] = ceil(($first_term_avg["optional_paper_1"] + $annual_term_avg["optional_paper_1"]) / 2);
                        $final_avg["optional_paper_2"] = ceil(($first_term_avg["optional_paper_2"] + $annual_term_avg["optional_paper_2"]) / 2);
                    }
                    
                    $first_term_merks_values  = array_values($first_term_marks);
                    $annual_term_merks_values = array_values($annual_term_marks);
                    $values = array_merge($first_term_merks_values, $annual_term_merks_values);
                    
                    foreach($values as &$value)
                        $value = strtolower($value);
                    
                    if(in_array("ab", $values))
                        $is_absent = true;
                    
                    $final_avg_total    =  $final_avg["english"] + $final_avg["history"] + $final_avg["political_science"] + $final_avg["sociology"]; 
                    
                    if(count($optional_papers) == 1){
                        $final_avg_total = $final_avg_total + $final_avg["optional_paper_1"];
                    }
                    
                    if(count($optional_papers) == 2){
                        $final_avg_total = $final_avg_total + $final_avg["optional_paper_1"];
                        $final_avg_total = $final_avg_total + $final_avg["optional_paper_2"];
                    }
                    
                    
                    $final_percentage   =  ceil($final_avg_total / count($final_avg));
                    
                    $points = [];
                    $total_point = 0;
                    $division = "";
                    
                    foreach($final_avg as $key => $value) {
                        
                        $point = "";
                        
                        if($value >= 90 && $value <= 100) {
                            $point = 1;
                        }
                        elseif($value >= 80 && $value <= 89) {
                            $point = 2;
                        }
                        elseif($value >= 70 && $value <= 79) {
                            $point = 3;
                        }
                        elseif($value >= 60 && $value <= 69) {
                            $point = 4;
                        }
                        elseif($value >= 50 && $value <= 59) {
                            $point = 5;
                        }
                        elseif($value >= 46 && $value <= 49) {
                            $point = 6;
                        }
                        elseif($value == 45) {
                            $point = 7;
                        }
                        else {
                            $point = 8;
                        }
                        
                        $total_point += $point;
                        $points[$key] = $point;
                    }
                    
                    
                    if($total_point > 44) {
                        $division = "Unsatisfactory";
                    }
                    elseif($total_point >= 39 && $total_point <= 44) {
                        $division = "Pass";
                    }
                    elseif($total_point >= 31 && $total_point <= 38) {
                        $division = "3rd";
                    }
                    elseif($total_point >= 21 && $total_point <= 30) {
                        $division = "2nd";
                    }
                    elseif($total_point <= 21) {
                        $division = "1st";
                    }
                    else {
                        $division = "";
                    }
                
                    if($final_avg["english"] >= 35)
                    {
                        $passed_in_english = true;
                    }
                    else
                    {
                        $number_of_failed_subject++;
                    }
                    
                    // $passed_in_english = $final_avg["english"] >= 35 ? true : false;
                    $number_of_failed_subject = 0;
                    $eligible_for_rank = true;
                    $passed = true;

                     
                    if($final_avg["history"] < 35)  {$number_of_failed_subject++;}
                    if($final_avg["political_science"] < 35)  {$number_of_failed_subject++;}
                    if($final_avg["sociology"] < 35)  {$number_of_failed_subject++;}
                    
                    
                    if(isset($final_avg["optional_paper_1"])) {
                        if($final_avg["optional_paper_1"] < 35) {$number_of_failed_subject++;}
                    }
                    
                    if(isset($final_avg["optional_paper_2"])) {
                        if($final_avg["optional_paper_2"] < 35) {$number_of_failed_subject++;}
                    }
                    
                    // Pass & Fail Condition
                    if(!$passed_in_english || $number_of_failed_subject >=3) {
                        $passed = false;
                        $eligible_for_rank = false;
                    }
                    else {
                        $passed = true;
                         
                        if($number_of_failed_subject == 1 || $number_of_failed_subject == 2){
                            $eligible_for_rank = false;    
                        }
                    }
                    
                    
                    if($eligible_for_rank) {
                        if(!in_array($final_avg_total, $ranks)) {
                            $ranks[] = $final_avg_total;
                        }    
                    }

                    $data = [
                        "name"                  => $student["f_name"] . " " . $student["m_name"] . " " . $student["l_name"],
                        "roll_no"               => $student["roll_no"],
                        "student_no"            => $student["student_no"],
                        "student_id"            => $student["id"],
                        "remarks"               => $remark,
                        "evolution_grades"              => $grades,
                        "first_unit_test_marks"         => $first_unit_test_marks,
                        "first_term_marks"              => $first_term_marks,
                        "second_unit_test_marks"        => $second_unit_test_marks,
                        "annual_term_marks"             => $annual_term_marks,
                        "first_term_totals"             => $first_term_totals,
                        "annual_term_totals"            => $annual_term_totals,
                        "first_term_avg"                => $first_term_avg,
                        "annual_term_avg"               => $annual_term_avg,
                        "final_avg"                     => $final_avg,
                        "final_avg_total"               => $final_avg_total,
                        "final_percentage"              => $final_percentage,
                        "first_term_grade_subjects"     => $first_term_grade_subjects,
                        "annual_term_grade_subjects"    => $annual_term_grade_subjects,
                        "points"                => $points,
                        "total_point"           => $total_point,
                        "division"                      => $division,
                        "attendence"                    => $attendence,
                        "subject"                       => $subject,
                        "is_absent"                     => $is_absent,
                        "passed"                => $passed,
                        "eligible_for_rank"     => $eligible_for_rank,
                        "grade_subjects"        => $grade_subjects,
                        "class_teacher"         => $class_teacher,
                        "optional_papers" => $optional_papers,
                    ];
                    
                    $records[] = $data;
                }
                
                if($report_for != "all") {
                    $student_id = $selected_student_id;
                    
                    $temp = [];
                    
                    foreach($records as $record) {
                        if($record["student_id"] == $student_id) {
                            $temp[] = $record;
                        }
                    }
                    
                    $records = $temp;
                }
                
                $class = $this->AcademyClass->get($class_id);
                $section = $this->Section->get($section_id);
                    
                rsort($ranks);
            
                // echo "<pre>";
                // print_r($records);
                // echo "</pre>";
                // return;
    
               return ["students" => $records, "ranks" => $all_ranks];
            }

            // Class XII Section SC
            else if(in_array($class_id, [13]) && $section_id == 3 ) 
            { 
            
                $students = $this->Student->get_where([
                    "class_id"                      => $class_id,
                    "section_id"                    => $section_id,
                    "student_session.promoted"      => "ANY",
                    "student_session.withdraw"      => "ANY",
                ]);
                
                
                $records = [];
                
                $ranks = [];
                
                $class_teacher = "";
                if($class_id == 13) {
                    // SC
                    if($section_id == 3) {
                        $class_teacher = "MS. ANITA";
                    }
                    
                    // AR
                    if($section_id == 4) {
                        $class_teacher = "MS. ONGMU";
                    }
                }
                
                
                foreach($students as $student) {
                    $student_evolution = $this->Marks->get_student_evolution($class_id, $exam_id, $student['id']);
                    $grades = explode(",", $student_evolution);
                    
                    $attendence = $this->ExamAttendence->get_student_attendence_percentage($class_id, $exam_id, $student['id']);
                    $remark     = $this->Remarks->get_student_remarks($class_id, $exam_id, $student['id']);
                    $is_absent  = false;
                    
                    $optional_papers = [];
                    
                    // Subject 3
                    $row = $this->StudentSubject->get_where([
                        "academy_class_id"  => $class_id,
                        "subject_type_id"   => 12,
                        "student_id"        => $student['id'],
                    ]);
                    
                    if($row["subject_id"]) {
                        $subject_id = $row["subject_id"];
                        $subject = $this->Subject->get($subject_id);
                        
                        $optional_papers[] = $subject;
                    }
                    
                    // Subject 8
                    $row = $this->StudentSubject->get_where([
                        "academy_class_id"  => $class_id,
                        "subject_type_id"   => 17,
                        "student_id"        => $student['id'],
                    ]);
                    
                    if($row["subject_id"]) {
                        $subject_id = $row["subject_id"];
                        $subject = $this->Subject->get($subject_id);
                        
                        $optional_papers[] = $subject;
                    }
                    
                    // Subject 4
                    if($section_id == 3) {
                        $row = $this->StudentSubject->get_where([
                            "academy_class_id"  => $class_id,
                            "subject_type_id"   => 13,
                            "student_id"        => $student['id'],
                        ]);
                        
                        if($row["subject_id"]) {
                            $subject_id = $row["subject_id"];
                            $subject = $this->Subject->get($subject_id);
                            
                            $optional_papers[] = $subject;
                        }
                    }
                    
                    // Grade Subjects
                    $first_term_grade_subjects = [
                        "moral_science"     => $this->Marks->get_student_grade($class_id, 2, 23,  $student['id']),
                        "catechism"         => $this->Marks->get_student_grade($class_id, 2, 24,  $student['id']),
                    ];
                    
                    // Grade Subjects
                    $annual_term_grade_subjects = [
                        "moral_science"     => $this->Marks->get_student_grade($class_id, 4, 23,  $student['id']),
                        "catechism"         => $this->Marks->get_student_grade($class_id, 4, 24,  $student['id']),
                    ];
                    
                      
                    // First Term Marks
                    $first_unit_test_marks = [
                        "english_language"      => $this->Marks->get_student_marks($class_id, 1, 2,  $student['id']),
                        "english_literature"    => $this->Marks->get_student_marks($class_id, 1, 1,  $student['id']),
                        "physics"               => $this->Marks->get_student_marks($class_id, 1, 6,  $student['id']),
                        "chemistry"             => $this->Marks->get_student_marks($class_id, 1, 7,  $student['id']),
                        "biology"               => $this->Marks->get_student_marks($class_id, 1, 5,  $student['id']),
                    ];
                    
                                        
                    if(count($optional_papers) == 1) {
                        $first_unit_test_marks["optional_paper_1"] = $this->Marks->get_student_marks($class_id, 1, $optional_papers[0]["id"],  $student['id']);
                    }
                    
                    if(count($optional_papers) == 2) {
                        $first_unit_test_marks["optional_paper_1"] = $this->Marks->get_student_marks($class_id, 1, $optional_papers[0]["id"],  $student['id']);
                    
                        $first_unit_test_marks["optional_paper_2"] = $this->Marks->get_student_marks($class_id, 1, $optional_papers[1]["id"],  $student['id']);
                    }
                    
                    
                    // First Term Marks
                    $first_term_marks = [
                        "english_language"      => $this->Marks->get_student_marks($class_id, 2, 2,  $student['id']),
                        "english_literature"    => $this->Marks->get_student_marks($class_id, 2, 1,  $student['id']),
                        "physics"               => $this->Marks->get_student_marks($class_id, 2, 6,  $student['id']),
                        "chemistry"             => $this->Marks->get_student_marks($class_id, 2, 7,  $student['id']),
                        "biology"               => $this->Marks->get_student_marks($class_id, 2, 5,  $student['id']),
                    ];
                    
                    if(count($optional_papers) == 1) {
                        $first_term_marks["optional_paper_1"] = $this->Marks->get_student_marks($class_id, 2, $optional_papers[0]["id"],  $student['id']);
                    }
                    
                    if(count($optional_papers) == 2) {
                        $first_term_marks["optional_paper_1"] = $this->Marks->get_student_marks($class_id, 2, $optional_papers[0]["id"],  $student['id']);
                    
                        $first_term_marks["optional_paper_2"] = $this->Marks->get_student_marks($class_id, 2, $optional_papers[1]["id"],  $student['id']);
                    }
                    
                    
                    // Second Unit Test Marks
                    $second_unit_test_marks = [
                        "english_language"      => $this->Marks->get_student_marks($class_id, 3, 2,  $student['id']),
                        "english_literature"    => $this->Marks->get_student_marks($class_id, 3, 1,  $student['id']),
                        "physics"               => $this->Marks->get_student_marks($class_id, 3, 6,  $student['id']),
                        "chemistry"             => $this->Marks->get_student_marks($class_id, 3, 7,  $student['id']),
                        "biology"               => $this->Marks->get_student_marks($class_id, 3, 5,  $student['id']),
                    ];
                    
                    if(count($optional_papers) == 1) {
                        $second_unit_test_marks["optional_paper_1"] = $this->Marks->get_student_marks($class_id, 3, $optional_papers[0]["id"],  $student['id']);
                    }
                    
                    if(count($optional_papers) == 2) {
                        $second_unit_test_marks["optional_paper_1"] = $this->Marks->get_student_marks($class_id, 3, $optional_papers[0]["id"],  $student['id']);
                    
                        $second_unit_test_marks["optional_paper_2"] = $this->Marks->get_student_marks($class_id, 3, $optional_papers[1]["id"],  $student['id']);
                    }
                    
                    // Annual Term Marks
                    $annual_term_marks = [
                        "english_language"      => $this->Marks->get_student_marks($class_id, 4, 2,  $student['id']),
                        "english_literature"    => $this->Marks->get_student_marks($class_id, 4, 1,  $student['id']),
                        "physics"               => $this->Marks->get_student_marks($class_id, 4, 6,  $student['id']),
                        "chemistry"             => $this->Marks->get_student_marks($class_id, 4, 7,  $student['id']),
                        "biology"               => $this->Marks->get_student_marks($class_id, 4, 5,  $student['id']),
                    ];
                    
                    if(count($optional_papers) == 1) {
                        $annual_term_marks["optional_paper_1"] = $this->Marks->get_student_marks($class_id, 4, $optional_papers[0]["id"],  $student['id']);
                    }
                    
                    if(count($optional_papers) == 2) {
                        $annual_term_marks["optional_paper_1"] = $this->Marks->get_student_marks($class_id, 4, $optional_papers[0]["id"],  $student['id']);
                    
                        $annual_term_marks["optional_paper_2"] = $this->Marks->get_student_marks($class_id, 4, $optional_papers[1]["id"],  $student['id']);
                    }
                    
                    // First Term Totals
                    $first_term_totals = [
                        "english_language"      =>  $first_term_marks["english_language"]   + $first_unit_test_marks["english_language"],
                        "english_literature"    =>  $first_term_marks["english_literature"] + $first_unit_test_marks["english_literature"],
                        "physics"               =>  $first_term_marks["physics"]            + $first_unit_test_marks["physics"],
                        "chemistry"             =>  $first_term_marks["chemistry"]          + $first_unit_test_marks["chemistry"],
                        "biology"               =>  $first_term_marks["biology"]            + $first_unit_test_marks["biology"],
                    ];
                    
                    if(count($optional_papers) == 1)
                    {
                        $first_term_totals["optional_paper_1"] = $first_term_marks["optional_paper_1"] + $first_unit_test_marks["optional_paper_1"];
                    }
                    
                    if(count($optional_papers) == 2)
                    {
                        $first_term_totals["optional_paper_1"] = $first_term_marks["optional_paper_1"] + $first_unit_test_marks["optional_paper_1"];
                        $first_term_totals["optional_paper_2"] = $first_term_marks["optional_paper_2"] + $first_unit_test_marks["optional_paper_2"];
                    }
                    
                    $annual_term_totals = [
                        "english_language"      =>  $second_unit_test_marks["english_language"]     + $annual_term_marks["english_language"],
                        "english_literature"    =>  $second_unit_test_marks["english_literature"]   + $annual_term_marks["english_literature"],
                        "physics"               =>  $second_unit_test_marks["physics"]              + $annual_term_marks["physics"],
                        "chemistry"             =>  $second_unit_test_marks["chemistry"]            + $annual_term_marks["chemistry"],
                        "biology"               =>  $second_unit_test_marks["biology"]              + $annual_term_marks["biology"],
                    ];
                    
                    if(count($optional_papers) == 1)
                    {
                        $annual_term_totals["optional_paper_1"] = $second_unit_test_marks["optional_paper_1"]     + $annual_term_marks["optional_paper_1"];
                    }
                    
                    if(count($optional_papers) == 2)
                    {
                        $annual_term_totals["optional_paper_1"] = $second_unit_test_marks["optional_paper_1"]     + $annual_term_marks["optional_paper_1"];
                        $annual_term_totals["optional_paper_2"] = $second_unit_test_marks["optional_paper_2"]     + $annual_term_marks["optional_paper_2"];
                    }
                    
                    $first_term_avg = [
                        "english"               => ceil(($first_term_totals["english_language"] + $first_term_totals["english_literature"]) / 2),
                        "physics"               => $first_term_totals["physics"],
                        "chemistry"             => $first_term_totals["chemistry"],
                        "biology"               => $first_term_totals["biology"],
                    ];
                    
                    if(count($optional_papers) == 1)
                    {
                        $first_term_avg["optional_paper_1"] = $first_term_totals["optional_paper_1"];
                    }
                    
                    if(count($optional_papers) == 2)
                    {
                        $first_term_avg["optional_paper_1"] = $first_term_totals["optional_paper_1"];
                        $first_term_avg["optional_paper_2"] = $first_term_totals["optional_paper_2"];
                    }
                    

                    $annual_term_avg = [
                        "english"               => ceil(($annual_term_totals["english_language"] + $annual_term_totals["english_literature"]) / 2),
                        "physics"               => $annual_term_totals["physics"],
                        "chemistry"             => $annual_term_totals["chemistry"],
                        "biology"               => $annual_term_totals["biology"]
                    ];
                    
                    if(count($optional_papers) == 1)
                    {
                        $annual_term_avg["optional_paper_1"] = $annual_term_totals["optional_paper_1"];
                    }
                    
                    if(count($optional_papers) == 2)
                    {
                        $annual_term_avg["optional_paper_1"] = $annual_term_totals["optional_paper_1"];
                        $annual_term_avg["optional_paper_2"] = $annual_term_totals["optional_paper_2"];
                    }
                    
                    
                    $final_avg = [
                        "english"           => ceil(($first_term_avg["english"]     + $annual_term_avg["english"]) / 2),
                        "physics"           => ceil(($first_term_avg["physics"]     + $annual_term_avg["physics"]) / 2),
                        "chemistry"         => ceil(($first_term_avg["chemistry"]   + $annual_term_avg["chemistry"]) / 2),
                        "biology"           => ceil(($first_term_avg["biology"]     + $annual_term_avg["biology"]) / 2),
                    ];
                    
                    if(count($optional_papers) == 1)
                    {
                        $final_avg["optional_paper_1"] = ceil(($first_term_avg["optional_paper_1"] + $annual_term_avg["optional_paper_1"]) / 2);
                    }
                    
                    if(count($optional_papers) == 2)
                    {
                        $final_avg["optional_paper_1"] = ceil(($first_term_avg["optional_paper_1"] + $annual_term_avg["optional_paper_1"]) / 2);
                        $final_avg["optional_paper_2"] = ceil(($first_term_avg["optional_paper_2"] + $annual_term_avg["optional_paper_2"]) / 2);
                    }
                    
                    $first_term_merks_values  = array_values($first_term_marks);
                    $annual_term_merks_values = array_values($annual_term_marks);
                    $values = array_merge($first_term_merks_values, $annual_term_merks_values);
                    
                    foreach($values as &$value)
                        $value = strtolower($value);
                    
                    if(in_array("ab", $values))
                        $is_absent = true;
                    
                    $final_avg_total    =  $final_avg["english"] + $final_avg["physics"] + $final_avg["chemistry"] + $final_avg["biology"]; 
                    
                    if(count($optional_papers) == 1){
                        $final_avg_total = $final_avg_total + $final_avg["optional_paper_1"];
                    }
                    
                    if(count($optional_papers) == 2){
                        $final_avg_total = $final_avg_total + $final_avg["optional_paper_1"];
                        $final_avg_total = $final_avg_total + $final_avg["optional_paper_2"];
                    }
                    
                    
                    $final_percentage   =  ceil($final_avg_total / count($final_avg));
                    
                    $points = [];
                    $total_point = 0;
                    $division = "";
                    
                    foreach($final_avg as $key => $value) {
                        
                        $point = "";
                        
                        if($value >= 90 && $value <= 100) {
                            $point = 1;
                        }
                        elseif($value >= 80 && $value <= 89) {
                            $point = 2;
                        }
                        elseif($value >= 70 && $value <= 79) {
                            $point = 3;
                        }
                        elseif($value >= 60 && $value <= 69) {
                            $point = 4;
                        }
                        elseif($value >= 50 && $value <= 59) {
                            $point = 5;
                        }
                        elseif($value >= 46 && $value <= 49) {
                            $point = 6;
                        }
                        elseif($value == 45) {
                            $point = 7;
                        }
                        else {
                            $point = 8;
                        }
                        
                        $total_point += $point;
                        $points[$key] = $point;
                    }
                    
                    
                    if($total_point > 44) {
                        $division = "Unsatisfactory";
                    }
                    elseif($total_point >= 39 && $total_point <= 44) {
                        $division = "Pass";
                    }
                    elseif($total_point >= 31 && $total_point <= 38) {
                        $division = "3rd";
                    }
                    elseif($total_point >= 21 && $total_point <= 30) {
                        $division = "2nd";
                    }
                    elseif($total_point <= 21) {
                        $division = "1st";
                    }
                    else {
                        $division = "";
                    }
                
                    if($final_avg["english"] >= 35)
                    {
                        $passed_in_english = true;
                    }
                    else
                    {
                        $number_of_failed_subject++;
                    }
                    
                    // $passed_in_english = $final_avg["english"] >= 35 ? true : false;
                    $number_of_failed_subject = 0;
                    $eligible_for_rank = true;
                    $passed = true;

                     
                    if($final_avg["physics"] < 35)  {$number_of_failed_subject++;}
                    if($final_avg["chemistry"] < 35)  {$number_of_failed_subject++;}
                    if($final_avg["biology"] < 35)  {$number_of_failed_subject++;}
                    
                    
                    if(isset($final_avg["optional_paper_1"])) {
                        if($final_avg["optional_paper_1"] < 35) {$number_of_failed_subject++;}
                    }
                    
                    if(isset($final_avg["optional_paper_2"])) {
                        if($final_avg["optional_paper_2"] < 35) {$number_of_failed_subject++;}
                    }
                    
                    // Pass & Fail Condition
                    if(!$passed_in_english || $number_of_failed_subject >=3) {
                        $passed = false;
                        $eligible_for_rank = false;
                    }
                    else {
                        $passed = true;
                         
                        if($number_of_failed_subject == 1 || $number_of_failed_subject == 2){
                            $eligible_for_rank = false;    
                        }
                    }
                    
                    
                    if($eligible_for_rank) {
                        if(!in_array($final_avg_total, $ranks)) {
                            $ranks[] = $final_avg_total;
                        }    
                    }

                    $data = [
                        "name"                          => $student["f_name"] . " " . $student["m_name"] . " " . $student["l_name"],
                        "roll_no"                       => $student["roll_no"],
                        "student_no"                    => $student["student_no"],
                        "student_id"                    => $student["id"],
                        "remarks"                       => $remark,
                        "evolution_grades"              => $grades,
                        "first_unit_test_marks"         => $first_unit_test_marks,
                        "first_term_marks"              => $first_term_marks,
                        "second_unit_test_marks"        => $second_unit_test_marks,
                        "annual_term_marks"             => $annual_term_marks,
                        "first_term_totals"             => $first_term_totals,
                        "annual_term_totals"            => $annual_term_totals,
                        "first_term_avg"                => $first_term_avg,
                        "annual_term_avg"               => $annual_term_avg,
                        "final_avg"                     => $final_avg,
                        "final_avg_total"               => $final_avg_total,
                        "final_percentage"              => $final_percentage,
                        "first_term_grade_subjects"     => $first_term_grade_subjects,
                        "annual_term_grade_subjects"    => $annual_term_grade_subjects,
                        "points"                        => $points,
                        "total_point"                   => $total_point,
                        "division"                      => $division,
                        "attendence"                    => $attendence,
                        "subject"                       => $subject,
                        "is_absent"                     => $is_absent,
                        "passed"                        => $passed,
                        "eligible_for_rank"             => $eligible_for_rank,
                        "grade_subjects"                => $grade_subjects,
                        "class_teacher"                 => $class_teacher,
                        "optional_papers"               => $optional_papers,
                    ];
                    
                    $records[] = $data;
                }
                
                if($report_for != "all") {
                    $student_id = $selected_student_id;
                    
                    $temp = [];
                    
                    foreach($records as $record) {
                        if($record["student_id"] == $student_id) {
                            $temp[] = $record;
                        }
                    }
                    
                    $records = $temp;
                }
                
                $class = $this->AcademyClass->get($class_id);
                $section = $this->Section->get($section_id);
                    
                rsort($ranks);
            
                // echo "<pre>";
                // print_r($ranks);
                // echo "</pre>";
    
                return ["students" => $records, "ranks" => $all_ranks];
            }
            
            // Class XII Section AR
            else if(in_array($class_id, [13]) && $section_id == 4) 
             { 
            
                $students = $this->Student->get_where([
                    "class_id"                      => $class_id,
                    "section_id"                    => $section_id,
                    "student_session.promoted"      => "ANY",
                    "student_session.withdraw"      => "ANY",
                ]);
                
                
                $records = [];
                
                $ranks = [];
                
                $class_teacher = "";
                if($class_id == 13) {
                    // SC
                    if($section_id == 3) {
                        $class_teacher = "MS. ROSELINE";
                    }
                    
                    // AR
                    if($section_id == 4) {
                        $class_teacher = "MS. ONGMU";
                    }
                }
                
                foreach($students as $student) {
                    $student_evolution = $this->Marks->get_student_evolution($class_id, $exam_id, $student['id']);
                    $grades = explode(",", $student_evolution);
                    
                    $attendence = $this->ExamAttendence->get_student_attendence_percentage($class_id, $exam_id, $student['id']);
                    $remark     = $this->Remarks->get_student_remarks($class_id, $exam_id, $student['id']);
                    $is_absent  = false;
                    
                    $optional_papers = [];
                    
                    // Subject 3
                    $row = $this->StudentSubject->get_where([
                        "academy_class_id"  => $class_id,
                        "subject_type_id"   => 12,
                        "student_id"        => $student['id'],
                    ]);
                    
                    if($row["subject_id"]) {
                        $subject_id = $row["subject_id"];
                        $subject = $this->Subject->get($subject_id);
                        
                        $optional_papers[] = $subject;
                    }
                    
                    // Subject 8
                    $row = $this->StudentSubject->get_where([
                        "academy_class_id"  => $class_id,
                        "subject_type_id"   => 17,
                        "student_id"        => $student['id'],
                    ]);
                    
                    if($row["subject_id"]) {
                        $subject_id = $row["subject_id"];
                        $subject = $this->Subject->get($subject_id);
                        
                        $optional_papers[] = $subject;
                    }
                    
                    // Subject 7
                    if($section_id == 4) {
                        $row = $this->StudentSubject->get_where([
                            "academy_class_id"  => $class_id,
                            "subject_type_id"   => 16,
                            "student_id"        => $student['id'],
                        ]);
                        
                        if($row["subject_id"]) {
                            $subject_id = $row["subject_id"];
                            $subject = $this->Subject->get($subject_id);
                            
                            $optional_papers[] = $subject;
                        }
                    }
                    
                    // Grade Subjects
                    $first_term_grade_subjects = [
                        "moral_science"     => $this->Marks->get_student_grade($class_id, 2, 23,  $student['id']),
                        "catechism"         => $this->Marks->get_student_grade($class_id, 2, 24,  $student['id']),
                    ];
                    
                    // Grade Subjects
                    $annual_term_grade_subjects = [
                        "moral_science"     => $this->Marks->get_student_grade($class_id, 4, 23,  $student['id']),
                        "catechism"         => $this->Marks->get_student_grade($class_id, 4, 24,  $student['id']),
                    ];
                    
                    
                    $first_unit_test_marks = [
                        "english_language"      => $this->Marks->get_student_marks($class_id, 1, 2,  $student['id']),
                        "english_literature"    => $this->Marks->get_student_marks($class_id, 1, 1,  $student['id']),
                        "history"               => $this->Marks->get_student_marks($class_id, 1, 9,  $student['id']),
                        "political_science"     => $this->Marks->get_student_marks($class_id, 1, 21,  $student['id']),
                        "sociology"             => $this->Marks->get_student_marks($class_id, 1, 29,  $student['id']),
                    ];
                    
                    if(count($optional_papers) == 1) {
                        $first_unit_test_marks["optional_paper_1"] = $this->Marks->get_student_marks($class_id, 1, $optional_papers[0]["id"],  $student['id']);
                    }
                    
                    if(count($optional_papers) == 2) {
                        $first_unit_test_marks["optional_paper_1"] = $this->Marks->get_student_marks($class_id, 1, $optional_papers[0]["id"],  $student['id']);
                    
                        $first_unit_test_marks["optional_paper_2"] = $this->Marks->get_student_marks($class_id, 1, $optional_papers[1]["id"],  $student['id']);
                    }
                    
                    // First Term Marks
                    $first_term_marks = [
                        "english_language"      => $this->Marks->get_student_marks($class_id, 2, 2,  $student['id']),
                        "english_literature"    => $this->Marks->get_student_marks($class_id, 2, 1,  $student['id']),
                        "history"               => $this->Marks->get_student_marks($class_id, 2, 9,  $student['id']),
                        "political_science"     => $this->Marks->get_student_marks($class_id, 2, 21,  $student['id']),
                        "sociology"             => $this->Marks->get_student_marks($class_id, 2, 29,  $student['id']),
                    ];
                    
                    if(count($optional_papers) == 1) {
                        $first_term_marks["optional_paper_1"] = $this->Marks->get_student_marks($class_id, 2, $optional_papers[0]["id"],  $student['id']);
                    }
                    
                    if(count($optional_papers) == 2) {
                        $first_term_marks["optional_paper_1"] = $this->Marks->get_student_marks($class_id, 2, $optional_papers[0]["id"],  $student['id']);
                    
                        $first_term_marks["optional_paper_2"] = $this->Marks->get_student_marks($class_id, 2, $optional_papers[1]["id"],  $student['id']);
                    }
                    
                    
                    // Second Unit Test Marks
                    $second_unit_test_marks = [
                        "english_language"      => $this->Marks->get_student_marks($class_id, 3, 2,  $student['id']),
                        "english_literature"    => $this->Marks->get_student_marks($class_id, 3, 1,  $student['id']),
                        "history"               => $this->Marks->get_student_marks($class_id, 3, 9,  $student['id']),
                        "political_science"     => $this->Marks->get_student_marks($class_id, 3, 21,  $student['id']),
                        "sociology"             => $this->Marks->get_student_marks($class_id, 3, 29,  $student['id']),
                    ];
                    
                    if(count($optional_papers) == 1) {
                        $second_unit_test_marks["optional_paper_1"] = $this->Marks->get_student_marks($class_id, 3, $optional_papers[0]["id"],  $student['id']);
                    }
                    
                    if(count($optional_papers) == 2) {
                        $second_unit_test_marks["optional_paper_1"] = $this->Marks->get_student_marks($class_id, 3, $optional_papers[0]["id"],  $student['id']);
                    
                        $second_unit_test_marks["optional_paper_2"] = $this->Marks->get_student_marks($class_id, 3, $optional_papers[1]["id"],  $student['id']);
                    }
                    
                    // Annual Term Marks
                    $annual_term_marks = [
                        "english_language"      => $this->Marks->get_student_marks($class_id, 4, 2,  $student['id']),
                        "english_literature"    => $this->Marks->get_student_marks($class_id, 4, 1,  $student['id']),
                        "history"               => $this->Marks->get_student_marks($class_id, 4, 9,  $student['id']),
                        "political_science"     => $this->Marks->get_student_marks($class_id, 4, 21,  $student['id']),
                        "sociology"             => $this->Marks->get_student_marks($class_id, 4, 29,  $student['id']),
                    ];
                    
                    if(count($optional_papers) == 1) {
                        $annual_term_marks["optional_paper_1"] = $this->Marks->get_student_marks($class_id, 4, $optional_papers[0]["id"],  $student['id']);
                    }
                    
                    if(count($optional_papers) == 2) {
                        $annual_term_marks["optional_paper_1"] = $this->Marks->get_student_marks($class_id, 4, $optional_papers[0]["id"],  $student['id']);
                    
                        $annual_term_marks["optional_paper_2"] = $this->Marks->get_student_marks($class_id, 4, $optional_papers[1]["id"],  $student['id']);
                    }
                    
                    // First Term Totals
                    $first_term_totals = [
                        "english_language"      =>  $first_term_marks["english_language"]       + $first_unit_test_marks["english_language"],
                        "english_literature"    =>  $first_term_marks["english_literature"]     + $first_unit_test_marks["english_literature"],
                        "history"               =>  $first_term_marks["history"]                + $first_unit_test_marks["history"],
                        "political_science"     =>  $first_term_marks["political_science"]      + $first_unit_test_marks["political_science"],
                        "sociology"             =>  $first_term_marks["sociology"]              + $first_unit_test_marks["sociology"],
                    ];
                    
                    if(count($optional_papers) == 1)
                    {
                        $first_term_totals["optional_paper_1"] = $first_term_marks["optional_paper_1"] + $first_unit_test_marks["optional_paper_1"];
                    }
                    
                    if(count($optional_papers) == 2)
                    {
                        $first_term_totals["optional_paper_1"] = $first_term_marks["optional_paper_1"] + $first_unit_test_marks["optional_paper_1"];
                        $first_term_totals["optional_paper_2"] = $first_term_marks["optional_paper_2"] + $first_unit_test_marks["optional_paper_2"];
                    }
                    
                    $annual_term_totals = [
                        "english_language"      =>  $second_unit_test_marks["english_language"]     + $annual_term_marks["english_language"],
                        "english_literature"    =>  $second_unit_test_marks["english_literature"]   + $annual_term_marks["english_literature"],
                        "history"               =>  $second_unit_test_marks["history"]              + $annual_term_marks["history"],
                        "political_science"     =>  $second_unit_test_marks["political_science"]    + $annual_term_marks["political_science"],
                        "sociology"             =>  $second_unit_test_marks["sociology"]            + $annual_term_marks["sociology"],
                    ];
                    
                    if(count($optional_papers) == 1)
                    {
                        $annual_term_totals["optional_paper_1"] = $second_unit_test_marks["optional_paper_1"]     + $annual_term_marks["optional_paper_1"];
                    }
                    
                    if(count($optional_papers) == 2)
                    {
                        $annual_term_totals["optional_paper_1"] = $second_unit_test_marks["optional_paper_1"]     + $annual_term_marks["optional_paper_1"];
                        $annual_term_totals["optional_paper_2"] = $second_unit_test_marks["optional_paper_2"]     + $annual_term_marks["optional_paper_2"];
                    }
                    
                    $first_term_avg = [
                        "english"               => ceil(($first_term_totals["english_language"] + $first_term_totals["english_literature"]) / 2),
                        "history"               => $first_term_totals["history"],
                        "political_science"     => $first_term_totals["political_science"],
                        "sociology"             => $first_term_totals["sociology"],
                    ];
                    
                    if(count($optional_papers) == 1)
                    {
                        $first_term_avg["optional_paper_1"] = $first_term_totals["optional_paper_1"];
                    }
                    
                    if(count($optional_papers) == 2)
                    {
                        $first_term_avg["optional_paper_1"] = $first_term_totals["optional_paper_1"];
                        $first_term_avg["optional_paper_2"] = $first_term_totals["optional_paper_2"];
                    }
                    

                    $annual_term_avg = [
                        "english"               => ceil(($annual_term_totals["english_language"] + $annual_term_totals["english_literature"]) / 2),
                        "history"               => $annual_term_totals["history"],
                        "political_science"     => $annual_term_totals["political_science"],
                        "sociology"             => $annual_term_totals["sociology"]
                    ];
                    
                    if(count($optional_papers) == 1)
                    {
                        $annual_term_avg["optional_paper_1"] = $annual_term_totals["optional_paper_1"];
                    }
                    
                    if(count($optional_papers) == 2)
                    {
                        $annual_term_avg["optional_paper_1"] = $annual_term_totals["optional_paper_1"];
                        $annual_term_avg["optional_paper_2"] = $annual_term_totals["optional_paper_2"];
                    }
                    
                    
                    $final_avg = [
                        "english"           => ceil(($first_term_avg["english"]             + $annual_term_avg["english"]) / 2),
                        "history"           => ceil(($first_term_avg["history"]             + $annual_term_avg["history"]) / 2),
                        "political_science" => ceil(($first_term_avg["political_science"]   + $annual_term_avg["political_science"]) / 2),
                        "sociology"         => ceil(($first_term_avg["sociology"]           + $annual_term_avg["sociology"]) / 2),
                    ];
                    
                    if(count($optional_papers) == 1)
                    {
                        $final_avg["optional_paper_1"] = ceil(($first_term_avg["optional_paper_1"] + $annual_term_avg["optional_paper_1"]) / 2);
                    }
                    
                    if(count($optional_papers) == 2)
                    {
                        $final_avg["optional_paper_1"] = ceil(($first_term_avg["optional_paper_1"] + $annual_term_avg["optional_paper_1"]) / 2);
                        $final_avg["optional_paper_2"] = ceil(($first_term_avg["optional_paper_2"] + $annual_term_avg["optional_paper_2"]) / 2);
                    }
                    
                    $first_term_merks_values  = array_values($first_term_marks);
                    $annual_term_merks_values = array_values($annual_term_marks);
                    $values = array_merge($first_term_merks_values, $annual_term_merks_values);
                    
                    foreach($values as &$value)
                        $value = strtolower($value);
                    
                    if(in_array("ab", $values))
                        $is_absent = true;
                    
                    $final_avg_total    =  $final_avg["english"] + $final_avg["history"] + $final_avg["political_science"] + $final_avg["sociology"]; 
                    
                    if(count($optional_papers) == 1){
                        $final_avg_total = $final_avg_total + $final_avg["optional_paper_1"];
                    }
                    
                    if(count($optional_papers) == 2){
                        $final_avg_total = $final_avg_total + $final_avg["optional_paper_1"];
                        $final_avg_total = $final_avg_total + $final_avg["optional_paper_2"];
                    }
                    
                    
                    $final_percentage   =  ceil($final_avg_total / count($final_avg));
                    
                    $points = [];
                    $total_point = 0;
                    $division = "";
                    
                    foreach($final_avg as $key => $value) {
                        
                        $point = "";
                        
                        if($value >= 90 && $value <= 100) {
                            $point = 1;
                        }
                        elseif($value >= 80 && $value <= 89) {
                            $point = 2;
                        }
                        elseif($value >= 70 && $value <= 79) {
                            $point = 3;
                        }
                        elseif($value >= 60 && $value <= 69) {
                            $point = 4;
                        }
                        elseif($value >= 50 && $value <= 59) {
                            $point = 5;
                        }
                        elseif($value >= 46 && $value <= 49) {
                            $point = 6;
                        }
                        elseif($value == 45) {
                            $point = 7;
                        }
                        else {
                            $point = 8;
                        }
                        
                        $total_point += $point;
                        $points[$key] = $point;
                    }
                    
                    
                    if($total_point > 44) {
                        $division = "Unsatisfactory";
                    }
                    elseif($total_point >= 39 && $total_point <= 44) {
                        $division = "Pass";
                    }
                    elseif($total_point >= 31 && $total_point <= 38) {
                        $division = "3rd";
                    }
                    elseif($total_point >= 21 && $total_point <= 30) {
                        $division = "2nd";
                    }
                    elseif($total_point <= 21) {
                        $division = "1st";
                    }
                    else {
                        $division = "";
                    }
                
                    if($final_avg["english"] >= 35)
                    {
                        $passed_in_english = true;
                    }
                    else
                    {
                        $number_of_failed_subject++;
                    }
                    
                    // $passed_in_english = $final_avg["english"] >= 35 ? true : false;
                    $number_of_failed_subject = 0;
                    $eligible_for_rank = true;
                    $passed = true;

                     
                    if($final_avg["history"] < 35)  {$number_of_failed_subject++;}
                    if($final_avg["political_science"] < 35)  {$number_of_failed_subject++;}
                    if($final_avg["sociology"] < 35)  {$number_of_failed_subject++;}
                    
                    
                    if(isset($final_avg["optional_paper_1"])) {
                        if($final_avg["optional_paper_1"] < 35) {$number_of_failed_subject++;}
                    }
                    
                    if(isset($final_avg["optional_paper_2"])) {
                        if($final_avg["optional_paper_2"] < 35) {$number_of_failed_subject++;}
                    }
                    
                    // Pass & Fail Condition
                    if(!$passed_in_english || $number_of_failed_subject >=3) {
                        $passed = false;
                        $eligible_for_rank = false;
                    }
                    else {
                        $passed = true;
                         
                        if($number_of_failed_subject == 1 || $number_of_failed_subject == 2){
                            $eligible_for_rank = false;    
                        }
                    }
                    
                    
                    if($eligible_for_rank) {
                        if(!in_array($final_avg_total, $ranks)) {
                            $ranks[] = $final_avg_total;
                        }    
                    }

                    $data = [
                        "name"                  => $student["f_name"] . " " . $student["m_name"] . " " . $student["l_name"],
                        "roll_no"               => $student["roll_no"],
                        "student_no"            => $student["student_no"],
                        "student_id"            => $student["id"],
                        "remarks"               => $remark,
                        "evolution_grades"              => $grades,
                        "first_unit_test_marks"         => $first_unit_test_marks,
                        "first_term_marks"              => $first_term_marks,
                        "second_unit_test_marks"        => $second_unit_test_marks,
                        "annual_term_marks"             => $annual_term_marks,
                        "first_term_totals"             => $first_term_totals,
                        "annual_term_totals"            => $annual_term_totals,
                        "first_term_avg"                => $first_term_avg,
                        "annual_term_avg"               => $annual_term_avg,
                        "final_avg"                     => $final_avg,
                        "final_avg_total"               => $final_avg_total,
                        "final_percentage"              => $final_percentage,
                        "first_term_grade_subjects"     => $first_term_grade_subjects,
                        "annual_term_grade_subjects"    => $annual_term_grade_subjects,
                        "points"                => $points,
                        "total_point"           => $total_point,
                        "division"                      => $division,
                        "attendence"                    => $attendence,
                        "subject"                       => $subject,
                        "is_absent"                     => $is_absent,
                        "passed"                => $passed,
                        "eligible_for_rank"     => $eligible_for_rank,
                        "grade_subjects"        => $grade_subjects,
                        "class_teacher"         => $class_teacher,
                        "optional_papers" => $optional_papers,
                    ];
                    
                    $records[] = $data;
                }
                
                if($report_for != "all") {
                    $student_id = $selected_student_id;
                    
                    $temp = [];
                    
                    foreach($records as $record) {
                        if($record["student_id"] == $student_id) {
                            $temp[] = $record;
                        }
                    }
                    
                    $records = $temp;
                }
                
                $class = $this->AcademyClass->get($class_id);
                $section = $this->Section->get($section_id);
                    
                rsort($ranks);
            
                // echo "<pre>";
                // print_r($ranks);
                // echo "</pre>";
    
                return ["students" => $records, "ranks" => $all_ranks];
            }
        }

    }