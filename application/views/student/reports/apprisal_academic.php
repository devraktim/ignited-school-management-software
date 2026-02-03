<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <style>
            @media print {
                canvas {
                    page-break-inside: avoid; /* Prevent page breaks inside the canvas element */
                }
            }
            canvas, .canvas-container {
                page-break-before: auto;
                page-break-after: auto;
                page-break-inside: auto;
            }

            canvas {
                display: block;
                width: 100%;
                height: auto;
            }

            .BigHeader {
                text-align:center;
                font-family: 'MS Sans Serif', Serif;
                font-weight:bold;
                font-size:16pt;
                
            }

            .SmallHeader
            {
                width:98%;
                text-align:center;
                font-family:Arial;
                font-size:12pt;    
                margin-left:10px;
                border-bottom: 1px #000 double;
            }

            .DispTable
            {
                border-collapse: collapse;
            }

            .DispTable TD.FldR
            {
                font-family:Georgia, "Times New Roman";
                font-size:9pt;
                font-weight: bold;
                text-align:right;
                padding-right:5px;
                padding-top:3px;
            }

            .DispTable TD.FldL
            {
                font-family:Georgia, "Times New Roman";
                font-size:9pt;
                font-weight: bold;
                text-align:left;
                padding-left:5px;
                padding-top:3px;
            }

            .DispTable TD.Dta
            {
                font-family:"Courier New", "Arial";
                font-size:10pt;
                text-align:left;
                padding-left:10px;
                padding-top:3px;
                border-bottom: 1px #000 dotted;
            }

            .DispTable TD.Hdr
            {
                font-family:"Georgia", "Times New Roman";
                font-size:12pt;
                font-variant: small-caps;
                text-align:left;
                padding-left:10px;
                padding-top:3px;     
                padding-bottom:5px;
            }

            .GridTable
            {
                border: 2px #000 solid;
                border-collapse: collapse;   
                border-radius: 15px;
            }

            .GridTable th.thl
            {
                border: 1px #000 solid;
                padding-left:5px;
                text-align:left;
                font-family:"Times New Roman", Georgia;
                font-size:10pt;
                font-weight:bold;
                font-variant: small-caps;
                background: #EEE;
                color:#000;
            }

            .GridTable th.thr
            {
                border: 1px #000 solid;
                padding-right:5px;
                text-align:right;
                font-family:"Times New Roman", Georgia;
                font-size:10pt;
                font-weight:bold;
                font-variant: small-caps;
                background: #EEE;
                color:#000;
            }

            .GridTable th.thc
            {
                border: 1px #000 solid;
                text-align:center;
                font-family:"Times New Roman", Georgia;
                font-size:10pt;
                font-weight:bold;
                font-variant: small-caps;
                background: #EEE;
                color:#000;
            }

            .GridTable td
            {
                border: 1px #000 solid;
                padding-left:5px;
                text-align:left;
                font-family:"Courier New", Arial;
                font-size:10pt;    
            }

            .GridTable td.Tdr
            {
                border: 1px #000 solid;
                padding-right:5px;
                text-align:right;
                font-family:  Arial, "Courier New";
                font-size:10pt;    
            }

            .GridTable td.Tdc
            {
                border: 1px #000 solid;
                text-align:center;
                font-family:"Courier New", Arial;
                font-size:10pt;    
            }

            .GridTable td.Fld
            {
                border: 1px #000 solid;
                text-align:left;
                font-family:Georgia, 'Times New Roman';
                font-size:10pt;
                font-weight:bold;    
            }

            .GridTable td.Srl
            {
                border: 1px #000 solid;
                padding-right:5px;
                text-align:right;
                font-family:  Arial, "Courier New";
                font-size:9pt;    
                background-color: #EFEFEF;
            }

            DIV.Info
            {
                margin-left: 30px;
                font-family: "Times New Roman", Arial;
                font-size: 16pt;
                font-weight: bold;
                font-variant: small-caps;
            }
        </style>
    </head>

    <body data-new-gr-c-s-check-loaded="14.1098.0" data-gr-ext-installed="">
        <?php 
            $class_map = [
                1 => "NURSERY", 2 => "LKG", 3 => "UKG", 4 => "I", 5 => "II", 
                6 => "III", 7 => "IV", 8 => "V", 9 => "VI", 10 => "VII", 
                11 => "VIII", 12 => "IX", 13 => "X", 14 => "XI", 15 => "XII"
            ];
            
            $section_map = [
                1 => "A", 2 => "SC", 3 => "HU"
            ];
            
            $student_type_map = [
                1 => "Day Scholars", 1 => "Day Boarders", 3 => "Boarder"
            ];
        ?>
        
        <?php 
            $sl_no = 1;
            $i = 0; 
        
            $records = $at["students"];
            
            while($i <= count($records)) {
                $rows = array_slice($records, $i, 25);                   
                $i = $i + 25;
        ?>
            <table style="width: 98%; border-collapse: collapse; margin-left: 10px; border-bottom: 2px solid rgb(0, 0, 0); --darkreader-inline-border-bottom:#7e7669;" data-darkreader-inline-border-bottom="">
                <tbody>
                    <tr>
                        <td style="vertical-align:top" rowspan="2">
                            <img src="<?php echo base_url()?>assets/media/logos/logol.png" style="Height:70px; Width:70px">
                        </td>
                        <td style="text-align:center; vertical-align:top">
                            <div style="font-family:Arial; font-size:30pt">
                                St. Francis School
                            </div>
                        </td>
                        <td style="vertical-align:top; text-align: end;" rowspan="2">
                            <img src="<?php echo base_url()?>assets/media/logos/logol.png" style="Height:70px; Width:70px">
                        </td>
                    </tr>
                    <tr>
                        <td style="text-align:center">
                            <table style="width:99%">
                                <tbody>
                                    <tr>
                                        <td style="font-size:10pt; font-family:Arial; text-align:center; font-style: italic">
                                            Jorethang
                                        </td>                            
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="BigHeader" style="width:90%; margin: 0 auto; margin-top:20px">Apprisal Academic List <?php echo date('Y', strtotime($this->session->academy_session['current_session']['start'])) ?>  
                
                <?php 
                    if(isset($clauses["ss_class_id"]) && ($clauses["ss_class_id"] != "")) { 
                        echo $class_map[$clauses["ss_class_id"]]; 
                        
                    }
                    
                    if(isset($clauses["ss_section_id"]) && ($clauses["ss_section_id"] != "")) { 
                        echo " - " . $section_map[$clauses["ss_section_id"]]; 
                        
                    }
                    
                    if(isset($clauses["s_student_type_id"]) && ($clauses["s_student_type_id"] != "")) { 
                        echo " - " . $student_type_map[$clauses["s_student_type_id"]]; 
                        
                    }
                ?>
            
            </div>
                        
            <table class="GridTable" style="width:94%; margin: 0 auto; margin-top:30px">
                <thead>
                    <tr>
                        <th class="Thc" style="width:3%">S.NO</th>
                        <th class="Thc">Student No</th>
                        <th class="Thc">Name</th>
                        <th class="Thc">Exam</th>
                        <th class="Thc">Total Marks</th>
                        <th class="Thc">Obtain Marks</th>
                        <th class="Thc">
                            <?php if($clauses["ss_class_id"] >=1 && $clauses["ss_class_id"] <= 6) { echo "Percentage"; } else { echo "Points"; }?>
                        </th>
                        <th class="Thc">Result</th>
                        <th class="Thc">Rank</th>
                        <th class="Thc">Division</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $total_students = count($rows);
                    
                    for ($j = 0; $j < $total_students; $j++) {
                        $student = $rows[$j];
                    
                        $first_term_totals = array_sum($student["first_unit_test_marks"]) + array_sum($student["first_term_marks"]);
                        $annual_term_totals = array_sum($student["second_unit_test_marks"]) + array_sum($student["annual_term_marks"]);
                    
                        ?>
                        <tr>
                            <td class="Tdc" rowspan=2>
                                <?php echo $sl_no; ?>
                            </td>
                            <td class="Tdc" rowspan=2>
                                <?php echo $student['student_no']; ?>
                            </td>
                            <td class="Tdc" rowspan=2>
                                <?php echo $student['name']; ?>
                            </td>
                            
                            <td class="Tdc">
                                FT
                            </td>
                          
                            <td class="Tdc">
                                <?php if($clauses["ss_class_id"] == 2 || $clauses["ss_class_id"] == 3) {echo "500";} else {echo "600";}?>
                            </td>
                            
                            <td class="Tdc">
                                <?php if($clauses["ss_class_id"] >=1 && $clauses["ss_class_id"] <= 6) { echo $ft["students"][$sl_no - 1]["total_percentage"];} else { echo $ft["students"][$sl_no - 1]["total_avg"]; }?>
                            </td>
                            
                            <td class="Tdc">
                                <?php 
                                    if($clauses["ss_class_id"] >=1 && $clauses["ss_class_id"] <= 6) {
                                        echo number_format(($first_term_totals / (100 * count($student["first_term_marks"]))) * 100, 2); 
                                    }
                                    else {
                                        echo $ft["students"][$sl_no - 1]["total_point"];
                                    }
                                ?>
                            </td>
                            
                            <td class="Tdc">
                                <?php echo $ft["students"][$sl_no - 1]["passed"] ? "P" : "U"; ?>
                            </td>
                            
                            <td class="Tdc">
                                <?php 
                                      if($clauses["ss_class_id"] >=1 && $clauses["ss_class_id"] <= 6) { 
                                            if($ft["students"][$sl_no - 1]["eligible_for_rank"]) { 
                                                echo array_search($ft["students"][$sl_no - 1]["total_percentage"], $ft["ranks"]) + 1; 
                                            }
                                       }
                                      else {
                                            if($ft["students"][$sl_no - 1]["eligible_for_rank"]) { 
                                                echo array_search($ft["students"][$sl_no - 1]["total_avg"], $ft["ranks"]) + 1; 
                                            }
                                      }
                                ?>
                            </td>
                            
                            <td class="Tdc">
                                <?php echo $ft["students"][$sl_no - 1]["division"]; ?>
                            </td>
                        </tr>
                    
                        <tr>
                            <td class="Tdc">
                                AT
                            </td>
                          
                            <td class="Tdc">
                                <?php if($clauses["ss_class_id"] == 2 || $clauses["ss_class_id"] == 3) {echo "500";} else {echo "600";}?>
                            </td>
                            
                            <td class="Tdc">
                                <?php echo $student["final_avg_total"]; ?>
                            </td>
                         
                            <td class="Tdc">
                                <?php 
                                    if($clauses["ss_class_id"] >=1 && $clauses["ss_class_id"] <= 6) {
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
                                <?php if($student["is_absent"] == false) { if($student["eligible_for_rank"]) { echo array_search($student["final_avg_total"], $at["ranks"]) + 1; } }?>
                            </td>
                            
                            <td class="Tdc">
                                <?php if(($student["is_absent"] == false) && ($student["passed"] == true)) { echo $student["division"]; }?>
                            </td>
                        </tr>
                        <?php
                        $sl_no++;
                    }
                    ?>
                </tbody>
            </table>
            <div style="page-break-before:always">&nbsp;</div>
        <?php } ?>
        
        <div style="display: flex; justify-content: center; align-items: center;">
            <canvas id="myPieChart1" width="400" height="400"></canvas>
        </div>
        
        <div style="display: flex; justify-content: center; align-items: center;">
            <canvas id="myPieChart2" width="1000" height="1000"></canvas>
        </div>
    </body>

</html>