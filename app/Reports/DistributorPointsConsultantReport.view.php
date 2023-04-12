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
    .dataTable{
        width : 100% !important;
        margin: 0 auto;
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
    .downloadlink{
        margin-right: 10px;
    }
</style>
<html>
    <body>
    <div class="text-center">
    <h1>Distributor Points Report</h1>
        </div>
        <div class="text-right downloadlink">
        <!-- <a href="<?php echo config('app.koolreport_server_url');?>/distributorpointconsultantpdf?POINTID=<?php echo $this->params["POINTID"]; ?>" style= margin-botom:10px;margin-right:5px;" class="btn btn-primary">Download Portrait PDF</a>
          <a href="<?php echo config('app.koolreport_server_url');?>/distributorpointconsultantlandscapepdf?POINTID=<?php echo $this->params["POINTID"]; ?>" style="margin-botom:10px;margin-right:5px;" class="btn btn-primary">Download Landscape PDF</a> -->
          <a href="<?php echo config('app.koolreport_server_url');?>/distributorpointconsultantexcel?POINTID=<?php echo $this->params["POINTID"]; ?>" style="margin-botom:10px;margin-right:5px;" class="btn btn-primary">Download EXCEL</a>
        </div>
        <div class="clear"></div>
    <?php 
      $data = $this->dataStore('DISTRIBUTORPOINTBYREPORT');
      foreach($data as $row)
      {
    ?>
    <div class="text-left" style="width: 70% !important; margin:20px;">
    <div style="font-weight:bold;font-size:15px;margin-bottom:10px">Distributor Name : <?php echo $row['DIST_NAME']; ?></div>
    <div style="font-size:15px;margin-bottom:10px">Distributor Point Name : <?php echo $row['DIST_POINT_NAME']; ?></div>
    <div style="font-size:15px;margin-bottom:10px">Distributor Point Code : <?php echo $row['DIST_POINT_CODE']; ?></div>
    <div style="font-size:15px;margin-bottom:10px">Address : <?php echo $row['ADDRESS']; ?></div>
    </div> 
<?php
      }
    
      DataTables::create([
        "dataSource"=>$this->dataStore('CONSULTANTPOINTREPORTDETAIL'),
        "plugins" => ["Buttons"],
        //"showFooter"=>true,
       // "complexHeaders" => true,
       // "headerSeparator" => "-",
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
            "CONSULTANT_NAME"=>array(
                "label"=>"CONSULTANT",
                "type"=>"string",
                "searchable" => true,
            ),
            "CONSULTANT_NRIC"=>array(
                "label"=>"NRIC",
                "type"=>"string",
            ),
            "CONSULTANT_FIMM_NO"=>array(
                "label"=>"FIMM NO",
                "type"=>"string",
            ),
            "TYPE_NAME"=>array(
                "label"=>"TYPE",
                "type"=>"string",
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
    </body>
</html>


