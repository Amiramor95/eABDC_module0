<?php
use \koolreport\widgets\koolphp\Table;
use \koolreport\inputs\Select2;
use \koolreport\inputs\DateRangePicker;
use \koolreport\datagrid\DataTables;
use \koolreport\core\Utility as Util;
use \koolreport\inputs\CheckBoxList;
?>
<style>
    body{
        background-color: #fff !important;
    }
    .dataTables_paginate.paging_input {
        padding: 0 !important;
    }
    .dataTables_info,
    .dataTables_paginate.paging_input span,
    .dataTables_length label,
    .dataTables_filter label {
        padding-top: 5px !important;
        padding-bottom: 5px !important;
    }
    .dataTables_length label,
    .dataTables_filter label {
        margin: 0 20px !important;
    }
    .dt-buttons{
        float: right;
    }
    
    .dataTables_wrapper{
        margin-top: 30px;
    }
    .clear{
        clear:both;
    }
    .form_row{
        margin-right:20px !important;
        margin-left:10px !important;
    }
    .dataTables_length{
        display: none !important;
    }
    .report_title{
        font-weight: bold;
        font-size: 14px;
        text-transform: uppercase;
    }
    .pagination{
        float:right !important;
    }
    .koolphp-table{
    width: 98% !important;
    margin: auto !important;
    }
    .view_detail{
        font-size: 12px;
        font-weight: bold;
    }
    .form_row{
        margin-right:20px !important;
        margin-left:10px !important;
    }
    .searchForm .row{
        display: block;
    }
    .searchForm .col-md-6{
        margin: 10px;
    }
    .download_div{
        display:inline-block;
        margin-right: 10px;
    }
    .reportFooter{
        text-align: center;
        height: 50px;
    }
    .reportHeader{
        text-align: center;
    }
    .reportLabel{
        text-align: center;
    }
    div.dataTables_scrollHead table.table-bordered{
        width: 100% !important;
        margin: 0 auto !important;
    }
    .form-check {
        display: inline-block !important;
    }
    div.dataTables_scrollBody table{
        width: 100% !important;
        margin: 0 auto !important;
    }
</style>
<html>
    <body>
    <div class="report-content">

        <div class="text-center">
            <h1>FUND DATA - ALL</h1>
        </div>
        <form method="post" id="consultantForm" class="searchForm">
        <div class="row form_row">
        <div class="form-group">
            <div class="col-md-6">
            <b>MANAGEMENT COMPANY</b>
                <?php
                Select2::create(array(
                    "multiple"=>true,
                    "name"=>"DISTRIBUTORIDS",
                    "defaultOption"=>array("All"=>0),
                    "dataSource"=>$this->dataStore("DISTRIBUTORLIST"),
                    "dataBind"=>array(
                                "text"=>"DIST_NAME",
                                "value"=>"DISTRIBUTORID",
                            ),
                    // "clientEvents"=>array(
                    //     "change"=>"function(e){
                    //         $('#consultantForm').submit(); 
                    //     }",
                    // ),
                    "attributes"=>array(
                        "class"=>"form-control"
                    )
                ));
                    ?>
                </div>
            </div>
                <div class="form-group">
                <div class="col-md-6">
                    <button class="btn btn-primary">SEARCH</button>
                </div>
            </div>
        </div>
    </form>
        <div class="clear"></div>
        <div class="text-right">
         <div class="download_div">
            <form method="post" action="<?php echo config('app.koolreport_server_url');?>/funddataallexcel">
            <?php
                foreach ($this->params['DISTRIBUTORIDS'] as  $value) {
                ?>
                  <input type="hidden" name="DISTRIBUTORIDS[]" value="<?php echo $value; ?>">
                <?php
                }
                ?>
                <button class="btn btn-primary">Download EXCEL</button>
            </form>
        </div>
        </div>
        <div style="height:20px;"></div>
        <div class="clear"></div>
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
    DataTables::create([
        "dataSource"=>$newArrayCon,
        "plugins" => ["Buttons"],
       // "showFooter"=>true,
        "complexHeaders" => true,
        "headerSeparator" => "-",
        "options"=>array(
           // "dom" => 'Blfrtip',
            "paging"=>true,
            "pageLength" => 10,
            "searching"=>true,
            "colReorder"=>true,
           // "scrollY" => "500px",
            "scrollX" => true,
            "scrollCollapse" => true,
            "buttons" => [
              "csv", "excel", "pdf", "print"
            ],
            "order"=>array(
                array(0,"asc"), //Sort by first column desc
            ),
        ),
        "searchOnEnter" => true,
        "searchMode" => "or",
        "themeBase"=>"bs4",
        // "columns"=>array(
        //     "DISTRIBUTOR"=>array(
        //        // "label"=>"DISTRIBUTOR",
        //         "type"=>"string",
        //         "searchable" => true,
        //        // "type"=>"datetime",
        //        // "format"=>"Y-m-d H:i:s",
        //        // "displayFormat"=>"Y"
        //       // "footer"=>"sum",
        //        "footerText"=>"<b>TOTAL</b>",
        //     ),
        //     "UTMC"=>array(
        //         //"label"=>"UTS-EXAM PASSED",
        //         "type"=>"number",
        //         "cssStyle"=>"dt-body-center",
        //         "footer"=>"sum",
        //         "footerText"=>"<b>@value</b>",
        //     ),
        //     "PRP"=>array(
        //        // "label"=>"UTS-VARIATION",
        //         "type"=>"number",
        //         "cssStyle"=>"text-align:center",
        //         "footer"=>"sum",
        //         "footerText"=>"<b>@value</b>",
        //     ),
        //     "IUTA"=>array(
        //        // "label"=>"UTS-EXEMPTION",
        //         "type"=>"number",
        //         "cssStyle"=>"text-align:center",
        //         "footer"=>"sum",
        //         "footerText"=>"<b>@value</b>",
        //     ),
        //     "CUTA"=>array(
        //         //"label"=>"TOTAL",
        //         "type"=>"number",
        //         "cssStyle"=>"text-align:center",
        //         "footer"=>"sum",
        //         "footerText"=>"<b>@value</b>",
        //     ),
        //     "CPRA"=>array(
        //        // "label"=>"PRS-EXAM PASSED",
        //         "type"=>"number",
        //         "cssStyle"=>"text-align:center",
        //         "footer"=>"sum",
        //         "footerText"=>"<b>@value</b>",
        //     ),
        //     "IPRA"=>array(
        //        // "label"=>"PRS-VARIATION",
        //         "type"=>"number",
        //         "cssStyle"=>"text-align:center",
        //         "footer"=>"sum",
        //         "footerText"=>"<b>@value</b>",
        //     ),
        // ),
        "cssClass"=>array(
            "table"=>"table table-striped table-bordered",
            'th' => 'reportHeader',
            'tr' => 'reportRow',
            'td' => function($row, $colName) {
                $v = Util::get($row, $colName, 0);
                $s = is_numeric($v) ? 'text-center' : 'reportLabel';
                return $s;
            },
            'tf' => 'reportFooter'
        )
    ]);
        ?>
        </div>
    </body>
</html>


