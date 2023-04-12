
<?php
use \koolreport\excel\Table;
use \koolreport\datagrid\DataTables;
use \koolreport\core\Utility as Util;

    $sheet1 = "Consultant Detail";
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
    Report Name : CONSULTANTS DETAILS REPORT
    </div>
    <div cell="A2" range="A2:J2"  excelstyle='<?php echo json_encode($styleArray1); ?>' >Report Date:  <?php echo date("d-M-Y h:i:sa"); ?></div>
    <div  cell="A3" range="A3:J3"   excelstyle='<?php echo json_encode($styleArray1); ?>' >Module Name : CONSULTANT MANAGEMENT MODULE</div>
    <div cell="A5"> 
      <?php
          $datacon = $this->dataStore('CONSULTANTDETAILREPORT');
          $datalicense = $this->dataStore('CONSULTANTLICENSE');
          $newArrayCon = array();
          $uts = "";
          $prs = "";
          $consID = array();
          $conPRSID = array();
          $consStatusTag = array();
          foreach($datacon as $row){
              $consID[$row['CID']] = "N";
              $conPRSID[$row['CID']] = "N";
              $consStatusTag[$row['CID']] = "";
          }
          foreach($datacon as $row)
          {
      
              $dateOfBirth = $row['DOB'];
              $today = date("Y-m-d");
              $diff = date_diff(date_create($dateOfBirth), date_create($today));
             // echo 'Your age is '.$diff->format('%y');
              $uts = "N";
              $prs = "N";
              
              foreach($datalicense as $row1)
              {
                  if($row1['CONID'] == $row['CID'])
                  {
                      if($row1['TID'] == 1)
                      {
                           $uts = "Y";
                      }
                      
                      $consID[$row['CID']] = $uts;
                      $consStatusTag[$row['CID']] = $row1['STATUSTAG'];
                  }
              }
      
              foreach($datalicense as $row1)
              {
                  if($row1['CONID'] == $row['CID'])
                  {
                      if($row1['TID'] == 2)
                      {
                          $prs = "Y";
                      }
                      $conPRSID[$row['CID']] = $prs;
                      $consStatusTag[$row['CID']] = $row1['STATUSTAG'];
                  }
              }
                  // echo "<pre>";
                  // print_r($consID);
                  // echo "</pre>";
                  $cID = $row['CID'];
                  if($row['PROCERTIFICATE'] == 1)
                  {
                      $pro = "CFP";
                  }
                  else if($row['PROCERTIFICATE'] == 2)
                  {
                      $pro = "IFP";
                  }
                  else if($row['PROCERTIFICATE'] == 3)
                  {
                      $pro = "RFP";
                  }
                  else if($row['PROCERTIFICATE'] == 4)
                  {
                      $pro = "SRFP";
                  }
                  else{
                      $pro = "";
                  }
                  $newArrayCon[] =  array( 
                                       'NAME' => $row['CNAME'],
                                       'NRIC' => $row['NRIC'],
                                       'PASSPORT' => $row['PASSPORT'],
                                       'P.EXPIRY DATE' => $row['PASSPORTEXPIRE'],
                                       'FIMM NO' => $row['FIMMNO'],
                                       'STATUS' => $row['STATUS'],
                                       'STATUS TAG' =>$consStatusTag[$cID],
                                       'UTS' => $consID[$cID],
                                       'PRS' => $conPRSID[$cID],
                                       'AGE' => $diff->format('%y'),
                                       'GENDER' => $row['GENDER'],
                                       'RACE' => $row['RACE'],
                                       'RACE(REMARK)' => $row['RACEREMARK'],
                                       'ACADEMIC QUALIFICATION' => $row['ACADEMICQUALI'],
                                       'PROFESSIONAL QUALIFICATION' => $pro,
                                       'NATIONALITY' => $row['NATIONALITY'],
                                       'COUNTRY' => $row['COUNTRY'],
                                       'CORRESPONDENCE ADDRESS-STREET' => $row['CSTREET'],
                                       'CORRESPONDENCE ADDRESS-POSTCODE' => $row['CPOSTCODE'],
                                       'CORRESPONDENCE ADDRESS-CITY' => $row['CCITY'],
                                       'CORRESPONDENCE ADDRESS-STATE' => $row['CSTATE'],
                                       'PERMANENT ADDRESS-STREET' => $row['PSTREET'],
                                       'PERMANENT ADDRESS-POSTCODE' => $row['PPOSTCODE'],
                                       'PERMANENT ADDRESS-CITY' =>$row['PCITY'],
                                       'PERMANENT ADDRESS-STATE' =>  $row['PSTATE'],
                                       'PHONE NUMBER-MOBILE' => $row['MOBILE'],
                                       'PHONE NUMBER-HOME' =>$row['HOUSE'],
                                       'PHONE NUMBER-EMAIL' => $row['EMAIL'],
                                   );
          }
        $newMeta= [];
        $ds = new \koolreport\core\DataStore($newArrayCon, $newMeta);
        Table::create(array(
            "dataSource"=>$ds,
            "complexHeaders" => true,
            "headerSeparator" => "-",
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

