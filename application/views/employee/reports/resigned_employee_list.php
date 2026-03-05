<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Resigned Employee List</title>

    <style>
        .BigHeader {
            text-align:center;
            font-family: 'MS Sans Serif', Serif;
            font-weight:bold;
            font-size:16pt;
        }

        .GridTable {
            border: 2px #000 solid;
            border-collapse: collapse;   
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
            padding:6px;
        }

        .GridTable td {
            border: 1px #000 solid;
            text-align:center;
            font-family:"Courier New", Arial;
            font-size:10pt;    
            padding:6px;
        }
    </style>
</head>

<body>

<!-- School Header -->
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
    Resigned Employee List
</div>

<?php if (!empty($records)) { ?>

<table class="GridTable" style="width:98%; margin: 0 auto; margin-top:30px">
    <tr>
        <th style="width:3%">Sl</th>
        <th>Name</th>
        <th>Department</th>
        <th>Designation</th>
        <th>Employee Type</th>
        <th>Job Status</th>
        <th>Date of Joining</th>
        <th>Phone</th>
        <th>Resigned Date</th>
        <th>Reason</th>
    </tr>

    <?php $sl = 0; foreach ($records as $record) { $sl++; ?>
    <tr>
        <td><?php echo $sl; ?></td>
        <td style="text-align:left;">
            <?php echo $record['f_name'] . " " . $record['m_name'] . " " . $record['l_name']; ?>
        </td>
        <td><?php echo $record['department']; ?></td>
        <td><?php echo $record['designation']; ?></td>
        <td><?php echo $record['emp_type']; ?></td>
        <td><?php echo $record['job_status']; ?></td>
        <td><?php echo date('d-m-Y', strtotime($record['since'])); ?></td>
        <td><?php echo $record['mobile_no']; ?></td>
        <td><?php echo date('d-m-Y', strtotime($record['resigned_date'])); ?></td>
        <td style="text-align:left;"><?php echo $record['resigned_reason']; ?></td>
    </tr>
    <?php } ?>

</table>

<?php } else { ?>

<div class="BigHeader" style="margin-top:50px;">
    No Resigned Employee Found
</div>

<?php } ?>

</body>
</html>