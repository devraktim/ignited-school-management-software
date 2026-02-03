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
                    <div class="BigHeader" style="font-size:15pt;">MASTER SPREAD SHEET FOR ANNUAL TERM EXAMINATION <?php if($academy_session_id == 1) {echo  "2023";} else {echo "2024";}?></div>
                    <h3 style="margin-top: 5px; margin-bottom: 0px;">ST. Joseph's Convent, Kalimpong</h3>
                </td>
                <td style="width:70px;">&nbsp;</td>
            </tr>
        </tbody>
    </table>
    <div class="smallHeader" style="width:95%; font-size:12pt; font-weight:bold; border:none;">Class <?php echo $class["name"] ?> <?php echo $section["name"] ?> - Examination Tabulation (<?php if($academy_session_id == 1) {echo  "2023";} else {echo "2024";}?>)</div>

    <?php 
        $i = 0;
        $j = 0; 
        $row = 10;
        while($j <= count($students)) {
            if($i != 0) { $row = 10; }
            $records = array_slice($students, $j, $row);                   
            $j = $j + $row;
    ?>
    <table class="GridTable" style="width:98%; margin-top:20px; margin-left:10px;">
        <tbody>
            <tr>
                <th class="Thc" style="width:2%">&nbsp;</th>
                <th class="Thc" style="width:6%">Std No</th>
                <th class="Thl" style="width:6%; text-align: center;">Name</th>
                <th class="Thc" style="width:2%">&nbsp;</th>
                <th class="Thc" style="width:3%">EL</th>
                <th class="Thc" style="width:3%">ELT</th>
                <th class="Thc" style="width:3%">EN</th>
                <th class="Thc" style="width:3%">PT</th>
                <th class="Thc" style="width:3%">PH</th>
                <th class="Thc" style="width:3%">PT</th>
                <th class="Thc" style="width:3%">CH</th>
                <th class="Thc" style="width:3%">PT</th>
                <th class="Thc" style="width:3%">BIO</th>
                <th class="Thc" style="width:3%">PT</th>
                <th class="Thc" style="width:3%">OPT1</th>
                <th class="Thc" style="width:3%">PT</th>
                <th class="Thc" style="width:3%">OPT2</th>
                <th class="Thc" style="width:3%">PT</th>
                <th class="Thc" style="width:3%">MS</th>
                <th class="Thc" style="width:3%">CAT</th>
                <th class="Thc" style="width:3%">GT</th>
                <th class="Thc" style="width:3%">TPT</th>
                <th class="Thc" style="width:3%">DV</th>
                <th class="Thc" style="width:4%">RES</th>
                <th class="Thc" style="width:3%">RNK</th>
                <th class="Thc" style="width:3%">ATD %</th>
            </tr>
            
            <?php foreach($records as $student) { $i++; ?>
            <tr>
                <td class="Tdc" style="width:2%" rowspan="7"><?php echo $i; ?></td>
                <td class="Tdc" style="width:6%" rowspan="7"><?php echo $student['student_no'] ?></td>
                <td class="Tdc" style="width:6%" rowspan="7"><?php echo $student['name'] ?></td>
            </tr>
            <tr>
                <td class="Tdc" style="width:2%">UT2</td>
                <td class="Tdc" style="width:3%"><?php echo $student["second_unit_test_marks"]["english_language"] ?></td>
                <td class="Tdc" style="width:3%"><?php echo $student["second_unit_test_marks"]["english_literature"] ?></td>
                <td class="Tdc" style="width:3%"></td>
                <td class="Tdc" style="width:3%"></td>
                <td class="Tdc" style="width:3%"><?php echo $student["second_unit_test_marks"]["physics"] ?></td>
                <td class="Tdc" style="width:3%"></td>
                <td class="Tdc" style="width:3%"><?php echo $student["second_unit_test_marks"]["chemistry"] ?></td>
                <td class="Tdc" style="width:3%"></td>
                <td class="Tdc" style="width:3%"><?php echo $student["second_unit_test_marks"]["biology"] ?></td>
                <td class="Tdc" style="width:3%"></td>
                <td class="Tdc" style="width:3%"><?php echo $student["second_unit_test_marks"]["optional_paper_1"] ?>(<?php echo $student["optional_papers"][0]["name"][0] ?>)</td>
                <td class="Tdc" style="width:3%"></td>
                <td class="Tdc" style="width:3%"><?php echo $student["second_unit_test_marks"]["optional_paper_2"] ?>(<?php echo $student["optional_papers"][1]["name"][0] ?>)</td>
                <td class="Tdc" style="width:3%"></td>
                <td class="Tdc" style="width:3%"></td>
                <td class="Tdc" style="width:4%"></td>
                <td class="Tdc" style="width:3%"></td>
                <td class="Tdc" style="width:4%"></td>
                <td class="Tdc" style="width:3%"></td>
                <td class="Tdc" style="width:3%"></td>
                <td class="Tdc" style="width:3%"></td>
                <td class="Tdc" style="width:3%"></td>
            </tr>
            <tr>
                <td class="Tdc" style="width:2%">AT</td>
                <td class="Tdc" style="width:3%"><?php echo $student["annual_term_marks"]["english_language"] ?></td>
                <td class="Tdc" style="width:3%"><?php echo $student["annual_term_marks"]["english_literature"] ?></td>
                <td class="Tdc" style="width:3%"></td>
                <td class="Tdc" style="width:3%"></td>
                <td class="Tdc" style="width:3%"><?php echo $student["annual_term_marks"]["physics"] ?></td>
                <td class="Tdc" style="width:3%"></td>
                <td class="Tdc" style="width:3%"><?php echo $student["annual_term_marks"]["chemistry"] ?></td>
                <td class="Tdc" style="width:3%"></td>
                <td class="Tdc" style="width:3%"><?php echo $student["annual_term_marks"]["biology"] ?></td>
                <td class="Tdc" style="width:3%"></td>
                <td class="Tdc" style="width:3%"><?php echo $student["annual_term_marks"]["optional_paper_1"] ?>(<?php echo $student["optional_papers"][0]["name"][0] ?>)</td>
                <td class="Tdc" style="width:3%"></td>
                <td class="Tdc" style="width:3%"><?php echo $student["annual_term_marks"]["optional_paper_2"] ?>(<?php echo $student["optional_papers"][1]["name"][0] ?>)</td>
                <td class="Tdc" style="width:3%"></td>
                <td class="Tdc" style="width:3%"></td>
                <td class="Tdc" style="width:3%"></td>
                <td class="Tdc" style="width:3%"></td>
                <td class="Tdc" style="width:3%"></td>
                <td class="Tdc" style="width:3%"></td>
                <td class="Tdc" style="width:3%"></td>
                <td class="Tdc" style="width:3%"></td>
                <td class="Tdc" style="width:3%"></td>
            </tr>
            <tr>
                <td class="Tdc" style="width:2%">TOT</td>
                <td class="Tdc" style="width:3%"><?php echo $student["annual_term_totals"]["english_language"] ?></td>
                <td class="Tdc" style="width:3%"><?php echo $student["annual_term_totals"]["english_literature"] ?></td>
                <td class="Tdc" style="width:3%"></td>
                <td class="Tdc" style="width:3%"></td>
                <td class="Tdc" style="width:3%"><?php echo $student["annual_term_totals"]["physics"] ?></td>
                <td class="Tdc" style="width:3%"></td>
                <td class="Tdc" style="width:3%"><?php echo $student["annual_term_totals"]["chemistry"] ?></td>
                <td class="Tdc" style="width:3%"></td>
                <td class="Tdc" style="width:3%"><?php echo $student["annual_term_totals"]["biology"] ?></td>
                <td class="Tdc" style="width:3%"></td>
                <td class="Tdc" style="width:3%"><?php echo $student["annual_term_totals"]["optional_paper_1"] ?>(<?php echo $student["optional_papers"][0]["name"][0] ?>)</td>
                <td class="Tdc" style="width:3%"></td>
                <td class="Tdc" style="width:3%"><?php echo $student["annual_term_totals"]["optional_paper_2"] ?>(<?php echo $student["optional_papers"][1]["name"][0] ?>)</td>
                <td class="Tdc" style="width:3%"></td>
                <td class="Tdc" style="width:3%"></td>
                <td class="Tdc" style="width:4%"></td>
                <td class="Tdc" style="width:3%"></td>
                <td class="Tdc" style="width:4%"></td>
                <td class="Tdc" style="width:3%"></td>
                <td class="Tdc" style="width:3%"></td>
                <td class="Tdc" style="width:3%"></td>
                <td class="Tdc" style="width:3%"></td>
            </tr>
            <tr>
                <td class="Tdc" style="width:2%">AAV</td>
                <td class="Tdc" style="width:3%"></td>
                <td class="Tdc" style="width:3%"></td>
                <td class="Tdc" style="width:3%"><?php echo $student["annual_term_avg"]["english"] ?></td>
                <td class="Tdc" style="width:3%"></td>
                <td class="Tdc" style="width:3%"><?php echo $student["annual_term_avg"]["physics"] ?></td>
                <td class="Tdc" style="width:3%"></td>
                <td class="Tdc" style="width:3%"><?php echo $student["annual_term_avg"]["chemistry"] ?></td>
                <td class="Tdc" style="width:3%"></td>
                <td class="Tdc" style="width:3%"><?php echo $student["annual_term_avg"]["biology"] ?></td>
                <td class="Tdc" style="width:3%"></td>
                <td class="Tdc" style="width:3%"><?php echo $student["annual_term_avg"]["optional_paper_1"] ?>(<?php echo $student["optional_papers"][0]["name"][0] ?>)</td>
                <td class="Tdc" style="width:3%"></td>
                <td class="Tdc" style="width:3%"><?php echo $student["annual_term_avg"]["optional_paper_2"] ?>(<?php echo $student["optional_papers"][1]["name"][0] ?>)</td>
                <td class="Tdc" style="width:3%"></td>
                <td class="Tdc" style="width:3%"><?php echo $student['annual_term_grade_subjects']['moral_science'] ?></td>
                <td class="Tdc" style="width:4%"><?php echo $student['annual_term_grade_subjects']['catechism'] ?></td>
                <td class="Tdc" style="width:3%"></td>
                <td class="Tdc" style="width:4%"></td>
                <td class="Tdc" style="width:3%"></td>
                <td class="Tdc" style="width:3%"></td>
                <td class="Tdc" style="width:3%"></td>
                <td class="Tdc" style="width:3%"></td>
            </tr>
            <tr>
                <td class="Tdc" style="width:2%">FTAV</td>
                <td class="Tdc" style="width:3%"></td>
                <td class="Tdc" style="width:3%"></td>
                <td class="Tdc" style="width:3%"><?php echo $student["first_term_avg"]["english"] ?></td>
                <td class="Tdc" style="width:3%"></td>
                <td class="Tdc" style="width:3%"><?php echo $student["first_term_avg"]["physics"] ?></td>
                <td class="Tdc" style="width:3%"></td>
                <td class="Tdc" style="width:3%"><?php echo $student["first_term_avg"]["chemistry"] ?></td>
                <td class="Tdc" style="width:3%"></td>
                <td class="Tdc" style="width:3%"><?php echo $student["first_term_avg"]["biology"] ?></td>
                <td class="Tdc" style="width:3%"></td>
                <td class="Tdc" style="width:3%"><?php echo $student["first_term_avg"]["optional_paper_1"] ?>(<?php echo $student["optional_papers"][0]["name"][0] ?>)</td>
                <td class="Tdc" style="width:3%"></td>
                <td class="Tdc" style="width:3%"><?php echo $student["first_term_avg"]["optional_paper_2"] ?>(<?php echo $student["optional_papers"][1]["name"][0] ?>)</td>
                <td class="Tdc" style="width:3%"></td>
                <td class="Tdc" style="width:3%"><?php echo $student['first_term_grade_subjects']['moral_science'] ?></td>
                <td class="Tdc" style="width:4%"><?php echo $student['first_term_grade_subjects']['catechism'] ?></td>
                <td class="Tdc" style="width:3%"></td>
                <td class="Tdc" style="width:4%"></td>
                <td class="Tdc" style="width:3%"></td>
                <td class="Tdc" style="width:3%"></td>
                <td class="Tdc" style="width:3%"></td>
                <td class="Tdc" style="width:3%"></td>
            </tr>
            <tr>
                <td class="Tdc" style="width:2%">FNAV</td>
                <td class="Tdc" style="width:3%"></td>
                <td class="Tdc" style="width:3%"></td>
                <td class="Tdc" style="width:3%"><?php echo $student["final_avg"]["english"] ?></td>
                <td class="Tdc" style="width:3%"><?php echo $student["points"]["english"] ?></td>
                <td class="Tdc" style="width:3%"><?php echo $student["final_avg"]["physics"] ?></td>
                <td class="Tdc" style="width:3%"><?php echo $student["points"]["physics"] ?></td>
                <td class="Tdc" style="width:3%"><?php echo $student["final_avg"]["chemistry"] ?></td>
                <td class="Tdc" style="width:3%"><?php echo $student["points"]["chemistry"] ?></td>
                <td class="Tdc" style="width:3%"><?php echo $student["final_avg"]["biology"] ?></td>
                <td class="Tdc" style="width:3%"><?php echo $student["points"]["biology"] ?></td>
                <td class="Tdc" style="width:3%"><?php echo $student["final_avg"]["optional_paper_1"] ?></td>
                <td class="Tdc" style="width:3%"><?php echo $student["points"]["optional_paper_1"] ?></td>
                <td class="Tdc" style="width:3%"><?php echo $student["final_avg"]["optional_paper_2"] ?></td>
                <td class="Tdc" style="width:3%"><?php echo $student["points"]["optional_paper_2"] ?></td>
                <td class="Tdc" style="width:3%">
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
                <td class="Tdc" style="width:3%">
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
                <td class="Tdc" style="width:3%"><?php echo $student["final_avg_total"] ?></td>
                <td class="Tdc" style="width:3%"><?php echo $student["total_point"] ?></td>
                <td class="Tdc" style="width:3%"><?php if(($student["is_absent"] == false) && ($student["passed"] == true)) { echo $student["division"][0]; }?></td>
                <td class="Tdc" style="width:3%"><?php if($student["is_absent"] == false) { echo $student["passed"] ? "P" : "UN"; } else { echo "I" ; } ?></td>
                <td class="Tdc" style="width:3%"><?php if($student["is_absent"] == false) { if($student["eligible_for_rank"]) { echo array_search($student["final_avg_total"], $ranks) + 1; } }?></td>
                <td class="Tdc" style="width:3%"><?php echo $student["attendence"] ?></td>
            </tr>
            <tr>
                <td colspan=25><br><br></td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
    <div style="page-break-before:always">&nbsp;</div>
    <?php } ?>
</body>

</html>