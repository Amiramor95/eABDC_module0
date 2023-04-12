
<?php
use \koolreport\excel\Table;
//use \koolreport\widgets\koolphp\Table;
use \koolreport\datagrid\DataTables;
use \koolreport\core\Utility as Util;

    $sheet1 = "User Detail";
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
    <div cell="A1" range="A1:J1" excelstyle='<?php echo json_encode($styleArray); ?>' >Report Name : USER DETAIL
    </div>
    <div cell="A2" range="A2:J2"  excelstyle='<?php echo json_encode($styleArray1); ?>' >Report Date:  <?php echo date("d-M-Y h:i:sa"); ?></div>
    <div  cell="A3" range="A3:J3"   excelstyle='<?php echo json_encode($styleArray1); ?>' >Module Name : ADMIN MODULE</div>
    <div cell="A5"> 
    <?php
    $datadist = $this->dataStore('CONSULTANTUSERDETAIL');
    // $datadistributor = $this->dataStore('DISTRIBUTORUSER');
    // $dataconsultant = $this->dataStore('CONSULTANTUSER');
    // $dataothers = $this->dataStore('OTHERSUSER');
    $newArrayDist = array();
   
  foreach( $datadist as $row){
      if($row['USER_STATUS'] == 0)
      {
          $status = "INACTIVE";
          $cl = "red";
      }
      else if($row['USER_STATUS'] == 1)
      {
          $status = "PENDING";
          $cl = "black";
      }
      else if($row['USER_STATUS'] == 2)
      {
          $status = "APPROVED";
          $cl = "green";
      }
      else{
        $status = "RETURNED";
        $cl = "red";
      }
      $newArrayDist[] =  array(
        'USERID' => $row['USER_ID'],
        'Name' => $row['USER_NAME'],
        'Email' => $row['USER_EMAIL'],
        'Status' =>  $status,
        'COMPANY' =>  $row['COMPANY'],
        'Office No' => $row['PHONE'],
        // 'COUNTRY' => $row['COUNTRY'],
        // 'CITY' => $row['CITY'],
        // 'STATE' => $row['STATE'],
        // 'POSTAL' => $row['POSTAL'],
        // 'ADDRESS' => $row['ADDRESS'],
        'DEPARTMENT' => $row['DPMT_NAME'],
        'DIVISION' => $row['DIV_NAME'],
        'GROUP' => $row['GROUP_NAME'],
        // 'IP ADDRESS' => $row['IP'],
    );


    }
    $newMeta= [];
    $ds = new \koolreport\core\DataStore($newArrayDist, $newMeta);
    Table::create([
          "dataSource"=>$ds,
          "showFooter"=>true,
        //   "columns"=>array(
        //     "MODULE"=>array(
        //         "label"=>"MODULE",
        //         "searchable" => true,
        //         "type"=>"string",
        //     ),
        //     "CATEGORY"=>array(
        //         "label"=>"CATEGORY",
        //         "searchable" => true,
        //         "type"=>"string",
        //     ),
        //     "AMOUNT"=>array(
        //         "label"=>"AMOUNT",
        //         "type"=>"number",
        //         "searchable" => true,
        //          "cssStyle" =>'text-align:right',
        //     ),
        //      "STARTDATE"=>array(
        //       "label"=>"START DATE",
        //       "type"=>"datetime",
        //       "format"=>"Y-m-d H:i:s",
        //       "displayFormat"=>"Y-m-d"
        //     ),
        //     "ENDDATE"=>array(
        //         "label"=>"END DATE",
        //         "type"=>"datetime",
        //         "format"=>"Y-m-d H:i:s",
        //         "displayFormat"=>"Y-m-d"
        //       ),
        //       "EFFECTIVEDATE"=>array(
        //         "label"=>"EFFECTIVE DATE",
        //         "type"=>"datetime",
        //         "format"=>"Y-m-d H:i:s",
        //         "displayFormat"=>"Y-m-d"
        //       ),
        // ),
          "cssClass"=>array(
              "table"=>"table table-bordered table-striped"
          )
      ]);
      ?>
    </div>

</div>

