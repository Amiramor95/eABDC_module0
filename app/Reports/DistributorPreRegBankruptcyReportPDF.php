<?php
namespace App\Reports;
class DistributorPreRegBankruptcyReportPDF extends \koolreport\KoolReport
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
           $start_date = date('Y-m-d', strtotime('first day of january this year'));
           $end_date = date('Y-m-d', strtotime('last day of december this year'));
        return array(
            "dateRange"=>array(
                $start_date,
                $end_date
            ),
            "DISTRIBUTORIDS" => array(0),
            "BANKRUPTCYSTATUS" => 2,
        );
    }
    function bindParamsToInputs()
    {
        return array(
          "dateRange"=>"dateRange",
         "DISTRIBUTORIDS" => "DISTRIBUTORIDS",
         "BANKRUPTCYSTATUS",
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
        if($this->params["BANKRUPTCYSTATUS"] != 2)
        {
            $query_params[":STATUS_ID"] = $this->params["BANKRUPTCYSTATUS"];
        }
        $this->src("mysql")
        ->query("Select CONSULTANT.CONSULTANT_NAME AS CONSULTANT_NAME,CONSULTANT.CONSULTANT_NRIC AS CONSULTANT_NRIC,DISTRIBUTOR.DIST_NAME AS DIST_NAME,BANKRUPTCY.BANKRUPTCY_DATE AS BANKRUPTCY_DATE,BANKRUPTCY.BANKRUPTCY_STATUS AS BANKRUPTCY_STATUS
        from consultant_management.BANKRUPTCY AS BANKRUPTCY
        LEFT JOIN distributor_management.DISTRIBUTOR AS DISTRIBUTOR
        ON DISTRIBUTOR.DISTRIBUTOR_ID = BANKRUPTCY.DISTRIBUTOR_ID
        LEFT JOIN consultant_management.CONSULTANT AS CONSULTANT
        ON CONSULTANT.CONSULTANT_ID = BANKRUPTCY.CONSULTANT_ID
        WHERE 1 = 1
        ".(($this->params["DISTRIBUTORIDS"]!=array(0))?"and DISTRIBUTOR.DISTRIBUTOR_ID in ( :DISTRIBUTOR_ID)":"")."
        ".(($this->params["BANKRUPTCYSTATUS"]!= 2)?"and  BANKRUPTCY.BANKRUPTCY_STATUS = :STATUS_ID":"")."
        ".(( $this->params["dateRange"][0]?"and BANKRUPTCY.BANKRUPTCY_DATE >= :start":""))."
        ".(( $this->params["dateRange"][1]?"and BANKRUPTCY.BANKRUPTCY_DATE <= :end":""))." 
        order by BANKRUPTCY.BANKRUPTCY_DATE desc")
        ->params($query_params)
        ->pipe($this->dataStore("DISTRIBUTORPREREGBANKRUPTCYREPORT"));

        $this->src("mysql")
        ->query("select DISTRIBUTOR.DISTRIBUTOR_ID AS DISTRIBUTORID,DISTRIBUTOR.DIST_NAME AS DIST_NAME
        from distributor_management.DISTRIBUTOR AS DISTRIBUTOR
        ")
        ->pipe($this->dataStore("DISTRIBUTORLIST"));

  }
}
