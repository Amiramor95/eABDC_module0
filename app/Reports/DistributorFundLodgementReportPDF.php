<?php
namespace App\Reports;
class DistributorFundLodgementReportPDF extends \koolreport\KoolReport
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
           $start_date = date('Y-m-d', strtotime('first day of january last year'));
           $end_date = date('Y-m-d', strtotime('last day of december this year'));
        return array(
            "dateRange"=>array(
                $start_date,
                $end_date
            ),
            "DISTRIBUTORIDS" => array(0),
            "DISTIDS" => array(0),
            "COMPANYIDS" => array(0),
            "FUNDTYPE" => 2,
            "FUND_NAME" => 0,
        );
    }
    function bindParamsToInputs()
    {
        return array(
          "dateRange"=>"dateRange",
         "DISTRIBUTORIDS" => "DISTRIBUTORIDS",
         "COMPANYIDS" => "COMPANYIDS",
         "DISTIDS" => "DISTIDS",
         "FUNDTYPE",
         "FUND_NAME",
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
        if($this->params["COMPANYIDS"] != array(0) )
        {
        $query_params[":COMPANY_ID"] = $this->params["COMPANYIDS"];
        }
        if($this->params["DISTIDS"] != array(0) )
        {
        $query_params[":TYPE_ID"] = $this->params["DISTIDS"];
        }
        if($this->params["FUNDTYPE"] != 2)
        {
            $query_params[":FUND_TYPE"] = $this->params["FUNDTYPE"];
        }
        if($this->params["FUND_NAME"] != 0)
        {
            $query_params[":FUND_NAME"] = $this->params["FUND_NAME"];
        }
        $this->src("mysql")
        ->query("Select DISTRIBUTOR.DIST_NAME AS DIST_NAME,FUND_PROFILE.FUND_NON_MEMBER AS FUND_NON_MEMBER,FUNDCOMPANY.DIST_NAME AS COMPANY_NAME,FUND_PROFILE.FUND_NAME AS FUND_NAME,FUND_LODGEMENT.LODGE_DATE AS LODGE_DATE,FUND_LODGEMENT.UPDATE_TIMESTAMP AS UPDATE_TIMESTAMP,DISTRIBUTOR_TYPE.DIST_TYPE AS DIST_TYPE,DISTRIBUTOR.DISTRIBUTOR_ID AS DISTRIBUTOR_ID
        from funds_management.FUND_LODGEMENT AS FUND_LODGEMENT
        LEFT JOIN funds_management.FUND_PROFILE AS FUND_PROFILE
        ON FUND_PROFILE.FUND_PROFILE_ID = FUND_LODGEMENT.FUND_PROFILE_ID
        LEFT JOIN distributor_management.DISTRIBUTOR AS DISTRIBUTOR
        ON DISTRIBUTOR.DISTRIBUTOR_ID = FUND_LODGEMENT.DIST_ID
        LEFT JOIN distributor_management.DISTRIBUTOR AS FUNDCOMPANY
        ON FUNDCOMPANY.DISTRIBUTOR_ID = FUND_PROFILE.DIST_ID
        LEFT JOIN distributor_management.DISTRIBUTOR_TYPE AS DISTRIBUTOR_TYPE
        ON DISTRIBUTOR_TYPE.DIST_ID = FUND_LODGEMENT.DIST_ID
        WHERE 1 = 1
        ".(($this->params["DISTRIBUTORIDS"]!=array(0))?"and FUND_LODGEMENT.DIST_ID in ( :DISTRIBUTOR_ID)":"")."
        ".(($this->params["COMPANYIDS"]!=array(0))?"and FUND_PROFILE.DIST_ID in ( :COMPANY_ID)":"")."
        ".(($this->params["DISTIDS"]!=array(0))?"and DISTRIBUTOR_TYPE.DIST_TYPE in ( :TYPE_ID)":"")."
        ".(($this->params["FUNDTYPE"]!= 2)?"and  FUND_PROFILE.FUND_NON_MEMBER = :FUND_TYPE":"")."
        ".(($this->params["FUND_NAME"]!= 0)?"and  FUND_LODGEMENT.FUND_PROFILE_ID = :FUND_NAME":"")."
        ".(( $this->params["dateRange"][0]?"and FUND_LODGEMENT.LODGE_DATE >= :start":""))."
        ".(( $this->params["dateRange"][1]?"and FUND_LODGEMENT.LODGE_DATE <= :end":""))." 
       GROUP BY FUND_LODGEMENT.FUND_LODG_ID  order by FUND_LODGEMENT.LODGE_DATE desc")
        ->params($query_params)
        ->pipe($this->dataStore("DISTRIBUTORFUNDLODGEMENTREPORT"));

        $this->src("mysql")
        ->query("select DISTRIBUTOR.DISTRIBUTOR_ID AS DISTRIBUTORID,DISTRIBUTOR.DIST_NAME AS DIST_NAME
        from distributor_management.DISTRIBUTOR AS DISTRIBUTOR
        ")
        ->pipe($this->dataStore("DISTRIBUTORLIST"));

        $this->src("mysql")
        ->query("select DISTRIBUTOR_TYPE.DIST_ID AS DIST_ID,DISTRIBUTORTYPE.DIST_TYPE_NAME AS DIST_TYPE_NAME,DISTRIBUTORTYPE.DISTRIBUTOR_TYPE_ID AS DISTRIBUTOR_TYPE_ID,CONSULTANT_TYPE.TYPE_SCHEME AS TYPE_SCHEME
        from distributor_management.DISTRIBUTOR_TYPE AS DISTRIBUTOR_TYPE
        LEFT JOIN admin_management.DISTRIBUTOR_TYPE AS DISTRIBUTORTYPE
        ON DISTRIBUTORTYPE.DISTRIBUTOR_TYPE_ID = DISTRIBUTOR_TYPE.DIST_TYPE
        LEFT JOIN admin_management.CONSULTANT_TYPE AS CONSULTANT_TYPE
        ON CONSULTANT_TYPE.CONSULTANT_TYPE_ID = DISTRIBUTORTYPE.SCHEME
        ")
        ->pipe($this->dataStore("DISTRIBUTORTYPE"));
        $this->src("mysql")
        ->query("select DISTRIBUTORTYPE.DISTRIBUTOR_TYPE_ID AS DISTID,DISTRIBUTORTYPE.DIST_TYPE_NAME AS DIST_TYPE_NAME
        from admin_management.DISTRIBUTOR_TYPE AS DISTRIBUTORTYPE
        ")
        ->pipe($this->dataStore("DISTRIBUTORTYPELIST"));

        $this->src("mysql")
        ->query("select DISTRIBUTOR.DISTRIBUTOR_ID AS COMPANYID,DISTRIBUTOR.DIST_NAME AS COM_NAME
        from distributor_management.DISTRIBUTOR AS DISTRIBUTOR
        ")
        ->pipe($this->dataStore("FUNDCOMPANYLIST"));
        $this->src("mysql")
        ->query("select FUND_PROFILE.FUND_NAME AS FUND_NAME,FUND_PROFILE.FUND_PROFILE_ID AS FUND_PROFILE_ID
        from funds_management.FUND_PROFILE AS FUND_PROFILE
        GROUP BY FUND_PROFILE.FUND_NAME")
        ->pipe($this->dataStore("FUNDNAMELIST"));

  }
}
