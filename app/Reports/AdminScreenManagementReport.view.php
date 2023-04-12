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
            <h1 class="report_title">Screen Management REPORT </h1>
        </div>
        <div class="clear"></div>
        <form method="post" id="screenID">
        <div class="row form_row">
            <div class="col-md-6">
                <div class="form-group">
                <b>MODULE</b>
                <?php 
                    Select2::create(array(
                        "multiple"=>false,
                        "name"=>"MANAGEMODULEID",
                        "defaultOption"=>array("--Select a Module"=>0),
                        "dataSource"=>$this->dataStore('MODULELIST'),
                        "dataBind"=>array(
                            "text"=>"MOD_NAME",
                            "value"=>"MANAGEMODULEID",
                        ),
                        "attributes"=>array(
                            "class"=>"form-control"
                        ),
                        "clientEvents"=>array(
                            "change"=>"function(e){
                                $('#screenID').submit();
                            }",
                            )
                    ));
                    ?>
                </div>
                <div class="form-group">
                <b>GROUP</b>
                <?php 
                    Select2::create(array(
                        "multiple"=>false,
                        "name"=>"SUBMANAGEMODULEID",
                        "defaultOption"=>array("--Select a Module"=>0),
                        "dataSource"=>$this->dataStore('SUBMODULELIST'),
                        "dataBind"=>array(
                            "text"=>"SUBMOD_NAME",
                            "value"=>"SUBMANAGEMODULEID",
                        ),
                        "attributes"=>array(
                            "class"=>"form-control"
                        ),
                        "clientEvents"=>array(
                            "change"=>"function(e){
                                $('#screenID').submit(); 
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
            <form method="post" action="<?php echo config('app.koolreport_server_url');?>/adminscreenmngpdf">
                <input type="hidden" value="<?php echo $this->params["MANAGEMODULEID"]; ?>" name="MANAGEMODULEID" />
                <input type="hidden" value="<?php echo $this->params["SUBMANAGEMODULEID"]; ?>" name="SUBMANAGEMODULEID" />
                <button class="btn btn-primary">Download Portrait PDF</button>
            </form>
         </div>
         <div class="download_div">
            <form method="post" action="<?php echo config('app.koolreport_server_url');?>/adminscreenmnglandscapepdf">
                <input type="hidden" value="<?php echo $this->params["MANAGEMODULEID"]; ?>" name="MANAGEMODULEID" />
                <input type="hidden" value="<?php echo $this->params["SUBMANAGEMODULEID"]; ?>" name="SUBMANAGEMODULEID" />
                <button class="btn btn-primary">Download Landscape PDF</button>
            </form>
         </div> -->
         <div class="download_div">
            <form method="post" action="<?php echo config('app.koolreport_server_url');?>/adminscreenmngexcel">
            <input type="hidden" value="<?php echo $this->params["MANAGEMODULEID"]; ?>" name="MANAGEMODULEID" />
                <input type="hidden" value="<?php echo $this->params["SUBMANAGEMODULEID"]; ?>" name="SUBMANAGEMODULEID" />
                <button class="btn btn-primary">Download EXCEL</button>
            </form>
           
        </div>
        </div>
        <div style="height:20px;"></div>
        <div class="clear"></div>
    <?php
    $data = $this->dataStore('SCREENREPORT');
   // print_r($data_queryB);
    $newArray = array();
    // foreach($data as $row)
    // {

    //     if($row['SMS_STATUS'] == 0)
    //     {
    //         $status = 'Failed';
    //     }
    //     else{
    //         $status = 'Success';
    //     }
    //         $newArray[] =  array(
    //                              'COMPANY' => "FIMM",
    //                              'DATE & TIME' => $row['DATE_SEND'],
    //                              'RECIPIENT' => $row['SMS_RECIPIENT'],
    //                              'MESSAGE' => $row['MESSAGE'],
    //                              'STATUS' => $status,
    //                          );
    // }

    DataTables::create([
        "dataSource"=>$data,
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
            "SCREEN_CODE"=>array(
                "label"=>"Screen Code",
                "searchable" => true,
                "type"=>"string",
            ),
            "SCREEN_NAME"=>array(
                "label"=>"Screen Name",
                "searchable" => true,
                "type"=>"string",
            ),
            // "'DATE & TIME"=>array(
            //   "label"=>"DATE & TIME",
            //   "type"=>"datetime",
            //   "format"=>"Y-m-d H:i:s",
            //   "displayFormat"=>"Y-m-d H:i:s"
            // ),
            "SCREEN_ROUTE"=>array(
                "label"=>"Path",
                "type"=>"string",
                "searchable" => true,
            ),
            "MOD_NAME"=>array(
                "label"=>"Module",
                "type"=>"string",
                "searchable" => true,
            ),
            "MOD_NAME"=>array(
                "label"=>"Module",
                "type"=>"string",
                "searchable" => true,
            ),
            "SUBMOD_NAME"=>array(
                "label"=>"Group",
                "type"=>"string",
                "searchable" => true,
            )
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


