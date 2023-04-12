
<?php
use \koolreport\excel\Table;
use \koolreport\datagrid\DataTables;
use \koolreport\core\Utility as Util;

    $sheet1 = "Teaching or Speaking";
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
    <?php 
      $data = $this->dataStore('TEACHINGCONSULTANTREPORT');
      foreach($data as $row)
      {
    ?>
    <div cell="A1" range="A1:J1" excelstyle='<?php echo json_encode($styleArray); ?>'>Name : <?php echo $row['CONSULTANT_NAME']; ?></div>
    <div cell="A2" range="A2:J2"   excelstyle='<?php echo json_encode($styleArray1); ?>'>NRIC : <?php echo $row['CONSULTANT_NRIC']; ?></div>
    <div cell="A3" range="A3:J3"  excelstyle='<?php echo json_encode($styleArray1); ?>'>FIMM NO. : <?php echo $row['CONSULTANT_FIMM_NO']; ?></div>
    <div cell="A4" range="A4:J4"  excelstyle='<?php echo json_encode($styleArray1); ?>'>COMPANY : <?php echo $row['DIST_NAME']; ?></div>
<?php
      }
      $data_max = $this->dataStore('TEACHINGAPPROVEMAX');
      foreach($data_max as $row_max)
      {
        $total_approve_point = $row_max['CPD_MAX'];
      }
      ?>
      <div cell="A6">
<?php
      Table::create([
    "dataSource"=>$this->dataStore('TEACHINGCONSULTANTREPORTDETAIL'),
    "showFooter"=>true,
    "columns"=>array(
        "TITLE"=>array(
            "label"=>"PRESENTATION TITLE",
            "type"=>"string",
            "searchable" => true,
        ),
        "DATE"=>array(
            "label"=>"Date",
            "type"=>"datetime",
            "format"=>"Y-m-d H:i:s",
            "displayFormat"=>"d-M-Y"
        ),
        "APPROVAL_STATUS"=>array(
            "label"=>"APPROVAL STATUS",
            "type"=>"string",
            "searchable" => true,
        ),
        "CPD_POINT"=>array(
          "label"=>"CPD POINT",
          "cssStyle"=>"text-align:right",
          //"prefix"=>"$",
          "footer"=>"sum",
          "footerText"=>"Total: @value",
        //  "footerText"=>"<span style='font-weight:bold;padding-bottom:10px'>Total :  @value</span><br><span style= 'font-weight:bold'>Total Approved CPD Points : $total_approve_point</span>",
        ),
    ),
    "cssClass"=>array(
        "table"=>"table table-bordered table-striped"
    )
]);
?>
    </div>

</div>

