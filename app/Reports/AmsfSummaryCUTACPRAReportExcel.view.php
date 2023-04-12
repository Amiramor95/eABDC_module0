
<?php
use \koolreport\excel\Table;
use \koolreport\datagrid\DataTables;
use \koolreport\core\Utility as Util;

    $sheet1 = "PRP";
?>


<div sheet-name="<?php echo $sheet1; ?>">
    <?php
    $styleArray = [
        'font' => [
            'name' => 'Calibri', //'Verdana', 'Arial'
            'size' => 15,
            'bold' => true,
            'text-transform' => 'uppercase',
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
    Report Name : Summary Report Annual Membership Fees/Annual Fee Payment (CUTA/CPRA) Year <?php echo $this->params["AMSFYEAR"]; ?> - <?php echo $this->params["AMSFYEAREND"]; ?>
    </div>
    <div cell="A2" range="A2:J2"  excelstyle='<?php echo json_encode($styleArray1); ?>' >Report Date:  <?php echo date("d-M-Y h:i:sa"); ?></div>
    <div  cell="A3" range="A3:J3"   excelstyle='<?php echo json_encode($styleArray1); ?>' >Module Name : ANNUAL FEES MODULE</div>
    <div cell="A5"> 
    <?php
      $datacon = $this->dataStore('AMSFSUMMARYCUTACPRAREPORT');
      $datatype = $this->dataStore('DISTRIBUTORTYPE');
      $newArrayCon = array();
      $newArrayDept = array();
      $respectiveSchemeNames = array();
      $membershiplevi = 0;
      foreach($datatype as $row2)
      {
          $newArrayDept[] = array(
                             'DISTID' => $row2['DIST_ID'],
                             'TYPENAME' => $row2['DIST_TYPE_NAME'],
          );
      }
      foreach($datacon as $row)
      {
          $launchdate = "";
          $updatedate = "";
          $contact = "";
          $shasridate = "";
          $respectiveSchemeNames = array();
          foreach($newArrayDept as $dj1){
              if( $dj1['DISTID'] == $row['DISTRIBUTOR_ID']){
                 // echo $dj1['DISTID'];
              $respectiveSchemeNames[] = $dj1['TYPENAME'];
              }
             }
          // if($row['LAUNCHDATE'] != '')
          // {
          //    $launchdate = date("d-M-Y", strtotime($row['LAUNCHDATE']));
          // }
          $membershiplevi = 50;
              $newArrayCon[] =  array( 
                                   // 'AMSF YEAR' => $row['AMSF_YEAR'],
                                    'COMPANY' => $row['DIST_NAME'],
                                    'CATEGORY' => implode(' + ', $respectiveSchemeNames),
                                  //   'TOTAL GROUP A(UT)(RM)' => $row['TOTALGROUPA'],
                                  //   'TOTAL GROUP B(UT)(RM)' => $row['TOTALGROUPB'],
                                  //   'TOTAL AUM(UT)(RM)' => $row['TOTALGROUPA']+$row['TOTALGROUPB'],
                                  //   'TOTAL NORMAL LOAD(PRS)(RM)' => $row['TOTALNORMALLOAD'],
                                  //   'TOTAL LOW LOAD(PRS)(RM)' => $row['TOTALLOWLOAD'],
                                  //   'TOTAL NO LOAD(PRS)(RM)' => $row['TOTALNOLOAD'],
                                  //   'TOTAL GROSS SALES(PRS)(RM)' => $row['TOTALNORMALLOAD']+$row['TOTALLOWLOAD']+$row['TOTALNOLOAD'],
                                    'CUTA+CPRA ANNUAL FEES(UT+PRS)(RM)' => $row['ANNUALFEES'],
                                    'NO. OF UTC' => $row['TOTALUTC'],
                                    'UTC Levy(RM)' => $row['TOTALUTCLEVY'],
                                    'UTC CARD(RM)' => $row['UTCCARDFEE'],
                                    'NO. OF PRC' => $row['TOTALPRC'],
                                    'PRC Levy(RM)' => $row['TOTALPRCLEVY'],
                                    'PRC CARD(RM)' => $row['PRCCARDFEE'],
                                    'TOTAL PAYABLE(RM)' =>  $row['ANNUALFEES']+$row['TOTALUTCLEVY']+$row['UTCCARDFEE']+$row['TOTALPRCLEVY']+$row['PRCCARDFEE'],
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
            "COMPANY"=>array(
               // "label"=>"DISTRIBUTOR",
                "type"=>"string",
                "searchable" => true,
               // "type"=>"datetime",
               // "format"=>"Y-m-d H:i:s",
               // "displayFormat"=>"Y"
              // "footer"=>"sum",
               "footerText"=>"TOTAL",
            ),
            "CATEGORY"=>array(
                // "label"=>"DISTRIBUTOR",
                 "type"=>"string",
                 "searchable" => true,
                // "type"=>"datetime",
                // "format"=>"Y-m-d H:i:s",
                // "displayFormat"=>"Y"
               // "footer"=>"sum",
               // "footerText"=>"<b>TOTAL</b>",
             ),
            "CUTA+CPRA ANNUAL FEES(UT+PRS)(RM)"=>array(
                //"label"=>"TOTAL",
                "type"=>"number",
                "decimals"=>2,
                "cssStyle"=>"text-align:center",
                "footer"=>"sum",
                "footerText"=>"@value",
            ),
            "NO. OF UTC"=>array(
                // "label"=>"PRS-EXAM PASSED",
                 "type"=>"number",
                 "cssStyle"=>"text-align:center",
                 "footer"=>"sum",
                 "footerText"=>"@value",
             ),
             "UTC Levy(RM)"=>array(
                // "label"=>"PRS-VARIATION",
                 "type"=>"number",
                 "decimals"=>2,
                 "cssStyle"=>"text-align:center",
                 "footer"=>"sum",
                 "footerText"=>"@value",
             ),
             "UTC CARD(RM)"=>array(
                 // "label"=>"PRS-VARIATION",
                  "type"=>"number",
                  "decimals"=>2,
                  "cssStyle"=>"text-align:center",
                  "footer"=>"sum",
                  "footerText"=>"@value",
              ),
             "NO. OF PRC"=>array(
                // "label"=>"PRS-EXAM PASSED",
                 "type"=>"number",
                 "cssStyle"=>"text-align:center",
                 "footer"=>"sum",
                 "footerText"=>"@value",
             ),
             "PRC Levy(RM)"=>array(
                // "label"=>"PRS-VARIATION",
                 "type"=>"number",
                 "decimals"=>2,
                 "cssStyle"=>"text-align:center",
                 "footer"=>"sum",
                 "footerText"=>"@value",
             ),
             "PRC CARD(RM)"=>array(
                 // "label"=>"PRS-VARIATION",
                  "type"=>"number",
                  "decimals"=>2,
                  "cssStyle"=>"text-align:center",
                  "footer"=>"sum",
                  "footerText"=>"@value",
              ),
             "TOTAL PAYABLE(RM)"=>array(
                // "label"=>"PRS-VARIATION",
                 "type"=>"number",
                 "decimals"=>2,
                 "cssStyle"=>"text-align:center",
                 "footer"=>"sum",
                 "footerText"=>"@value",
             ),
        ),
    ));
        ?>
    </div>

</div>

