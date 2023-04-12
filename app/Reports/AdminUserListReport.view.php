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
            <h1>List of User</h1>
        </div>
        <div class="clear"></div>
    <div class="text-right downloadlink">
        <!-- <a href="<?php echo config('app.koolreport_server_url');?>/adminuserlistpdf" style= margin-botom:10px;margin-right:5px;" class="btn btn-primary">Download Portrait PDF</a>
          <a href="<?php echo config('app.koolreport_server_url');?>/adminuserlistlandscapepdf" style="margin-botom:10px;margin-right:5px;" class="btn btn-primary">Download Landscape PDF</a> -->
          <a href="<?php echo config('app.koolreport_server_url');?>/adminuserlistexcel" style="margin-botom:10px;margin-right:5px;" class="btn btn-primary">Download EXCEL</a>
        </div>
        <div style="height:20px;"></div>
        <div class="clear"></div>
    <?php
    $datafimm = $this->dataStore('FIMMUSER');
    $datadistributor = $this->dataStore('DISTRIBUTORUSER');
    $dataconsultant = $this->dataStore('CONSULTANTUSER');
    $dataothers = $this->dataStore('OTHERSUSER');
    $newArrayFimm = array();
    $newArrayDistributor = array();
    $newArrayConsultant = array();
    $newArrayOthers = array();
    foreach($datafimm as $row)
    {

            $newArrayFimm[] =  array(
                                 'USERID' => $row['USER_ID'],
                                 'NAME' => $row['USER_NAME'],
                                 'EMAIL' => $row['USER_EMAIL'],
                                 'COMPANY' => "FIMM",
                                 'ACTION' => '<div class="view_detail text-center"><a target="_parent"  href="'.config('app.koolreport_server_front_address').'/admin-user-list-detail/'.$row['USER_ID'].'/1'.'">VIEW</a></div>',
                             );
    }
    foreach($datadistributor as $row1)
    {

            $newArrayDistributor[] =  array(
                                 'USERID' => $row1['USER_ID'],
                                 'NAME' => $row1['USER_NAME'],
                                 'EMAIL' => $row1['USER_EMAIL'],
                                 'COMPANY' => $row1['COMPANY'],
                                 'ACTION' => '<div class="view_detail text-center"><a target="_parent"  href="'.config('app.koolreport_server_front_address').'/admin-user-list-detail/'.$row1['USER_ID'].'/2'.'">VIEW</a></div>',
                             );
    }
    foreach($dataconsultant as $row2)
    {

            $newArrayCONSULTANT[] =  array(
                                 'USERID' => $row2['USER_ID'],
                                 'NAME' => $row2['USER_NAME'],
                                 'EMAIL' => $row2['USER_EMAIL'],
                                 'COMPANY' => $row2['COMPANY'],
                                 'ACTION' => '<div class="view_detail text-center"><a target="_parent"  href="'.config('app.koolreport_server_front_address').'/admin-user-list-detail/'.$row2['USER_ID'].'/3'.'">VIEW</a></div>',
                             );
    }
    foreach($dataothers as $row3)
    {

            $newArrayOthers[] =  array(
                                 'USERID' => $row3['USER_ID'],
                                 'NAME' => $row3['USER_NAME'],
                                 'EMAIL' => $row3['USER_EMAIL'],
                                 'COMPANY' => $row3['COMPANY'],
                                 'ACTION' => '<div class="view_detail text-center"><a target="_parent"  href="'.config('app.koolreport_server_front_address').'/admin-user-list-detail/'.$row3['USER_ID'].'/4'.'">VIEW</a></div>',
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
                array(1,"asc"), //Sort by first column desc
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


