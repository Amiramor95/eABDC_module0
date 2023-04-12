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
</style>
<html>
    <body>
    <div class="report-content">

        <div class="text-center">
            <h1>Consultants Registration Summary</h1>
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
            <form method="post" action="<?php echo config('app.koolreport_server_url');?>/consultantregistrationsummarypdf">
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
            <form method="post" action="<?php echo config('app.koolreport_server_url');?>/consultantregistrationsummarylandscapepdf">
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
            <form method="post" action="<?php echo config('app.koolreport_server_url');?>/consultantregistrationsummaryexcel">
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
    $datacon = $this->dataStore('CONSULTANTREGISTRATIONSUMMREPORT');
    $datatype = $this->dataStore('DISTRIBUTORTYPE');
    $dataexam = $this->dataStore('CONSULTANTEXAMREPORT');
  

    $newArrayDept = array();
    $newArrayApp = array();
    $newArrayExam = array();
    foreach($datatype as $row2)
    {
        $newArrayDept[] = array(
                           'DISTID' => $row2['DIST_ID'],
                           'TYPENAME' => $row2['DIST_TYPE_NAME'],
        );
    }
    foreach($dataexam as $row3)
    {
        // echo "<pre>";
        // print_r($row3);
        // echo "</pre>";
            $newArrayExam[] = array(
            'CONSULTANT_ID' => $row3['CONSULTANT_ID'],
            'CONSULTANTAPPLICATIONTYPE' => $row3['CONSULTANTAPPLICATIONTYPE'],
            'DISTRIBUTOR_ID' => $row3['DISTRIBUTOR_ID'],
            'CONSULTANT_TYPE_ID' => $row3['CONSULTANT_TYPE_ID'],
            'EXAM_RESULT_STATUS' => $row3['EXAM_RESULT_STATUS'],
            );
    }
   
    $newArrayCon = array();
    $utsexam = 0;
    $prsexam = 0;
    $utsvar = 0;
    $prsvar = 0;
    $utsexemp = 0;
    $prsexemp = 0;
    $consID = array();
    $conPRSID = array();
    $consURSVAR = array();
    $consPRSVAR = array();
    $consURSEXEMP = array();
    $consPRSEXEMP = array();
    foreach($datacon as $row){
        $consID[$row['DISTRIBUTOR_ID']] = 0;
        $conPRSID[$row['DISTRIBUTOR_ID']] = 0;
        $consURSVAR[$row['DISTRIBUTOR_ID']] = 0;
        $consPRSVAR[$row['DISTRIBUTOR_ID']] = 0;
        $consURSEXEMP[$row['DISTRIBUTOR_ID']] = 0;
        $consPRSEXEMP[$row['DISTRIBUTOR_ID']] = 0;
    }
    foreach($datacon as $row)
    {
        $respectiveNames = array();
        foreach($newArrayDept as $dj){
            if( $dj['DISTID'] == $row['DISTRIBUTOR_ID']){
                $respectiveNames[] = $dj['TYPENAME'];
            }
        }
        $utsexam = 0;
        $prsexam = 0;
        $utsvar = 0;
        $prsvar = 0;
        $utsexemp = 0;
        $prsexemp = 0;
        foreach($dataexam as $row1)
        {
            if($row1['DISTRIBUTOR_ID'] == $row['DISTRIBUTOR_ID'])
            {
                if($row1['CONSULTANT_TYPE_ID'] == 1 && $row1['EXAM_RESULT_STATUS'] == 1)
                {
                    //echo "enter";
                     $utsexam++;
                }
                $consID[$row['DISTRIBUTOR_ID']] = $utsexam;

                if($row1['CONSULTANT_TYPE_ID'] == 1 && $row1['CONSULTANTAPPLICATIONTYPE'] == 2)
                {
                    //echo "enter";
                     $utsvar++;
                }
                $consURSVAR[$row['DISTRIBUTOR_ID']] = $utsvar;
                if($row1['CONSULTANT_TYPE_ID'] == 1 && $row1['CONSULTANTAPPLICATIONTYPE'] == 3)
                {
                    //echo "enter";
                     $utsexemp++;
                }
                $consURSEXEMP[$row['DISTRIBUTOR_ID']] = $utsexemp;

            }
        }
        foreach($dataexam as $row4)
        {
            if($row4['DISTRIBUTOR_ID'] == $row['DISTRIBUTOR_ID'])
            {
                if($row4['CONSULTANT_TYPE_ID'] == 2 && $row4['EXAM_RESULT_STATUS'] == 1)
                {
                   // echo "enter";
                     $prsexam++;
                }

                $conPRSID[$row['DISTRIBUTOR_ID']] = $prsexam;
                if($row4['CONSULTANT_TYPE_ID'] == 2 && $row4['CONSULTANTAPPLICATIONTYPE'] == 2)
                {
                    //echo "enter";
                     $prsvar++;
                }
                $consPRSVAR[$row['DISTRIBUTOR_ID']] = $prsvar;
                if($row4['CONSULTANT_TYPE_ID'] == 2 && $row4['CONSULTANTAPPLICATIONTYPE'] == 3)
                {
                    //echo "enter";
                     $prsexemp++;
                }
                $consPRSEXEMP[$row['DISTRIBUTOR_ID']] = $prsexemp;
            }
        }
        $dID = $row['DISTRIBUTOR_ID'];
            $newArrayCon[] =  array( 
                                  'DISTRIBUTOR' => $row['DIST_NAME'],
                                  'TYPE' => implode(', ', $respectiveNames),
                                  'UTS-EXAM PASSED' => $consID[$dID],
                                  'UTS-VARIATION' => $consURSVAR[$dID],
                                  'UTS-EXEMPTION' => $consURSEXEMP[$dID],
                                  'UTS-TOTAL' => ($consID[$dID]+$consURSVAR[$dID]+$consURSEXEMP[$dID]),
                                  'PRS-EXAM PASSED' => $consPRSVAR[$dID],
                                  'PRS-VARIATION' => $consPRSVAR[$dID],
                                  'PRS-EXEMPTION' => $consPRSEXEMP[$dID],
                                  'PRS-TOTAL' => ($consPRSVAR[$dID]+$consPRSVAR[$dID]+$consPRSEXEMP[$dID]),
                             );
    }

    // $newArray = array_merge($newArrayFimm,$newArrayDistributor);
    // $newArray1 = array_merge($newArrayCONSULTANT,$newArrayOthers);
    //$finalArray = array_merge($newArray,$newArray1);
   // $finaloutput = array_values($newArrayCon);
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
           // "scrollX" => true,
            //"scrollCollapse" => true,
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
               // "label"=>"DISTRIBUTOR",
                "type"=>"string",
                "searchable" => true,
               // "type"=>"datetime",
               // "format"=>"Y-m-d H:i:s",
               // "displayFormat"=>"Y"
              // "footer"=>"sum",
               "footerText"=>"<b>TOTAL</b>",
            ),
            "TYPE"=>array(
              //"label"=>"DTYPE",
              "type"=>"string",
              "searchable" => true,
               // "footer"=>"sum",
               "footerText"=>"",
            ),
            "UTS-EXAM PASSED"=>array(
                //"label"=>"UTS-EXAM PASSED",
                "type"=>"number",
                "cssStyle"=>"dt-body-center",
                "footer"=>"sum",
                "footerText"=>"<b>@value</b>",
            ),
            "UTS-VARIATION"=>array(
               // "label"=>"UTS-VARIATION",
                "type"=>"number",
                "cssStyle"=>"text-align:center",
                "footer"=>"sum",
                "footerText"=>"<b>@value</b>",
            ),
            "UTS-EXEMPTION"=>array(
               // "label"=>"UTS-EXEMPTION",
                "type"=>"number",
                "cssStyle"=>"text-align:center",
                "footer"=>"sum",
                "footerText"=>"<b>@value</b>",
            ),
            "UTS-TOTAL"=>array(
                //"label"=>"TOTAL",
                "type"=>"number",
                "cssStyle"=>"text-align:center",
                "footer"=>"sum",
                "footerText"=>"<b>@value</b>",
            ),
            "PRS-EXAM PASSED"=>array(
               // "label"=>"PRS-EXAM PASSED",
                "type"=>"number",
                "cssStyle"=>"text-align:center",
                "footer"=>"sum",
                "footerText"=>"<b>@value</b>",
            ),
            "PRS-VARIATION"=>array(
                "label"=>"PRS-VARIATION",
                "type"=>"number",
                "cssStyle"=>"text-align:center",
                "footer"=>"sum",
                "footerText"=>"<b>@value</b>",
            ),
            "PRS-EXEMPTION"=>array(
                //"label"=>"PRS-EXEMPTION",
                "type"=>"number",
                "cssStyle"=>"text-align:center",
                "footer"=>"sum",
                "footerText"=>"<b>@value</b>",
            ),
            "PRS-TOTAL"=>array(
               // "label"=>"TOTAL",
                "type"=>"number",
                "cssStyle"=>"text-align:center",
                "footer"=>"sum",
                "footerText"=>"<b>@value</b>",
            ),
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


