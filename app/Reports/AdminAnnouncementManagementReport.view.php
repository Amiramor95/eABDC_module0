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
            <h1 class="report_title">Announcement Management REPORT </h1>
        </div>
        <div class="clear"></div>
        <form method="post" id="circularID">
        <div class="row form_row">
            <div class="col-md-6">
                <div class="form-group">
                <b>DEPARTMENT</b>
                <?php 
                  
                    Select2::create(array(
                        "multiple"=>false,
                        "name"=>"MANAGEDEPARTMENTID",
                        "defaultOption"=>array("--Select a Department"=>0),
                        "dataSource"=>$this->dataStore('DEPARTMENTLIST'),
                        "dataBind"=>array(
                            "text"=>"DPMT_NAME",
                            "value"=>"MANAGEDEPARTMENTID",
                        ),
                        "attributes"=>array(
                            "class"=>"form-control"
                        ),
                        "clientEvents"=>array(
                            "change"=>"function(e){
                                $('#circularID').submit();
                            }",
                            )
                    ));
                    ?>
                </div>
                <div class="form-group">
                <b>Date Range</b>
                <?php
                DateRangePicker::create(array(
                "name"=>"dateRange",
              //  "format"=>"MMM Do, YYYY", //Jul 3rd, 2017
              "format"=>"YYYY-M-D",
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
                    <button class="btn btn-primary">SEARCH</button>
                </div>
            </div>
        </div>
    </form>


    <div class="text-right">
        <!-- <div class="download_div">
            <form method="post" action="<?php echo config('app.koolreport_server_url');?>/adminannouncementmngpdf">
            <input type="hidden" value="<?php echo $this->params["MANAGEDEPARTMENTID"]; ?>" name="MANAGEDEPARTMENTID" />
                <input type="hidden" value="<?php echo $this->params["dateRange"][0]; ?>" id="dateRange_start" name="dateRange[]" />
                <input type="hidden" value="<?php echo $this->params["dateRange"][1]; ?>" id="dateRange_end" name="dateRange[]" />
                <button class="btn btn-primary">Download Portrait PDF</button>
            </form>
         </div>
         <div class="download_div">
            <form method="post" action="<?php echo config('app.koolreport_server_url');?>/adminannouncementmnglandscapepdf">
            <input type="hidden" value="<?php echo $this->params["MANAGEDEPARTMENTID"]; ?>" name="MANAGEDEPARTMENTID" />
                <input type="hidden" value="<?php echo $this->params["dateRange"][0]; ?>" id="dateRange_start" name="dateRange[]" />
                <input type="hidden" value="<?php echo $this->params["dateRange"][1]; ?>" id="dateRange_end" name="dateRange[]" />
                <button class="btn btn-primary">Download Landscape PDF</button>
            </form>
         </div> -->
         <div class="download_div">
            <form method="post" action="<?php echo config('app.koolreport_server_url');?>/adminannouncementmngexcel">
            <input type="hidden" value="<?php echo $this->params["MANAGEDEPARTMENTID"]; ?>" name="MANAGEDEPARTMENTID" />
                <input type="hidden" value="<?php echo $this->params["dateRange"][0]; ?>" id="dateRange_start" name="dateRange[]" />
                <input type="hidden" value="<?php echo $this->params["dateRange"][1]; ?>" id="dateRange_end" name="dateRange[]" />
                <button class="btn btn-primary">Download EXCEL</button>
            </form>
           
        </div>
        </div>
        <div style="height:20px;"></div>
        <div class="clear"></div>
    <?php
    $data = $this->dataStore('CIRCULARREPORT');
    $data2 = $this->dataStore('DISTRIBUTORTYPELIST');
    $data3 = $this->dataStore('CONSULTANTTYPELIST');
   // print_r($data_queryB);
    $newArrayDist = array();
    $newArrayDept = array();
    $newArrayCon = array();
    $newArrayother = array();
    $status="";
    $categoryname=array();
    foreach($data2 as $row2)
    {
        $newArrayDept[] = array(
                           'TYPENAME' => $row2['DIST_TYPE_NAME'],
                           'TYPEID' => $row2['DISTRIBUTOR_TYPE_ID'],
        );
    }
    foreach($data3 as $row3)
    {
        $newArrayCon[] = array(
                           'TYPENAME' => $row3['TYPE_NAME'],
                           'TYPEID' => $row3['CONSULTANT_TYPE_ID'],
        );
    }

    $newArrayother[0] = array(
    'TYPENAME' =>"3rd Party",
    'TYPEID' => 13,
    );
    $newArrayother[1] = array(
    'TYPENAME' =>"Training Provider",
    'TYPEID' => 14,
    );
    
    foreach($data as $row)
    {
        $decoded_json = json_decode($row['CATEGORY'], false);
        $decoded_json1 = json_decode($row['CONSULTATCATEGORY'], false);
        $decoded_json2 = json_decode($row['OTHERCATEGORY'], false);

        $respectiveNames = array();
        if(isset($decoded_json) && sizeof($decoded_json) > 0){
            foreach($decoded_json as $de){
                foreach($newArrayDept as $dj){
                    if( $dj['TYPEID'] == $de){
                        $respectiveNames[] = $dj['TYPENAME'];
                    }
                }
            }
        }

        if(isset($decoded_json1) && sizeof($decoded_json1) > 0){
            foreach($decoded_json1 as $de1){
                foreach($newArrayCon as $dj1){
                    if( $dj1['TYPEID'] == $de1){
                        $respectiveNames[] = $dj1['TYPENAME'];
                    }
                }
            }
        }
        if(isset($decoded_json2) && sizeof($decoded_json2) > 0){
            foreach($decoded_json2 as $de2){
                foreach($newArrayother as $dj2){
                    if( $dj2['TYPEID'] == $de2){
                        $respectiveNames[] = $dj2['TYPENAME'];
                    }
                }
            }
        }
      
        if($row['STATUS'] == 1){
            $status = "PENDING FOR HOD APPROVAL";
          }else if($row['STATUS'] == 2){
            $status = "PENDING FOR GM APPROVAL";
          }else if($row['STATUS'] == 3){
            $status =  "RETURN BY HOD";
          }else if($row['STATUS'] == 4){
            $status = "APPROVED BY GM";
          }else if($row['STATUS'] == 5){
            $status = "RETURN BY GM";
          }else if($row['STATUS'] == 6){
            $status = "REJECTED";
          }else{
            $status = "DRAFT";
          }
        //  echo $status;

            $newArrayDist[] =  array(
                                 'DEPARTMENT' => $row['DNAME'],
                                 'CATEGORY' => implode(', ', $respectiveNames), 
                                 'ETITLE' => $row['EVENT_TITLE'],
                                 'STARTDATE' => $row['STARTDATE'],
                                 'ENDDATE' => $row['ENDDATE'],
                                 'YEAR' => $row['YEAR'],
                                 'MONTH' => $row['MONTH'],
                                 'CUSER' => $row['CUSER'],
                                 'STATUS' => $status,
                             );
    }
    
    DataTables::create([
        "dataSource"=>$newArrayDist,
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
            "DEPARTMENT"=>array(
                "label"=>"DEPARTMENT",
                "searchable" => true,
                "type"=>"string",
            ),
            "CATEGORY"=>array(
                "label"=>"CATEGORY",
                "searchable" => true,
                "type"=>"string",
            ),
            "ETITLE"=>array(
                "label"=>"ANNOUNCEMENT",
                "type"=>"string",
                "searchable" => true,
                // "cssStyle" =>'text-align:right',
            ),
             "STARTDATE"=>array(
              "label"=>"PUBLISH DATE",
              "type"=>"datetime",
              "format"=>"Y-m-d H:i:s",
              "displayFormat"=>"Y-m-d"
            ),
            // "ENDDATE"=>array(
            //     "label"=>"END DATE",
            //     "type"=>"datetime",
            //     "format"=>"Y-m-d H:i:s",
            //     "displayFormat"=>"Y-m-d"
            //   ),
              "YEAR"=>array(
                "label"=>"YEAR",
                "type"=>"datetime",
                "format"=>"Y",
                "displayFormat"=>"Y"
              ),
              "MONTH"=>array(
                "label"=>"MONTH",
                "type"=>"datetime",
                "format"=>"m",
                "displayFormat"=>"F"
              ),
              "CUSER"=>array(
                "label"=>"SUBMITTED USER",
                "searchable" => true,
                "type"=>"string",
            ),
            "STATUS"=>array(
                "label"=>"APPROVE BY",
                "searchable" => true,
                "type"=>"string",
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


