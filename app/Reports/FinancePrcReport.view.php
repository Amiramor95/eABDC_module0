<?php
use \koolreport\widgets\koolphp\Table;
use \koolreport\inputs\Select2;
use \koolreport\inputs\DateRangePicker;
use \koolreport\datagrid\DataTables;
use \koolreport\core\Utility as Util;
$DIST_NAME = "";
$this->dataStore("FINANCECOMPANY")->popStart();
while($row = $this->dataStore("FINANCECOMPANY")->pop())
{
    if($row["DISTRIBUTORID"]==$this->params["DISTRIBUTORID"])
    {
        $DIST_NAME =$row["DIST_NAME"];
    }
}
//print_r($this->params["dateRange"]);
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
    .downloadlink{
        margin-right: 10px;
    }
</style>
<html>
    <body>
    <div class="report-content">

        <div class="text-center">
            <h1>PRC Batch Details Report</h1>
        </div>
        <div class="clear"></div>
        <form method="post">
        <div class="row form_row">
            <div class="col-md-6">
                <div class="form-group">
                    <b>COMPANY</b>
                    <?php 
                    Select2::create(array(
                        "multiple"=>false,
                        "name"=>"DISTRIBUTORID",
                        "defaultOption"=>array(""=>2),
                        "dataSource"=>$this->dataStore('FINANCECOMPANY'),
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
                <b>Date Range</b>
                <?php
                DateRangePicker::create(array(
                "name"=>"dateRange",
              //  "format"=>"MMM Do, YYYY", //Jul 3rd, 2017
              "format"=>"YYYY-M-D",
                "ranges"=>array(
                "Today"=>DateRangePicker::today(),
                "Yesterday"=>DateRangePicker::yesterday(),
                "Last 7 days"=>DateRangePicker::last7days(),
                "Last 30 days"=>DateRangePicker::last30days(),
                "This month"=>DateRangePicker::thisMonth(),
                "Last month"=>DateRangePicker::lastMonth(),
                )
                ));
                ?>
                </div>
                <div class="form-group">
                    <button class="btn btn-primary">Search</button>
                </div>   
            </div>
        </div>
    </form>

<?php
if($this->dataStore("FINANCEPRCREPORT")->countData()>0)
{
    ?>
    <div class="text-left" style="width: 70% !important; margin:20px;">
    <div class="report_title">Company Name : Federation Of Investment Managers Malaysia</div>
    <div class="report_title">Report Name: PRC Batch Details Report </div>
    <div class="report_title">Member Name : <?php echo $DIST_NAME; ?></div>
    </div>
    <div class="text-right downloadlink">
        <!-- <a href="<?php echo config('app.koolreport_server_url');?>/financeutcpdf" style= margin-botom:10px;margin-right:5px;" class="btn btn-primary">Download Portrait PDF</a>
          <a href="<?php echo config('app.koolreport_server_url');?>/finaceutclandscapepdf" style="margin-botom:10px;margin-right:5px;" class="btn btn-primary">Download Landscape PDF</a> -->
          <form method="post" action="<?php echo config('app.koolreport_server_url');?>/financeprcexcel">
          <input type="hidden" value="<?php echo $this->params["DISTRIBUTORID"]; ?>" name="DISTRIBUTORID" />
          <input type="hidden" value="<?php echo $this->params["dateRange"][0]; ?>" id="dateRange_start" name="dateRange[]" />
          <input type="hidden" value="<?php echo $this->params["dateRange"][1]; ?>" id="dateRange_end" name="dateRange[]" />  
          <button class="btn btn-primary">Download EXCEL</button>
        </form>
        </div>
        <div style="height:20px;"></div>
        <div class="clear"></div>
    <?php
    $data_queryB = $this->dataStore('FINANCEPRCREPORT');
    $newArray = array();
    foreach($data_queryB as $row)
    {

            $newArray[] =  array(
                                 'BATCH NO.' => "121321", // Later will update
                                 'NAME' => $row['NAME'],
                                 'NRIC' => $row['NRIC'],
                                 'BATCH TYPE' => $row['TYPE_NAME'],
                                 'BATCH DATE' => $row['CREATED_AT'],
                                 'TYPE' => $row['TYPENAME'],
                                 'STATUS' => $row['STATUS'],
                                 'AMOUNT' => $row['AMOUNT'],
                                 'GST(0%)' => $row['GST'],
                             );
    }
    // $newArray[0] =  array(
    //     'Batch' => "Bathch 1",
    //     'Batch Type' => "Utc Re-registration",
    //     'Batch Date' => "17 Feb 2022",
    //     'type' => "Re-register",
    //     'Status' => "Active",
    //     'gst' => "0.00",
    //     'Name' => "Consultant 1",//$row['NAME'],
    //     'NRIC' => "123", //$row['NRIC'],
    //     'Amount' => 5,
    // );
    // $newArray[1] =  array(
    //     'Batch' => "Batch 2",
    //     'Batch Type' => "Utc Re-registration1",
    //     'Batch Date' => "18 Feb 2022",
    //     'type' => "Re-register1",
    //     'Status' => "Active",
    //     'gst' => "0.00",
    //     'Name' => "Consultant 2",//$row['NAME'],
    //     'NRIC' => "345", //$row['NRIC'],
    //     'Amount' => 10,
    // );

    Table::create([
            "dataSource"=>$newArray,
            "showFooter"=>true,
            "paging"=>true,
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
            "columns"=>array(
                "BATCH NO."=>array(
                    "label"=>"BATCH NO. ",
                    "type"=>"string",
                    "searchable" => true,
                ),
                "NAME"=>array(
                    "label"=>"NAME",
                    "type"=>"string",
                    "searchable" => true,
                ),
                "NRIC"=>array(
                    "label"=>"NRIC",
                    "type"=>"string",
                    "searchable" => true,
                ),
                "BATCH TYPE"=>array(
                    "label"=>"BATCH TYPE",
                    "type"=>"string",
                    "searchable" => true,
                ),
                "BATCH DATE"=>array(
                    "label"=>"BATCH DATE",
                    "type"=>"datetime",
                    "format"=>"Y-m-d H:i:s",
                    "displayFormat"=>"d-M-Y"
                ),
                "TYPE"=>array(
                    "label"=>"TYPE",
                    "type"=>"string",
                    "searchable" => true,
                ),
                "STATUS"=>array(
                    "label"=>"STATUS",
                    "type"=>"string",
                    "searchable" => true,
                ),
                "TYPE"=>array(
                    "label"=>"TYPE",
                    "type"=>"string",
                    "searchable" => true,
                ),
                "AMOUNT"=>array(
                  "label"=>"AMOUNT",
                  "cssStyle"=>"text-align:right",
                  "type"=>"number",
                  "format"=>"decimal",
                  "decimals"=>2,
                  "decimalPoint" => ".",
                  "footer"=>"sum",
                  //"footerText"=>"<b>Total:</b> @value",
                  "footerText"=>"<span style='font-weight:bold;padding-bottom:10px'>Total :  @value</span>",
                ),
                "GST(0%)"=>array(
                    "label"=>"GST(0%)",
                    "cssStyle"=>"text-align:right",
                    "footer"=>"sum",
                    "type"=>"number",
                    "format"=>"decimal",
                    "decimals"=>2,
                    "decimalPoint" => ".",
                    "footerText"=>"<span style='font-weight:bold;padding-bottom:10px'> @value</span>",
                ),
            ),
            "cssClass"=>array(
                "table"=>"table table-bordered table-striped",
               
            )
        ]);
    }
        ?>
        </div>
    </body>
</html>


