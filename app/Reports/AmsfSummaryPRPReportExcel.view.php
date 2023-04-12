
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
    Report Name : Summary Report Annual Membership Fees/Annual Fee Payment (PRP) Year  <?php echo $this->params["AMSFYEAR"]; ?> - <?php echo $this->params["AMSFYEAREND"]; ?>(IUTA)
    </div>
    <div cell="A2" range="A2:J2"  excelstyle='<?php echo json_encode($styleArray1); ?>' >Report Date:  <?php echo date("d-M-Y h:i:sa"); ?></div>
    <div  cell="A3" range="A3:J3"   excelstyle='<?php echo json_encode($styleArray1); ?>' >Module Name : ANNUAL FEES MODULE</div>
    <div cell="A5"> 
    <?php
     $datacon = $this->dataStore('AMSFSUMMARYPRPREPORT');
     $datatype = $this->dataStore('DISTRIBUTORTYPE');
     $newArrayCon = array();
     $newArrayDept = array();
     $respectiveSchemeNames = array();
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
       
             $newArrayCon[] =  array( 
                                  // 'AMSF YEAR' => $row['AMSF_YEAR'],
                                   'COMPANY' => $row['DIST_NAME'],
                                   'CATEGORY' => implode(' + ', $respectiveSchemeNames),
                                   'TOTAL GROUP A(PRS)(RM)' => $row['TOTALGROUPA'],
                                   'TOTAL GROUP B(PRS)(RM)' => $row['TOTALGROUPB'],
                                 //  'TOTAL NO LOAD C(RM)' => $row['TOTALGROUPC'],
                                   'TOTAL AUM(PRS)' => $row['TOTALGROUPA']+$row['TOTALGROUPB'],
                                   'MEMBERSHIP LEVY(PRS)(RM)' => 50,
                                   'NO. OF PRC' => $row['TOTALPRC'],
                                   'PRC Levy(RM)' => $row['TOTALPRCLEVY'],
                                   'PRC CARD(RM)' => 3.00,
                                   'TOTAL PAYABLE(RM)' =>  50.00+3.00+$row['TOTALPRCLEVY'],
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
            "TOTAL GROUP A(PRS)(RM)"=>array(
                //"label"=>"UTS-EXAM PASSED",
                "type"=>"number",
                "decimals"=>2,
                "cssStyle"=>"dt-body-center",
                "footer"=>"sum",
                "footerText"=>"@value",
            ),
            "TOTAL GROUP B(PRS)(RM)"=>array(
               // "label"=>"UTS-VARIATION",
                "type"=>"number",
                "decimals"=>2,
                "cssStyle"=>"text-align:center",
                "footer"=>"sum",
                "footerText"=>"@value",
            ),
            // "TOTAL NO LOAD C(RM)"=>array(
            //     // "label"=>"UTS-VARIATION",
            //      "type"=>"number",
            //      "decimals"=>2,
            //      "cssStyle"=>"text-align:center",
            //      "footer"=>"sum",
            //      "footerText"=>"<b>@value</b>",
            //  ),
            "TOTAL AUM(PRS)"=>array(
               // "label"=>"UTS-EXEMPTION",
                "type"=>"number",
                "decimals"=>2,
                "cssStyle"=>"text-align:center",
                "footer"=>"sum",
                "footerText"=>"@value",
            ),
            "MEMBERSHIP LEVY(PRS)(RM)"=>array(
                //"label"=>"TOTAL",
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

