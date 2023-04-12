<?php
use \koolreport\widgets\koolphp\Table;
use \koolreport\inputs\Select2;
use \koolreport\inputs\DateRangePicker;
use \koolreport\datagrid\DataTables;
use \koolreport\core\Utility as Util;
use \koolreport\inputs\CheckBoxList;

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
    .form_row{
        margin-right:20px !important;
        margin-left:10px !important;
    }
    .dataTables_length{
        display: none !important;
    }
    .date-range-picker{
        width: 40% !important;
    }
    .download_div{
        display:inline-block;
        margin-right: 10px;
    }
    #searchid{
        margin-left: 42px;
    }
</style>
<html>
    <body>
    

        <div class="text-center">
            <h1>The Total Number Of UTS/PRS Consultants Was Taken Action By FIMM Based On Distributors</h1>
        </div>
       
        <div class="clear"></div>
        <form method="post">
        <div class="row form_row">
            <div class="col-md-6">
           
                <div class="form-group">
                    <b>COMPANY</b>
                    <?php 
                    Select2::create(array(
                        "multiple"=>true,
                        "name"=>"DISTRIBUTORIDS",
                        "defaultOption"=>array("Please Select Company"=>0),
                        "dataSource"=>$this->dataStore('CASCOMPANY'),
                        "dataBind"=>array(
                            "text"=>"DIST_NAME",
                            "value"=>"DISTRIBUTORID",
                        ),
                        "attributes"=>array(
                            "class"=>"form-control"
                        )
                    ));
                    ?>
                </div>
             
                <div class="form-group">
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
            </div>
            <div class="form-group">
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

                <div class="form-group">
                    <button id="searchid" class="btn btn-primary">Search</button>
                </div>   
            </div>
        </div>
    </form>
    <div class="text-right">
    <div class="download_div">
            <form method="post" action="<?php echo config('app.koolreport_server_url');?>/cassanctionedexcel">
            <?php
                foreach ($this->params['DISTRIBUTORIDS'] as  $value) {
                ?>
                  <input type="hidden" name="DISTRIBUTORIDS[]" value="<?php echo $value; ?>">
                <?php
                }
                ?>
            <input type="hidden" value="<?php echo $this->params["COMPLAINYEAREND"]; ?>" name="COMPLAINYEAREND" />
                 <input type="hidden" value="<?php echo $this->params["COMPLAINYEAR"]; ?>" name="COMPLAINYEAR" />
                <button class="btn btn-primary">Download EXCEL</button>
            </form>
        </div>
        </div>
<?php
    $data = $this->dataStore("SANCTIONED");
    $newArray = array();
    $mapYear = array();
    foreach ( $data as $v ) {
    if ( !isset($newArray[$v['DISTRIBUTOR_ID']]) ) {
    $mapYear[$v['year']] = $v['total'] ?? 0;
    $newArray[$v['DISTRIBUTOR_ID']] = array('NAME' => $v['DIST_NAME']);
    }else{
    $mapYear[$v['year']] = $v['total'] ?? 0;
    }
    $newArray[$v['DISTRIBUTOR_ID']][$v['year']] = $v['total'] ?? 0;//array($mapYear);
    }
    // echo "<pre>";
    // print_r($newArray);
    // echo "</pre>";
    $finaloutput = array_values($newArray);
      DataTables::create([
            "dataSource"=>$finaloutput,
            "plugins" => ["Buttons"],
            "options"=>array(
               // "dom" => 'Blfrtip',
                "paging"=>true,
                "pageLength" => 10,
                "searching"=>true,
                "colReorder"=>true,
                "complexHeaders" => true,
                "headerSeparator" => "-",
                "showFooter"=>true,
                //"scrollX" => true,
               // "scrollCollapse" => true,
                "order"=>array(
                    array(0,"asc"), //Sort by first column desc
                   // array(1,"asc"), //Sort by second column asc
                ),
            ),
            "searchOnEnter" => true,
            "searchMode" => "or",
            "cssClass"=>array(
                "table"=>"table table-bordered table-striped"
            )
        ]);
        ?>
    </body>
</html>


