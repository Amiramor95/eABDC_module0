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
            <h1>FMS User Summary Report</h1>
        </div>
        <form method="post" id="consultantForm" class="searchForm">
        <div class="row form_row">
        <div class="form-group">
            <div class="col-md-6">
            <b>USER GROUP</b>
                <?php
                Select2::create(array(
                    "multiple"=>true,
                    "name"=>"GROUPIDS",
                    "defaultOption"=>array("All"=>0),
                    "dataSource"=>$this->dataStore("TPGROUPLIST"),
                    "dataBind"=>array(
                                "text"=>"GROUPNAME",
                                "value"=>"GROUPID",
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
            <b>ORGANIZATION</b>
                <?php
                Select2::create(array(
                    "multiple"=>true,
                    "name"=>"COMIDS",
                    "defaultOption"=>array("All"=>0),
                    "dataSource"=>$this->dataStore("ORGANIZATIONLIST"),
                    "dataBind"=>array(
                                "text"=>"TP_NAME",
                                "value"=>"COMID",
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
            <form method="post" action="<?php echo config('app.koolreport_server_url');?>/fundusersummarypdf">
            <?php
                foreach ($this->params['COMIDS'] as  $value) {
                ?>
                  <input type="hidden" name="COMIDS[]" value="<?php echo $value; ?>">
                <?php
                }
                ?>
                 <?php
                foreach ($this->params['GROUPIDS'] as  $value1) {
                ?>
                  <input type="hidden" name="GROUPIDS[]" value="<?php echo $value1; ?>">
                <?php
                }
                ?>
                <button class="btn btn-primary">Download Portrait PDF</button>
            </form>
         </div>
         <div class="download_div">
            <form method="post" action="<?php echo config('app.koolreport_server_url');?>/fundusersummarylandscapepdf">
            <?php
                foreach ($this->params['COMIDS'] as  $value) {
                ?>
                  <input type="hidden" name="COMIDS[]" value="<?php echo $value; ?>">
                <?php
                }
                ?>
                 <?php
                foreach ($this->params['GROUPIDS'] as  $value1) {
                ?>
                  <input type="hidden" name="GROUPIDS[]" value="<?php echo $value1; ?>">
                <?php
                }
                ?>
                <button class="btn btn-primary">Download Landscape PDF</button>
            </form>
         </div> -->
         <div class="download_div">
            <form method="post" action="<?php echo config('app.koolreport_server_url');?>/fundusersummaryexcel">
            <?php
                foreach ($this->params['COMIDS'] as  $value) {
                ?>
                  <input type="hidden" name="COMIDS[]" value="<?php echo $value; ?>">
                <?php
                }
                ?>
                 <?php
                foreach ($this->params['GROUPIDS'] as  $value1) {
                ?>
                  <input type="hidden" name="GROUPIDS[]" value="<?php echo $value1; ?>">
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
    $datacon = $this->dataStore('FUNDUSERSUMMARYREPORT');
    // echo "<pre>";
    // print_r($datacon);
    // echo "</pre>";
    $newArrayCon = array();
    foreach($datacon as $row)
    {
        $launchdate = "";
        $updatedate = "";
        $contact = "";
        $shasridate = "";
        // if($row['LAUNCHDATE'] != '')
        // {
        //    $launchdate = date("d-M-Y", strtotime($row['LAUNCHDATE']));
        // }
        if($row['TP_USER_TYPE'] == 3)
        {
            $contact = "Media";
        }
        if($row['TP_USER_TYPE'] == 2)
        {
            $contact = "Training Provider";
        }
        if($row['TP_USER_TYPE'] == 1){
            $contact = "3rd Party";
        }
            $newArrayCon[] =  array( 
                                  'ORGANIZATION' => $row['TP_NAME'],
                                  'USER ID' => $row['TP_USERID'],
                                  'NAME' => $row['TP_USER_FNAME'],
                                  'EMAIL' => $row['TP_USER_EMAIL'],
                                  'DESIGNATION' => $row['DESIGNATION'],
                                  'MOBILE NUMBER' => $row['MOBILE'],
                                  'OFFICE NUMBER' => $row['OFFICENUMBER'],
                                  'USER ACCESS GROUP' => $row['TP_MANAGE_GROUP_NAME'],
                                  'NEWSPAPER CONTACT PERSON' => $contact,
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


