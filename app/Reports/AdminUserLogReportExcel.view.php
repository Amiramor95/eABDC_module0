
<?php
use \koolreport\excel\Table;
use \koolreport\datagrid\DataTables;
use \koolreport\core\Utility as Util;

    $sheet1 = "List of User";
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
    Report Name : USER LOG
    </div>
    <div cell="A2" range="A2:J2"  excelstyle='<?php echo json_encode($styleArray1); ?>' >Report Date:  <?php echo date("d-M-Y h:i:sa"); ?></div>
    <div  cell="A3" range="A3:J3"   excelstyle='<?php echo json_encode($styleArray1); ?>' >Module Name : ADMIN MODULE</div>
    <div cell="A5"> 
      <?php
       $datafimm = $this->dataStore('FIMMUSERLOG');
       $datadistributor = $this->dataStore('DISTRIBUTORUSERLOG');
       $dataconsultant = $this->dataStore('CONSULTANTUSERLOG');
       $dataothers = $this->dataStore('OTHERSUSERLOG');
       $dataip = $this->dataStore('KEYKLOCKID');
       $newArrayFimm = array();
       $newArrayDistributor = array();
       $newArrayConsultant = array();
       $newArrayOthers = array();
      // $ip = "";
       foreach($datafimm as $row)
       {
           
               $newArrayFimm[] =  array( 
                                    'NAME' => $row['USER_NAME'],
                                    'EMAIL' => $row['USER_EMAIL'],
                                    'COMPANY' => "FIMM",
                                    'LOGINTIME' => $row['LOGINTIME'],
                                    'LOGOUTTIME' => $row['LOGOUTTIME'],
                                );
       }
       foreach($datadistributor as $row1)
       {
           
               $newArrayDistributor[] =  array( 
                                    'NAME' => $row1['USER_NAME'],
                                    'EMAIL' => $row1['USER_EMAIL'],
                                    'COMPANY' => $row1['COMPANY'],
                                    'LOGINTIME' => $row1['LOGINTIME'],
                                    'LOGOUTTIME' => $row1['LOGOUTTIME'],
                                );
       }
       foreach($dataconsultant as $row2)
       {
           //$company = "";
           $newArrayConsultant[] =  array( 
               'NAME' => $row2['USER_NAME'],
               'EMAIL' => $row2['USER_EMAIL'],
               'COMPANY' => $row2['COMPANY'],
               'LOGINTIME' => $row2['LOGINTIME'],
               'LOGOUTTIME' => $row2['LOGOUTTIME'],
           );
       }
       foreach($dataothers as $row3)
       {
           $newArrayOthers[] =  array( 
               'NAME' => $row3['USER_NAME'],
               'EMAIL' => $row3['USER_EMAIL'],
               'COMPANY' => $row3['COMPANY'],
               'LOGINTIME' => $row3['LOGINTIME'],
               'LOGOUTTIME' => $row3['LOGOUTTIME'],
           );
       }
      
        //$newArray = array_merge($newArrayFimm,$newArrayDistributor);
       // $newArray1 = array_merge($newArrayCONSULTANT,$newArrayOthers);
       //$finalArray = array_merge($newArray,$newArray1);
       if($this->params["MODULEID"] == 1)
       {
           $finalArray = $newArrayFimm;
       }
       if($this->params["MODULEID"] == 2)
       {
           $finalArray = $newArrayDistributor;
       }
       if($this->params["MODULEID"] == 3)
       {
           $finalArray = $newArrayConsultant;
       }
       if($this->params["MODULEID"] == 4)
       {
           $finalArray = $newArrayOthers;
       }
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
                "NAME"=>array(
                    "label"=>"NAME",
                   // "type"=>"number",
                    "searchable" => true,
                    "type"=>"string",
                   // "type"=>"datetime",
                   // "format"=>"Y-m-d H:i:s",
                   // "displayFormat"=>"Y"
                ),
                "EMAIL"=>array(
                  "label"=>"EMAIL",
                  "type"=>"string",
                  "searchable" => true,
                ),
                "COMPANY"=>array(
                    "label"=>"COMPANY",
                    "type"=>"string",
                    "searchable" => true,
                ),
                "LOGINTIME"=>array(
                    "label"=>"LOGIN TIME",
                     "type"=>"datetime",
                    "format"=>"Y-m-d H:i:s",
                    "displayFormat"=>"d-M-Y H:i:s"
                ),
                "LOGOUTTIME"=>array(
                    "label"=>"LOGOUT TIME",
                     "type"=>"datetime",
                    "format"=>"Y-m-d H:i:s",
                    "displayFormat"=>"d-M-Y H:i:s"
                  )
            ),
           ),
        ));
        ?>
    </div>

</div>

