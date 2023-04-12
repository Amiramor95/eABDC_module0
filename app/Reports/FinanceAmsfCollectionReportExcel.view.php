
<?php
use \koolreport\excel\Table;
use \koolreport\datagrid\DataTables;
use \koolreport\core\Utility as Util;

    $sheet1 = "Utc Batch Detail";
    $DIST_NAME = "AmBank (M) Berhad";
$this->dataStore("FINANCECOMPANY")->popStart();
while($row = $this->dataStore("FINANCECOMPANY")->pop())
{
    if($row["DISTRIBUTORID"]==$this->params["DISTRIBUTORID"])
    {
        $DIST_NAME =$row["DIST_NAME"];
    }
}
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

     // $data = $this->dataStore('WRITINGCONSULTANTREPORT');
     // foreach($data as $row)
     // {
    ?>
    <div cell="A1" range="A1:J1" excelstyle='<?php echo json_encode($styleArray); ?>'>Company Name : Federation Of Investment Managers Malaysia</div>
    <div cell="A2" range="A2:J2"   excelstyle='<?php echo json_encode($styleArray1); ?>'>Report Name: UTC Batch Details From</div>
    <div cell="A3" range="A3:J3"  excelstyle='<?php echo json_encode($styleArray1); ?>'>Report Date:  <?php echo date("d-M-Y h:i:sa"); ?></div>
    <div cell="A4" range="A4:J4"  excelstyle='<?php echo json_encode($styleArray1); ?>'>Member Name :  <?php echo $DIST_NAME; ?></div>

      <div cell="A6">
      <?php
    $data_queryB = $this->dataStore('FINANCEPRCREPORT');
    $newArray = array();
    foreach($data_queryB as $row)
    {

            $newArray[] =  array(
                                 'BATCH NO.' => "121321", // Later will update
                                 'NAME' => $row['NAME'],
                                 'NRIC' => $row['NRIC'],
                                 'BATCH TYPE' => $row['TYPE_NAME'],
                                 'BATCH DATE' => $row['CREATED_AT'],
                                 'TYPE' => $row['TYPENAME'],
                                 'STATUS' => $row['STATUS'],
                                 'AMOUNT' => $row['AMOUNT'],
                                 'GST(0%)' => $row['GST'],
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
        "BATCH NO."=>array(
            "label"=>"BATCH NO. ",
            "type"=>"string",
            "searchable" => true,
        ),
        "NAME"=>array(
            "label"=>"NAME",
            "type"=>"string",
            "searchable" => true,
        ),
        "NRIC"=>array(
            "label"=>"NRIC",
            "type"=>"string",
            "searchable" => true,
        ),
        "BATCH TYPE"=>array(
            "label"=>"BATCH TYPE",
            "type"=>"string",
            "searchable" => true,
        ),
        "BATCH DATE"=>array(
            "label"=>"BATCH DATE",
            "type"=>"datetime",
            "format"=>"Y-m-d H:i:s",
            "displayFormat"=>"d-M-Y"
        ),
        "TYPE"=>array(
            "label"=>"TYPE",
            "type"=>"string",
            "searchable" => true,
        ),
        "STATUS"=>array(
            "label"=>"STATUS",
            "type"=>"string",
            "searchable" => true,
        ),
        "TYPE"=>array(
            "label"=>"TYPE",
            "type"=>"string",
            "searchable" => true,
        ),
        "AMOUNT"=>array(
          "label"=>"AMOUNT",
          "cssStyle"=>"text-align:right",
          "type"=>"number",
          "format"=>"decimal",
          "decimals"=>2,
          "decimalPoint" => ".",
          "footer"=>"sum",
          //"footerText"=>"<b>Total:</b> @value",
          "footerText"=>"Total :  @value",
        ),
        "GST(0%)"=>array(
            "label"=>"GST(0%)",
            "cssStyle"=>"text-align:right",
            "footer"=>"sum",
            "type"=>"number",
            "format"=>"decimal",
            "decimals"=>2,
            "decimalPoint" => ".",
            "footerText"=>"@value",
        ),
    ),
    "cssClass"=>array(
        "table"=>"table table-bordered table-striped"
    )
]);
?>
    </div>

</div>

