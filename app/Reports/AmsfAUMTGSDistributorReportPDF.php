<?php
namespace App\Reports;
class AmsfAUMTGSDistributorReportPDF extends \koolreport\KoolReport
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
        ->query("Select FUND_SUMMARY.AUM_GROUP_A AS TOTALGROUPA,FUND_SUMMARY.AUM_GROUP_B AS TOTALGROUPB,FUND_SUMMARY.TOTAL_NORMAL AS TOTALNORMALLOAD,FUND_SUMMARY.TOTAL_LOW AS TOTALLOWLOAD,FUND_SUMMARY.TOTAL_NO AS TOTALNOLOAD,FUND_SUMMARY.TOTAL_UTC_LEVY AS TOTALUTCLEVY,FUND_SUMMARY.TOTAL_UTC AS TOTALUTC,FUND_SUMMARY.TOTAL_PRC AS TOTALPRC,FUND_SUMMARY.TOTAL_PRC_LEVY AS TOTALPRCLEVY,DISTRIBUTOR.DIST_NAME AS DIST_NAME,DISTRIBUTOR.DISTRIBUTOR_ID AS DISTRIBUTOR_ID,FUND_SUMMARY.UTC_CARD_FEES AS UTCCARDFEE,FUND_SUMMARY.PRC_CARD_FEES AS PRCCARDFEE,FUND_SUMMARY.ANNUAL_FEES AS ANNUALFEES,FUND_SUMMARY.AMSF_YEAR AS AMSF_YEAR
        from annualFee_management.FUND_SUMMARY AS FUND_SUMMARY
        LEFT JOIN distributor_management.DISTRIBUTOR AS DISTRIBUTOR
        ON DISTRIBUTOR.DISTRIBUTOR_ID = FUND_SUMMARY.DISTRIBUTOR_ID
        WHERE  1 = 1
        ".(($this->params["DISTRIBUTORIDS"]!=array(0))?"and FUND_SUMMARY.DISTRIBUTOR_ID in ( :COM_ID)":"")."
        ".(( $this->params["AMSFYEAR"]?"and FUND_SUMMARY.AMSF_YEAR >= :start":""))."
        ".(( $this->params["AMSFYEAREND"]?"and FUND_SUMMARY.AMSF_YEAR <= :end":""))." 
       ")
        ->params($query_params)
        ->pipe($this->dataStore("AMSFAUMTGSDISTRIBUTORREPORT"));

        $this->src("mysql")
        ->query("select DISTRIBUTOR.DISTRIBUTOR_ID AS DISTRIBUTORID,DISTRIBUTOR.DIST_NAME AS DIST_NAME
        from distributor_management.DISTRIBUTOR AS DISTRIBUTOR
        ")
        ->pipe($this->dataStore("DISTRIBUTORLIST"));
        $this->src("mysql")
        ->query("select DISTRIBUTOR_TYPE.DIST_ID AS DIST_ID,DISTRIBUTORTYPE.DIST_TYPE_NAME AS DIST_TYPE_NAME,DISTRIBUTORTYPE.SCHEME AS SCHEME
        from distributor_management.DISTRIBUTOR_TYPE AS DISTRIBUTOR_TYPE
        LEFT JOIN admin_management.DISTRIBUTOR_TYPE AS DISTRIBUTORTYPE
        ON DISTRIBUTORTYPE.DISTRIBUTOR_TYPE_ID = DISTRIBUTOR_TYPE.DIST_TYPE
        ")
        ->pipe($this->dataStore("DISTRIBUTORTYPE"));
  }
}
