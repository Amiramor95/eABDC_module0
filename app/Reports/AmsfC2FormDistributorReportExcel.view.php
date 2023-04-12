
<?php
use \koolreport\excel\Table;
use \koolreport\datagrid\DataTables;
use \koolreport\core\Utility as Util;

    $sheet1 = "PRP";
?>


<div sheet-name="<?php echo $sheet1; ?>">
    <?php
    $styleArray = [
        'font' => [
            'name' => 'Calibri', //'Verdana', 'Arial'
            'size' => 15,
            'bold' => true,
            'text-transform' => 'uppercase',
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
    $datacon = $this->dataStore('AMSFC2FORMREPORT');
    $datadistributor = $this->dataStore('DISTRIBUTORLISTC2');
    $ryear = "";
    $newDate = "";
    $ryear = (int)$this->params['AMSFYEAR']+1;
    $newDate = $ryear ;//date('Y', strtotime($ryear. ' + 1 year'));
    $newArrayCon = array();
    $totalgroupa = 0.00;
    $totalgroupb = 0.00;
    foreach($datadistributor as $row1)
    {
    ?>
    <div cell="A1" range="A1:J1" excelstyle='<?php echo json_encode($styleArray); ?>' >
    FORM C2
    </div>
    <div  cell="A2" range="A2:J2"   excelstyle='<?php echo json_encode($styleArray); ?>' >COMPANY: <?php echo $row1['DIST_NAME'];?></span></div>
    <div cell="A3" range="A3:J3"  excelstyle='<?php echo json_encode($styleArray1); ?>' > Asset Under Management for the Year ended 31 December <?php echo $this->params["AMSFYEAR"]; ?></div>
    
    <?php
    }
    foreach($datacon as $row)
    {

            $newArrayCon[] =  array( 
                                 // 'AMSF YEAR' => $row['AMSF_YEAR'],
                                  'FULL NAME' => $row['FUND_NAME'],
                                   'FUND CATEGORY' => $row['GROUP_ASSET'],
                                   'FUND GROUP' => $row['FUND_GROUP'],
                                   'AUM(RM)' => $row['AUM_AMOUNT'],
                                   'REMARKS' => $row['AUM_REMARKS_MANAGER'],
                             );
    }
     $newMeta= [];
        $ds = new \koolreport\core\DataStore($newArrayCon, $newMeta);
        ?>
<div cell="A5"> 
        <?php
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
           "columns"=>array(
            "FULL NAME"=>array(
               // "label"=>"DISTRIBUTOR",
                "type"=>"string",
                "searchable" => true,
               // "type"=>"datetime",
               // "format"=>"Y-m-d H:i:s",
               // "displayFormat"=>"Y"
              // "footer"=>"sum",
               //"footerText"=>"<b>TOTAL</b>",
            ),
            "FUND CATEGORY"=>array(
                // "label"=>"DISTRIBUTOR",
                 "type"=>"string",
                 "searchable" => true,
                // "type"=>"datetime",
                // "format"=>"Y-m-d H:i:s",
                // "displayFormat"=>"Y"
               // "footer"=>"sum",
               // "footerText"=>"<b>TOTAL</b>",
             ),
             "FUND GROUP"=>array(
                // "label"=>"DISTRIBUTOR",
                 "type"=>"string",
                 "searchable" => true,
                // "type"=>"datetime",
                // "format"=>"Y-m-d H:i:s",
                // "displayFormat"=>"Y"
               // "footer"=>"sum",
                "footerText"=>"TOTAL",
             ),
            "AUM(RM)"=>array(
                //"label"=>"TOTAL",
                "type"=>"number",
                "decimals"=>2,
                "cssStyle"=>"text-align:center",
                "footer"=>"sum",
                "footerText"=>"@value",
            ),
            "REMARKS"=>array(
                // "label"=>"DISTRIBUTOR",
                 "type"=>"string",
                 "searchable" => true,
                // "type"=>"datetime",
                // "format"=>"Y-m-d H:i:s",
                // "displayFormat"=>"Y"
               // "footer"=>"sum",
               // "footerText"=>"<b>TOTAL</b>",
             ),
        ),
          
    ));
    ?>
</div>
</div>

