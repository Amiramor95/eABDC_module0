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
            <h1>Active Consultants Summary Report</h1>
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
            <form method="post" action="<?php echo config('app.koolreport_server_url');?>/consultantactivesummarypdf">
                <?php
                foreach ($this->params['DISTRIBUTORIDS'] as  $value) {
                ?>
                  <input type="hidden" name="DISTRIBUTORIDS[]" value="<?php echo $value; ?>">
                <?php
                }
                ?>
                <button class="btn btn-primary">Download Portrait PDF</button>
            </form>
         </div>
         <div class="download_div">
            <form method="post" action="<?php echo config('app.koolreport_server_url');?>/consultantactivesummarylandscapepdf">
            <?php
                foreach ($this->params['DISTRIBUTORIDS'] as  $value) {
                ?>
                  <input type="hidden" name="DISTRIBUTORIDS[]" value="<?php echo $value; ?>">
                <?php
                }
                ?>
                <button class="btn btn-primary">Download Landscape PDF</button>
            </form>
         </div> -->
         <div class="download_div">
            <form method="post" action="<?php echo config('app.koolreport_server_url');?>/consultantactivesummaryexcel">
            <?php
                foreach ($this->params['DISTRIBUTORIDS'] as  $value) {
                ?>
                  <input type="hidden" name="DISTRIBUTORIDS[]" value="<?php echo $value; ?>">
                <?php
                }
                ?>
                <button class="btn btn-primary">Download EXCEL</button>
            </form>
        </div>
        </div>
        <div style="height:20px;"></div>
        <div class="clear"></div>
    <?php
    $datacon = $this->dataStore('CONSULTANTSUMMARYDISTRIBUTOR');
    $datatype = $this->dataStore('DISTRIBUTORTYPE');
    $datatdual = $this->dataStore('CONSULTANTDUALLICENSE');
    $datatsingleuts = $this->dataStore('CONSULTANTSINGLEUTSLICENSE');
    $newArrayDept = array();
    $newArrayApp = array();
    $newArrayScheme = array();
    $dual = 0;
    foreach($datatype as $row2)
    {
        $newArrayDept[] = array(
                           'DISTID' => $row2['DIST_ID'],
                           'TYPENAME' => $row2['DIST_TYPE_NAME'],
        );
    }
    $newArrayCon = array();
    foreach($datacon as $row)
    {
        $respectiveTypeNames = array();
        $dual = 0;
        $uts = 0;
        $prs = 0;
        foreach($newArrayDept as $dj1){
            if( $dj1['DISTID'] == $row['DISTRIBUTORID']){
                $respectiveTypeNames[] = $dj1['TYPENAME'];
            }
        }
        // Dual Registration
        foreach($datatdual as $dualobject){
            if( $dualobject['DISTRIBUTOR_ID'] == $row['DISTRIBUTORID']){
                $dual = $dual+1;
            }
        }
         // Single Registration 
         foreach($datatsingleuts as $singleobject){
            if( $singleobject['DISTRIBUTOR_ID'] == $row['DISTRIBUTORID']){
                if($singleobject['CONSULTANT_TYPE_ID'] == 1)
                {
                $uts = $uts+1;
                }
                if($singleobject['CONSULTANT_TYPE_ID'] == 2)
                {
                $prs = $prs+1;
                }
            }
        }

            $newArrayCon[] =  array( 
                                 //'ID' => $row['DISTRIBUTORID'],
                                 'DISTRIBUTOR' => $row['DIST_NAME'],
                                 'TYPE' =>  implode(', ', $respectiveTypeNames),
                                 'UTS' => $uts,
                                 'PRS' => $prs,
                                 'DUAL REGISTRATION' => $dual,
                                 'TOTAL' => $uts+$prs+$dual,
                             );
    }

    // $newArray = array_merge($newArrayFimm,$newArrayDistributor);
    // $newArray1 = array_merge($newArrayCONSULTANT,$newArrayOthers);
    //$finalArray = array_merge($newArray,$newArray1);
    DataTables::create([
        "dataSource"=>$newArrayCon,
        "showFooter"=>true,
        "options"=>array(
           // "dom" => 'Blfrtip',
            "paging"=>true,
            "pageLength" => 10,
            "searching"=>true,
            "colReorder"=>true,
             // "scrollY" => "600px",
           //  "scrollX" => true,
            //  "scrollCollapse" => true,
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
        "columns"=>array(
            "DISTRIBUTOR"=>array(
                "searchable" => true,
                "type"=>"string",
                "footerText"=>"<b>TOTAL</b>",
            ),
            "TYPE"=>array(
            //  "label"=>"TOTAL COMPLAINTS",
              "type"=>"string",
               "searchable" => true,
               "footerText"=>"",
            ),
            "UTS"=>array(
                //"label"=>"CLOSED",
                "type"=>"number",
                "searchable" => true,
                "footer"=>"sum",
                "footerText"=>"<b>@value</b>",
            ),
            "PRS"=>array(
               // "label"=>"ON-GOING",
                "type"=>"number",
               "searchable" => true,
               "footer"=>"sum",
               "footerText"=>"<b>@value</b>",
            ),
            "DUAL REGISTRATION"=>array(
                // "label"=>"ON-GOING",
                 "type"=>"number",
                "searchable" => true,
                "footer"=>"sum",
                "footerText"=>"<b>@value</b>",
             ),
            "TOTAL"=>array(
                // "label"=>"ON-GOING",
                 "type"=>"number",
                "searchable" => true,
                "footer"=>"sum",
                "footerText"=>"<b>@value</b>",
               )
        ),
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


