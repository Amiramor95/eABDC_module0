<?php
namespace App\Http\Controllers;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Http;
use Ixudra\Curl\Facades\Curl;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\Log;
use App\Reports\ConsultantDetailReport;
use App\Reports\ConsultantDetailReportPDF;
use App\Reports\ConsultantRegistrationReport;
use App\Reports\ConsultantRegistrationReportPDF;
use App\Reports\ConsultantRegistrationSummaryReport;
use App\Reports\ConsultantRegistrationSummaryReportPDF;
use App\Reports\ConsultantTerminationReport;
use App\Reports\ConsultantTerminationReportPDF;
use App\Reports\ConsultantTerminationSummaryReport;
use App\Reports\ConsultantTerminationSummaryReportPDF;
use App\Reports\ConsultantActiveReport;
use App\Reports\ConsultantActiveReportPDF;
use App\Reports\ConsultantActiveSummaryReport;
use App\Reports\ConsultantActiveSummaryReportPDF;
use App\Reports\ConsultantBankruptcyReport;
use App\Reports\ConsultantBankruptcyReportPDF;


class ConsultantManagementReportController extends Controller
{
    public function getConsultantDetailReportReport(Request $request)
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
                    $report = new ConsultantDetailReport;
                    return $report->run()->render("ConsultantDetailReport");
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
    public function getConsultantDetailPortraitPdf(Request $request)
    {
        try {
            $userid = $request->session()->get('user_id');
            $usertype = $request->session()->get('user_type');
            //if(isset($userid) && isset($usertype)) {
                $report = new  ConsultantDetailReportPDF;
                $report->run()
            ->export('ConsultantDetailReportPdf')
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
            ->toBrowser("consultantdetailreport.pdf");
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
    public function getConsultantDetailLandscapePdf(Request $request)
    {
        try {
            $userid = $request->session()->get('user_id');
            $usertype = $request->session()->get('user_type');
            //if (isset($userid) && isset($usertype)) {
                $report = new  ConsultantDetailReportPDF;
                $report->run()
            ->export('ConsultantDetailReportPdf')
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
            ->toBrowser("consultantdetaillandscapereport.pdf");
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
    public function getConsultantDetailExcel(Request $request)
    {
        try {
            $userid = $request->session()->get('user_id');
            $usertype = $request->session()->get('user_type');
           // if (isset($userid) && isset($usertype)) {
                $report = new  ConsultantDetailReport;
                $report->run()
            ->exportToExcel('ConsultantDetailReportExcel')
            ->toBrowser("consultantdetail.xlsx");
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
    public function getConsultantRegistrationReport(Request $request)
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
                    $report = new ConsultantRegistrationReport;
                    return $report->run()->render("ConsultantRegistrationReport");
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
    public function getConsultantRegistrationPortraitPdf(Request $request)
    {
        try {
            $userid = $request->session()->get('user_id');
            $usertype = $request->session()->get('user_type');
           // if(isset($userid) && isset($usertype)) {
                $report = new  ConsultantRegistrationReportPDF;
                $report->run()
            ->export('ConsultantRegistrationReportPdf')
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
            ->toBrowser("consultantregistrationreport.pdf");
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
    public function getConsultantRegistrationLandscapePdf(Request $request)
    {
        try {
            $userid = $request->session()->get('user_id');
            $usertype = $request->session()->get('user_type');
            //if (isset($userid) && isset($usertype)) {
                $report = new  ConsultantRegistrationReportPDF;
                $report->run()
            ->export('ConsultantRegistrationReportPdf')
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
            ->toBrowser("consultantregistrationlandscapereport.pdf");
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
    public function getConsultantRegistrationExcel(Request $request)
    {
        try {
            $userid = $request->session()->get('user_id');
            $usertype = $request->session()->get('user_type');
            //if (isset($userid) && isset($usertype)) {
                $report = new  ConsultantRegistrationReport;
                $report->run()
            ->exportToExcel('ConsultantRegistrationReportExcel')
            ->toBrowser("consultantregistration.xlsx");
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
    public function getConsultantRegistrationSummaryReport(Request $request)
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
                    $report = new ConsultantRegistrationSummaryReport;
                    return $report->run()->render("ConsultantRegistrationSummaryReport");
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
    public function getConsultantRegistrationSummaryPortraitPdf(Request $request)
    {
        try {
            $userid = $request->session()->get('user_id');
            $usertype = $request->session()->get('user_type');
            //if(isset($userid) && isset($usertype)) {
                $report = new  ConsultantRegistrationSummaryReportPDF;
                $report->run()
            ->export('ConsultantRegistrationSummaryReportPdf')
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
            ->toBrowser("consultantregistrationsummaryreport.pdf");
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
    public function getConsultantRegistrationSummaryLandscapePdf(Request $request)
    {
        try {
            $userid = $request->session()->get('user_id');
            $usertype = $request->session()->get('user_type');
           // if (isset($userid) && isset($usertype)) {
                $report = new  ConsultantRegistrationSummaryReportPDF;
                $report->run()
            ->export('ConsultantRegistrationSummaryReportPdf')
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
            ->toBrowser("consultantregistrationsummarylandscapereport.pdf");
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
    public function getConsultantRegistrationSummaryExcel(Request $request)
    {
        try {
            $userid = $request->session()->get('user_id');
            $usertype = $request->session()->get('user_type');
           // if (isset($userid) && isset($usertype)) {
                $report = new  ConsultantRegistrationSummaryReport;
                $report->run()
            ->exportToExcel('ConsultantRegistrationSummaryReportExcel')
            ->toBrowser("consultantregistrationsummary.xlsx");
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
    public function getConsultantTerminationReport(Request $request)
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
                    $report = new ConsultantTerminationReport;
                    return $report->run()->render("ConsultantTerminationReport");
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
    public function getConsultantTerminationPortraitPdf(Request $request)
    {
        try {
            $userid = $request->session()->get('user_id');
            $usertype = $request->session()->get('user_type');
           // if(isset($userid) && isset($usertype)) {
                $report = new  ConsultantTerminationReportPDF;
                $report->run()
            ->export('ConsultantTerminationReportPdf')
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
            ->toBrowser("consultantterminationreport.pdf");
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
    public function getConsultantTerminationLandscapePdf(Request $request)
    {
        try {
            $userid = $request->session()->get('user_id');
            $usertype = $request->session()->get('user_type');
           // if (isset($userid) && isset($usertype)) {
                $report = new  ConsultantTerminationReportPDF;
                $report->run()
            ->export('ConsultantTerminationReportPdf')
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
            ->toBrowser("consultantterminationlandscapereport.pdf");
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
    public function getConsultantTerminationExcel(Request $request)
    {
        try {
            $userid = $request->session()->get('user_id');
            $usertype = $request->session()->get('user_type');
           // if (isset($userid) && isset($usertype)) {
                $report = new  ConsultantTerminationReport;
                $report->run()
            ->exportToExcel('ConsultantTerminationReportExcel')
            ->toBrowser("consultanttermination.xlsx");
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
    public function getConsultantTerminationSummaryReport(Request $request)
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
                    $report = new ConsultantTerminationSummaryReport;
                    return $report->run()->render("ConsultantTerminationSummaryReport");
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
    public function getConsultantTerminationSummaryPortraitPdf(Request $request)
    {
        try {
            $userid = $request->session()->get('user_id');
            $usertype = $request->session()->get('user_type');
            //if(isset($userid) && isset($usertype)) {
                $report = new  ConsultantTerminationSummaryReportPDF;
                $report->run()
            ->export('ConsultantTerminationSummaryReportPdf')
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
            ->toBrowser("consultantterminationsummaryreport.pdf");
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
    public function getConsultantTerminationSummaryLandscapePdf(Request $request)
    {
        try {
            $userid = $request->session()->get('user_id');
            $usertype = $request->session()->get('user_type');
            //if (isset($userid) && isset($usertype)) {
                $report = new  ConsultantTerminationSummaryReportPDF;
                $report->run()
            ->export('ConsultantTerminationSummaryReportPdf')
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
            ->toBrowser("consultantterminationsummlandscapereport.pdf");
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
    public function getConsultantTerminationSummaryExcel(Request $request)
    {
        try {
            $userid = $request->session()->get('user_id');
            $usertype = $request->session()->get('user_type');
           // if (isset($userid) && isset($usertype)) {
                $report = new  ConsultantTerminationSummaryReport;
                $report->run()
            ->exportToExcel('ConsultantTerminationSummaryReportExcel')
            ->toBrowser("consultantterminationsummary.xlsx");
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
    public function getConsultantActiveReport(Request $request)
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
                    $report = new ConsultantActiveReport;
                    return $report->run()->render("ConsultantActiveReport");
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
    public function getConsultantActivePortraitPdf(Request $request)
    {
        try {
            $userid = $request->session()->get('user_id');
            $usertype = $request->session()->get('user_type');
           // if(isset($userid) && isset($usertype)) {
                $report = new  ConsultantActiveReportPDF;
                $report->run()
            ->export('ConsultantActiveReportPdf')
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
            ->toBrowser("consultantactivereport.pdf");
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
    public function getConsultantActiveLandscapePdf(Request $request)
    {
        try {
            $userid = $request->session()->get('user_id');
            $usertype = $request->session()->get('user_type');
           // if (isset($userid) && isset($usertype)) {
                $report = new  ConsultantActiveReportPDF;
                $report->run()
            ->export('ConsultantActiveReportPdf')
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
            ->toBrowser("consultantactivelandscapereport.pdf");
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
    public function getConsultantActiveExcel(Request $request)
    {
        try {
            $userid = $request->session()->get('user_id');
            $usertype = $request->session()->get('user_type');
            //if (isset($userid) && isset($usertype)) {
                $report = new  ConsultantActiveReport;
                $report->run()
            ->exportToExcel('ConsultantActiveReportExcel')
            ->toBrowser("consultantactive.xlsx");
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
    public function getConsultantActiveSummaryReport(Request $request)
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
                    $report = new ConsultantActiveSummaryReport;
                    return $report->run()->render("ConsultantActiveSummaryReport");
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
    public function getConsultantActiveSummaryPortraitPdf(Request $request)
    {
        try {
            $userid = $request->session()->get('user_id');
            $usertype = $request->session()->get('user_type');
           // if(isset($userid) && isset($usertype)) {
                $report = new  ConsultantActiveSummaryReportPDF;
                $report->run()
            ->export('ConsultantActiveSummaryReportPdf')
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
            ->toBrowser("consultantactivesummaryreport.pdf");
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
    public function getConsultantActiveSummaryLandscapePdf(Request $request)
    {
        try {
            $userid = $request->session()->get('user_id');
            $usertype = $request->session()->get('user_type');
           // if (isset($userid) && isset($usertype)) {
                $report = new  ConsultantActiveSummaryReportPDF;
                $report->run()
            ->export('ConsultantActiveSummaryReportPdf')
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
            ->toBrowser("consultantactivesummarylandscapereport.pdf");
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
    public function getConsultantActiveSummaryExcel(Request $request)
    {
        try {
            $userid = $request->session()->get('user_id');
            $usertype = $request->session()->get('user_type');
           // if (isset($userid) && isset($usertype)) {
                $report = new  ConsultantActiveSummaryReport;
                $report->run()
            ->exportToExcel('ConsultantActiveSummaryReportExcel')
            ->toBrowser("consultantactivesummary.xlsx");
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
    public function getConsultantBankruptcyReport(Request $request)
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
                    $report = new ConsultantBankruptcyReport;
                    return $report->run()->render("ConsultantBankruptcyReport");
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
