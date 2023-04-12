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
            <h1 class="report_title">ADDRESS Management REPORT </h1>
        </div>
        <div class="clear"></div>
        <form method="post" id="addressID">
        <div class="row form_row">
            <div class="col-md-6">
                <div class="form-group">
                <b>COUNTRY</b>
                <?php 
                    Select2::create(array(
                        "multiple"=>false,
                        "name"=>"COUNTRYID",
                        "defaultOption"=>array("--Select a Country"=>0),
                        "dataSource"=>$this->dataStore('COUNTRYLIST'),
                        "dataBind"=>array(
                            "text"=>"COUNTRYNAME",
                            "value"=>"COUNTRYID",
                        ),
                        "attributes"=>array(
                            "class"=>"form-control"
                        ),
                        "clientEvents"=>array(
                            "change"=>"function(e){
                                $('#addressID').submit();
                            }",
                            )
                    ));
                    ?>
                </div>
                <div class="form-group">
                <b>STATE</b>
                <?php 
                    Select2::create(array(
                        "multiple"=>false,
                        "name"=>"STATEID",
                        "defaultOption"=>array("--Select a State"=>0),
                        "dataSource"=>$this->dataStore('STATELIST'),
                        "dataBind"=>array(
                            "text"=>"STATENAME",
                            "value"=>"STATEID",
                        ),
                        "attributes"=>array(
                            "class"=>"form-control"
                        ),
                        "clientEvents"=>array(
                            "change"=>"function(e){
                                $('#addressID').submit(); 
                            }",
                            )
                    ));
                    ?>
                </div>
                <div class="form-group">
                <b>POST CODE</b>
                <?php 
                    Select2::create(array(
                        "multiple"=>false,
                        "name"=>"POSTCODEID",
                        "defaultOption"=>array("--Select a Post Code"=>0),
                        "dataSource"=>$this->dataStore('POSTLIST'),
                        "dataBind"=>array(
                            "text"=>"POSTCODENAME",
                            "value"=>"POSTCODEID",
                        ),
                        "attributes"=>array(
                            "class"=>"form-control"
                        ),
                        "clientEvents"=>array(
                            "change"=>"function(e){
                                $('#addressID').submit(); 
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
            <form method="post" action="<?php echo config('app.koolreport_server_url');?>/adminaddressmngpdf">
                <input type="hidden" value="<?php echo $this->params["COUNTRYID"]; ?>" name="COUNTRYID" />
                <input type="hidden" value="<?php echo $this->params["STATEID"]; ?>" name="STATEID" />
                <input type="hidden" value="<?php echo $this->params["POSTCODEID"]; ?>" name="POSTCODEID" />
                <button class="btn btn-primary">Download Portrait PDF</button>
            </form>
         </div>
         <div class="download_div">
            <form method="post" action="<?php echo config('app.koolreport_server_url');?>/adminaddressmnglandscapepdf">
                <input type="hidden" value="<?php echo $this->params["COUNTRYID"]; ?>" name="COUNTRYID" />
                <input type="hidden" value="<?php echo $this->params["STATEID"]; ?>" name="STATEID" />
                <input type="hidden" value="<?php echo $this->params["POSTCODEID"]; ?>" name="POSTCODEID" />
                <button class="btn btn-primary">Download Landscape PDF</button>
            </form>
         </div> -->
         <div class="download_div">
            <form method="post" action="<?php echo config('app.koolreport_server_url');?>/adminaddressmngexcel">
            <input type="hidden" value="<?php echo $this->params["COUNTRYID"]; ?>" name="COUNTRYID" />
            <input type="hidden" value="<?php echo $this->params["STATEID"]; ?>" name="STATEID" />
            <input type="hidden" value="<?php echo $this->params["POSTCODEID"]; ?>" name="POSTCODEID" />
            
                <button class="btn btn-primary">Download EXCEL</button>
            </form>
        </div>
        </div>
        <div style="height:20px;"></div>
        <div class="clear"></div>
    <?php
    $data = $this->dataStore('ADDRESSREPORT');
    $newArray = array();
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
            "COUNTRYNAME"=>array(
                "label"=>"Country",
                "searchable" => true,
                "type"=>"string",
            ),
            "STATENAME"=>array(
                "label"=>"State",
                "searchable" => true,
                "type"=>"string",
            ),
            "CITYNAME"=>array(
                "label"=>"City",
                "type"=>"string",
                "searchable" => true,
            ),
            "POSTCODE"=>array(
                "label"=>"Post Code",
                "type"=>"string",
                "searchable" => true,
            ),
            "POSTCODE_DATE"=>array(
              "label"=>"Modified Date",
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


