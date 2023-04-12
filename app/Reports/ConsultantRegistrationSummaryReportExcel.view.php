
<?php
use \koolreport\excel\Table;
use \koolreport\datagrid\DataTables;
use \koolreport\core\Utility as Util;

    $sheet1 = "Consultant Registration";
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
    Report Name : CONSULTANTS REGISTRATION SUMMARY REPORT
    </div>
    <div cell="A2" range="A2:J2"  excelstyle='<?php echo json_encode($styleArray1); ?>' >Report Date:  <?php echo date("d-M-Y h:i:sa"); ?></div>
    <div  cell="A3" range="A3:J3"   excelstyle='<?php echo json_encode($styleArray1); ?>' >Module Name : CONSULTANT MANAGEMENT MODULE</div>
    <div cell="A5"> 
      <?php
      $datacon = $this->dataStore('CONSULTANTREGISTRATIONSUMMREPORT');
      $datatype = $this->dataStore('DISTRIBUTORTYPE');
      $dataexam = $this->dataStore('CONSULTANTEXAMREPORT');
    
  
      $newArrayDept = array();
      $newArrayApp = array();
      $newArrayExam = array();
      foreach($datatype as $row2)
      {
          $newArrayDept[] = array(
                             'DISTID' => $row2['DIST_ID'],
                             'TYPENAME' => $row2['DIST_TYPE_NAME'],
          );
      }
      foreach($dataexam as $row3)
      {
          // echo "<pre>";
          // print_r($row3);
          // echo "</pre>";
              $newArrayExam[] = array(
              'CONSULTANT_ID' => $row3['CONSULTANT_ID'],
              'CONSULTANTAPPLICATIONTYPE' => $row3['CONSULTANTAPPLICATIONTYPE'],
              'DISTRIBUTOR_ID' => $row3['DISTRIBUTOR_ID'],
              'CONSULTANT_TYPE_ID' => $row3['CONSULTANT_TYPE_ID'],
              'EXAM_RESULT_STATUS' => $row3['EXAM_RESULT_STATUS'],
              );
      }
     
      $newArrayCon = array();
      $utsexam = 0;
      $prsexam = 0;
      $utsvar = 0;
      $prsvar = 0;
      $utsexemp = 0;
      $prsexemp = 0;
      $consID = array();
      $conPRSID = array();
      $consURSVAR = array();
      $consPRSVAR = array();
      $consURSEXEMP = array();
      $consPRSEXEMP = array();
      foreach($datacon as $row){
          $consID[$row['DISTRIBUTOR_ID']] = 0;
          $conPRSID[$row['DISTRIBUTOR_ID']] = 0;
          $consURSVAR[$row['DISTRIBUTOR_ID']] = 0;
          $consPRSVAR[$row['DISTRIBUTOR_ID']] = 0;
          $consURSEXEMP[$row['DISTRIBUTOR_ID']] = 0;
          $consPRSEXEMP[$row['DISTRIBUTOR_ID']] = 0;
      }
      foreach($datacon as $row)
      {
          $respectiveNames = array();
          foreach($newArrayDept as $dj){
              if( $dj['DISTID'] == $row['DISTRIBUTOR_ID']){
                  $respectiveNames[] = $dj['TYPENAME'];
              }
          }
          $utsexam = 0;
          $prsexam = 0;
          $utsvar = 0;
          $prsvar = 0;
          $utsexemp = 0;
          $prsexemp = 0;
          foreach($dataexam as $row1)
          {
              if($row1['DISTRIBUTOR_ID'] == $row['DISTRIBUTOR_ID'])
              {
                  if($row1['CONSULTANT_TYPE_ID'] == 1 && $row1['EXAM_RESULT_STATUS'] == 1)
                  {
                      //echo "enter";
                       $utsexam++;
                  }
                  $consID[$row['DISTRIBUTOR_ID']] = $utsexam;
  
                  if($row1['CONSULTANT_TYPE_ID'] == 1 && $row1['CONSULTANTAPPLICATIONTYPE'] == 2)
                  {
                      //echo "enter";
                       $utsvar++;
                  }
                  $consURSVAR[$row['DISTRIBUTOR_ID']] = $utsvar;
                  if($row1['CONSULTANT_TYPE_ID'] == 1 && $row1['CONSULTANTAPPLICATIONTYPE'] == 3)
                  {
                      //echo "enter";
                       $utsexemp++;
                  }
                  $consURSEXEMP[$row['DISTRIBUTOR_ID']] = $utsexemp;
  
              }
          }
          foreach($dataexam as $row4)
          {
              if($row4['DISTRIBUTOR_ID'] == $row['DISTRIBUTOR_ID'])
              {
                  if($row4['CONSULTANT_TYPE_ID'] == 2 && $row4['EXAM_RESULT_STATUS'] == 1)
                  {
                     // echo "enter";
                       $prsexam++;
                  }
  
                  $conPRSID[$row['DISTRIBUTOR_ID']] = $prsexam;
                  if($row4['CONSULTANT_TYPE_ID'] == 2 && $row4['CONSULTANTAPPLICATIONTYPE'] == 2)
                  {
                      //echo "enter";
                       $prsvar++;
                  }
                  $consPRSVAR[$row['DISTRIBUTOR_ID']] = $prsvar;
                  if($row4['CONSULTANT_TYPE_ID'] == 2 && $row4['CONSULTANTAPPLICATIONTYPE'] == 3)
                  {
                      //echo "enter";
                       $prsexemp++;
                  }
                  $consPRSEXEMP[$row['DISTRIBUTOR_ID']] = $prsexemp;
              }
          }
          $dID = $row['DISTRIBUTOR_ID'];
              $newArrayCon[] =  array( 
                                    'DISTRIBUTOR' => $row['DIST_NAME'],
                                    'TYPE' => implode(', ', $respectiveNames),
                                    'UTS-EXAM PASSED' => $consID[$dID],
                                    'UTS-VARIATION' => $consURSVAR[$dID],
                                    'UTS-EXEMPTION' => $consURSEXEMP[$dID],
                                    'UTS-TOTAL' => ($consID[$dID]+$consURSVAR[$dID]+$consURSEXEMP[$dID]),
                                    'PRS-EXAM PASSED' => $consPRSVAR[$dID],
                                    'PRS-VARIATION' => $consPRSVAR[$dID],
                                    'PRS-EXEMPTION' => $consPRSEXEMP[$dID],
                                    'PRS-TOTAL' => ($consPRSVAR[$dID]+$consPRSVAR[$dID]+$consPRSEXEMP[$dID]),
                               );
      }
        $newMeta= [];
        $ds = new \koolreport\core\DataStore($newArrayCon, $newMeta);
        Table::create(array(
            "dataSource"=>$ds,
            "complexHeaders" => true,
            "headerSeparator" => "-",
            "showFooter"=>true,
            "options"=>array(
                "order"=>array(
                   array(0,"desc"), //Sort by first column desc
                  // array(1,"asc"), //Sort by second column asc
               ),
           ),
           "columns"=>array(
            "DISTRIBUTOR"=>array(
               // "label"=>"DISTRIBUTOR",
                "type"=>"string",
                "searchable" => true,
               // "type"=>"datetime",
               // "format"=>"Y-m-d H:i:s",
               // "displayFormat"=>"Y"
              // "footer"=>"sum",
               "footerText"=>"TOTAL",
            ),
            "TYPE"=>array(
              //"label"=>"DTYPE",
              "type"=>"string",
              "searchable" => true,
               // "footer"=>"sum",
               "footerText"=>"",
            ),
            "UTS-EXAM PASSED"=>array(
                //"label"=>"UTS-EXAM PASSED",
                "type"=>"number",
                "cssStyle"=>"dt-body-center",
                "footer"=>"sum",
                "footerText"=>"@value",
            ),
            "UTS-VARIATION"=>array(
               // "label"=>"UTS-VARIATION",
                "type"=>"number",
                "cssStyle"=>"text-align:center",
                "footer"=>"sum",
                "footerText"=>"@value",
            ),
            "UTS-EXEMPTION"=>array(
               // "label"=>"UTS-EXEMPTION",
                "type"=>"number",
                "cssStyle"=>"text-align:center",
                "footer"=>"sum",
                "footerText"=>"@value",
            ),
            "UTS-TOTAL"=>array(
                //"label"=>"TOTAL",
                "type"=>"number",
                "cssStyle"=>"text-align:center",
                "footer"=>"sum",
                "footerText"=>"@value",
            ),
            "PRS-EXAM PASSED"=>array(
               // "label"=>"PRS-EXAM PASSED",
                "type"=>"number",
                "cssStyle"=>"text-align:center",
                "footer"=>"sum",
                "footerText"=>"@value",
            ),
            "PRS-VARIATION"=>array(
                "label"=>"PRS-VARIATION",
                "type"=>"number",
                 "footer"=>"sum",
                "footerText"=>"@value",
            ),
            "PRS-EXEMPTION"=>array(
                //"label"=>"PRS-EXEMPTION",
                "type"=>"number",
                "cssStyle"=>"text-align:center",
                "footer"=>"sum",
                "footerText"=>"@value",
            ),
            "PRS-TOTAL"=>array(
               // "label"=>"TOTAL",
                "type"=>"number",
                "cssStyle"=>"text-align:center",
                "footer"=>"sum",
                "footerText"=>"@value",
            ),
        ),
        ));
        ?>
    </div>

</div>

