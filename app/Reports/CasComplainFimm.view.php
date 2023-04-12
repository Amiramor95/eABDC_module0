<?php
use \koolreport\widgets\koolphp\Table;
use \koolreport\inputs\Select2;
use \koolreport\inputs\DateRangePicker;
use \koolreport\datagrid\DataTables;
use \koolreport\core\Utility as Util;
use \koolreport\inputs\CheckBoxList;
//echo $this->params["COMPLAINYEAR"];
//echo $this->params["COMPLAINYEAREND"];
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
    .downloadlink{
        margin-right: 10px;
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
            display: block;
            margin-left: 20px;
            vertical-align: top;
            width: 99%;
            margin-top: 20px;
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
        width: 68% !important;
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
    .select2-container--open .select2-dropdown{
        width: 332.917px !important;  
    }
    .dataTables_length{
        display: none;
    }
    #searchid{
        margin-left: 42px;
    }
</style>
<html>
    <body>
    <form method="post" id="consultantForm" class="searchForm">
        <div class="row form_row">
        <div class="form-group">
            <div class="col-md-6">
           
            <b>YEAR </b>
                    <?php 
                     $years = array();
                     $currentYear = date('Y');
                     $startyear = "2017";
                     for($i = $startyear;$i<= $currentYear;$i++){
                         $years[] =  array('COMPLAINYEAR' => $i);
                     }
                    Select2::create(array(
                        "multiple"=>false,
                        "name"=>"COMPLAINYEAR",
                        //"defaultOption"=>array($currentYear => $currentYear),
                        "dataSource"=>$years,
                        "dataBind"=>array(
                            "text"=>"COMPLAINYEAR",
                            "value"=>"COMPLAINYEAR",
                        ),
                        "attributes"=>array(
                            "class"=>"form-control"
                        ),
                        "clientEvents"=>array(
                            "change"=>"function(e){
                                var xp = $('#COMPLAINYEAR').val();
                                var xp1 = $('#COMPLAINYEAREND').val();
                                if(xp > xp1){
                                    $('#COMPLAINYEAR').val($currentYear);
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
                    
                   <div class ="module_class">
                    <b>TO </b>
                    <?php 
                     $years1 = array();
                     $currentYear1 = date('Y');
                     $startyear1 = "2020";
                     for($i1 = $startyear1;$i1<= $currentYear1;$i1++){
                         $years1[] =  array('COMPLAINYEAREND' => $i1);
                     }
                    Select2::create(array(
                        "multiple"=>false,
                        "name"=>"COMPLAINYEAREND",
                        "defaultOption"=>array($currentYear1 => $currentYear1),
                        "dataSource"=>$years1,
                        "dataBind"=>array(
                            "text"=>"COMPLAINYEAREND",
                            "value"=>"COMPLAINYEAREND",
                        ),
                        "attributes"=>array(
                            "class"=>"form-control"
                        ),
                        "clientEvents"=>array(
                            "change"=>"function(e){
                                var xp = $('#COMPLAINYEAR').val();
                                var xp1 = $('#COMPLAINYEAREND').val();
                                if(xp1 < xp){
                                    $('#COMPLAINYEAREND').val($currentYear1);
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
                    </div> 
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

        <div class="text-center">
            <h1>Total number of complaints received by FIMM</h1>
        </div>
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
            <form method="post" action="<?php echo config('app.koolreport_server_url');?>/cascomplainfimmexcel">
            <input type="hidden" value="<?php echo $this->params["COMPLAINYEAREND"]; ?>" name="COMPLAINYEAREND" />
                 <input type="hidden" value="<?php echo $this->params["COMPLAINYEAR"]; ?>" name="COMPLAINYEAR" />
                <button class="btn btn-primary">Download EXCEL</button>
            </form>
        </div>
        </div>
        
        <div class="clear"></div>
     <?php
    $data_close = $this->dataStore("close_source");
    $data_ongoing = $this->dataStore("ongoing_source");
    $data_main = $this->dataStore("complain_source");
    $ta1 = array();
    $ta2 = array();
    $ta3 = array();
    $dt =array();
    $databyyear = array();
    $databyyearfinal = array();
  foreach ($data_close as $d) {
    array_push($ta1, $d['year']);
        $dt['total1'] = $d['total1'];
        $dt['total2'] = 0;
        $dt['total'] = 0;
        $dt['year_of_complain'] = $d['year'];
        array_push($databyyear, $dt);
  }
  foreach ($data_ongoing as $d1) {
        array_push($ta2, $d1['year1']);
        $dt['total2'] = $d1['total2'];
        $dt['total1'] = 0;
        $dt['total'] = 0;
        $dt['year_of_complain'] = $d1['year1'];
        array_push($databyyear, $dt);
  }
  foreach($data_main as $ta_l){
     array_push($ta3, $ta_l['year_of_complain']);
        if(!in_array($ta_l['year_of_complain'], $ta1)){
        $dt['total1'] = 0;
        }
        if(!in_array($ta_l['year_of_complain'], $ta2)){
        $dt['total2'] = 0;
        }
        $dt['total'] = $ta_l['total'];
        $dt['year_of_complain'] = $ta_l['year_of_complain'];
        array_push($databyyear, $dt);
}
$out = array();
foreach($databyyear as $x){
   // print_r($x['year_of_complain']);
    $out[$x['year_of_complain']]['total'] = 0;
    $out[$x['year_of_complain']]['total1'] = 0;
    $out[$x['year_of_complain']]['total2'] = 0;
}
foreach($databyyear as $x){

    // Log::info(print_r($x));
    $out[$x['year_of_complain']]['total'] += $x['total'];
    $out[$x['year_of_complain']]['total1'] += $x['total1'];
    $out[$x['year_of_complain']]['total2'] += $x['total2'];
    $out[$x['year_of_complain']]['year_of_complain'] = $x['year_of_complain'];
}

$finaloutput = array_values($out);
      DataTables::create([
            "dataSource"=>$finaloutput,
            "plugins" => ["Buttons"],
            //"complexHeaders" => true,
           // "headerSeparator" => "-",
            "options"=>array(
               // "dom" => 'Blfrtip',
                "paging"=>true,
                "pageLength" => 10,
                "searching"=>true,
                "colReorder"=>true,
                "buttons" => [
                  "csv", "excel", "pdf", "print"
                ],
                "order"=>array(
                    array(0,"desc"), //Sort by first column desc
                ),
            ),
            "searchOnEnter" => true,
            "searchMode" => "or",
            "themeBase"=>"bs4",
            "columns"=>array(
                "year_of_complain"=>array(
                    "label"=>"YEAR",
                   // "type"=>"number",
                    "searchable" => true,
                    "type"=>"datetime",
                    "format"=>"Y-m-d H:i:s",
                    "displayFormat"=>"Y"
                ),
                "total"=>array(
                  "label"=>"TOTAL COMPLAINTS",
                  "type"=>"number",
                  //"searchable" => true,
                ),
                "total1"=>array(
                    "label"=>"CLOSED",
                    "type"=>"number",
                    //"searchable" => true,
                ),
                "total2"=>array(
                    "label"=>"ON-GOING",
                    "type"=>"number",
                    //"searchable" => true,
                  )
            ),
            "cssClass"=>array(
                "table"=>"table table-striped table-bordered"
            )
        ]);
        ?>
    </body>
</html>


