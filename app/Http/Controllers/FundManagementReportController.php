<?php
namespace App\Http\Controllers;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Http;
use Ixudra\Curl\Facades\Curl;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\Log;
use App\Reports\FundHistoricalNavReport;
use App\Reports\FundHistoricalNavReportPDF;
use App\Reports\FundHistoricalNavDetailReport;
use App\Reports\FundHistoricalNavDetailReportPDF;
use App\Reports\FundHistoricalNavMemberReport;
use App\Reports\FundHistoricalNavMemberReportPDF;
use App\Reports\FundDataNewReport;
use App\Reports\FundDataNewReportPDF;
use App\Reports\FundDataClosedReport;
use App\Reports\FundDataClosedReportPDF;
use App\Reports\FundDataStatusReport;
use App\Reports\FundDataStatusReportPDF;
use App\Reports\FundDataEPFReport;
use App\Reports\FundDataEPFReportPDF;
use App\Reports\FundDataSRIReport;
use App\Reports\FundDataSRIReportPDF;
use App\Reports\FundDailyNavReport;
use App\Reports\FundDailyNavReportPDF;
use App\Reports\FundDailyNavAdminReport;
use App\Reports\FundDailyNavAdminReportPDF;
use App\Reports\FundUserSummaryReport;
use App\Reports\FundUserSummaryReportPDF;
use App\Reports\FundUserSummaryFimmReport;
use App\Reports\FundUserSummaryFimmReportPDF;
use App\Reports\FundUTMCContactPersonReport;
use App\Reports\FundUTMCContactPersonReportPDF;
use App\Reports\FundNewspaperContactReport;
use App\Reports\FundNewspaperContactReportPDF;
use App\Reports\FundEventLogReport;
use App\Reports\FundEventLogReportPDF;
use App\Reports\FundDataAllReport;
use App\Reports\FundDataAllReportPDF;
use App\Reports\FundAuditTrailReport;
use App\Reports\FundAuditTrailReportPDF;
use App\Reports\FundNAVMovementReport;
use App\Reports\FundNAVMovementReportPDF;


class FundManagementReportController extends Controller
{
    public function getFundDailyNavReport(Request $request)
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
                    $report = new FundDailyNavReport;
                    return $report->run()->render("FundDailyNavReport");
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
    public function getFundDailyNavPortraitPdf(Request $request)
    {
        try {
            $userid = $request->session()->get('user_id');
            $usertype = $request->session()->get('user_type');
           // if(isset($userid) && isset($usertype)) {
                $report = new  FundDailyNavReportPDF;
                $report->run()
            ->export('FundDailyNavReportPdf')
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
            ->toBrowser("funddailynavreport.pdf");
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
    public function getFundDailyNavLandscapePdf(Request $request)
    {
        try {
            $userid = $request->session()->get('user_id');
            $usertype = $request->session()->get('user_type');
           // if (isset($userid) && isset($usertype)) {
                $report = new  FundDailyNavReportPDF;
                $report->run()
            ->export('FundDailyNavReportPdf')
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
            ->toBrowser("funddailynavlandscapereport.pdf");
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
    public function getFundDailyNavExcel(Request $request)
    {
        try {
            $userid = $request->session()->get('user_id');
            $usertype = $request->session()->get('user_type');
           // if (isset($userid) && isset($usertype)) {
                $report = new  FundDailyNavReport;
                $report->run()
            ->exportToExcel('FundDailyNavReportExcel')
            ->toBrowser("funddailynav.xlsx");
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
    public function getFundDailyNavAdminReport(Request $request)
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
                    $report = new FundDailyNavAdminReport;
                    return $report->run()->render("FundDailyNavAdminReport");
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
    public function getFundDailyNavAdminPortraitPdf(Request $request)
    {
        try {
            $userid = $request->session()->get('user_id');
            $usertype = $request->session()->get('user_type');
           // if(isset($userid) && isset($usertype)) {
                $report = new  FundDailyNavAdminReportPDF;
                $report->run()
            ->export('FundDailyNavAdminReportPdf')
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
            ->toBrowser("funddailynavadminreport.pdf");
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
    public function getFundDailyNavAdminLandscapePdf(Request $request)
    {
        try {
            $userid = $request->session()->get('user_id');
            $usertype = $request->session()->get('user_type');
           // if (isset($userid) && isset($usertype)) {
                $report = new  FundDailyNavAdminReportPDF;
                $report->run()
            ->export('FundDailyNavAdminReportPdf')
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
            ->toBrowser("funddailynavadminlandscapereport.pdf");
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
    public function getFundDailyNavAdminExcel(Request $request)
    {
        try {
            $userid = $request->session()->get('user_id');
            $usertype = $request->session()->get('user_type');
           // if (isset($userid) && isset($usertype)) {
                $report = new  FundDailyNavAdminReport;
                $report->run()
            ->exportToExcel('FundDailyNavAdminReportExcel')
            ->toBrowser("funddailynavadmin.xlsx");
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
    public function getFundHistoricalNavReport(Request $request)
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
                    $report = new FundHistoricalNavReport;
                    return $report->run()->render("FundHistoricalNavReport");
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
    public function getFundHistoricalNavPortraitPdf(Request $request)
    {
        try {
            $userid = $request->session()->get('user_id');
            $usertype = $request->session()->get('user_type');
           // if(isset($userid) && isset($usertype)) {
                $report = new  FundHistoricalNavReportPDF;
                $report->run()
            ->export('FundHistoricalNavReportPdf')
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
            ->toBrowser("fundhistoricalnavreport.pdf");
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
    public function getFundHistoricalNavLandscapePdf(Request $request)
    {
        try {
            $userid = $request->session()->get('user_id');
            $usertype = $request->session()->get('user_type');
            //if (isset($userid) && isset($usertype)) {
                $report = new  FundHistoricalNavReportPDF;
                $report->run()
            ->export('FundHistoricalNavReportPdf')
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
            ->toBrowser("fundhistoricalnavlandscapereport.pdf");
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
    public function getFundHistoricalNavExcel(Request $request)
    {
        try {
            $userid = $request->session()->get('user_id');
            $usertype = $request->session()->get('user_type');
           // if (isset($userid) && isset($usertype)) {
                $report = new  FundHistoricalNavReport;
                $report->run()
            ->exportToExcel('FundHistoricalNavReportExcel')
            ->toBrowser("fundhistoricalnav.xlsx");
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
    public function getFundHistoricalNavDetailReport(Request $request)
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
                    $report = new FundHistoricalNavDetailReport;
                    return $report->run()->render("FundHistoricalNavDetailReport");
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
    public function getFundHistoricalNavDetailPortraitPdf(Request $request)
    {
        try {
            $userid = $request->session()->get('user_id');
            $usertype = $request->session()->get('user_type');
           // if(isset($userid) && isset($usertype)) {
                $report = new  FundHistoricalNavDetailReportPDF;
                $report->run()
            ->export('FundHistoricalNavDetailReportPdf')
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
            ->toBrowser("fundhistoricalnavdetailreport.pdf");
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
    public function getFundHistoricalNavDetailLandscapePdf(Request $request)
    {
        try {
            $userid = $request->session()->get('user_id');
            $usertype = $request->session()->get('user_type');
           // if (isset($userid) && isset($usertype)) {
                $report = new  FundHistoricalNavDetailReportPDF;
                $report->run()
            ->export('FundHistoricalNavDetailReportPdf')
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
            ->toBrowser("fundhistoricalnavdetaillandscapereport.pdf");
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
    public function getFundHistoricalNavDetailExcel(Request $request)
    {
        try {
            $userid = $request->session()->get('user_id');
            $usertype = $request->session()->get('user_type');
          //  if (isset($userid) && isset($usertype)) {
                $report = new  FundHistoricalNavDetailReport;
                $report->run()
            ->exportToExcel('FundHistoricalNavDetailReportExcel')
            ->toBrowser("fundhistoricalnavdetail.xlsx");
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
    public function getFundHistoricalNavMemberReport(Request $request)
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
                    $report = new FundHistoricalNavMemberReport;
                    return $report->run()->render("FundHistoricalNavMemberReport");
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
    public function getFundHistoricalNavMemberPortraitPdf(Request $request)
    {
        try {
            $userid = $request->session()->get('user_id');
            $usertype = $request->session()->get('user_type');
           // if(isset($userid) && isset($usertype)) {
                $report = new  FundHistoricalNavMemberReportPDF;
                $report->run()
            ->export('FundHistoricalNavMemberReportPdf')
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
            ->toBrowser("fundhistoricalnavmemberreport.pdf");
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
    public function getFundHistoricalNavMemberLandscapePdf(Request $request)
    {
        try {
            $userid = $request->session()->get('user_id');
            $usertype = $request->session()->get('user_type');
           // if (isset($userid) && isset($usertype)) {
                $report = new  FundHistoricalNavMemberReportPDF;
                $report->run()
            ->export('FundHistoricalNavMemberReportPdf')
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
            ->toBrowser("fundhistoricalnavmemberlandscapereport.pdf");
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
    public function getFundHistoricalNavMemberExcel(Request $request)
    {
        try {
            $userid = $request->session()->get('user_id');
            $usertype = $request->session()->get('user_type');
           // if (isset($userid) && isset($usertype)) {
                $report = new  FundHistoricalNavMemberReport;
                $report->run()
            ->exportToExcel('FundHistoricalNavMemberReportExcel')
            ->toBrowser("fundhistoricalnavmember.xlsx");
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
    public function getFundDataNewReport(Request $request)
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
                    $report = new FundDataNewReport;
                    return $report->run()->render("FundDataNewReport");
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
    public function getFundDataNewPortraitPdf(Request $request)
    {
        try {
            $userid = $request->session()->get('user_id');
            $usertype = $request->session()->get('user_type');
           // if(isset($userid) && isset($usertype)) {
                $report = new  FundDataNewReportPDF;
                $report->run()
            ->export('FundDataNewReportPdf')
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
            ->toBrowser("funddatanewreport.pdf");
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
    public function getFundDataNewLandscapePdf(Request $request)
    {
        try {
            $userid = $request->session()->get('user_id');
            $usertype = $request->session()->get('user_type');
           // if (isset($userid) && isset($usertype)) {
                $report = new  FundDataNewReportPDF;
                $report->run()
            ->export('FundDataNewReportPdf')
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
            ->toBrowser("funddatanewlandscapereport.pdf");
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
    public function getFundDataNewExcel(Request $request)
    {
        try {
            $userid = $request->session()->get('user_id');
            $usertype = $request->session()->get('user_type');
           // if (isset($userid) && isset($usertype)) {
                $report = new  FundDataNewReport;
                $report->run()
            ->exportToExcel('FundDataNewReportExcel')
            ->toBrowser("funddatanew.xlsx");
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
    public function getFundDataClosedReport(Request $request)
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
                    $report = new FundDataClosedReport;
                    return $report->run()->render("FundDataClosedReport");
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
    public function getFundDataClosedPortraitPdf(Request $request)
    {
        try {
            $userid = $request->session()->get('user_id');
            $usertype = $request->session()->get('user_type');
           // if(isset($userid) && isset($usertype)) {
                $report = new  FundDataClosedReportPDF;
                $report->run()
            ->export('FundDataClosedReportPdf')
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
            ->toBrowser("funddataclosedreport.pdf");
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
    public function getFundDataClosedLandscapePdf(Request $request)
    {
        try {
            $userid = $request->session()->get('user_id');
            $usertype = $request->session()->get('user_type');
           // if (isset($userid) && isset($usertype)) {
                $report = new  FundDataClosedReportPDF;
                $report->run()
            ->export('FundDataClosedReportPdf')
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
            ->toBrowser("funddataclosedlandscapereport.pdf");
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
    public function getFundDataClosedExcel(Request $request)
    {
        try {
            $userid = $request->session()->get('user_id');
            $usertype = $request->session()->get('user_type');
           // if (isset($userid) && isset($usertype)) {
                $report = new  FundDataClosedReport;
                $report->run()
            ->exportToExcel('FundDataClosedReportExcel')
            ->toBrowser("funddataclosed.xlsx");
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
    public function getFundDataStatusReport(Request $request)
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
                    $report = new FundDataStatusReport;
                    return $report->run()->render("FundDataStatusReport");
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
    public function getFundDataStatusPortraitPdf(Request $request)
    {
        try {
            $userid = $request->session()->get('user_id');
            $usertype = $request->session()->get('user_type');
           // if(isset($userid) && isset($usertype)) {
                $report = new  FundDataStatusReportPDF;
                $report->run()
            ->export('FundDataStatusReportPdf')
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
            ->toBrowser("funddatastatusreport.pdf");
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
    public function getFundDataStatusLandscapePdf(Request $request)
    {
        try {
            $userid = $request->session()->get('user_id');
            $usertype = $request->session()->get('user_type');
           // if (isset($userid) && isset($usertype)) {
                $report = new  FundDataStatusReportPDF;
                $report->run()
            ->export('FundDataStatusReportPdf')
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
            ->toBrowser("funddatastatuslandscapereport.pdf");
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
    public function getFundDataStatusExcel(Request $request)
    {
        try {
            $userid = $request->session()->get('user_id');
            $usertype = $request->session()->get('user_type');
           // if (isset($userid) && isset($usertype)) {
                $report = new  FundDataStatusReport;
                $report->run()
            ->exportToExcel('FundDataStatusReportExcel')
            ->toBrowser("funddatastatus.xlsx");
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
    public function getFundDataEPFReport(Request $request)
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
                    $report = new FundDataEPFReport;
                    return $report->run()->render("FundDataEPFReport");
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
    public function getFundDataEPFPortraitPdf(Request $request)
    {
        try {
            $userid = $request->session()->get('user_id');
            $usertype = $request->session()->get('user_type');
           // if(isset($userid) && isset($usertype)) {
                $report = new  FundDataEPFReportPDF;
                $report->run()
            ->export('FundDataEPFReportPdf')
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
            ->toBrowser("funddataepfreport.pdf");
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
    public function getFundDataEPFLandscapePdf(Request $request)
    {
        try {
            $userid = $request->session()->get('user_id');
            $usertype = $request->session()->get('user_type');
            //if (isset($userid) && isset($usertype)) {
                $report = new  FundDataEPFReportPDF;
                $report->run()
            ->export('FundDataEPFReportPdf')
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
            ->toBrowser("funddataepflandscapereport.pdf");
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
    public function getFundDataEPFExcel(Request $request)
    {
        try {
            $userid = $request->session()->get('user_id');
            $usertype = $request->session()->get('user_type');
           // if (isset($userid) && isset($usertype)) {
                $report = new  FundDataEPFReport;
                $report->run()
            ->exportToExcel('FundDataEPFReportExcel')
            ->toBrowser("funddataepf.xlsx");
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
    public function getFundDataSRIReport(Request $request)
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
               // if ($userid == $requestuid && $usertype == $requestutype) {
                    $report = new FundDataSRIReport;
                    return $report->run()->render("FundDataSRIReport");
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
    public function getFundDataSRIPortraitPdf(Request $request)
    {
        try {
            $userid = $request->session()->get('user_id');
            $usertype = $request->session()->get('user_type');
            //if(isset($userid) && isset($usertype)) {
                $report = new  FundDataSRIReportPDF;
                $report->run()
            ->export('FundDataSRIReportPdf')
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
            ->toBrowser("funddatasrireport.pdf");
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
    public function getFundDataSRILandscapePdf(Request $request)
    {
        try {
            $userid = $request->session()->get('user_id');
            $usertype = $request->session()->get('user_type');
           // if (isset($userid) && isset($usertype)) {
                $report = new  FundDataSRIReportPDF;
                $report->run()
            ->export('FundDataSRIReportPdf')
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
            ->toBrowser("funddatasrilandscapereport.pdf");
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
    public function getFundDataSRIExcel(Request $request)
    {
        try {
            $userid = $request->session()->get('user_id');
            $usertype = $request->session()->get('user_type');
           // if (isset($userid) && isset($usertype)) {
                $report = new  FundDataSRIReport;
                $report->run()
            ->exportToExcel('FundDataSRIReportExcel')
            ->toBrowser("funddatasri.xlsx");
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
    public function getFundUserSummaryReport(Request $request)
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
                    $report = new FundUserSummaryReport;
                    return $report->run()->render("FundUserSummaryReport");
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
    public function getFundUserSummaryPortraitPdf(Request $request)
    {
        try {
            $userid = $request->session()->get('user_id');
            $usertype = $request->session()->get('user_type');
           // if(isset($userid) && isset($usertype)) {
                $report = new  FundUserSummaryReportPDF;
                $report->run()
            ->export('FundUserSummaryReportPdf')
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
            ->toBrowser("fundusersummaryreport.pdf");
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
    public function getFundUserSummaryLandscapePdf(Request $request)
    {
        try {
            $userid = $request->session()->get('user_id');
            $usertype = $request->session()->get('user_type');
           // if (isset($userid) && isset($usertype)) {
                $report = new  FundUserSummaryReportPDF;
                $report->run()
            ->export('FundUserSummaryReportPdf')
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
            ->toBrowser("funduaersummarylandscapereport.pdf");
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
    public function getFundUserSummaryExcel(Request $request)
    {
        try {
            $userid = $request->session()->get('user_id');
            $usertype = $request->session()->get('user_type');
           // if (isset($userid) && isset($usertype)) {
                $report = new  FundUserSummaryReport;
                $report->run()
            ->exportToExcel('FundUserSummaryReportExcel')
            ->toBrowser("fundusersummary.xlsx");
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
    public function getFundUserSummaryFimmReport(Request $request)
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
                    $report = new FundUserSummaryFimmReport;
                    return $report->run()->render("FundUserSummaryFimmReport");
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
    public function getFundUserSummaryFimmPortraitPdf(Request $request)
    {
        try {
            $userid = $request->session()->get('user_id');
            $usertype = $request->session()->get('user_type');
           // if(isset($userid) && isset($usertype)) {
                $report = new  FundUserSummaryFimmReportPDF;
                $report->run()
            ->export('FundUserSummaryFimmReportPdf')
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
            ->toBrowser("fundusersummaryfimmreport.pdf");
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
    public function getFundUserSummaryFimmLandscapePdf(Request $request)
    {
        try {
            $userid = $request->session()->get('user_id');
            $usertype = $request->session()->get('user_type');
            //if (isset($userid) && isset($usertype)) {
                $report = new  FundUserSummaryFimmReportPDF;
                $report->run()
            ->export('FundUserSummaryFimmReportPdf')
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
            ->toBrowser("funduaersummaryfimmlandscapereport.pdf");
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
    public function getFundUserSummaryFimmExcel(Request $request)
    {
        try {
            $userid = $request->session()->get('user_id');
            $usertype = $request->session()->get('user_type');
           // if (isset($userid) && isset($usertype)) {
                $report = new  FundUserSummaryFimmReport;
                $report->run()
            ->exportToExcel('FundUserSummaryFimmReportExcel')
            ->toBrowser("fundusersummaryfimm.xlsx");
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
    public function getFundUTMCContactPersonReport(Request $request)
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
                //if ($userid == $requestuid && $usertype == $requestutype) {
                    $report = new FundUTMCContactPersonReport;
                    return $report->run()->render("FundUTMCContactPersonReport");
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
    public function getFundUTMCContactPersonPortraitPdf(Request $request)
    {
        try {
            $userid = $request->session()->get('user_id');
            $usertype = $request->session()->get('user_type');
           // if(isset($userid) && isset($usertype)) {
                $report = new  FundUTMCContactPersonReportPDF;
                $report->run()
            ->export('FundUTMCContactPersonReportPdf')
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
            ->toBrowser("fundutmccontactpersonreport.pdf");
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
    public function getFundUTMCContactPersonLandscapePdf(Request $request)
    {
        try {
            $userid = $request->session()->get('user_id');
            $usertype = $request->session()->get('user_type');
           // if (isset($userid) && isset($usertype)) {
                $report = new  FundUTMCContactPersonReportPDF;
                $report->run()
            ->export('FundUTMCContactPersonReportPdf')
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
            ->toBrowser("fundutmccontactlandscapereport.pdf");
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
    public function getFundUTMCContactPersonExcel(Request $request)
    {
        try {
            $userid = $request->session()->get('user_id');
            $usertype = $request->session()->get('user_type');
           // if (isset($userid) && isset($usertype)) {
                $report = new  FundUTMCContactPersonReport;
                $report->run()
            ->exportToExcel('FundUTMCContactPersonReportExcel')
            ->toBrowser("fundutmccontact.xlsx");
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
    public function getFundNewspaperContactReport(Request $request)
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
                    $report = new FundNewspaperContactReport;
                    return $report->run()->render("FundNewspaperContactReport");
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
    public function getFundNewspaperContactPortraitPdf(Request $request)
    {
        try {
            $userid = $request->session()->get('user_id');
            $usertype = $request->session()->get('user_type');
           // if(isset($userid) && isset($usertype)) {
                $report = new  FundNewspaperContactReportPDF;
                $report->run()
            ->export('FundNewspaperContactReportPdf')
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
            ->toBrowser("fundnewspapercontactreport.pdf");
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
    public function getFundNewspaperContactLandscapePdf(Request $request)
    {
        try {
            $userid = $request->session()->get('user_id');
            $usertype = $request->session()->get('user_type');
           // if (isset($userid) && isset($usertype)) {
                $report = new  FundNewspaperContactReportPDF;
                $report->run()
            ->export('FundNewspaperContactReportPdf')
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
            ->toBrowser("fundnewspapercontactlandscapereport.pdf");
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
    public function getFundNewspaperContactExcel(Request $request)
    {
        try {
            $userid = $request->session()->get('user_id');
            $usertype = $request->session()->get('user_type');
           // if (isset($userid) && isset($usertype)) {
                $report = new  FundNewspaperContactReport;
                $report->run()
            ->exportToExcel('FundNewspaperContactReportExcel')
            ->toBrowser("fundnewspapercontact.xlsx");
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
    public function getFundEventLogReport(Request $request)
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
                    $report = new FundEventLogReport;
                    return $report->run()->render("FundEventLogReport");
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
    public function getFundEventLogPortraitPdf(Request $request)
    {
        try {
            $userid = $request->session()->get('user_id');
            $usertype = $request->session()->get('user_type');
          //  if(isset($userid) && isset($usertype)) {
                $report = new  FundEventLogReportPDF;
                $report->run()
            ->export('FundEventLogReportPdf')
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
            ->toBrowser("fundeventlogreport.pdf");
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
    public function getFundEventLogLandscapePdf(Request $request)
    {
        try {
            $userid = $request->session()->get('user_id');
            $usertype = $request->session()->get('user_type');
           // if (isset($userid) && isset($usertype)) {
                $report = new  FundEventLogReportPDF;
                $report->run()
            ->export('FundEventLogReportPdf')
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
            ->toBrowser("fundeventloglandscapereport.pdf");
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
    public function getFundEventLogExcel(Request $request)
    {
        try {
            $userid = $request->session()->get('user_id');
            $usertype = $request->session()->get('user_type');
           // if (isset($userid) && isset($usertype)) {
                $report = new  FundEventLogReport;
                $report->run()
            ->exportToExcel('FundEventLogReportExcel')
            ->toBrowser("fundeventlog.xlsx");
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
    public function getFundDataAllReport(Request $request)
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
                    $report = new FundDataAllReport;
                    return $report->run()->render("FundDataAllReport");
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
    public function getFundDataAllPortraitPdf(Request $request)
    {
        try {
            $userid = $request->session()->get('user_id');
            $usertype = $request->session()->get('user_type');
           // if(isset($userid) && isset($usertype)) {
                $report = new  FundDataAllReportPDF;
                $report->run()
            ->export('FundDataAllReportPdf')
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
            ->toBrowser("funddataallreport.pdf");
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
    public function getFundDataAllLandscapePdf(Request $request)
    {
        try {
            $userid = $request->session()->get('user_id');
            $usertype = $request->session()->get('user_type');
            //if (isset($userid) && isset($usertype)) {
                $report = new  FundDataAllReportPDF;
                $report->run()
            ->export('FundDataAllReportPdf')
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
            ->toBrowser("funddataalllandscapereport.pdf");
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
    public function getFundDataAllExcel(Request $request)
    {
        try {
            $userid = $request->session()->get('user_id');
            $usertype = $request->session()->get('user_type');
           // if (isset($userid) && isset($usertype)) {
                $report = new  FundDataAllReport;
                $report->run()
            ->exportToExcel('FundDataAllReportExcel')
            ->toBrowser("funddataall.xlsx");
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
    public function getFundAuditTrailReport(Request $request)
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
                    $report = new FundAuditTrailReport;
                    return $report->run()->render("FundAuditTrailReport");
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
    public function getAuditTrailExcel(Request $request)
    {
        try {
            $userid = $request->session()->get('user_id');
            $usertype = $request->session()->get('user_type');
           // if (isset($userid) && isset($usertype)) {
                $report = new  FundAuditTrailReport;
                $report->run()
            ->exportToExcel('FundAuditTrailReportExcel')
            ->toBrowser("fundaudittrail.xlsx");
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
    public function getFundNAVMovementReport(Request $request)
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
                    $report = new FundNAVMovementReport;
                    return $report->run()->render("FundNAVMovementReport");
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
}
