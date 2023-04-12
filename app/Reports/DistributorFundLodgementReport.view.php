<?php
use \koolreport\widgets\koolphp\Table;
use \koolreport\inputs\Select2;
use \koolreport\inputs\DateRangePicker;
use \koolreport\datagrid\DataTables;
use \koolreport\core\Utility as Util;
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
</style>
<html>
    <body>
    <div class="report-content">

        <div class="text-center">
            <h1>Fund Lodgement Report</h1>
        </div>
        <form method="post" id="consultantForm" class="searchForm">
        <div class="row form_row">
        
        <div class="form-group">
            <div class="col-md-6">
            <b>DISTRIBUTOR</b>
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
                <b>DISTRIBUTOR TYPE</b>
                <?php
                Select2::create(array(
                    "multiple"=>true,
                    "name"=>"DISTIDS",
                    "defaultOption"=>array("All"=>0),
                    "dataSource"=>$this->dataStore("DISTRIBUTORTYPELIST"),
                    "dataBind"=>array(
                                "text"=>"DIST_TYPE_NAME",
                                "value"=>"DISTID",
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
            <b>LODGEMENT DATE</b>
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
                <b>FUND TYPE</b>
                <?php 
                 $types = array();
                 $types[0] = array('TYPENAME' => 'MEMBER','ID' => 0);
                 $types[1] = array('TYPENAME' => 'NON-MEMBER','ID' => 1);
                    Select2::create(array(
                        "multiple"=>false,
                        "name"=>"FUNDTYPE",
                        "defaultOption"=>array("All"=>2),
                        "dataSource"=>$types,
                        "dataBind"=>array(
                            "text"=>"TYPENAME",
                            "value"=>"ID",
                        ),
                        "attributes"=>array(
                            "class"=>"form-control"
                        ),
                        
                    ));
                    ?>
                </div>
                </div>
                <div class="form-group">
                <div class="col-md-6">
                <b>FUND COMPANY</b>
                <?php 
                    Select2::create(array(
                        "multiple"=>true,
                        "name"=>"COMPANYIDS",
                        "defaultOption"=>array("All"=>0),
                        "dataSource"=>$this->dataStore('FUNDCOMPANYLIST'),
                        "dataBind"=>array(
                            "text"=>"COM_NAME",
                            "value"=>"COMPANYID",
                        ),
                        "attributes"=>array(
                            "class"=>"form-control"
                        ),
                        // "clientEvents"=>array(
                        //     "change"=>"function(e){
                        //         $('#consultantForm').submit();
                        //     }",
                        //     )
                    ));
                    ?>
                </div>
                </div>
                <div class="form-group">
                <div class="col-md-6">
                <b>FUND NAME</b>
                <?php 
                    Select2::create(array(
                        "multiple"=>false,
                        "name"=>"FUND_NAME",
                        "defaultOption"=>array("All"=>0),
                        "dataSource"=>$this->dataStore('FUNDNAMELIST'),
                        "dataBind"=>array(
                            "text"=>"FUND_NAME",
                            "value"=>"FUND_PROFILE_ID",
                        ),
                        "attributes"=>array(
                            "class"=>"form-control"
                        ),
                        // "clientEvents"=>array(
                        //     "change"=>"function(e){
                        //         $('#consultantForm').submit();
                        //     }",
                        //     )
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
            <form method="post" action="<?php echo config('app.koolreport_server_url');?>/distributorfundlodgementpdf">
            <?php
                foreach ($this->params['DISTRIBUTORIDS'] as  $value) {
                ?>
                  <input type="hidden" name="DISTRIBUTORIDS[]" value="<?php echo $value; ?>">
                <?php
                }
                ?>
                 <?php
                foreach ($this->params['DISTIDS'] as  $value1) {
                ?>
                  <input type="hidden" name="DISTIDS[]" value="<?php echo $value1; ?>">
                <?php
                }
                ?>
                 <?php
                foreach ($this->params['COMPANYIDS'] as  $value2) {
                ?>
                  <input type="hidden" name="COMPANYIDS[]" value="<?php echo $value2; ?>">
                <?php
                }
                ?>
                 <input type="hidden" value="<?php echo $this->params["FUNDTYPE"]; ?>" name="FUNDTYPE" />
                 <input type="hidden" value="<?php echo $this->params["FUND_NAME"]; ?>" name="FUND_NAME" />
                <input type="hidden" value="<?php echo $this->params["dateRange"][0]; ?>" id="dateRange_start" name="dateRange[]" />
                <input type="hidden" value="<?php echo $this->params["dateRange"][1]; ?>" id="dateRange_end" name="dateRange[]" />
                <button class="btn btn-primary">Download Portrait PDF</button>
            </form>
         </div>
         <div class="download_div">
            <form method="post" action="<?php echo config('app.koolreport_server_url');?>/distributorfundlodgementlandscapepdf">
            <?php
                foreach ($this->params['DISTRIBUTORIDS'] as  $value) {
                ?>
                  <input type="hidden" name="DISTRIBUTORIDS[]" value="<?php echo $value; ?>">
                <?php
                }
                ?>
                 <?php
                foreach ($this->params['DISTIDS'] as  $value1) {
                ?>
                  <input type="hidden" name="DISTIDS[]" value="<?php echo $value1; ?>">
                <?php
                }
                ?>
                 <?php
                foreach ($this->params['COMPANYIDS'] as  $value2) {
                ?>
                  <input type="hidden" name="COMPANYIDS[]" value="<?php echo $value2; ?>">
                <?php
                }
                ?>
                 <input type="hidden" value="<?php echo $this->params["FUNDTYPE"]; ?>" name="FUNDTYPE" />
                 <input type="hidden" value="<?php echo $this->params["FUND_NAME"]; ?>" name="FUND_NAME" />
                <input type="hidden" value="<?php echo $this->params["dateRange"][0]; ?>" id="dateRange_start" name="dateRange[]" />
                <input type="hidden" value="<?php echo $this->params["dateRange"][1]; ?>" id="dateRange_end" name="dateRange[]" />
                <button class="btn btn-primary">Download Landscape PDF</button>
            </form>
         </div> -->
         <div class="download_div">
            <form method="post" action="<?php echo config('app.koolreport_server_url');?>/distributorfundlodgementexcel">
            <?php
                foreach ($this->params['DISTRIBUTORIDS'] as  $value) {
                ?>
                  <input type="hidden" name="DISTRIBUTORIDS[]" value="<?php echo $value; ?>">
                <?php
                }
                ?>
                 <?php
                foreach ($this->params['DISTIDS'] as  $value1) {
                ?>
                  <input type="hidden" name="DISTIDS[]" value="<?php echo $value1; ?>">
                <?php
                }
                ?>
                 <?php
                foreach ($this->params['COMPANYIDS'] as  $value2) {
                ?>
                  <input type="hidden" name="COMPANYIDS[]" value="<?php echo $value2; ?>">
                <?php
                }
                ?>
                 <input type="hidden" value="<?php echo $this->params["FUNDTYPE"]; ?>" name="FUNDTYPE" />
                 <input type="hidden" value="<?php echo $this->params["FUND_NAME"]; ?>" name="FUND_NAME" />
                <input type="hidden" value="<?php echo $this->params["dateRange"][0]; ?>" id="dateRange_start" name="dateRange[]" />
                <input type="hidden" value="<?php echo $this->params["dateRange"][1]; ?>" id="dateRange_end" name="dateRange[]" />
                <button class="btn btn-primary">Download EXCEL</button>
            </form>
        </div>
        </div>
        <div style="height:20px;"></div>
        <div class="clear"></div>
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


