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
    .row_title{
        text-transform: uppercase !important;
        font-size: 14px;
        font-weight: bold;
    }
    .dataTable{
        width: 98% !important;
        margin: auto !important;
    }
    .red{
        color: red;
    }
    .green{
        color: green;
    }
    .black{
        color: black;
    }
    .downloadlink{
        margin-right: 10px;
    }
</style>
<html>
    <body>
    <div class="report-content">

        <div class="text-center">
            <h1>User Details</h1>
        </div>
        <div class="clear"></div>
    <div class="text-right downloadlink">
        <!-- <a href="<?php echo config('app.koolreport_server_url');?>/adminuserdetailpdf?fuserid=<?php echo $this->params["UID"]; ?>" style= margin-botom:10px;margin-right:5px;" class="btn btn-primary">Download Portrait PDF</a>
          <a href="<?php echo config('app.koolreport_server_url');?>/adminuserdetaillandscapepdf?fuserid=<?php echo $this->params["UID"]; ?>" style="margin-botom:10px;margin-right:5px;" class="btn btn-primary">Download Landscape PDF</a> -->
          <a href="<?php echo config('app.koolreport_server_url');?>/adminuserdetailexcel?fuserid=<?php echo $this->params["UID"]; ?>" style="margin-botom:10px;margin-right:5px;" class="btn btn-primary">Download EXCEL</a>
        </div>
        <div style="height:20px;"></div>
        <div class="clear"></div>
    <?php
    $datafimm = $this->dataStore('FIMMUSERDETAIL');
    // $datadistributor = $this->dataStore('DISTRIBUTORUSER');
    // $dataconsultant = $this->dataStore('CONSULTANTUSER');
    // $dataothers = $this->dataStore('OTHERSUSER');
    $newArrayFimm = array();
    $newArrayDistributor = array();
    $newArrayConsultant = array();
    $newArrayOthers = array();
  foreach( $datafimm as $row){
      if($row['USER_STATUS'] == 0)
      {
          $status = "INACTIVE";
          $cl = "red";
      }
      else if($row['USER_STATUS'] == 1)
      {
          $status = "PENDING";
          $cl = "black";
      }
      else if($row['USER_STATUS'] == 2)
      {
          $status = "APPROVED";
          $cl = "green";
      }
      else{
        $status = "RETURNED";
        $cl = "red";
      }
        ?>

            <table  class="table table-striped table-bordered dataTable no-footer " role="grid" aria-describedby="datatables6242d0c6676311_info">
            <tbody>
            <tr class="odd" role="row">
                    <td class="row_title">USERID</td>
                    <td class="sorting_1">
                    <?php echo $row['USER_ID']; ?>
                    </td>
                </tr>
                <tr class="odd" role="row">
                    <td class="row_title">Name</td>
                    <td class="sorting_1">
                   <?php echo $row['USER_NAME']; ?>
                    </td>
                </tr>
                <tr class="even" role="row">
                    <td class="row_title">Email</td>
                    <td class="sorting_1">
                    <?php echo $row['USER_EMAIL']; ?>
                    </td>
                </tr>
                <tr class="even" role="row">
                    <td class="row_title">NRIC</td>
                    <td class="sorting_1">
                    <?php echo $row['NRIC']; ?>
                    </td>
                </tr>
                <tr class="even" role="row">
                    <td class="row_title">Status</td>
                    <td class="sorting_1 <?php echo $cl; ?>">
                    <?php echo $status; ?>
                    </td>
                </tr>
                <tr class="even" role="row">
                    <td class="row_title">USER ROLE</td>
                    <td >
                    <?php echo $row['USERROLE']; ?>
                    </td>
                </tr>
                <tr class="even" role="row">
                    <td class="row_title">COMPANY</td>
                    <td >
                            FIMM
                    </td>
                </tr>
                <tr class="even" role="row">
                    <td class="row_title">Office No.</td>
                    <td class="sorting_1">
                    <?php echo $row['PHONE']; ?>
                    </td>
                </tr>
                <tr class="even" role="row">
                    <td class="row_title">COUNTRY</td>
                    <td class="sorting_1">
                    <?php echo $row['COUNTRY']; ?>
                    </td>
                </tr>
                <tr class="even" role="row">
                    <td class="row_title">CITY</td>
                    <td class="sorting_1">
                    <?php echo $row['CITY']; ?>
                    </td>
                </tr>
                <tr class="even" role="row">
                    <td class="row_title">STATE</td>
                    <td class="sorting_1">
                    <?php echo $row['STATE']; ?>
                    </td>
                </tr>
                <tr class="even" role="row">
                    <td class="row_title">POSTAL</td>
                    <td class="sorting_1">
                    <?php echo $row['POSTAL']; ?>
                    </td>
                </tr>
                <tr class="even" role="row">
                    <td class="row_title">ADDRESS</td>
                    <td class="sorting_1">
                    <?php echo $row['ADDRESS']; ?>
                    </td>
                </tr>
                <tr class="even" role="row">
                    <td class="row_title">DEPARTMENT</td>
                    <td class="sorting_1">
                    <?php echo $row['DPMT_NAME']; ?>
                    </td>
                </tr>
                <tr class="even" role="row">
                    <td class="row_title">DIVISION</td>
                    <td class="sorting_1">
                    <?php echo $row['DIV_NAME']; ?>
                    </td>
                </tr>
                <tr class="even" role="row">
                    <td class="row_title">GROUP</td>
                    <td class="sorting_1">
                    <?php echo $row['GROUP_NAME']; ?>
                    </td>
                </tr>
                <tr class="even" role="row">
                    <td class="row_title">IP ADDRESS</td>
                    <td class="sorting_1">
                    <?php echo $row['IP']; ?>
                    </td>
                </tr>
             </tbody>
            </table>
            <?php
  }
  ?>
        </div>
    </body>
</html>


