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
            <h1 class="report_title">List of Template</h1>
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
                    <button class="btn btn-primary">SEARCH</button>
                </div>
            </div>
        </div>
    </form>
    <div class="text-right">
        <!-- <div class="download_div">
            <form method="post" action="<?php echo config('app.koolreport_server_url');?>/adminidmaskingpdf">
                <button class="btn btn-primary">Download Portrait PDF</button>
            </form>
         </div>
         <div class="download_div">
            <form method="post" action="<?php echo config('app.koolreport_server_url');?>/adminidmaskinglandscapepdf">
                <button class="btn btn-primary">Download Landscape PDF</button>
            </form>
         </div> -->
         <div class="download_div">
            <form method="post" action="<?php echo config('app.koolreport_server_url');?>/admintemplatelistexcel">
            <input type="hidden" value="<?php echo $this->params["MANAGEMODULEID"]; ?>" name="MANAGEMODULEID" />
                <button class="btn btn-primary">Download EXCEL</button>
            </form>
        </div>
        </div>
        <div style="height:20px;"></div>
        <div class="clear"></div>
    <?php
      $data = $this->dataStore('FORMTEMPLATE');
      $newArray = array();
      foreach($data as $row)
    {

            $newArray[] =  array(
                                 'MODULE' => $row['MOD_NAME'],
                                 'TEMPLATE TITLE' => $row['TEMP_TITLE'],
                                 'DESCRIPTION' => $row['TEMP_DESCRIPTION'],
                                 'DOCUMENT' => '<div class="view_detail text-center"><a  href="'.config('app.koolreport_server_url').'/admintemplatefiledownload?templateId='.$row['MANAGE_FORM_TEMPLATE_ID'].'">VIEW</a></div>',
                             );
    }
    DataTables::create([
        "dataSource"=> $newArray,
        "plugins" => ["Buttons"],
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
        // "columns"=>array(
        //     "MASKING_TYPE"=>array(
        //         "label"=>"MODULE",
        //         "type"=>"string",
        //         "searchable" => true,
        //        // "format"=>"Y-m-d H:i:s",
        //        // "displayFormat"=>"Y"
        //       ),
        //       "PREFIX"=>array(
        //         "label"=>"CATEGORY",
        //         "searchable" => true,
        //         "type"=>"string",
        //     ),
        //     "RUN_NO"=>array(
        //         "label"=>"Masking ID",
        //         "searchable" => true,
        //         "type"=>"number",
        //     ),
        //     "DESCRIPTION"=>array(
        //         "label"=>"Masking Details",
        //         "searchable" => true,
        //         "type"=>"string",
        //     ),
        //     "STATUS"=>array(
        //         "label"=>"STATUS",
        //         "searchable" => true,
        //         "type"=>"string",
        //     ),
        //       "CREATE_TIMESTAMP"=>array(
        //         "label"=>"DATE",
        //         "type"=>"datetime",
        //         "format"=>"Y-m-d H:i:s",
        //           "displayFormat"=>"m/d/Y"
        //       ),
        //     "NAME"=>array(
        //         "label"=>"ADDED BY",
        //         "searchable" => true,
        //         "type"=>"string",
        //     ),
        // ),
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


