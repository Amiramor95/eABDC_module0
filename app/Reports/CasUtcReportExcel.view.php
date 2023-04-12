
<?php
use \koolreport\excel\Table;
use \koolreport\datagrid\DataTables;
use \koolreport\core\Utility as Util;

    $sheet1 = "CAS UTC TAGGING";
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
    Report Name : UTC TAGGING LIST REPORT
    </div>
    <div cell="A2" range="A2:J2"  excelstyle='<?php echo json_encode($styleArray1); ?>' >Report Date:  <?php echo date("d-M-Y h:i:sa"); ?></div>
    <div  cell="A3" range="A3:J3"   excelstyle='<?php echo json_encode($styleArray1); ?>' >Module Name : CONSULTANT ALERT MODULE</div>
  
    <div cell="A5">
        <?php
        // $newMeta= [];
        // $ds = new \koolreport\core\DataStore($newArray, $newMeta);
        Table::create(array(
            "dataSource"=>$this->dataStore("CONSULTANTS"),
            "columns"=>array(
                "CONSULTANT_NAME"=>array(
                    "label"=>"NAME",
                    "type"=>"string",
                    "searchable" => true,
                ),
                "CONSULTANT_NRIC"=>array(
                  "label"=>"NRIC NO",
                  "type"=>"string",
                  "searchable" => true,
                ),
                "CONSULTANT_PASSPORT_NO"=>array(
                    "label"=>"PASSPORT NO",
                    "type"=>"string",
                ),
                "TYPE_NAME"=>array(
                    "label"=>"TYPE OF LICENSE",
                    "type"=>"string",
                ),
                "CONSULTANT_FIMM_NO"=>array(
                    "label"=>"FIMM NO",
                    "type"=>"string",
                ),
                "SET_PARAM"=>array(
                    "label"=>"STATUS",
                    "type"=>"string",
                ),
                "DIST_NAME"=>array(
                    "label"=>"COMPANY",
                    "type"=>"string",
                ),
                "START_DATE"=>array(
                    "label"=>"START DATE",
                    "type"=>"datetime",
                    "format"=>"Y-m-d H:i:s",
                   // "displayFormat"=>"d-M-Y"
                ),
                "UPDATE_DATE"=>array(
                    "label"=>"UPDATE/COMPLAINT DATE",
                    "type"=>"datetime",
                    "format"=>"Y-m-d H:i:s",
                    //"displayFormat"=>"d-M-Y"
                ),
            ),
        ));
        ?>
    </div>

</div>

