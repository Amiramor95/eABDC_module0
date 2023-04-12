<?php
use \koolreport\widgets\koolphp\Table;
use \koolreport\inputs\Select2;
use \koolreport\inputs\DateRangePicker;
use \koolreport\datagrid\DataTables;
use \koolreport\core\Utility as Util;

//print_r($this->params["dateRange"]);
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
    .date-range-picker {
    width: 40% !important;
    }
    .downloadlink{
        margin-right: 10px;
    }
</style>
<html>
    <body>
    <div class="report-content">

        <div class="text-center">
            <h1>SMS LOG REPORT </h1>
        </div>
        <div class="clear"></div>
        <form method="post">
        <div class="row form_row">
            <div class="col-md-6">
                <div class="form-group">
                <b>Date Range</b>
                <?php
                DateRangePicker::create(array(
                "name"=>"dateRange",
              //  "format"=>"MMM Do, YYYY", //Jul 3rd, 2017
              "format"=>"YYYY-M-D",
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
                    <button class="btn btn-primary">SEARCH</button>
                </div>
            </div>
        </div>
    </form>


    <div class="text-right downloadlink">
        <!-- <a href="<?php echo config('app.koolreport_server_url');?>/adminsmslogpdf" style= margin-botom:10px;margin-right:5px;" class="btn btn-primary">Download Portrait PDF</a>
          <a href="<?php echo config('app.koolreport_server_url');?>/adminsmsloglandscapepdf" style="margin-botom:10px;margin-right:5px;" class="btn btn-primary">Download Landscape PDF</a> -->
          <a href="<?php echo config('app.koolreport_server_url');?>/adminsmslogexcel" style="margin-botom:10px;margin-right:5px;" class="btn btn-primary">Download EXCEL</a>
        </div>
        <div style="height:20px;"></div>
        <div class="clear"></div>
    <?php
    $data_queryB = $this->dataStore('SMSLOGREPORT');
   // print_r($data_queryB);
    $newArray = array();
    foreach($data_queryB as $row)
    {

        if($row['SMS_STATUS'] == 0)
        {
            $status = 'Failed';
        }
        else{
            $status = 'Success';
        }
            $newArray[] =  array(
                                 'COMPANY' => "FIMM",
                                 'DATE & TIME' => $row['DATE_SEND'],
                                 'RECIPIENT' => $row['SMS_RECIPIENT'],
                                 'MESSAGE' => $row['MESSAGE'],
                                 'STATUS' => $status,
                             );
    }

    DataTables::create([
        "dataSource"=>$newArray,
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
                array(1,"desc"), //Sort by first column desc
            ),
        ),
        "searchOnEnter" => true,
        "searchMode" => "or",
        "themeBase"=>"bs4",
        "columns"=>array(
            "COMPANY"=>array(
                "label"=>"COMPANY",
               // "type"=>"number",
                "searchable" => true,
                "type"=>"string",
               // "format"=>"Y-m-d H:i:s",
               // "displayFormat"=>"Y"
            ),
            "DATE & TIME"=>array(
              "label"=>"DATE & TIME",
              "type"=>"datetime",
              "format"=>"Y-m-d H:i:s",
              "displayFormat"=>"d-M-Y H:i:s"
            ),
            "RECIPIENT"=>array(
                "label"=>"RECIPIENT",
                "type"=>"string",
                "searchable" => true,
            ),
            "MESSAGE"=>array(
                "label"=>"MESSAGE",
                "type"=>"string",
                "searchable" => true,
            ),
            "STATUS"=>array(
                "label"=>"STATUS",
                "type"=>"string",
                "searchable" => true,
            ),
        ),
        "cssClass"=>array(
            "table"=>"table table-striped table-bordered"
        ),
    ]);
        ?>
        </div>
    </body>
</html>


