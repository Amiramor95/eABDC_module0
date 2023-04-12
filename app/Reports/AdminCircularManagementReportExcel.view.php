
<?php
use \koolreport\excel\Table;
//use \koolreport\widgets\koolphp\Table;
use \koolreport\datagrid\DataTables;
use \koolreport\core\Utility as Util;

    $sheet1 = "CIRCULAR MANAGEMENT";
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
    Report Name : CIRCULAR MANAGEMENT REPORT
    </div>
    <div cell="A2" range="A2:J2"  excelstyle='<?php echo json_encode($styleArray1); ?>' >Report Date:  <?php echo date("d-M-Y h:i:sa"); ?></div>
    <div  cell="A3" range="A3:J3"   excelstyle='<?php echo json_encode($styleArray1); ?>' >Module Name : ADMIN MODULE</div>
    <div cell="A5"> 
      <?php
        $data = $this->dataStore('CIRCULARREPORT');
        $data2 = $this->dataStore('DISTRIBUTORTYPELIST');
   // $data3 = $this->dataStore('WAIVERFEEREPORT');
   // print_r($data_queryB);
    $newArrayDist = array();
    $newArrayDept = array();
    $newArrayWaiver = array();
    $status="";
    $categoryname=array();
    foreach($data2 as $row2)
    {
        $newArrayDept[] = array(
                           'TYPENAME' => $row2['DIST_TYPE_NAME'],
                           'TYPEID' => $row2['DISTRIBUTOR_TYPE_ID'],
        );
    }
        foreach($data as $row)
        {
            $decoded_json = json_decode($row['CATEGORY'], false);
           $respectiveNames = array();
           if(isset($decoded_json) && sizeof($decoded_json) > 0){
               foreach($decoded_json as $de){
                   foreach($newArrayDept as $dj){
                       if( $dj['TYPEID'] == $de){
                           $respectiveNames[] = $dj['TYPENAME'];
                       }
                   }
               }
           }
            if($row['STATUS'] == 1){
                $status = "PENDING FOR HOD APPROVAL";
              }else if($row['STATUS'] == 2){
                $status = "PENDING FOR GM APPROVAL";
              }else if($row['STATUS'] == 3){
                $status =  "RETURN BY HOD";
              }else if($row['STATUS'] == 4){
                $status = "APPROVED BY GM";
              }else if($row['STATUS'] == 5){
                $status = "RETURN BY GM";
              }else if($row['STATUS'] == 6){
                $status = "REJECTED";
              }else{
                $status = "DRAFT";
              }
            //  echo $status;
     
                $newArrayDist[] =  array(
                                     'DEPARTMENT' => $row['DNAME'],
                                     'CATEGORY' => implode(', ', $respectiveNames),
                                     'ETITLE' => $row['EVENT_TITLE'],
                                     'STARTDATE' => $row['STARTDATE'],
                                     'ENDDATE' => $row['ENDDATE'],
                                     'YEAR' => $row['YEAR'],
                                     'MONTH' => $row['MONTH'],
                                     'CUSER' => $row['CUSER'],
                                     'STATUS' => $status,
                                 );
        }
       
        $newMeta= [];
        $ds = new \koolreport\core\DataStore($newArrayDist, $newMeta);
       // $datastore =  new \koolreport\core\DataStore();
       // $datastore->data($newArray);
        //$datastore->meta($meta); // $meta could be an empty array []
            Table::create([
          "dataSource"=>$ds,
          "showFooter"=>true,
          "columns"=>array(
            "DEPARTMENT"=>array(
                "label"=>"DEPARTMENT",
                "searchable" => true,
                "type"=>"string",
            ),
            "CATEGORY"=>array(
                "label"=>"CATEGORY",
                "searchable" => true,
                "type"=>"string",
            ),
            "ETITLE"=>array(
                "label"=>"CIRCULAR",
                "type"=>"string",
                "searchable" => true,
                // "cssStyle" =>'text-align:right',
            ),
             "STARTDATE"=>array(
              "label"=>"PUBLISH DATE",
              "type"=>"datetime",
              "format"=>"Y-m-d H:i:s",
              "displayFormat"=>"Y-m-d"
            ),
            // "ENDDATE"=>array(
            //     "label"=>"END DATE",
            //     "type"=>"datetime",
            //     "format"=>"Y-m-d H:i:s",
            //     "displayFormat"=>"Y-m-d"
            //   ),
            "YEAR"=>array(
                "label"=>"YEAR",
                "type"=>"datetime",
                "format"=>"Y",
                "displayFormat"=>"Y"
              ),
              "MONTH"=>array(
                "label"=>"MONTH",
                "type"=>"datetime",
                "format"=>"m",
                "displayFormat"=>"F"
              ),
              "CUSER"=>array(
                "label"=>"SUBMITTED USER",
                "searchable" => true,
                "type"=>"string",
            ),
            "STATUS"=>array(
                "label"=>"APPROVE BY",
                "searchable" => true,
                "type"=>"string",
            ),
        ),
          "cssClass"=>array(
              "table"=>"table table-bordered table-striped"
          )
      ]);
  
        ?>
    </div>

</div>

