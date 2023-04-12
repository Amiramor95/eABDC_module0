<?php
namespace App\Reports;
class  koolsetting {

     public function ksetup(){
        return array(
            "assets"=>array(
                "path"=> config('app.koolreport_setting_path'),
                 "url"=> config('app.koolreport_setting_url')
            )
        );
    }
}
