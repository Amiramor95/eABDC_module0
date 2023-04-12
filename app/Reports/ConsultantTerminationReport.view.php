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
    .form_row{
        margin-right:20px !important;
        margin-left:10px !important;
    }
    .searchForm .row{
        display: block;
    }
    .searchForm .col-md-6{
        margin: 10px;
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
            <h1>Consultants Termination Report</h1>
        </div>
        <form method="post" id="consultantForm" class="searchForm">
        <div class="row form_row">
        <div class="form-group">
            <div class="col-md-6">
            <b>TERMINATION DATE</b>
                <?php
                DateRangePicker::create(array(
                "name"=>"dateRange",
               // "format"=>"MMM Do, YYYY", //Jul 3rd, 2017
                 "format"=>"d-MMM-Y",
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
            </div>
                <div class="form-group">
                <div class="col-md-6">
                <b>SCHEME</b>
                <?php 
                    Select2::create(array(
                        "multiple"=>false,
                        "name"=>"SCHEMEID",
                        "defaultOption"=>array("All"=>0),
                        "dataSource"=>$this->dataStore('CONSULTANTSCHEME'),
                        "dataBind"=>array(
                            "text"=>"TYPE_SCHEME",
                            "value"=>"SCHEMEID",
                        ),
                        "attributes"=>array(
                            "class"=>"form-control"
                        ),
                        // "clientEvents"=>array(
                        //     "change"=>"function(e){
                        //         $('#consultantForm').submit();
                        //     }",
                        //     )
                    ));
                    ?>
                </div>
                </div>
               
                <div class="form-group">
                <div class="col-md-6">
                <b>DISTRIBUTOR</b>
                <?php
                Select2::create(array(
                    "multiple"=>true,
                    "name"=>"DISTRIBUTORIDS",
                    "defaultOption"=>array("All"=>0),
                    "dataSource"=>$this->dataStore("CONSULTANTDISTRIBUTOR"),
                    "dataBind"=>array(
                                "text"=>"DIST_NAME",
                                "value"=>"DISTRIBUTORID",
                            ),
                    // "clientEvents"=>array(
                    //     "change"=>"function(e){
                    //         $('#consultantForm').submit(); 
                    //     }",
                    // ),
                    "attributes"=>array(
                        "class"=>"form-control"
                    )
                ));
                    ?>
                </div>
                </div>
                <div class="form-group">
                <div class="col-md-6">
                <b>TERMINATION TYPE</b>
                <?php 
                    Select2::create(array(
                        "multiple"=>false,
                        "name"=>"TERMINATIONTYPEID",
                        "defaultOption"=>array("All"=>0),
                        "dataSource"=>$this->dataStore('CONSULTANTTERMINATION'),
                        "dataBind"=>array(
                            "text"=>"TERMINATIONTYPENAME",
                            "value"=>"TERMINATIONTYPEID",
                        ),
                        "attributes"=>array(
                            "class"=>"form-control"
                        ),
                        // "clientEvents"=>array(
                        //     "change"=>"function(e){
                        //         $('#consultantForm').submit();
                        //     }",
                        //     )
                    ));
                    ?>
                </div>
                </div>
               
                <div class="form-group">
                <div class="col-md-6">
                    <button class="btn btn-primary">SEARCH</button>
                </div>
            </div>
        </div>
    </form>
        <div class="clear"></div>
        <div class="text-right">
        <!-- <div class="download_div">
            <form method="post" action="<?php echo config('app.koolreport_server_url');?>/consultantterminationpdf">
                <?php
                foreach ($this->params['DISTRIBUTORIDS'] as  $value) {
                ?>
                  <input type="hidden" name="DISTRIBUTORIDS[]" value="<?php echo $value; ?>">
                <?php
                }
                ?>
                <input type="hidden" value="<?php echo $this->params["SCHEMEID"]; ?>" name="SCHEMEID" />
                <input type="hidden" value="<?php echo $this->params["TERMINATIONTYPEID"]; ?>" name="TERMINATIONTYPEID" />
                <input type="hidden" value="<?php echo $this->params["dateRange"][0]; ?>" id="dateRange_start" name="dateRange[]" />
                <input type="hidden" value="<?php echo $this->params["dateRange"][1]; ?>" id="dateRange_end" name="dateRange[]" />
                <button class="btn btn-primary">Download Portrait PDF</button>
            </form>
         </div>
         <div class="download_div">
            <form method="post" action="<?php echo config('app.koolreport_server_url');?>/consultantterminationlandscapepdf">
            <?php
                foreach ($this->params['DISTRIBUTORIDS'] as  $value) {
                ?>
                  <input type="hidden" name="DISTRIBUTORIDS[]" value="<?php echo $value; ?>">
                <?php
                }
                ?>
                  <input type="hidden" value="<?php echo $this->params["SCHEMEID"]; ?>" name="SCHEMEID" />
                <input type="hidden" value="<?php echo $this->params["TERMINATIONTYPEID"]; ?>" name="TERMINATIONTYPEID" />
                <input type="hidden" value="<?php echo $this->params["dateRange"][0]; ?>" id="dateRange_start" name="dateRange[]" />
                <input type="hidden" value="<?php echo $this->params["dateRange"][1]; ?>" id="dateRange_end" name="dateRange[]" />
                <button class="btn btn-primary">Download Landscape PDF</button>
            </form>
         </div> -->
         <div class="download_div">
            <form method="post" action="<?php echo config('app.koolreport_server_url');?>/consultantterminationexcel">
            <?php
                foreach ($this->params['DISTRIBUTORIDS'] as  $value) {
                ?>
                  <input type="hidden" name="DISTRIBUTORIDS[]" value="<?php echo $value; ?>">
                <?php
                }
                ?>
                  <input type="hidden" value="<?php echo $this->params["SCHEMEID"]; ?>" name="SCHEMEID" />
                <input type="hidden" value="<?php echo $this->params["TERMINATIONTYPEID"]; ?>" name="TERMINATIONTYPEID" />
                <input type="hidden" value="<?php echo $this->params["dateRange"][0]; ?>" id="dateRange_start" name="dateRange[]" />
                <input type="hidden" value="<?php echo $this->params["dateRange"][1]; ?>" id="dateRange_end" name="dateRange[]" />
                <button class="btn btn-primary">Download EXCEL</button>
            </form>
        </div>
        </div>
        <div style="height:20px;"></div>
        <div class="clear"></div>
    <?php
    $datacon = $this->dataStore('CONSULTANTTERMINATIONREPORT');
    $datatype = $this->dataStore('DISTRIBUTORTYPE');
    $dataapproval = $this->dataStore('APPROVALLATEST');
    $newArrayDept = array();
    $newArrayApp = array();
    foreach($datatype as $row2)
    {
        $newArrayDept[] = array(
                           'DISTID' => $row2['DIST_ID'],
                           'TYPENAME' => $row2['DIST_TYPE_NAME'],
        );
    }
   
    $newArrayCon = array();
    $uts = "";
    $prs = "";
    $consID = array();
    $conPRSID = array();
    $consStatusTag = array();
    foreach($datacon as $row)
    {
        // $respectiveNames = array();
        // foreach($newArrayDept as $dj){
        //     if( $dj['DISTID'] == $row['DID']){
        //         $respectiveNames[] = $dj['TYPENAME'];
        //     }
        // }

        $respectiveUpdateBy = array();
        $respectiveUpdate = array();
     
        // if( $row['CONSULTANT_ID'] == $row['CID'] && $row['CONSULTANT_TYPE_ID'] == $row['CTYPEID']){
        //     $respectiveUpdateBy[] = $row['FIMM_LATEST_UPDATE_BY'];
        //     $respectiveUpdate[] =  date("d-M-Y", strtotime($row['FIMM_LATEST_UPDATE']));
        // }
            $newArrayCon[] =  array( 
                                 'NAME' => $row['CNAME'],
                                 'NRIC' => $row['NRIC'],
                                 'PASSPORT' => $row['PASSPORT'],
                                 'FIMM NO' => $row['FIMMNO'],
                                  'SCHEME' => $row['TYPE_SCHEME'],
                                  'DISTRIBUTOR' => $row['DIST_NAME'],
                                  //'TYPE' => implode(', ', $respectiveNames),
                                  'TERMINATION TYPE' => $row['STATUS'],
                                  'TERMINATION SUBTYPE' => $row['TERMINATION_TYPE_STATUS'],
                                  'REMARK' => $row['REMARK'],
                                  'TERMINATION DATE' => $row['TERMINATION_DATE'],
                             );
    }

    // $newArray = array_merge($newArrayFimm,$newArrayDistributor);
    // $newArray1 = array_merge($newArrayCONSULTANT,$newArrayOthers);
    //$finalArray = array_merge($newArray,$newArray1);
    DataTables::create([
        "dataSource"=>$newArrayCon,
        "plugins" => ["Buttons"],
        "complexHeaders" => true,
        "headerSeparator" => "-",
        "options"=>array(
           // "dom" => 'Blfrtip',
            "paging"=>true,
            "pageLength" => 10,
            "searching"=>true,
            "colReorder"=>true,
              "scrollY" => "600px",
             "scrollX" => true,
              "scrollCollapse" => true,
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


