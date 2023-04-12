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
            <h1 class="report_title">User Matrix - Authorization Report</h1>
        </div>
        <div class="clear"></div>
        <form method="post" id="matrixID">
        <div class="row form_row">
            <div class="col-md-6">
                <div class="form-group">
                <b>DEPARTMENT</b>
                <?php
                Select2::create(array(
                    "multiple"=>true,
                    "name"=>"DEPARTMENTIDS",
                    "dataSource"=>$this->dataStore("DEPARTMENTLIST"),
                    "dataBind"=>array(
                                "text"=>"DPMTNAME",
                                "value"=>"DEPARTMENTID",
                            ),
                    "attributes"=>array(
                        "class"=>"form-control"
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


    <div class="text-right">
        <div class="download_div">
            <form method="post" action="<?php echo config('app.koolreport_server_url');?>/adminusermatrixpdf">
            <?php
                foreach ($this->params['DEPARTMENTIDS'] as  $value) {
              ?>
            <input type="hidden" name="DEPARTMENTIDS[]" value="<?php echo $value; ?>">
            <?php
                }
                ?>
                <button class="btn btn-primary">Download Portrait PDF</button>
            </form>
         </div>
         <div class="download_div">
            <form method="post" action="<?php echo config('app.koolreport_server_url');?>/adminusermatrixlandscapepdf">
            <?php
                foreach ($this->params['DEPARTMENTIDS'] as  $value2) {
              ?>
            <input type="hidden" name="DEPARTMENTIDS[]" value="<?php echo $value2; ?>">
            <?php
                }
                ?>
                <button class="btn btn-primary">Download Landscape PDF</button>
            </form>
         </div>
         <div class="download_div">
            <form method="post" action="<?php echo config('app.koolreport_server_url');?>/adminusermatrixexcel">
            <?php
                foreach ($this->params['DEPARTMENTIDS'] as  $value1) {
              ?>
            <input type="hidden" name="DEPARTMENTIDS[]" value="<?php echo $value1; ?>">
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
    $dataModule = $this->dataStore('USERMATRIXMODULE');
    $dataProcessFlow = $this->dataStore('USERMATRIXREPORT');
    $dataDepartMent = $this->dataStore('USERMATRIXDEPART');
    $dataAuth = $this->dataStore('USERMATRIXAUTHORIZATION');
    $newArray = array();
    $depArray = array();
    $newProcessArray = array();
    $authLevel = [];
    $myVariable;

    foreach($dataAuth as $key => $value){
       ${"authLevel$key"} = "";
       ${"authLevelData$key"} = "";
    }
    
    foreach($dataProcessFlow as $rowProcess)
    {
        foreach($dataDepartMent as $key => $value){
            ${"authLevel$key"} = '<div class="com_header">AUTHORIZATION LEVEL/DEPARTMENT</div>-' . $value['AUTHORIZATION_LEVEL_NAME'].' <br><div class="dept_name">'.$value['DPMT_SNAME'].'</div>';

            $decoded_json = json_decode($value['MANAGE_SCREEN_ID'], false);
            if (in_array($rowProcess['MANAGE_SCREEN_ID'],  $decoded_json )) {
               // echo "Got =" . $rowProcess['PROCESS_FLOW_ID'];
                ${"authLevelData$key"} = '<div style="text-align:center;">1</div>';//"1 ------ > " . $rowProcess['PROCESS_FLOW_ID'] ;
            }else{
                ${"authLevelData$key"} = '<div style="text-align:center;">0</div>'; //' 0 --->' . $rowProcess['PROCESS_FLOW_ID'];
            }
        }
        $newProcessArray[] =  array(
            'MODULE' => $rowProcess['MOD_SNAME'],
            'PROCESS' => $rowProcess['PROCESS_FLOW_NAME'],
           $authLevel0 => $authLevelData0,
           $authLevel1 => $authLevelData1,
           $authLevel2 => $authLevelData2,
           $authLevel3 => $authLevelData3,
           $authLevel4 => $authLevelData4,
           $authLevel5 => $authLevelData5,
           $authLevel6 => $authLevelData6,
           $authLevel7 => $authLevelData7,
           $authLevel8 => $authLevelData8,
           $authLevel9 => $authLevelData9,
           $authLevel10 => $authLevelData10,
           $authLevel11 => $authLevelData11,
           $authLevel12 => $authLevelData12,
           $authLevel13 => $authLevelData13,
           $authLevel14 => $authLevelData14,
        );
    }
 //  $finaloutput = array_values($newArrayFinal);

    DataTables::create([
        "dataSource"=> $newProcessArray,
        "plugins" => ["Buttons"],
        "complexHeaders" => true,
       "headerSeparator" => "-",
        "options"=>array(
           // "dom" => 'Blfrtip',
            "paging"=>true,
            "pageLength" => 50,
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
        //     "Module"=>array(
        //         "label"=>"Module",
        //         "searchable" => true,
        //         "type"=>"string",
        //         "formatValue"=>function($value,$row){
        //             print_r($value);
        //            // return $row;
        //         },
        //     ),
           
        // ),
        "removeDuplicate"=>array("MODULE"),
        // "grouping"=>array(
        //     "Module",
        // ),
        "cssClass"=>array(
            "table"=>"table table-striped table-bordered",
            "th"=>"heading_title",
        ),
    ]);
        ?>
        </div>
    </body>
</html>


