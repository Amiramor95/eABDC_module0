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
        text-align: left;
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
    .group_class{
        display:inline-block;
        vertical-align: top;
    }
    .module_class{
        display:inline-block;
        margin-left: 28px;
        vertical-align: top;
    }
    .text-left{
        margin-left: 17px;
    }
</style>
<html>
    <body>
    <div class="report-content"> 
  
        <form method="post" id="consultantForm" class="searchForm">
        <div class="row form_row">
        <div class="form-group">
            <div class="col-md-6">
            <div class = "group_class">
            <b>YEAR FROM </b>
                    <?php 
                     $years = array();
                     $currentYear = date('Y');
                     $startyear = "2020";
                     for($i = $startyear;$i<= $currentYear;$i++){
                         $years[] =  array('AMSFYEAR' => $i);
                     }
                    Select2::create(array(
                        "multiple"=>false,
                        "name"=>"AMSFYEAR",
                        //"defaultOption"=>array($currentYear => $currentYear),
                        "dataSource"=>$years,
                        "dataBind"=>array(
                            "text"=>"AMSFYEAR",
                            "value"=>"AMSFYEAR",
                        ),
                        "attributes"=>array(
                            "class"=>"form-control"
                        ),
                        "clientEvents"=>array(
                            "change"=>"function(e){
                                var xp = $('#AMSFYEAR').val();
                                var xp1 = $('#AMSFYEAREND').val();
                                if(xp > xp1){
                                    $('#AMSFYEAR').val($currentYear);
                                    alert('From year cannot bigger than to year');
                                    $('#searchid').attr('disabled',true);
                                }
                                else
                                {
                                    $('#searchid').attr('disabled',false);
                                }
                            }",
                            )
                    ));
                    ?>
                    </div>
                    <div class = "module_class">
                    <b>TO </b>
                    <?php 
                     $years1 = array();
                     $currentYear1 = date('Y');
                     $startyear1 = "2020";
                     for($i1 = $startyear1;$i1<= $currentYear1;$i1++){
                         $years1[] =  array('AMSFYEAREND' => $i1);
                     }
                    Select2::create(array(
                        "multiple"=>false,
                        "name"=>"AMSFYEAREND",
                       // "defaultOption"=>array($currentYear1 => $currentYear1),
                        "dataSource"=>$years1,
                        "dataBind"=>array(
                            "text"=>"AMSFYEAREND",
                            "value"=>"AMSFYEAREND",
                        ),
                        "attributes"=>array(
                            "class"=>"form-control"
                        ),
                        "clientEvents"=>array(
                            "change"=>"function(e){
                                var xp = $('#AMSFYEAR').val();
                                var xp1 = $('#AMSFYEAREND').val();
                                if(xp1 < xp){
                                    $('#AMSFYEAREND').val($currentYear1);
                                    alert('To year cannot less than from year');
                                    $('#searchid').attr('disabled',true);
                                }
                                else
                                {
                                    $('#searchid').attr('disabled',false);
                                }
                            }",
                            )
                    ));
                    ?>
                    </div>
                </div>
            </div>
        <div class="form-group">
            <div class="col-md-6">
            <b>FUND COMPANY</b>
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
                    <button class="btn btn-primary" id="searchid">SEARCH</button>
                </div>
            </div>
        </div>
    </form>
        <div class="clear"></div>
        <div class="text-right">
        <!-- <div class="download_div">
            <form method="post" action="<?php echo config('app.koolreport_server_url');?>/fundutmccontactpersonpdf">
                <button class="btn btn-primary">Download Portrait PDF</button>
            </form>
         </div>
         <div class="download_div">
            <form method="post" action="<?php echo config('app.koolreport_server_url');?>/fundutmccontactpersonlandscapepdf">
                <button class="btn btn-primary">Download Landscape PDF</button>
            </form>
         </div> -->
         <div class="download_div">
            <form method="post" action="<?php echo config('app.koolreport_server_url');?>/amsfsummaryiutaiprpexcel">
            <?php
                foreach ($this->params['DISTRIBUTORIDS'] as  $value) {
                ?>
                  <input type="hidden" name="DISTRIBUTORIDS[]" value="<?php echo $value; ?>">
                <?php
                }
                ?>
                 <input type="hidden" value="<?php echo $this->params["AMSFYEAR"]; ?>" name="AMSFYEAR" />
                 <input type="hidden" value="<?php echo $this->params["AMSFYEAREND"]; ?>" name="AMSFYEAREND" />
                <button class="btn btn-primary">Download EXCEL</button>
            </form>
        </div>
        </div>
        <div style="height:20px;"></div>
        <div class="clear"></div>
    <?php
    $datacon = $this->dataStore('AMSFSUMMARYIUTAIPRPREPORT');
    $datatype = $this->dataStore('DISTRIBUTORTYPE');
    $newArrayCon = array();
    $newArrayDept = array();
    $respectiveSchemeNames = array();
    foreach($datatype as $row2)
    {
        $newArrayDept[] = array(
                           'DISTID' => $row2['DIST_ID'],
                           'TYPENAME' => $row2['DIST_TYPE_NAME'],
        );
    }
    foreach($datacon as $row)
    {
        $launchdate = "";
        $updatedate = "";
        $contact = "";
        $shasridate = "";
        $respectiveSchemeNames = array();
        foreach($newArrayDept as $dj1){
            if( $dj1['DISTID'] == $row['DISTRIBUTOR_ID']){
               // echo $dj1['DISTID'];
            $respectiveSchemeNames[] = $dj1['TYPENAME'];
            }
           }
        // if($row['LAUNCHDATE'] != '')
        // {
        //    $launchdate = date("d-M-Y", strtotime($row['LAUNCHDATE']));
        // }
      
            $newArrayCon[] =  array( 
                                 // 'AMSF YEAR' => $row['AMSF_YEAR'],
                                  'COMPANY' => $row['DIST_NAME'],
                                  'CATEGORY' => implode(' + ', $respectiveSchemeNames),
                                  'TOTAL NORMAL LOAD(UT&PRS)(RM)' => $row['TOTALGROUPA'],
                                  'TOTAL LOW LOAD(UT&PRS)(RM)' => $row['TOTALGROUPB'],
                                  'TOTAL NO LOAD(UT&PRS)(RM)' => $row['TOTALGROUPC'],
                                  'TOTAL GROSS SALES(UT&PRS)(RM)' => $row['TOTALGROUPA']+$row['TOTALGROUPB']+$row['TOTALGROUPC'],
                                  'IUTA+IPRP ANNUAL FEES(UT&PRS)(RM)' => $row['ANNUALFEE'],
                                  'NO. OF UTC' => $row['TOTALUTC'],
                                  'UTC Levy(RM)' => $row['TOTALUTCLEVY'],
                                  'UTC CARD(RM)' => 3.00,
                                  'NO. OF PRC' => $row['TOTALPRC'],
                                  'PRC Levy(RM)' => $row['TOTALPRCLEVY'],
                                  'PRC CARD(RM)' => 3.00,
                                  'TOTAL PAYABLE(RM)' =>  $row['ANNUALFEE']+$row['TOTALUTCLEVY']+3.00+$row['TOTALPRCLEVY']+3.00,
                             );
    }
    ?>
    <div class="text-left">
                <h1>Summary Report Annual Membership Fees/Annual Fee Payment (IUTA-IPRA) Year <?php echo $this->params["AMSFYEAR"]; ?> - <?php echo $this->params["AMSFYEAREND"]; ?></h1>
            </div>
    <?php
    DataTables::create([
        "dataSource"=>$newArrayCon,
        "plugins" => ["Buttons"],
        "showFooter"=>true,
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
        "columns"=>array(
            "COMPANY"=>array(
               // "label"=>"DISTRIBUTOR",
                "type"=>"string",
                "searchable" => true,
               // "type"=>"datetime",
               // "format"=>"Y-m-d H:i:s",
               // "displayFormat"=>"Y"
              // "footer"=>"sum",
               "footerText"=>"<b>TOTAL</b>",
            ),
            "CATEGORY"=>array(
                // "label"=>"DISTRIBUTOR",
                 "type"=>"string",
                 "searchable" => true,
                // "type"=>"datetime",
                // "format"=>"Y-m-d H:i:s",
                // "displayFormat"=>"Y"
               // "footer"=>"sum",
               // "footerText"=>"<b>TOTAL</b>",
             ),
            "TOTAL NORMAL LOAD(UT&PRS)(RM)"=>array(
                //"label"=>"UTS-EXAM PASSED",
                "type"=>"number",
                "decimals"=>2,
                "cssStyle"=>"dt-body-center",
                "footer"=>"sum",
                "footerText"=>"<b>@value</b>",
            ),
            "TOTAL LOW LOAD(UT&PRS)(RM)"=>array(
               // "label"=>"UTS-VARIATION",
                "type"=>"number",
                "decimals"=>2,
                "cssStyle"=>"text-align:center",
                "footer"=>"sum",
                "footerText"=>"<b>@value</b>",
            ),
            "TOTAL NO LOAD(UT&PRS)(RM)"=>array(
                // "label"=>"UTS-VARIATION",
                 "type"=>"number",
                 "decimals"=>2,
                 "cssStyle"=>"text-align:center",
                 "footer"=>"sum",
                 "footerText"=>"<b>@value</b>",
             ),
            "TOTAL GROSS SALES(UT&PRS)(RM)"=>array(
               // "label"=>"UTS-EXEMPTION",
                "type"=>"number",
                "decimals"=>2,
                "cssStyle"=>"text-align:center",
                "footer"=>"sum",
                "footerText"=>"<b>@value</b>",
            ),
            "IUTA+IPRP ANNUAL FEES(UT&PRS)(RM)"=>array(
                //"label"=>"TOTAL",
                "type"=>"number",
                "decimals"=>2,
                "cssStyle"=>"text-align:center",
                "footer"=>"sum",
                "footerText"=>"<b>@value</b>",
            ),
            "NO. OF UTC"=>array(
                // "label"=>"PRS-EXAM PASSED",
                 "type"=>"number",
                 "cssStyle"=>"text-align:center",
                 "footer"=>"sum",
                 "footerText"=>"<b>@value</b>",
             ),
             "UTC Levy(RM)"=>array(
                // "label"=>"PRS-VARIATION",
                 "type"=>"number",
                 "decimals"=>2,
                 "cssStyle"=>"text-align:center",
                 "footer"=>"sum",
                 "footerText"=>"<b>@value</b>",
             ),
             "UTC CARD(RM)"=>array(
                 // "label"=>"PRS-VARIATION",
                  "type"=>"number",
                  "decimals"=>2,
                  "cssStyle"=>"text-align:center",
                  "footer"=>"sum",
                  "footerText"=>"<b>@value</b>",
              ),
             "NO. OF PRC"=>array(
                // "label"=>"PRS-EXAM PASSED",
                 "type"=>"number",
                 "cssStyle"=>"text-align:center",
                 "footer"=>"sum",
                 "footerText"=>"<b>@value</b>",
             ),
             "PRC Levy(RM)"=>array(
                // "label"=>"PRS-VARIATION",
                 "type"=>"number",
                 "decimals"=>2,
                 "cssStyle"=>"text-align:center",
                 "footer"=>"sum",
                 "footerText"=>"<b>@value</b>",
             ),
             "PRC CARD(RM)"=>array(
                 // "label"=>"PRS-VARIATION",
                  "type"=>"number",
                  "decimals"=>2,
                  "cssStyle"=>"text-align:center",
                  "footer"=>"sum",
                  "footerText"=>"<b>@value</b>",
              ),
             "TOTAL PAYABLE(RM)"=>array(
                // "label"=>"PRS-VARIATION",
                 "type"=>"number",
                 "decimals"=>2,
                 "cssStyle"=>"text-align:center",
                 "footer"=>"sum",
                 "footerText"=>"<b>@value</b>",
             ),
        ),
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


