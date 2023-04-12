<?php
namespace App\Reports;
class AmsfB1FormDistributorReportPDF extends \koolreport\KoolReport
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
          //  "DISTRIBUTORIDS" => array(0),
            "AMSFYEAR" => $start_date,
           // "AMSFYEAREND" => $end_date,
           // "CATEGORYIDS" => array(0),
           // "SCHEMENAME"=>0,
        );
    }
    function bindParamsToInputs()
    {
        return array(
          "dateRange"=>"dateRange",
     //    "DISTRIBUTORIDS" => "DISTRIBUTORIDS",
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
        if($this->params["AMSFYEAR"])
        {
        $query_params[":start"] = $this->params["AMSFYEAR"];
        }
        // if(isset($this->params["AMSFYEAREND"]))
        // {
        // $query_params[":end"] = $this->params["AMSFYEAREND"];
        // }
        if($this->params["DID"] != "" )
        {
        $query_params[":COM_ID"] = $this->params["DID"];
        }
        $this->src("mysql")
        ->query("Select SUM(FUND_SUMMARY.TOTAL_NORMAL) AS TOTAL_NORMAL,SUM(FUND_SUMMARY.TOTAL_LOW) AS TOTAL_LOW,SUM(FUND_SUMMARY.TOTAL_NO) AS TOTAL_NO
        from annualFee_management.FUND_SUMMARY AS FUND_SUMMARY
        WHERE 1 =1
        ".(($this->params["DID"]!= "")?"and  FUND_SUMMARY.DISTRIBUTOR_ID = :COM_ID":"")."
        ".(( $this->params["AMSFYEAR"]?"and FUND_SUMMARY.AMSF_YEAR = :start":""))."
        ")
        ->params($query_params)
        ->pipe($this->dataStore("AMSFB1FORMREPORT"));

        $this->src("mysql")
        ->query("select DISTRIBUTOR.DISTRIBUTOR_ID AS DISTRIBUTORID,DISTRIBUTOR.DIST_NAME AS DIST_NAME
        from distributor_management.DISTRIBUTOR AS DISTRIBUTOR
        where DISTRIBUTOR.DISTRIBUTOR_ID = :DISTRIBUTOR_ID")
         ->params(array(
            ":DISTRIBUTOR_ID"=>$this->params["DID"]
         ))
        ->pipe($this->dataStore("DISTRIBUTORLIST"));
        $this->src("mysql")
        ->query("select DISTRIBUTOR_TYPE.DIST_ID AS DIST_ID,DISTRIBUTORTYPE.DIST_TYPE_NAME AS DIST_TYPE_NAME,DISTRIBUTOR_TYPE.DIST_TYPE AS DIST_TYPE
        from distributor_management.DISTRIBUTOR_TYPE AS DISTRIBUTOR_TYPE
        LEFT JOIN admin_management.DISTRIBUTOR_TYPE AS DISTRIBUTORTYPE
        ON DISTRIBUTORTYPE.DISTRIBUTOR_TYPE_ID = DISTRIBUTOR_TYPE.DIST_TYPE
        where DISTRIBUTOR_TYPE.DIST_TYPE IN(3,4,5,6) AND DISTRIBUTOR_TYPE.DIST_ID = :DISTRIBUTOR_ID")
         ->params(array(
            ":DISTRIBUTOR_ID"=>$this->params["DID"]
         ))
        ->pipe($this->dataStore("DISTRIBUTORTYPE"));
       
  }
}
