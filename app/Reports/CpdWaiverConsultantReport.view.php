<?php
use \koolreport\widgets\koolphp\Table;
use \koolreport\inputs\Select2;
use \koolreport\datagrid\DataTables;
use \koolreport\core\Utility as Util;
$DIST_YEAR = "";
$this->dataStore("WAIVERCONSULTANTREPORT")->popStart();
while($row = $this->dataStore("WAIVERCONSULTANTREPORT")->pop())
{
    if($row["CONSULTANTYEAR"]==$this->params["CONSULTANTYEAR"])
    {
        $DIST_YEAR =$row["CONSULTANTYEAR"];
    }
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
    .koolphp-table{
    width: 98% !important;
    margin: auto !important;
    }
    .year-block{
      margin-right: 25px !important;
    }
    .vcenter-item{
    display: flex;
    align-items: center;
   }
   .list-inline-item{
       font-size:20px;
   }
   .form_row{
        margin-right:20px !important;
        margin-left:10px !important;
    }
    .select2-container .select2-selection--single{
        width: 20% !important;
    }
    .select2-container--open .select2-dropdown--below{
        width:140px !important;
    }
    .downloadlink{
        margin-right: 10px;
    }
</style>
<html>
    <body>
    <div class="text-center">
    <h1>List of Waiver From CPD Requirements</h1>
        </div>
        <div class="text-right downloadlink">
        <!-- <a href="<?php echo config('app.koolreport_server_url');?>/cpdwaiverpdf?consultantid=<?php echo $this->params["CID"]; ?>" style= margin-botom:10px;margin-right:5px;" class="btn btn-primary">Download Portrait PDF</a>
          <a href="<?php echo config('app.koolreport_server_url');?>/cpdwaiverlandscapepdf?consultantid=<?php echo $this->params["CID"]; ?>" style="margin-botom:10px;margin-right:5px;" class="btn btn-primary">Download Landscape PDF</a> -->
          <a href="<?php echo config('app.koolreport_server_url');?>/cpdwaiverexcel?consultantid=<?php echo $this->params["CID"]; ?>" style="margin-botom:10px;margin-right:5px;" class="btn btn-primary">Download EXCEL</a>

        </div>
        <div class="clear"></div>
    <?php 
        $conyear=0;
        $conmonth=0;
      $data = $this->dataStore('WAIVERCONSULTANTREPORT');
      foreach($data as $row)
      {
           $conyear = $row['CONSULTANTYEAR'];
          $conmonth = $row['MONTH'];
    ?>
    <div class="text-left" style="width: 70% !important; margin:20px;">
    <div style="font-weight:bold;font-size:15px;margin-bottom:10px">Name : <?php echo $row['CONSULTANT_NAME']; ?></div>
    <div style="font-size:15px;margin-bottom:10px">NRIC : <?php echo $row['CONSULTANT_NRIC']; ?></div>
    <div style="font-size:15px;margin-bottom:10px">FIMM NO. : <?php echo $row['CONSULTANT_FIMM_NO']; ?></div>
    <div style="font-size:15px;margin-bottom:10px">COMPANY : <?php echo $row['DIST_NAME']; ?></div>
    </div> 
<?php
      }
      $years = array();
      $currentYear = date('Y');
      $renewalmonth = $conmonth;
      for($i = $conyear;$i<= $currentYear;$i++){
          $years[] =  array('CONSULTANTYEAR' => $i);
      }
     // print_r($years);
     if($conyear == $this->params["CONSULTANTYEAR"])
     {
        $renewalmonth = $conmonth;
    //  echo  $this->params["CONSULTANTYEAR"];
     }
     else{
        $renewalmonth = 01;
     }
     //echo $renewalmonth;
?>
<div class="col-xs-1 year-block text-left">
<form method="post">
        <div class="row form_row">
            <div class="col-md-6">
                <div class="form-group">
                    <b>YEAR</b>
                    <?php 
                    Select2::create(array(
                        "multiple"=>false,
                        "name"=>"CONSULTANTYEAR",
                        "dataSource"=>$years,
                        "dataBind"=>array(
                            "text"=>"CONSULTANTYEAR",
                            "value"=>"CONSULTANTYEAR",
                        ),
                        "attributes"=>array(
                            "class"=>"form-control"
                        ),
                        "clientEvents"=>array(
                            "change"=>"function(e){
                                var xp = $('#CONSULTANTYEAR').val();
                                if($conyear == xp){
                                    $('#CONSULTANTMONTH').val($conmonth);
                                };
                            }",
                            )
                    ));
                    ?>
                </div>
                <div class="form-group">
                <input type="hidden" value="<?php echo $this->params["CID"]; ?>" name="consultantid" />
                <input type="hidden" value="<?php echo  $renewalmonth; ?>" id = "CONSULTANTMONTH" name="CONSULTANTMONTH" />
                    <button class="btn btn-primary">Look Up</button>
                </div>   
            </div>
        </div>
    </form>
</div>
<?php
// echo "<pre>";
// print_r($this->dataStore('WAIVERCONSULTANTREPORTDETAIL'));
// echo "</pre>";
Table::create([
    "dataSource"=>$this->dataStore('WAIVERCONSULTANTREPORTDETAIL'),
    "showFooter"=>true,
    "columns"=>array(
        "REASON"=>array(
            "label"=>"REASON",
            "type"=>"string",
            "searchable" => true,
        ),
        "YEAR"=>array(
            "label"=>"YEAR",
            "type"=>"string",
            "searchable" => true,
        ),
        "APPROVAL_STATUS"=>array(
            "label"=>"APPROVAL STATUS",
            "type"=>"string",
            "searchable" => true,
            "cssStyle"=>"text-align:middle",
        ),
        "RENEWAL_REQUIREMENT"=>array(
            "label"=>"CPD POINT",
            "type"=>"numver",
            "searchable" => true,
            "cssStyle"=>"text-align:middle",
        ),
        // "CPD_POINT"=>array(
        //   "label"=>"CPD POINT",
        //   "cssStyle"=>"text-align:right",
        //   //"prefix"=>"$",
        //   "footer"=>"sum",
        //   //"footerText"=>"<b>Total:</b> @value",
        //   "footerText"=>"<span style='font-weight:bold;padding-bottom:10px'>Total :  @value</span><br><span style= 'font-weight:bold'>Total Approved CPD Points : $total_approve_point</span>",
        // ),
    ),
    "cssClass"=>array(
        "table"=>"table table-bordered table-striped"
    )
]);

?>
    </body>
</html>


