<?php
namespace App\Reports;
class AmsfTotalSubmissionReportPDF extends \koolreport\KoolReport
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
        ->query("Select SUM(CONSULTANT_INFO.UTS_COUNT) AS TOTALUTS,SUM(CONSULTANT_INFO.PRS_COUNT) AS TOTALPRS,SUM(CONSULTANT_INFO.COMBINE_UTS_PRS_COUNT) AS TOTALUTSPRS,SUM(CONSULTANT_INFO.SPLIT_UTS_COUNT) AS SPLITUTS,SUM(CONSULTANT_INFO.SPLIT_PRS_COUNT) AS SPLITPRS,SUM(CONSULTANT_INFO.PRC_WAIVER_COUNT) AS TOTALWAIVER,DISTRIBUTOR.DIST_NAME AS DIST_NAME
        from annualFee_management.CONSULTANT_INFO AS CONSULTANT_INFO
        LEFT JOIN distributor_management.DISTRIBUTOR AS DISTRIBUTOR
        ON DISTRIBUTOR.DISTRIBUTOR_ID = CONSULTANT_INFO.DIST_ID
        WHERE 1 = 1
        ".(($this->params["DISTRIBUTORIDS"]!=array(0))?"and CONSULTANT_INFO.DIST_ID in ( :COM_ID)":"")."
        ".(( $this->params["AMSFYEAR"]?"and YEAR(CONSULTANT_INFO.LATEST_UPDATE) >= :start":""))."
        ".(( $this->params["AMSFYEAREND"]?"and YEAR(CONSULTANT_INFO.LATEST_UPDATE) <= :end":""))." 
        GROUP BY CONSULTANT_INFO.DIST_ID")
        ->params($query_params)
        ->pipe($this->dataStore("AMSFTOTALSUBMISSIONREPORT"));

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
