<?php
use \koolreport\widgets\koolphp\Table;
use \koolreport\inputs\Select2;
use \koolreport\inputs\DateRangePicker;
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
</style>
<html>
    <body>
        <div class="text-center">
            <h1>ENQUIRY REPORT</h1>
        </div>
        <div class="clear"></div>
        <form method="post">
        <div class="row form_row">
            <div class="col-md-6">
            <div class="form-group">
                    <b>Status</b>
                    <?php 
                    Select2::create(array(
                        "multiple"=>true,
                        "name"=>"STATUSIDS",
                        "defaultOption"=>array("Please Select Status"=>0),
                        "dataSource"=>$this->dataStore('CASSTATUS'),
                        "dataBind"=>array(
                            "text"=>"SET_PARAM",
                            "value"=>"STATUSID",
                        ),
                        "attributes"=>array(
                            "class"=>"form-control"
                        )
                    ));
                    ?>
                </div>
                <div class="form-group">
                    <b>Type of License</b>
                    <?php 
                    Select2::create(array(
                        "multiple"=>true,
                        "name"=>"TYPEIDS",
                        "defaultOption"=>array("Please Select Type"=>0),
                        "dataSource"=>$this->dataStore('CASCONSULTANTTYPE'),
                        "dataBind"=>array(
                            "text"=>"TYPE_NAME",
                            "value"=>"TYPEID",
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
                "format"=>"MMM Do, YYYY", //Jul 3rd, 2017
             // "format"=>"YYYY-M-D",
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
    <div class="text-right">
        <div class="download_div">
            <form method="post" action="<?php echo config('app.koolreport_server_url');?>/casenquiryexcel">
            <?php
                ?>
                <?php
                foreach ($this->params['TYPEIDS'] as  $value1) {
                ?>
                 <input type="hidden" name="TYPEIDS[]" value="<?php echo $value1; ?>">
                <?php
                }
                ?>
                <?php
                foreach ($this->params['STATUSIDS'] as  $value2) {
                ?>
                 <input type="hidden" name="STATUSIDS[]" value="<?php echo $value2; ?>">
                <?php
                }
                ?>
                <input type="hidden" value="<?php echo $this->params["dateRange"][0]; ?>" id="dateRange_start" name="dateRange[]" />
                <input type="hidden" value="<?php echo $this->params["dateRange"][1]; ?>" id="dateRange_end" name="dateRange[]" />  
                <button class="btn btn-primary">Download EXCEL</button>
            </form>
        </div>
       
        </div>
        <div class="clear"></div>
     <?php
       $data = $this->dataStore('CASENQUIRY');
       $newArray = array();
       foreach($data as $row)
     {
 
             $newArray[] =  array(
                                  'NAME' => $row['CONSULTANT_NAME'],
                                  'NRIC NO' => $row['CONSULTANT_NRIC'],
                                  'PASSPORT NO' => $row['CONSULTANT_PASSPORT_NO'],
                                  'STATUS' => $row['SET_PARAM'],
                                  'LICENSE' => $row['TYPE_NAME'],
                                  'REASON' => $row['CA_REASON'],
                                  'REMARK' => $row['CA_REMARK'],
                                  'EFFECTIVE DATE' => $row['CA_DATE_START'],
                                  'END DATE' => $row['CA_DATE_END'],
                                  'DOCUMENT' => '<div class="view_detail text-center"><a  href="'.config('app.koolreport_server_url').'/casenquiryfiledownload?fileId='.$row['CA_DOCUMENT_ID'].'">VIEW</a></div>',
                              );
     }
      DataTables::create([
            "dataSource"=>$newArray,
            "plugins" => ["Buttons"],
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
                   // array(1,"asc"), //Sort by second column asc
                ),
            ),
            "searchOnEnter" => true,
            "searchMode" => "or",
            "themeBase"=>"bs4",
            "columns"=>array(
                "NAME"=>array(
                    "label"=>"NAME",
                    "type"=>"string",
                    "searchable" => true,
                ),
                "NRIC NO"=>array(
                  "label"=>"NRIC NO",
                  "type"=>"string",
                  "searchable" => true,
                ),
                "PASSPORT NO"=>array(
                    "label"=>"PASSPORT NO",
                    "type"=>"string",
                ),
                "STATUS"=>array(
                    "label"=>"STATUS",
                    "type"=>"string",
                ),
                "LICENSE"=>array(
                    "label"=>"LICENSE",
                    "type"=>"string",
                ),
                "REASON"=>array(
                    "label"=>"REASON",
                    "type"=>"string",
                ),
                "REMARK"=>array(
                    "label"=>"REMARK",
                    "type"=>"string",
                ),
                "EFFECTIVE DATE"=>array(
                    "label"=>"EFFECTIVE DATE",
                    "type"=>"datetime",
                    "format"=>"Y-m-d H:i:s",
                    "displayFormat"=>"d-M-Y"
                ),
                "END DATE"=>array(
                    "label"=>"END DATE",
                    "type"=>"datetime",
                    "format"=>"Y-m-d H:i:s",
                    "displayFormat"=>"d-M-Y"
                ),
                "DOCUMENT"=>array(
                    "label"=>"DOCUMENT",
                    "type"=>"string",
                ),
            ),
            "cssClass"=>array(
                "table"=>"table table-bordered table-striped"
            )
        ]);
        ?>
    </body>
</html>


