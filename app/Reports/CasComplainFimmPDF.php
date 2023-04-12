<?php
namespace App\Reports;
use \koolreport\processes\Join;

class CasComplainFimmPDF extends \koolreport\KoolReport
{
    use \koolreport\laravel\Friendship;
    use \koolreport\clients\FontAwesome;
    use \koolreport\amazing\Theme;
    use \koolreport\export\Exportable;
    use \koolreport\excel\ExcelExportable;
    use \koolreport\inputs\POSTBinding;
    use \koolreport\inputs\Bindable;
    function defaultParamValues()
    {
      $start_date = date('Y', strtotime('-4 years')); //date('Y-m-d', strtotime('first day of january this year'));
      $end_date =date('Y'); //date('Y-m-d', strtotime('last day of december this year'));
        return array(
            "dateRange"=>array(
                $start_date,
                $end_date
            ),
            "COMPLAINYEAR" => $start_date,
            "COMPLAINYEAREND" => $end_date,
        );
    }
    function bindParamsToInputs()
    {
        return array(
          "dateRange"=>"dateRange",
         "COMPLAINYEAR" => "COMPLAINYEAR",
         "COMPLAINYEAREND" => "COMPLAINYEAREND",
        );
    }
    function setup()
    {
      $query_params = array();

        if($this->params["COMPLAINYEAR"])
        {
        $query_params[":start"] = $this->params["COMPLAINYEAR"];
        }
        if($this->params["COMPLAINYEAREND"])
        {
        $query_params[":end"] = $this->params["COMPLAINYEAREND"];
        }
         $this->src("mysql")
        ->query("Select count(*) as total,YEAR(CA_APPROVAL.CREATE_TIMESTAMP) AS  year_of_complain
        from consultantAlert_management.CA_APPROVAL AS CA_APPROVAL
        where CA_APPROVAL.TS_ID IN(2)
        ".(( $this->params["COMPLAINYEAR"]?"and YEAR(CA_APPROVAL.CREATE_TIMESTAMP) >= :start":""))."
        ".(( $this->params["COMPLAINYEAREND"]?"and YEAR(CA_APPROVAL.CREATE_TIMESTAMP) <= :end":""))." 
        GROUP BY year_of_complain
       ")
      //  ->query("Select count(*) as total,YEAR(CONSULTANT.CREATE_TIMESTAMP) AS  year_of_complain
      //  from consultant_management.CONSULTANT AS CONSULTANT
      //  where CONSULTANT.CONSULTANT_STATUS IN(263,264,265,266,267,268,269)
      //  ".(( $this->params["COMPLAINYEAR"]?"and YEAR(CONSULTANT.CREATE_TIMESTAMP) >= :start":""))."
      //  ".(( $this->params["COMPLAINYEAREND"]?"and YEAR(CONSULTANT.CREATE_TIMESTAMP) <= :end":""))." 
      //  GROUP BY year_of_complain
      // ")
       ->params($query_params)
       ->saveTo($complain_source)
       ->pipe($this->dataStore("complain_source"));
       $this->src("mysql")
       ->query("Select count(*) as total1,YEAR(CA_RECORD_DETAILS.CREATE_TIMESTAMP) AS  year from consultantAlert_management.CA_RECORD_DETAILS AS CA_RECORD_DETAILS
       where CA_RECORD_DETAILS.TS_ID IN(3,5)
       ".(( $this->params["COMPLAINYEAR"]?"and YEAR(CA_RECORD_DETAILS.CREATE_TIMESTAMP) >= :start":""))."
       ".(( $this->params["COMPLAINYEAREND"]?"and YEAR(CA_RECORD_DETAILS.CREATE_TIMESTAMP) <= :end":""))." 
       GROUP BY year
      ")
      ->params($query_params)
      ->saveTo($close_source)
      ->pipe($this->dataStore("close_source"));
      $this->src("mysql")->query("Select count(*) as total2,YEAR(CA_RECORD_DETAILS.CREATE_TIMESTAMP) AS  year1 from consultantAlert_management.CA_RECORD_DETAILS AS CA_RECORD_DETAILS
      where CA_RECORD_DETAILS.TS_ID IN(2,4,8,15)
      ".(( $this->params["COMPLAINYEAR"]?"and YEAR(CA_RECORD_DETAILS.CREATE_TIMESTAMP) >= :start":""))."
      ".(( $this->params["COMPLAINYEAREND"]?"and YEAR(CA_RECORD_DETAILS.CREATE_TIMESTAMP) <= :end":""))." 
      GROUP BY year1
     ")
     ->params($query_params)
     ->saveTo($ongoing_source)
     ->pipe($this->dataStore("ongoing_source"));
      //$join = new Join($complain_source,$close_source,array("year_of_complain"=>"year"));
      //$join->pipe($this->dataStore("CASCOMPLAIN"));
    }
}
