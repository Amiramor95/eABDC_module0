<?php

namespace App\Http\Controllers;

use App\Models\SettingDashboardChart;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Ixudra\Curl\Facades\Curl;
use Validator;
use DB;

class SettingDashboardChartController extends Controller
{
    public function getChart(Request $request)
    {
        $validator = Validator::make($request->all(), [ 
			'SETTING_DASHBOARD_CHART_ID' => 'required|integer', 
			'labelArray' => 'required',
            'USER_ID' => 'required|integer'  
        ]);

        if ($validator->fails()) {
            http_response_code(400);
            return response([
                'message' => 'Data validation error.',
                'errorCode' => 4106
            ],400);
        }

        try {
            $chart = SettingDashboardChart::where('SETTING_DASHBOARD_CHART_ID', $request->SETTING_DASHBOARD_CHART_ID)->first();

            $labelArray = json_decode($chart->SETTING_DASHBOARD_CHART_LABEL,true);
            $chartArray = array();

            $i = 0;
            $len = count($labelArray);

            $rawDB = "SELECT ";
            foreach ($labelArray as $label) {

                if ($i == $len - 1) {
                    $rawDB.= "SUM(".$label."'.'".$label.") as ".$label;
                } else {
                    $rawDB.= "SUM(".$label."'.'".$label.") as ".$label.",";
                }
                $i++;
            }
            $rawDB.= " FROM admin_management.SETTING_DASHBOARD_CHART ";

            echo $rawDB;
            //   ->leftJoin('programs', 'programs.id', '=', 'allocationstates.scope_id')
            //   ->where('allocationstates.scope_id', '=', $packageId)
            //   ->groupBy('allocationstates.scope_id')
            //   ->get();

            $totalArray = array();

            foreach ($program as $progrm) {
                $c = 0;
                foreach ($labelArray as $label) {
                    $totalArray[$c][] = $progrm->$label;
                    $c++;
                }

                $chartArray['xaxis']['categories'][] = $progrm->name;
            }

            $chartArray['chart']['type'] = 'bar';
            $chartArray['chart']['height'] = 350;
            $chartArray['chart']['stacked'] = true;
            $chartArray['chart']['stackType'] = '100%';

            $chartArray['plotOptions']['bar']['horizontal'] = true;
            $chartArray['stroke']['width'] = 1;
            $chartArray['stroke']['colors'][] = '#fff';
            $chartArray['title']['text'] = 'Peratusan Kewangan';

            // $chartArray['tooltip']['y']['formatter'] = '#fff';
            $chartArray['fill']['opacity'] = 1;

            $chartArray['legend']['position'] = 'top';
            $chartArray['legend']['horizontalAlign'] = 'left';
            $chartArray['legend']['offsetX'] = 40;

            $i = 0;
            $dataArray = array();

            foreach ($labelArray as $a) {
                $e = new Prestasi;
                $e->name = $a;
                $e->data = $totalArray[$i];
                $i++;
                $dataArray[] = $e;
            }

            $e = new Prestasi;
            $e->data = $dataArray;
            $e->schema = $chartArray;

            echo json_encode($e);
        } catch (RequestException $r) {

            http_response_code(400);
            return response([
                'message' => 'Data failed to be updated.',
                'errorCode' => 4100
            ],400);
        }

    }
}
