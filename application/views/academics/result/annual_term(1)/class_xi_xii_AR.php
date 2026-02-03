<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">

    <title>Result</title>

    <style>
        * {
            -webkit-print-color-adjust: exact !important;   /* Chrome, Safari 6 – 15.3, Edge */
            color-adjust: exact !important;                 /* Firefox 48 – 96 */
            print-color-adjust: exact !important;           /* Firefox 97+, Safari 15.4+ */
        }
        
        body {
            background-color: #fbe4d5;
        }
        .result {
            padding: 40px;
        }
        .text {
            color: #3b6292;
            font-weight: bold;
        }
        table {
            width: 100%;
        }
        
        table, th, td {
            border: 1px solid black;
            padding: 7px;
            text-align: center;
        }
    </style>
  </head>
  <body>
    
    <?php $academy_session_id = $this->session->academy_session['current_session']['id']; ?>
    <?php foreach($students as $student) { ?>
        <div class="container-fluid">
            <div class="result">
                <div class="row justify-content-center mb-2">
                    <div class="col-md-10">
                        <img class="img-fluid" src="<?php echo base_url()?>/assets/media/logos/result_header.png" />
                    </div>
                </div>
                <h4 class="text-center text">REPORT CARD</h4>
                <h5 class="text-center text">Academic Session <?php if($academy_session_id == 1) {echo  "2023";} else {echo "2024";}?></h5>
                <h5 class="text-center text-dark font-weight-bold">XII-ARTS</h5>
                <div class="row justify-content-between px-3 my-4">
                    <h5 class="text-center text-dark font-weight-bold">NAME - <?php echo $student['name'] ?></h5>
                    <h5 class="text-center text-dark font-weight-bold">STUDENT NO - <?php echo $student['student_no'] ?></h5>
                </div>
                <table>
                    <thead>
                        <tr>
                            <th rowspan="2">SUBJECTS</th>    
                            <th colspan="9">
                                <h3>ANNUAL EXAMINATION</h3>
                            </th>                        
                        </tr>
                        <tr>
                            <th>Unit Test II</th>    
                            <th>Annual Term</th>    
                            <th>Total (100)</th>    
                            <th>Annual AVG</th>    
                            <th>First Term AVG</th>    
                            <th>FINAL AVG</th>
                            <th>POINTS</th>
                            <th>CONTINUOUS COMPREHENSIVE EVALUATION</th>    
                            <th>GRADE</th>    
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="text-start">English Language</td>
                            <td><?php echo $student["second_unit_test_marks"]["english_language"] ?></td>
                            <td><?php echo $student["annual_term_marks"]["english_language"] ?></td>
                            <td><?php echo $student["annual_term_totals"]["english_language"] ?></td>
                            <td rowspan="2"><?php echo $student["annual_term_avg"]["english"] ?></td>
                            <td rowspan="2"><?php echo $student["first_term_avg"]["english"] ?></td>
                            <td rowspan="2"><?php echo $student["final_avg"]["english"] ?></td>
                            <td rowspan="2"><?php echo $student["points"]["english"] ?></td>
                            <td class="text-start">Command over written and spoken language</td>
                            <td><?php echo $student["evolution_grades"][0] ?></td>
                        </tr>
                        <tr>
                            <td class="text-start">English Literature</td>
                            <td><?php echo $student["second_unit_test_marks"]["english_literature"] ?></td>
                            <td><?php echo $student["annual_term_marks"]["english_literature"] ?></td>
                            <td><?php echo $student["annual_term_totals"]["english_literature"] ?></td>
                            <td class="text-start">Expresses ideas explicitly</td>
                            <td><?php echo $student["evolution_grades"][1] ?></td>
                        </tr>
                        <tr>
                            <td class="text-start">History</td>
                            <td><?php echo $student["second_unit_test_marks"]["history"] ?></td>
                            <td><?php echo $student["annual_term_marks"]["history"] ?></td>
                            <td><?php echo $student["annual_term_totals"]["history"] ?></td>
                            <td><?php echo $student["annual_term_avg"]["history"] ?></td>
                            <td><?php echo $student["first_term_avg"]["history"] ?></td>
                            <td><?php echo $student["final_avg"]["history"] ?></td>
                            <td><?php echo $student["points"]["history"] ?></td>
                            <td class="text-start">Enjoys hands on experiments</td>
                            <td><?php echo $student["evolution_grades"][2] ?></td>
                        </tr>
                        <tr>
                            <td class="text-start">Political Science</td>
                            <td><?php echo $student["second_unit_test_marks"]["political_science"] ?></td>
                            <td><?php echo $student["annual_term_marks"]["political_science"] ?></td>
                            <td><?php echo $student["annual_term_totals"]["political_science"] ?></td>
                            <td><?php echo $student["annual_term_avg"]["political_science"] ?></td>
                            <td><?php echo $student["first_term_avg"]["political_science"] ?></td>
                            <td><?php echo $student["final_avg"]["political_science"] ?></td>
                            <td><?php echo $student["points"]["political_science"] ?></td>
                            <td class="text-start">Expresses through colors, canvas and crafts</td>
                            <td><?php echo $student["evolution_grades"][3] ?></td>
                        </tr>
                        <tr>
                            <td class="text-start">Sociology</td>
                            <td><?php echo $student["second_unit_test_marks"]["sociology"] ?></td>
                            <td><?php echo $student["annual_term_marks"]["sociology"] ?></td>
                            <td><?php echo $student["annual_term_totals"]["sociology"] ?></td>
                            <td><?php echo $student["annual_term_avg"]["sociology"] ?></td>
                            <td><?php echo $student["first_term_avg"]["sociology"] ?></td>
                            <td><?php echo $student["final_avg"]["sociology"] ?></td>
                            <td><?php echo $student["points"]["sociology"] ?></td>
                            <td class="text-start">Highly developed psychomotor skills</td>
                            <td><?php echo $student["evolution_grades"][4] ?></td>
                        </tr>
                        <tr>
                            <td class="text-start"><?php echo $student["optional_papers"][0]["name"] ?></td>
                            <td><?php echo $student["second_unit_test_marks"]["optional_paper_1"] ?></td>
                            <td><?php echo $student["annual_term_marks"]["optional_paper_1"] ?></td>
                            <td><?php echo $student["annual_term_totals"]["optional_paper_1"] ?></td>
                            <td><?php echo $student["annual_term_avg"]["optional_paper_1"] ?></td>
                            <td><?php echo $student["first_term_avg"]["optional_paper_1"] ?></td>
                            <td><?php echo $student["final_avg"]["optional_paper_1"] ?></td>
                            <td><?php echo $student["points"]["optional_paper_1"] ?></td>
                            <td class="text-start">Takes leader roles</td>
                            <td><?php echo $student["evolution_grades"][5] ?></td>
                        </tr>
                        <tr>
                            <td class="text-start"><?php echo $student["optional_papers"][1]["name"] ?></td>
                            <td><?php echo $student["second_unit_test_marks"]["optional_paper_2"] ?></td>
                            <td><?php echo $student["annual_term_marks"]["optional_paper_2"] ?></td>
                            <td><?php echo $student["annual_term_totals"]["optional_paper_2"] ?></td>
                            <td><?php echo $student["annual_term_avg"]["optional_paper_2"] ?></td>
                            <td><?php echo $student["first_term_avg"]["optional_paper_2"] ?></td>
                            <td><?php echo $student["final_avg"]["optional_paper_2"] ?></td>
                            <td><?php echo $student["points"]["optional_paper_2"] ?></td>
                            <td class="text-start">Shows Moral Values</td>
                            <td><?php echo $student["evolution_grades"][6] ?></td>
                        </tr>
                        <tr>
                            <td class="text-start">Moral Science</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td><?php echo $student['annual_term_grade_subjects']['moral_science'] ?></td>
                            <td><?php echo $student['first_term_grade_subjects']['moral_science'] ?></td>
                            <td>
                                <?php   
                                    if($student['first_term_grade_subjects']['moral_science'] == "") {
                                        echo $student['annual_term_grade_subjects']['moral_science'];
                                    }
                                    elseif($student['annual_term_grade_subjects']['moral_science'] == "") {
                                        echo $student['first_term_grade_subjects']['moral_science'];
                                    }
                                    else{
                                        echo $student['first_term_grade_subjects']['moral_science'] < $student['annual_term_grade_subjects']['moral_science'] ? $student['first_term_grade_subjects']['moral_science'] : $student['annual_term_grade_subjects']['moral_science']; 
                                    }    
                                ?>
                            </td>
                            <td></td>
                            <td class="text-start">Collaborative Learner</td>
                            <td><?php echo $student["evolution_grades"][7] ?></td>
                        </tr>
                        <tr>
                            <td class="text-start">Catechism</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td><?php echo $student['annual_term_grade_subjects']['catechism'] ?></td>
                            <td><?php echo $student['first_term_grade_subjects']['catechism'] ?></td>
                            <td>
                                <?php   
                                    if($student['first_term_grade_subjects']['catechism'] == "") {
                                        echo $student['annual_term_grade_subjects']['catechism'];
                                    }
                                    elseif($student['annual_term_grade_subjects']['catechism'] == "") {
                                        echo $student['first_term_grade_subjects']['catechism'];
                                    }
                                    else{
                                        echo $student['first_term_grade_subjects']['catechism'] < $student['annual_term_grade_subjects']['catechism'] ? $student['first_term_grade_subjects']['catechism'] : $student['annual_term_grade_subjects']['catechism']; 
                                    }    
                                ?>
                            </td>
                            <td></td>
                            <td class="text-start">Highly Imaginative child</td>
                            <td><?php echo $student["evolution_grades"][8] ?></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td class="text-start">Good Quality work</td>
                            <td><?php echo $student["evolution_grades"][9] ?></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td class="text-start">Judges behavior as right or wrong</td>
                            <td><?php echo $student["evolution_grades"][10] ?></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td class="text-start">Punctual and Regular in Learning</td>
                            <td><?php echo $student["evolution_grades"][11] ?></td>
                        </tr>
                        <tr>
                            <td class="text-start">Total</td>
                            <td colspan="4"></td>
                            <td></td>
                            <td><?php echo $student["final_avg_total"] ?></td>
                            <td><?php echo $student["total_point"] ?></td>
                            <td></td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
                <div class="my-2">
                    <h6 class="text-dark font-weight-bold">Class Teacher: <?php echo $student["class_teacher"] ?></h6>
                    <h6 class="text-dark font-weight-bold">Remarks: <?php echo $student["remarks"] ?></h6>
                </div>
                <div class="row justify-content-between my-2">
                    <div class="col-md-2 d-flex justify-content-center">
                        <table>
                            <tr>
                                <td>Points</td>
                                <td><?php echo $student["total_point"] ?></td>
                            </tr>
                        </table>
                    </div>
                    
                    <div class="col-md-2 d-flex justify-content-center">
                        <table>
                            <tr>
                                <td>Result</td>
                                <td><?php if($student["is_absent"] == false) { echo $student["passed"] ? "PASSED" : "UNSATISFACTORY"; } ?></td>
                            </tr>
                        </table>
                    </div>
                    
                    <div class="col-md-2 d-flex justify-content-center">
                        <table>
                            <tr>
                                <td>Ranks</td>
                                <td><?php if($student["is_absent"] == false) { if($student["eligible_for_rank"]) { echo array_search($student["final_avg_total"], $ranks) + 1; } }?></td>
                            </tr>
                        </table>
                    </div>
    
                    <div class="col-md-2 d-flex justify-content-center">
                        <table>
                            <tr>
                                <td>Division</td>
                                <td><?php if(($student["is_absent"] == false) && ($student["passed"] == true)) { echo $student["division"]; }?></td>
                            </tr>
                        </table>
                    </div>
                    
                    <div class="col-md-2 d-flex justify-content-center">
                        <table>
                            <tr>
                                <td>Attendance</td>
                                <td><?php echo $student["attendence"] ?>%</td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3"></div>
                    <div class="col-md-6 d-flex justify-content-center">
                        <table>
                            <thead>
                                <tr>
                                    <th>TOTAL POINTS</th>
                                    <th>DIVISION</th>
                                    <th></th>
                                    <th>MARKS</th>
                                    <th>POINTS</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Less than 21</td>
                                    <td>1 st Div</td>
                                    <td rowspan="8"></td>
                                    <td>90-100</td>
                                    <td>1</td>
                                </tr>
                                <tr>
                                    <td>21-30</td>
                                    <td>2 nd Div</td>
                                    <td>80-89</td>
                                    <td>2</td>
                                </tr>
                                <tr>
                                    <td>31-38</td>
                                    <td>3 rd Div</td>
                                    <td>70-79</td>
                                    <td>3</td>
                                </tr>
                                <tr>
                                    <td>39-44</td>
                                    <td>Pass</td>
                                    <td>60-69</td>
                                    <td>4</td>
                                </tr>
                                <tr>
                                    <td>Above 44</td>
                                    <td>Unsatisfactory</td>
                                    <td>50-59</td>
                                    <td>5</td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td>46-49</td>
                                    <td>6</td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td>45</td>
                                    <td>7</td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td>Below 45</td>
                                    <td>8</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-3 d-flex justify-content-center align-items-center">
                        <img class="img-fluid" height="150" width="150" src="<?php echo base_url()?>/assets/media/logos/stamp.png" />
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>

    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
  </body>
</html>