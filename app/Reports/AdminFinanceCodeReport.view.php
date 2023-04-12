<?php
use \koolreport\widgets\koolphp\Table;
use \koolreport\inputs\Select2;
use \koolreport\inputs\DateRangePicker;
use \koolreport\datagrid\DataTables;
use \koolreport\core\Utility as Util;
use \koolreport\pivot\widgets\PivotTable;
// echo "<pre>";
// print_r($this->dataStore("SCREENREPORT"));
// echo "</pre>";
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
        font-size: 16px;
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
    .heading_title{
        text-transform: uppercase;
    }
    .download_div{
        display:inline-block;
        margin-right: 10px;
    }
    .dept_name{
        font-weight: normal;
        color: #514f4f;
        font-size: 14px;
        text-align: center;
    }
    .com_header{
        text-align: center; 
    }
   
</style>
<html>
    <body>
    <div class="report-content">

        <div class="text-center">
            <h1 class="report_title">Listing of Code Table</h1>
        </div>
        <div class="clear"></div>
    <div class="text-right">
        <!-- <div class="download_div">
            <form method="post" action="<?php echo config('app.koolreport_server_url');?>/adminfinancecodepdf">
                <button class="btn btn-primary">Download Portrait PDF</button>
            </form>
         </div>
         <div class="download_div">
            <form method="post" action="<?php echo config('app.koolreport_server_url');?>/adminfinancecodelandscapepdf">
                <button class="btn btn-primary">Download Landscape PDF</button>
            </form>
         </div> -->
         <div class="download_div">
            <form method="post" action="<?php echo config('app.koolreport_server_url');?>/adminfinancecodeexcel">
                <button class="btn btn-primary">Download EXCEL</button>
            </form>
        </div>
        </div>
        <div style="height:20px;"></div>
        <div class="clear"></div>
    <?php
    $dataCode = $this->dataStore('FINANCECODE');
    $dataCompany = $this->dataStore('FINANCECOMPANY');
    $newArray = array();
    $newArrayCompany = array();
    $status = "";
    foreach($dataCode as $row)
    {
       // foreach($dataCompany as $row1)
       // {

        if($row['STATUS'] == 0)
        {
            $status = 'Inactive';
        }
        else{
            $status = 'Active';
        }
        $newArray[] =  array(
            'Finance Category Code' => $row['REF_NUMBER'],
            'Code ID' => $row['ACC_CODE'],
            'Code Details' => $row['FINANCE_ACC_CODE_NAME'],
            'COMPANY' =>  "",
            'GL CODE' =>  "",
            'Status' => $status,
        );
    //}
    }
    //  $newArray1 = array_merge($newArray,$newArrayCompany);
    //     $finaloutput = array_values($newArray1);

    DataTables::create([
        "dataSource"=> $newArray,
        "plugins" => ["Buttons"],
        "complexHeaders" => true,
       "headerSeparator" => "-",
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
        "cssClass"=>array(
            "table"=>"table table-striped table-bordered",
            "th"=>"heading_title",
        ),
    ]);
        ?>
        </div>
    </body>
</html>


