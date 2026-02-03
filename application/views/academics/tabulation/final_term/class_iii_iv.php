<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Tabulation Sheet</title>
    <style>
        .BigHeader {
            text-align: center;
            font-family: 'MS Sans Serif', Serif;
            font-weight: bold;
            font-size: 16pt;

        }

        .SmallHeader {
            width: 98%;
            text-align: center;
            font-family: Arial;
            font-size: 12pt;
            margin-left: 10px;
            border-bottom: 1px #000 double;
        }

        .DispTable {
            border-collapse: collapse;
        }

        .DispTable TD.FldR {
            font-family: Georgia, "Times New Roman";
            font-size: 9pt;
            font-weight: bold;
            text-align: right;
            padding-right: 5px;
            padding-top: 3px;
        }

        .DispTable TD.FldL {
            font-family: Georgia, "Times New Roman";
            font-size: 9pt;
            font-weight: bold;
            text-align: left;
            padding-left: 5px;
            padding-top: 3px;
        }

        .DispTable TD.Dta {
            font-family: "Courier New", "Arial";
            font-size: 10pt;
            text-align: left;
            padding-left: 10px;
            padding-top: 3px;
            border-bottom: 1px #000 dotted;
        }

        .DispTable TD.Hdr {
            font-family: "Georgia", "Times New Roman";
            font-size: 12pt;
            font-variant: small-caps;
            text-align: left;
            padding-left: 10px;
            padding-top: 3px;
            padding-bottom: 5px;
        }

        .GridTable {
            border: 2px #000 solid;
            border-collapse: collapse;
            border-radius: 15px;
        }

        .GridTable th.thl {
            border: 1px #000 solid;
            padding-left: 5px;
            text-align: left;
            font-family: "Times New Roman", Georgia;
            font-size: 10pt;
            font-weight: bold;
            font-variant: small-caps;
            background: #EEE;
            color: #000;
        }

        .GridTable th.thr {
            border: 1px #000 solid;
            padding-right: 5px;
            text-align: right;
            font-family: "Times New Roman", Georgia;
            font-size: 10pt;
            font-weight: bold;
            font-variant: small-caps;
            background: #EEE;
            color: #000;
        }

        .GridTable th.thc {
            border: 1px #000 solid;
            text-align: center;
            font-family: "Times New Roman", Georgia;
            font-size: 10pt;
            font-weight: bold;
            font-variant: small-caps;
            background: #EEE;
            color: #000;
        }

        .GridTable td {
            border: 1px #000 solid;
            padding-left: 5px;
            text-align: left;
            font-family: "Courier New", Arial;
            font-size: 10pt;
        }

        .GridTable td.Tdr {
            border: 1px #000 solid;
            padding-right: 5px;
            text-align: right;
            font-family: Arial, "Courier New";
            font-size: 10pt;
        }

        .GridTable td.Tdc {
            border: 1px #000 solid;
            text-align: center;
            font-family: "Courier New", Arial;
            font-size: 10pt;
        }

        .GridTable td.Fld {
            border: 1px #000 solid;
            text-align: left;
            font-family: Georgia, 'Times New Roman';
            font-size: 10pt;
            font-weight: bold;
        }

        .GridTable td.Srl {
            border: 1px #000 solid;
            padding-right: 5px;
            text-align: right;
            font-family: Arial, "Courier New";
            font-size: 9pt;
            background-color: #EFEFEF;
        }

        DIV.Info {
            margin-left: 30px;
            font-family: "Times New Roman", Arial;
            font-size: 16pt;
            font-weight: bold;
            font-variant: small-caps;
        }


        .GridTable td,
        .GridTable td.Tdr,
        .GridTable td.Tdc {
            font-size: 8pt;
        }

        .GridTable th.Thl,
        .GridTable th.Thc {
            font-size: 8pt;
        }
    </style>
</head>

<?php $academy_session_id = $this->session->academy_session['current_session']['id']; ?>
<body onload="javascript:setValues()">

    <table style="width:95%; margin-left:10px;">
        <tbody>
            <tr>
                <td style="text-align:left; vertical-align:top; width:100px;">
                    <img src="<?php echo base_url() ?>assets/media/logos/logol.png" style="width:70px;">
                </td>
                <td style="text-align:center; vertical-align:top">
                    <div class="BigHeader" style="font-size:15pt;">MASTER SPREAD SHEET FOR FINAL TERM EXAMINATION 2025</div>
                    <h3 style="margin-top: 5px; margin-bottom: 0px;">ST. FRANCIS SCHOOL, JORETHANG SOUTH SIKKIM</h3>
                </td>
                <td style="text-align:right; vertical-align:top; width:100px;">
                    <img src="<?php echo base_url() ?>assets/media/logos/logol.png" style="width:70px;">
                </td>
            </tr>
        </tbody>
    </table>
    <div class="smallHeader" style="width:95%; font-size:12pt; font-weight:bold; border:none;">Class <?php echo $class_detail["name"] ?> <?php echo $section_detail["name"] ?> - Final Term Examination Tabulation - 2025</div>
    <?php 
        $i = 0;
        $j = 0; 
        $row = 20;
        while($j <= count($students)) {
            if($i != 0) { $row = 20; }
            $records = array_slice($students, $j, $row);                   
            $j = $j + $row;
    ?>
    <table class="GridTable" style="width:98%; margin-top:20px; margin-left:10px;">
        <tbody>
            <tr>
                <th rowspan="3" class="Thc" style="width:2%;">Std No</th>
                <th rowspan="3" class="Thc" style="width:10% !important;">Name</th>
                <th colspan="3" class="Thc" style="width:2%;">English I & II</th>
                <th colspan="3" class="Thc" style="width:2%;">2nd Lang</th>
                <th colspan="3" class="Thc" style="width:2%;">Maths</th>
                <th colspan="3" class="Thc" style="width:2%;">Gen Sc</th>
                <th colspan="3" class="Thc" style="width:2%;">Comp Std</th>
                <th colspan="3" class="Thc" style="width:2%;">Sp & Dict</th>
                <th colspan="3" class="Thc" style="width:2%;">SST</th>
                <th colspan="3" class="Thc" style="width:2%;">GK</th>
                <th colspan="3" class="Thc" style="width:2%;">V Ed</th>
                <th rowspan="3" class="Thc" style="width:2%;">ANT</th>
                <th rowspan="3" class="Thc" style="width:2%;">PCNT</th>
                <th rowspan="3" class="Thc" style="width:2%;">RST</th>
                <th rowspan="3" class="Thc" style="width:2%;">R</th>
                <th rowspan="3" class="Thc" style="width:2%;">ATD</th>
            </tr>
            <tr>
                <th class="Thc" >(F)</th>
                <th class="Thc" >(H)</th>
                <th class="Thc" >(A)</th>
                
                <th class="Thc" >(F)</th>
                <th class="Thc" >(H)</th>
                <th class="Thc" >(A)</th>
                
                <th class="Thc" >(F)</th>
                <th class="Thc" >(H)</th>
                <th class="Thc" >(A)</th>
                
                <th class="Thc" >(F)</th>
                <th class="Thc" >(H)</th>
                <th class="Thc" >(A)</th>
                
                <th class="Thc" >(F)</th>
                <th class="Thc" >(H)</th>
                <th class="Thc" >(A)</th>
                
                <th class="Thc" >(F)</th>
                <th class="Thc" >(H)</th>
                <th class="Thc" >(A)</th>
        
                <th class="Thc" >(F)</th>
                <th class="Thc" >(H)</th>
                <th class="Thc" >(A)</th>
                
                <th class="Thc" >(F)</th>
                <th class="Thc" >(H)</th>
                <th class="Thc" >(A)</th>
                
                <th class="Thc" >(F)</th>
                <th class="Thc" >(H)</th>
                <th class="Thc" >(A)</th>
            </tr>
            <tr>
                <th class="Thc" style="width:2%">100</td>
                <th class="Thc" style="width:2%">100</td>
                <th class="Thc" style="width:2%">100</th>
                <th class="Thc" style="width:2%">100</th>
                <th class="Thc" style="width:2%">100</th>
                <th class="Thc" style="width:2%">100</th>
                <th class="Thc" style="width:2%">100</th>
                <th class="Thc" style="width:2%">100</th>
                <th class="Thc" style="width:2%">100</th>
                <th class="Thc" style="width:2%">100</th>
                <th class="Thc" style="width:2%">100</th>
                <th class="Thc" style="width:2%">100</th>
                <th class="Thc" style="width:2%">100</th>
                <th class="Thc" style="width:2%">100</th>
                <th class="Thc" style="width:2%">100</th>
                <th class="Thc" style="width:2%">100</th>
                <th class="Thc" style="width:2%">100</th>
                <th class="Thc" style="width:2%">100</th>
                <th class="Thc" style="width:2%">100</th>
                <th class="Thc" style="width:2%">100</th>
                <th class="Thc" style="width:2%">100</th>
                <th class="Thc" style="width:2%">100</th>
                <th class="Thc" style="width:2%">100</th>
                <th class="Thc" style="width:2%">100</th>
                <th class="Thc" style="width:2%">100</th>
                <th class="Thc" style="width:2%">100</th>
                <th class="Thc" style="width:2%">100</th>
            </tr>
            
            <!--Data-->
            <?php foreach($records as $student) { $i++; ?>
                <tr>
                  <td class="Tdc"><?php echo $student['student_no'] ?></td>
                  <td class="Tdc" style="width:10% !important;"><?php echo $student['name'] ?></td>
                  
                  <!--English I & II-->
                  <td class="Tdc"><?php echo $student['final_totals']['s1'] ?></td>
                  <td class="Tdc"><?php echo $student['mid_totals']['s1'] ?></td>
                  <td class="Tdc"><?php echo $student['annual_marks']['s1'] ?></td>
                  
                  <!--2nd Lang-->
                  <td class="Tdc"><?php echo $student['final_totals']['s2'] ?></td>
                  <td class="Tdc"><?php echo $student['mid_totals']['s2'] ?></td>
                  <td class="Tdc"><?php echo $student['annual_marks']['s2'] ?></td>
                  
                  <!--Maths-->
                  <td class="Tdc"><?php echo $student['final_totals']['s3'] ?></td>
                  <td class="Tdc"><?php echo $student['mid_totals']['s3'] ?></td>
                  <td class="Tdc"><?php echo $student['annual_marks']['s3'] ?></td>
                  
                  <!--Gen Sc-->
                  <td class="Tdc"><?php echo $student['final_totals']['s4'] ?></td>
                  <td class="Tdc"><?php echo $student['mid_totals']['s4'] ?></td>
                  <td class="Tdc"><?php echo $student['annual_marks']['s4'] ?></td>
                  
                  <!--Comp Std-->
                  <td class="Tdc"><?php echo $student['final_totals']['s5'] ?></td>
                  <td class="Tdc"><?php echo $student['mid_totals']['s5'] ?></td>
                  <td class="Tdc"><?php echo $student['annual_marks']['s5'] ?></td>
                  
                  <!--Sp & Dict-->
                  <td class="Tdc"><?php echo $student['final_totals']['s6'] ?></td>
                  <td class="Tdc"><?php echo $student['mid_totals']['s6'] ?></td>
                  <td class="Tdc"><?php echo $student['annual_marks']['s6'] ?></td>
                  
                  <!--SST-->
                  <td class="Tdc"><?php echo $student['final_totals']['s7'] ?></td>
                  <td class="Tdc"><?php echo $student['mid_totals']['s7'] ?></td>
                  <td class="Tdc"><?php echo $student['annual_marks']['s7'] ?></td>
                  
                  <!--GK-->
                  <td class="Tdc"><?php echo $student['special_final_totals']['sps1'] ?></td>
                  <td class="Tdc"><?php echo $student['special_mid_totals']['sps1'] ?></td>
                  <td class="Tdc"><?php echo $student['special_annual_marks']['sps1'] ?></td>
                  
                  <!--V Edt-->
                  <td class="Tdc"><?php echo $student['special_final_totals']['sps2'] ?></td>
                  <td class="Tdc"><?php echo $student['special_mid_totals']['sps2'] ?></td>
                  <td class="Tdc"><?php echo $student['special_annual_marks']['sps2'] ?></td>
                  
                  <td class="Tdc"><?= array_sum($student['annual_marks']) + array_sum($student['special_annual_marks'] ?? []) ?></td>
                  <td class="Tdc"><?= isset($student['percentage']) ? $student['percentage'] . '%' : '' ?></td>
                  <td class="Tdc">
                        <?php 
                            if($student['ut2_absent'] > 0 || $student['final_absent'] > 0) 
                            {
                                if($student['ut2_absent'] > 0) {
                                    echo $student['result'];
                                }
                                
                                if($student['final_absent'] > 0) {
                                    echo "INC";
                                }
                            } 
                            else {
                                echo $student['result'];
                            }
                        ?>
                    </td>
                  <td class="Tdc">
                        <?php 
                            if($student['ut2_absent'] > 0 || $student['final_absent'] > 0) 
                            {
                                if($student['ut2_absent'] > 0) {
                                    echo "";
                                }
                                
                                if($student['final_absent'] > 0) {
                                    echo "N/A";
                                }
                            } 
                            else {
                                echo $student['rank'];
                            }
                        ?>
                  </td>
                  <td class="Tdc"><?= !empty($student['attendence']) ? $student['attendence'] . '%' : '' ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
    <div style="page-break-before:always">&nbsp;</div>
    <?php } ?>
</body>

</html>