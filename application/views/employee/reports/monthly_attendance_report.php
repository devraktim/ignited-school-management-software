<!DOCTYPE html>
<html>
<head>
    <title>Month Wise Attendance Report</title>
    <style>
        body {
            margin: 0;
            padding: 0;
        }

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
            font-size:9pt;
            font-weight:bold;
            font-variant: small-caps;
            background: #EEE;
        }

        .GridTable td {
            border: 1px #000 solid;
            text-align:center;
            font-family:"Courier New", Arial;
            font-size:9pt;
            padding:4px;
        }

        .page-break {
            page-break-before: always;
        }
    </style>
</head>

<body>

<?php
// Convert holidays array to date => name map
$holidayMap = [];
foreach ($holidays as $holiday) {
    $holidayMap[$holiday['holiday_date']] = $holiday['name'];
}

foreach ($attendanceData as $monthYear => $data) {

    $year  = (int) substr($monthYear, 0, 4);
    $month = (int) substr($monthYear, 5, 2);

    $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);
    $monthName   = date("F Y", strtotime($monthYear));

    // Calculate working days
    $holidayCount = 0;
    for ($d = 1; $d <= $daysInMonth; $d++) {
        $date = sprintf('%04d-%02d-%02d', $year, $month, $d);
        if (isset($holidayMap[$date])) {
            $holidayCount++;
        }
    }

    $workingDays = $daysInMonth - $holidayCount;
?>

<!-- SCHOOL HEADER -->
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

<div class="BigHeader" style="margin:20px 0;">
    Attendance Sheet - <?php echo $monthName; ?>
</div>

<table class="GridTable" style="width: 98%; margin: 0 auto;">
    <thead>
        <tr>
            <th>Sl</th>
            <th>Code</th>
            <th>Name</th>

            <?php for ($day = 1; $day <= $daysInMonth; $day++) { ?>
                <th><?php echo $day; ?></th>
            <?php } ?>

            <th>Total (<?php echo $workingDays; ?>)</th>
        </tr>
    </thead>

    <tbody>
        <?php
        $slNo = 1;
        foreach ($employeeRecords as $record) {

            $totalPresent = 0;
        ?>
        <tr>
            <td><?php echo $slNo++; ?></td>
            <td><?php echo htmlspecialchars($record['emp_code']); ?></td>
            <td><?php echo htmlspecialchars($record['f_name'] . ' ' . $record['l_name']); ?></td>

            <?php
            for ($day = 1; $day <= $daysInMonth; $day++) {

                $attendanceDate = sprintf('%04d-%02d-%02d', $year, $month, $day);
                $attendance = $attendanceData[$monthYear][$attendanceDate][$record['id']] ?? null;

                $cell = '';

                // Holiday
                if (isset($holidayMap[$attendanceDate])) {
                    $cell = 'H';
                }
                // Attendance
                elseif ($attendance) {
                    if ($attendance['attendance'] == 'P') {
                        $cell = 'P';
                        $totalPresent++;
                    } elseif ($attendance['attendance'] == 'A') {
                        $cell = 'A';
                    }
                }

                echo "<td>{$cell}</td>";
            }
            ?>

            <td><?php echo $totalPresent; ?></td>
        </tr>
        <?php } ?>
    </tbody>
</table>

<div class="page-break"></div>

<?php } ?>

</body>
</html>