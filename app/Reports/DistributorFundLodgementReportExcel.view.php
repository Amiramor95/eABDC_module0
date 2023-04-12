
<?php
use \koolreport\excel\Table;
use \koolreport\datagrid\DataTables;
use \koolreport\core\Utility as Util;

    $sheet1 = "Fund Lodgement";
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
    Report Name : FUND LODGEMENT REPORT
    </div>
    <div cell="A2" range="A2:J2"  excelstyle='<?php echo json_encode($styleArray1); ?>' >Report Date:  <?php echo date("d-M-Y h:i:sa"); ?></div>
    <div  cell="A3" range="A3:J3"   excelstyle='<?php echo json_encode($styleArray1); ?>' >Module Name : DISTRIBUTOR MANAGEMENT MODULE</div>
    <div cell="A5"> 
      <?php
    $datacon = $this->dataStore('DISTRIBUTORFUNDLODGEMENTREPORT');
    $datatype = $this->dataStore('DISTRIBUTORTYPE');
    $newArrayDept = array();
    $newArrayApp = array();
    $newArrayExam = array();
   // echo $this->params["dateRange"][0];
    // echo "<pre>";
    // print_r($datacon);
    // echo "<pre>";
    foreach($datatype as $row2)
    {
        $newArrayDept[] = array(
                           'DISTID' => $row2['DIST_ID'],
                           'TYPENAME' => $row2['DIST_TYPE_NAME'],
                           'TYPEID' => $row2['DISTRIBUTOR_TYPE_ID'],
                           'TYPESCHEME' => $row2['TYPE_SCHEME'],
        );
    }
    $newArrayCon = array();
    foreach($datacon as $row)
    {
        $status = "";
        $distributiondate = "";
        $updatedate = "";
        if($row['FUND_NON_MEMBER'] == 0){
            $status = "MEMBER"; 
        }
        if($row['FUND_NON_MEMBER'] == 1){
            $status = "NON MEMBER"; 
        }
        if($row['LODGE_DATE'] != '')
        {
           $distributiondate = date("d-M-Y", strtotime($row['LODGE_DATE'])); 
        }
        if($row['UPDATE_TIMESTAMP'] != '')
        {
           $updatedate = date("d-M-Y", strtotime($row['UPDATE_TIMESTAMP'])); 
        }
         $respectiveNames = array();
         $respectiveScheme ="";
        foreach($newArrayDept as $dj){
            if( $dj['DISTID'] == $row['DISTRIBUTOR_ID']){
                $respectiveNames[] = $dj['TYPENAME'];
                $respectiveScheme = $dj['TYPESCHEME'];
            }
        }
       // echo $row['DIST_TYPE'];
            $newArrayCon[] =  array( 
                                 // 'ID' => $row['DISTRIBUTOR_ID'],
                                  'DISTRIBUTOR' => $row['DIST_NAME'],
                                  'DISTRIBUTOR TYPE' => implode(', ', $respectiveNames),
                                  'SCHEME' =>  $respectiveScheme,
                                  'FUND TYPE' => $status,
                                  'FUND COMPANY' => $row['COMPANY_NAME'],
                                  'FUND NAME' => $row['FUND_NAME'],
                                  'DISTRIBUTION DATE' => $distributiondate,
                                  'LAST UPDATED' => $updatedate,
                                  'UPDATED BY' => "",
                             );
    }
        $newMeta= [];
        $ds = new \koolreport\core\DataStore($newArrayCon, $newMeta);
        Table::create(array(
            "dataSource"=>$ds,
            "complexHeaders" => true,
            "headerSeparator" => "-",
            "showFooter"=>true,
            "options"=>array(
                "order"=>array(
                   array(0,"desc"), //Sort by first column desc
                  // array(1,"asc"), //Sort by second column asc
               ),
           ),
          
    ));
        ?>
    </div>

</div>

