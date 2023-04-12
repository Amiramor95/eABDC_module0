
<?php
use \koolreport\excel\Table;
use \koolreport\datagrid\DataTables;
use \koolreport\core\Utility as Util;

    $sheet1 = "Active Consultant";
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
    Report Name : ACTIVE CONSULTANTS SUMMARY REPORT
    </div>
    <div cell="A2" range="A2:J2"  excelstyle='<?php echo json_encode($styleArray1); ?>' >Report Date:  <?php echo date("d-M-Y h:i:sa"); ?></div>
    <div  cell="A3" range="A3:J3"   excelstyle='<?php echo json_encode($styleArray1); ?>' >Module Name : CONSULTANT MANAGEMENT MODULE</div>
    <div cell="A5"> 
      <?php
       $datacon = $this->dataStore('CONSULTANTSUMMARYDISTRIBUTOR');
       $datatype = $this->dataStore('DISTRIBUTORTYPE');
       $datatdual = $this->dataStore('CONSULTANTDUALLICENSE');
       $datatsingleuts = $this->dataStore('CONSULTANTSINGLEUTSLICENSE');
       $newArrayDept = array();
       $newArrayApp = array();
       $newArrayScheme = array();
       $dual = 0;
       foreach($datatype as $row2)
       {
           $newArrayDept[] = array(
                              'DISTID' => $row2['DIST_ID'],
                              'TYPENAME' => $row2['DIST_TYPE_NAME'],
           );
       }
       $newArrayCon = array();
       foreach($datacon as $row)
       {
           $respectiveTypeNames = array();
           $dual = 0;
           $uts = 0;
           $prs = 0;
           foreach($newArrayDept as $dj1){
               if( $dj1['DISTID'] == $row['DISTRIBUTORID']){
                   $respectiveTypeNames[] = $dj1['TYPENAME'];
               }
           }
           // Dual Registration
           foreach($datatdual as $dualobject){
               if( $dualobject['DISTRIBUTOR_ID'] == $row['DISTRIBUTORID']){
                   $dual = $dual+1;
               }
           }
            // Single Registration 
            foreach($datatsingleuts as $singleobject){
               if( $singleobject['DISTRIBUTOR_ID'] == $row['DISTRIBUTORID']){
                   if($singleobject['CONSULTANT_TYPE_ID'] == 1)
                   {
                   $uts = $uts+1;
                   }
                   if($singleobject['CONSULTANT_TYPE_ID'] == 2)
                   {
                   $prs = $prs+1;
                   }
               }
           }
     
               $newArrayCon[] =  array( 
                                    //'ID' => $row['DISTRIBUTORID'],
                                    'DISTRIBUTOR' => $row['DIST_NAME'],
                                    'TYPE' =>  implode(', ', $respectiveTypeNames),
                                    'UTS' => $uts,
                                    'PRS' => $prs,
                                    'DUAL REGISTRATION' => $dual,
                                    'TOTAL' => $uts+$prs+$dual,
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
                "searchable" => true,
                "type"=>"string",
                "footerText"=>"TOTAL",
            ),
            "TYPE"=>array(
            //  "label"=>"TOTAL COMPLAINTS",
              "type"=>"string",
               "searchable" => true,
               "footerText"=>"",
            ),
            "UTS"=>array(
                "type"=>"number",
                "searchable" => true,
                "footer"=>"sum",
                "footerText"=>"@value",
            ),
            "PRS"=>array(
                "type"=>"number",
               "searchable" => true,
               "footer"=>"sum",
               "footerText"=>"@value",
            ),
            "DUAL REGISTRATION"=>array(
                 "type"=>"number",
                "searchable" => true,
                "footer"=>"sum",
                "footerText"=>"@value",
             ),
            "TOTAL"=>array(
                 "type"=>"number",
                "searchable" => true,
                "footer"=>"sum",
                "footerText"=>"@value",
               )
        ),
        ));
        ?>
    </div>

</div>

