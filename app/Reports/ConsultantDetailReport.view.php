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
            <h1>Consultants Details Report</h1>
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
                <b>STATUS</b>
                <?php 
                    Select2::create(array(
                        "multiple"=>false,
                        "name"=>"SETTINGID",
                        "defaultOption"=>array("All"=>0),
                        "dataSource"=>$this->dataStore('CONSULTANTSTATUS'),
                        "dataBind"=>array(
                            "text"=>"PARAM",
                            "value"=>"SETTINGID",
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
                    <button class="btn btn-primary">SEARCH</button>
                </div>
            </div>
        </div>
    </form>
        <div class="clear"></div>
        <div class="text-right">
        <!-- <div class="download_div">
            <form method="post" action="<?php echo config('app.koolreport_server_url');?>/consultantdetailpdf">
                <?php
                foreach ($this->params['DISTRIBUTORIDS'] as  $value) {
                ?>
                  <input type="hidden" name="DISTRIBUTORIDS[]" value="<?php echo $value; ?>">
                <?php
                }
                ?>
                <input type="hidden" value="<?php echo $this->params["SETTINGID"]; ?>" name="SETTINGID" />
                <input type="hidden" value="<?php echo $this->params["SCHEMEID"]; ?>" name="SCHEMEID" />
                <input type="hidden" value="<?php echo $this->params["dateRange"][0]; ?>" id="dateRange_start" name="dateRange[]" />
                <button class="btn btn-primary">Download Portrait PDF</button>
            </form>
         </div>
         <div class="download_div">
            <form method="post" action="<?php echo config('app.koolreport_server_url');?>/consultantdetaillandscapepdf">
            <?php
                foreach ($this->params['DISTRIBUTORIDS'] as  $value) {
                ?>
                  <input type="hidden" name="DISTRIBUTORIDS[]" value="<?php echo $value; ?>">
                <?php
                }
                ?>
                <input type="hidden" value="<?php echo $this->params["SETTINGID"]; ?>" name="SETTINGID" />
                <input type="hidden" value="<?php echo $this->params["SCHEMEID"]; ?>" name="SCHEMEID" />
                <input type="hidden" value="<?php echo $this->params["dateRange"][0]; ?>" id="dateRange_start" name="dateRange[]" />
                <button class="btn btn-primary">Download Landscape PDF</button>
            </form>
         </div> -->
         <div class="download_div">
            <form method="post" action="<?php echo config('app.koolreport_server_url');?>/consultantdetailexcel">
            <?php
                foreach ($this->params['DISTRIBUTORIDS'] as  $value) {
                ?>
                  <input type="hidden" name="DISTRIBUTORIDS[]" value="<?php echo $value; ?>">
                <?php
                }
                ?>
                <input type="hidden" value="<?php echo $this->params["SETTINGID"]; ?>" name="SETTINGID" />
                <input type="hidden" value="<?php echo $this->params["SCHEMEID"]; ?>" name="SCHEMEID" />
                <input type="hidden" value="<?php echo $this->params["dateRange"][0]; ?>" id="dateRange_start" name="dateRange[]" />
                <button class="btn btn-primary">Download EXCEL</button>
            </form>
        </div>
        </div>
        <div style="height:20px;"></div>
        <div class="clear"></div>
    <?php
    $datacon = $this->dataStore('CONSULTANTDETAILREPORT');
    $datalicense = $this->dataStore('CONSULTANTLICENSE');
    $newArrayCon = array();
    $uts = "";
    $prs = "";
    $consID = array();
    $conPRSID = array();
    $consStatusTag = array();
    foreach($datacon as $row){
        $consID[$row['CID']] = "N";
        $conPRSID[$row['CID']] = "N";
        $consStatusTag[$row['CID']] = "";
    }
    foreach($datacon as $row)
    {

        $dateOfBirth = $row['DOB'];
        $today = date("Y-m-d");
        $diff = date_diff(date_create($dateOfBirth), date_create($today));
       // echo 'Your age is '.$diff->format('%y');
        $uts = "N";
        $prs = "N";
        
        foreach($datalicense as $row1)
        {
            if($row1['CONID'] == $row['CID'])
            {
                if($row1['TID'] == 1)
                {
                     $uts = "Y";
                }
                
                $consID[$row['CID']] = $uts;
                $consStatusTag[$row['CID']] = $row1['STATUSTAG'];
            }
        }

        foreach($datalicense as $row1)
        {
            if($row1['CONID'] == $row['CID'])
            {
                if($row1['TID'] == 2)
                {
                    $prs = "Y";
                }
                $conPRSID[$row['CID']] = $prs;
                $consStatusTag[$row['CID']] = $row1['STATUSTAG'];
            }
        }
            // echo "<pre>";
            // print_r($consID);
            // echo "</pre>";
            $cID = $row['CID'];
            if($row['PROCERTIFICATE'] == 1)
            {
                $pro = "CFP";
            }
            else if($row['PROCERTIFICATE'] == 2)
            {
                $pro = "IFP";
            }
            else if($row['PROCERTIFICATE'] == 3)
            {
                $pro = "RFP";
            }
            else if($row['PROCERTIFICATE'] == 4)
            {
                $pro = "SRFP";
            }
            else{
                $pro = "";
            }
            $newArrayCon[] =  array( 
                                 'NAME' => $row['CNAME'],
                                 'NRIC' => $row['NRIC'],
                                 'PASSPORT' => $row['PASSPORT'],
                                 'P.EXPIRY DATE' => $row['PASSPORTEXPIRE'],
                                 'FIMM NO' => $row['FIMMNO'],
                                 'STATUS' => $row['STATUS'],
                                 'STATUS TAG' =>$consStatusTag[$cID],
                                 'UTS' => $consID[$cID],
                                 'PRS' => $conPRSID[$cID],
                                 'AGE' => $diff->format('%y'),
                                 'GENDER' => $row['GENDER'],
                                 'RACE' => $row['RACE'],
                                 'RACE(REMARK)' => $row['RACEREMARK'],
                                 'ACADEMIC QUALIFICATION' => $row['ACADEMICQUALI'],
                                 'PROFESSIONAL QUALIFICATION' => $pro,
                                 'NATIONALITY' => $row['NATIONALITY'],
                                 'COUNTRY' => $row['COUNTRY'],
                                 'CORRESPONDENCE ADDRESS-STREET' => $row['CSTREET'],
                                 'CORRESPONDENCE ADDRESS-POSTCODE' => $row['CPOSTCODE'],
                                 'CORRESPONDENCE ADDRESS-CITY' => $row['CCITY'],
                                 'CORRESPONDENCE ADDRESS-STATE' => $row['CSTATE'],
                                 'PERMANENT ADDRESS-STREET' => $row['PSTREET'],
                                 'PERMANENT ADDRESS-POSTCODE' => $row['PPOSTCODE'],
                                 'PERMANENT ADDRESS-CITY' =>$row['PCITY'],
                                 'PERMANENT ADDRESS-STATE' =>  $row['PSTATE'],
                                 'PHONE NUMBER-MOBILE' => $row['MOBILE'],
                                 'PHONE NUMBER-HOME' =>$row['HOUSE'],
                                 'PHONE NUMBER-EMAIL' => $row['EMAIL'],
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
            "table"=>"table table-striped table-bordered"
        )
    ]);
        ?>
        </div>
    </body>
</html>


