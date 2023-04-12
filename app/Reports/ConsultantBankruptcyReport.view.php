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
    .utscolor{
       background-color: "#d9cba0";
    }
    .reportFooter{
        text-align: center;
        height: 50px;
    }
    .reportHeader{
        text-align: center;
    }
</style>
<html>
    <body>
    <div class="report-content">

        <div class="text-center">
            <h1>Consultants Bankruptcy Report</h1>
        </div>
        <form method="post" id="consultantForm" class="searchForm">
        <div class="row form_row">
        <div class="form-group">
            <div class="col-md-6">
            <b>REPORT DATE</b>
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
                    <button class="btn btn-primary">SEARCH</button>
                </div>
            </div>
        </div>
    </form>
        <div class="clear"></div>
        <div class="text-right">
        <!-- <div class="download_div">
            <form method="post" action="<?php echo config('app.koolreport_server_url');?>/consultantactivepdf">
                <?php
                foreach ($this->params['DISTRIBUTORIDS'] as  $value) {
                ?>
                  <input type="hidden" name="DISTRIBUTORIDS[]" value="<?php echo $value; ?>">
                <?php
                }
                ?>
                <input type="hidden" value="<?php echo $this->params["dateRange"][0]; ?>" id="dateRange_start" name="dateRange[]" />
                <input type="hidden" value="<?php echo $this->params["dateRange"][1]; ?>" id="dateRange_end" name="dateRange[]" />
                <button class="btn btn-primary">Download Portrait PDF</button>
            </form>
         </div>
         <div class="download_div">
            <form method="post" action="<?php echo config('app.koolreport_server_url');?>/consultantactivelandscapepdf">
            <?php
                foreach ($this->params['DISTRIBUTORIDS'] as  $value) {
                ?>
                  <input type="hidden" name="DISTRIBUTORIDS[]" value="<?php echo $value; ?>">
                <?php
                }
                ?>
                <input type="hidden" value="<?php echo $this->params["dateRange"][0]; ?>" id="dateRange_start" name="dateRange[]" />
                <input type="hidden" value="<?php echo $this->params["dateRange"][1]; ?>" id="dateRange_end" name="dateRange[]" />
                <button class="btn btn-primary">Download Landscape PDF</button>
            </form>
         </div> -->
         <div class="download_div">
            <form method="post" action="<?php echo config('app.koolreport_server_url');?>/consultantactiveexcel">
            <?php
                foreach ($this->params['DISTRIBUTORIDS'] as  $value) {
                ?>
                  <input type="hidden" name="DISTRIBUTORIDS[]" value="<?php echo $value; ?>">
                <?php
                }
                ?>
                <input type="hidden" value="<?php echo $this->params["dateRange"][0]; ?>" id="dateRange_start" name="dateRange[]" />
                <input type="hidden" value="<?php echo $this->params["dateRange"][1]; ?>" id="dateRange_end" name="dateRange[]" />
                <button class="btn btn-primary">Download EXCEL</button>
            </form>
        </div>
        </div>
        <div style="height:20px;"></div>
        <div class="clear"></div>
    <?php
    $datacon = $this->dataStore('CONSULTANTACTIVEREPORT');
    $datatype = $this->dataStore('DISTRIBUTORTYPE');
    $datascheme = $this->dataStore('CONSULTANTSCHEME');
    $datalicense = $this->dataStore('CONSULTANTLICENSE');
    $newArrayDept = array();
    $newArrayApp = array();
    $newArrayScheme = array();
    foreach($datatype as $row2)
    {
        $newArrayDept[] = array(
                           'DISTID' => $row2['DIST_ID'],
                           'TYPENAME' => $row2['DIST_TYPE_NAME'],
        );
    }

    // foreach($datalicense as $row7)
    // {
    //     $newArrayScheme[] = array(
    //                        'DIST_NAME' => $row7['DIST_NAME'],
    //                        'CONSULTANT_TYPE_ID' => $row7['CONSULTANT_TYPE_ID'],
    //                        'CONSULTANT_ID' => $row7['CONSULTANT_ID'],
    //                        'DISTRIBUTOR_ID' => $row7['DISTRIBUTOR_ID'],
    //                        'REGDATE' => $row7['REGDATE'],
    //     );
    // }
   
    $newArrayCon = array();
    $uts = "";
    $prs = "";
    $consID = array();
    $conPRSID = array();
    $consStatusTag = array();
    foreach($datacon as $row)
    {
        
        $respectiveSchemeNames = array();
        $respectiveUTSDISTRIBUTOR = "";
        $respectivePRSDISTRIBUTOR = "";
        $respectiveUtsNames = array();
        $respectivePrsNames = array();
        $reqdateuts = "";
        $reqdateprs = "";
        $regdate = "";
        $regdate1 = "";
        foreach($datalicense as $object){
            // echo "<pre>";
            //    echo $object['CONSULTANT_ID'];
            //     echo "</pre>";
            if($row['CID'] == $object['CONSULTANT_ID']){
                // Consultant Type
                if($object['CONSULTANT_TYPE_ID'] == 1)
                {
                    $respectiveUTSDISTRIBUTOR =  $object['DIST_NAME'];

                    foreach($newArrayDept as $dj1){
                        if( $dj1['DISTID'] == $object['DISTRIBUTOR_ID']){
                           // echo $dj1['DISTID'];
                        $respectiveUtsNames[] = $dj1['TYPENAME'];
                        }
                       }
                      // $respectiveSchemeNames[] = "UTS";

                       foreach($datascheme as $dj){
                        if( $dj['SCHEMEID'] == $object['CONSULTANT_TYPE_ID']){
                            $respectiveSchemeNames[] = $dj['TYPE_SCHEME'];
                       }
                    }
                }
                if($object['CONSULTANT_TYPE_ID'] == 2)
                {
                    $respectivePRSDISTRIBUTOR =  $object['DIST_NAME'];
                    //$reqdateprs = $object['REGDATE'];
                    foreach($newArrayDept as $dj1){
                        if( $dj1['DISTID'] == $object['DISTRIBUTOR_ID']){
                           // echo $dj1['DISTID'];
                        $respectivePrsNames[] = $dj1['TYPENAME'];
                        }
                       }
                      // $respectiveSchemeNames[] = "PRS";
                       foreach($datascheme as $dj){
                        if( $dj['SCHEMEID'] == $object['CONSULTANT_TYPE_ID']){
                            $respectiveSchemeNames[] = $dj['TYPE_SCHEME'];
                       }
                    }
                }
                // Distributor Type

            }
        }

            $newArrayCon[] =  array( 
                                 //'ID' => $row['CID'],
                                 'NAME' => $row['CNAME'],
                                 'NRIC' => $row['NRIC'],
                                 'FIMM NO' => $row['FIMMNO'],
                                 // 'CONSULTANT TYPE' => implode(' & ', $respectiveSchemeNames),
                                  'UTS-DISTRIBUTOR' =>  $respectiveUTSDISTRIBUTOR,
                                  //'UTS-TYPE' => implode(', ', $respectiveUtsNames),
                                  'UTS-REGISTRATION DATE(FIMM)' => "",
                                  'UTS-REGISTRATION DATE(DISTRIBUTOR)' => "", //$regdate,
                                  'UTS-ADJUDICATION DATE' => "",
                                  'UTS-FIMM REVOCATION DATE' => "",
                                  'PRS-DISTRIBUTOR' => $respectivePRSDISTRIBUTOR,
                                 // 'PRS-TYPE' => implode(', ', $respectivePrsNames),
                                  'PRS-REGISTRATION DATE(FIMM)' => "",
                                  'PRS-REGISTRATION DATE(DISTRIBUTOR)' => "",
                                  'PRS-ADJUDICATION DATE' => "",
                                  'PRS-FIMM REVOCATION DATE' => "",
                                  'CURRENT STATUS' => "",
                                  'DISCHARGED DATE (FROM FIMM)' => "",
                                  'LAST UPDATED' => "",
                                  'LAST UPDATED BY' => "",
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
             // "scrollY" => "600px",
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


