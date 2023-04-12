
<?php
use \koolreport\excel\Table;
use \koolreport\datagrid\DataTables;
use \koolreport\core\Utility as Util;

    $sheet1 = "Distributor Information";
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
    Report Name : DISTRIBUTOR INFORMATION REPORT
    </div>
    <div cell="A2" range="A2:J2"  excelstyle='<?php echo json_encode($styleArray1); ?>' >Report Date:  <?php echo date("d-M-Y h:i:sa"); ?></div>
    <div  cell="A3" range="A3:J3"   excelstyle='<?php echo json_encode($styleArray1); ?>' >Module Name : DISTRIBUTOR MANAGEMENT MODULE</div>
    <div cell="A5"> 
    <?php
    $datacon = $this->dataStore('DISTRIBUTORINFORMATIONREPORT');
    $datatype = $this->dataStore('DISTRIBUTORTYPE');
    $newArrayCon = array();
    $uts = "";
    $prs = "";
    $consID = array();
    $conPRSID = array();
    $consStatusTag = array();
    $newArrayDept = array();
    $newArrayApp = array();
    $typeStructure = "";
    foreach($datatype as $row2)
    {
        $newArrayDept[] = array(
                           'DISTID' => $row2['DIST_ID'],
                           'TYPENAME' => $row2['DIST_TYPE_NAME'],
        );
    }
    foreach($datacon as $row)
    {
        $respectiveNames = array();
        foreach($newArrayDept as $dj){
            if( $dj['DISTID'] == $row['DID']){
                $respectiveNames[] = $dj['TYPENAME'];
            }
        }
        if($row['DIST_TYPE_STRUCTURE'] == 1)
        {
            $typeStructure = "Single-tier";
        }
        if($row['DIST_TYPE_STRUCTURE'] == 2)
        {
            $typeStructure = "Multi-tier";
        }


            $newArrayCon[] =  array( 
                                 'DISTRIBUTOR INFORMATION-DISTRIBUTOR' => $row['DIST_NAME'],
                                 'DISTRIBUTOR INFORMATION-DISTRIBUTOR CODE' =>  number_format($row['DIST_CODE'],0, '.', ''),
                                 'DISTRIBUTOR INFORMATION-DISTRIBUTOR TYPE' => implode(', ', $respectiveNames),
                                 'DISTRIBUTOR INFORMATION-REGISTRATION NUMBER' => $row['REGNUM'],
                                 'DISTRIBUTOR INFORMATION-BUSINESS ADDRESS' => $row['ADDRESS'],
                                 'DISTRIBUTOR INFORMATION-POSTCODE' => $row['POSTCODE_NO'],
                                 'DISTRIBUTOR INFORMATION-CITY' =>$row['SET_CITY_NAME'],
                                 'DISTRIBUTOR INFORMATION-STATE' => $row['STATE'],
                                 'DISTRIBUTOR INFORMATION-CONTACT NO.' => $row['DIST_MOBILE_NUMBER'],
                                 'DISTRIBUTOR INFORMATION-EMAIL' => $row['DIST_EMAIL'],
                                 'DISTRIBUTOR INFORMATION-FIMM APPROVAL DATE' => "",
                                 'DISTRIBUTOR INFORMATION-COMMENCEMENT DTATE' => "",
                                 'DISTRIBUTOR INFORMATION-ACCOUNT BALANCE' => $row['DIST_ACC_AMOUNT'],
                                 'BUSINESS STRUCTURE-AGENCY STRUCTURE' => $typeStructure,
                                 'BUSINESS STRUCTURE-TOTAL DISTRIBUTOR POINTS' => $row['DIST_NUM_DIST_POINT'],
                                 'COMPANY REPRESENTATIVES-AR' => $row['AR_NAME'],
                                 'COMPANY REPRESENTATIVES-AR SALUTATION' => $row['AR_SALUT'],
                                 'COMPANY REPRESENTATIVES-AR POSITION' => $row['AR_POSITION'],
                                 'COMPANY REPRESENTATIVES-AR CONTACT' => $row['AR_MOBILE_NUMBER'],
                                 'COMPANY REPRESENTATIVES-AR EMAIL' => $row['AR_EMAIL'],
                                 'COMPANY REPRESENTATIVES-AAR' => $row['AAR_NAME'],
                                 'COMPANY REPRESENTATIVES-AAR SALUTATION' => $row['AAR_SALUT'],
                                 'COMPANY REPRESENTATIVES-AAR POSITION' =>  $row['AAR_POSITION'],
                                 'COMPANY REPRESENTATIVES-AAR CONTACT' => $row['AAR_MOBILE_NUMBER'],
                                 'COMPANY REPRESENTATIVES-AAR EMAIL' => $row['AAR_EMAIL'],
                                 'COMPANY REPRESENTATIVES-COMPLIANCE OFFICER' => $row['COM_NAME'],
                                 'COMPANY REPRESENTATIVES-C SALUTATION' => $row['COM_SALUT'],
                                 'COMPANY REPRESENTATIVES-COMPLIANCE OFFICER CONTACT' => $row['COM_MOBILE_NUMBER'],
                                 'COMPANY REPRESENTATIVES-COMPLIANCE OFFICER EMAIL' => $row['COM_EMAIL'],
                                 'COMPANY REPRESENTATIVES-HOD UTS' => $row['UTS_NAME'],
                                 'COMPANY REPRESENTATIVES-HEAD OF D/O UTS SALUTATION' => $row['UTS_SALUT'],
                                 'COMPANY REPRESENTATIVES-HEAD OF D/O UTS CONTACT' => $row['UTS_MOBILE_NUMBER'],
                                 'COMPANY REPRESENTATIVES-HEAD OF D/O UTS EMAIL' =>  $row['UTS_EMAIL'],
                                 'COMPANY REPRESENTATIVES-HOD PRS' => $row['PRS_NAME'],
                                 'COMPANY REPRESENTATIVES-HEAD OF D/O PRS SALUTATION' => $row['PRS_SALUT'],
                                 'COMPANY REPRESENTATIVES-HEAD OF D/O PRS CONTACT' => $row['PRS_MOBILE_NUMBER'],
                                 'COMPANY REPRESENTATIVES-HEAD OF D/O PRS EMAIL' => $row['PRS_EMAIL'],
                                 'COMPANY REPRESENTATIVES-HEAD OF TRAINING' => $row['TRAIN_NAME'],
                                 'COMPANY REPRESENTATIVES-SALUTATION' => $row['TRAIN_SALUT'],
                                 'COMPANY REPRESENTATIVES-HEAD OF TRAINING CONTACT' => $row['TRAIN_MOBILE_NUMBER'],
                                 'COMPANY REPRESENTATIVES-HEAD OF TRAINING EMAIL' => $row['TRAIN_EMAIL'],
                                 'GENERIC INFORMATION-LAST UPDATED' => "",
                                 'GENERIC INFORMATION-UPDATED BY' => "",
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
        //    "columns"=>array(
        //     "DISTRIBUTOR"=>array(
        //        // "label"=>"DISTRIBUTOR",
        //         "type"=>"string",
        //         "searchable" => true,
        //        // "type"=>"datetime",
        //        // "format"=>"Y-m-d H:i:s",
        //        // "displayFormat"=>"Y"
        //       // "footer"=>"sum",
        //        "footerText"=>"TOTAL",
        //     ),
        //     "UTMC"=>array(
        //         //"label"=>"UTS-EXAM PASSED",
        //         "type"=>"number",
        //         "cssStyle"=>"dt-body-center",
        //         "footer"=>"sum",
        //         "footerText"=>"@value",
        //     ),
        //     "PRP"=>array(
        //        // "label"=>"UTS-VARIATION",
        //         "type"=>"number",
        //         "cssStyle"=>"text-align:center",
        //         "footer"=>"sum",
        //         "footerText"=>"@value",
        //     ),
        //     "IUTA"=>array(
        //        // "label"=>"UTS-EXEMPTION",
        //         "type"=>"number",
        //         "cssStyle"=>"text-align:center",
        //         "footer"=>"sum",
        //         "footerText"=>"@value",
        //     ),
        //     "CUTA"=>array(
        //         //"label"=>"TOTAL",
        //         "type"=>"number",
        //         "cssStyle"=>"text-align:center",
        //         "footer"=>"sum",
        //         "footerText"=>"@value",
        //     ),
        //     "CPRA"=>array(
        //        // "label"=>"PRS-EXAM PASSED",
        //         "type"=>"number",
        //         "cssStyle"=>"text-align:center",
        //         "footer"=>"sum",
        //         "footerText"=>"@value",
        //     ),
        //     "IPRA"=>array(
        //        // "label"=>"PRS-VARIATION",
        //         "type"=>"number",
        //         "cssStyle"=>"text-align:center",
        //         "footer"=>"sum",
        //         "footerText"=>"@value",
        //     ),
        // ),
    ));
        ?>
    </div>

</div>

