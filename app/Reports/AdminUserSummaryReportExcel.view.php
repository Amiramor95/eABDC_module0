
<?php
use \koolreport\excel\Table;
use \koolreport\datagrid\DataTables;
use \koolreport\core\Utility as Util;

    $sheet1 = "List of User";
?>


<div sheet-name="<?php echo $sheet1; ?>">
    <?php
    $styleArray = [
        'font' => [
            'name' => 'Calibri', //'Verdana', 'Arial'
            'size' => 15,
            'bold' => true,
            'italic' => FALSE,
            'underline' => 'none', //'double', 'doubleAccounting', 'single', 'singleAccounting'
            'strikethrough' => FALSE,
            'superscript' => false,
            'subscript' => false,
            'color' => [
                'rgb' => '000000',
                'argb' => 'FF000000',
            ]
        ],
        'alignment' => [
            'horizontal' => 'general',//left, right, center, centerContinuous, justify, fill, distributed
            'vertical' => 'bottom',//top, center, justify, distributed
            'textRotation' => 0,
            'wrapText' => false,
            'shrinkToFit' => false,
            'indent' => 0,
            'readOrder' => 0,
        ],
        'borders' => [
            'top' => [
                'borderStyle' => 'none', //dashDot, dashDotDot, dashed, dotted, double, hair, medium, mediumDashDot, mediumDashDotDot, mediumDashed, slantDashDot, thick, thin
                'color' => [
                    'rgb' => '808080',
                    'argb' => 'FF808080',
                ]
            ],
            //left, right, bottom, diagonal, allBorders, outline, inside, vertical, horizontal
        ],
        'fill' => [
            'fillType' => 'none', //'solid', 'linear', 'path', 'darkDown', 'darkGray', 'darkGrid', 'darkHorizontal', 'darkTrellis', 'darkUp', 'darkVertical', 'gray0625', 'gray125', 'lightDown', 'lightGray', 'lightGrid', 'lightHorizontal', 'lightTrellis', 'lightUp', 'lightVertical', 'mediumGray'
            'rotation' => 90,
            'color' => [
                'rgb' => 'A0A0A0',
                'argb' => 'FFA0A0A0',
            ],
            'startColor' => [
                'rgb' => 'A0A0A0',
                'argb' => 'FFA0A0A0',
            ],
            'endColor' => [
                'argb' => 'FFFFFF',
                'argb' => 'FFFFFFFF',
            ],
        ],
    ];
    $styleArray1 = [
        'font' => [
            'name' => 'Calibri', //'Verdana', 'Arial'
            'size' => 15,
            'bold' => false,
            'italic' => FALSE,
            'underline' => 'none', //'double', 'doubleAccounting', 'single', 'singleAccounting'
            'strikethrough' => FALSE,
            'superscript' => false,
            'subscript' => false,
            'color' => [
                'rgb' => '000000',
                'argb' => 'FF000000',
            ]
        ],
        'alignment' => [
            'horizontal' => 'general',//left, right, center, centerContinuous, justify, fill, distributed
            'vertical' => 'bottom',//top, center, justify, distributed
            'textRotation' => 0,
            'wrapText' => false,
            'shrinkToFit' => false,
            'indent' => 0,
            'readOrder' => 0,
        ],
        'borders' => [
            'top' => [
                'borderStyle' => 'none', //dashDot, dashDotDot, dashed, dotted, double, hair, medium, mediumDashDot, mediumDashDotDot, mediumDashed, slantDashDot, thick, thin
                'color' => [
                    'rgb' => '808080',
                    'argb' => 'FF808080',
                ]
            ],
            //left, right, bottom, diagonal, allBorders, outline, inside, vertical, horizontal
        ],
        'fill' => [
            'fillType' => 'none', //'solid', 'linear', 'path', 'darkDown', 'darkGray', 'darkGrid', 'darkHorizontal', 'darkTrellis', 'darkUp', 'darkVertical', 'gray0625', 'gray125', 'lightDown', 'lightGray', 'lightGrid', 'lightHorizontal', 'lightTrellis', 'lightUp', 'lightVertical', 'mediumGray'
            'rotation' => 90,
            'color' => [
                'rgb' => 'A0A0A0',
                'argb' => 'FFA0A0A0',
            ],
            'startColor' => [
                'rgb' => 'A0A0A0',
                'argb' => 'FFA0A0A0',
            ],
            'endColor' => [
                'argb' => 'FFFFFF',
                'argb' => 'FFFFFFFF',
            ],
        ],
    ];
    ?>
    <div cell="A1" range="A1:J1" excelstyle='<?php echo json_encode($styleArray); ?>' >
    Report Name : Summary: List of User
    </div>
    <div cell="A2" range="A2:J2"  excelstyle='<?php echo json_encode($styleArray1); ?>' >Report Date:  <?php echo date("d-M-Y h:i:sa"); ?></div>
    <div  cell="A3" range="A3:J3"   excelstyle='<?php echo json_encode($styleArray1); ?>' >Module Name : ADMIN MODULE</div>
    <div cell="A5"> 
      <?php
         $datafimm = $this->dataStore('FIMMUSERSUMMARY');
         $datadistributor = $this->dataStore('DISTRIBUTORUSERSUMMARY');
         $dataconsultant = $this->dataStore('CONSULTANTUSERSUMMARY');
         $dataothers = $this->dataStore('OTHERSUSERSUMMARY');
         $dataip = $this->dataStore('KEYKLOCKID');
         $newArrayFimm = array();
         $newArrayDistributor = array();
         $newArrayConsultant = array();
         $newArrayOthers = array();
        // $ip = "";
         foreach($datafimm as $row)
         {
             $ip = "";
             foreach($dataip as $krow)
             {
                 if($row['KID'] == $krow['KEYID'])
                 {
                   $ip =   $krow['IP'];
                 }
             }
             if($row['USER_STATUS'] == 0)
             {
                 $status = "INACTIVE";
             }
             else if($row['USER_STATUS'] == 1)
             {
                 $status = "PENDING";
             }
             else if($row['USER_STATUS'] == 2)
             {
                 $status = "APPROVED";
             }
             else{
               $status = "RETURNED";
             }
     
                 $newArrayFimm[] =  array( 
                                      'NAME' => $row['USER_NAME'],
                                      'EMAIL' => $row['USER_EMAIL'],
                                      'COMPANY' => "FIMM",
                                      'STATUS' => $status,
                                      'IP' => $ip,
                                      'STATE' => $row['STATE'],
                                  );
         }
         foreach($datadistributor as $row1)
         {
             $ip1 = "";
             foreach($dataip as $krow1)
             {
                 if($row1['KID'] == $krow1['KEYID'])
                 {
                   $ip1 =   $krow1['IP'];
                 }
             }
             if($row1['USER_STATUS'] == 0)
             {
                 $status1 = "INACTIVE";
             }
             else if($row1['USER_STATUS'] == 1)
             {
                 $status1 = "PENDING";
             }
             else if($row1['USER_STATUS'] == 2)
             {
                 $status1 = "APPROVED";
             }
             else{
               $status1 = "RETURNED";
             }
     
                 $newArrayDistributor[] =  array(
                                      'NAME' => $row1['USER_NAME'],
                                      'EMAIL' => $row1['USER_EMAIL'],
                                      'COMPANY' => $row1['COMPANY'],
                                      'STATUS' => $status1,
                                      'IP' => $ip1,
                                      'STATE' => $row1['STATE'],
                                  );
         }
         foreach($dataconsultant as $row2)
         {
             $ip2 = "";
             foreach($dataip as $krow2)
             {
                 if($row2['KID'] == $krow2['KEYID'])
                 {
                   $ip2 =   $krow2['IP'];
                 }
             }
             if($row2['USER_STATUS'] == 0)
             {
                 $status2 = "INACTIVE";
             }
             else if($row2['USER_STATUS'] == 1)
             {
                 $status2 = "PENDING";
             }
             else if($row2['USER_STATUS'] == 2)
             {
                 $status2 = "APPROVED";
             }
             else{
               $status2 = "RETURNED";
             }
     
                 $newArrayCONSULTANT[] =  array(
                                      'NAME' => $row2['USER_NAME'],
                                      'EMAIL' => $row2['USER_EMAIL'],
                                      'COMPANY' => $row2['COMPANY'],
                                      'STATUS' => $status2,
                                      'IP' =>$ip2,
                                      'STATE' => "DEMO",
                                  );
         }
         foreach($dataothers as $row3)
         {
             $ip3 = "";
             foreach($dataip as $krow3)
             {
                 if($row3['KID'] == $krow3['KEYID'])
                 {
                   $ip3 =   $krow3['IP'];
                 }
             }
             if($row3['USER_STATUS'] == 0)
             {
                 $status3 = "INACTIVE";
             }
             else if($row3['USER_STATUS'] == 1)
             {
                 $status3 = "PENDING";
             }
             else if($row3['USER_STATUS'] == 2)
             {
                 $status3 = "APPROVED";
             }
             else{
               $status3 = "RETURNED";
             }
     
                 $newArrayOthers[] =  array(
                                      'NAME' => $row3['USER_NAME'],
                                      'EMAIL' => $row3['USER_EMAIL'],
                                      'COMPANY' => $row3['COMPANY'],
                                      'STATUS' => $status3,
                                      'IP' => $ip3,
                                      'STATE' => $row3['STATE'],
                                  );
         }
        $newArray = array_merge($newArrayFimm,$newArrayDistributor);
        $newArray1 = array_merge($newArrayCONSULTANT,$newArrayOthers);
        $finalArray = array_merge($newArray,$newArray1);
        $newMeta= [];
        $ds = new \koolreport\core\DataStore($finalArray, $newMeta);
        Table::create(array(
            "dataSource"=>$ds,
            "options"=>array(
                "order"=>array(
                   array(0,"desc"), //Sort by first column desc
                  // array(1,"asc"), //Sort by second column asc
               ),
           ),
        ));
        ?>
    </div>

</div>

