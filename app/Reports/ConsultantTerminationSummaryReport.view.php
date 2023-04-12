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
            <h1>Consultants Termination Summary</h1>
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
            <form method="post" action="<?php echo config('app.koolreport_server_url');?>/consultantterminationsummarypdf">
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
            <form method="post" action="<?php echo config('app.koolreport_server_url');?>/consultantterminationsummarylandscapepdf">
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
            <form method="post" action="<?php echo config('app.koolreport_server_url');?>/consultantterminationsummaryexcel">
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
    $datacon = $this->dataStore('CONSULTANTTERMINATIONSUMMREPORT');
    $datautsresigned = $this->dataStore('CONSULTANTUTSRESIGNEDREPORT');
    $dataprsresigned = $this->dataStore('CONSULTANTPRSRESIGNEDREPORT');
    $datautsrevoked = $this->dataStore('CONSULTANTUTSREVOKEDREPORT');
    $dataprsrevoked = $this->dataStore('CONSULTANTPRSREVOKEDREPORT');
    $datautstermination = $this->dataStore('CONSULTANTUTSTERMINATIONREPORT');
    $dataprstermination = $this->dataStore('CONSULTANTPRSTERMINATIONREPORT');
  
    $newArrayCon = array();
    $utsresigned = 0;
    $prsresigned = 0;
    $utsrevoked = 0;
    $prsrevoked = 0;
    $utstermination = 0;
    $prstermination = 0;
    $consUTSRE = array();
    $conPRSRE = array();
    $consUTSREVOKED = array();
    $consPRSREVIKED = array();
    $consURSVAR = array();
    $consPRSVAR = array();
    $consURSTERMINATION = array();
    $consPRSTERMINATION = array();
    foreach($datacon as $row){
        $consUTSRE[$row['DISTRIBUTOR_ID']] = 0;
        $conPRSRE[$row['DISTRIBUTOR_ID']] = 0;
        $consUTSREVOKED[$row['DISTRIBUTOR_ID']] = 0;
        $consPRSREVIKED[$row['DISTRIBUTOR_ID']] = 0;
        $consURSTERMINATION[$row['DISTRIBUTOR_ID']] = 0;
        $consPRSTERMINATION[$row['DISTRIBUTOR_ID']] = 0;
    }
    foreach($datacon as $row)
    {
       
        $utsresigned = 0;
        $prsresigned = 0;
        $utsrevoked = 0;
       $prsrevoked = 0;
       $utstermination = 0;
       $prstermination = 0;
        foreach($datautsresigned as $row1)
        {
            if($row1['DID'] == $row['DISTRIBUTOR_ID'])
            {
                  //echo "enter";
                  $utsresigned = $row1['RESIGNEDTOTAL'];
                $consUTSRE[$row['DISTRIBUTOR_ID']] = $utsresigned;


            }
        }
        foreach($dataprsresigned as $row2)
        {
            if($row2['DID'] == $row['DISTRIBUTOR_ID'])
            {
                  //echo "enter";
                  $prsresigned = $row2['RESIGNEDTOTAL'];
                $conPRSRE[$row['DISTRIBUTOR_ID']] = $prsresigned;


            }
        }
        foreach($datautsrevoked as $row3)
        {
            if($row3['DID'] == $row['DISTRIBUTOR_ID'])
            {
                  //echo "enter";
                  $utsrevoked = $row3['REVOKEDTOTAL'];
                $consUTSREVOKED[$row['DISTRIBUTOR_ID']] = $utsrevoked;


            }
        }
        foreach($dataprsrevoked as $row4)
        {
            if($row4['DID'] == $row['DISTRIBUTOR_ID'])
            {
                 // echo "enter1";
                  $prsrevoked = $row4['REVOKEDTOTAL'];
                $consPRSREVIKED[$row['DISTRIBUTOR_ID']] = $prsrevoked;


            }
        }
        foreach($datautstermination as $row5)
        {
            if($row5['DID'] == $row['DISTRIBUTOR_ID'])
            {
                 // echo "enter1";
                  $utstermination = $row5['TERMINATIONTOTAL'];
                $consURSTERMINATION[$row['DISTRIBUTOR_ID']] = $utstermination;


            }
        }
        foreach($dataprstermination as $row6)
        {
            if($row6['DID'] == $row['DISTRIBUTOR_ID'])
            {
                 // echo "enter1";
                  $prstermination = $row6['TERMINATIONTOTAL'];
                $consPRSTERMINATION[$row['DISTRIBUTOR_ID']] = $prstermination;


            }
        }
        $dID = $row['DISTRIBUTOR_ID'];

            $newArrayCon[] =  array( 
                                  'DISTRIBUTOR' => $row['DIST_NAME'],
                                  'UTS-RESIGNATION' => $consUTSRE[$dID],
                                  'UTS-TERMINATION' => $consURSTERMINATION[$dID],
                                   'UTS-REVOKED' => $consUTSREVOKED[$dID],
                                   'PRS-RESIGNATION' => $conPRSRE[$dID],
                                   'PRS-TERMINATION' => $consPRSTERMINATION[$dID],
                                   'PRS-REVOKED' => $consPRSREVIKED[$dID],
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
            "UTS-RESIGNATION"=>array(
                //"label"=>"UTS-EXAM PASSED",
                "type"=>"number",
                "cssStyle"=>"dt-body-center",
                "footer"=>"sum",
                "footerText"=>"<b>@value</b>",
            ),
            "UTS-TERMINATION"=>array(
               // "label"=>"UTS-VARIATION",
                "type"=>"number",
                "cssStyle"=>"text-align:center",
                "footer"=>"sum",
                "footerText"=>"<b>@value</b>",
            ),
            "UTS-REVOKED"=>array(
               // "label"=>"UTS-EXEMPTION",
                "type"=>"number",
                "cssStyle"=>"text-align:center",
                "footer"=>"sum",
                "footerText"=>"<b>@value</b>",
            ),
            "PRS-RESIGNATION"=>array(
               // "label"=>"PRS-EXAM PASSED",
                "type"=>"number",
                "cssStyle"=>"text-align:center",
                "footer"=>"sum",
                "footerText"=>"<b>@value</b>",
            ),
            "PRS-TERMINATION"=>array(
               // "label"=>"PRS-VARIATION",
                "type"=>"number",
                "cssStyle"=>"text-align:center",
                "footer"=>"sum",
                "footerText"=>"<b>@value</b>",
            ),
            "PRS-REVOKED"=>array(
                //"label"=>"PRS-EXEMPTION",
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


