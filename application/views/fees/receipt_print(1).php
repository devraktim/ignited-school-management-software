<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fees Receipt</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" xintegrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <style>
        /* Custom styles to ensure proper A4 sizing and printing */
        @media print {
            body {
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
                margin: 0;
            }
        }
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8f9fa;
        }
        .receipt-container {
            width: 21cm; /* A4 width */
            height: 29.7cm; /* A4 height */
            background-color: white;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border-radius: 0.5rem;
            padding: 0cm;
        }
        .receipt {
            padding: 1.5rem;
            margin-bottom: 2rem;
            position: relative;
        }
        .parent-copy {
            position: absolute;
            top: 0.5rem;
            right: 0.5rem;
            font-size: 0.75rem;
            color: #6c757d;
            font-weight: bold;
        }
        .header {
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            margin-bottom: 1.5rem;
        }
        .header img {
            height: 2.5rem;
            margin-right: 1rem;
        }
        .header-text h1 {
            font-size: 1.2rem;
            font-weight: bold;
            color: #212529;
        }
        .header-text p {
            font-size: 0.775rem;
            color: #6c757d;
        }
        .info-row .info-item label {
            font-size: 0.875rem;
            font-weight: bold;
            color: #495057;
            margin-bottom: 0.25rem;
        }
        .info-row .info-item .value {
            border-bottom: 1px dotted #adb5bd;
            font-size: 0.875rem;
            padding-bottom: 0.125rem;
            color: #212529;
        }
        .table-container {
            border-radius: 0.5rem;
            overflow: hidden;
            margin-bottom: 1.5rem;
        }
        .fee-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.875rem;
        }
        .fee-table th, .fee-table td {
            border: 1px solid #dee2e6;
            padding: 0.35rem;
            text-align: left;
        }
        .fee-table th {
            background-color: #eaf6fd;
            font-weight: bold;
            color: #1a5c85;
        }
        .fee-table td {
            background-color: white;
            color: #212529;
        }
        .fee-table tfoot td {
            background-color: #d1ecf1;
            font-weight: bold;
            color: #212529;
        }
        .rupees-in-words {
            font-size: 0.875rem;
            margin-bottom: 1.5rem;
            color: #495057;
        }
        .signature-section {
            display: flex;
            justify-content: flex-end;
            margin-top: 2rem;
            text-align: center;
        }
        .signature-box {
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 50%;
        }
        .signature-line {
            width: 80%;
            height: 1px;
            background-color: #adb5bd;
            margin-bottom: 0.5rem;
        }
        .signature-text {
            font-size: 0.75rem;
            color: #6c757d;
        }
        table tbody tr th {
            font-size: 0.775rem;
            color: #495057;
            font-weight: bold;
        }
        table tbody tr td {
            font-size: 0.775rem;
            color: #495057;
        }
    </style>
</head>
<body class="bg-light d-flex align-items-center justify-content-center min-vh-100 p-4">

    <div class="receipt-container container-fluid">
        <div class="row g-0">
            <!-- First Receipt -->
            <div class="col-6 border-end border-dashed">
                <div class="receipt">
                    <span class="parent-copy">PARENT COPY</span>
                    <div class="header">
                        <!-- Placeholder for school logo -->
                        <img src="https://ignitedsoft.in/stfrancis/assets/sfs_new_logo.png" alt="School Logo">
                        <div class="header-text">
                            <h1 class="h5">ST. FRANCIS' SCHOOL</h1>
                            <p class="mb-0">JORETHANG, SOUTH SIKKIM</p>
                        </div>
                    </div>

                    <div class="info-row row mb-4" style="padding-left: 10px;">
                        <table>
                            <tbody>
                                <tr>
                                    <th>Receipt No</th>
                                    <td><?php echo $data['receipt_id']; ?></td>
                                    <th>Receipt Date</th>
                                    <td><?php echo date('d-m-Y', strtotime($data['receipt_date'])); ?></td>
                                </tr>
                                
                                <tr>
                                    <th>Student No</th>
                                    <td><?php echo $student['student_no']; ?></td>
                                </tr>

                                <tr>
                                    <th>Student Name</th>
                                    <td><?php echo $student['f_name'] . ' ' . $student['m_name'] . ' ' . $student['l_name']; ?></td>
                                </tr>

                                <tr>
                                    <th>Class</th>
                                    <td><?php echo $student['student_session_class_name']; ?></td>
                                    <th>Section</th>
                                    <td>A</td>
                                </tr>
                                
                                <tr>
                                    <th>Receipt For</th>
                                    <td>
                                        <?php
                                            $months = json_decode($data['months'], true);
                                            if (!empty($months)) {
                                                $uniqueMonths = array_unique($months);
                                                $monthNames = array_map(function($m) {
                                                    return date('F', mktime(0, 0, 0, $m + 1, 10));
                                                }, $uniqueMonths);
                                                echo implode(', ', $monthNames);
                                            } else {
                                                echo '-';
                                            }
                                        ?>
                                    </td>
                                </tr>
                                
                                <tr>
                                    <th>Payment Mode</th>
                                    <td><?php echo ucwords(str_replace('_', ' ', $data['payment_method'])); ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <?php
                    // Decode the JSON string from the database
                    $summary = json_decode($data['summary'], true);
                    
                    // Extract the total value (last element)
                    // $total = 0;
                    // if (!empty($summary) && is_array($summary)) {
                    //    $summaryKeys = array_keys($summary);
                    //    $lastKey = end($summaryKeys);
                    //    $total = floatval(preg_replace('/[^\d.]/', '', $summary[$lastKey]));
                    
                    
                    //    unset($summary[$lastKey]);
                    //}
                    ?>
                    
                    <div class="table-container shadow-sm">
                        <table class="fee-table">
                            <thead>
                                <tr>
                                    <th class="w-75">Details</th>
                                    <th class="w-25">Amount (₹)</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($summary)): ?>
                                    <?php $total = 0; foreach ($summary as $label => $amount): ?>
                                        <?php
                                            // Clean and format amount
                                            $amountNumeric = floatval(preg_replace('/[^\d.]/', '', $amount));
                                            $total = $total + $amountNumeric; 
                                            $isConcession = stripos($label, 'concession') !== false;
                                            $displayAmount = $isConcession ? number_format($amountNumeric, 2) : number_format($amountNumeric, 2);
                                        ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($label); ?></td>
                                            <td><?php echo $displayAmount; ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="2">No fee data available.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td>Total</td>
                                    <td><?php echo number_format($data['net_amount'], 2); ?></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    <div class="rupees-in-words">
                        <strong>Rupees in words:</strong> <?php echo convertToIndianCurrencyWords($data['net_amount']); ?>
                    </div>

                    <div class="signature-section">
                        <div class="signature-box">
                            <p class="signature-text">ST. FRANCIS' SCHOOL</p>
                            <p class="signature-text">Collected by</p>
                            <p class="signature-text"><strong>(Admin)</strong></p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Second Receipt (Duplicate) -->
            <div class="col-6">
                <div class="receipt">
                    <span class="parent-copy">OFFICE COPY</span>
                    <div class="header">
                        <!-- Placeholder for school logo -->
                        <img src="https://ignitedsoft.in/stfrancis/assets/sfs_new_logo.png" alt="School Logo">
                        <div class="header-text">
                            <h1 class="h5">ST. FRANCIS' SCHOOL</h1>
                            <p class="mb-0">JORETHANG, SOUTH SIKKIM</p>
                        </div>
                    </div>

                    <div class="info-row row mb-4" style="padding-left: 10px;">
                        <table>
                            <tbody>
                                <tr>
                                    <th>Receipt No</th>
                                    <td><?php echo $data['receipt_id']; ?></td>
                                    <th>Receipt Date</th>
                                    <td><?php echo date('d-m-Y', strtotime($data['receipt_date'])); ?></td>
                                </tr>
                                
                                <tr>
                                    <th>Student No</th>
                                    <td><?php echo $student['student_no']; ?></td>
                                </tr>

                                <tr>
                                    <th>Student Name</th>
                                    <td><?php echo $student['f_name'] . ' ' . $student['m_name'] . ' ' . $student['l_name']; ?></td>
                                </tr>

                                <tr>
                                    <th>Class</th>
                                    <td><?php echo $student['student_session_class_name']; ?></td>
                                    <th>Section</th>
                                    <td>A</td>
                                </tr>
                                
                                <tr>
                                    <th>Receipt For</th>
                                    <td>
                                        <?php
                                            $months = json_decode($data['months'], true);
                                            if (!empty($months)) {
                                                $uniqueMonths = array_unique($months);
                                                $monthNames = array_map(function($m) {
                                                    return date('F', mktime(0, 0, 0, $m + 1, 10));
                                                }, $uniqueMonths);
                                                echo implode(', ', $monthNames);
                                            } else {
                                                echo '-';
                                            }
                                        ?>
                                    </td>
                                </tr>
                                
                                <tr>
                                    <th>Payment Mode</th>
                                    <td><?php echo ucwords(str_replace('_', ' ', $data['payment_method'])); ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="table-container shadow-sm">
                        <table class="fee-table">
                            <thead>
                                <tr>
                                    <th class="w-75">Details</th>
                                    <th class="w-25">Amount (₹)</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($summary)): ?>
                                    <?php foreach ($summary as $label => $amount): ?>
                                        <?php
                                            // Clean and format amount
                                            $amountNumeric = floatval(preg_replace('/[^\d.]/', '', $amount));
                                            $isConcession = stripos($label, 'concession') !== false;
                                            $displayAmount = $isConcession ? number_format($amountNumeric, 2) : number_format($amountNumeric, 2);
                                        ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($label); ?></td>
                                            <td><?php echo $displayAmount; ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="2">No fee data available.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td>Total</td>
                                    <td><?php echo number_format($data['net_amount'], 2); ?></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    <div class="rupees-in-words">
                        <strong>Rupees in words:</strong> <?php echo convertToIndianCurrencyWords($data['net_amount']); ?>
                    </div>

                    <div class="signature-section">
                        <div class="signature-box">
                            <p class="signature-text">ST. FRANCIS' SCHOOL</p>
                            <p class="signature-text">Collected by</p>
                            <p class="signature-text"><strong>(Admin)</strong></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" xintegrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>

<?php 
// function convertToIndianCurrencyWords($number) {
//     $words = array(
//         '0' => '', '1' => 'One', '2' => 'Two',
//         '3' => 'Three', '4' => 'Four', '5' => 'Five',
//         '6' => 'Six', '7' => 'Seven', '8' => 'Eight',
//         '9' => 'Nine', '10' => 'Ten', '11' => 'Eleven',
//         '12' => 'Twelve', '13' => 'Thirteen', '14' => 'Fourteen',
//         '15' => 'Fifteen', '16' => 'Sixteen', '17' => 'Seventeen',
//         '18' => 'Eighteen', '19' => 'Nineteen', '20' => 'Twenty',
//         '30' => 'Thirty', '40' => 'Forty', '50' => 'Fifty',
//         '60' => 'Sixty', '70' => 'Seventy', '80' => 'Eighty',
//         '90' => 'Ninety'
//     );

//     $digits = ['', 'Hundred', 'Thousand', 'Lakh', 'Crore'];

//     if (!is_numeric($number)) {
//         return "Invalid number";
//     }

//     $no = floor($number);
//     $point = round($number - $no, 2) * 100;
//     $str = [];

//     $numArr = str_split(str_pad($no, 9, '0', STR_PAD_LEFT), 2);
//     $levels = ['Crore', 'Lakh', 'Thousand', 'Hundred', ''];

//     for ($i = 0; $i < 5; $i++) {
//         $val = intval($numArr[$i]);

//         if ($val) {
//             if ($val < 21) {
//                 $str[] = $words[$val] . ' ' . $levels[$i];
//             } else {
//                 $str[] = $words[$val - $val % 10] . ' ' . $words[$val % 10] . ' ' . $levels[$i];
//             }
//         }
//     }

//     // Remove this block 👇
//     // $lastTwo = intval($numArr[4]);
//     // if ($lastTwo) {
//     //     if ($lastTwo < 21) {
//     //         $str[] = $words[$lastTwo];
//     //     } else {
//     //         $str[] = $words[$lastTwo - $lastTwo % 10] . ' ' . $words[$lastTwo % 10];
//     //     }
//     // }

//     $Rupees = trim(implode(' ', array_filter($str))) . ' Rupees';

//     $Paise = ($point > 0) ? ' and ' . convertToIndianCurrencyWords($point) . ' Paise' : '';

//     return ucwords($Rupees . $Paise . ' Only');
// }

function numberToWord(value) {
    const fraction = Math.round(getFraction(value) * 100);
    let fractionText = "";

    if (fraction > 0) {
        fractionText = " AND " + convertNumber(fraction) + " PAISE";
    }

    return convertNumber(Math.floor(value)) + " RUPEE" + fractionText + " ONLY";
}

function getFraction(num) {
    return num % 1;
}

function convertNumber(number) {
    if (number < 0 || number > 999999999) {
        return "NUMBER OUT OF RANGE!";
    }

    const ones = [
        "", "ONE", "TWO", "THREE", "FOUR", "FIVE", "SIX", "SEVEN", "EIGHT", "NINE",
        "TEN", "ELEVEN", "TWELVE", "THIRTEEN", "FOURTEEN", "FIFTEEN",
        "SIXTEEN", "SEVENTEEN", "EIGHTEEN", "NINETEEN"
    ];

    const tens = [
        "", "", "TWENTY", "THIRTY", "FORTY", "FIFTY",
        "SIXTY", "SEVENTY", "EIGHTY", "NINETY"
    ];

    const crore = Math.floor(number / 10000000);
    number %= 10000000;

    const lakh = Math.floor(number / 100000);
    number %= 100000;

    const thousand = Math.floor(number / 1000);
    number %= 1000;

    const hundred = Math.floor(number / 100);
    number %= 100;

    const ten = Math.floor(number / 10);
    const one = number % 10;

    let result = "";

    if (crore > 0) result += convertNumber(crore) + " CRORE ";
    if (lakh > 0) result += convertNumber(lakh) + " LAKH ";
    if (thousand > 0) result += convertNumber(thousand) + " THOUSAND ";
    if (hundred > 0) result += convertNumber(hundred) + " HUNDRED ";

    if (ten > 0 || one > 0) {
        if (result !== "") result += "AND ";

        if (ten < 2) {
            result += ones[ten * 10 + one];
        } else {
            result += tens[ten];
            if (one > 0) result += "-" + ones[one];
        }
    }

    if (result.trim() === "") {
        return "ZERO";
    }

    return result.trim();
}

?>
