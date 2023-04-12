<?php
namespace App\Http\Controllers;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Http;
use Ixudra\Curl\Facades\Curl;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\Log;
use App\Reports\DistributorInformationReport;
use App\Reports\DistributorInformationReportPDF;
use App\Reports\DistributorTypeSummaryReport;
use App\Reports\DistributorTypeSummaryReportPDF;
use App\Reports\DistributorPointsReport;
use App\Reports\DistributorPointsReportPDF;
use App\Reports\DistributorPointsConsultantReport;
use App\Reports\DistributorPointsConsultantReportPDF;
use App\Reports\DistributorPointsByConsultantReport;
use App\Reports\DistributorPointsByConsultantReportPDF;
use App\Reports\DistributorPreRegBankruptcyReport;
use App\Reports\DistributorPreRegBankruptcyReportPDF;
use App\Reports\DistributorFundLodgementReport;
use App\Reports\DistributorFundLodgementReportPDF;


class DistributorManagementReportController extends Controller
{
    public function getDistributorInformationReport(Request $request)
    {
        //Log::info("Req =". $request->q);
        try {
            $userid = $request->session()->get('user_id');
            $usertype = $request->session()->get('user_type');
            //if (isset($userid) && isset($usertype)) {
                $decode = base64_decode($request->q);
                $paramstr= explode("/", $decode);
                $requestuid=$paramstr[0];
                $requestutype=$paramstr[1];
               // if ($userid == $requestuid && $usertype == $requestutype) {
                    $report = new DistributorInformationReport;
                    return $report->run()->render("DistributorInformationReport");
               // }
            // } else {
            //     http_response_code(400);
            //     return response([
            // 'message' => 'Un-Authenticate User',
            // 'errorCode' => 4103
            // ], 400);
            // }
        } catch (RequestException $r) {
            http_response_code(400);
            return response([
            'message' => 'Failed to retrieve data.',
            'errorCode' => 4103
            ], 400);
        }
    }
    public function getDistributorInformationExcelReport(Request $request)
    {
        try {
            $userid = $request->session()->get('user_id');
            $usertype = $request->session()->get('user_type');
            //if (isset($userid) && isset($usertype)) {
                $report = new  DistributorInformationReport;
                $report->run()
            ->exportToExcel('DistributorInformationReportExcel')
            ->toBrowser("distributorinformation.xlsx");
            // } else {
            //     http_response_code(400);
            //     return response([
            // 'message' => 'Un-Authenticate User',
            // 'errorCode' => 4103
            // ], 400);
            // }
        } catch (RequestException $r) {
            http_response_code(400);
            return response([
            'message' => 'Failed to retrieve data.',
            'errorCode' => 4103
            ], 400);
        }
    }
   
    public function getDistributorTypeSummaryReport(Request $request)
    {
        //Log::info("Req =". $request->q);
        try {
            $userid = $request->session()->get('user_id');
            $usertype = $request->session()->get('user_type');
           // if (isset($userid) && isset($usertype)) {
                $decode = base64_decode($request->q);
                $paramstr= explode("/", $decode);
                $requestuid=$paramstr[0];
                $requestutype=$paramstr[1];
              //  if ($userid == $requestuid && $usertype == $requestutype) {
                    $report = new DistributorTypeSummaryReport;
                    return $report->run()->render("DistributorTypeSummaryReport");
               // }
            // } else {
            //     http_response_code(400);
            //     return response([
            // 'message' => 'Un-Authenticate User',
            // 'errorCode' => 4103
            // ], 400);
            // }
        } catch (RequestException $r) {
            http_response_code(400);
            return response([
            'message' => 'Failed to retrieve data.',
            'errorCode' => 4103
            ], 400);
        }
    }
    public function getDistributorTypeSummaryPortraitPdf(Request $request)
    {
        try {
            $userid = $request->session()->get('user_id');
            $usertype = $request->session()->get('user_type');
           // if(isset($userid) && isset($usertype)) {
                $report = new  DistributorTypeSummaryReportPDF;
                $report->run()
            ->export('DistributorTypeSummaryReportPdf')
             ->settings(array(
                "useLocalTempFolder"=>true,
                "autoDeleteLocalTempFile"=>true,
                "phantomjs"=> config('app.koolreport_phantomjs_path'),
                "serverLocalAddress" => config('app.koolreport_server_local_address'),
            ))
            ->pdf(array(
                "format"=>"A4",
                "orientation"=>"portrait",
                "zoom"=>0.5,
                "margin"=>array(
                    "top"=>"0.5in",
                    "bottom"=>"0.5in",
                    "left"=>"0.5in",
                    "right"=>"0.5in",
                ),
                "headerCallback" => "function(headerContent, pageNum, numPages){
                    if (pageNum != 1) return ''; //don't show header for the 1st page
                    return headerContent;
                }",
               // "header"=>array("height"=>"30px","contents"=>"this is header"),
                //"footer"=>array("height"=>"30px","contents"=>"this is footer"),
            ))
            ->toBrowser("distributortypereport.pdf");
            // } else {
            //     http_response_code(400);
            //     return response([
            // 'message' => 'Un-Authenticate User',
            // 'errorCode' => 4103
            // ], 400);
            // }
        } catch (RequestException $r) {
            http_response_code(400);
            return response([
            'message' => 'Failed to retrieve data.',
            'errorCode' => 4103
            ], 400);
        }
    }
    public function getDistributorTypeSummaryLandscapePdf(Request $request)
    {
        try {
            $userid = $request->session()->get('user_id');
            $usertype = $request->session()->get('user_type');
           // if (isset($userid) && isset($usertype)) {
                $report = new  DistributorTypeSummaryReportPDF;
                $report->run()
            ->export('DistributorTypeSummaryReportPdf')
             ->settings(array(
                "useLocalTempFolder"=>true,
                "autoDeleteLocalTempFile"=>true,
                "phantomjs"=> config('app.koolreport_phantomjs_path'),
                "serverLocalAddress" => config('app.koolreport_server_local_address'),
            ))
            ->pdf(array(
                "format"=>"A4",
                "orientation"=>"landscape",
                "zoom"=>0.5,
                "margin"=>array(
                    "top"=>"0.5in",
                    "bottom"=>"0.5in",
                    "left"=>"0.5in",
                    "right"=>"0.5in",
                ),
                "headerCallback" => "function(headerContent, pageNum, numPages){
                    if (pageNum != 1) return ''; //don't show header for the 1st page
                    return headerContent;
                }",
               // "header"=>array("height"=>"30px","contents"=>"this is header"),
                //"footer"=>array("height"=>"30px","contents"=>"this is footer"),
            ))
            ->toBrowser("distributortypelandscapereport.pdf");
            // } else {
            //     http_response_code(400);
            //     return response([
            // 'message' => 'Un-Authenticate User',
            // 'errorCode' => 4103
            // ], 400);
            // }
        } catch (RequestException $r) {
            http_response_code(400);
            return response([
            'message' => 'Failed to retrieve data.',
            'errorCode' => 4103
            ], 400);
        }
    }
    public function getDistributorTypeSummaryExcel(Request $request)
    {
        try {
            $userid = $request->session()->get('user_id');
            $usertype = $request->session()->get('user_type');
           // if (isset($userid) && isset($usertype)) {
                $report = new  DistributorTypeSummaryReport;
                $report->run()
            ->exportToExcel('DistributorTypeSummaryReportExcel')
            ->toBrowser("distributortypesummary.xlsx");
            // } else {
            //     http_response_code(400);
            //     return response([
            // 'message' => 'Un-Authenticate User',
            // 'errorCode' => 4103
            // ], 400);
            // }
        } catch (RequestException $r) {
            http_response_code(400);
            return response([
            'message' => 'Failed to retrieve data.',
            'errorCode' => 4103
            ], 400);
        }
    }
    public function getDistributorPointsReport(Request $request)
    {
       // Log::info("Req =". $request->q);
        try {
            $userid = $request->session()->get('user_id');
            $usertype = $request->session()->get('user_type');
           // if (isset($userid) && isset($usertype)) {
                $decode = base64_decode($request->q);
                $paramstr= explode("/", $decode);
                $requestuid=$paramstr[0];
                $requestutype=$paramstr[1];
               // if ($userid == $requestuid && $usertype == $requestutype) {
                    $report = new DistributorPointsReport;
                    return $report->run()->render("DistributorPointsReport");
               // }
            // } else {
            //     http_response_code(400);
            //     return response([
            // 'message' => 'Un-Authenticate User',
            // 'errorCode' => 4103
            // ], 400);
            // }
        } catch (RequestException $r) {
            http_response_code(400);
            return response([
            'message' => 'Failed to retrieve data.',
            'errorCode' => 4103
            ], 400);
        }
    }
    public function getDistributorPointPortraitPdf(Request $request)
    {
        try {
            $userid = $request->session()->get('user_id');
            $usertype = $request->session()->get('user_type');
           // if(isset($userid) && isset($usertype)) {
                $report = new  DistributorPointsReportPDF;
                $report->run()
            ->export('DistributorPointsReportPdf')
             ->settings(array(
                "useLocalTempFolder"=>true,
                "autoDeleteLocalTempFile"=>true,
                "phantomjs"=> config('app.koolreport_phantomjs_path'),
                "serverLocalAddress" => config('app.koolreport_server_local_address'),
            ))
            ->pdf(array(
                "format"=>"A4",
                "orientation"=>"portrait",
                "zoom"=>0.5,
                "margin"=>array(
                    "top"=>"0.5in",
                    "bottom"=>"0.5in",
                    "left"=>"0.5in",
                    "right"=>"0.5in",
                ),
                "headerCallback" => "function(headerContent, pageNum, numPages){
                    if (pageNum != 1) return ''; //don't show header for the 1st page
                    return headerContent;
                }",
               // "header"=>array("height"=>"30px","contents"=>"this is header"),
                //"footer"=>array("height"=>"30px","contents"=>"this is footer"),
            ))
            ->toBrowser("distributorpointreport.pdf");
            // } else {
            //     http_response_code(400);
            //     return response([
            // 'message' => 'Un-Authenticate User',
            // 'errorCode' => 4103
            // ], 400);
            // }
        } catch (RequestException $r) {
            http_response_code(400);
            return response([
            'message' => 'Failed to retrieve data.',
            'errorCode' => 4103
            ], 400);
        }
    }
    public function getDistributorPointLandscapePdf(Request $request)
    {
        try {
            $userid = $request->session()->get('user_id');
            $usertype = $request->session()->get('user_type');
           // if (isset($userid) && isset($usertype)) {
                $report = new  DistributorPointsReportPDF;
                $report->run()
            ->export('DistributorPointsReportPdf')
             ->settings(array(
                "useLocalTempFolder"=>true,
                "autoDeleteLocalTempFile"=>true,
                "phantomjs"=> config('app.koolreport_phantomjs_path'),
                "serverLocalAddress" => config('app.koolreport_server_local_address'),
            ))
            ->pdf(array(
                "format"=>"A4",
                "orientation"=>"landscape",
                "zoom"=>0.5,
                "margin"=>array(
                    "top"=>"0.5in",
                    "bottom"=>"0.5in",
                    "left"=>"0.5in",
                    "right"=>"0.5in",
                ),
                "headerCallback" => "function(headerContent, pageNum, numPages){
                    if (pageNum != 1) return ''; //don't show header for the 1st page
                    return headerContent;
                }",
               // "header"=>array("height"=>"30px","contents"=>"this is header"),
                //"footer"=>array("height"=>"30px","contents"=>"this is footer"),
            ))
            ->toBrowser("distributorpointlandscapereport.pdf");
            // } else {
            //     http_response_code(400);
            //     return response([
            // 'message' => 'Un-Authenticate User',
            // 'errorCode' => 4103
            // ], 400);
            // }
        } catch (RequestException $r) {
            http_response_code(400);
            return response([
            'message' => 'Failed to retrieve data.',
            'errorCode' => 4103
            ], 400);
        }
    }
    public function getDistributorPointExcel(Request $request)
    {
        try {
            $userid = $request->session()->get('user_id');
            $usertype = $request->session()->get('user_type');
           // if (isset($userid) && isset($usertype)) {
                $report = new  DistributorPointsReport;
                $report->run()
            ->exportToExcel('DistributorPointsReportExcel')
            ->toBrowser("distributorpoint.xlsx");
            // } else {
            //     http_response_code(400);
            //     return response([
            // 'message' => 'Un-Authenticate User',
            // 'errorCode' => 4103
            // ], 400);
            // }
        } catch (RequestException $r) {
            http_response_code(400);
            return response([
            'message' => 'Failed to retrieve data.',
            'errorCode' => 4103
            ], 400);
        }
    }
    public function getDistributorPointConsultantReport(Request $request)
    {
        //Log::info("Req =". $request->q);
        try {
            $userid = $request->session()->get('user_id');
            $usertype = $request->session()->get('user_type');
          //  if (isset($userid) && isset($usertype)) {
                $decode = base64_decode($request->q);
                $paramstr= explode("/", $decode);
                $requestuid=$paramstr[0];
                $requestutype=$paramstr[1];
                $pointid=$paramstr[2];
               // if ($userid == $requestuid && $usertype == $requestutype) {
                    $report = new DistributorPointsConsultantReport(array(
                        "POINTID"=>$pointid
                    ));
                    return $report->run()->render("DistributorPointsConsultantReport");
            //     }
            // } else {
            //     http_response_code(400);
            //     return response([
            // 'message' => 'Un-Authenticate User',
            // 'errorCode' => 4103
            // ], 400);
            // }
        } catch (RequestException $r) {
            http_response_code(400);
            return response([
            'message' => 'Failed to retrieve data.',
            'errorCode' => 4103
            ], 400);
        }
    }
    public function getDistributorPointConsultantPortraitPdf(Request $request)
    {
        try {
            $userid = $request->session()->get('user_id');
            $usertype = $request->session()->get('user_type');
          //  if(isset($userid) && isset($usertype)) {
                $pointid=$request->POINTID;
                $report = new DistributorPointsConsultantReportPDF(array(
                    "POINTID"=>$pointid
                ));
                $report->run()
            ->export('DistributorPointsConsultantReportPdf')
             ->settings(array(
                "useLocalTempFolder"=>true,
                "autoDeleteLocalTempFile"=>true,
                "phantomjs"=> config('app.koolreport_phantomjs_path'),
                "serverLocalAddress" => config('app.koolreport_server_local_address'),
            ))
            ->pdf(array(
                "format"=>"A4",
                "orientation"=>"portrait",
                "zoom"=>0.5,
                "margin"=>array(
                    "top"=>"0.5in",
                    "bottom"=>"0.5in",
                    "left"=>"0.5in",
                    "right"=>"0.5in",
                ),
                "headerCallback" => "function(headerContent, pageNum, numPages){
                    if (pageNum != 1) return ''; //don't show header for the 1st page
                    return headerContent;
                }",
               // "header"=>array("height"=>"30px","contents"=>"this is header"),
                //"footer"=>array("height"=>"30px","contents"=>"this is footer"),
            ))
            ->toBrowser("distributorpointconsultantreport.pdf");
            // } else {
            //     http_response_code(400);
            //     return response([
            // 'message' => 'Un-Authenticate User',
            // 'errorCode' => 4103
            // ], 400);
            // }
        } catch (RequestException $r) {
            http_response_code(400);
            return response([
            'message' => 'Failed to retrieve data.',
            'errorCode' => 4103
            ], 400);
        }
    }
    public function getDistributorPointConsultantLandscapePdf(Request $request)
    {
        try {
            $userid = $request->session()->get('user_id');
            $usertype = $request->session()->get('user_type');
          //  if (isset($userid) && isset($usertype)) {
                $pointid=$request->POINTID;
                $report = new DistributorPointsConsultantReportPDF(array(
                    "POINTID"=>$pointid
                ));
                $report->run()
            ->export('DistributorPointsConsultantReportPdf')
             ->settings(array(
                "useLocalTempFolder"=>true,
                "autoDeleteLocalTempFile"=>true,
                "phantomjs"=> config('app.koolreport_phantomjs_path'),
                "serverLocalAddress" => config('app.koolreport_server_local_address'),
            ))
            ->pdf(array(
                "format"=>"A4",
                "orientation"=>"landscape",
                "zoom"=>0.5,
                "margin"=>array(
                    "top"=>"0.5in",
                    "bottom"=>"0.5in",
                    "left"=>"0.5in",
                    "right"=>"0.5in",
                ),
                "headerCallback" => "function(headerContent, pageNum, numPages){
                    if (pageNum != 1) return ''; //don't show header for the 1st page
                    return headerContent;
                }",
               // "header"=>array("height"=>"30px","contents"=>"this is header"),
                //"footer"=>array("height"=>"30px","contents"=>"this is footer"),
            ))
            ->toBrowser("distributorpointconsultantlandscapereport.pdf");
            // } else {
            //     http_response_code(400);
            //     return response([
            // 'message' => 'Un-Authenticate User',
            // 'errorCode' => 4103
            // ], 400);
            // }
        } catch (RequestException $r) {
            http_response_code(400);
            return response([
            'message' => 'Failed to retrieve data.',
            'errorCode' => 4103
            ], 400);
        }
    }
    public function getDistributorPointConsultantExcel(Request $request)
    {
        try {
            $userid = $request->session()->get('user_id');
            $usertype = $request->session()->get('user_type');
           // if (isset($userid) && isset($usertype)) {
                $pointid=$request->POINTID;
                $report = new DistributorPointsConsultantReport(array(
                    "POINTID"=>$pointid
                ));
                $report->run()
            ->exportToExcel('DistributorPointsConsultantReportExcel')
            ->toBrowser("distributorpointconsultant.xlsx");
            // } else {
            //     http_response_code(400);
            //     return response([
            // 'message' => 'Un-Authenticate User',
            // 'errorCode' => 4103
            // ], 400);
            // }
        } catch (RequestException $r) {
            http_response_code(400);
            return response([
            'message' => 'Failed to retrieve data.',
            'errorCode' => 4103
            ], 400);
        }
    }
    public function getDistributorPointByConsultantReport(Request $request)
    {
        //Log::info("Req =". $request->q);
        try {
            $userid = $request->session()->get('user_id');
            $usertype = $request->session()->get('user_type');
           // if (isset($userid) && isset($usertype)) {
                $decode = base64_decode($request->q);
                $paramstr= explode("/", $decode);
                $requestuid=$paramstr[0];
                $requestutype=$paramstr[1];
              //  if ($userid == $requestuid && $usertype == $requestutype) {
                    $report = new DistributorPointsByConsultantReport;
                    return $report->run()->render("DistributorPointsByConsultantReport");
            //     }
            // } else {
            //     http_response_code(400);
            //     return response([
            // 'message' => 'Un-Authenticate User',
            // 'errorCode' => 4103
            // ], 400);
            // }
        } catch (RequestException $r) {
            http_response_code(400);
            return response([
            'message' => 'Failed to retrieve data.',
            'errorCode' => 4103
            ], 400);
        }
    }
    public function getDistributorPointByConsultantPortraitPdf(Request $request)
    {
        try {
            $userid = $request->session()->get('user_id');
            $usertype = $request->session()->get('user_type');
           // if(isset($userid) && isset($usertype)) {
                $report = new  DistributorPointsByConsultantReportPDF;
                $report->run()
            ->export('DistributorPointsByConsultantReportPdf')
             ->settings(array(
                "useLocalTempFolder"=>true,
                "autoDeleteLocalTempFile"=>true,
                "phantomjs"=> config('app.koolreport_phantomjs_path'),
                "serverLocalAddress" => config('app.koolreport_server_local_address'),
            ))
            ->pdf(array(
                "format"=>"A4",
                "orientation"=>"portrait",
                "zoom"=>0.5,
                "margin"=>array(
                    "top"=>"0.5in",
                    "bottom"=>"0.5in",
                    "left"=>"0.5in",
                    "right"=>"0.5in",
                ),
                "headerCallback" => "function(headerContent, pageNum, numPages){
                    if (pageNum != 1) return ''; //don't show header for the 1st page
                    return headerContent;
                }",
               // "header"=>array("height"=>"30px","contents"=>"this is header"),
                //"footer"=>array("height"=>"30px","contents"=>"this is footer"),
            ))
            ->toBrowser("distributorpointbyconsultantreport.pdf");
            // } else {
            //     http_response_code(400);
            //     return response([
            // 'message' => 'Un-Authenticate User',
            // 'errorCode' => 4103
            // ], 400);
            // }
        } catch (RequestException $r) {
            http_response_code(400);
            return response([
            'message' => 'Failed to retrieve data.',
            'errorCode' => 4103
            ], 400);
        }
    }
    public function getDistributorPointByConsultantLandscapePdf(Request $request)
    {
        try {
            $userid = $request->session()->get('user_id');
            $usertype = $request->session()->get('user_type');
           // if (isset($userid) && isset($usertype)) {
                $report = new  DistributorPointsByConsultantReportPDF;
                $report->run()
            ->export('DistributorPointsByConsultantReportPdf')
             ->settings(array(
                "useLocalTempFolder"=>true,
                "autoDeleteLocalTempFile"=>true,
                "phantomjs"=> config('app.koolreport_phantomjs_path'),
                "serverLocalAddress" => config('app.koolreport_server_local_address'),
            ))
            ->pdf(array(
                "format"=>"A4",
                "orientation"=>"landscape",
                "zoom"=>0.5,
                "margin"=>array(
                    "top"=>"0.5in",
                    "bottom"=>"0.5in",
                    "left"=>"0.5in",
                    "right"=>"0.5in",
                ),
                "headerCallback" => "function(headerContent, pageNum, numPages){
                    if (pageNum != 1) return ''; //don't show header for the 1st page
                    return headerContent;
                }",
               // "header"=>array("height"=>"30px","contents"=>"this is header"),
                //"footer"=>array("height"=>"30px","contents"=>"this is footer"),
            ))
            ->toBrowser("distributorpointbyconsultantlandscapereport.pdf");
            // } else {
            //     http_response_code(400);
            //     return response([
            // 'message' => 'Un-Authenticate User',
            // 'errorCode' => 4103
            // ], 400);
            // }
        } catch (RequestException $r) {
            http_response_code(400);
            return response([
            'message' => 'Failed to retrieve data.',
            'errorCode' => 4103
            ], 400);
        }
    }
    public function getDistributorPointByConsultantExcel(Request $request)
    {
        try {
            $userid = $request->session()->get('user_id');
            $usertype = $request->session()->get('user_type');
          //  if (isset($userid) && isset($usertype)) {
                $report = new  DistributorPointsByConsultantReport;
                $report->run()
            ->exportToExcel('DistributorPointsByConsultantReportExcel')
            ->toBrowser("distributorpointbyconsultant.xlsx");
            // } else {
            //     http_response_code(400);
            //     return response([
            // 'message' => 'Un-Authenticate User',
            // 'errorCode' => 4103
            // ], 400);
            // }
        } catch (RequestException $r) {
            http_response_code(400);
            return response([
            'message' => 'Failed to retrieve data.',
            'errorCode' => 4103
            ], 400);
        }
    }
    public function getDistributorPreRegBankruptcyReport(Request $request)
    {
        //Log::info("Req =". $request->q);
        try {
            $userid = $request->session()->get('user_id');
            $usertype = $request->session()->get('user_type');
            //if (isset($userid) && isset($usertype)) {
                $decode = base64_decode($request->q);
                $paramstr= explode("/", $decode);
                $requestuid=$paramstr[0];
                $requestutype=$paramstr[1];
              //  if ($userid == $requestuid && $usertype == $requestutype) {
                    $report = new DistributorPreRegBankruptcyReport;
                    return $report->run()->render("DistributorPreRegBankruptcyReport");
            //     }
            // } else {
            //     http_response_code(400);
            //     return response([
            // 'message' => 'Un-Authenticate User',
            // 'errorCode' => 4103
            // ], 400);
            // }
        } catch (RequestException $r) {
            http_response_code(400);
            return response([
            'message' => 'Failed to retrieve data.',
            'errorCode' => 4103
            ], 400);
        }
    }
    public function getDistributorPreBankruptcyPortraitPdf(Request $request)
    {
        try {
            $userid = $request->session()->get('user_id');
            $usertype = $request->session()->get('user_type');
           // if(isset($userid) && isset($usertype)) {
                $report = new  DistributorPreRegBankruptcyReportPDF;
                $report->run()
            ->export('DistributorPreRegBankruptcyReportPdf')
             ->settings(array(
                "useLocalTempFolder"=>true,
                "autoDeleteLocalTempFile"=>true,
                "phantomjs"=> config('app.koolreport_phantomjs_path'),
                "serverLocalAddress" => config('app.koolreport_server_local_address'),
            ))
            ->pdf(array(
                "format"=>"A4",
                "orientation"=>"portrait",
                "zoom"=>0.5,
                "margin"=>array(
                    "top"=>"0.5in",
                    "bottom"=>"0.5in",
                    "left"=>"0.5in",
                    "right"=>"0.5in",
                ),
                "headerCallback" => "function(headerContent, pageNum, numPages){
                    if (pageNum != 1) return ''; //don't show header for the 1st page
                    return headerContent;
                }",
               // "header"=>array("height"=>"30px","contents"=>"this is header"),
                //"footer"=>array("height"=>"30px","contents"=>"this is footer"),
            ))
            ->toBrowser("distributorprebankruptcyreport.pdf");
            // } else {
            //     http_response_code(400);
            //     return response([
            // 'message' => 'Un-Authenticate User',
            // 'errorCode' => 4103
            // ], 400);
            // }
        } catch (RequestException $r) {
            http_response_code(400);
            return response([
            'message' => 'Failed to retrieve data.',
            'errorCode' => 4103
            ], 400);
        }
    }
    public function getDistributorPreBankruptcyLandscapePdf(Request $request)
    {
        try {
            $userid = $request->session()->get('user_id');
            $usertype = $request->session()->get('user_type');
            //if (isset($userid) && isset($usertype)) {
                $report = new  DistributorPreRegBankruptcyReportPDF;
                $report->run()
            ->export('DistributorPreRegBankruptcyReportPdf')
             ->settings(array(
                "useLocalTempFolder"=>true,
                "autoDeleteLocalTempFile"=>true,
                "phantomjs"=> config('app.koolreport_phantomjs_path'),
                "serverLocalAddress" => config('app.koolreport_server_local_address'),
            ))
            ->pdf(array(
                "format"=>"A4",
                "orientation"=>"landscape",
                "zoom"=>0.5,
                "margin"=>array(
                    "top"=>"0.5in",
                    "bottom"=>"0.5in",
                    "left"=>"0.5in",
                    "right"=>"0.5in",
                ),
                "headerCallback" => "function(headerContent, pageNum, numPages){
                    if (pageNum != 1) return ''; //don't show header for the 1st page
                    return headerContent;
                }",
               // "header"=>array("height"=>"30px","contents"=>"this is header"),
                //"footer"=>array("height"=>"30px","contents"=>"this is footer"),
            ))
            ->toBrowser("distributortbankruptcylandscapereport.pdf");
            // } else {
            //     http_response_code(400);
            //     return response([
            // 'message' => 'Un-Authenticate User',
            // 'errorCode' => 4103
            // ], 400);
            // }
        } catch (RequestException $r) {
            http_response_code(400);
            return response([
            'message' => 'Failed to retrieve data.',
            'errorCode' => 4103
            ], 400);
        }
    }
    public function getDistributorPreBankruptcyExcel(Request $request)
    {
        try {
            $userid = $request->session()->get('user_id');
            $usertype = $request->session()->get('user_type');
           // if (isset($userid) && isset($usertype)) {
                $report = new  DistributorPreRegBankruptcyReport;
                $report->run()
            ->exportToExcel('DistributorPreRegBankruptcyReportExcel')
            ->toBrowser("distributorbankruptcy.xlsx");
            // } else {
            //     http_response_code(400);
            //     return response([
            // 'message' => 'Un-Authenticate User',
            // 'errorCode' => 4103
            // ], 400);
            // }
        } catch (RequestException $r) {
            http_response_code(400);
            return response([
            'message' => 'Failed to retrieve data.',
            'errorCode' => 4103
            ], 400);
        }
    }
    public function getDistributorFundlodgementReport(Request $request)
    {
        //Log::info("Req =". $request->q);
        try {
            $userid = $request->session()->get('user_id');
            $usertype = $request->session()->get('user_type');
           // if (isset($userid) && isset($usertype)) {
                $decode = base64_decode($request->q);
                $paramstr= explode("/", $decode);
                $requestuid=$paramstr[0];
                $requestutype=$paramstr[1];
               // if ($userid == $requestuid && $usertype == $requestutype) {
                    $report = new DistributorFundLodgementReport;
                    return $report->run()->render("DistributorFundLodgementReport");
            //     }
            // } else {
            //     http_response_code(400);
            //     return response([
            // 'message' => 'Un-Authenticate User',
            // 'errorCode' => 4103
            // ], 400);
            // }
        } catch (RequestException $r) {
            http_response_code(400);
            return response([
            'message' => 'Failed to retrieve data.',
            'errorCode' => 4103
            ], 400);
        }
    }
    public function getDistributorFundlodgementPortraitPdf(Request $request)
    {
        try {
            $userid = $request->session()->get('user_id');
            $usertype = $request->session()->get('user_type');
            //if(isset($userid) && isset($usertype)) {
                $report = new  DistributorFundLodgementReportPDF;
                $report->run()
            ->export('DistributorFundLodgementReportPdf')
             ->settings(array(
                "useLocalTempFolder"=>true,
                "autoDeleteLocalTempFile"=>true,
                "phantomjs"=> config('app.koolreport_phantomjs_path'),
                "serverLocalAddress" => config('app.koolreport_server_local_address'),
            ))
            ->pdf(array(
                "format"=>"A4",
                "orientation"=>"portrait",
                "zoom"=>0.5,
                "margin"=>array(
                    "top"=>"0.5in",
                    "bottom"=>"0.5in",
                    "left"=>"0.5in",
                    "right"=>"0.5in",
                ),
                "headerCallback" => "function(headerContent, pageNum, numPages){
                    if (pageNum != 1) return ''; //don't show header for the 1st page
                    return headerContent;
                }",
               // "header"=>array("height"=>"30px","contents"=>"this is header"),
                //"footer"=>array("height"=>"30px","contents"=>"this is footer"),
            ))
            ->toBrowser("distributorfundlodgementreport.pdf");
            // } else {
            //     http_response_code(400);
            //     return response([
            // 'message' => 'Un-Authenticate User',
            // 'errorCode' => 4103
            // ], 400);
            // }
        } catch (RequestException $r) {
            http_response_code(400);
            return response([
            'message' => 'Failed to retrieve data.',
            'errorCode' => 4103
            ], 400);
        }
    }
    public function getDistributorFundlodgementLandscapePdf(Request $request)
    {
        try {
            $userid = $request->session()->get('user_id');
            $usertype = $request->session()->get('user_type');
           // if (isset($userid) && isset($usertype)) {
                $report = new  DistributorFundLodgementReportPDF;
                $report->run()
            ->export('DistributorFundLodgementReportPdf')
             ->settings(array(
                "useLocalTempFolder"=>true,
                "autoDeleteLocalTempFile"=>true,
                "phantomjs"=> config('app.koolreport_phantomjs_path'),
                "serverLocalAddress" => config('app.koolreport_server_local_address'),
            ))
            ->pdf(array(
                "format"=>"A4",
                "orientation"=>"landscape",
                "zoom"=>0.5,
                "margin"=>array(
                    "top"=>"0.5in",
                    "bottom"=>"0.5in",
                    "left"=>"0.5in",
                    "right"=>"0.5in",
                ),
                "headerCallback" => "function(headerContent, pageNum, numPages){
                    if (pageNum != 1) return ''; //don't show header for the 1st page
                    return headerContent;
                }",
               // "header"=>array("height"=>"30px","contents"=>"this is header"),
                //"footer"=>array("height"=>"30px","contents"=>"this is footer"),
            ))
            ->toBrowser("distributorfundlodgementlandscapereport.pdf");
            // } else {
            //     http_response_code(400);
            //     return response([
            // 'message' => 'Un-Authenticate User',
            // 'errorCode' => 4103
            // ], 400);
            // }
        } catch (RequestException $r) {
            http_response_code(400);
            return response([
            'message' => 'Failed to retrieve data.',
            'errorCode' => 4103
            ], 400);
        }
    }
    public function getDistributorFundlodgementExcel(Request $request)
    {
        try {
            $userid = $request->session()->get('user_id');
            $usertype = $request->session()->get('user_type');
          //  if (isset($userid) && isset($usertype)) {
                $report = new  DistributorFundLodgementReport;
                $report->run()
            ->exportToExcel('DistributorFundLodgementReportExcel')
            ->toBrowser("distributorfundlodgement.xlsx");
            // } else {
            //     http_response_code(400);
            //     return response([
            // 'message' => 'Un-Authenticate User',
            // 'errorCode' => 4103
            // ], 400);
            // }
        } catch (RequestException $r) {
            http_response_code(400);
            return response([
            'message' => 'Failed to retrieve data.',
            'errorCode' => 4103
            ], 400);
        }
    }
}
