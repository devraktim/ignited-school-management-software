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
    
        // Determine the number of dynamic columns based on the keys of the first record
        $firstRecord = $records[0];
        $keys = array_keys($firstRecord);
        $cols = count($keys) - 2; // Excludes 'class_name' and 'total_students'
        $rows = count($records);
        
        $m = 0;
        
        if($rows == 1 && $cols == 1) {
            $m = 150;
        } 
        elseif($rows == 1 && $cols > 1) {
            $m = 50;
        }
        else {
            $m = 17;
        }
    
        $category_wise_data = $records[0];
        
        // Remove the first element
        array_shift($category_wise_data);
        
        // Remove the last element
        array_pop($category_wise_data);
        
        foreach ($category_wise_data as $key => &$value) {
            $value = 0;
        }
        
        $categories = array_keys($category_wise_data);
       
        foreach ($records as $record) {
            foreach($categories as $category) {
                $category_wise_data[$category] += $record[$category];
            }
        }
        
        // Convert data to JSON for use in JavaScript
        $category_wise_data = json_encode($category_wise_data);
    ?>
    
        
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
            <div class="BigHeader" style="width:90%; margin: 0 auto; margin-top:20px">Student Type Wise Breakup <?php echo date('Y', strtotime($this->session->academy_session['current_session']['start'])) ?></div>
                        
            <table class="GridTable" style="width:94%; margin: 0 auto; margin-top:30px">
                <tbody>
                        <tr>
                            <th class="Thc" style="width:3%">&nbsp;</th>
                            <th class="Thc">Class</th>
                            <?php
                                $count = count($records[0]);
                                foreach ($records[0] as $key => $value):
                                    if ($key !== 'class_name' && $key !== 'total_students'): ?>
                                        <th class="Thl"><?php echo str_replace('_', ' ', $key); ?></th>
                                    <?php endif;
                                endforeach;
                            ?>
                            <th class="Thc">Total</th>
                        </tr>
                        <?php 
                        $sl_no = 0;
                        foreach ($records as $record): 
                            $sl_no++;
                        ?>
                            <tr>
                                <td class="Tdc"><?php echo $sl_no; ?></td>
                                <td class="Tdc"><?php echo $record['class_name']; ?></td>
                                <?php 
                                foreach ($record as $key => $value):
                                    if ($key !== 'class_name' && $key !== 'total_students'): ?>
                                        <td class="Tdc"><?php echo $value; ?></td>
                                    <?php endif;
                                endforeach;
                                ?>
                                <td class="Tdc"><?php echo $record['total_students']; ?></td>
                            </tr>
                        <?php endforeach; ?>
                </tbody>
            </table>
            <div style="page-break-before:always">&nbsp;</div>
        <?php } ?>
        
        <div class="page">
            <div style="display: flex; justify-content: center; align-items: center;">
                <canvas id="myPieChart1" width="400" height="400"></canvas>
            </div>
        </div>
        
        <div style="page-break-before:always">&nbsp;</div>

        <div class="page">
            <canvas id="myPieChart2" width="3000" height="1000"></canvas>
        </div>
        
        <!-- Your content here -->
        <a target="_blank" href="<?php echo $_SERVER['REQUEST_URI'] . '&print=true';?>" class="fixed-button">
            <i class="fas fa-print"></i>
        </a>

    </body>
    
        
    
    <!-- CDN link for Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>
    
    <script>
        let colors = [
            '#F6C1C1', // Soft rose
            '#B5EAD7', // Light sea green
            '#D5AAFF', // Soft purple
            '#FFADAD', // Light rosy red
            '#FFE156', // Light yellow gold
            '#C5F0D0', // Soft light green
            '#F7B7A3',  // Light blush
            '#FF9AA2', // Light coral pink
            '#FFB7B2', // Light peach
            '#FFDAC1', // Light peachy beige
            '#FFABAB', // Pale light red
            '#FFC3A0', // Soft orange
            '#B9FBC0', // Light mint green
            '#C9C9FF', // Light lavender
            '#A2C2E1', // Light sky blue
            '#B9D9EB', // Pale blue
            '#FCE38A', // Pale yellow
        ]
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
        var ctx = document.getElementById('myPieChart1').getContext('2d');
        var chartData = <?php echo $category_wise_data; ?>;
        
        var myPieChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: Object.keys(chartData),
                datasets: [{
                    label: 'Total Students',
                    data: Object.values(chartData),
                    backgroundColor: colors,
                    borderWidth: 1
                }]
            },
            options: {
                responsive: false,
                maintainAspectRatio: true,
                plugins: {
                    datalabels: {
                        color: '#000',
                        anchor: 'center', // Anchor the label in the center of the segment
                        align: 'center', // Align the label in the center of the segment
                        formatter: (value) => value, // Display the data value
                        font: {
                            weight: 'bold',
                            size: 16 // Change this value to adjust the font size
                        }
                    },
                    legend: {
                        position: 'bottom',
                    },
                    tooltip: {
                        callbacks: {
                            label: function(tooltipItem) {
                                return `${tooltipItem.label}: ${tooltipItem.raw}`;
                            }
                        }
                    }
                },
                title: {
                    display: true,
                    text: 'Total Students by Class'
                }
            },
            plugins: [ChartDataLabels]
        });
    });
    </script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
    // Sample data
    var chartData = <?php echo json_encode($records); ?>;
    
    // Define colors
    var colors = [
        '#F6C1C1', '#B5EAD7', '#D5AAFF', '#FFADAD', '#FFE156', 
        '#C5F0D0', '#F7B7A3', '#FF9AA2', '#FFB7B2', '#FFDAC1', 
        '#FFABAB', '#FFC3A0', '#B9FBC0', '#C9C9FF', '#A2C2E1', 
        '#B9D9EB', '#FCE38A'
    ];

    // Extract unique keys for categories
    var keys = Object.keys(chartData[0]).filter(key => key !== 'class_name' && key !== 'total_students');

    // Generate datasets and colors dynamically
    var datasets = keys.map((key, index) => ({
        label: key,
        data: chartData.map(item => item[key]),
        backgroundColor: colors[index % colors.length] // Use color set cyclically
    }));

    // Process data for Chart.js
    var labels = chartData.map(item => item.class_name);

    // Create vertical bar chart
    var ctx = document.getElementById('myPieChart2').getContext('2d');
    var myGroupedBarChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: datasets
        },
        options: {
            responsive: true,
            maintainAspectRatio: false, // Allows custom dimensions
            plugins: {
                legend: {
                    display: true, // Set to false if you want to hide the legend
                    position: 'bottom',
                    labels: {
                        boxWidth: 20 // Customizes the legend box width
                    }
                },
                tooltip: {
                    callbacks: {
                        label: function(tooltipItem) {
                            return `${tooltipItem.dataset.label}: ${tooltipItem.raw}`;
                        }
                    }
                },
                datalabels: {
                    color: '#000',
                    anchor: 'end', // Position the label at the end of the bar
                    align: 'end',  // Align the label at the end of the bar
                    formatter: (value) => value, // Display the data value
                    font: {
                        weight: 'bold',
                        size: 12 // Adjust font size if needed
                    }
                }
            },
            scales: {
                x: {
                    stacked: false,
                    title: {
                        display: true,
                        text: 'Class Name'
                    },
                    grid: {
                        drawBorder: false,
                    },
                    ticks: {
                        autoSkip: false, // Ensure all labels are displayed
                        maxRotation: 0,  // Prevent rotation of labels
                        minRotation: 0,  // Prevent rotation of labels
                        callback: function(label) {
                            return labels[label]
                        }
                    }
                },
                y: {
                    stacked: false,
                    title: {
                        display: true,
                        text: 'Number of Students'
                    },
                    grid: {
                        drawBorder: false,
                    },
                    ticks: {
                        beginAtZero: true,
                        stepSize: 10, // Sets the interval between ticks
                        callback: function(value) {
                            return value.toLocaleString(); // Format numbers with commas
                        }
                    }
                }
            },
            elements: {
                bar: {
                    barThickness: 15 // Fixed width of each bar
                }
            }
        },
        plugins: [ChartDataLabels]
    });
});
    </script>
</html>