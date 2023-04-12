
<?php
use \koolreport\excel\Table;
use \koolreport\datagrid\DataTables;
use \koolreport\core\Utility as Util;

    $sheet1 = "FUND DATA ALL";
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
    Report Name : FUND DATA - ALL REPORT
    </div>
    <div cell="A2" range="A2:J2"  excelstyle='<?php echo json_encode($styleArray1); ?>' >Report Date:  <?php echo date("d-M-Y h:i:sa"); ?></div>
    <div  cell="A3" range="A3:J3"   excelstyle='<?php echo json_encode($styleArray1); ?>' >Module Name : FUND MANAGEMENT MODULE</div>
    <div cell="A5"> 
    <?php
   $datacon = $this->dataStore('FUNDDATAALLREPORT');
   $newArrayCon = array();
   foreach($datacon as $row)
   {
       $launchdate = "";
       $updatedate = "";
       $maturitydate = "";
       $suspendeddate = "";
       $changedate = "";
       $revocationdate = "";
       $srieffectivedate = "";
       $nonmember = "";
       if($row['LAUNCHDATE'] != '')
       {
          $launchdate = date("d-M-Y", strtotime($row['LAUNCHDATE']));
       }
       if($row['FUND_MATURITY_CLOSURE_DATE'] != '')
       {
          $maturitydate = date("d-M-Y", strtotime($row['FUND_MATURITY_CLOSURE_DATE']));
       }
       if($row['FUND_SUSPENSION_DATE'] != '')
       {
          $suspendeddate = date("d-M-Y", strtotime($row['FUND_SUSPENSION_DATE']));
       }
       if($row['FUND_NAME_CHANGE_DATE'] != '')
       {
          $changedate = date("d-M-Y", strtotime($row['FUND_NAME_CHANGE_DATE']));
       }
       if($row['FUND_REACTIVATION_DATE'] != '')
       {
          $revocationdate = date("d-M-Y", strtotime($row['FUND_REACTIVATION_DATE']));
       }
       if($row['FUND_DATE_SRI_ESG_EFFECTIVE_DATE'] != '')
       {
          $srieffectivedate = date("d-M-Y", strtotime($row['FUND_DATE_SRI_ESG_EFFECTIVE_DATE']));
       }
       if($row['FUND_NON_MEMBER'] == 0)
       {
           $nonmember = "MEMBER COMPANY";
       }
       if($row['FUND_NON_MEMBER'] == 1)
       {
           $nonmember = "THIRD PARTY";
       }
           $newArrayCon[] =  array( 
                                // 'ID' => $row['DISTRIBUTOR_ID'],
                                 'MANAGEMENT COMPANY' => $row['DIST_NAME'],
                                 'USER' => $row['USER_NAME'],
                                 'USER GROUP' => $row['GROUPNAME'],
                                 'FIMM  CODE' => $row['FUND_CODE_FIMM'],
                                 'UMBRELLA  CODE' => $row['UMBRELLACODE'],
                                 'MEMBER  CODE' => $row['MEMBERCODE'],
                                 'NAME' => $row['FUND_NAME'],
                                 'NAME FORMER' => $row['FORMERNAME'],
                                 'NAME SHORT' => $row['SHORTNAME'],
                                 'NAME CHINESE' => $row['CHINESENAME'],
                                 'FUND STATUS' => $row['TS_PARAM'],
                                 'FUND TYPE' => $row['FUNDTYPE'],
                                 'FUND CATEGORY' => $row['GROUP_ASSET'],
                                 'FUND DOMICILE' => $row['FUND_DOMICILE_NAME'],
                                 'FUND EXPIRY DATE' => $row['FUND_DATE_EXPIRY'],
                                 'FUND CURRENCY' => $row['CURRENCY'],
                                 'FUND SUB MANAGER' => $row['FUND_SUB_MANAGER'],
                                 'FUND SHARIAH COMP' => $row['FUND_SYARIAH_COMP'],
                                 'FUND ANNUAL MGMT' => $row['FUND_ANNUAL_MGMT'],
                                 'FUND PERFORMANCE' => $row['FUND_FUND_PERFORMANCE'],
                                 'FUND STATUS EPF' => $row['FUND_STATUS_EPF'],
                                 'FUND EPF CODE' => $row['FUND_EPF_CODE'],
                                 'FUND DAILY NAV' => $row['FUND_DAILY_NAV'],
                                 'FUND FEE ANNUAL' => $row['FUND_FEE_ANNUAL'],
                                 'FUND FEE PERFORMANCE' => $row['FUND_FEE_PERFORMANCE'],
                                 'FUND STATUS RATIO' => $row['FUND_STATUS_RATIO'],
                                 'FUND RATIO' => $row['FUND_RATIO'],
                                 'FUND HURDLE' => $row['FUND_HURDLE'],
                                 'FUND HURDLE STATUS' => $row['FUND_HURDLE_STATUS'],
                                 'FUND HURDLE STATUS RATE' => $row['FUND_STATUS_HURDLE_RATE'],
                                 'FUND PRICE PERUNIT' => $row['FUND_PRICE_PERUNIT'],
                                 'LAUNCH DATE' => $launchdate,
                                 'FUND END YEAR' => $row['FUND_YEAR_END'],
                                 'FUND SALES CHARGE' => $row['FUND_SALES_CHARGE'],
                                 'FUND SCHEME' => $row['FMS_SCHEME_NAME'],
                                 'FUND FOCUS' => $row['FUND_FOCUS'],
                                 'FUND WHOLESALE' => $row['FUND_WHOLESALE'],
                                 'FUND FEEDER' => $row['FUND_FEEDER'],
                                 'FUND FEEDER STATUS' => $row['FUND_FEEDER_STATUS'],
                                 'FUND ISIN' => $row['FUND_ISIN'],
                                 'FUND SC CODE' => $row['FUND_SC_CODE'],
                                 'FUND LIPPER CODE' => $row['FUND_LIPPER_CODE'],
                                 'FUND NAME CHANGE DATE' => $changedate,
                                 'FUND STATUS MER' => $row['FUND_STATUS_MER'],
                                 'FUND MER' => $row['FUND_MER'],
                                 'FUND PERFORMANCE FEE STATUS' => $row['FUND_PERFORMANCE_FEE_STATUS'],
                                 'MATURITY/CLOSURE DATE' => $maturitydate,
                                 'SUSPENDED DATE' => $suspendeddate,
                                 'REVOCATION DATE' => $revocationdate,
                                 'FINANCIAL YEAR END' => $row['FUND_FINANCIAL_YEAR_END'],
                                 'FUND STATUS ANNUAL MGMT' => $row['FUND_STATUS_ANNUAL_MGMT'],
                                 'FUND STATUS FEE PERFORMANCE' => $row['FUND_STATUS_FEE_PERFORMANCE'],
                                 'FUND NOTES ID' => $row['FUND_NOTES_ID'],
                                 'FUND STATUS SALE CHARGE' => $row['FUND_STATUS_SALE_CHARGE'],
                                 'FUND STATUS MIN SALE CHARGE' => $row['FUND_STATUS_MINIMUM_SALE_CHARGE'],
                                 'FUND STATUS MAX SALE CHARGE' => $row['FUND_STATUS_MAXIMUM_SALE_CHARGE'],
                                 'FUND MIN SALE CHARGE' => $row['FUND_MINIMUM_SALE_CHARGE'],
                                 'FUND MAX SALE CHARGE' => $row['FUND_MAXIMUM_SALE_CHARGE'],
                                 'UNIT STRUCTURE' => $row['FUND_UNIT_STRUCTURE'],
                                 'INVESTMENT FOCUS' => $row['FUND_INVESTMENT_FOCUS'],
                                 'FOF STATUS' => $row['FUND_FOF_STATUS'],
                                 'FUND FOF' => $row['FUND_FOF'],
                                 'UCITS STATUS' => $row['FUND_UCITS_STATUS'],
                                 'UCITS' => $row['FUND_UCITS'],
                                 'ASEAN CIS STATUS' => $row['FUND_ASEAN_CIS_STATUS'],
                                 'ASEAN CIS' => $row['FUND_ASEAN_CIS'],
                                 'STATUS SRI/ESG' => $row['FUND_STATUS_SRI_ESG'],
                                 'SRI/ESG' => $row['FUND_SRI_ESG'],
                                 'SRI/ESG EFFECTIVE DATE' => $srieffectivedate,
                                 'FUND NON MEMBER' => $nonmember,
                                 'FUND DEFINITION' => $row['FUND_DEFINITION'],
                                 'FUND UNITS' => $row['FUND_UNITS'],
                                 'CREATETIME' => $row['CREATE_TIMESTAMP'],
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

