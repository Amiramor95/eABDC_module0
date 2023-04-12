<?php
namespace App\Reports;
class AmsfSummaryUTMCReportPDF extends \koolreport\KoolReport
{
    use \koolreport\laravel\Friendship;
    use \koolreport\clients\FontAwesome;
    use \koolreport\amazing\Theme;
    use \koolreport\export\Exportable;
    use \koolreport\excel\ExcelExportable;
    use \koolreport\inputs\Bindable;
    use \koolreport\inputs\POSTBinding;
    //use \koolreport\cloudexport\Exportable;
    function defaultParamValues()
    {
            $start_date = date('Y');
            $end_date = date('Y');
        return array(
            "dateRange"=>array(
                $start_date,
                $end_date
            ),
            "DISTRIBUTORIDS" => array(0),
            "AMSFYEAR" => $start_date,
            "AMSFYEAREND" => $end_date,
           // "CATEGORYIDS" => array(0),
           // "SCHEMENAME"=>0,
        );
    }
    function bindParamsToInputs()
    {
        return array(
          "dateRange"=>"dateRange",
         "DISTRIBUTORIDS" => "DISTRIBUTORIDS",
        // "CATEGORYIDS" => "CATEGORYIDS",
         "AMSFYEAR" => "AMSFYEAR",
         "AMSFYEAREND" => "AMSFYEAREND",
        // "SCHEMENAME",
        );
    }
    function setup()
    {
      $query_params = array();
      $query_params1 = array();
      $query_params2 = array();
        if(isset($this->params["AMSFYEAR"]))
        {
        $query_params[":start"] = $this->params["AMSFYEAR"];
        }
        if(isset($this->params["AMSFYEAREND"]))
        {
        $query_params[":end"] = $this->params["AMSFYEAREND"];
        }
        if($this->params["DISTRIBUTORIDS"] != array(0) )
        {
        $query_params[":COM_ID"] = $this->params["DISTRIBUTORIDS"];
        }
        $this->src("mysql")
        ->query("Select SUM(FUND_SUMMARY.AUM_GROUP_A_UTC) AS TOTALGROUPA,SUM(FUND_SUMMARY.AUM_GROUP_B_UTC) AS TOTALGROUPB,SUM(FUND_SUMMARY.TOTAL_UTC_LEVY) AS TOTALUTCLEVY,SUM(FUND_SUMMARY.TOTAL_UTC) AS TOTALUTC,DISTRIBUTOR.DIST_NAME AS DIST_NAME
        from annualFee_management.FUND_SUMMARY AS FUND_SUMMARY
        JOIN distributor_management.DISTRIBUTOR_TYPE AS DISTRIBUTOR_TYPE
        ON DISTRIBUTOR_TYPE.DIST_ID = FUND_SUMMARY.DISTRIBUTOR_ID
        LEFT JOIN distributor_management.DISTRIBUTOR AS DISTRIBUTOR
        ON DISTRIBUTOR.DISTRIBUTOR_ID = FUND_SUMMARY.DISTRIBUTOR_ID
        WHERE DISTRIBUTOR_TYPE.DIST_TYPE = 1
        ".(($this->params["DISTRIBUTORIDS"]!=array(0))?"and FUND_SUMMARY.DISTRIBUTOR_ID in ( :COM_ID)":"")."
        ".(( $this->params["AMSFYEAR"]?"and FUND_SUMMARY.AMSF_YEAR >= :start":""))."
        ".(( $this->params["AMSFYEAREND"]?"and FUND_SUMMARY.AMSF_YEAR <= :end":""))." 
        GROUP BY FUND_SUMMARY.DISTRIBUTOR_ID")
        ->params($query_params)
        ->pipe($this->dataStore("AMSFSUMMARYUTMCREPORT"));

        $this->src("mysql")
        ->query("select DISTRIBUTOR.DISTRIBUTOR_ID AS DISTRIBUTORID,DISTRIBUTOR.DIST_NAME AS DIST_NAME
        from distributor_management.DISTRIBUTOR AS DISTRIBUTOR
        ")
        ->pipe($this->dataStore("DISTRIBUTORLIST"));
        $this->src("mysql")
        ->query("select FMS_FUNDCATEGORY.FMS_FUNDCATEGORY_ID AS CATEGORYID,FMS_FUNDCATEGORY.GROUP_ASSET AS GROUP_ASSET
        from admin_management.FMS_FUNDCATEGORY AS FMS_FUNDCATEGORY
        ")
        ->pipe($this->dataStore("CATEGORYLIST"));
  }
}
