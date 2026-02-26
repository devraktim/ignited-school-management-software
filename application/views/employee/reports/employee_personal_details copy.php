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
            $sl_no = 0;
            $i = 0; 
            while($i <= count($records)) {
                $records = array_slice($records, $i, 25);                   
                $i = $i + 25;
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
            <div class="BigHeader" style="width:90%; margin: 0 auto; margin-top:20px">Employee Personal Details</div>

            <table class="GridTable" style="width:94%; margin: 0 auto; margin-top:30px">
                <tbody>
                    <tr>
                        <th class="Thc" style="width:3%">&nbsp;</th>
                        <th class="Thc">CODE</th>
                        <th class="Thl">NAME</th>
                        <th class="Thc">CATEGORY</th>
                        <th class="Thc">RELIGION</th>
                        <th class="Thc">NATIONALITY</th>
                        <th class="Thc">QUALIFICATION</th>
                        <th class="Thc">PAN No</th>
                        <th class="Thc">VOTER ID</th>
                        <th class="Thc">ADHAAR NO</th>
                        <th class="Thc">MARITAL STATUS</th>
                        <th class="Thc">SPOUSE</th>
                        <th class="Thc">FATHER</th>
                        <th class="Thc">MOTHER</th>
                    </tr>
                    <?php $sl_no = 0; foreach ($records as $record) { $sl_no++; ?>
                        <tr>
                            <td class="Tdc"><?php echo $sl_no; ?></td>
                            <td class="Tdc"><?php echo $record['emp_code']; ?></td>
                            <td class="Tdc"><?php echo $record['f_name'] . " " . $record['m_name'] . " " . $record['l_name']; ?></td>
                            <td class="Tdc"><?php echo isset($categories[$record['category_id']]) ? $categories[$record['category_id']]['name'] : ''; ?></td>
                            <td class="Tdc"><?php echo isset($religions[$record['religion_id']]) ? $religions[$record['religion_id']]['name'] : ''; ?></td>
                            <td class="Tdc"><?php echo isset($nationalities[$record['nationality_id']]) ? $nationalities[$record['nationality_id']]['name'] : ''; ?></td>
                            <td class="Tdc"><?php echo isset($qualifications[$record['qualification_id']]) ? $qualifications[$record['qualification_id']]['name'] : ''; ?></td>
                            <td class="Tdc"><?php echo $record['pan_no']; ?></td>
                            <td class="Tdc"><?php echo $record['voter_id']; ?></td>
                            <td class="Tdc"><?php echo $record['aadhar_no']; ?></td>
                            <td class="Tdc"><?php echo $record['marital_status']; ?></td>
                            <td class="Tdc"><?php echo $record['spouse']; ?></td>
                            <td class="Tdc"><?php echo $record['father']; ?></td>
                            <td class="Tdc"><?php echo $record['mother']; ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
            <div style="page-break-before:always">&nbsp;</div>
        <?php } ?>
    </body>
</html>