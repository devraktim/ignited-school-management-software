<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>ID Card - St. Anthony School</title>

    <style>
      @import url("https://fonts.googleapis.com/css2?family=Raleway:ital,wght@0,100..900;1,100..900&display=swap");
      @import url("https://fonts.cdnfonts.com/css/helvetica-neue-55");

      * {
        box-sizing: border-box;
      }

      *,
      *::before,
      *::after {
        margin: 0;
        padding: 0;
      }

      body {
      }

      img {
        max-width: 100%;
        height: auto;
      }

      .raleway-400 {
        font-family: "Raleway", sans-serif;
        font-optical-sizing: auto;
        font-weight: 400;
        font-style: normal;
      }

      .raleway-900 {
        font-family: "Raleway", sans-serif;
        font-optical-sizing: auto;
        font-weight: 900;
        font-style: normal;
      }

      .font-helvetica {
        font-family: "Helvetica Neue", sans-serif;
      }

      .main-wrap {
        background-color: #f5f5f5;
        min-height: 100vh;
        display: flex;
        flex-direction: column;
        justify-content: center;
        padding: 20px;
      }

      .row {
        display: flex;
        flex-wrap: wrap;
        /*margin-inline: -12px;*/
      }

      .col {
          width: 50%;
            /*padding-inline: 12px;*/
      }

      .cards-container {
        width: 100%;
        max-width: 1074px;
        margin-inline: auto;
        font-family: "Helvetica Neue", sans-serif;
      }

      .cards-container .col {
        width: 50%;
      }

      .id-card {
        aspect-ratio: 1074/708;
        background-image: url(https://ignitedschoolsoft.com/stanthony/images/id_cards/gradient-bg.png);
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        position: relative;
      }

      .id-card .id-card__header {
        background-image: url(https://ignitedschoolsoft.com/stanthony/images/id_cards/header-shape.png);
        background-size: 100%;
        background-repeat: no-repeat;
        padding: 18px 18px;
      }

      .id-card .id-card__logo-block {
        display: flex;
        align-items: center;
        color: #fff;
        column-gap: 20px;
      }

      .id-card .id-card__logo {
          height: 31px;
        flex-shrink: 0;
      }

      .id-card .id-card__header h1 {
        line-height: 1;
        font-size: large;
      }

      .id-card .id-card__header h2 {
        font-weight: 400;
        font-size: 14px;
      }

      .id-card .bg-img {
        position: absolute;
        left: 0;
        right: 0;
        bottom: 0;
      }

      .id-card .id-card__body {
        padding: 0px 0 48px 8px;
        display: grid;
        grid-template-columns: repeat(12, minmax(0, 1fr));
        gap: 20px;
      }

      .id-card .id-card__body .first-col {
        grid-column: span 8;
      }

      .id-card .id-card__body .second-col {
        position: relative;
        text-align: center;
        grid-column: span 4;
      }

      .id-card .id-card__body h3 {
        /*font-size: 32px;*/
        font-weight: 900;
      }

      .id-card .content-wrap {
        padding-left: 22px;
        position: relative;
      }

      .id-card .content-wrap::before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        bottom: 0;
        width: 6px;
        height: 100%;
        background-color: #ffa342;
      }

      .id-card .content-wrap .content-wrap__top > *:not(:last-child),
      .id-card .content-wrap .content-wrap__bottom > *:not(:last-child) {
        margin-bottom: 1px;
      }

      .id-card .content-wrap h4 {
        /*font-size: 28px;*/
        font-weight: 300;
      }

      .id-card .content-wrap h4 span:first-child {
        margin-right: 100px;
      }

      .id-card .content-wrap .content-wrap__top {
        margin-bottom: 7px;
        margin-top: 48px;
      }

      .id-card .rec-shape-lg {
        position: absolute;
        top: 0;
        left: 48px;
      }

      .id-card .rec-shape-sm {
        position: absolute;
        bottom: 66px;
        right: 0;
      }

      .id-card .line-shape {
        position: absolute;
        right: 35px;
        top: 0;
      }

      .id-card .sign-wrap {
        margin-top: 8px;
      }

      .id-card .sign-wrap h3 {
        /*font-size: 30px;*/
        text-transform: uppercase;
      }

      @media (max-width: 767px) {
        .cards-container .col {
          width: 100%;
        }
      }
    </style>
  </head>
  <body>
    <main class="main-wrap">
      <div class="cards-container">
        <div class="row" style="justify-content: space-between;">
        <?php 
            $class_map = [
                    1 => "UKG", 2 => "I", 3 => "II", 4 => "III", 5 => "IV", 
                    6 => "V", 7 => "VI", 8 => "VII", 9 => "VIII", 10 => "IX", 
                    11 => "X", 12 => "XI", 13 => "XII"
            ];
        ?>
        <?php foreach($records as $record) { 
        
        $fullName = $record['f_name'] . ' ' . $record['m_name'] . ' ' . $record['l_name'];
        $classId = $record['class_id'];
        $studentNo = $record['student_no'];
        $dob = $record['dob'];
        $address = $record['local_address'] . ' ' . $record['permanent_address'];
        $parentName = $record['father_name'];
        $phone = $record['local_phone'];
        $bloodGroup = $record['blood_group'] ?: 'Not Provided';
    
    ?>
	        <div class="col" style="margin-top: 10px !important; height: 190px; width: 300px;">
                <div class="id-card" style="height: 190px; width: 300px;">
                  <div class="id-card__header" style="padding-top: 8px;">
                    <div class="id-card__logo-block">
                      <img src="https://ignitedschoolsoft.com/stanthony/images/id_cards/logo.png" alt="" class="id-card__logo" />
                      <div style="margin-left: -17px;">
                        <h1 class="raleway-900" style="font-size: 6pt;">ST. ANTHONY’S SCHOOL</h1>
                        <h2 style="font-size: 5pt;">Giddha Pahar - Kurseong. Dist: Darjeeling</h2>
                        <h2 style="font-size: 5pt;">Contact :  +91 8172066180 / +91 9674354527</h2>
                      </div>
                    </div>
                  </div>
                  <div class="id-card__body" style="padding: 4px 0 0px 8px;">
                    <div class="first-col" style="margin-top: -60px;">
                      <div class="content-wrap">
                        <div class="content-wrap__top">
                          <h3 style="font-size: 6pt;">Name:  <?php echo ($fullName) ?></h3>
                          <h4 style="font-size: 6pt;">Student ID No: <?php echo($studentNo)?></h4>
                          <h4 style="font-size: 6pt;">Class: <?php echo($class_map[$classId])?>, DOB: <?php echo($dob)?></h4>
                          <h4 style="font-size: 6pt;">Address: <?php echo($address)?></h4>
                        </div>
                        <div class="content-wrap__bottom">
                          <h4 style="font-size: 6pt;">Parents Name: <?php echo($parentName)?></h4>
                          <h4 style="font-size: 6pt;">Mobile No: <?php echo($phone)?>,
                          <?php echo($Mphone)?></h4>
                          <h4 style="font-size: 6pt;">Blood Group: <?php echo($bloodGroup)?></h4>
                        </div>
                      </div>
                    </div>
                    <div class="second-col">
                      <figure style="text-align: start;">
                            <?php if($vPhoto == "") { ?>
                            <img src="https://ignitedschoolsoft.com/stanthony/images/id_cards/students/no_image.jpg" alt="" style="height: 60px; margin-left: 9px;" />
                            <?php } else { ?>
                            <img src="https://ignitedschoolsoft.com/stanthony/images/id_cards/students/" alt="" style="height: 70px; width: 60px; margin-left: 9px;" />
                            <?php } ?>
                          
                        
                      </figure>
                      <img src="https://ignitedschoolsoft.com/stanthony/images/id_cards/rectange-shape-lg.png" alt="" class="rec-shape-lg" style="height: 20px; left: -7px;" />
                      <!--<img src="https://ignitedschoolsoft.com/stanthony/images/id_cards/rectangle-shape-sm.png" alt="" class="rec-shape-sm" style="bottom: 55px; height: 11px;" />-->
                      <img src="https://ignitedschoolsoft.com/stanthony/images/id_cards/vertical-line-shape-2.png" alt="" class="line-shape" style="height: 90px; right: 6px;" />
    
                      <div class="sign-wrap">
                        <img src="https://ignitedschoolsoft.com/stanthony/images/id_cards/signature.png" alt="" style="height: 20px;" />
                        <h3 style="font-size: 5pt;">Principal</h3>
                      </div>
                    </div>
    
                    <img src="https://ignitedschoolsoft.com/stanthony/images/id_cards/footer-shape.png" alt="" class="bg-img" />
                  </div>
                </div>
                
                <?php if($i == 8) { $i = 0; ?>
                    <div style="page-break-before:always">&nbsp;</div>
                <?php } ?>
            </div>
        <?php } ?>
          </div>
        </div>
      </div>
    </main>
  </body>
</html>