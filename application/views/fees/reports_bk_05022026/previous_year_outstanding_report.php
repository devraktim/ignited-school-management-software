<!DOCTYPE html>
<html>
<head>
    <title><?= $title ?></title>
    <style>
        @page {
            size: A4 portrait;
            margin: 20mm;
        }
        body {
            font-family: 'MS Sans Serif', Arial, sans-serif;
            font-size: 10pt;
            margin: 0;
            padding: 30px;
        }

        .BigHeader {
            text-align: center;
            font-weight: bold;
            font-size: 16pt;
            margin-bottom: 10px;
        }

        .GridTable {
            border: 2px #000 solid;
            border-collapse: collapse;
            width: 100%;
            table-layout: fixed;
            margin-bottom: 10px;
        }

        .GridTable th, .GridTable td {
            border: 1px #000 solid;
            padding: 4px 5px;
            font-size: 10pt;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .GridTable th {
            background: #EEE;
            font-variant: small-caps;
            font-weight: bold;
        }

        .Tdc { text-align: center; }
        .Tdr { text-align: right; }
        .Tdl { text-align: left; }

        /* Fixed column widths */
        .col-sl { width: 4%; }
        .col-student-no { width: 8%; }
        .col-name { width: 20%; }
        .col-class { width: 12%; }
        .col-type { width: 10%; }
        .col-payable { width: 10%; }
        .col-paid { width: 10%; }
        .col-outstanding { width: 10%; }
        .col-phone { width: 12%; }

        /* Page break after 30 rows */
        .page-break { page-break-after: always; }

        /* Repeat table header on every printed page */
        thead { display: table-header-group; }
        tfoot { display: table-footer-group; }
    </style>
</head>
<body>
<?php 
    // Custom function for Indian Number Format with 2 decimal places
    function indian_number_format_with_crore($num) {
        $num = (string)$num; // Convert to string
        $arr = explode('.', $num); // Separate the number and the decimal part
        $num = $arr[0]; // Get the integer part
        $decimal = isset($arr[1]) ? '.' . substr($arr[1], 0, 2) : ''; // Get the decimal part and limit it to 2 decimal places
    
        // Ensure the number has 2 decimal points (even if the original number doesn't have decimals)
        if ($decimal === '') {
            $decimal = '.00';
        } else {
            $decimal = rtrim($decimal, '0'); // Remove trailing zeros if there are any
            if (strlen($decimal) < 3) {
                $decimal = str_pad($decimal, 3, '0'); // Ensure 2 decimal places
            }
        }
    
        $len = strlen($num);
        $result = '';
        $i = 0;
    
        // Separate the last three digits
        if ($len > 3) {
            $lastthree = substr($num, $len - 3, 3);
            $len -= 3;
            $result = ',' . $lastthree . $result;
        }
    
        // Explode the remaining digits in 2's format
        while ($len > 0) {
            $temp_len = ($len > 2) ? 2 : $len;
            $restunits = substr($num, $len - $temp_len, $temp_len);
            $len -= $temp_len;
            $result = $restunits . $result;
            if ($len > 0) {
                $result = ',' . $result;
            }
        }
    
        // Return the formatted number with the decimal part
        return $result . $decimal;
    }
?>
<?php
$school_name = "St. Francis School";
$branch = "Jorethang";
$rows_per_page = 30;

// Set default values for GET parameters if they are not set, to prevent errors in date() calls
$_GET['from_date'] = $_GET['from_date'] ?? date('Y-m-d');
$_GET['to_date'] = $_GET['to_date'] ?? date('Y-m-d');
?>

<?php function render_page_header($school_name, $branch, $title, $from_date, $to_date) { ?>
<table style="width:100%; border-collapse:collapse; margin-bottom:10px; border-bottom:2px solid #000;">
    <tbody>
        <tr>
            <td rowspan="2" style="vertical-align:top;">
                <img src="<?= base_url('assets/media/logos/logol.png') ?>" style="height:70px;width:70px;">
            </td>
            <td style="text-align:center; vertical-align:top;">
                <div style="font-size:28pt; font-weight:bold;"><?= $school_name ?></div>
            </td>
            <td rowspan="2" style="text-align:right; vertical-align:top;">
                <img src="<?= base_url('assets/media/logos/logol.png') ?>" style="height:70px;width:70px;">
            </td>
        </tr>
        <tr>
            <td style="text-align:center; font-size:10pt; font-style:italic;"><?= $branch ?></td>
        </tr>
    </tbody>
</table>

<div class="BigHeader"><?= $title ?></div>
<br>
<?php } ?>

<?php
// Initialize counters
$sl = 0;
$row_count = 0;
$page_total = ['outstanding'=>0];
$grand_total = ['outstanding'=>0];
$total_records = count($records ?? []); // Ensure $records is treated as an array

if ($total_records > 0):
    // Loop through records and paginate every 30 rows
    foreach ($records as $index => $row) {
        $is_last_row = ($index == $total_records - 1);

        if ($row_count % $rows_per_page == 0) {
            if ($row_count > 0) {
                // End previous page table with its Page Total
                ?>
                <tr style="font-weight:bold; border-top:2px solid #000;">
                    <td colspan="6" class="Tdr">Page Total :</td>
                    <td class="Tdr"><?= indian_number_format_with_crore($page_total['outstanding']); ?></td>
                </tr>
                </tbody>
                </table>
                <div class="page-break"></div>
                <?php
                $page_total = ['outstanding'=>0];
            }

            // Render page header
            render_page_header($school_name, $branch, 'Previous Year Outstanding Report', $_GET['from_date'], $_GET['to_date']);

            // Render table header
            ?>
            <table class="GridTable">
                <thead>
                    <tr>
                        <th class="col-sl">SL</th>
                        <th class="col-student-no">Std No</th>
                        <th class="col-name">Name</th>
                        <th class="col-class">Class / Section</th>
                        <th class="col-type">Std Type</th>
                        <th class="col-phone">Phone</th>
                        <th class="col-outstanding">Outstanding</th>
                    </tr>
                </thead>
                <tbody>
            <?php
            }

        $sl++;
        $row_count++;
        $page_total['outstanding'] += $row['outstanding'];
        $grand_total['outstanding'] += $row['outstanding'];
        ?>
        <tr>
            <td class="Tdc"><?= $sl ?></td>
            <td class="Tdc"><?= htmlspecialchars($row['student_no']) ?></td>
            <td class="Tdl"><?= htmlspecialchars($row['student_name']) ?></td>
            <td class="Tdc"><?= htmlspecialchars($row['class_name'].' / '.$row['section_name']) ?></td>
            <td class="Tdc"><?= htmlspecialchars($row['student_type']) ?></td>
            <td class="Tdc"><?= htmlspecialchars($row['phone']) ?></td>
            <td class="Tdr"><?= indian_number_format_with_crore($row['outstanding']) ?></td>
        </tr>
    <?php } ?>

    <tr style="font-weight:bold; border-top:2px solid #000;">
            <td colspan="6" class="Tdr">Page Total :</td>
            <td class="Tdr"><?= indian_number_format_with_crore($page_total['outstanding']) ?></td>
        </tr>

        <tr style="font-weight:bold; border-top:3px double #000;">
            <td colspan="6" class="Tdr">Grand Total :</td>
            <td class="Tdr"><?= indian_number_format_with_crore($grand_total['outstanding']) ?></td>
        </tr>
    </tbody>
    </table>

<?php else: ?>
    <div style="text-align:center; font-size:20px; padding:50px; background:#f7f7f7; border:1px solid #ccc; margin:50px auto; width:80%; color:#d9534f; font-weight:bold;">
        No Data Found
    </div>
<?php endif; ?>

</body>

</html>
