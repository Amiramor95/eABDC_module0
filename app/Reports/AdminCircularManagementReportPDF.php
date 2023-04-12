<?php
namespace App\Reports;
class AdminCircularManagementReportPDF extends \koolreport\KoolReport
{
    use \koolreport\laravel\Friendship;
    use \koolreport\clients\FontAwesome;
    use \koolreport\amazing\Theme;
    use \koolreport\export\Exportable;
    use \koolreport\excel\ExcelExportable;
    use \koolreport\inputs\Bindable;
    use \koolreport\inputs\POSTBinding;
    function defaultParamValues()
    {
        $start_date = date('Y-m-d', strtotime('first day of January'));
        $end_date = date('Y-m-d', strtotime('last day of December'));
        return array(
            "dateRange"=>array(
                $start_date,
                $end_date
            ),
            "MANAGEDEPARTMENTID"=>0,
           // "CATEGORYID"=>0,
        );
    }
    function bindParamsToInputs()
    {
        return array(
            "dateRange"=>"dateRange",
           "MANAGEDEPARTMENTID",
          // "CATEGORYID",
        );
    }


    function setup()
    {
        //var_dump($this->params); echo "<br>";
        $this->src("mysql")
        ->query("Select MANAGE_DEPARTMENT.DPMT_NAME AS DPMT_NAME,MANAGE_DEPARTMENT.MANAGE_DEPARTMENT_ID AS MANAGEDEPARTMENTID
         from admin_management.MANAGE_DEPARTMENT AS MANAGE_DEPARTMENT")
        ->pipe($this->dataStore("DEPARTMENTLIST"));

        $this->src("mysql")
        ->query("Select DISTRIBUTOR_TYPE.DIST_TYPE_NAME AS DIST_TYPE_NAME,DISTRIBUTOR_TYPE.DISTRIBUTOR_TYPE_ID AS DISTRIBUTOR_TYPE_ID
         from admin_management.DISTRIBUTOR_TYPE AS DISTRIBUTOR_TYPE")
        ->pipe($this->dataStore("DISTRIBUTORTYPELIST"));


        $query_params = array();
        if($this->params["MANAGEDEPARTMENTID"] != 0)
        {
            $query_params[":DEPARTMENT_ID"] = $this->params["MANAGEDEPARTMENTID"];
        }
        if(isset($this->params["dateRange"][0]))
        {
            $query_params[":start"] = $this->params["dateRange"][0];
        }
        if(isset($this->params["dateRange"][1]))
        {
            $query_params[":end"] = $this->params["dateRange"][1];
        }

       $this->src("mysql")
       ->query("Select CIRCULAR_EVENT.EVENT_TITLE AS EVENT_TITLE,CIRCULAR_EVENT.CREATE_TIMESTAMP AS STARTDATE,CIRCULAR_EVENT.EVENT_DATE_END AS ENDDATE,YEAR(CIRCULAR_EVENT.EVENT_DATE_START) AS YEAR,MONTH(CIRCULAR_EVENT.EVENT_DATE_START) AS MONTH,MANAGE_DEPARTMENT.DPMT_NAME AS DNAME, CIRCULAR_EVENT.EVENT_DISTRIBUTOR_AUDIENCE AS CATEGORY,USER.USER_NAME AS CUSER,CIRCULAR_EVENT.PUBLISH_STATUS AS STATUS
        from admin_management.CIRCULAR_EVENT AS CIRCULAR_EVENT
        LEFT JOIN admin_management.MANAGE_DEPARTMENT AS MANAGE_DEPARTMENT ON MANAGE_DEPARTMENT.MANAGE_DEPARTMENT_ID = CIRCULAR_EVENT.DEPARTMENT
        LEFT JOIN admin_management.USER AS USER ON USER.USER_ID = CIRCULAR_EVENT.CREATE_BY
           WHERE CIRCULAR_EVENT.TS_ID = 3
           ".(($this->params["MANAGEDEPARTMENTID"]!= 0)?"and MANAGE_DEPARTMENT.MANAGE_DEPARTMENT_ID = :DEPARTMENT_ID":"")."
           ".(( $this->params["dateRange"][0]?"and CIRCULAR_EVENT.EVENT_DATE_START >= :start":""))."
           ".(( $this->params["dateRange"][1]?"and CIRCULAR_EVENT.EVENT_DATE_START <= :end":""))." 
       ")
       ->params($query_params)
      ->pipe($this->dataStore("CIRCULARREPORT"));
    }
}
