
<?php
use \koolreport\excel\Table;
use \koolreport\datagrid\DataTables;
use \koolreport\core\Utility as Util;

    $sheet1 = "Audit Trail";
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
    Report Name : AUDIT TRAIL REPORT
    </div>
    <div cell="A2" range="A2:J2"  excelstyle='<?php echo json_encode($styleArray1); ?>' >Report Date:  <?php echo date("d-M-Y h:i:sa"); ?></div>
    <div  cell="A3" range="A3:J3"   excelstyle='<?php echo json_encode($styleArray1); ?>' >Module Name : FUND MANAGEMENT MODULE</div>
    <div cell="A5"> 
    <?php
     $datacon = $this->dataStore('FUNDAUDITTRAILREPORT');
     $newArrayCon = array();
     foreach($datacon as $row)
     {
         $launchdate = "";
         $updatedate = "";
         $st = "";
         $user = "";
         $user1 = "";
         // if($row['LAUNCHDATE'] != '')
         // {
         //    $launchdate = date("d-M-Y", strtotime($row['LAUNCHDATE'])); 
         // }
         // if($row['FUND_MATURITY_CLOSURE_DATE'] != '')
         // {
         //    $updatedate = date("d-M-Y", strtotime($row['FUND_MATURITY_CLOSURE_DATE'])); 
         // }
         if($row['STATUS'] == 1)
         {
             $st = "APPROVED";
         }
         else{
             $st = "PENDING";
         }
         if($row['DIST_ID'] == '')
         {
             $user = $row['USER_NAME'];
         }
         else{
             $user1 = $row['USER_NAME1']; 
         }
         $tr = "";
         $tr1 = "";
         if( $row['NEW_VALUES'] != [])
         {
            $jsondata = json_decode( $row['NEW_VALUES'],true) ?? [];
            foreach($jsondata as $attribute => $value)
            {
                $tr .= "<tr><td><b>" .$attribute . "</b></td><td>".$value ."</td></tr>";
            }
           
           $table = '<table class="table table-bordered table-hover" style="width:100%;display:inline-block">'. $tr .'</table>';
         
         }
         if( $row['OLD_VALUES'] != [])
         {
            $jsondata1 = json_decode( $row['OLD_VALUES'],true) ?? [];
            foreach($jsondata1 as $attribute1 => $value1)
            {
                $tr1 .= "<tr><td><b>" .$attribute1 . "</b></td><td>".$value1 ."</td></tr>";
            }
           
           $table1 = '<table class="table table-bordered table-hover" style="width:100%;display:inline-block">'. $tr1 .'</table>';
         
         }
             $newArrayCon[] =  array( 
                                  // 'ID' => $row['DISTRIBUTOR_ID'],
                                   'OLD RECORD' => $table1,
                                   'NEW RECORD' => $table,
                                   'STATUS' => $st,
                                   'APPROVAL USER(MEMBER)' => $user1,
                                   'APPROVAL DATE' => $row['UPDATED_AT'],
                                   'MANAGEMENT COMPANY' => $row['DIST_NAME'],
                                   'APPROVAL USER(FIMM)' => $user,
                                   'APPROVAL DATE FIMM' => $row['UPDATED_AT'],
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
        //    "columns"=>array(
        //     "OLD RECORD"=>array(
        //         "label"=>"OLD RECORD",
        //         "type"=>"string",
        //         "searchable" => true,
        //        // "type"=>"datetime",
        //        // "format"=>"Y-m-d H:i:s",
        //        // "displayFormat"=>"Y"
        //       // "footer"=>"sum",
        //       // "footerText"=>"<b>TOTAL</b>",
        //     ),
        //     "NEW RECORD"=>array(
        //         "label"=>"NEW RECORD",
        //         "type"=>"string",
        //         //"cssStyle"=>"dt-body-center",
        //        // "footer"=>"sum",
        //        // "footerText"=>"<b>@value</b>",
        //     ),
        //     "STATUS"=>array(
        //         "label"=>"STATUS",
        //         "type"=>"string",
        //        // "cssStyle"=>"text-align:center",
        //        // "footer"=>"sum",
        //         //"footerText"=>"<b>@value</b>",
        //     ),
        //     "APPROVAL USER(MEMBER)"=>array(
        //         "label"=>"APPROVAL USER(MEMBER)",
        //         "type"=>"string",
        //         //"cssStyle"=>"text-align:center",
        //        // "footer"=>"sum",
        //        // "footerText"=>"<b>@value</b>",
        //     ),
        //     "APPROVAL DATE"=>array(
        //         "label"=>"APPROVAL DATE",
        //         "type"=>"datetime",
        //         "format"=>"Y-m-d H:i:s",
        //         "displayFormat"=>"M-d-Y"
        //     ),
        //     "MANAGEMENT COMPANY"=>array(
        //         "label"=>"MANAGEMENT COMPANY",
        //         "type"=>"string",
        //        // "cssStyle"=>"text-align:center",
        //        // "footer"=>"sum",
        //        // "footerText"=>"<b>@value</b>",
        //     ),
        //     "APPROVAL USER(FIMM)"=>array(
        //         "label"=>"APPROVAL USER(FIMM)",
        //         "type"=>"string",
        //         //"cssStyle"=>"text-align:center",
        //         //"footer"=>"sum",
        //         //"footerText"=>"<b>@value</b>",
        //     ),
        //     "APPROVAL DATE FIMM"=>array(
        //         "label"=>"APPROVAL DATE FIMM",
        //         "type"=>"datetime",
        //         "format"=>"Y-m-d H:i:s",
        //         "displayFormat"=>"M-d-Y"
        //     ),
        // ),
    ));
        ?>
    </div>

</div>

