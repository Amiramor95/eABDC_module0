
<?php
use \koolreport\excel\Table;
//use \koolreport\widgets\koolphp\Table;
use \koolreport\datagrid\DataTables;
use \koolreport\core\Utility as Util;

    $sheet1 = "Calendar MANAGEMENT";
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
    <div cell="A1" range="A1:J1" excelstyle='<?php echo json_encode($styleArray); ?>' >Report Name : CALENDAR MANAGEMENT REPORT
    </div>
    <div cell="A2" range="A2:J2"  excelstyle='<?php echo json_encode($styleArray1); ?>' >Report Date:  <?php echo date("d-M-Y h:i:sa"); ?></div>
    <div  cell="A3" range="A3:J3"   excelstyle='<?php echo json_encode($styleArray1); ?>' >Module Name : ADMIN MODULE</div>
    <div cell="A5"> 
      <?php
        $data_queryB = $this->dataStore('CALENDARREPORT');
        $newArray = array();
        foreach($data_queryB as $row)
        {
    
                $newArray[] =  array(
                                     'YEAR' => $row['YEAR'],
                                     'MONTH' => $row['MONTH'],
                                     'EVENTNAME' => $row['EVENTNAME'],
                                     'STARTDATE' => $row['STARTDATE'],
                                     'ENDDATE' => $row['ENDDATE'],
                                 );
        }
       
        $newMeta= [];
        $ds = new \koolreport\core\DataStore($newArray, $newMeta);
       // $datastore =  new \koolreport\core\DataStore();
       // $datastore->data($newArray);
        //$datastore->meta($meta); // $meta could be an empty array []
            Table::create([
          "dataSource"=>$ds,
          "showFooter"=>true,
          "columns"=>array(
            "YEAR"=>array(
                "label"=>"YEAR",
               // "type"=>"string",
               // "format"=>"Y-m-d H:i:s",
                "displayFormat"=>"Y"
              ),
              "MONTH"=>array(
                "label"=>"MONTH",
               // "type"=>"datetime",
               // "format"=>"m",
                "displayFormat"=>"F"
              ),
            "EVENTNAME"=>array(
                "label"=>"Event Name",
               // "searchable" => true,
                "type"=>"string",
            ),
            "STARTDATE"=>array(
              "label"=>"Start Date",
              "type"=>"datetime",
             // "format"=>"Y-m-d H:i:s",
              "displayFormat"=>"m/d/Y"
            ),
            "ENDDATE"=>array(
                "label"=>"END Date",
                "type"=>"datetime",
               // "format"=>"Y-m-d H:i:s",
               "displayFormat"=>"m/d/Y"
              ),
        ),
          "cssClass"=>array(
              "table"=>"table table-bordered table-striped"
          )
      ]);
  
        ?>
    </div>

</div>

