<?php
namespace App\Reports;
class AmsfAumReportPDF extends \koolreport\KoolReport
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
            "CATEGORYIDS" => array(0),
            "SCHEMENAME"=>0,
        );
    }
    function bindParamsToInputs()
    {
        return array(
          "dateRange"=>"dateRange",
         "DISTRIBUTORIDS" => "DISTRIBUTORIDS",
         "CATEGORYIDS" => "CATEGORYIDS",
         "AMSFYEAR" => "AMSFYEAR",
         "AMSFYEAREND" => "AMSFYEAREND",
         "SCHEMENAME",
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
        if($this->params["CATEGORYIDS"] != array(0) )
        {
        $query_params[":CAT_ID"] = $this->params["CATEGORYIDS"];
        }
        if($this->params["SCHEMENAME"] != 0)
        {
            $query_params[":SCHEME_ID"] = $this->params["SCHEMENAME"];
        }
        
        $this->src("mysql")
        ->query("Select FUND_SUBMISSION.FUND_NAME AS FUND_NAME,FUND_SUBMISSION.FIMM_FUND_CODE AS FIMM_FUND_CODE,FUND_PROFILE.FUND_NAME_SHORT AS FUND_NAME_SHORT,DISTRIBUTOR.DIST_NAME AS COMPANY,FUND_SUBMISSION.CIS_STRUCTURE AS CIS_STRUCTURE,FUND_PROFILE.FUND_MINIMUM_SALE_CHARGE AS FUND_MINIMUM_SALE_CHARGE,FUND_PROFILE.FUND_MAXIMUM_SALE_CHARGE AS FUND_MAXIMUM_SALE_CHARGE,FMS_FUNDCATEGORY.GROUP_ASSET AS GROUP_ASSET,FUND_SUBMISSION.FUND_GROUP AS FUND_GROUP,FMS_FUND_DOMICILE.FUND_DOMICILE_NAME AS FUND_DOMICILE_NAME,SETTING_GENERAL.SET_PARAM AS CURRENCY,FUND_SUMMARY.METHOD AS METHOD,FUND_SUBMISSION.ASSET_CLASS AS ASSET_CLASS,FUND_SUBMISSION.AMSF_YEAR AS AMSF_YEAR
        from annualFee_management.AUM_ENTRY AS AUM_ENTRY
        LEFT JOIN annualFee_management.FUND_SUBMISSION AS FUND_SUBMISSION
        ON AUM_ENTRY.FUND_SUBMISSION_ID = FUND_SUBMISSION.FUND_SUBMISSION_ID
        LEFT JOIN funds_management.FUND_PROFILE AS FUND_PROFILE
        ON FUND_PROFILE.FUND_PROFILE_ID = FUND_SUBMISSION.FMS_ID
        LEFT JOIN distributor_management.DISTRIBUTOR AS DISTRIBUTOR
        ON DISTRIBUTOR.DISTRIBUTOR_ID = FUND_SUBMISSION.DISTRIBUTOR_ID
        LEFT JOIN admin_management.FMS_FUNDCATEGORY AS FMS_FUNDCATEGORY
        ON FMS_FUNDCATEGORY.FMS_FUNDCATEGORY_ID = FUND_SUBMISSION.FUND_CATEGORY
        LEFT JOIN admin_management.FMS_FUND_DOMICILE AS FMS_FUND_DOMICILE
        ON FMS_FUND_DOMICILE.FUND_DOMICILE_ID = FUND_PROFILE.FUND_DOMICILE
        LEFT JOIN admin_management.SETTING_GENERAL AS SETTING_GENERAL
        ON SETTING_GENERAL.SETTING_GENERAL_ID = FUND_PROFILE.FUND_CURR_DENOMINATION
        LEFT JOIN annualFee_management.FUND_SUMMARY AS FUND_SUMMARY
        ON FUND_SUMMARY.DISTRIBUTOR_ID = FUND_SUBMISSION.DISTRIBUTOR_ID
        WHERE 1 = 1
        ".(($this->params["DISTRIBUTORIDS"]!=array(0))?"and FUND_SUBMISSION.DISTRIBUTOR_ID in ( :COM_ID)":"")."
        ".(($this->params["CATEGORYIDS"]!=array(0))?"and FUND_SUBMISSION.FUND_CATEGORY in ( :CAT_ID)":"")."
        ".(($this->params["SCHEMENAME"]!= 0)?"and FUND_SUBMISSION.CIS_STRUCTURE = :SCHEME_ID":"")."
        ".(( $this->params["AMSFYEAR"]?"and FUND_SUBMISSION.AMSF_YEAR >= :start":""))."
        ".(( $this->params["AMSFYEAREND"]?"and FUND_SUBMISSION.AMSF_YEAR <= :end":""))." 
         ")
        ->params($query_params)
        ->pipe($this->dataStore("AMSFAUMREPORT"));

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
