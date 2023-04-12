<?php
use \koolreport\widgets\koolphp\Table;
use \koolreport\inputs\Select2;
use \koolreport\inputs\DateRangePicker;
use \koolreport\datagrid\DataTables;
use \koolreport\core\Utility as Util;
use \koolreport\inputs\CheckBoxList;
$newArrayDept = array();
$datatype = $this->dataStore('DISTRIBUTORTYPED2');
foreach($datatype as $obj)
    {
        $newArrayDept[] = array(
            'DISTID' => $obj['DIST_ID'],
           // 'TYPENAME' => $obj['DIST_TYPE_NAME'],
           // 'DIST_TYPE' => $obj['DIST_TYPE'],
        );
    }
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
    .reportLabel{
        text-align: left;
    }
    div.dataTables_scrollHead table.table-bordered{
        width: 100% !important;
        margin: 0 auto !important;
    }
    .form-check {
        display: inline-block !important;
    }
    div.dataTables_scrollBody table{
        width: 100% !important;
        margin: 0 auto !important;
    }
    .group_class{
     
        vertical-align: top;
    }
    .module_class{
        display:inline-block;
        margin-left: 28px;
        vertical-align: top;
    }
    .text-left{
        margin-left: 17px;
    }
    .companyname{
        font-weight: bold;
        font-size: 20px;
        margin-top: 20px;
        margin-bottom: 20px;
    }
    .companyname span{ 
        text-decoration: underline;
        margin-left:20px;
    }
    .slip{
        text-align:center;
    }
    .detail{
        margin-left: 10px;
    }
    .detail span{
        font-weight: bold;
        font-size: 15px;
    }
    .groupa{
        font-weight: bold;
        font-size: 15px;
        margin-left:100px;
        margin-top:20px;
        
    }
    .groupb{
        font-weight: bold;
        font-size: 15px;
        margin-left:100px;
        margin-top:10px;
        
    }
    .col-md-6 .amazing span{
        width: 70% !important;
    }
    .notAllow{
        text-align: center;
        font-size: 20px;
        font-weight: bold;
        color: red;
        margin-top: 100px;
    }
</style>
<html>
    <body>
    <div class="report-content">
        <form method="post" id="consultantForm" class="searchForm">
        <div class="row form_row">
        <div class="form-group">
            <div class="col-md-6">
           
            <b>YEAR </b>
                    <?php 
                     $years = array();
                     $currentYear = date('Y');
                     $startyear = "2020";
                     for($i = $startyear;$i<= $currentYear;$i++){
                         $years[] =  array('AMSFYEAR' => $i);
                     }
                    Select2::create(array(
                        "multiple"=>false,
                        "name"=>"AMSFYEAR",
                        //"defaultOption"=>array($currentYear => $currentYear),
                        "dataSource"=>$years,
                        "dataBind"=>array(
                            "text"=>"AMSFYEAR",
                            "value"=>"AMSFYEAR",
                        ),
                        "attributes"=>array(
                            "class"=>"form-control"
                        ),
                        "clientEvents"=>array(
                            "change"=>"function(e){
                                var xp = $('#AMSFYEAR').val();
                                var xp1 = $('#AMSFYEAREND').val();
                                if(xp > xp1){
                                    $('#AMSFYEAR').val($currentYear);
                                    alert('From year cannot bigger than to year');
                                    $('#searchid').attr('disabled',true);
                                }
                                else
                                {
                                    $('#searchid').attr('disabled',false);
                                }
                            }",
                            )
                    ));
                    ?>
                    
                    <!-- <div class = "module_class">
                    <b>TO </b>
                    <?php 
                     $years1 = array();
                     $currentYear1 = date('Y');
                     $startyear1 = "2020";
                     for($i1 = $startyear1;$i1<= $currentYear1;$i1++){
                         $years1[] =  array('AMSFYEAREND' => $i1);
                     }
                    Select2::create(array(
                        "multiple"=>false,
                        "name"=>"AMSFYEAREND",
                       // "defaultOption"=>array($currentYear1 => $currentYear1),
                        "dataSource"=>$years1,
                        "dataBind"=>array(
                            "text"=>"AMSFYEAREND",
                            "value"=>"AMSFYEAREND",
                        ),
                        "attributes"=>array(
                            "class"=>"form-control"
                        ),
                        "clientEvents"=>array(
                            "change"=>"function(e){
                                var xp = $('#AMSFYEAR').val();
                                var xp1 = $('#AMSFYEAREND').val();
                                if(xp1 < xp){
                                    $('#AMSFYEAREND').val($currentYear1);
                                    alert('To year cannot less than from year');
                                    $('#searchid').attr('disabled',true);
                                }
                                else
                                {
                                    $('#searchid').attr('disabled',false);
                                }
                            }",
                            )
                    ));
                    ?>
                    </div> -->
                </div>
            </div>
       
                <div class="form-group">
                <div class="col-md-6">
                    <button class="btn btn-primary" id="searchid">SEARCH</button>
                </div>
            </div>
        </div>
    </form>
        <div class="clear"></div>
        <?php
        if(!empty($newArrayDept))
        {
        ?>
        <div class="text-right">
        <!-- <div class="download_div">
            <form method="post" action="<?php echo config('app.koolreport_server_url');?>/fundutmccontactpersonpdf">
                <button class="btn btn-primary">Download Portrait PDF</button>
            </form>
         </div>
         <div class="download_div">
            <form method="post" action="<?php echo config('app.koolreport_server_url');?>/fundutmccontactpersonlandscapepdf">
                <button class="btn btn-primary">Download Landscape PDF</button>
            </form>
         </div> -->
         <div class="download_div">
            <form method="post" action="<?php echo config('app.koolreport_server_url');?>/amsfd2formdistributorexcel">
            <input type="hidden" value="<?php echo $this->params["DID"]; ?>" name="DISTRIBUTORID" />
                 <input type="hidden" value="<?php echo $this->params["AMSFYEAR"]; ?>" name="AMSFYEAR" />
                <button class="btn btn-primary">Download EXCEL</button>
            </form>
        </div>
        </div>
        <?php
        }
        ?>
        <div style="height:20px;"></div>
        <div class="clear"></div>
    <?php
    $datacon = $this->dataStore('AMSFD2FORMREPORT');
    $datadistributor = $this->dataStore('DISTRIBUTORLISTD2');
   
    $ryear = "";
    $newDate = "";
    $ryear = (int)$this->params['AMSFYEAR']+1;
    $newDate = $ryear ;//date('Y', strtotime($ryear. ' + 1 year'));
    $newArrayCon = array();

    $totalgroupa = 0.00;
    $totalgroupb = 0.00;
    foreach($datadistributor as $row1)
    {
    ?>
        <div class="text-left">
            <h1>FORM D2</h1>
            <div class="companyname">COMPANY: <span><?php echo $row1['DIST_NAME'];?></span></div>
            <div>Total Gross Sales for the Year ended 31 December <?php echo $this->params["AMSFYEAR"]; ?></div>
        </div>
       <?php
    }
    if(!empty($newArrayDept))
    {
    foreach($datacon as $row)
    {

            $newArrayCon[] =  array( 
                                 // 'AMSF YEAR' => $row['AMSF_YEAR'],
                                  'FULL NAME' => $row['FUND_NAME'],
                                   'FUND CATEGORY' => $row['GROUP_ASSET'],
                                   'FUND GROUP' => $row['FUND_GROUP'],
                                   'TOTAL GROSS SALE(RM)' => $row['TGS_AMOUNT'],
                                   'REMARKS' => $row['AUM_REMARKS_MANAGER'],
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
        "columns"=>array(
            "FULL NAME"=>array(
               // "label"=>"DISTRIBUTOR",
                "type"=>"string",
                "searchable" => true,
               // "type"=>"datetime",
               // "format"=>"Y-m-d H:i:s",
               // "displayFormat"=>"Y"
              // "footer"=>"sum",
               //"footerText"=>"<b>TOTAL</b>",
            ),
            "FUND CATEGORY"=>array(
                // "label"=>"DISTRIBUTOR",
                 "type"=>"string",
                 "searchable" => true,
                // "type"=>"datetime",
                // "format"=>"Y-m-d H:i:s",
                // "displayFormat"=>"Y"
               // "footer"=>"sum",
               // "footerText"=>"<b>TOTAL</b>",
             ),
             "FUND GROUP"=>array(
                // "label"=>"DISTRIBUTOR",
                 "type"=>"string",
                 "searchable" => true,
                // "type"=>"datetime",
                // "format"=>"Y-m-d H:i:s",
                // "displayFormat"=>"Y"
               // "footer"=>"sum",
                "footerText"=>"<b>TOTAL</b>",
             ),
            "TOTAL GROSS SALE(RM)"=>array(
                //"label"=>"TOTAL",
                "type"=>"number",
                "decimals"=>2,
                "cssStyle"=>"text-align:center",
                "footer"=>"sum",
                "footerText"=>"<b>@value</b>",
            ),
            "REMARKS"=>array(
                // "label"=>"DISTRIBUTOR",
                 "type"=>"string",
                 "searchable" => true,
                // "type"=>"datetime",
                // "format"=>"Y-m-d H:i:s",
                // "displayFormat"=>"Y"
               // "footer"=>"sum",
               // "footerText"=>"<b>TOTAL</b>",
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
}
else{
?>
<div class="notAllow"> You are not allowed to see this report.</div>
<?php  
}
        ?>
        </div>
    </body>
</html>


