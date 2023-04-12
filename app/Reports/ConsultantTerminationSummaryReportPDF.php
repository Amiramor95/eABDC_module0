<?php
namespace App\Reports;
class ConsultantTerminationSummaryReportPDF extends \koolreport\KoolReport
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
         //  $start_date = "";//date('Y-m-d', strtotime('first day of this month'));
          // $end_date = "";//date('Y-m-d', strtotime('last day of this month'));
        return array(
            // "dateRange"=>array(
            //     $start_date,
            //     $end_date
            // ),
            "DISTRIBUTORIDS" => array(0),
        );
    }
    function bindParamsToInputs()
    {
        return array(
         // "dateRange"=>"dateRange",
         "DISTRIBUTORIDS" => "DISTRIBUTORIDS",
        );
    }
    function setup()
    {
      $query_params = array();
      $query_params1 = array();
      $query_params2 = array();
    //   if(isset($this->params["dateRange"][0]))
    //   {
    //       $query_params[":start"] = $this->params["dateRange"][0];
    //   }
    //   if(isset($this->params["dateRange"][1]))
    //   {
    //       $query_params[":end"] = $this->params["dateRange"][1];
    //   }
    if($this->params["DISTRIBUTORIDS"] != array(0) )
    {
        $query_params[":DISTRIBUTOR_ID"] = $this->params["DISTRIBUTORIDS"];
    }
        $this->src("mysql")
        ->query("Select DISTRIBUTOR.DIST_NAME AS DIST_NAME,DISTRIBUTOR.DISTRIBUTOR_ID AS DISTRIBUTOR_ID
        from distributor_management.DISTRIBUTOR AS DISTRIBUTOR
        WHERE 1 = 1
        ".(($this->params["DISTRIBUTORIDS"]!=array(0))?"and DISTRIBUTOR.DISTRIBUTOR_ID in ( :DISTRIBUTOR_ID)":"")."
        order by DIST_NAME asc")
        ->params($query_params)
        ->pipe($this->dataStore("CONSULTANTTERMINATIONSUMMREPORT"));
        // For Resigned
        $this->src("mysql")
        ->query("Select CONSULTANT_LICENSE.DISTRIBUTOR_ID AS DID,COUNT(*) AS RESIGNEDTOTAL
        from consultant_management.CONSULTANT_LICENSE AS CONSULTANT_LICENSE
        WHERE CONSULTANT_LICENSE.CONSULTANT_STATUS = 304 AND CONSULTANT_LICENSE.CONSULTANT_TYPE_ID = 1
        GROUP BY CONSULTANT_LICENSE.DISTRIBUTOR_ID
         ")
        ->pipe($this->dataStore("CONSULTANTUTSRESIGNEDREPORT"));

        $this->src("mysql")
        ->query("Select CONSULTANT_LICENSE.DISTRIBUTOR_ID AS DID,COUNT(*) AS RESIGNEDTOTAL
        from consultant_management.CONSULTANT_LICENSE AS CONSULTANT_LICENSE
        WHERE CONSULTANT_LICENSE.CONSULTANT_STATUS = 304 AND CONSULTANT_LICENSE.CONSULTANT_TYPE_ID = 2
        GROUP BY CONSULTANT_LICENSE.DISTRIBUTOR_ID
         ")
        ->pipe($this->dataStore("CONSULTANTPRSRESIGNEDREPORT"));
        // For Revoked
        $this->src("mysql")
        ->query("Select CONSULTANT_LICENSE.DISTRIBUTOR_ID AS DID,COUNT(*) AS REVOKEDTOTAL
        from consultant_management.CONSULTANT_LICENSE AS CONSULTANT_LICENSE
        WHERE CONSULTANT_LICENSE.CONSULTANT_STATUS = 799 AND CONSULTANT_LICENSE.CONSULTANT_TYPE_ID = 1
        GROUP BY CONSULTANT_LICENSE.DISTRIBUTOR_ID
         ")
        ->pipe($this->dataStore("CONSULTANTUTSREVOKEDREPORT"));

        $this->src("mysql")
        ->query("Select CONSULTANT_LICENSE.DISTRIBUTOR_ID AS DID,COUNT(*) AS REVOKEDTOTAL
        from consultant_management.CONSULTANT_LICENSE AS CONSULTANT_LICENSE
        WHERE CONSULTANT_LICENSE.CONSULTANT_STATUS = 799 AND CONSULTANT_LICENSE.CONSULTANT_TYPE_ID = 2
        GROUP BY CONSULTANT_LICENSE.DISTRIBUTOR_ID
         ")
        ->pipe($this->dataStore("CONSULTANTPRSREVOKEDREPORT"));

          // For Termination
          $this->src("mysql")
          ->query("Select CONSULTANT_LICENSE.DISTRIBUTOR_ID AS DID,COUNT(*) AS TERMINATIONTOTAL
          from consultant_management.CONSULTANT_LICENSE AS CONSULTANT_LICENSE
          WHERE CONSULTANT_LICENSE.CONSULTANT_STATUS IN (296,297,298,299,300,301,302,303) AND CONSULTANT_LICENSE.CONSULTANT_TYPE_ID = 1
          GROUP BY CONSULTANT_LICENSE.DISTRIBUTOR_ID
           ")
          ->pipe($this->dataStore("CONSULTANTUTSTERMINATIONREPORT"));
  
          $this->src("mysql")
          ->query("Select CONSULTANT_LICENSE.DISTRIBUTOR_ID AS DID,COUNT(*) AS TERMINATIONTOTAL
          from consultant_management.CONSULTANT_LICENSE AS CONSULTANT_LICENSE
          WHERE CONSULTANT_LICENSE.CONSULTANT_STATUS IN (296,297,298,299,300,301,302,303) AND CONSULTANT_LICENSE.CONSULTANT_TYPE_ID = 2
          GROUP BY CONSULTANT_LICENSE.DISTRIBUTOR_ID
           ")
          ->pipe($this->dataStore("CONSULTANTPRSTERMINATIONREPORT"));
  

        $this->src("mysql")
        ->query("select DISTRIBUTOR.DISTRIBUTOR_ID AS DISTRIBUTORID,DISTRIBUTOR.DIST_NAME AS DIST_NAME
        from distributor_management.DISTRIBUTOR AS DISTRIBUTOR
        ")
        ->pipe($this->dataStore("CONSULTANTDISTRIBUTOR"));

  }
}
