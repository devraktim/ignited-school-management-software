<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
        
        <style>
            @media print {
                canvas {
                    page-break-inside: avoid; /* Prevent page breaks inside the canvas element */
                }
            }
            canvas, .canvas-container {
                page-break-before: auto;
                page-break-after: auto;
                page-break-inside: auto;
            }
           
            canvas {
                display: block;
                width: 100%;
                height: auto;
            }
            
            /* Styles for the fixed circular button */
            .fixed-button {
                position: fixed; /* Fixes the position relative to the viewport */
                bottom: 20px;    /* Distance from the bottom of the screen */
                right: 20px;     /* Distance from the right of the screen */
                width: 60px;     /* Width of the button */
                height: 60px;    /* Height of the button */
                background-color: #007bff; /* Background color of the button */
                color: #fff;     /* Text color */
                border-radius: 50%; /* Makes the button circular */
                display: flex;   /* Flexbox for centering icon */
                justify-content: center; /* Center icon horizontally */
                align-items: center; /* Center icon vertically */
                text-decoration: none; /* Remove underline from link */
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* Shadow effect */
                font-size: 24px; /* Font size for the icon */
                z-index: 1000; /* Ensure it appears above other elements */
            }
            
            .fixed-button:hover {
                background-color: #0056b3; /* Darker background color on hover */
                color: #e0e0e0; /* Lighter text color on hover */
            }
            
            .fixed-button i {
                margin: 0; /* Remove any default margin from the icon */
            }
            
            
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
                width: 200px;
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
            
            /* Ensure table header cells are in one line */
            th {
                white-space: nowrap; /* Prevent text from wrapping */
            }
            
            td {
                white-space: nowrap; /* Prevent text from wrapping */
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
            
            <div class="BigHeader" style="width:90%; margin: 0 auto; margin-top:20px"><?php echo $heading; ?></div>
            
            <div class="BigHeader" style="width:90%; margin: 0 auto; margin-top:20px; font-size: 17px; color: gray;"><?php echo $subheading; ?></div>
                        
            <table class="GridTable" style="width:94%; margin: 0 auto; margin-top:30px">
                <tbody>
                        <tr>
                            <th class="Thc" style="width:3%">&nbsp;</th>
                            <th class="Thc">Name</th>
                        
                            <?php 
                                foreach($fields as $field) { 
                                    
                                    $field = str_replace('_', ' ', $field); 
                                    $field = ucwords(strtolower($field));
                            ?>
                                <th class="Thc"><?php echo $field; ?></th>
                            <?php } ?>
                            
                            <?php foreach($blank_columns as $blank_column) { ?>
                                <th class="Thc"><?php echo $blank_column; ?></th>
                            <?php } ?>
                        </tr>
                        <?php 
                        $sl_no = 0;
                        foreach ($employees as $employee): 
                            $sl_no++;
                        ?>
                            <tr>
                                <td class="Tdc"><?php echo $sl_no; ?></td>
                                <td class="Tdc"><?php echo $employee['f_name'] . ' ' . $employee['m_name'] . ' ' . $employee['l_name']; ?></td>
                    
                                <?php foreach($fields as $field) { ?>
                                    <td class="Tdc"><?php  echo $employee[$field]; ?></td>
                                <?php } ?>
                                
                                <?php foreach($blank_columns as $blank_column) { ?>
                                    <td class="Tdc"></td>
                                <?php } ?>
                            </tr>
                        <?php endforeach; ?>
                </tbody>
            </table>
            <div style="page-break-before:always">&nbsp;</div>
        <?php } ?>
    </body>
</html>