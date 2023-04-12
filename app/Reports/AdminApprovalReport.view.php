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
            <h1>Approval Report</h1>
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
                        "defaultOption"=>array("Select Module"=>0),
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
                    <b>GROUP</b>
                    <?php 
                    
                    Select2::create(array(
                        "multiple"=>false,
                        "name"=>"GROUPID",
                        "defaultOption"=>array("Select GROUP"=>0),
                        "dataSource"=>$this->dataStore('MANAGEGROUP'),
                        "dataBind"=>array(
                            "text"=>"GROUP_NAME",
                            "value"=>"GROUPID",
                        ),
                        "attributes"=>array(
                            "class"=>"form-control"
                        )
                    ));
                    ?>
                </div>
                <div class="form-group">
                    <b>DEPARTMENT</b>
                    <?php 
                    Select2::create(array(
                        "multiple"=>false,
                        "name"=>"DEPARTMENTID",
                        "defaultOption"=>array("Select DEPARTMENT"=>0),
                        "dataSource"=>$this->dataStore('MANAGEDEPARTMENT'),
                        "dataBind"=>array(
                            "text"=>"DPMT_NAME",
                            "value"=>"DEPARTMENTID",
                        ),
                        "attributes"=>array(
                            "class"=>"form-control"
                        )
                    ));
                    ?>
                </div>
                <div class="form-group">
                    <b>DIVISION</b>
                    <?php 
                    Select2::create(array(
                        "multiple"=>false,
                        "name"=>"DIVISIONID",
                        "defaultOption"=>array("Select DEPARTMENT"=>0),
                        "dataSource"=>$this->dataStore('MANAGEDIVISION'),
                        "dataBind"=>array(
                            "text"=>"DIV_NAME",
                            "value"=>"DIVISIONID",
                        ),
                        "attributes"=>array(
                            "class"=>"form-control"
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
          <form method="post" action="<?php echo config('app.koolreport_server_url');?>/adminapprovalexcel">
        <!-- <a href="<?php echo config('app.koolreport_server_url');?>/adminusersummarypdf" style= margin-botom:10px;margin-right:5px;" class="btn btn-primary">Download Portrait PDF</a>
          <a href="<?php echo config('app.koolreport_server_url');?>/adminusersummarylandscapepdf" style="margin-botom:10px;margin-right:5px;" class="btn btn-primary">Download Landscape PDF</a> -->
          <input type="hidden" value="<?php echo $this->params["MODULEID"]; ?>" name="MODULEID" />
          <input type="hidden" value="<?php echo $this->params["GROUPID"]; ?>" name="GROUPID" />
          <input type="hidden" value="<?php echo $this->params["DEPARTMENTID"]; ?>" name="DEPARTMENTID" />
          <input type="hidden" value="<?php echo $this->params["DIVISIONID"]; ?>" name="DIVISIONID" />
                   <button class="btn btn-primary">Download EXCEL</button>
            </form>
        </div>
        <div style="height:20px;"></div>
        <div class="clear"></div>
    <?php
    $dataapproval = $this->dataStore('APPROVALREPORT');
    $newArrayApproval = array();
    $newArrayDistributor = array();
    $newArrayConsultant = array();
    $newArrayOthers = array();
   // $ip = "";
    foreach($dataapproval as $row)
    {
       $status="";
       if($row['APPR_STATUS'] == 0) 
       {
        $status = 'ON'; 
       }
       else{
        $status = 'OFF';  
       }
            $newArrayApproval[] =  array( 
                                    'DIVISION' => $row['DIV_NAME'],
                                    'DEPARTMENT' => $row['DPMT_NAME'],
                                    'MODULE' => $row['MOD_NAME'],
                                    'GROUP' => $row['GROUP_NAME'],
                                 'APPROVAL LEVEL' => $row['APPR_LEVEL_NAME'],
                                 'AUTHORIZATION' => $row['PROCESS_FLOW_NAME'],
                                 'STATUS' => $status,
                                 'DATE' => $row['CREATE_TIMESTAMP'],
                             );
    }
   
   
     //$newArray = array_merge($newArrayFimm,$newArrayDistributor);
    // $newArray1 = array_merge($newArrayCONSULTANT,$newArrayOthers);
    //$finalArray = array_merge($newArray,$newArray1);
   
        $finalArray = $newArrayApproval;

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
            "scrollX" => true,
            "scrollCollapse" => true,
            "buttons" => [
              "csv", "excel", "pdf", "print"
            ],
            "order"=>array(
                array(7,"desc"), //Sort by first column desc
            ),
        ),
        "searchOnEnter" => true,
        "searchMode" => "or",
        "themeBase"=>"bs4",
        "columns"=>array(
            "DIVISION"=>array(
                "label"=>"DIVISION",
               // "type"=>"number",
                "searchable" => true,
                "type"=>"string",
               // "type"=>"datetime",
               // "format"=>"Y-m-d H:i:s",
               // "displayFormat"=>"Y"
            ),
            "DEPARTMENT"=>array(
              "label"=>"DEPARTMENT",
              "type"=>"string",
              "searchable" => true,
            ),
            "MODULE"=>array(
                "label"=>"MODULE",
                "type"=>"string",
                "searchable" => true,
            ),
            "GROUP"=>array(
                "label"=>"GROUP",
                "type"=>"string",
                "searchable" => true,
            ),
            "APPROVAL LEVEL"=>array(
                "label"=>"APPROVAL LEVEL",
                "type"=>"string",
                "searchable" => true,
            ),
            "AUTHORIZATION"=>array(
                "label"=>"AUTHORIZATION",
                "type"=>"string",
                "searchable" => true,
            ),
            "STATUS"=>array(
                "label"=>"STATUS",
                "type"=>"string",
                "searchable" => true,
            ),
            "DATE"=>array(
                "label"=>"DATE",
                 "type"=>"datetime",
                "format"=>"Y-m-d H:i:s",
                "displayFormat"=>"d-M-Y"
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


