<?php
use \koolreport\widgets\koolphp\Table;
use \koolreport\inputs\Select2;
use \koolreport\inputs\DateRangePicker;
use \koolreport\datagrid\DataTables;
use \koolreport\core\Utility as Util;
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
   
</style>
<html>
    <body>
    <div class="report-content">

        <div class="text-center">
            <h1 class="report_title">Fee Management REPORT </h1>
        </div>
        <div class="clear"></div>
        <form method="post" id="feeID">
        <div class="row form_row">
            <div class="col-md-6">
                <div class="form-group">
                <b>MODULE</b>
                <?php 
                   $ModuleArray = array();
                   $ModuleArray[0] =  array(
                    'MOD_NAME' => "DISTRIBUTOR",
                    'MODEID' => 1,
                );
                $ModuleArray[1] =  array(
                    'MOD_NAME' => "CONSULTANT",
                    'MODEID' => 2,
                );
                $ModuleArray[2] =  array(
                    'MOD_NAME' => "WAIVER",
                    'MODEID' => 3,
                );
                    Select2::create(array(
                        "multiple"=>false,
                        "name"=>"MODEID",
                        "defaultOption"=>array("--Select a Module"=>0),
                        "dataSource"=>$ModuleArray,
                        "dataBind"=>array(
                            "text"=>"MOD_NAME",
                            "value"=>"MODEID",
                        ),
                        "attributes"=>array(
                            "class"=>"form-control"
                        ),
                        "clientEvents"=>array(
                            "change"=>"function(e){
                                $('#feeID').submit();
                            }",
                            )
                    ));
                    ?>
                </div>
                <div class="form-group">
                <b>CATEGORY</b>
                <?php 
                    Select2::create(array(
                        "multiple"=>false,
                        "name"=>"CATEGORYID",
                        "defaultOption"=>array("--Select a Module"=>0),
                        "dataSource"=>$this->dataStore('CATEGORYLIST'),
                        "dataBind"=>array(
                            "text"=>"CATEGORYNAME",
                            "value"=>"CATEGORYID",
                        ),
                        "attributes"=>array(
                            "class"=>"form-control"
                        ),
                        "clientEvents"=>array(
                            "change"=>"function(e){
                                $('#feeID').submit(); 
                            }",
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
        <!-- <div class="download_div">
            <form method="post" action="<?php echo config('app.koolreport_server_url');?>/adminfeemngpdf">
                <input type="hidden" value="<?php echo $this->params["MODEID"]; ?>" name="MODEID" />
                <input type="hidden" value="<?php echo $this->params["CATEGORYID"]; ?>" name="CATEGORYID" />
                <button class="btn btn-primary">Download Portrait PDF</button>
            </form>
         </div>
         <div class="download_div">
            <form method="post" action="<?php echo config('app.koolreport_server_url');?>/adminfeemnglandscapepdf">
                <input type="hidden" value="<?php echo $this->params["MODEID"]; ?>" name="MODEID" />
                <input type="hidden" value="<?php echo $this->params["CATEGORYID"]; ?>" name="CATEGORYID" />
                <button class="btn btn-primary">Download Landscape PDF</button>
            </form>
         </div> -->
         <div class="download_div">
            <form method="post" action="<?php echo config('app.koolreport_server_url');?>/adminfeemngexcel">
            <input type="hidden" value="<?php echo $this->params["MODEID"]; ?>" name="MODEID" />
                <input type="hidden" value="<?php echo $this->params["CATEGORYID"]; ?>" name="CATEGORYID" />
                <button class="btn btn-primary">Download EXCEL</button>
            </form>
           
        </div>
        </div>
        <div style="height:20px;"></div>
        <div class="clear"></div>
    <?php
    $data = $this->dataStore('DISTRIBUTORFEEREPORT');
    $data2 = $this->dataStore('CONSULTANTFEEREPORT');
    $data3 = $this->dataStore('WAIVERFEEREPORT');
   // print_r($data_queryB);
    $newArrayDist = array();
    $newArrayCon = array();
    $newArrayWaiver = array();
    foreach($data as $row)
    {

            $newArrayDist[] =  array(
                                 'MODULE' => "DISTRIBUTOR",
                                 'CATEGORY' => $row['CATEGORY'],
                                 'AMOUNT' => $row['AMOUNT'],
                                 'STARTDATE' => $row['STARTDATE'],
                                 'ENDDATE' => $row['ENDDATE'],
                                 'EFFECTIVEDATE' => $row['STARTDATE'],
                             );
    }
    foreach($data2 as $row1)
    {

            $newArrayCon[] =  array(
                                 'MODULE' => "CONSULTANT",
                                 'CATEGORY' => $row1['CATEGORY'],
                                 'AMOUNT' => $row1['AMOUNT'],
                                 'STARTDATE' => $row1['STARTDATE'],
                                 'ENDDATE' => $row1['STARTDATE'],
                                 'EFFECTIVEDATE' => $row1['STARTDATE'],
                             );
    }
    foreach($data3 as $row2)
    {

            $newArrayWaiver[] =  array(
                                 'MODULE' => "WAIVER",
                                 'CATEGORY' => $row2['CATEGORY'],
                                 'AMOUNT' => $row2['AMOUNT'],
                                 'STARTDATE' => $row2['STARTDATE'],
                                 'ENDDATE' => $row2['ENDDATE'],
                                 'EFFECTIVEDATE' => $row2['STARTDATE'],
                             );
    }
    $newArray = array_merge($newArrayDist,$newArrayCon);
    $finalArray = array_merge($newArray,$newArrayWaiver);
    DataTables::create([
        "dataSource"=>$finalArray,
        "plugins" => ["Buttons"],
        //"complexHeaders" => true,
       // "headerSeparator" => "-",
        "options"=>array(
           // "dom" => 'Blfrtip',
            "paging"=>true,
            "pageLength" => 10,
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
            "MODULE"=>array(
                "label"=>"MODULE",
                "searchable" => true,
                "type"=>"string",
            ),
            "CATEGORY"=>array(
                "label"=>"CATEGORY",
                "searchable" => true,
                "type"=>"string",
            ),
            "AMOUNT"=>array(
                "label"=>"AMOUNT",
                "type"=>"number",
                "searchable" => true,
                 "cssStyle" =>'text-align:right',
            ),
             "STARTDATE"=>array(
              "label"=>"START DATE",
              "type"=>"datetime",
              "format"=>"Y-m-d H:i:s",
              "displayFormat"=>"Y-m-d"
            ),
            "ENDDATE"=>array(
                "label"=>"END DATE",
                "type"=>"datetime",
                "format"=>"Y-m-d H:i:s",
                "displayFormat"=>"Y-m-d"
              ),
              "EFFECTIVEDATE"=>array(
                "label"=>"EFFECTIVE DATE",
                "type"=>"datetime",
                "format"=>"Y-m-d H:i:s",
                "displayFormat"=>"Y-m-d"
              ),
        ),
        "cssClass"=>array(
            "table"=>"table table-striped table-bordered",
            "th"=>"heading_title",
        ),
    ]);
        ?>
        </div>
    </body>
</html>


