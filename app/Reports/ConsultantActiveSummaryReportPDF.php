<?php
namespace App\Reports;
class ConsultantActiveSummaryReportPDF extends \koolreport\KoolReport
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
           //$start_date = "";//date('Y-m-d', strtotime('first day of this month'));
          // $end_date = "";//date('Y-m-d', strtotime('last day of this month'));
        return array(
            // "dateRange"=>array(
            //   /  $start_date,
            //     $end_date
            // ),
          //  "SCHEMEID" => 0,
          "DISTRIBUTORIDS" => array(0),

        );
    }
    function bindParamsToInputs()
    {
        return array(
         // "dateRange"=>"dateRange",
           "DISTRIBUTORIDS" => "DISTRIBUTORIDS",
          // "SCHEMEID",
           // "TERMINATIONTYPEID",
            //"SUBID",
        );
    }
    function setup()
    {
      $query_params = array();
      if($this->params["DISTRIBUTORIDS"] != array(0) )
      {
          $query_params[":DISTRIBUTOR_ID"] = $this->params["DISTRIBUTORIDS"];
      }
    //   if($this->params["SCHEMEID"] != 0)
    //   {
    //       $query_params[":SCHEME_ID"] = $this->params["SCHEMEID"];
    //   }
     
    //   if(isset($this->params["dateRange"][0]))
    //   {
    //       $query_params[":start"] = $this->params["dateRange"][0];
    //   }
    //   if(isset($this->params["dateRange"][1]))
    //   {
    //       $query_params[":end"] = $this->params["dateRange"][1];
    //   }

        $this->src("mysql")
        ->query("select  CONSULTANT_LICENSE.CONSULTANT_ID AS CONSULTANT_ID,CONSULTANT_LICENSE.DISTRIBUTOR_ID AS DISTRIBUTOR_ID,count(CONSULTANT_LICENSE.CONSULTANT_ID) as c,count(CONSULTANT_LICENSE.DISTRIBUTOR_ID) as c1
        from consultant_management.CONSULTANT_LICENSE AS CONSULTANT_LICENSE
        WHERE CONSULTANT_LICENSE.CONSULTANT_STATUS = 295
        group by CONSULTANT_LICENSE.CONSULTANT_ID, DISTRIBUTOR_ID having c =2 and c1=2
        ")
        ->pipe($this->dataStore("CONSULTANTDUALLICENSE"));
        $this->src("mysql")
        ->query("select  CONSULTANT_LICENSE.CONSULTANT_ID AS CONSULTANT_ID,CONSULTANT_LICENSE.DISTRIBUTOR_ID AS DISTRIBUTOR_ID,count(CONSULTANT_LICENSE.CONSULTANT_ID) as c,count(CONSULTANT_LICENSE.DISTRIBUTOR_ID) as c1,CONSULTANT_LICENSE.CONSULTANT_TYPE_ID AS CONSULTANT_TYPE_ID 
        from consultant_management.CONSULTANT_LICENSE AS CONSULTANT_LICENSE
        WHERE CONSULTANT_LICENSE.CONSULTANT_STATUS = 295
        group by CONSULTANT_LICENSE.CONSULTANT_ID, DISTRIBUTOR_ID having c =1 and c1=1
        ")
        ->pipe($this->dataStore("CONSULTANTSINGLEUTSLICENSE"));

        $this->src("mysql")
        ->query("select DISTRIBUTOR_TYPE.DIST_ID AS DIST_ID,DISTRIBUTORTYPE.DIST_TYPE_NAME AS DIST_TYPE_NAME
        from distributor_management.DISTRIBUTOR_TYPE AS DISTRIBUTOR_TYPE
        LEFT JOIN admin_management.DISTRIBUTOR_TYPE AS DISTRIBUTORTYPE
        ON DISTRIBUTORTYPE.DISTRIBUTOR_TYPE_ID = DISTRIBUTOR_TYPE.DIST_TYPE
        ")
        ->pipe($this->dataStore("DISTRIBUTORTYPE"));

        $this->src("mysql")
        ->query("select DISTRIBUTOR.DISTRIBUTOR_ID AS DISTRIBUTORID,DISTRIBUTOR.DIST_NAME AS DIST_NAME
        from distributor_management.DISTRIBUTOR AS DISTRIBUTOR
        where 1 = 1
        ".(($this->params["DISTRIBUTORIDS"]!=array(0))?"and DISTRIBUTOR.DISTRIBUTOR_ID in ( :DISTRIBUTOR_ID)":"")."
        ")
        ->params($query_params)
        ->pipe($this->dataStore("CONSULTANTSUMMARYDISTRIBUTOR"));

       


        $this->src("mysql")
        ->query("select DISTRIBUTOR.DISTRIBUTOR_ID AS DISTRIBUTORID,DISTRIBUTOR.DIST_NAME AS DIST_NAME
        from distributor_management.DISTRIBUTOR AS DISTRIBUTOR
        ")
        ->pipe($this->dataStore("CONSULTANTDISTRIBUTOR"));
  }
}
