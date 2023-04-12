<?php
use \koolreport\datagrid\DataTables;

?>
<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>USER DETAIL</title>
<meta name="viewport" content="width=device-width, initial-scale=1">

<style>
body {
  font-family: -apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol";
  font-size: 16px;
  font-weight: 600;
  line-height: 1;
  color: #000;
}
.report_container{
    position:relative;
}
.table{
clear: both;
margin-top: 0.5in !important;
margin-bottom: 0.5in !important;
border-collapse: collapse !important;
width: 100% !important;
border: 1px solid #c7cbd5;


}
.table > thead > tr > th {
    background-color:#f0f2f7 !important;
    text-align: left !important;
    line-height: 1;
    height: 50px !important;
    font-weight: bold;
    font-size: 12px;
    padding-left: .60rem;
}
.table > tbody > tr > td {
    text-align: left !important;
    font-size: 12px;
    font-weight: normal;
    padding: .60rem;
    vertical-align: top;
    border: 1px solid #c7cbd5;
}
.clear{
        clear:both;
    }

</style>
</head>
<body >
<?php
$logoSrc = public_path()."/assets/logo_report.png";
?>
<div class="report_container">
    <div class="page-header" style="height:100px;">
    <div style="float: right; height:80px; width: 200px; background-repeat:no-repeat; background-image:    url('data:image/png;base64,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')">
        </div>
        <div class="text-left" style="width: 70% !important;">
            <h3>Report Name : USER DETAIL REPORT</h3>
            <h4>Report Date:  <?php echo date("d-M-Y h:i:sa"); ?></h4>
            <h4>Module Name : ADMIN MODULE</h4>
        </div> 
         <hr style=" border: 3px solid #0a0a38;border-radius: 3px;"/>
    </div>
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
         <div class="page-footer">
         <hr style=" border: 3px solid #0a0a38;border-radius: 3px;"/>
               <span style='float:right'> Page {pageNum}/{numPages}</span>
        </div>
            <!-- <div class="footer">Page {pageNum}/{numPages}</div> -->
    </div>
    </body>
</html>


