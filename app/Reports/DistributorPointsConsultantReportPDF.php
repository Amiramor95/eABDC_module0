<?php
namespace App\Reports;
class DistributorPointsConsultantReportPDF extends \koolreport\KoolReport
{
    use \koolreport\laravel\Friendship;
    use \koolreport\clients\FontAwesome;
    use \koolreport\amazing\Theme;
    use \koolreport\export\Exportable;
    use \koolreport\excel\ExcelExportable;
    function setup()
    {
        $this->src("mysql")
        ->query("Select DISTRIBUTOR.DIST_NAME AS DIST_NAME,DISTRIBUTOR.DISTRIBUTOR_ID AS DISTRIBUTOR_ID,DISTRIBUTION_POINT.DIST_POINT_NAME AS DIST_POINT_NAME,DISTRIBUTION_POINT.DIST_POINT_CODE AS DIST_POINT_CODE,CONCAT_WS(', ',DISTRIBUTION_POINT.DIST_ADDR_1, DISTRIBUTION_POINT.DIST_ADDR_2,DISTRIBUTION_POINT.DIST_ADDR_3) AS ADDRESS
        from distributor_management.DISTRIBUTOR AS DISTRIBUTOR
        JOIN distributor_management.DISTRIBUTION_POINT AS DISTRIBUTION_POINT
        ON DISTRIBUTION_POINT.DISTRIBUTOR_ID = DISTRIBUTOR.DISTRIBUTOR_ID
        where DISTRIBUTION_POINT.DIST_POINT_ID = :POINT_ID")
         ->params(array(
            ":POINT_ID"=>$this->params["POINTID"]
        ))
       ->pipe($this->dataStore("DISTRIBUTORPOINTBYREPORT"));

       $this->src("mysql")
       ->query("select CONSULTANT_LICENSE.DIST_POINT_ID AS DIST_POINT_ID,CONSULTANT_LICENSE. 	DISTRIBUTOR_ID AS DISTRIBUTOR_ID,CONSULTANT.CONSULTANT_NAME AS CONSULTANT_NAME,CONSULTANT.CONSULTANT_FIMM_NO AS CONSULTANT_FIMM_NO,CONSULTANT.CONSULTANT_NRIC AS CONSULTANT_NRIC,CONSULTANT_TYPE.TYPE_NAME AS TYPE_NAME
       from consultant_management.CONSULTANT AS CONSULTANT
       JOIN consultant_management.CONSULTANT_LICENSE AS CONSULTANT_LICENSE
       ON CONSULTANT_LICENSE.CONSULTANT_ID = CONSULTANT.CONSULTANT_ID
       LEFT JOIN admin_management.CONSULTANT_TYPE AS CONSULTANT_TYPE
       ON CONSULTANT_TYPE.CONSULTANT_TYPE_ID = CONSULTANT_LICENSE.CONSULTANT_TYPE_ID
       where CONSULTANT_LICENSE.DIST_POINT_ID = :POINT_ID
       ")
        ->params(array(
           ":POINT_ID"=>$this->params["POINTID"]
       ))
      ->pipe($this->dataStore("CONSULTANTPOINTREPORTDETAIL"));
    }
}
