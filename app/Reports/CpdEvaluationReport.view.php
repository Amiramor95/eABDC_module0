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
            <h1>List of Evaluation Report</h1>
        </div>
        <div class="text-right downloadlink">
        <!-- <a href="<?php echo config('app.koolreport_server_url');?>/cpdevaluationpdf" style= margin-botom:10px;margin-right:5px;" class="btn btn-primary">Download Portrait PDF</a>
          <a href="<?php echo config('app.koolreport_server_url');?>/cpdevaluationandscapepdf" style="margin-botom:10px;margin-right:5px;" class="btn btn-primary">Download Landscape PDF</a> -->
          <a href="<?php echo config('app.koolreport_server_url');?>/cpdevaluationexcel" style="margin-botom:10px;margin-right:5px;" class="btn btn-primary">Download EXCEL</a>
        </div>
        <div class="clear"></div>
<?php
$data_evaluation = $this->dataStore('CPDEVALUATION');
$data_feedback = $this->dataStore('CPDEVALUATIONFEEDBACK');
$newArray = array();
$newArrayfeedback = array();
$comname = "";
$SPEAKER ="";
$VENUE = "";
$CONTENTS = "";
$REFRESHMENT = "";
$OVERALL = "";
foreach($data_feedback as $rowFeedback)
{
        if($rowFeedback['ITEM'] == 'SPEAKER'){
            $SPEAKER = $rowFeedback['RATING'];
        }
       if($rowFeedback['ITEM'] == 'VENUE'){
            $VENUE = $rowFeedback['RATING'];
        }
        if($rowFeedback['ITEM'] == 'CONTENTS'){
            $CONTENTS = $rowFeedback['RATING'];
        }
        if($rowFeedback['ITEM'] == 'REFRESHMENT'){
            $REFRESHMENT = $rowFeedback['RATING'];
        }
        if($rowFeedback['ITEM'] == 'OVERALL'){
            $OVERALL = $rowFeedback['RATING'];
        }
     $newArrayfeedback[$rowFeedback['PROG_DETAILS_ID']] =  array(
        'PROG_DETAILS_ID' => $rowFeedback['PROG_DETAILS_ID'],
        'SPEAKER' => $SPEAKER,
        'VENUE' => $VENUE,
        'CONTENTS' => $CONTENTS,
        'REFRESHMENT' => $REFRESHMENT,
        'OVERALL' => $OVERALL,
        );
}
$SPEAKER1 ="";
$VENUE1 = "";
$CONTENTS1 = "";
$REFRESHMENT1 = "";
$OVERALL1 = "";
foreach($data_evaluation as $row)
{
    if($row['CATEGORY'] == 2)
    {
       $comname =  $row['COMPANY'];
    }
    else{
        $comname = $row['COMPANY1'];
    }
    foreach($newArrayfeedback as $dj){
        if( $dj['PROG_DETAILS_ID'] == $row['PROG_DETAILS_ID']){
            $SPEAKER1 =  $dj['SPEAKER'];
            $VENUE1 =  $dj['VENUE'];
            $CONTENTS1 =  $dj['CONTENTS'];
            $REFRESHMENT1 =  $dj['REFRESHMENT'];
            $OVERALL1 =  $dj['OVERALL'];
        }
    }
        $newArray[] =  array('COMPANY' => $comname,
                           'PROGRAM ID' => $row['PROG_CODE'],
                           'PROGRAM TITLE' => $row['PROG_TITLE'],
                           'DATE' => $row['PROG_DATE_START'],
                           'VENUE' => $row['VENUE'],
                           'SPEAKER/TRAINER' => $row['SPEAKER'],
                           'PROGRAM CONTENT/TOPIC' => $CONTENTS1,
                           'SPEAKER' => $SPEAKER1,
                           'REFRESHMENT' => $REFRESHMENT1,
                           'OVERALL' => $OVERALL1,
                           'VENUE1' => $VENUE1,
                         );
}
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
            "columns"=>array(
                "COMPANY"=>array(
                    "label"=>"COMPANY",
                    "searchable" => true,
                    "type"=>"string",
                ),
                "PROGRAM ID"=>array(
                    "label"=>"PROGRAMID",
                    "searchable" => true,
                    "type"=>"string",
                ),
                "PROGRAM TITLE"=>array(
                    "label"=>"TITLE",
                    "type"=>"string",
                    "searchable" => true,
                    // "cssStyle" =>'text-align:right',
                ),
                 "DATE"=>array(
                  "label"=>"DATE",
                  "type"=>"datetime",
                  "format"=>"Y-m-d H:i:s",
                  "displayFormat"=>"Y-m-d H:i:s"
                ),
             "VENUE"=>array(
                    "label"=>"VENUE",
                    "searchable" => true,
                    "type"=>"string",
                ),
                "SPEAKER/TRAINER"=>array(
                    "label"=>"SPEAKER/TRAINER",
                    "searchable" => true,
                    "type"=>"string",
                ),
                "PROGRAM CONTENT/TOPIC"=>array(
                    "label"=>"CONTENT/TOPIC",
                   // "searchable" => true,
                    "type"=>"number",
                ),
                "SPEAKER"=>array(
                    "label"=>"SPEAKER",
                   // "searchable" => true,
                    "type"=>"number",
                ),
                "REFRESHMENT"=>array(
                    "label"=>"REFRESHMENT",
                   // "searchable" => true,
                    "type"=>"number",
                ),
                "VENUE1"=>array(
                    "label"=>"VENUE",
                   // "searchable" => true,
                    "type"=>"number",
                ),
                "OVERALL"=>array(
                    "label"=>"OVERALL",
                   // "searchable" => true,
                    "type"=>"number",
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


