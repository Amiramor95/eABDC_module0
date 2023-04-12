<?php
namespace App\Reports;
class AmsfTOTALAUMReportPDF extends \koolreport\KoolReport
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
        ->query("Select FUND_SUBMISSION.FIMM_FUND_CODE AS FIMM_FUND_CODE,FUND_SUBMISSION.FUND_NAME AS FUND_NAME,FUND_SUBMISSION.CIS_STRUCTURE AS CIS_STRUCTURE,FUND_SUBMISSION.AUM_AMOUNT AS AUM_AMOUNT,DISTRIBUTOR.DIST_NAME AS DIST_NAME,DISTRIBUTOR.DISTRIBUTOR_ID AS DISTRIBUTOR_ID,DISTRIBUTOR.DIST_CODE AS DIST_CODE,FUND_PROFILE.FUND_NAME_SHORT AS FUND_NAME_SHORT
        from annualFee_management.FUND_SUBMISSION AS FUND_SUBMISSION
        LEFT JOIN distributor_management.DISTRIBUTOR AS DISTRIBUTOR
        ON DISTRIBUTOR.DISTRIBUTOR_ID = FUND_SUBMISSION.DISTRIBUTOR_ID
        LEFT JOIN funds_management.FUND_PROFILE AS FUND_PROFILE
        ON FUND_PROFILE.FUND_PROFILE_ID = FUND_SUBMISSION.FMS_ID
        WHERE  1 = 1
        ".(($this->params["DISTRIBUTORIDS"]!=array(0))?"and FUND_SUBMISSION.DISTRIBUTOR_ID in ( :COM_ID)":"")."
        ".(( $this->params["AMSFYEAR"]?"and FUND_SUBMISSION.AMSF_YEAR >= :start":""))."
        ".(( $this->params["AMSFYEAREND"]?"and FUND_SUBMISSION.AMSF_YEAR <= :end":""))." 
       ")
        ->params($query_params)
        ->pipe($this->dataStore("AMSFTOTALAUMREPORT"));

        $this->src("mysql")
        ->query("select DISTRIBUTOR.DISTRIBUTOR_ID AS DISTRIBUTORID,DISTRIBUTOR.DIST_NAME AS DIST_NAME
        from distributor_management.DISTRIBUTOR AS DISTRIBUTOR
        ")
        ->pipe($this->dataStore("DISTRIBUTORLIST"));
  }
}
