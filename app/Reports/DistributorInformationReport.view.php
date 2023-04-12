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
    .dataTable{
        width : 100% !important;
        margin: 0 auto;
    }
</style>
<html>
    <body>
    <div class="report-content">

        <div class="text-center">
            <h1>Distributor Information Report</h1>
        </div>
        <form method="post" id="consultantForm" class="searchForm">
        <div class="row form_row">
            <div class="col-md-6">
            <b>REPORT DATE</b>
                <?php
                DateRangePicker::create(array(
                "name"=>"dateRange",
                "format"=>"MMM Do, YYYY", //Jul 3rd, 2017
              //"format"=>"YYYY-M-D",
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
                <b>DISTRIBUTOR TYPE</b>
                <?php
                Select2::create(array(
                    "multiple"=>true,
                    "name"=>"DISTIDS",
                    "defaultOption"=>array("All"=>0),
                    "dataSource"=>$this->dataStore("DISTRIBUTORTYPELIST"),
                    "dataBind"=>array(
                                "text"=>"DIST_TYPE_NAME",
                                "value"=>"DISTID",
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
                        "name"=>"SETTINGID",
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
                <b>BUSINESS STRUCTURE</b>
                <?php 
                 $types = array();
                 $types[0] = array('TYPENAME' => 'SINGLE-TIER','ID' => 1);
                 $types[1] = array('TYPENAME' => 'MULTI-TIER','ID' => 2);
                    Select2::create(array(
                        "multiple"=>false,
                        "name"=>"BUSINESSTYPE",
                        "defaultOption"=>array("All"=>0),
                        "dataSource"=>$types,
                        "dataBind"=>array(
                            "text"=>"TYPENAME",
                            "value"=>"ID",
                        ),
                        "attributes"=>array(
                            "class"=>"form-control"
                        ),
                        
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
         <div class="download_div">
            <form method="post" action="<?php echo config('app.koolreport_server_url');?>/distributorinformationexcel">
            <?php
                foreach ($this->params['DISTRIBUTORIDS'] as  $value) {
                ?>
                  <input type="hidden" name="DISTRIBUTORIDS[]" value="<?php echo $value; ?>">
                <?php
                }
                ?>
                 <?php
                foreach ($this->params['DISTIDS'] as  $value1) {
                ?>
                  <input type="hidden" name="DISTIDS[]" value="<?php echo $value1; ?>">
                <?php
                }
                ?>
                <input type="hidden" value="<?php echo $this->params["SETTINGID"]; ?>" name="SETTINGID" />
                <input type="hidden" value="<?php echo $this->params["BUSINESSTYPE"]; ?>" name="BUSINESSTYPE" />
                <input type="hidden" value="<?php echo $this->params["dateRange"][0]; ?>" id="dateRange_start" name="dateRange[]" />
                <button class="btn btn-primary">Download EXCEL</button>
            </form>
        </div>
        </div>
        <div style="height:20px;"></div>
        <div class="clear"></div>
    <?php
    $datacon = $this->dataStore('DISTRIBUTORINFORMATIONREPORT');
    $datatype = $this->dataStore('DISTRIBUTORTYPE');
    $newArrayCon = array();
    $uts = "";
    $prs = "";
    $consID = array();
    $conPRSID = array();
    $consStatusTag = array();
    $newArrayDept = array();
    $newArrayApp = array();
    $typeStructure = "";
    foreach($datatype as $row2)
    {
        $newArrayDept[] = array(
                           'DISTID' => $row2['DIST_ID'],
                           'TYPENAME' => $row2['DIST_TYPE_NAME'],
        );
    }
    foreach($datacon as $row)
    {
        $respectiveNames = array();
        foreach($newArrayDept as $dj){
            if( $dj['DISTID'] == $row['DID']){
                $respectiveNames[] = $dj['TYPENAME'];
            }
        }
        if($row['DIST_TYPE_STRUCTURE'] == 1)
        {
            $typeStructure = "Single-tier";
        }
        if($row['DIST_TYPE_STRUCTURE'] == 2)
        {
            $typeStructure = "Multi-tier";
        }


            $newArrayCon[] =  array( 
                                 'DISTRIBUTOR INFORMATION-DISTRIBUTOR' => $row['DIST_NAME'],
                                 'DISTRIBUTOR INFORMATION-DISTRIBUTOR CODE' =>  number_format($row['DIST_CODE'],0, '.', ''),
                                 'DISTRIBUTOR INFORMATION-DISTRIBUTOR TYPE' => implode(', ', $respectiveNames),
                                 'DISTRIBUTOR INFORMATION-REGISTRATION NUMBER' => $row['REGNUM'],
                                 'DISTRIBUTOR INFORMATION-BUSINESS ADDRESS' => $row['ADDRESS'],
                                 'DISTRIBUTOR INFORMATION-POSTCODE' => $row['POSTCODE_NO'],
                                 'DISTRIBUTOR INFORMATION-CITY' =>$row['SET_CITY_NAME'],
                                 'DISTRIBUTOR INFORMATION-STATE' => $row['STATE'],
                                 'DISTRIBUTOR INFORMATION-CONTACT NO.' => $row['DIST_MOBILE_NUMBER'],
                                 'DISTRIBUTOR INFORMATION-EMAIL' => $row['DIST_EMAIL'],
                                 'DISTRIBUTOR INFORMATION-FIMM APPROVAL DATE' => "",
                                 'DISTRIBUTOR INFORMATION-COMMENCEMENT DTATE' => "",
                                 'DISTRIBUTOR INFORMATION-ACCOUNT BALANCE' => $row['DIST_ACC_AMOUNT'],
                                 'BUSINESS STRUCTURE-AGENCY STRUCTURE' => $typeStructure,
                                 'BUSINESS STRUCTURE-TOTAL DISTRIBUTOR POINTS' => $row['DIST_NUM_DIST_POINT'],
                                 'COMPANY REPRESENTATIVES-AR' => $row['AR_NAME'],
                                 'COMPANY REPRESENTATIVES-AR SALUTATION' => $row['AR_SALUT'],
                                 'COMPANY REPRESENTATIVES-AR POSITION' => $row['AR_POSITION'],
                                 'COMPANY REPRESENTATIVES-AR CONTACT' => $row['AR_MOBILE_NUMBER'],
                                 'COMPANY REPRESENTATIVES-AR EMAIL' => $row['AR_EMAIL'],
                                 'COMPANY REPRESENTATIVES-AAR' => $row['AAR_NAME'],
                                 'COMPANY REPRESENTATIVES-AAR SALUTATION' => $row['AAR_SALUT'],
                                 'COMPANY REPRESENTATIVES-AAR POSITION' =>  $row['AAR_POSITION'],
                                 'COMPANY REPRESENTATIVES-AAR CONTACT' => $row['AAR_MOBILE_NUMBER'],
                                 'COMPANY REPRESENTATIVES-AAR EMAIL' => $row['AAR_EMAIL'],
                                 'COMPANY REPRESENTATIVES-COMPLIANCE OFFICER' => $row['COM_NAME'],
                                 'COMPANY REPRESENTATIVES-C SALUTATION' => $row['COM_SALUT'],
                                 'COMPANY REPRESENTATIVES-COMPLIANCE OFFICER CONTACT' => $row['COM_MOBILE_NUMBER'],
                                 'COMPANY REPRESENTATIVES-COMPLIANCE OFFICER EMAIL' => $row['COM_EMAIL'],
                                 'COMPANY REPRESENTATIVES-HOD UTS' => $row['UTS_NAME'],
                                 'COMPANY REPRESENTATIVES-HEAD OF D/O UTS SALUTATION' => $row['UTS_SALUT'],
                                 'COMPANY REPRESENTATIVES-HEAD OF D/O UTS CONTACT' => $row['UTS_MOBILE_NUMBER'],
                                 'COMPANY REPRESENTATIVES-HEAD OF D/O UTS EMAIL' =>  $row['UTS_EMAIL'],
                                 'COMPANY REPRESENTATIVES-HOD PRS' => $row['PRS_NAME'],
                                 'COMPANY REPRESENTATIVES-HEAD OF D/O PRS SALUTATION' => $row['PRS_SALUT'],
                                 'COMPANY REPRESENTATIVES-HEAD OF D/O PRS CONTACT' => $row['PRS_MOBILE_NUMBER'],
                                 'COMPANY REPRESENTATIVES-HEAD OF D/O PRS EMAIL' => $row['PRS_EMAIL'],
                                 'COMPANY REPRESENTATIVES-HEAD OF TRAINING' => $row['TRAIN_NAME'],
                                 'COMPANY REPRESENTATIVES-SALUTATION' => $row['TRAIN_SALUT'],
                                 'COMPANY REPRESENTATIVES-HEAD OF TRAINING CONTACT' => $row['TRAIN_MOBILE_NUMBER'],
                                 'COMPANY REPRESENTATIVES-HEAD OF TRAINING EMAIL' => $row['TRAIN_EMAIL'],
                                 'GENERIC INFORMATION-LAST UPDATED' => "",
                                 'GENERIC INFORMATION-UPDATED BY' => "",
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
              "scrollY" => "500px",
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


