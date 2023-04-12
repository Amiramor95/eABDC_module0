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
    .reportFooter{
        text-align: center;
        height: 50px;
    }
    .reportHeader{
        text-align: center;
    }
    .text_center{
        text-align: center; 
    }
    .reportLabel{
        text-align: center; 
    }
</style>
<html>
    <body>
    <div class="report-content">

        <div class="text-center">
            <h1>Distributor Points Report</h1>
        </div>
        <form method="post" id="consultantForm" class="searchForm">
        <div class="row form_row">
        <div class="form-group">
            <div class="col-md-6">
            <b>DISTRIBUTOR</b>
                <?php
                Select2::create(array(
                    "multiple"=>true,
                    "name"=>"DISTRIBUTORIDS",
                    "defaultOption"=>array("All"=>0),
                    "dataSource"=>$this->dataStore("DISTRIBUTORLIST"),
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
                <b>STATE</b>
                <?php 
                    Select2::create(array(
                        "multiple"=>false,
                        "name"=>"SETTING_GENERAL_ID",
                        "defaultOption"=>array("All"=>0),
                        "dataSource"=>$this->dataStore('STATELIST'),
                        "dataBind"=>array(
                            "text"=>"SET_PARAM",
                            "value"=>"SETTING_GENERAL_ID",
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
                <b>STATUS</b>
                <?php 
                    Select2::create(array(
                        "multiple"=>false,
                        "name"=>"TS_ID",
                        "defaultOption"=>array("All"=>0),
                        "dataSource"=>$this->dataStore('STATUSLIST'),
                        "dataBind"=>array(
                            "text"=>"TS_PARAM",
                            "value"=>"TS_ID",
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
            <form method="post" action="<?php echo config('app.koolreport_server_url');?>/distributorpointpdf">
            <?php
                foreach ($this->params['DISTRIBUTORIDS'] as  $value) {
                ?>
                  <input type="hidden" name="DISTRIBUTORIDS[]" value="<?php echo $value; ?>">
                <?php
                }
                ?>
                  <input type="hidden" value="<?php echo $this->params["SETTING_GENERAL_ID"]; ?>" name="SETTING_GENERAL_ID" />
                  <input type="hidden" value="<?php echo $this->params["TS_ID"]; ?>" name="TS_ID" />
                <button class="btn btn-primary">Download Portrait PDF</button>
            </form>
         </div>
         <div class="download_div">
            <form method="post" action="<?php echo config('app.koolreport_server_url');?>/distributorpointlandscapepdf">
            <?php
                foreach ($this->params['DISTRIBUTORIDS'] as  $value) {
                ?>
                  <input type="hidden" name="DISTRIBUTORIDS[]" value="<?php echo $value; ?>">
                <?php
                }
                ?>
                <input type="hidden" value="<?php echo $this->params["SETTING_GENERAL_ID"]; ?>" name="SETTING_GENERAL_ID" />
                  <input type="hidden" value="<?php echo $this->params["TS_ID"]; ?>" name="TS_ID" />
                <button class="btn btn-primary">Download Landscape PDF</button>
            </form>
         </div> -->
         <div class="download_div">
            <form method="post" action="<?php echo config('app.koolreport_server_url');?>/distributorpointexcel">
            <?php
                foreach ($this->params['DISTRIBUTORIDS'] as  $value) {
                ?>
                  <input type="hidden" name="DISTRIBUTORIDS[]" value="<?php echo $value; ?>">
                <?php
                }
                ?>
                <input type="hidden" value="<?php echo $this->params["SETTING_GENERAL_ID"]; ?>" name="SETTING_GENERAL_ID" />
                  <input type="hidden" value="<?php echo $this->params["TS_ID"]; ?>" name="TS_ID" />
                <button class="btn btn-primary">Download EXCEL</button>
            </form>
        </div>
        </div>
        <div style="height:20px;"></div>
        <div class="clear"></div>
    <?php
    $datacon = $this->dataStore('CONSULTANTREGISTRATIONSUMMREPORT');
    $datatype = $this->dataStore('DISTRIBUTORTYPE');
    $dataconsultant = $this->dataStore('CONSULTANTNO');
    $newArrayDept = array();
    $newArrayApp = array();
    $newArrayExam = array();
    foreach($datatype as $row2)
    {
        $newArrayDept[] = array(
                           'DISTID' => $row2['DIST_ID'],
                           'TYPENAME' => $row2['DIST_TYPE_NAME'],
                           'TYPEID' => $row2['DISTRIBUTOR_TYPE_ID'],
        );
    }
    $newArrayCon = array();
    foreach($datacon as $row)
    {
        $respectiveNames = array();
        $noconsultant = 0;
        $prp = 0;
        $iuta = 0;
        $cuta = 0;
        $cpra = 0;
        $ipra = 0;
        foreach($dataconsultant as $dj){
            if( $dj['DISTRIBUTOR_ID'] == $row['DISTRIBUTOR_ID']){
               if($dj['DIST_POINT_ID'] == $row['DIST_POINT_ID'])
               {
                    $noconsultant++;
               }
              
            }
        }

        $dID = $row['DISTRIBUTOR_ID'];
            $newArrayCon[] =  array( 
                                  'ID' => $row['DIST_POINT_ID'],
                                  'DISTRIBUTOR' => $row['DIST_NAME'],
                                  'POINT NAME' => $row['DIST_POINT_NAME'],
                                  'POINT CODE' => $row['DIST_POINT_CODE'],
                                  'POINT ADDRESS' => $row['ADDRESS'],
                                  'POSTCODE' => $row['POSTCODE_NO'],
                                  'CITY' => $row['CITYNAME'],
                                  'STATE' => $row['STATENAME'],
                                  'STATUS' => $row['TS_PARAM'],
                                  'OPERATION COMMENCEMENT DATE' => "",
                                  'SYSTEM CREATION DATE' => date("d-M-Y", strtotime($row['CREATEDATE'])),
                                  'OPERATION CESSATION DATE' => "",
                                  'NO OF CONSULTANTS' => '<a class="text_center" target="_parent"  href="'.config('app.koolreport_server_front_address').'/distributor-point-consultant-report/'.$row['DIST_POINT_ID'].'">'.$noconsultant.'</a>',
                                  'LAST UPDATE' => date("d-M-Y", strtotime($row['LATEST_UPDATE'])),
                                  'UPDATED BY' => $row['UPDATEDBY'],
                             );
    }
    DataTables::create([
        "dataSource"=>$newArrayCon,
        "plugins" => ["Buttons"],
        "showFooter"=>true,
        "complexHeaders" => true,
        "headerSeparator" => "-",
        "options"=>array(
           // "dom" => 'Blfrtip',
            "paging"=>true,
            "pageLength" => 10,
            "searching"=>true,
            "colReorder"=>true,
           // "scrollY" => "500px",
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
        //     "DISTRIBUTOR"=>array(
        //        // "label"=>"DISTRIBUTOR",
        //         "type"=>"string",
        //         "searchable" => true,
        //        // "type"=>"datetime",
        //        // "format"=>"Y-m-d H:i:s",
        //        // "displayFormat"=>"Y"
        //       // "footer"=>"sum",
        //        "footerText"=>"<b>TOTAL</b>",
        //     ),
        //     "UTMC"=>array(
        //         //"label"=>"UTS-EXAM PASSED",
        //         "type"=>"number",
        //         "cssStyle"=>"dt-body-center",
        //         "footer"=>"sum",
        //         "footerText"=>"<b>@value</b>",
        //     ),
        //     "PRP"=>array(
        //        // "label"=>"UTS-VARIATION",
        //         "type"=>"number",
        //         "cssStyle"=>"text-align:center",
        //         "footer"=>"sum",
        //         "footerText"=>"<b>@value</b>",
        //     ),
        //     "IUTA"=>array(
        //        // "label"=>"UTS-EXEMPTION",
        //         "type"=>"number",
        //         "cssStyle"=>"text-align:center",
        //         "footer"=>"sum",
        //         "footerText"=>"<b>@value</b>",
        //     ),
        //     "CUTA"=>array(
        //         //"label"=>"TOTAL",
        //         "type"=>"number",
        //         "cssStyle"=>"text-align:center",
        //         "footer"=>"sum",
        //         "footerText"=>"<b>@value</b>",
        //     ),
        //     "CPRA"=>array(
        //        // "label"=>"PRS-EXAM PASSED",
        //         "type"=>"number",
        //         "cssStyle"=>"text-align:center",
        //         "footer"=>"sum",
        //         "footerText"=>"<b>@value</b>",
        //     ),
        //     "IPRA"=>array(
        //        // "label"=>"PRS-VARIATION",
        //         "type"=>"number",
        //         "cssStyle"=>"text-align:center",
        //         "footer"=>"sum",
        //         "footerText"=>"<b>@value</b>",
        //     ),
        // ),
        "cssClass"=>array(
            "table"=>"table table-striped table-bordered",
            'th' => 'reportHeader',
            'tr' => 'reportRow',
            'td' => function($row, $colName) {
                $v = Util::get($row, $colName, 0);
                $s = is_numeric($v) ? 'text-center' : 'reportLabel';
                return $s;
            },
            'tf' => 'reportFooter'
        )
    ]);
        ?>
        </div>
    </body>
</html>


