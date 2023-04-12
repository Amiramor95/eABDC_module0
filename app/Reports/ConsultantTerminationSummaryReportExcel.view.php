
<?php
use \koolreport\excel\Table;
use \koolreport\datagrid\DataTables;
use \koolreport\core\Utility as Util;

    $sheet1 = "Consultant Termination";
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
    Report Name : CONSULTANTS TERMINATION SUMMARY REPORT
    </div>
    <div cell="A2" range="A2:J2"  excelstyle='<?php echo json_encode($styleArray1); ?>' >Report Date:  <?php echo date("d-M-Y h:i:sa"); ?></div>
    <div  cell="A3" range="A3:J3"   excelstyle='<?php echo json_encode($styleArray1); ?>' >Module Name : CONSULTANT MANAGEMENT MODULE</div>
    <div cell="A5"> 
      <?php
      $datacon = $this->dataStore('CONSULTANTTERMINATIONSUMMREPORT');
      $datautsresigned = $this->dataStore('CONSULTANTUTSRESIGNEDREPORT');
      $dataprsresigned = $this->dataStore('CONSULTANTPRSRESIGNEDREPORT');
      $datautsrevoked = $this->dataStore('CONSULTANTUTSREVOKEDREPORT');
      $dataprsrevoked = $this->dataStore('CONSULTANTPRSREVOKEDREPORT');
      $datautstermination = $this->dataStore('CONSULTANTUTSTERMINATIONREPORT');
      $dataprstermination = $this->dataStore('CONSULTANTPRSTERMINATIONREPORT');
    
      $newArrayCon = array();
      $utsresigned = 0;
      $prsresigned = 0;
      $utsrevoked = 0;
      $prsrevoked = 0;
      $utstermination = 0;
      $prstermination = 0;
      $consUTSRE = array();
      $conPRSRE = array();
      $consUTSREVOKED = array();
      $consPRSREVIKED = array();
      $consURSVAR = array();
      $consPRSVAR = array();
      $consURSTERMINATION = array();
      $consPRSTERMINATION = array();
      foreach($datacon as $row){
          $consUTSRE[$row['DISTRIBUTOR_ID']] = 0;
          $conPRSRE[$row['DISTRIBUTOR_ID']] = 0;
          $consUTSREVOKED[$row['DISTRIBUTOR_ID']] = 0;
          $consPRSREVIKED[$row['DISTRIBUTOR_ID']] = 0;
          $consURSTERMINATION[$row['DISTRIBUTOR_ID']] = 0;
          $consPRSTERMINATION[$row['DISTRIBUTOR_ID']] = 0;
      }
      foreach($datacon as $row)
      {
         
          $utsresigned = 0;
          $prsresigned = 0;
          $utsrevoked = 0;
         $prsrevoked = 0;
         $utstermination = 0;
         $prstermination = 0;
          foreach($datautsresigned as $row1)
          {
              if($row1['DID'] == $row['DISTRIBUTOR_ID'])
              {
                    //echo "enter";
                    $utsresigned = $row1['RESIGNEDTOTAL'];
                  $consUTSRE[$row['DISTRIBUTOR_ID']] = $utsresigned;
  
  
              }
          }
          foreach($dataprsresigned as $row2)
          {
              if($row2['DID'] == $row['DISTRIBUTOR_ID'])
              {
                    //echo "enter";
                    $prsresigned = $row2['RESIGNEDTOTAL'];
                  $conPRSRE[$row['DISTRIBUTOR_ID']] = $prsresigned;
  
  
              }
          }
          foreach($datautsrevoked as $row3)
          {
              if($row3['DID'] == $row['DISTRIBUTOR_ID'])
              {
                    //echo "enter";
                    $utsrevoked = $row3['REVOKEDTOTAL'];
                  $consUTSREVOKED[$row['DISTRIBUTOR_ID']] = $utsrevoked;
  
  
              }
          }
          foreach($dataprsrevoked as $row4)
          {
              if($row4['DID'] == $row['DISTRIBUTOR_ID'])
              {
                   // echo "enter1";
                    $prsrevoked = $row4['REVOKEDTOTAL'];
                  $consPRSREVIKED[$row['DISTRIBUTOR_ID']] = $prsrevoked;
  
  
              }
          }
          foreach($datautstermination as $row5)
          {
              if($row5['DID'] == $row['DISTRIBUTOR_ID'])
              {
                   // echo "enter1";
                    $utstermination = $row5['TERMINATIONTOTAL'];
                  $consURSTERMINATION[$row['DISTRIBUTOR_ID']] = $utstermination;
  
  
              }
          }
          foreach($dataprstermination as $row6)
          {
              if($row6['DID'] == $row['DISTRIBUTOR_ID'])
              {
                   // echo "enter1";
                    $prstermination = $row6['TERMINATIONTOTAL'];
                  $consPRSTERMINATION[$row['DISTRIBUTOR_ID']] = $prstermination;
  
  
              }
          }
          $dID = $row['DISTRIBUTOR_ID'];
  
              $newArrayCon[] =  array( 
                                    'DISTRIBUTOR' => $row['DIST_NAME'],
                                    'UTS-RESIGNATION' => $consUTSRE[$dID],
                                    'UTS-TERMINATION' => $consURSTERMINATION[$dID],
                                     'UTS-REVOKED' => $consUTSREVOKED[$dID],
                                     'PRS-RESIGNATION' => $conPRSRE[$dID],
                                     'PRS-TERMINATION' => $consPRSTERMINATION[$dID],
                                     'PRS-REVOKED' => $consPRSREVIKED[$dID],
                               );
      }
        $newMeta= [];
        $ds = new \koolreport\core\DataStore($newArrayCon, $newMeta);
        Table::create(array(
            "dataSource"=>$ds,
            "showFooter"=>true,
            "complexHeaders" => true,
            "headerSeparator" => "-",
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
               "footerText"=>"<b>TOTAL</b>",
            ),
            "UTS-RESIGNATION"=>array(
                //"label"=>"UTS-EXAM PASSED",
                "type"=>"number",
                "cssStyle"=>"dt-body-center",
                "footer"=>"sum",
                "footerText"=>"@value",
            ),
            "UTS-TERMINATION"=>array(
               // "label"=>"UTS-VARIATION",
                "type"=>"number",
                "cssStyle"=>"text-align:center",
                "footer"=>"sum",
                "footerText"=>"@value",
            ),
            "UTS-REVOKED"=>array(
               // "label"=>"UTS-EXEMPTION",
                "type"=>"number",
                "cssStyle"=>"text-align:center",
                "footer"=>"sum",
                "footerText"=>"@value",
            ),
            "PRS-RESIGNATION"=>array(
               // "label"=>"PRS-EXAM PASSED",
                "type"=>"number",
                "cssStyle"=>"text-align:center",
                "footer"=>"sum",
                "footerText"=>"@value",
            ),
            "PRS-TERMINATION"=>array(
               // "label"=>"PRS-VARIATION",
                "type"=>"number",
                "cssStyle"=>"text-align:center",
                "footer"=>"sum",
                "footerText"=>"@value",
            ),
            "PRS-REVOKED"=>array(
                //"label"=>"PRS-EXEMPTION",
                "type"=>"number",
                "cssStyle"=>"text-align:center",
                "footer"=>"sum",
                "footerText"=>"@value",
            ),
        ),
        "cssClass"=>array(
            "table"=>"table table-striped table-bordered",
            'th' => 'reportHeader',
            'tr' => 'reportRow',
            'td' => function($row, $colName) {
                $v = Util::get($row, $colName, 0);
                $s = is_numeric($v) ? 'text-center' : 'reportLabel';
                return $s;
            },
            'tf' => 'reportFooter'
        )
        ));
        ?>
    </div>

</div>

