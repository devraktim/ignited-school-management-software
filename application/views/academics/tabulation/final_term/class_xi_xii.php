<!DOCTYPE html>
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

<body onload="javascript:setValues()">

<?php
$academy_session_id = $this->session->academy_session['current_session']['id'];

// SUBJECT NAME SWITCHING BASED ON SECTION
$sub_math = "Mathematics";
$sub_phy  = "Physics";
$sub_chem = "Chemistry";
$sub_bio  = "Biology";

// If section is HU → replace subjects
if ($section_detail["name"] === "HU") {
    $sub_math = "Political Science";
    $sub_phy  = "History";
    $sub_chem = "Geography";
    $sub_bio  = "Economics";
}

function printSubjectMarks($student, $subjectName) {

    if ($subjectName === 'N/A') {
        echo '<td class="Tdc"></td><td class="Tdc"></td><td class="Tdc"></td>';
        return;
    }

    $key = array_search($subjectName, $student['subjects']);

    if ($key !== false) {
        echo '<td class="Tdc">' . $student['final_totals'][$key] . '</td>';
        echo '<td class="Tdc">' . $student['mid_totals'][$key] . '</td>';
        echo '<td class="Tdc">' . $student['annual_marks'][$key] . '</td>';
    } else {
        echo '<td class="Tdc"></td><td class="Tdc"></td><td class="Tdc"></td>';
    }
}
?>

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

<div class="smallHeader" style="width:95%; font-size:12pt; font-weight:bold; border:none; text-align: center;">
    Class <?php echo $class_detail["name"] ?> <?php echo $section_detail["name"] ?> - Final Term Examination Tabulation - 2025
</div>

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
            <th rowspan="3" class="Thc" style="width:2%; border: 1px solid black; background-color: #e8e8e8;">Std No</th>
            <th rowspan="3" class="Thc" style="width:10%; border: 1px solid black; background-color: #e8e8e8;">Name</th>

            <th colspan="3" class="Thc" style="border: 1px solid black; background-color: #e8e8e8;">English</th>
            <th colspan="3" class="Thc" style="border: 1px solid black; background-color: #e8e8e8;">2nd Lang</th>

            <!-- Dynamic Subject Headers -->
            <th colspan="3" class="Thc" style="border: 1px solid black; background-color: #e8e8e8;">Comp Sc</th>
            <th colspan="3" class="Thc" style="border: 1px solid black; background-color: #e8e8e8;"><?= $sub_math ?></th>
            <th colspan="3" class="Thc" style="border: 1px solid black; background-color: #e8e8e8;"><?= $sub_phy ?></th>
            <th colspan="3" class="Thc" style="border: 1px solid black; background-color: #e8e8e8;"><?= $sub_chem ?></th>
            <th colspan="3" class="Thc" style="border: 1px solid black; background-color: #e8e8e8;"><?= $sub_bio ?></th>

            <th rowspan="3" class="Thc" style="border: 1px solid black; background-color: #e8e8e8;">ANT</th>
            <th rowspan="3" class="Thc" style="border: 1px solid black; background-color: #e8e8e8;">PCNT</th>
            <th rowspan="3" class="Thc" style="border: 1px solid black; background-color: #e8e8e8;">RST</th>
            <th rowspan="3" class="Thc" style="border: 1px solid black; background-color: #e8e8e8;">R</th>
            <th rowspan="3" class="Thc" style="border: 1px solid black; background-color: #e8e8e8;">ATD</th>

            <th colspan="3" class="Thc" style="border: 1px solid black; background-color: #e8e8e8;">GK</th>
            <th colspan="3" class="Thc" style="border: 1px solid black; background-color: #e8e8e8;">v Ed</th>
        </tr>

        <tr>
            <?php for ($x=1; $x<10; $x++): ?>
                <th class="Thc" style="border: 1px solid black; background-color: #e8e8e8;">(F)</th>
                <th class="Thc" style="border: 1px solid black; background-color: #e8e8e8;">(H)</th>
                <th class="Thc" style="border: 1px solid black; background-color: #e8e8e8;">(A)</th>
            <?php endfor; ?>
        </tr>

        <tr>
            <?php for ($x=1; $x<10; $x++): ?>
                <th class="Thc" style="border: 1px solid black; background-color: #e8e8e8;">100</th>
                <th class="Thc" style="border: 1px solid black; background-color: #e8e8e8;">100</th>
                <th class="Thc" style="border: 1px solid black; background-color: #e8e8e8;">100</th>
            <?php endfor; ?>
        </tr>

        <?php foreach($records as $student) { $i++; ?>
        <tr>
            <td class="Tdc"><?= $student['student_no'] ?></td>
            <td class="Tdc"><?= $student['name'] ?></td>

            <!-- English -->
            <td class="Tdc"><?= ceil(($student['final_totals']['s1'] + $student['final_totals']['s2']) / 2) ?></td>
            <td class="Tdc"><?= ceil(($student['mid_totals']['s1'] + $student['mid_totals']['s2']) / 2) ?></td>
            <td class="Tdc"><?= $student['english_avg'] ?></td>

            <!-- 2nd Language -->
            <?php printSubjectMarks($student, '2nd Language'); ?>

            <!-- Dynamic Subjects + Computer Science -->
            <?php printSubjectMarks($student, 'Computer Science'); ?>
            <?php printSubjectMarks($student, $sub_math); ?>
            <?php printSubjectMarks($student, $sub_phy); ?>
            <?php printSubjectMarks($student, $sub_chem); ?>
            <?php printSubjectMarks($student, $sub_bio); ?>

            <!-- Summary -->
            <td class="Tdc"><?= $student['grand_total'] ?></td>
            <td class="Tdc"><?= isset($student['percentage']) ? $student['percentage'] . '%' : '' ?></td>
            <td class="Tdc"><?= $student['result'] ?></td>
            <td class="Tdc"><?= $student['rank'] ?></td>
            <td class="Tdc"><?= !empty($student['attendence']) ? $student['attendence'] . '%' : '' ?></td>

            <!-- GK -->
            <td class="Tdc"><?= $student['special_final_totals']['sps1'] ?></td>
            <td class="Tdc"><?= $student['special_mid_totals']['sps1'] ?></td>
            <td class="Tdc"><?= $student['special_annual_marks']['sps1'] ?></td>

            <!-- V Ed -->
            <td class="Tdc"><?= $student['special_final_totals']['sps2'] ?></td>
            <td class="Tdc"><?= $student['special_mid_totals']['sps2'] ?></td>
            <td class="Tdc"><?= $student['special_annual_marks']['sps2'] ?></td>
        </tr>
        <?php } ?>
    </tbody>
</table>

<div style="page-break-before:always"></div>

<?php } ?>

</body>


</html>
