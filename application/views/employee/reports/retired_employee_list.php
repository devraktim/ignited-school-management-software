<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Retired Employee List</title>

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
    Retired Employee List
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
        <th>Address</th>
        <th>Phone</th>
        <th>Retired Date</th>
    </tr>

    <?php $sl = 0; foreach ($records as $r) { $sl++; ?>
    <tr>
        <td><?php echo $sl; ?></td>

        <td>
            <?php echo $r['f_name'].' '.$r['m_name'].' '.$r['l_name']; ?>
        </td>

        <td><?php echo $r['department']; ?></td>

        <td><?php echo $r['designation']; ?></td>

        <td><?php echo $r['emp_type']; ?></td>

        <td><?php echo $r['job_status']; ?></td>

        <td><?php echo date('d-m-Y', strtotime($r['since'])); ?></td>

        <td style="text-align:left;">
            <?php echo $r['permanent_address']; ?>
        </td>

        <td><?php echo $r['mobile_no']; ?></td>

        <td><?php echo date('d-m-Y', strtotime($r['retired_date'])); ?></td>
    </tr>
    <?php } ?>

</table>

<?php } else { ?>

<div class="BigHeader" style="margin-top:50px;">
    No Retired Employee Found
</div>

<?php } ?>

</body>
</html>