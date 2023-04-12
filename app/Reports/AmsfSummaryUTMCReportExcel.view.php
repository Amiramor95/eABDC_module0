
<?php
use \koolreport\excel\Table;
use \koolreport\datagrid\DataTables;
use \koolreport\core\Utility as Util;

    $sheet1 = "AMSF AUM";
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
    Report Name : SUMMARY REPORT UTF SUBSCRIPTION FEES FOR YEAR <?php echo $this->params["AMSFYEAR"]; ?> - <?php echo $this->params["AMSFYEAREND"]; ?>(UTMC)
    </div>
    <div cell="A2" range="A2:J2"  excelstyle='<?php echo json_encode($styleArray1); ?>' >Report Date:  <?php echo date("d-M-Y h:i:sa"); ?></div>
    <div  cell="A3" range="A3:J3"   excelstyle='<?php echo json_encode($styleArray1); ?>' >Module Name : ANNUAL FEES MODULE</div>
    <div cell="A5"> 
      <?php
    $datacon = $this->dataStore('AMSFTOTALSUBMISSIONREPORT');
    // echo "<pre>";
    // print_r($datacon);
    // echo "</pre>";
    $newArrayCon = array();
    foreach($datacon as $row)
    {
        $launchdate = "";
        $updatedate = "";
        $contact = "";
        $shasridate = "";
        // if($row['LAUNCHDATE'] != '')
        // {
        //    $launchdate = date("d-M-Y", strtotime($row['LAUNCHDATE']));
        // }
      
            $newArrayCon[] =  array( 
                                 // 'AMSF YEAR' => $row['AMSF_YEAR'],
                                  'COMPANY' => $row['DIST_NAME'],
                                  'TOTAL GROUP A(RM)' => $row['TOTALGROUPA'],
                                  'TOTAL GROUP B(RM)' => $row['TOTALGROUPB'],
                                  'TOTAL AUM(A+B)(RM)' => $row['TOTALGROUPA']+$row['TOTALGROUPB'],
                                  'MEMBERSHIP LEVY(RM)' => 50.00,
                                  'NO. OF UTC' => $row['TOTALUTC'],
                                  'UTC Levy(RM)' => $row['TOTALUTCLEVY'],
                                  'UTC CARD(RM)' => 3.00,
                                  'TOTAL PAYABLE(RM)' => 50.00+3.00+$row['TOTALUTCLEVY'],
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
            "TOTAL GROUP A(RM)"=>array(
                //"label"=>"UTS-EXAM PASSED",
                "type"=>"number",
                "decimals"=>2,
                "cssStyle"=>"dt-body-center",
                "footer"=>"sum",
                "footerText"=>"@value",
            ),
            "TOTAL GROUP B(RM)"=>array(
               // "label"=>"UTS-VARIATION",
                "type"=>"number",
                "decimals"=>2,
                "cssStyle"=>"text-align:center",
                "footer"=>"sum",
                "footerText"=>"@value",
            ),
            "TOTAL AUM(A+B)(RM)"=>array(
               // "label"=>"UTS-EXEMPTION",
                "type"=>"number",
                "decimals"=>2,
                "cssStyle"=>"text-align:center",
                "footer"=>"sum",
                "footerText"=>"@value",
            ),
            "MEMBERSHIP LEVY(RM)"=>array(
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

