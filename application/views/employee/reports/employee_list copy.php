<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        .BigHeader {
            text-align:center;
            font-family: 'MS Sans Serif', Serif;
            font-weight:bold;
            font-size:16pt;
        }

        .SmallHeader {
            width:98%;
            text-align:center;
            font-family:Arial;
            font-size:12pt;    
            margin-left:10px;
            border-bottom: 1px #000 double;
        }

        .GridTable {
            border: 2px #000 solid;
            border-collapse: collapse;   
            border-radius: 15px;
        }

        .GridTable th {
            border: 1px #000 solid;
            text-align:center;
            font-family:"Times New Roman", Georgia;
            font-size:10pt;
            font-weight:bold;
            font-variant: small-caps;
            background: #EEE;
            color:#000;
        }

        .GridTable td {
            border: 1px #000 solid;
            text-align:center;
            font-family:"Courier New", Arial;
            font-size:10pt;    
            padding:5px;
        }
    </style>
</head>

<body>

<?php 
    $sl_no = 0;
    $i = 0;
    $total = count($records);

    while ($i < $total) {

        // Take 25 records per page WITHOUT overwriting original array
        $chunk = array_slice($records, $i, 25);
        $i += 25;
?>

    <table style="width: 98%; border-collapse: collapse; margin-left: 10px; border-bottom: 2px solid #000;">
        <tr>
            <td style="vertical-align:top" rowspan="2">
                <img src="<?php echo base_url()?>assets/media/logos/logol.png" style="height:70px; width:70px;">
            </td>
            <td style="text-align:center; vertical-align:top">
                <div style="font-family:Arial; font-size:30pt">
                    St. Francis School
                </div>
            </td>
            <td style="vertical-align:top; text-align:end;" rowspan="2">
                <img src="<?php echo base_url()?>assets/media/logos/logol.png" style="height:70px; width:70px;">
            </td>
        </tr>
        <tr>
            <td style="text-align:center; font-size:10pt; font-family:Arial; font-style:italic;">
                Jorethang
            </td>
        </tr>
    </table>

    <div class="BigHeader" style="width:90%; margin:20px auto;">
        Employee List
    </div>

    <table class="GridTable" style="width:94%; margin: 0 auto; margin-top:30px">
        <tr>
            <th style="width:3%">Sl</th>
            <th>Code</th>
            <th>Name</th>
            <th>DOB</th>
            <th>Date Of Joining</th>
            <th>Department</th>
            <th>Designation</th>
            <th>Employee Type</th>
            <th>Job Status</th>
            <th>Mobile No</th>
        </tr>

        <?php foreach($chunk as $record) { $sl_no++; ?>
        <tr>
            <td><?php echo $sl_no; ?></td>
            <td><?php echo $record['emp_code']; ?></td>
            <td>
                <?php echo $record['f_name'] . " " . $record['m_name'] . " " . $record['l_name']; ?>
            </td>
            <td><?php echo date('d-m-Y', strtotime($record['dob'])); ?></td>
            <td><?php echo date('d-m-Y', strtotime($record['since'])); ?></td>
            <td><?php echo $departments[$record['department_id']]['name']; ?></td>
            <td><?php echo $designations[$record['designation_id'] - 1]['name']; ?></td>
            <td><?php echo $employee_types[$record['emp_type_id'] - 1]['name']; ?></td>
            <td><?php echo $job_statuses[$record['job_status_id'] - 1]['name']; ?></td>
            <td><?php echo $record['mobile_no']; ?></td>
        </tr>
        <?php } ?>

    </table>

    <div style="page-break-before:always;"></div>

<?php } ?>

</body>
</html>