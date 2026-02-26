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

        .GridTable {
            border: 2px #000 solid;
            border-collapse: collapse;   
            border-radius: 15px;
            width:94%;
            margin:0 auto;
            margin-top:30px;
        }

        .GridTable th.thl,
        .GridTable th.thr,
        .GridTable th.thc {
            border: 1px #000 solid;
            padding:5px;
            font-family:"Times New Roman", Georgia;
            font-size:10pt;
            font-weight:bold;
            font-variant: small-caps;
            background: #EEE;
            color:#000;
        }

        .GridTable th.thl { text-align:left; }
        .GridTable th.thr { text-align:right; }
        .GridTable th.thc { text-align:center; }

        .GridTable td {
            border: 1px #000 solid;
            padding:5px;
            font-family:"Courier New", Arial;
            font-size:10pt;    
            text-align:center;
        }
    </style>
</head>

<body>

<?php 
    $sl_no = 0;
    $total = count($records);
    $i = 0;

    while ($i < $total) {

        $chunk = array_slice($records, $i, 25);
        $i += 25;
?>

    <table style="width: 98%; border-collapse: collapse; margin-left: 10px; border-bottom: 2px solid #000;">
        <tr>
            <td style="vertical-align:top" rowspan="2">
                <img src="<?php echo base_url()?>assets/media/logos/logol.png" style="height:70px; width:70px">
            </td>
            <td style="text-align:center; vertical-align:top">
                <div style="font-family:Arial; font-size:30pt">
                    St. Francis School
                </div>
            </td>
            <td style="vertical-align:top; text-align:end;" rowspan="2">
                <img src="<?php echo base_url()?>assets/media/logos/logol.png" style="height:70px; width:70px">
            </td>
        </tr>
        <tr>
            <td style="font-size:10pt; font-family:Arial; text-align:center; font-style: italic">
                Jorethang
            </td>
        </tr>
    </table>

    <div class="BigHeader" style="width:90%; margin: 20px auto;">
        Employee Personal Details
    </div>

    <table class="GridTable">
        <tr>
            <th class="thc" style="width:3%">SL</th>
            <th class="thc">CODE</th>
            <th class="thl">NAME</th>
            <th class="thc">CATEGORY</th>
            <th class="thc">RELIGION</th>
            <th class="thc">NATIONALITY</th>
            <th class="thc">QUALIFICATION</th>
            <th class="thc">PAN No</th>
            <th class="thc">VOTER ID</th>
            <th class="thc">AADHAAR NO</th>
            <th class="thc">MARITAL STATUS</th>
            <th class="thc">SPOUSE</th>
            <th class="thc">FATHER</th>
            <th class="thc">MOTHER</th>
        </tr>

        <?php foreach ($chunk as $record) { $sl_no++; ?>
        <tr>
            <td><?php echo $sl_no; ?></td>
            <td><?php echo $record['emp_code']; ?></td>
            <td><?php echo $record['f_name'] . " " . $record['m_name'] . " " . $record['l_name']; ?></td>
            <td><?php echo isset($categories[$record['category_id']]) ? $categories[$record['category_id'] - 1]['name'] : ''; ?></td>
            <td><?php echo isset($religions[$record['religion_id']]) ? $religions[$record['religion_id'] - 1]['name'] : ''; ?></td>
            <td><?php echo isset($nationalities[$record['nationality_id']]) ? $nationalities[$record['nationality_id'] - 1]['name'] : ''; ?></td>
            <td><?php echo isset($qualifications[$record['qualification_id']]) ? $qualifications[$record['qualification_id'] - 1]['name'] : ''; ?></td>
            <td><?php echo $record['pan_no']; ?></td>
            <td><?php echo $record['voter_id']; ?></td>
            <td><?php echo $record['aadhar_no']; ?></td>
            <td><?php echo $record['marital_status']; ?></td>
            <td><?php echo $record['spouse']; ?></td>
            <td><?php echo $record['father']; ?></td>
            <td><?php echo $record['mother']; ?></td>
        </tr>
        <?php } ?>

    </table>

    <div style="page-break-before:always;"></div>

<?php } ?>

</body>
</html>