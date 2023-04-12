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
    .downloadlink{
        margin-right: 10px;
    }
    .form_row{
        margin-right:20px !important;
        margin-left:10px !important;
    }
    .dataTables_length{
        display: none !important;
    }
    .date-range-picker{
        width: 40% !important;
    }
    .download_div{
        display:inline-block;
        margin-right: 10px;
    }
</style>
<html>
    <body>
    <?php 
        //echo  $logoSrc = url('/')."/koolreport_assets/3186757410/KoolReport.js";
    ?>

        <div class="text-center">
            <h1>UTC TAGGING LIST REPORT</h1>
        </div>
        <div class="clear"></div>
        <form method="post">
        <div class="row form_row">
            <div class="col-md-6">
            <div class="form-group">
                    <b>Status</b>
                    <?php 
                    Select2::create(array(
                        "multiple"=>true,
                        "name"=>"STATUSIDS",
                        "defaultOption"=>array("Please Select Status"=>0),
                        "dataSource"=>$this->dataStore('CASSTATUS'),
                        "dataBind"=>array(
                            "text"=>"SET_PARAM",
                            "value"=>"STATUSID",
                        ),
                        "attributes"=>array(
                            "class"=>"form-control"
                        )
                    ));
                    ?>
                </div>
                <div class="form-group">
                    <b>COMPANY</b>
                    <?php 
                    Select2::create(array(
                        "multiple"=>true,
                        "name"=>"DISTRIBUTORIDS",
                        "defaultOption"=>array("Please Select Company"=>0),
                        "dataSource"=>$this->dataStore('CASCOMPANY'),
                        "dataBind"=>array(
                            "text"=>"DIST_NAME",
                            "value"=>"DISTRIBUTORID",
                        ),
                        "attributes"=>array(
                            "class"=>"form-control"
                        )
                    ));
                    ?>
                </div>
                <div class="form-group">
                    <b>Type of License</b>
                    <?php 
                    Select2::create(array(
                        "multiple"=>true,
                        "name"=>"TYPEIDS",
                        "defaultOption"=>array("Please Select Type"=>0),
                        "dataSource"=>$this->dataStore('CASCONSULTANTTYPE'),
                        "dataBind"=>array(
                            "text"=>"TYPE_NAME",
                            "value"=>"TYPEID",
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
             // "format"=>"YYYY-M-D",
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
        <div class="text-right">
        <div class="download_div">
            <form method="post" action="<?php echo config('app.koolreport_server_url');?>/casutcexcel">
            <?php
                foreach ($this->params['DISTRIBUTORIDS'] as  $value) {
                ?>
                  <input type="hidden" name="DISTRIBUTORIDS[]" value="<?php echo $value; ?>">
                <?php
                }
                ?>
                <?php
                foreach ($this->params['TYPEIDS'] as  $value1) {
                ?>
                 <input type="hidden" name="TYPEIDS[]" value="<?php echo $value1; ?>">
                <?php
                }
                ?>
                <?php
                foreach ($this->params['STATUSIDS'] as  $value2) {
                ?>
                 <input type="hidden" name="STATUSIDS[]" value="<?php echo $value2; ?>">
                <?php
                }
                ?>
                <input type="hidden" value="<?php echo $this->params["dateRange"][0]; ?>" id="dateRange_start" name="dateRange[]" />
                <input type="hidden" value="<?php echo $this->params["dateRange"][1]; ?>" id="dateRange_end" name="dateRange[]" />  
                <button class="btn btn-primary">Download EXCEL</button>
            </form>
        </div>
       
        </div>
        <div class="clear"></div>
     <?php

    DataTables::create([
            "dataSource"=>$this->dataStore("CONSULTANTS"),
            //"themeBase" => "bs4",
            "plugins" => ["Buttons"],
            "options"=>array(
               // "dom" => 'Blfrtip',
                "paging"=>true,
                "pageLength" => 10,
                "searching"=>true,
               // "fixedHeader"=>true,
                "colReorder"=>true,
                "complexHeaders" => true,
                "headerSeparator" => "-",
                "showFooter"=>true,
               // "showFooter"=>true,
                "buttons" => [
                  "csv", "excel", "pdf", "print"
                    
                ],
            ),
            "searchOnEnter" => true,
            "searchMode" => "or",
            "themeBase"=>"bs4",
            "columns"=>array(
                "CONSULTANT_NAME"=>array(
                    "label"=>"NAME",
                    "type"=>"string",
                    "searchable" => true,
                ),
                "CONSULTANT_NRIC"=>array(
                  "label"=>"NRIC NO",
                  "type"=>"string",
                  "searchable" => true,
                ),
                "CONSULTANT_PASSPORT_NO"=>array(
                    "label"=>"PASSPORT NO",
                    "type"=>"string",
                ),
                "TYPE_NAME"=>array(
                    "label"=>"TYPE OF LICENSE",
                    "type"=>"string",
                ),
                "CONSULTANT_FIMM_NO"=>array(
                    "label"=>"FIMM NO",
                    "type"=>"string",
                ),
                "SET_PARAM"=>array(
                    "label"=>"STATUS",
                    "type"=>"string",
                ),
                "DIST_NAME"=>array(
                    "label"=>"COMPANY",
                    "type"=>"string",
                ),
                "START_DATE"=>array(
                    "label"=>"START DATE",
                    "type"=>"datetime",
                    "format"=>"Y-m-d H:i:s",
                    "displayFormat"=>"d-M-Y"
                ),
                "UPDATE_DATE"=>array(
                    "label"=>"UPDATE/COMPLAINT DATE",
                    "type"=>"datetime",
                    "format"=>"Y-m-d H:i:s",
                    "displayFormat"=>"d-M-Y"
                ),
            ),
            "cssClass"=>array(
                "table"=>"table table-bordered table-striped"
            )
        ]);
        ?>
    </body>
</html>


