
<?php
use \koolreport\excel\Table;
use \koolreport\datagrid\DataTables;
use \koolreport\core\Utility as Util;

    $sheet1 = "CAS COMPLAIN FIMM";
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
    Report Name : Total number of complaints received by FIMM
    </div>
    <div cell="A2" range="A2:J2"  excelstyle='<?php echo json_encode($styleArray1); ?>' >Report Date:  <?php echo date("d-M-Y h:i:sa"); ?></div>
    <div  cell="A3" range="A3:J3"   excelstyle='<?php echo json_encode($styleArray1); ?>' >Module Name : CONSULTANT ALERT MODULE</div>
    <div cell="A5">
         <?php
         $data_close = $this->dataStore("close_source");
         $data_ongoing = $this->dataStore("ongoing_source");
         $data_main = $this->dataStore("complain_source");
         $ta1 = array();
         $ta2 = array();
         $ta3 = array();
         $dt =array();
         $databyyear = array();
         $databyyearfinal = array();
       foreach ($data_close as $d) {
         array_push($ta1, $d['year']);
             $dt['total1'] = $d['total1'];
             $dt['total2'] = 0;
             $dt['total'] = 0;
             $dt['year_of_complain'] = $d['year'];
             array_push($databyyear, $dt);
       }
       foreach ($data_ongoing as $d1) {
             array_push($ta2, $d1['year1']);
             $dt['total2'] = $d1['total2'];
             $dt['total1'] = 0;
             $dt['total'] = 0;
             $dt['year_of_complain'] = $d1['year1'];
             array_push($databyyear, $dt);
       }
       foreach($data_main as $ta_l){
          array_push($ta3, $ta_l['year_of_complain']);
             if(!in_array($ta_l['year_of_complain'], $ta1)){
             $dt['total1'] = 0;
             }
             if(!in_array($ta_l['year_of_complain'], $ta2)){
             $dt['total2'] = 0;
             }
             $dt['total'] = $ta_l['total'];
             $dt['year_of_complain'] = $ta_l['year_of_complain'];
             array_push($databyyear, $dt);
     }
     $out = array();
     foreach($databyyear as $x){
        // print_r($x['year_of_complain']);
         $out[$x['year_of_complain']]['total'] = 0;
         $out[$x['year_of_complain']]['total1'] = 0;
         $out[$x['year_of_complain']]['total2'] = 0;
     }
     foreach($databyyear as $x){
         // Log::info(print_r($x));
         $out[$x['year_of_complain']]['total'] += $x['total'];
         $out[$x['year_of_complain']]['total1'] += $x['total1'];
         $out[$x['year_of_complain']]['total2'] += $x['total2'];
         $out[$x['year_of_complain']]['year_of_complain'] = $x['year_of_complain'];
     }
    // $finaloutput=array

     $finaloutput = array_values($out);
    // print_r( $finaloutput);
     $newMeta= [];
     $ds = new \koolreport\core\DataStore($finaloutput, $newMeta);
        Table::create(array(
            "dataSource"=>$ds,
            "columns"=>array(
                "year_of_complain"=>array(
                    "label"=>"YEAR",
                   // "type"=>"number",
                   // "searchable" => true,
                    "type"=>"string",
                    //"format"=>"Y-m-d H:i:s",
                   // "displayFormat"=>"Y"
                ),
                "total"=>array(
                  "label"=>"TOTAL COMPLAINTS",
                  "type"=>"number",
                  //"searchable" => true,
                ),
                "total1"=>array(
                    "label"=>"CLOSED",
                    "type"=>"number",
                    //"searchable" => true,
                ),
                "total2"=>array(
                    "label"=>"ON-GOING",
                    "type"=>"number",
                    //"searchable" => true,
                  )
            ),
        ));
        ?>
    </div>

</div>

