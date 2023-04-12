
<?php
use \koolreport\excel\Table;
//use \koolreport\widgets\koolphp\Table;
use \koolreport\datagrid\DataTables;
use \koolreport\core\Utility as Util;

    $sheet1 = "FEE MANAGEMENT";
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
    Report Name : FEE MANAGEMENT REPORT
    </div>
    <div cell="A2" range="A2:J2"  excelstyle='<?php echo json_encode($styleArray1); ?>' >Report Date:  <?php echo date("d-M-Y h:i:sa"); ?></div>
    <div  cell="A3" range="A3:J3"   excelstyle='<?php echo json_encode($styleArray1); ?>' >Module Name : ADMIN MODULE</div>
    <div cell="A5"> 
      <?php
       $data = $this->dataStore('DISTRIBUTORFEEREPORT');
       $data2 = $this->dataStore('CONSULTANTFEEREPORT');
       $data3 = $this->dataStore('WAIVERFEEREPORT');
      // print_r($data_queryB);
       $newArrayDist = array();
       $newArrayCon = array();
       $newArrayWaiver = array();
       foreach($data as $row)
       {
    
               $newArrayDist[] =  array(
                                    'MODULE' => "DISTRIBUTOR",
                                    'CATEGORY' => $row['CATEGORY'],
                                    'AMOUNT' => $row['AMOUNT'],
                                    'STARTDATE' => $row['STARTDATE'],
                                    'ENDDATE' => $row['ENDDATE'],
                                    'EFFECTIVEDATE' => $row['STARTDATE'],
                                );
       }
       foreach($data2 as $row1)
       {
    
               $newArrayCon[] =  array(
                                    'MODULE' => "CONSULTANT",
                                    'CATEGORY' => $row1['CATEGORY'],
                                    'AMOUNT' => $row1['AMOUNT'],
                                    'STARTDATE' => $row1['STARTDATE'],
                                    'ENDDATE' => $row1['STARTDATE'],
                                    'EFFECTIVEDATE' => $row1['STARTDATE'],
                                );
       }
       foreach($data3 as $row2)
       {
    
               $newArrayWaiver[] =  array(
                                    'MODULE' => "WAIVER",
                                    'CATEGORY' => $row2['CATEGORY'],
                                    'AMOUNT' => $row2['AMOUNT'],
                                    'STARTDATE' => $row2['STARTDATE'],
                                    'ENDDATE' => $row2['ENDDATE'],
                                    'EFFECTIVEDATE' => $row2['STARTDATE'],
                                );
       }
       $newArray = array_merge($newArrayDist,$newArrayCon);
       $finalArray = array_merge($newArray,$newArrayWaiver);
       
        $newMeta= [];
        $ds = new \koolreport\core\DataStore($finalArray, $newMeta);
       // $datastore =  new \koolreport\core\DataStore();
       // $datastore->data($newArray);
        //$datastore->meta($meta); // $meta could be an empty array []
            Table::create([
          "dataSource"=>$ds,
          "showFooter"=>true,
          "columns"=>array(
            "MODULE"=>array(
                "label"=>"MODULE",
                "searchable" => true,
                "type"=>"string",
            ),
            "CATEGORY"=>array(
                "label"=>"CATEGORY",
                "searchable" => true,
                "type"=>"string",
            ),
            "AMOUNT"=>array(
                "label"=>"AMOUNT",
                "type"=>"number",
                "searchable" => true,
                 "cssStyle" =>'text-align:right',
            ),
             "STARTDATE"=>array(
              "label"=>"START DATE",
              "type"=>"datetime",
              "format"=>"Y-m-d H:i:s",
              "displayFormat"=>"Y-m-d"
            ),
            "ENDDATE"=>array(
                "label"=>"END DATE",
                "type"=>"datetime",
                "format"=>"Y-m-d H:i:s",
                "displayFormat"=>"Y-m-d"
              ),
              "EFFECTIVEDATE"=>array(
                "label"=>"EFFECTIVE DATE",
                "type"=>"datetime",
                "format"=>"Y-m-d H:i:s",
                "displayFormat"=>"Y-m-d"
              ),
        ),
          "cssClass"=>array(
              "table"=>"table table-bordered table-striped"
          )
      ]);
  
        ?>
    </div>

</div>

