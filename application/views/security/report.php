<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        .GridTable {
            border: 2px #000 solid;
            border-collapse: collapse;
            border-radius: 15px;
        }
        .GridTable th.Thc {
            border: 1px #000 solid;
            text-align: center;
            font-family: "Times New Roman", Georgia;
            font-size: 10pt;
            font-weight: bold;
            font-variant: small-caps;
            background: #EFEFEF;
            color: #000;
        }
        .GridTable th.Thl {
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
        .GridTable td {
            border: 1px #000 solid;
            padding-left: 5px;
            text-align: left;
            font-family: "Courier New", Arial;
            font-size: 10pt;
        }
        .GridTable td.Srl {
            border: 1px #000 solid;
            padding-right: 5px;
            text-align: right;
            font-family: Arial, "Courier New";
            font-size: 9pt;
            background-color: #EFEFEF;
        }
        .GridTable td.Tdc {
            border: 1px #000 solid;
            text-align: center;
            font-family: "Courier New", Arial;
            font-size: 10pt;
        }
    </style>
</head>
<body>
    <p style="margin-top: 10px; margin-bottom: 10px; text-align: center; font-size: 42px; font-weight: bold; font-family: cursive;">ST. Joseph's Convent School</p>
    <hr>
    <h1 style="text-align: center;">Active Users</h1>
    <table class="GridTable" style="width:98%; margin-top:20px; margin-left:10px;">
        <tbody>
            <tr>
                <th class="Thc" rowspan="2" style="width:3%;">&nbsp;</th>
                <th class="Thl" rowspan="2">User Name</th>
                <th class="Thl" rowspan="2">Name</th>
                <th class="Thc" colspan="11">M O D U L E S</th>
                <th class="Thc" rowspan="2">System Administrator</th>
            </tr>
            <tr>
            <th class="Thc">Student</th>
            <th class="Thc">Academics</th>
            <th class="Thc">Fees</th>
            <th class="Thc">Hostel</th>
            <th class="Thc">Personnel</th>
            <th class="Thc">Leave</th>
            <th class="Thc">Payroll</th>
            <th class="Thc">Library</th>
            <th class="Thc">Inventory</th>
            <th class="Thc">Mess</th>
            <th class="Thc">Infirmary</th>
            <th class="Thc">Status</th>
            </tr>
            <?php $sl_no = 0 ; foreach($users as $user) { $sl_no ++; ?>
                <tr>
                    <td class="Srl"><?php echo $sl_no; ?></td>
                    <td><?php echo $user["username"] ?></td>
                    <td><?php echo $user["f_name"] . " " . $user["m_name"] . " " . $user["l_name"] ?></td>
                    <td class="Tdc"><?php echo $user["student_module"] ?></td>
                    <td class="Tdc"><?php echo $user["academics_module"] ?></td>
                    <td class="Tdc"><?php echo $user["fees_module"] ?></td>
                    <td class="Tdc"><?php echo $user["hostel_module"] ?></td>
                    <td class="Tdc"><?php echo $user["personnel_module"] ?></td>
                    <td class="Tdc"><?php echo $user["leave_module"] ?></td>
                    <td class="Tdc"><?php echo $user["payroll_module"] ?></td>
                    <td class="Tdc"><?php echo $user["library_module"] ?></td>
                    <td class="Tdc"><?php echo $user["inventory_module"] ?></td>
                    <td class="Tdc"><?php echo $user["mess_module"] ?></td>
                    <td class="Tdc"><?php echo $user["infirmary_module"] ?></td>
                    <td class="Tdc"><?php echo $user["system_administrator"] ?></td>
                    <td class="Tdc"><?php echo $user["status"] ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</body>
</html>

