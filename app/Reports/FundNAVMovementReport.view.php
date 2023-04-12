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
    .reportLabel{
        text-align: left;
    }
    .reportHeader{
        text-align: left;
    }
</style>
<html>
    <body>
    <div class="report-content">

        <div class="text-center">
            <h1>NAV MOVEMENT REPORT</h1>
        </div>
        <form method="post" id="consultantForm" class="searchForm">
        <div class="row form_row">
        <div class="form-group">
            <div class="col-md-6">
            <b>DATE</b>
                <?php
                DateRangePicker::create(array(
                "name"=>"dateRange",
                "format"=>"MMM Do, YYYY", //Jul 3rd, 2017
               //  "format"=>"d-MMM-Y",
                "ranges"=>array(
               // "Select Date"=> '0000-00-00,0000-00-00',
                "Today"=>DateRangePicker::today(),
                "Yesterday"=>DateRangePicker::yesterday(),
                "Last 7 days"=>DateRangePicker::last7days(),
                "Last 30 days"=>DateRangePicker::last30days(),
                "This month"=>DateRangePicker::thisMonth(),
                "Last month"=>DateRangePicker::lastMonth(),
                )
                ));
                ?>
                </div>
            </div>
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
        <!-- <div class="download_div">
            <form method="post" action="<?php echo config('app.koolreport_server_url');?>/funddataclosedpdf">
            <?php
                foreach ($this->params['DISTRIBUTORIDS'] as  $value) {
                ?>
                  <input type="hidden" name="DISTRIBUTORIDS[]" value="<?php echo $value; ?>">
                <?php
                }
                ?>
                <input type="hidden" value="<?php echo $this->params["dateRange"][0]; ?>" id="dateRange_start" name="dateRange[]" />
                <input type="hidden" value="<?php echo $this->params["dateRange"][1]; ?>" id="dateRange_end" name="dateRange[]" />
                <button class="btn btn-primary">Download Portrait PDF</button>
            </form>
         </div>
         <div class="download_div">
            <form method="post" action="<?php echo config('app.koolreport_server_url');?>/funddataclosedlandscapepdf">
            <?php
                foreach ($this->params['DISTRIBUTORIDS'] as  $value) {
                ?>
                  <input type="hidden" name="DISTRIBUTORIDS[]" value="<?php echo $value; ?>">
                <?php
                }
                ?>
                <input type="hidden" value="<?php echo $this->params["dateRange"][0]; ?>" id="dateRange_start" name="dateRange[]" />
                <input type="hidden" value="<?php echo $this->params["dateRange"][1]; ?>" id="dateRange_end" name="dateRange[]" />
                <button class="btn btn-primary">Download Landscape PDF</button>
            </form>
         </div> -->
         <div class="download_div">
            <form method="post" action="<?php echo config('app.koolreport_server_url');?>/fundaudittrailexcel">
            <?php
                foreach ($this->params['DISTRIBUTORIDS'] as  $value) {
                ?>
                  <input type="hidden" name="DISTRIBUTORIDS[]" value="<?php echo $value; ?>">
                <?php
                }
                ?>
                <input type="hidden" value="<?php echo $this->params["dateRange"][0]; ?>" id="dateRange_start" name="dateRange[]" />
                <input type="hidden" value="<?php echo $this->params["dateRange"][1]; ?>" id="dateRange_end" name="dateRange[]" />
                <button class="btn btn-primary">Download EXCEL</button>
            </form>
        </div>
        </div>
        <div style="height:20px;"></div>
        <div class="clear"></div>
    <?php
    $datacon = $this->dataStore('FUNDNAVMOVEMENTREPORT');
    $newArrayCon = array();
    foreach($datacon as $row)
    {
        $launchdate = "";
        $updatedate = "";
        $st = "";
        $user = "";
        $user1 = "";
        // if($row['LAUNCHDATE'] != '')
        // {
        //    $launchdate = date("d-M-Y", strtotime($row['LAUNCHDATE'])); 
        // }
        // if($row['FUND_MATURITY_CLOSURE_DATE'] != '')
        // {
        //    $updatedate = date("d-M-Y", strtotime($row['FUND_MATURITY_CLOSURE_DATE'])); 
        // }
       
        // $tr = "";
        // foreach($row['NEW_VALUES'] as $attribute  => $value){
        //     $tr .= "<tr><td><b>" .$attribute . "</b></td><td>".$value ."</td></tr>";
        //   }
        // $table = '<table class="table table-bordered table-hover" style="width:100%">'. $tr .'</table>';
            $newArrayCon[] =  array( 
                                 // 'ID' => $row['DISTRIBUTOR_ID'],
                                  'COMPANY' => $row['DIST_NAME'],
                                  'FUND NAME' => $row['FUND_NAME'],
                                  'FIMM FUND CODE' => $row['FUND_CODE_FIMM'],
                                  'VALUATION DATE' => $row['VALUATION_DATE'],
                                  'PREVIOUS NAV' => $row['PREV_NAV_VAL'],
                                  'CURRENT NAV' => $row['NAV_VAL'],
                                  'MOVEMENT' => 0,
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
            "pageLength" => 5,
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
        //     "OLD RECORD"=>array(
        //         "label"=>"OLD RECORD",
        //         "type"=>"string",
        //         "searchable" => true,
        //        // "type"=>"datetime",
        //        // "format"=>"Y-m-d H:i:s",
        //        // "displayFormat"=>"Y"
        //       // "footer"=>"sum",
        //       // "footerText"=>"<b>TOTAL</b>",
        //     ),
        //     "NEW RECORD"=>array(
        //         "label"=>"NEW RECORD",
        //         "type"=>"string",
        //         //"cssStyle"=>"dt-body-center",
        //        // "footer"=>"sum",
        //        // "footerText"=>"<b>@value</b>",
        //     ),
        //     "STATUS"=>array(
        //         "label"=>"STATUS",
        //         "type"=>"string",
        //        // "cssStyle"=>"text-align:center",
        //        // "footer"=>"sum",
        //         //"footerText"=>"<b>@value</b>",
        //     ),
        //     "APPROVAL USER(MEMBER)"=>array(
        //         "label"=>"APPROVAL USER(MEMBER)",
        //         "type"=>"string",
        //         //"cssStyle"=>"text-align:center",
        //        // "footer"=>"sum",
        //        // "footerText"=>"<b>@value</b>",
        //     ),
        //     "APPROVAL DATE"=>array(
        //         "label"=>"APPROVAL DATE",
        //         "type"=>"datetime",
        //         "format"=>"Y-m-d H:i:s",
        //         "displayFormat"=>"M-d-Y"
        //     ),
        //     "MANAGEMENT COMPANY"=>array(
        //         "label"=>"MANAGEMENT COMPANY",
        //         "type"=>"string",
        //        // "cssStyle"=>"text-align:center",
        //        // "footer"=>"sum",
        //        // "footerText"=>"<b>@value</b>",
        //     ),
        //     "APPROVAL USER(FIMM)"=>array(
        //         "label"=>"APPROVAL USER(FIMM)",
        //         "type"=>"string",
        //         //"cssStyle"=>"text-align:center",
        //         //"footer"=>"sum",
        //         //"footerText"=>"<b>@value</b>",
        //     ),
        //     "APPROVAL DATE FIMM"=>array(
        //         "label"=>"APPROVAL DATE FIMM",
        //         "type"=>"datetime",
        //         "format"=>"Y-m-d H:i:s",
        //         "displayFormat"=>"M-d-Y"
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


