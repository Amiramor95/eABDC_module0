
<?php
use \koolreport\excel\Table;
//use \koolreport\widgets\koolphp\Table;
use \koolreport\datagrid\DataTables;
use \koolreport\core\Utility as Util;

    $sheet1 = "USER MATRIX";
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
    <div cell="A1" range="A1:J1" excelstyle='<?php echo json_encode($styleArray); ?>' >Report Name : USER MATRIX AUTHORIZATION REPORT
    </div>
    <div cell="A2" range="A2:J2"  excelstyle='<?php echo json_encode($styleArray1); ?>' >Report Date:  <?php echo date("d-M-Y h:i:sa"); ?></div>
    <div  cell="A3" range="A3:J3"   excelstyle='<?php echo json_encode($styleArray1); ?>' >Module Name : ADMIN MODULE</div>
    <div cell="A5"> 
      <?php
        $dataModule = $this->dataStore('USERMATRIXMODULE');
        $dataProcessFlow = $this->dataStore('USERMATRIXREPORT');
        $dataDepartMent = $this->dataStore('USERMATRIXDEPART');
        $dataAuth = $this->dataStore('USERMATRIXAUTHORIZATION');
        $newArray = array();
        $depArray = array();
        $newProcessArray = array();
        $authLevel = [];
        $myVariable;
    
        foreach($dataAuth as $key => $value){
           ${"authLevel$key"} = "";
           ${"authLevelData$key"} = "";
        }
        
        foreach($dataProcessFlow as $rowProcess)
        {
            foreach($dataDepartMent as $key => $value){
                ${"authLevel$key"} =  $value['AUTHORIZATION_LEVEL_NAME'].':'.$value['DPMT_SNAME'];
    
                $decoded_json = json_decode($value['MANAGE_SCREEN_ID'], false);
                if (in_array($rowProcess['MANAGE_SCREEN_ID'],  $decoded_json )) {
                   // echo "Got =" . $rowProcess['PROCESS_FLOW_ID'];
                    ${"authLevelData$key"} = 'O';
                }else{
                    ${"authLevelData$key"} = 'X';
                }
            }
            $newProcessArray[] =  array(
                'MODULE' => $rowProcess['MOD_SNAME'],
                'PROCESS' => $rowProcess['PROCESS_FLOW_NAME'],
               $authLevel0 => $authLevelData0,
               $authLevel1 => $authLevelData1,
               $authLevel2 => $authLevelData2,
               $authLevel3 => $authLevelData3,
               $authLevel4 => $authLevelData4,
               $authLevel5 => $authLevelData5,
               $authLevel6 => $authLevelData6,
               $authLevel7 => $authLevelData7,
               $authLevel8 => $authLevelData8,
               $authLevel9 => $authLevelData9,
               $authLevel10 => $authLevelData10,
               $authLevel11 => $authLevelData11,
               $authLevel12 => $authLevelData12,
               $authLevel13 => $authLevelData13,
               $authLevel14 => $authLevelData14,
            );
        }
       
        $newMeta= [];
        $ds = new \koolreport\core\DataStore($newProcessArray, $newMeta);
       // $datastore =  new \koolreport\core\DataStore();
       // $datastore->data($newArray);
        //$datastore->meta($meta); // $meta could be an empty array []
            Table::create([
          "dataSource"=>$ds,
         // "showFooter"=>true,
         "removeDuplicate"=>array("MODULE"),
          "cssClass"=>array(
              "table"=>"table table-bordered table-striped"
          )
      ]);
  
        ?>
    </div>

</div>

