<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>Student Biodata</title>
    
    <style>
        .table strong {
            color: black !important;
        }
        
        th, td {
            font-size: 12px;
            color: black !important;
            text-align: center;
        }
    </style>
  </head>
  <body>
    <div class="container-fluid">   
        <div class="row">
            <div class="col-3">
                <img src="<?php echo base_url()?>assets/media/logos/logol.png" style="Height:80px; Width:80px">
            </div>
            
            <div class="col-6">
                <h5 class="text-center text-dark mt-4">St. Francis School</h5>
                
                <p class="text-center text-dark">Jorethang</p>

                <h4 class="text-center text-dark">Bio Data For <?php echo $record['f_name'] . ' ' . $record['m_name'] . ' ' . $record['l_name'] ?></h4>
            </div>
            
            <div class="col-3 text-end">
                <!--<img src="<?php echo base_url()?>assets/media/logos/logol.png" style="Height:80px; Width:80px">-->
            </div>
        </div>
        
        <hr>
        
        <div class="row">
            <div class="col-9">
                <table class="table table-sm table-bordered">
                    <tbody>
                        <tr class="table-secondary">
                            <td colspan="6"><strong>Personal Details</strong></td>
                        </tr>
                        <tr>
                            <td><strong>Student No</strong></td>
                            <td><?php echo $record['student_no'] ?></td>
                            
                            <td><strong>Name</strong></td>
                            <td><?php echo $record['f_name'] . ' ' . $record['m_name'] . ' ' . $record['l_name'] ?></td>
                            
                            <td><strong>Class</strong></td>
                            <td><?php echo $record['student_session_class_name'] ?></td>
                        </tr>
                        <tr>
                            <td><strong>House</strong></td>
                            <td><?php echo $record['houese'] ?></td>
                            
                            <td><strong>Sex</strong></td>
                            <td><?php echo $record['sex'] ?></td>
                            
                            <td><strong>Date of Birth</strong></td>
                            <td><?php if(!empty($record['dob'])) { echo date('d-m-Y', strtotime($record['dob'])); } ?></td>
                        </tr>
                        
                        <tr>
                            <td><strong>Date of Admission</strong></td>
                            <td>
                                <?php if(!empty($record['date_of_admission'])) { echo date('d-m-Y', strtotime($record['date_of_admission'])); } ?>
                            </td>
                            
                            <td><strong>Student Category</strong></td>
                            <td><?php echo $record['category'] ?></td>
                            
                            <td><strong>State of Domicile</strong></td>
                            <td><?php echo $record['nationality'] ?></td>
                        </tr>
                        
                        <tr>
                            <td><strong>Student Type</strong></td>
                            <td><?php echo $record['student_type'] ?></td>
                            
                            <td><strong>Location</strong></td>
                            <td><?php echo $record['state'] ?></td>
                            
                            <td><strong>Religion</strong></td>
                            <td><?php echo $record['religion'] ?></td>
                        </tr>
                        
                        <tr>
                            <td><strong>Nationality</strong></td>
                            <td><?php echo $record['nationality'] ?></td>
                            
                            <td><strong>Status</strong></td>
                            <td><?php echo $record['status'] ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="col-3">
                <?php if($record["image"]) { ?>
                    <img style="height: 120px; width: 120px; border: 1px solid black; padding: 4px;" src="<?php echo base_url('storage/students/') . $record['image'] ?>" style="opacity: <?php echo $record['status'] == "ACTIVE" ? '1' : '0.3' ?>">
                <?php } else { ?>
                    <img style="height: 120px; width: 120px; border: 1px solid black; padding: 4px;" src="<?php echo base_url('assets/media/avatar/') ?><?php echo $record['sex'] == 'male' ? 'male.jpg' : 'female.jpg' ?>" style="height: 200px; width: fit-content; opacity: <?php echo $record['status'] == "ACTIVE" ? '1' : '0.3' ?>">
                <?php } ?>
            </div>
        </div>

        <div class="row">
            <div class="col-6">
                <table class="table table-sm table-bordered">
                    <tbody>
                        <tr class="table-secondary">
                            <td colspan="4"><strong>Family Details</strong></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td><strong>Name</strong></td>
                            <td><strong>Mobile</strong></td>
                        </tr>
                        <tr>
                            <td><strong>Father</strong></td>
                            <td><?php echo $record['father_name'] ?></td>
                            <td><?php echo $record['father_mobile'] ?></td>
                        </tr>
                        <tr>
                            <td><strong>Mother</strong></td>
                            <td><?php echo $record['mother_name'] ?></td>
                            <td><?php echo $record['mother_mobile'] ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
            <div class="col-6">
                <table class="table table-sm table-bordered">
                    <tbody>
                        <tr class="table-secondary">
                            <td colspan="5"><strong>Address Details</strong></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td><strong>Permanent</strong></td>
                            <td><strong>Local</strong></td>
                        </tr>
                        <tr>
                            <td><strong>Address</strong></td>
                            <td><?php echo $record['local_address'] ?></td>
                            <td><?php echo $record['permanent_address'] ?></td>
                        </tr>
                        <tr>
                            <td><strong>Phone</strong></td>
                            <td><?php echo $record['local_phone'] ?></td>
                            <td><?php echo $record['permanent_phone'] ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        
        <div class="row">
            <div class="col-12">
                <table class="table table-sm table-bordered">
                <thead class="table-secondary">
                    <tr>
                        <th>Exam</th>
                        <th>Total Marks</th>
                        <th>Obtain Marks</th>
                        <th>
                            <?php if($class_id >=1 && $class_id <= 6) { echo "Percentage"; } else { echo "Points"; }?>
                        </th>
                        <th>Result</th>
                        <th>Rank</th>
                        <th>Division</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    
                    $rows   = $appraisal_academic[0];
                    $ft     = $appraisal_academic[1];
                    
                    $class_id     = $appraisal_academic[2];
                    
                    
                    $total_students = count($rows["students"]);
                    
                    for ($j = 0; $j < $total_students; $j++) {
                        $student = $rows["students"][$j];
                    
                        $first_term_totals = array_sum($student["first_unit_test_marks"]) + array_sum($student["first_term_marks"]);
                        $annual_term_totals = array_sum($student["second_unit_test_marks"]) + array_sum($student["annual_term_marks"]);
                    
                        ?>
                        <tr>
                            <td class="Tdc">
                                FT
                            </td>
                          
                            <td class="Tdc">
                                <?php if($class_id == 2 || $class_id == 3) {echo "500";} else {echo "600";}?>
                            </td>
                            
                            <td class="Tdc">
                                <?php   
                                    if($class_id >=1 && $class_id <= 6) 
                                    { 
                                        echo $ft["students"][$j]["total_percentage"];
                                    } 
                                    else 
                                    { 
                                        echo $ft["students"][$j]["total_avg"]; 
                                    }
                                ?>
                            </td>
                            
                            <td class="Tdc">
                                <?php 
                                    if($class_id >=1 && $class_id <= 6) {
                                        echo number_format(($first_term_totals / (100 * count($student["first_term_marks"]))) * 100, 2); 
                                    }
                                    else {
                                        echo $ft["students"][$j]["total_point"];
                                    }
                                ?>
                            </td>
                            
                            <td class="Tdc">
                                <?php echo $ft["students"][$j]["passed"] ? "P" : "U"; ?>
                            </td>
                            
                            <td class="Tdc">
                                <?php 
                                      if($class_id >=1 && $class_id <= 6) { 
                                            if($ft["students"][$j]["eligible_for_rank"]) { 
                                                echo array_search($ft["students"][$j]["total_percentage"], $ft["ranks"]) + 1; 
                                            }
                                       }
                                      else {
                                            if($ft["students"][$j]["eligible_for_rank"]) { 
                                                echo array_search($ft["students"][$j]["total_avg"], $ft["ranks"]) + 1; 
                                            }
                                      }
                                ?>
                            </td>
                            
                            <td class="Tdc">
                                <?php echo $ft["students"][$j]["division"]; ?>
                            </td>
                        </tr>
                    
                        <tr>
                            <td class="Tdc">
                                AT
                            </td>
                          
                            <td class="Tdc">
                                <?php if($class_id == 2 || $class_id == 3) {echo "500";} else {echo "600";}?>
                            </td>
                            
                            <td class="Tdc">
                                <?php echo $student["final_avg_total"]; ?>
                            </td>
                         
                            <td class="Tdc">
                                <?php 
                                    if($class_id >=1 && $class_id <= 6) {
                                        echo number_format(($annual_term_totals / (100 * count($student["annual_term_marks"]))) * 100, 2); 
                                    }
                                    else {
                                        echo $student["total_point"];
                                    }
                                ?>
                            </td>
                            
                            <td class="Tdc">
                                <?php echo $student["passed"] ? "P" : "U"; ?>
                            </td>
                            
                            <td class="Tdc">
                                <?php if($student["is_absent"] == false) { if($student["eligible_for_rank"]) { echo array_search($student["final_avg_total"], $rows["ranks"]) + 1; } }?>
                            </td>
                            
                            <td class="Tdc">
                                <?php if(($student["is_absent"] == false) && ($student["passed"] == true)) { echo $student["division"]; }?>
                            </td>
                        </tr>
                        <?php } ?>
                </tbody>
                </table>
            </div>
        </div>
        
        <div class="row">
            <div class="col-6">
                <table class="table table-sm table-bordered">
                    <tbody>
                        <tr class="table-secondary">
                            <td colspan="4"><strong>EXTRA-CURRICULAR</strong></td>
                        </tr>
                        <tr>
                            <td><strong>EVENT</strong></td>
                            <td><strong>RESULT</td>
                            <td><strong>REMARKS</strong></td>
                        </tr>
                        
                        <?php foreach($appraisal_extra_curricular['data'] as $extra_curricular) { ?>
                            <tr>
                                <td><?php echo $extra_curricular['name']; ?></td>
                                <td><?php echo $extra_curricular['result']; ?></td>
                                <td><?php echo $extra_curricular['remarks']; ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
                
                <table class="table table-sm table-bordered">
                    <tbody>
                        <tr class="table-secondary">
                            <td colspan="4"><strong>PARTICIPATED IN</strong></td>
                        </tr>
                        <tr>
                            <td><strong>EVENT</strong></td>
                            <td><strong>RESULT</td>
                            <td><strong>REMARKS</strong></td>
                        </tr>
                        
                        <?php foreach($appraisal_game_and_sports['data'] as $game) { ?>
                            <tr>
                                <td><?php echo $game['name']; ?></td>
                                <td><?php echo $game['result']; ?></td>
                                <td><?php echo $game['remarks']; ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            
            <div class="col-6">
                <table class="table table-sm table-bordered">
                    <tbody>
                        <tr class="table-secondary">
                            <td colspan="4"><strong>DISCIPLINE</strong></td>
                        </tr>
                        <tr>
                            <td><strong>CRITERIA</strong></td>
                            <td><strong>ASSESMENT</td>
                        </tr>
                        <tr>
                            <td>CONDUCT</td>
                            <td><?php echo $appraisal_discipline['data']['conduct_name']; ?></td>
                        </tr>
                        <tr>
                            <td>BEHAVIOUS</td>
                            <td><?php echo $appraisal_discipline['data']['behaviour_name']; ?></td>
                        </tr>
                        <tr>
                            <td>PUNCTUALITY</td>
                            <td><?php echo $appraisal_discipline['data']['punctuality_name']; ?></td>
                        </tr>
                        <tr>
                            <td>ATTENDENCE</td>
                            <td><?php echo $appraisal_discipline['data']['attendance_name']; ?></td>
                        </tr>
                        <tr>
                            <td>LEADERSHIP</td>
                            <td><?php echo $appraisal_discipline['data']['leadership_name']; ?></td>
                        </tr>
                        <tr>
                            <td>INTERACTION</td>
                            <td><?php echo $appraisal_discipline['data']['interaction_name']; ?></td>
                        </tr>
                        <tr>
                            <td>EXPRESSIVENESS</td>
                            <td><?php echo $appraisal_discipline['data']['expressiveness_name']; ?></td>
                        </tr>
                        <tr>
                            <td>PARTICIPATION</td>
                            <td><?php echo $appraisal_discipline['data']['participation_name']; ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        
        <div class="row">
            <div class="col-12">
                <table class="table table-sm table-bordered">
                    <tbody>
                        <tr class="table-secondary">
                            <td colspan="4"><strong>OTHERS</strong></td>
                        </tr>
                        <tr>
                            <td><strong>PARTICULARS</strong></td>
                            <td><strong>REMARKS</td>
                        </tr>
                        
                        <?php foreach($appraisal_others['data'] as $appraisal_other) { ?>
                            <tr>
                                <td><?php echo $appraisal_other['particular']; ?></td>
                                <td><?php echo $appraisal_other['remarks']; ?></td>
                            </tr>
                        <?php } ?>
                        
                    </tbody>
                </table>
            </div>
        </div>
    </div>
  </body>
</html>