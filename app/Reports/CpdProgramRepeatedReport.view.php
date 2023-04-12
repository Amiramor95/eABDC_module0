<?php
//use \koolreport\widgets\koolphp\Table;
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
    .downloadlink{
        margin-right: 10px;
    }
</style>
<html>
    <body>
    <?php 
        //echo  $logoSrc = url('/')."/koolreport_assets/3186757410/KoolReport.js";
    ?>

        <div class="text-center">
            <h1>List of CPD Program (Secretariat) - Repeated</h1>
        </div>
        <div class="text-right downloadlink">
        <!-- <a href="<?php echo config('app.koolreport_server_url');?>/cpdprogramrepeatedpdf" style= margin-botom:10px;margin-right:5px;" class="btn btn-primary">Download Portrait PDF</a>
          <a href="<?php echo config('app.koolreport_server_url');?>/cpdprogramrepeatedlandscapepdf" style="margin-botom:10px;margin-right:5px;" class="btn btn-primary">Download Landscape PDF</a> -->
          <a href="<?php echo config('app.koolreport_server_url');?>/cpdprogramrepeatedexcel" style="margin-botom:10px;margin-right:5px;" class="btn btn-primary">Download EXCEL</a>

        </div>
        <div class="clear"></div>
<?php
$data_queryB = $this->dataStore('PROGRAMREPEATED');
$newArray = array();
foreach($data_queryB as $row)
{

    if($row['CATEGORY'] == 2)
    {
        $newArray[] =  array('COMPANY' => $row['COMPANY'],
                           'PROGRAM ID' => $row['PROG_CODE'],
                           'PROGRAM TITLE' => $row['PROG_TITLE'],
                           'DATE' => $row['PROG_DATE_START'],
                           'SPEAKER/TRAINER' => $row['SPEAKER'],
                           'CPD POINTS' => $row['POINT'],
                           'APPROVAL STATUS' => $row['TS_PARAM'],
                         );
    }
    if($row['CATEGORY'] == 3)
    {
        $newArray[] =  array('COMPANY' => $row['COMPANY1'],
                           'PROGRAM ID' => $row['PROG_CODE'],
                           'PROGRAM TITLE' => $row['PROG_TITLE'],
                           'DATE' => $row['PROG_DATE_START'],
                           'SPEAKER/TRAINER' => $row['SPEAKER'],
                           'CPD POINTS' => $row['POINT'],
                           'APPROVAL STATUS' => $row['TS_PARAM'],
                         );
    }
}
// echo "<pre>";
// print_r($newArray);
// echo "</pre>";
    DataTables::create([
            "dataSource"=>$newArray,
            //"themeBase" => "bs4",
            "plugins" => ["Buttons"],
            "options"=>array(
               // "dom" => 'Blfrtip',
                "paging"=>true,
                "pageLength" => 10,
                "searching"=>true,
               // "fixedHeader"=>true,
                "colReorder"=>true,
                "complexHeaders" => true,
                "headerSeparator" => "-",
                "showFooter"=>true,
               // "showFooter"=>true,
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
           // "columns"=>$columns,
            "cssClass"=>array(
                "table"=>"table table-bordered table-striped"
            )
        ]);
        ?>
    </body>
</html>


