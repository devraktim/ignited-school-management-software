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
                <h5 class="text-center text-dark font-weight-bold">CLASS-<?php echo $class["name"] ?> "<?php echo $section["name"] ?>"</h5>
                <div class="row justify-content-between px-3 my-4">
                    <h5 class="text-center text-dark font-weight-bold">NAME - <?php echo $student['name'] ?></h5>
                    <h5 class="text-center text-dark font-weight-bold">STUDENT NO - <?php echo $student['student_no'] ?></h5>
                </div>
                <table>
                    <thead>
                        <tr>
                            <th rowspan="2">SUBJECTS</th>    
                            <th colspan="6">
                                <h3>ANNUAL EXAMINATION</h3>
                            </th>                        
                        </tr>
                        <tr>
                            <th>Unit Test II (20)</th>    
                            <th>Annual Term (80)</th>    
                            <th>Total (100)</th>    
                            <th>Annual AVG</th>    
                            <th>First Term AVG</th>    
                            <th>FINAL AVG</th>
                            
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
                            <td class="text-start">Demonstrates beginning skills in reading, writing and mathematics</td>
                            <td><?php echo $student["evolution_grades"][0] ?></td>
                        </tr>
                        <tr>
                            <td class="text-start">English Literature</td>
                            <td><?php echo $student["second_unit_test_marks"]["english_literature"] ?></td>
                            <td><?php echo $student["annual_term_marks"]["english_literature"] ?></td>
                            <td><?php echo $student["annual_term_totals"]["english_literature"] ?></td>
                            <td class="text-start">Constructs sentences using correct grammar</td>
                            <td><?php echo $student["evolution_grades"][1] ?></td>
                        </tr>
                        <tr>
                            <td class="text-start">Second Language</td>
                            <td><?php echo $student["second_unit_test_marks"]["second_language"] ?></td>
                            <td><?php echo $student["annual_term_marks"]["second_language"] ?></td>
                            <td><?php echo $student["annual_term_totals"]["second_language"] ?></td>
                            <td><?php echo $student["annual_term_avg"]["second_language"] ?></td>
                            <td><?php echo $student["first_term_avg"]["second_language"] ?></td>
                            <td><?php echo $student["final_avg"]["second_language"] ?></td>
                            <td class="text-start">Recognizes familiar simple word</td>
                            <td><?php echo $student["evolution_grades"][2] ?></td>
                        </tr>
                        <tr>
                            <td class="text-start">Mathematics</td>
                            <td><?php echo $student["second_unit_test_marks"]["mathematics"] ?></td>
                            <td><?php echo $student["annual_term_marks"]["mathematics"] ?></td>
                            <td><?php echo $student["annual_term_totals"]["mathematics"] ?></td>
                            <td><?php echo $student["annual_term_avg"]["mathematics"] ?></td>
                            <td><?php echo $student["first_term_avg"]["mathematics"] ?></td>
                            <td><?php echo $student["final_avg"]["mathematics"] ?></td>
                            <td class="text-start">Relays messages correctly</td>
                            <td><?php echo $student["evolution_grades"][3] ?></td>
                        </tr>
                        <tr>
                            <td class="text-start">Science</td>
                            <td><?php echo $student["second_unit_test_marks"]["science"] ?></td>
                            <td><?php echo $student["annual_term_marks"]["science"] ?></td>
                            <td><?php echo $student["annual_term_totals"]["science"] ?></td>
                            <td><?php echo $student["annual_term_avg"]["science"] ?></td>
                            <td><?php echo $student["first_term_avg"]["science"] ?></td>
                            <td><?php echo $student["final_avg"]["science"] ?></td>
                            <td class="text-start">Can listen without interrupting</td>
                            <td><?php echo $student["evolution_grades"][4] ?></td>
                        </tr>
                        <tr>
                            <td class="text-start">Social Studies</td>
                            <td><?php echo $student["second_unit_test_marks"]["social_studies"] ?></td>
                            <td><?php echo $student["annual_term_marks"]["social_studies"] ?></td>
                            <td><?php echo $student["annual_term_totals"]["social_studies"] ?></td>
                            <td><?php echo $student["annual_term_avg"]["social_studies"] ?></td>
                            <td><?php echo $student["first_term_avg"]["social_studies"] ?></td>
                            <td><?php echo $student["final_avg"]["social_studies"] ?></td>
                            <td class="text-start">Uses feeling and emotion words appropriately</td>
                            <td><?php echo $student["evolution_grades"][5] ?></td>
                        </tr>
                        <tr>
                            <td class="text-start">Computer</td>
                            <td><?php echo $student["second_unit_test_marks"]["computer"] ?></td>
                            <td><?php echo $student["annual_term_marks"]["computer"] ?></td>
                            <td><?php echo $student["annual_term_totals"]["computer"] ?></td>
                            <td><?php echo $student["annual_term_avg"]["computer"] ?></td>
                            <td><?php echo $student["first_term_avg"]["computer"] ?></td>
                            <td><?php echo $student["final_avg"]["computer"] ?></td>
                            <td class="text-start">Shows interest in creative expression</td>
                            <td><?php echo $student["evolution_grades"][6] ?></td>
                        </tr>
                        <tr>
                            <td class="text-start">General Knowledge</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td><?php echo $student['annual_term_grade_subjects']['gk'] ?></td>
                            <td><?php echo $student['first_term_grade_subjects']['gk'] ?></td>
                            
                            <td>    
                                <?php   
                                    if($student['first_term_grade_subjects']['gk'] == "") {
                                        echo $student['annual_term_grade_subjects']['gk'];
                                    }
                                    elseif($student['annual_term_grade_subjects']['gk'] == "") {
                                        echo $student['first_term_grade_subjects']['gk'];
                                    }
                                    else{
                                        echo $student['first_term_grade_subjects']['gk'] < $student['annual_term_grade_subjects']['gk'] ? $student['first_term_grade_subjects']['gk'] : $student['annual_term_grade_subjects']['gk']; 
                                    }    
                                ?>
                            </td>
                            
                            <td class="text-start">Accepts responsibility and completes work independently</td>
                            <td><?php echo $student["evolution_grades"][7] ?></td>
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
                            <td class="text-start">Interact cooperatively with other children</td>
                            <td><?php echo $student["evolution_grades"][8] ?></td>
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
                            <td class="text-start">Judges behavior as right or wrong</td>
                            <td><?php echo $student["evolution_grades"][9] ?></td>
                        </tr>
                        <tr>
                            <td class="text-start">Handwriting</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td><?php echo $student['annual_term_grade_subjects']['handwriting'] ?></td>
                            <td><?php echo $student['first_term_grade_subjects']['handwriting'] ?></td>
                            <td>
                                <?php   
                                    if($student['first_term_grade_subjects']['handwriting'] == "") {
                                        echo $student['annual_term_grade_subjects']['handwriting'];
                                    }
                                    elseif($student['annual_term_grade_subjects']['handwriting'] == "") {
                                        echo $student['first_term_grade_subjects']['handwriting'];
                                    }
                                    else{
                                        echo $student['first_term_grade_subjects']['handwriting'] < $student['annual_term_grade_subjects']['handwriting'] ? $student['first_term_grade_subjects']['handwriting'] : $student['annual_term_grade_subjects']['handwriting']; 
                                    }    
                                ?>
                            </td>
                            <td class="text-start">Maintains friendship in Learning</td>
                            <td><?php echo $student["evolution_grades"][10] ?></td>
                        </tr>
                        <tr>
                            <td class="text-start">Drawing</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td><?php echo $student['annual_term_grade_subjects']['drawing'] ?></td>
                            <td><?php echo $student['first_term_grade_subjects']['drawing'] ?></td>
                            <td>
                                <?php   
                                    if($student['first_term_grade_subjects']['drawing'] == "") {
                                        echo $student['annual_term_grade_subjects']['drawing'];
                                    }
                                    elseif($student['annual_term_grade_subjects']['drawing'] == "") {
                                        echo $student['first_term_grade_subjects']['drawing'];
                                    }
                                    else{
                                        echo $student['first_term_grade_subjects']['drawing'] < $student['annual_term_grade_subjects']['drawing'] ? $student['first_term_grade_subjects']['drawing'] : $student['annual_term_grade_subjects']['drawing']; 
                                    }    
                                ?>
                            </td>
                            <td class="text-start">Inquisitive learner</td>
                            <td><?php echo $student["evolution_grades"][11] ?></td>
                        </tr>
                        <tr>
                            <td class="text-start">Total</td>
                            <td colspan="5"></td>
                            <td><strong><?php echo $student["final_avg_total"] ?></strong></td>
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
                                <td>Percentage</td>
                                <td><?php echo $student["final_percentage"] ?>%</td>
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
                                <td><?php if($student["is_absent"] == false) { echo $student["division"]; }?></td>
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
                                    <th>PERCENTAGE</th>
                                    <th>DIVISION</th>
                                    <th colspan="2">GRADE</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>85-100</td>
                                    <td>1st Div</td>
                                    <td>A</td>
                                    <td>Excellent</td>
                                </tr>
                                <tr>
                                    <td>65-84</td>
                                    <td>2nd Div</td>
                                    <td>B</td>
                                    <td>Good</td>
                                </tr>
                                <tr>
                                    <td>45-64</td>
                                    <td>3rd Div</td>
                                    <td>C</td>
                                    <td>Satisfactory</td>
                                </tr>
                                <tr>
                                    <td>Less than 45</td>
                                    <td>Unsatisfactory</td>
                                    <td>D</td>
                                    <td>Need to improve</td>
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