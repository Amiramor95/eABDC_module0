
<?php
use \koolreport\excel\Table;
use \koolreport\datagrid\DataTables;
use \koolreport\core\Utility as Util;

    $sheet1 = "APPROVAL REPORT";
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
    Report Name : APPROVAL REPORT
    </div>
    <div cell="A2" range="A2:J2"  excelstyle='<?php echo json_encode($styleArray1); ?>' >Report Date:  <?php echo date("d-M-Y h:i:sa"); ?></div>
    <div  cell="A3" range="A3:J3"   excelstyle='<?php echo json_encode($styleArray1); ?>' >Module Name : ADMIN MODULE</div>
    <div cell="A5"> 
      <?php
      $dataapproval = $this->dataStore('APPROVALREPORT');
      $newArrayApproval = array();
      $newArrayDistributor = array();
      $newArrayConsultant = array();
      $newArrayOthers = array();
     // $ip = "";
      foreach($dataapproval as $row)
      {
         $status="";
         if($row['APPR_STATUS'] == 0) 
         {
          $status = 'ON'; 
         }
         else{
          $status = 'OFF';  
         }
              $newArrayApproval[] =  array( 
                                      'DIVISION' => $row['DIV_NAME'],
                                      'DEPARTMENT' => $row['DPMT_NAME'],
                                      'MODULE' => $row['MOD_NAME'],
                                      'GROUP' => $row['GROUP_NAME'],
                                   'APPROVAL LEVEL' => $row['APPR_LEVEL_NAME'],
                                   'AUTHORIZATION' => $row['PROCESS_FLOW_NAME'],
                                   'STATUS' => $status,
                                   'DATE' => $row['CREATE_TIMESTAMP'],
                               );
      }
     
     
       //$newArray = array_merge($newArrayFimm,$newArrayDistributor);
      // $newArray1 = array_merge($newArrayCONSULTANT,$newArrayOthers);
      //$finalArray = array_merge($newArray,$newArray1);
     
          $finalArray = $newArrayApproval;
        $newMeta= [];
        $ds = new \koolreport\core\DataStore($finalArray, $newMeta);
        Table::create(array(
            "dataSource"=>$ds,
            "options"=>array(
                "order"=>array(
                   array(3,"desc"), //Sort by first column desc
                  // array(1,"asc"), //Sort by second column asc
               ),
               "columns"=>array(
                "DIVISION"=>array(
                    "label"=>"DIVISION",
                   // "type"=>"number",
                    "searchable" => true,
                    "type"=>"string",
                   // "type"=>"datetime",
                   // "format"=>"Y-m-d H:i:s",
                   // "displayFormat"=>"Y"
                ),
                "DEPARTMENT"=>array(
                  "label"=>"DEPARTMENT",
                  "type"=>"string",
                  "searchable" => true,
                ),
                "MODULE"=>array(
                    "label"=>"MODULE",
                    "type"=>"string",
                    "searchable" => true,
                ),
                "GROUP"=>array(
                    "label"=>"GROUP",
                    "type"=>"string",
                    "searchable" => true,
                ),
                "APPROVAL LEVEL"=>array(
                    "label"=>"APPROVAL LEVEL",
                    "type"=>"string",
                    "searchable" => true,
                ),
                "AUTHORIZATION"=>array(
                    "label"=>"AUTHORIZATION",
                    "type"=>"string",
                    "searchable" => true,
                ),
                "STATUS"=>array(
                    "label"=>"STATUS",
                    "type"=>"string",
                    "searchable" => true,
                ),
                "DATE"=>array(
                    "label"=>"DATE",
                     "type"=>"datetime",
                    "format"=>"Y-m-d H:i:s",
                    "displayFormat"=>"d-M-Y"
                )
               
            ),
           ),
        ));
        ?>
    </div>

</div>

