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
    .downloadlink{
        margin-right: 10px;
    }
</style>
<html>
    <body>
    <div class="report-content">

        <div class="text-center">
            <h1>User Log Report</h1>
        </div>
        <div class="clear"></div>
        <form method="post">
        <div class="row form_row">
            <div class="col-md-6">
                <div class="form-group">
                    <b>Module</b>
                    <?php 
                    
                    Select2::create(array(
                        "multiple"=>false,
                        "name"=>"MODULEID",
                        //"defaultOption"=>array("Select Company"=>1),
                        "dataSource"=>$this->dataStore('MAINMODULE'),
                        "dataBind"=>array(
                            "text"=>"MODULENAME",
                            "value"=>"MODULEID",
                        ),
                        "attributes"=>array(
                            "class"=>"form-control"
                        )
                    ));
                    ?>
                </div>
                <div class="form-group">
                <b>Date Range</b>
                <?php
                DateRangePicker::create(array(
                "name"=>"dateRange",
                "format"=>"MMM Do, YYYY", //Jul 3rd, 2017
            //  "format"=>"YYYY-M-D",
                "ranges"=>array(
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
                <div class="form-group">
                    <button class="btn btn-primary">Search</button>
                </div>   
            </div>
        </div>
    </form>
    <div class="text-right downloadlink">
          <form method="post" action="<?php echo config('app.koolreport_server_url');?>/adminuserlogexcel">
        <!-- <a href="<?php echo config('app.koolreport_server_url');?>/adminusersummarypdf" style= margin-botom:10px;margin-right:5px;" class="btn btn-primary">Download Portrait PDF</a>
          <a href="<?php echo config('app.koolreport_server_url');?>/adminusersummarylandscapepdf" style="margin-botom:10px;margin-right:5px;" class="btn btn-primary">Download Landscape PDF</a> -->
          <input type="hidden" value="<?php echo $this->params["MODULEID"]; ?>" name="MODULEID" />
          <input type="hidden" value="<?php echo $this->params["dateRange"][0]; ?>" id="dateRange_start" name="dateRange[]" />
          <input type="hidden" value="<?php echo $this->params["dateRange"][1]; ?>" id="dateRange_end" name="dateRange[]" />  
          <button class="btn btn-primary">Download EXCEL</button>
            </form>
        </div>
        <div style="height:20px;"></div>
        <div class="clear"></div>
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
    DataTables::create([
        "dataSource"=>$finalArray,
        "plugins" => ["Buttons"],
        //"complexHeaders" => true,
       // "headerSeparator" => "-",
        "options"=>array(
           // "dom" => 'Blfrtip',
            "paging"=>true,
            "pageLength" => 15,
            "searching"=>true,
            "colReorder"=>true,
            "buttons" => [
              "csv", "excel", "pdf", "print"
            ],
            "order"=>array(
                array(3,"desc"), //Sort by first column desc
            ),
        ),
        "searchOnEnter" => true,
        "searchMode" => "or",
        "themeBase"=>"bs4",
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
        "cssClass"=>array(
            "table"=>"table table-striped table-bordered"
        )
    ]);
        ?>
        </div>
    </body>
</html>


