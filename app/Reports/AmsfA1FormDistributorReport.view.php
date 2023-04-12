<?php
use \koolreport\widgets\koolphp\Table;
use \koolreport\inputs\Select2;
use \koolreport\inputs\DateRangePicker;
use \koolreport\datagrid\DataTables;
use \koolreport\core\Utility as Util;
use \koolreport\inputs\CheckBoxList;
$datacon = $this->dataStore('AMSFA1FORMREPORT');
$datadistributor = $this->dataStore('DISTRIBUTORLIST');
$datatype = $this->dataStore('DISTRIBUTORTYPE');
$ryear = "";
$newDate = "";
$ryear = (int)$this->params['AMSFYEAR']+1;
$newDate = $ryear ;//date('Y', strtotime($ryear. ' + 1 year'));
$newArrayCon = array();
$totalgroupa = 0.00;
$totalgroupb = 0.00;
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
    .table_form{
        width: 25% !important;
        margin-left: 25px;
    }
    .text-left{
        font-weight: bold;
    }
    .table td{
        border-top: none !important;
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
            <form method="post" action="<?php echo config('app.koolreport_server_url');?>/amsfa1formdistributorexcel">
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
    if(!empty($newArrayDept))
    {
    foreach($datacon as $row)
    {
       // echo "enter";
        $totalgroupa = $row['TOTALGROUPA'];
        $totalgroupb = $row['TOTALGROUPB'];
    }
    foreach($datadistributor as $row1)
    {
    ?>
        <div class="text-left">
            <h1>FORM A1</h1>
            <div>Asset Under Management for the Year ended 31 December <?php echo $this->params["AMSFYEAR"]; ?></div>
            <div class="companyname">COMPANY: <span><?php echo $row1['DIST_NAME'];?></span></div>
        </div>
        <hr style=" border: 1px solid #0a0a38;border-radius: 1px;"/>
        <div class ="slip">Please send the completed slip to FIMM latest By 15 January <?php echo $newDate;?></div>
        <hr style=" border: 1px solid #0a0a38;border-radius: 1px;"/>
        <div class="detail">We hereby declare the below information of the Asset Under Management(AUM) for <span>Unit Trust Schemes as at 31 December <?php echo $this->params["AMSFYEAR"]; ?></span> are complete, true and accurate.</div>
        <?php
    }
    ?>
        <table class="table_form table">
        <tr>
        <td class="text-left">Total Group A :</td>
        <td class="text-left">RM <?php echo number_format((float)$totalgroupa, 2, '.', ''); ?></td>
        </tr>
        <tr> 
        <td class="text-left">Total Group B :</td>
        <td class="text-left">RM <?php echo number_format((float)$totalgroupb, 2, '.', ''); ?></td>
        </tr>
        </table>
<?php
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


