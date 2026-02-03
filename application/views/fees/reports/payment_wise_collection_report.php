<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Payment Wise Collection Report</title>
    <style>
    .BigHeader {
        text-align: center;
        font-family: 'Arial', sans-serif;
        font-weight: bold;
        font-size: 16pt;
    }
    
    /* ======= Table ======= */
    .GridTable {
        border: 2px #000 solid;
        border-collapse: collapse;
        width: 94%;
        margin: 0 auto;
        margin-top: 30px;
    }
    
    /* ======= Table Header ======= */
    .GridTable th.thl,
    .GridTable th.thc,
    .GridTable th.thr {
        border: 1px #000 solid;
        padding: 5px;
        font-family: "Times New Roman", Georgia;
        font-size: 10pt;
        font-weight: bold;
        font-variant: small-caps;
        background: #EEE;
        color: #000;
        white-space: nowrap; /* ✅ Keep header text in one line */
    }
    
    .GridTable th.thc { text-align: center; }
    .GridTable th.thl { text-align: left; }
    .GridTable th.thr { text-align: right; }
    
    /* ======= Table Data ======= */
    .GridTable td {
        border: 1px #000 solid;
        padding: 4px 5px;
        font-family: "Courier New", Arial;
        font-size: 10pt;
        white-space: nowrap; /* ✅ Keep all cell text in one line */
    }
    
    .GridTable td.Tdc { text-align: center; }
    .GridTable td.Tdr { text-align: right; }
    .GridTable td.Tdl { text-align: left; }
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
$sl = 1;
$selected_modes = isset($_GET['payment_mode']) && !empty($_GET['payment_mode'])
    ? (array)$_GET['payment_mode']
    : [];

// Define all available payment columns
$payment_columns = [
    'cash'          => 'Cash',
    'debit_card'    => 'D/Card',
    'credit_card'   => 'C/Card',
    'qr_code'       => 'QR Code',
    'cheque'        => 'Chq/P Ord',
    'neft'          => 'NEFT/RTGS',
    'bank_deposit'  => 'Bank Deposit'
];

// If specific payment modes are selected, show only those
$visible_columns = empty($selected_modes)
    ? $payment_columns
    : array_intersect_key($payment_columns, array_flip($selected_modes));

// ===== Initialize GRAND TOTALS =====
$grand_totals = array_fill_keys(array_keys($visible_columns), 0);
$grand_net_total = 0;
$total_rows_processed = 0; // Tracks if any data was processed

// ===== Column Width Allocation =====
// 7 static columns + dynamic payment columns + 1 Net column = total columns
$total_columns = 8 + count($visible_columns); // 7 static + dynamic + Net
$widths = [
    'sl' => '3%',
    'std_no' => '7%',
    'name' => '18%',
    'class_sec' => '8%',
    'type' => '8%',
    'rno' => '7%',
    'rdate' => '8%',
];
$fixed_width_sum = 59; // Sum of fixed widths: 3+7+18+8+8+7+8 = 59%
$net_column_width = 8;
$dynamic_width = round((100 - $fixed_width_sum - $net_column_width) / (count($visible_columns) ?: 1), 2);

$total_chunks = count($chunks ?? []); // Assuming $chunks is defined and an array
$current_chunk_index = 0;
?>

<?php foreach ($chunks as $chunk):
    $current_chunk_index++;
    $is_last_chunk = ($current_chunk_index === $total_chunks);
?>
<table style="width:98%; border-collapse:collapse; margin:10px auto; border-bottom:2px solid #000;">
    <tbody>
        <tr>
            <td rowspan="2" style="vertical-align:top;">
                <img src="<?= base_url('assets/media/logos/logol.png') ?>" style="height:70px;width:70px;">
            </td>
            <td style="text-align:center; vertical-align:top;">
                <div style="font-family:Arial; font-size:28pt;"><?= $school_name ?></div>
            </td>
            <td rowspan="2" style="text-align:right; vertical-align:top;">
                <img src="<?= base_url('assets/media/logos/logol.png') ?>" style="height:70px;width:70px;">
            </td>
        </tr>
        <tr>
            <td style="text-align:center; font-family:Arial; font-size:10pt; font-style:italic;"><?= $branch ?></td>
        </tr>
    </tbody>
</table>


<div class="BigHeader">Payment Wise Collection Report <br> From: <?= date('d-m-y', strtotime($filters['from_date'] ?? '')) ?> To: <?= date('d-m-y', strtotime($filters['to_date'] ?? '')) ?></div>

<br>

<table class="GridTable" style="width:98%; margin:auto;">
    <thead>
        <tr>
            <th class="thc" style="width:<?= $widths['sl']; ?>">Sl</th>
            <th class="thc" style="width:<?= $widths['std_no']; ?>">Std No</th>
            <th class="thl" style="width:<?= $widths['name']; ?>">Student Name</th>
            <th class="thc" style="width:<?= $widths['class_sec']; ?>">Class/Sec</th>
            <th class="thc" style="width:<?= $widths['type']; ?>">Std/Type</th>
            <th class="thc" style="width:<?= $widths['rno']; ?>">R. No.</th>
            <th class="thc" style="width:<?= $widths['rdate']; ?>">R. Date</th>
            <?php foreach ($visible_columns as $label): ?>
                <th class="thc" style="width:<?= $dynamic_width; ?>%;"><?= htmlspecialchars($label) ?></th>
            <?php endforeach; ?>
            <th class="thr" style="width:<?= $net_column_width; ?>%;">Net</th>
        </tr>
    </thead>

    <tbody>
        <?php if (!empty($chunk)): ?>
            <?php
            // Page-wise totals
            $page_totals = array_fill_keys(array_keys($visible_columns), 0);
            $page_net_total = 0;
            ?>

            <?php foreach ($chunk as $row): ?>
                <?php $total_rows_processed++; // Increment overall counter ?>
                <tr>
                    <td class="Tdc"><?= $sl++; ?></td>
                    <td class="Tdc"><?= htmlspecialchars($row['student_no']); ?></td>
                    <td class="Tdl"><?= htmlspecialchars($row['student_name']); ?></td>
                    <td class="Tdc"><?= htmlspecialchars($row['class_name'].'/'.$row['section_name']); ?></td>
                    <td class="Tdc"><?= htmlspecialchars($row['student_type']); ?></td>
                    <td class="Tdc"><?= htmlspecialchars($row['receipt_id']); ?></td>
                    <td class="Tdc"><?= date('d-m-Y', strtotime($row['receipt_date'])); ?></td>

                    <?php foreach ($visible_columns as $key => $label):
                        $amount = isset($row[$key]) ? (float)$row[$key] : 0;
                        $page_totals[$key]  += $amount;
                        $grand_totals[$key] += $amount;
                    ?>
                        <td class="Tdr"><?= indian_number_format_with_crore($amount); ?></td>
                    <?php endforeach; ?>

                    <?php
                        $net_amt = (float)$row['net_amount'];
                        $page_net_total  += $net_amt;
                        $grand_net_total += $net_amt;
                    ?>
                    <td class="Tdr" style="font-weight:bold;"><?= indian_number_format_with_crore($net_amt); ?></td>
                </tr>
            <?php endforeach; ?>

        </tbody>
        <tfoot>
            <tr style="font-weight:bold; background:#f2f2f2;">
                <td class="Tdc" colspan="7" style="text-align:right;">Page Total :</td>
                <?php foreach ($visible_columns as $key => $label): ?>
                    <td class="Tdr"><?= indian_number_format_with_crore($page_totals[$key]); ?></td>
                <?php endforeach; ?>
                <td class="Tdr"><?= indian_number_format_with_crore($page_net_total); ?></td>
            </tr>

            <?php if ($is_last_chunk): ?>
                <tr style="font-weight:bold; background:#e2e2e2;">
                    <td class="Tdc" colspan="7" style="text-align:right;">Grand Total :</td>
                    <?php foreach ($visible_columns as $key => $label): ?>
                        <td class="Tdr"><?= indian_number_format_with_crore($grand_totals[$key]); ?></td>
                    <?php endforeach; ?>
                    <td class="Tdr"><?= indian_number_format_with_crore($grand_net_total); ?></td>
                </tr>
            <?php endif; ?>
        </tfoot>

        <?php else: ?>
            <tr>
                <td colspan="<?= $total_columns ?>" class="Tdc" style="color:red;">No Records Found in this chunk</td>
            </tr>
        </tbody>
        </table>

        <?php endif; ?>
    </table>

    <div style="page-break-before:always;">&nbsp;</div>
<?php endforeach; ?>

<?php if ($total_rows_processed === 0): ?>
    <div style="text-align:center; font-size:20px; padding:50px; background:#f7f7f7; border:1px solid #ccc; margin:50px auto; width:80%; color:#d9534f; font-weight:bold;">
        No Data Found
    </div>
<?php endif; ?>

</body>
</html>
