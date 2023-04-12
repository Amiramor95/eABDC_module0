<?php
namespace App\Reports;
//use  \koolreport\KoolReport;

class CasSanctionedReportPDF extends \koolreport\KoolReport
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
          //  "DISTRIBUTORID"=>2,
             "DISTRIBUTORIDS" => array(0),
             "COMPLAINYEAR" => $start_date,
             "COMPLAINYEAREND" => $end_date,
        );
    }
    function bindParamsToInputs()
    {
        return array(
            "DISTRIBUTORIDS" => "DISTRIBUTORIDS",
            "COMPLAINYEAR" => "COMPLAINYEAR",
            "COMPLAINYEAREND" => "COMPLAINYEAREND",
          //  "dateRange",
        );
    }
    function setup()
    {
        $query_params = array();
        if($this->params["DISTRIBUTORIDS"] != array(0) )
        {
            $query_params[":DISTRIBUTOR_ID"] = $this->params["DISTRIBUTORIDS"];
        }
        if($this->params["COMPLAINYEAR"])
        {
        $query_params[":start"] = $this->params["COMPLAINYEAR"];
        }
        if($this->params["COMPLAINYEAREND"])
        {
        $query_params[":end"] = $this->params["COMPLAINYEAREND"];
        }
       $this->src("mysql")
       ->query("Select count(*) as total,YEAR(CONSULTANT_LICENSE.CREATED_AT) AS  year,DISTRIBUTOR.DIST_NAME AS DIST_NAME,CONSULTANT_LICENSE.DISTRIBUTOR_ID AS DISTRIBUTOR_ID
       from distributor_management.DISTRIBUTOR AS DISTRIBUTOR
       JOIN consultant_management.CONSULTANT_LICENSE AS CONSULTANT_LICENSE
           ON CONSULTANT_LICENSE.DISTRIBUTOR_ID = DISTRIBUTOR.DISTRIBUTOR_ID
       where CONSULTANT_LICENSE.CONSULTANT_TYPE_ID IN(1,2)
       ".(( $this->params["COMPLAINYEAR"]?"and YEAR(CONSULTANT_LICENSE.CREATED_AT) >= :start":""))."
       ".(( $this->params["COMPLAINYEAREND"]?"and YEAR(CONSULTANT_LICENSE.CREATED_AT) <= :end":""))." 
       ".(($this->params["DISTRIBUTORIDS"]!=array(0))?"and DISTRIBUTOR.DISTRIBUTOR_ID in ( :DISTRIBUTOR_ID)":"")."
       group by DISTRIBUTOR_ID,year
       ")
       ->params($query_params)
      ->saveTo($SANCTIONED)
      ->pipe($this->dataStore("SANCTIONED"));

      $this->src("mysql")
      ->query("Select DISTRIBUTOR.DIST_NAME AS DIST_NAME,DISTRIBUTOR.DISTRIBUTOR_ID AS DISTRIBUTORID
       from distributor_management.DISTRIBUTOR AS DISTRIBUTOR order by DISTRIBUTOR_ID asc")
     ->pipe($this->dataStore("CASCOMPANY"));
    }
}
