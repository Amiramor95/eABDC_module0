
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
    $datacon = $this->dataStore('AMSFB1FORMREPORT');
    $datadistributor = $this->dataStore('DISTRIBUTORLIST');
    $datatype = $this->dataStore('DISTRIBUTORTYPE');
    $ryear = "";
    $newDate = "";
    $ryear = (int)$this->params['AMSFYEAR']+1;
    $newDate = $ryear ;//date('Y', strtotime($ryear. ' + 1 year'));
    $newArrayCon = array();
    $totalnormal = 0.00;
    $totallow = 0.00;
    $totalno = 0.00;
    foreach($datatype as $obj)
    {
        $newArrayDept[] = array(
            'DISTID' => $obj['DIST_ID'],
           // 'TYPENAME' => $obj['DIST_TYPE_NAME'],
           // 'DIST_TYPE' => $obj['DIST_TYPE'],
        );
    }
    foreach($datacon as $row)
    {
       // echo "enter";
        $totalnormal = $row['TOTAL_NORMAL'];
        $totallow = $row['TOTAL_LOW'];
        $totalno = $row['TOTAL_NO'];
    }
    foreach($datadistributor as $row1)
    {
    ?>
    <div cell="A1" range="A1:J1" excelstyle='<?php echo json_encode($styleArray); ?>' >
    FORM A1
    </div>
    <div cell="A2" range="A2:J2"  excelstyle='<?php echo json_encode($styleArray1); ?>' > Total Gross Sales for the Year ended 31 December <?php echo $this->params["AMSFYEAR"]; ?></div>
    <div  cell="A3" range="A3:J3"   excelstyle='<?php echo json_encode($styleArray); ?>' >COMPANY: <?php echo $row1['DIST_NAME'];?></span></div>
    <div cell="A4" range="A4:J4"> Please send the completed slip to FIMM latest By 15 January <?php echo $newDate;?>
    </div>
    <?php
    }
    ?>
    <div cell="A6" range="A6:Z6">We hereby declare the below information of the Total Gross Sales(TGS) for Unit Trust Schemes as at 31 December <?php echo $this->params["AMSFYEAR"]; ?> are complete, true and accurate.</div>
    <div cell="C8" range="C8:L8">Total Normal Load : RM <?php echo number_format((float)$totalnormal, 2, '.', ''); ?></div>
    <div cell="C10" range="C10:L10">Total Low Load : RM <?php echo number_format((float)$totallow, 2, '.', ''); ?></div>
    <div cell="C12" range="C12:L12">Total No Load : RM <?php echo number_format((float)$totalno, 2, '.', ''); ?></div>


</div>

