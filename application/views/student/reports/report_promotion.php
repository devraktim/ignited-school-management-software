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

            .SmallHeader
            {
                width:98%;
                text-align:center;
                font-family:Arial;
                font-size:12pt;    
                margin-left:10px;
                border-bottom: 1px #000 double;
            }

            .DispTable
            {
                border-collapse: collapse;
            }

            .DispTable TD.FldR
            {
                font-family:Georgia, "Times New Roman";
                font-size:9pt;
                font-weight: bold;
                text-align:right;
                padding-right:5px;
                padding-top:3px;
            }

            .DispTable TD.FldL
            {
                font-family:Georgia, "Times New Roman";
                font-size:9pt;
                font-weight: bold;
                text-align:left;
                padding-left:5px;
                padding-top:3px;
            }

            .DispTable TD.Dta
            {
                font-family:"Courier New", "Arial";
                font-size:10pt;
                text-align:left;
                padding-left:10px;
                padding-top:3px;
                border-bottom: 1px #000 dotted;
            }

            .DispTable TD.Hdr
            {
                font-family:"Georgia", "Times New Roman";
                font-size:12pt;
                font-variant: small-caps;
                text-align:left;
                padding-left:10px;
                padding-top:3px;     
                padding-bottom:5px;
            }

            .GridTable
            {
                border: 2px #000 solid;
                border-collapse: collapse;   
                border-radius: 15px;
            }

            .GridTable th.thl
            {
                border: 1px #000 solid;
                padding-left:5px;
                text-align:left;
                font-family:"Times New Roman", Georgia;
                font-size:10pt;
                font-weight:bold;
                font-variant: small-caps;
                background: #EEE;
                color:#000;
            }

            .GridTable th.thr
            {
                border: 1px #000 solid;
                padding-right:5px;
                text-align:right;
                font-family:"Times New Roman", Georgia;
                font-size:10pt;
                font-weight:bold;
                font-variant: small-caps;
                background: #EEE;
                color:#000;
            }

            .GridTable th.thc
            {
                border: 1px #000 solid;
                text-align:center;
                font-family:"Times New Roman", Georgia;
                font-size:10pt;
                font-weight:bold;
                font-variant: small-caps;
                background: #EEE;
                color:#000;
            }

            .GridTable td
            {
                border: 1px #000 solid;
                padding-left:5px;
                text-align:left;
                font-family:"Courier New", Arial;
                font-size:10pt;    
            }

            .GridTable td.Tdr
            {
                border: 1px #000 solid;
                padding-right:5px;
                text-align:right;
                font-family:  Arial, "Courier New";
                font-size:10pt;    
            }

            .GridTable td.Tdc
            {
                border: 1px #000 solid;
                text-align:center;
                font-family:"Courier New", Arial;
                font-size:10pt;    
            }

            .GridTable td.Fld
            {
                border: 1px #000 solid;
                text-align:left;
                font-family:Georgia, 'Times New Roman';
                font-size:10pt;
                font-weight:bold;    
            }

            .GridTable td.Srl
            {
                border: 1px #000 solid;
                padding-right:5px;
                text-align:right;
                font-family:  Arial, "Courier New";
                font-size:9pt;    
                background-color: #EFEFEF;
            }

            DIV.Info
            {
                margin-left: 30px;
                font-family: "Times New Roman", Arial;
                font-size: 16pt;
                font-weight: bold;
                font-variant: small-caps;
            }
        </style>
    </head>
    <body data-new-gr-c-s-check-loaded="14.1098.0" data-gr-ext-installed="">

        <?php
        $sl_no = 1; // Start serial number from 1
        $records_per_page = 25; // Number of records per page
        
        $student_type_map = [
            1 => "Day Scholar",
            2 => "Day Boarders",
            3 => "Boarder"
        ];
        
        $class_map = [
                1 => "NURSERY", 2 => "LKG", 3 => "UKG", 4 => "I", 5 => "II", 
                6 => "III", 7 => "IV", 8 => "V", 9 => "VI", 10 => "VII", 
                11 => "VIII", 12 => "IX", 13 => "X", 14=> "XI", 15=> "XII"
            ];
            
            $section_map = [
                1 => "A", 2 => "SC", 3 => "HU"
            ];
        
        $original_records = $records; // Save the original records array
        $total_records = count($original_records);
        $total_pages = ceil($total_records / $records_per_page); // Calculate total number of pages
        
        for ($page = 0; $page < $total_pages; $page++) {
            $start = $page * $records_per_page;
            $current_records = array_slice($original_records, $start, $records_per_page);
        ?>
            <table style="width: 98%; border-collapse: collapse; margin-left: 10px; border-bottom: 2px solid rgb(0, 0, 0); --darkreader-inline-border-bottom:#7e7669;" data-darkreader-inline-border-bottom="">
                <tbody>
                    <tr>
                        <td style="vertical-align:top" rowspan="2">
                            <img src="<?php echo base_url()?>assets/media/logos/logol.png" style="Height:70px; Width:70px">
                        </td>
                        <td style="text-align:center; vertical-align:top">
                            <div style="font-family:Arial; font-size:30pt">
                                St. Francis School
                            </div>
                        </td>
                        <td style="vertical-align:top; text-align: end;" rowspan="2">
                            <img src="<?php echo base_url()?>assets/media/logos/logol.png" style="Height:70px; Width:70px">
                        </td>
                    </tr>
                    <tr>
                        <td style="text-align:center">
                            <table style="width:99%">
                                <tbody>
                                    <tr>
                                        <td style="font-size:10pt; font-family:Arial; text-align:center; font-style: italic">
                                            Jorethang
                                        </td>                            
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="BigHeader" style="width:90%; margin: 0 auto; margin-top:20px">Promotion Report <?php echo date('Y', strtotime($this->session->academy_session['current_session']['start'])) ?></div>
        
            <table class="GridTable" style="width:94%; margin: 0 auto; margin-top:30px">
                <thead>
                    <tr>
                        <th class="Thc">Sl. No.</th>
                        <th class="Thc">Student No</th>
                        <th class="Thc">Name</th>
                        <th class="Thc">Student Type</th>
                        <th class="Thc" colspan="2">Promoted From</th>
                        <th class="Thc" colspan="2">Promoted To</th>
                        <th class="Thc" colspan="2">Continue In</th>
                        <th class="Thc">Passout</th>
                    </tr>
                    <tr>
                        <th class="Thc"></th>
                        <th class="Thc"></th>
                        <th class="Thc"></th>
                        <th class="Thc"></th>
                        <th class="Thc">Class</th>
                        <th class="Thc">Section</th>
                        <th class="Thc">Class</th>
                        <th class="Thc">Section</th>
                        <th class="Thc">Class</th>
                        <th class="Thc">Section</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                foreach ($current_records as $record):
                ?>
                    <tr>
                        <td class="Tdc"><?php echo htmlspecialchars($sl_no++); ?></td>
                        <td class="Tdc"><?php echo htmlspecialchars($record['student_no']); ?></td>
                        <td class="Tdc"><?php echo htmlspecialchars($record['student_name']); ?></td>
                        <td class="Tdc"><?php echo htmlspecialchars($student_type_map[$record['student_type_id']]); ?></td>
                        <td class="Tdc"><?php echo htmlspecialchars($class_map[$record['promoted_form']['class']]); ?></td>
                        <td class="Tdc"><?php echo htmlspecialchars($section_map[$record['promoted_form']['section']]); ?></td>
                        <td class="Tdc"><?php echo htmlspecialchars($class_map[$record['promoted_to']['class']]); ?></td>
                        <td class="Tdc"><?php echo htmlspecialchars($section_map[$record['promoted_to']['section']]); ?></td>
                        <td class="Tdc"><?php echo htmlspecialchars($class_map[$record['continute_to']['class']]); ?></td>
                        <td class="Tdc"><?php echo htmlspecialchars($section_map[$record['continute_to']['section']]); ?></td>
                        
                        <td class="Tdc"><?php echo $record['passout'] == 1 ? 'Passout' : ''; ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        
            <div style="page-break-before:always">&nbsp;</div>
        <?php
        }
    ?>

    </body>
</html>