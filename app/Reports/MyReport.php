<?php
namespace App\Reports;

class MyReport extends \koolreport\KoolReport
{
    use \koolreport\laravel\Friendship;
    // By adding above statement, you have claim the friendship between two frameworks
    // As a result, this report will be able to accessed all databases of Laravel
    // There are no need to define the settings() function anymore
    // while you can do so if you have other datasources rather than those
    // defined in Laravel.
    use \koolreport\clients\FontAwesome;
    use \koolreport\amazing\Theme;
    use \koolreport\cloudexport\Exportable;
    

    function setup()
    {
        // Let say, you have "sale_database" is defined in Laravel's database settings.
        // Now you can use that database without any futher setitngs.
        $this->src("mysql")
        ->query("Select DISTRIBUTOR_TYPE.DIST_TYPE_NAME AS DIST_TYPE_NAME
         from admin_management.DISTRIBUTOR_TYPE AS DISTRIBUTOR_TYPE")
       ->pipe($this->dataStore("offices"));
    }
}
