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
            <h1>Summary: List of User</h1>
        </div>
        <div class="clear"></div>
    <div class="text-right downloadlink">
        <!-- <a href="<?php echo config('app.koolreport_server_url');?>/adminusersummarypdf" style= margin-botom:10px;margin-right:5px;" class="btn btn-primary">Download Portrait PDF</a>
          <a href="<?php echo config('app.koolreport_server_url');?>/adminusersummarylandscapepdf" style="margin-botom:10px;margin-right:5px;" class="btn btn-primary">Download Landscape PDF</a> -->
          <a href="<?php echo config('app.koolreport_server_url');?>/adminusersummaryexcel" style="margin-botom:10px;margin-right:5px;" class="btn btn-primary">Download EXCEL</a>
        </div>
        <div style="height:20px;"></div>
        <div class="clear"></div>
    <?php
    $datafimm = $this->dataStore('FIMMUSERSUMMARY');
    $datadistributor = $this->dataStore('DISTRIBUTORUSERSUMMARY');
    $dataconsultant = $this->dataStore('CONSULTANTUSERSUMMARY');
    $dataothers = $this->dataStore('OTHERSUSERSUMMARY');
    $dataip = $this->dataStore('KEYKLOCKID');
    $newArrayFimm = array();
    $newArrayDistributor = array();
    $newArrayConsultant = array();
    $newArrayOthers = array();
   // $ip = "";
    foreach($datafimm as $row)
    {
        $ip = "";
        foreach($dataip as $krow)
        {
            if($row['KID'] == $krow['KEYID'])
            {
              $ip =   $krow['IP'];
            }
        }
        if($row['USER_STATUS'] == 0)
        {
            $status = "INACTIVE";
        }
        else if($row['USER_STATUS'] == 1)
        {
            $status = "PENDING";
        }
        else if($row['USER_STATUS'] == 2)
        {
            $status = "APPROVED";
        }
        else{
          $status = "RETURNED";
        }

            $newArrayFimm[] =  array( 
                                 'NAME' => $row['USER_NAME'],
                                 'EMAIL' => $row['USER_EMAIL'],
                                 'COMPANY' => "FIMM",
                                 'STATUS' => $status,
                                 'IP' => $ip,
                                 'STATE' => $row['STATE'],
                             );
    }
    foreach($datadistributor as $row1)
    {
        $ip1 = "";
        foreach($dataip as $krow1)
        {
            if($row1['KID'] == $krow1['KEYID'])
            {
              $ip1 =   $krow1['IP'];
            }
        }
        if($row1['USER_STATUS'] == 0)
        {
            $status1 = "INACTIVE";
        }
        else if($row1['USER_STATUS'] == 1)
        {
            $status1 = "PENDING";
        }
        else if($row1['USER_STATUS'] == 2)
        {
            $status1 = "APPROVED";
        }
        else{
          $status1 = "RETURNED";
        }

            $newArrayDistributor[] =  array(
                                 'NAME' => $row1['USER_NAME'],
                                 'EMAIL' => $row1['USER_EMAIL'],
                                 'COMPANY' => $row1['COMPANY'],
                                 'STATUS' => $status1,
                                 'IP' => $ip1,
                                 'STATE' => $row1['STATE'],
                             );
    }
    foreach($dataconsultant as $row2)
    {
        $ip2 = "";
        foreach($dataip as $krow2)
        {
            if($row2['KID'] == $krow2['KEYID'])
            {
              $ip2 =   $krow2['IP'];
            }
        }
        if($row2['USER_STATUS'] == 0)
        {
            $status2 = "INACTIVE";
        }
        else if($row2['USER_STATUS'] == 1)
        {
            $status2 = "PENDING";
        }
        else if($row2['USER_STATUS'] == 2)
        {
            $status2 = "APPROVED";
        }
        else{
          $status2 = "RETURNED";
        }

            $newArrayCONSULTANT[] =  array(
                                 'NAME' => $row2['USER_NAME'],
                                 'EMAIL' => $row2['USER_EMAIL'],
                                 'COMPANY' => $row2['COMPANY'],
                                 'STATUS' => $status2,
                                 'IP' =>$ip2,
                                 'STATE' => "DEMO",
                             );
    }
    foreach($dataothers as $row3)
    {
        $ip3 = "";
        foreach($dataip as $krow3)
        {
            if($row3['KID'] == $krow3['KEYID'])
            {
              $ip3 =   $krow3['IP'];
            }
        }
        if($row3['USER_STATUS'] == 0)
        {
            $status3 = "INACTIVE";
        }
        else if($row3['USER_STATUS'] == 1)
        {
            $status3 = "PENDING";
        }
        else if($row3['USER_STATUS'] == 2)
        {
            $status3 = "APPROVED";
        }
        else{
          $status3 = "RETURNED";
        }

            $newArrayOthers[] =  array(
                                 'NAME' => $row3['USER_NAME'],
                                 'EMAIL' => $row3['USER_EMAIL'],
                                 'COMPANY' => $row3['COMPANY'],
                                 'STATUS' => $status3,
                                 'IP' => $ip3,
                                 'STATE' => $row3['STATE'],
                             );
    }
   
     $newArray = array_merge($newArrayFimm,$newArrayDistributor);
     $newArray1 = array_merge($newArrayCONSULTANT,$newArrayOthers);
    $finalArray = array_merge($newArray,$newArray1);
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
                array(0,"asc"), //Sort by first column desc
            ),
        ),
        "searchOnEnter" => true,
        "searchMode" => "or",
        "themeBase"=>"bs4",
        // "columns"=>array(
        //     "year_of_complain"=>array(
        //         "label"=>"YEAR",
        //        // "type"=>"number",
        //         "searchable" => true,
        //         "type"=>"datetime",
        //         "format"=>"Y-m-d H:i:s",
        //         "displayFormat"=>"Y"
        //     ),
        //     "total"=>array(
        //       "label"=>"TOTAL COMPLAINTS",
        //       "type"=>"number",
        //       //"searchable" => true,
        //     ),
        //     "total1"=>array(
        //         "label"=>"CLOSED",
        //         "type"=>"number",
        //         //"searchable" => true,
        //     ),
        //     "total2"=>array(
        //         "label"=>"ON-GOING",
        //         "type"=>"number",
        //         //"searchable" => true,
        //       )
        // ),
        "cssClass"=>array(
            "table"=>"table table-striped table-bordered"
        )
    ]);
        ?>
        </div>
    </body>
</html>


