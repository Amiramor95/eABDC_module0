<?php
namespace App\Reports;
class FundDataNewReportPDF extends \koolreport\KoolReport
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
           $start_date = ""; //date('Y-m-d', strtotime('first day of january last year'));
           $end_date = "";//date('Y-m-d', strtotime('last day of december this year'));
        return array(
            "dateRange"=>array(
                $start_date,
                $end_date
            ),
            "DISTRIBUTORIDS" => array(0),
            "CATEGORYIDS" => array(0),
            "SCHEMEIDS" => array(0),
            "SHARIAH" => array(1,2),
        );
    }
    function bindParamsToInputs()
    {
        return array(
          "dateRange"=>"dateRange",
         "DISTRIBUTORIDS" => "DISTRIBUTORIDS",
         "CATEGORYIDS" => "CATEGORYIDS",
         "SCHEMEIDS" => "SCHEMEIDS",
         "SHARIAH" => "SHARIAH",
        );
    }
    function setup()
    {
      $query_params = array();
      $query_params1 = array();
      $query_params2 = array();
        if(isset($this->params["dateRange"][0]))
        {
        $query_params[":start"] = $this->params["dateRange"][0];
        }
        if(isset($this->params["dateRange"][1]))
        {
        $query_params[":end"] = $this->params["dateRange"][1];
        }
        if($this->params["DISTRIBUTORIDS"] != array(0) )
        {
        $query_params[":DISTRIBUTOR_ID"] = $this->params["DISTRIBUTORIDS"];
        }
        if($this->params["CATEGORYIDS"] != array(0) )
        {
        $query_params[":CATEGORY_ID"] = $this->params["CATEGORYIDS"];
        }
        if($this->params["SCHEMEIDS"] != array(0) )
        {
        $query_params[":SCHEME_ID"] = $this->params["SCHEMEIDS"];
        }
        if($this->params["SHARIAH"] != array(0) )
        {
            $query_params[":SHARIAH"] = $this->params["SHARIAH"];
        }
        $this->src("mysql")
        ->query("Select DISTRIBUTOR.DIST_NAME AS DIST_NAME,FUND_PROFILE.FUND_NAME AS FUND_NAME,FUND_PROFILE.FUND_CODE_FIMM AS FUND_CODE_FIMM,FUND_PROFILE.FUND_DATE_LAUNCH AS LAUNCHDATE,FMS_FUNDTYPE.FUND_NAME AS FUND_TYPE,FMS_FUNDCATEGORY.GROUP_ASSET AS FUNDCATEGORY,FUND_PROFILE.FUND_STATUS_SRI_ESG AS FUNDSRI,FMS_SCHEME_STRUCTURE.FMS_SCHEME_NAME AS FUND_SCHEME,FUND_PROFILE.FUND_UNIT_STRUCTURE AS FUND_UNIT_STRUCTURE,FUND_PROFILE.FUND_INVESTMENT_FOCUS AS FUND_INVESTMENT_FOCUS,FUND_PROFILE.FUND_FEEDER AS FUND_FEEDER,FUND_PROFILE.FUND_FOF AS FUND_FOF,DISTRIBUTOR.DISTRIBUTOR_ID AS DISTRIBUTOR_ID
        from funds_management.FUND_PROFILE AS FUND_PROFILE
        LEFT JOIN distributor_management.DISTRIBUTOR AS DISTRIBUTOR
        ON DISTRIBUTOR.DISTRIBUTOR_ID = FUND_PROFILE.DIST_ID
        LEFT JOIN admin_management.FMS_FUNDTYPE AS FMS_FUNDTYPE
        ON FMS_FUNDTYPE.FMS_FUNDTYPE_ID = FUND_PROFILE.FUND_TYPE
        LEFT JOIN admin_management.FMS_FUNDCATEGORY AS FMS_FUNDCATEGORY
        ON FMS_FUNDCATEGORY.FMS_FUNDCATEGORY_ID = FUND_PROFILE.FUND_CATEGORY
        LEFT JOIN admin_management.FMS_SCHEME_STRUCTURE AS FMS_SCHEME_STRUCTURE
        ON FMS_SCHEME_STRUCTURE.FMS_SCHEME_ID = FUND_PROFILE.FUND_SCHEME
        WHERE FUND_PROFILE.FUND_STATUS_FUND = 2
        ".(($this->params["DISTRIBUTORIDS"]!=array(0))?"and FUND_PROFILE.DIST_ID in ( :DISTRIBUTOR_ID)":"")."
        ".(($this->params["CATEGORYIDS"]!=array(0))?"and FUND_PROFILE.FUND_CATEGORY in ( :CATEGORY_ID)":"")."
        ".(($this->params["SCHEMEIDS"]!=array(0))?"and FUND_PROFILE.FUND_SCHEME in ( :SCHEME_ID)":"")."
        ".(($this->params["SHARIAH"]!=array(0))?"and FUND_PROFILE.FUND_STATUS_SRI_ESG in ( :SHARIAH)":"")."
        ".(( $this->params["dateRange"][0]?"and FUND_PROFILE.FUND_DATE_LAUNCH >= :start":""))."
        ".(( $this->params["dateRange"][1]?"and FUND_PROFILE.FUND_DATE_LAUNCH <= :end":""))." 
         order by FUND_PROFILE.CREATE_TIMESTAMP desc")
        ->params($query_params)
        ->pipe($this->dataStore("FUNDDATANEWREPORT"));

        $this->src("mysql")
        ->query("select DISTRIBUTOR.DISTRIBUTOR_ID AS DISTRIBUTORID,DISTRIBUTOR.DIST_NAME AS DIST_NAME
        from distributor_management.DISTRIBUTOR AS DISTRIBUTOR
        ")
        ->pipe($this->dataStore("DISTRIBUTORLIST"));
        $this->src("mysql")
        ->query("select FMS_FUNDCATEGORY.FMS_FUNDCATEGORY_ID AS CATEGORYID,FMS_FUNDCATEGORY.GROUP_ASSET AS GROUP_ASSET
        from admin_management.FMS_FUNDCATEGORY AS FMS_FUNDCATEGORY
        ")
        ->pipe($this->dataStore("FUNDCATEGORYLIST"));

        $this->src("mysql")
        ->query("select FMS_SCHEME_STRUCTURE.FMS_SCHEME_ID AS SCHEMEID,FMS_SCHEME_STRUCTURE.FMS_SCHEME_NAME AS FMS_SCHEME_NAME
        from admin_management.FMS_SCHEME_STRUCTURE AS FMS_SCHEME_STRUCTURE
        ")
        ->pipe($this->dataStore("FUNDSCHEMELIST")); 

  }
}
