<?php
use \koolreport\widgets\koolphp\Table;
//use \koolreport\inputs\Select2;
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
    .koolphp-table{
    width: 98% !important;
    margin: auto !important;
    }
    .downloadlink{
        margin-right: 10px;
    }
</style>
<html>
    <body>
    <div class="text-center">
    <h1>List of FPAM Modules</h1>
        </div>
        <div class="text-right downloadlink">
        <!-- <a href="<?php echo config('app.koolreport_server_url');?>/cpdfpampdf?consultantid=<?php echo $this->params["CID"]; ?>" style= margin-botom:10px;margin-right:5px;" class="btn btn-primary">Download Portrait PDF</a>
          <a href="<?php echo config('app.koolreport_server_url');?>/cpdfpamlandscapepdf?consultantid=<?php echo $this->params["CID"]; ?>" style="margin-botom:10px;margin-right:5px;" class="btn btn-primary">Download Landscape PDF</a> -->
          <a href="<?php echo config('app.koolreport_server_url');?>/cpdfpamexcel?consultantid=<?php echo $this->params["CID"]; ?>" style="margin-botom:10px;margin-right:5px;" class="btn btn-primary">Download EXCEL</a>

        </div>
        <div class="clear"></div>
    <?php 
      $data = $this->dataStore('FPAMCONSULTANTREPORT');
      foreach($data as $row)
      {
    ?>
    <div class="text-left" style="width: 70% !important; margin:20px;">
    <div style="font-weight:bold;font-size:15px;margin-bottom:10px">Name : <?php echo $row['CONSULTANT_NAME']; ?></div>
    <div style="font-size:15px;margin-bottom:10px">NRIC : <?php echo $row['CONSULTANT_NRIC']; ?></div>
    <div style="font-size:15px;margin-bottom:10px">FIMM NO. : <?php echo $row['CONSULTANT_FIMM_NO']; ?></div>
    <div style="font-size:15px;margin-bottom:10px">COMPANY : <?php echo $row['DIST_NAME']; ?></div>
    </div> 
<?php
      }
$newArray = array();
$data_max = $this->dataStore('FPAMAPPROVEMAX');
foreach($data_max as $row_max)
{
  $total_approve_point = $row_max['CPD_MAX'];
}
//$total_approve_point = 16;
Table::create([
    "dataSource"=>$this->dataStore('FPAMCONSULTANTREPORTDETAIL'),
    "showFooter"=>true,
    "themeBase"=>"bs4",
    "columns"=>array(
        "MODULES"=>array(
            "label"=>"MODULES",
            "type"=>"string",
            "searchable" => true,
        ),
        "COMPLETION_DATE"=>array(
            "label"=>"Date",
            "type"=>"string",
            "searchable" => true,
        ),
        "APPROVAL_STATUS"=>array(
            "label"=>"APPROVAL STATUS",
            "type"=>"string",
            "searchable" => true,
        ),
        "APPROVE_POINT"=>array(
          "label"=>"CPD POINT",
          "cssStyle"=>"text-align:right",
          //"prefix"=>"$",
          "footer"=>"sum",
          //"footerText"=>"<b>Total:</b> @value",
          "footerText"=>"<span style='font-weight:bold;padding-bottom:10px'>Total :  @value</span><br><span style= 'font-weight:bold'>Total Approved CPD Points : $total_approve_point</span>",
        ),
    ),
    "cssClass"=>array(
        "table"=>"table table-bordered table-striped"
    )
]);

?>
    </body>
</html>


