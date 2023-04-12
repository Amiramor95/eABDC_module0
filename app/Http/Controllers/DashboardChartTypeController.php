<?php
namespace App\Http\Controllers;

use App\Models\DashboardChartType;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Ixudra\Curl\Facades\Curl;
use Validator;
use DB;
use Illuminate\Support\Facades\Log;
use App\Reports\CasUtcReport;
use App\Reports\CasUtcReportPDF;
use App\Reports\CasEnquiryReport;
use App\Reports\CasEnquiryReportPDF;
use App\Reports\CasComplainFimm;
use App\Reports\CasComplainFimmPDF;
use App\Reports\CasSanctionedReport;
use App\Reports\CasSanctionedReportPDF;
use Illuminate\Support\Facades\Auth;

class DashboardChartTypeController extends Controller
{
    public function get(Request $request)
    {
        try {
            $data = DashboardChartType::all();

            http_response_code(200);
            return response([
                'message' => 'Data successfully retrieved.',
                'data' => $data
            ]);
        } catch (RequestException $r) {
            http_response_code(400);
            return response([
                'message' => 'Failed to retrieve data.',
                'errorCode' => 4103
            ], 400);
        }
    }
    public function getCasUtcTaggingListReport(Request $request)
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
                    $report = new CasUtcReport;
                    return $report->run()->render("CasUtcReport");
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
    public function getCasUtcTaggingListPdfReport(Request $request)
    {
        try {
            $userid = $request->session()->get('user_id');
            $usertype = $request->session()->get('user_type');
           // if (isset($userid) && isset($usertype)) {
                $report = new  CasUtcReportPDF;
                $report->run()
            ->export('CasUtcReportPdf')
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
            ->toBrowser("utcportraitreport.pdf");
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
    public function getCasUtcTaggingListPdfReportLandscape(Request $request)
    {
        try {
            $userid = $request->session()->get('user_id');
            $usertype = $request->session()->get('user_type');
            //if (isset($userid) && isset($usertype)) {
                $report = new  CasUtcReportPDF;
                $report->run()
            ->export('CasUtcReportPdf')
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
            ->toBrowser("utclandscapereport.pdf");
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
    public function getCasUtcExcel(Request $request)
    {
        try {
            $userid = $request->session()->get('user_id');
            $usertype = $request->session()->get('user_type');
           // if (isset($userid) && isset($usertype)) {
                $report = new  CasUtcReport;
                $report->run()
            ->exportToExcel('CasUtcReportExcel')
            ->toBrowser("casutcexcel.xlsx");
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
    public function getCasEnquiryReport(Request $request)
    {
        try {
            $userid = $request->session()->get('user_id');
            $usertype = $request->session()->get('user_type');
            //if (isset($userid) && isset($usertype)) {
                $decode = base64_decode($request->q);
                $paramstr= explode("/", $decode);
                $requestuid=$paramstr[0];
                $requestutype=$paramstr[1];
               // if ($userid == $requestuid && $usertype == $requestutype) {
                    $report = new CasEnquiryReport;
                    return $report->run()->render("CasEnquiryReport");
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
    public function getCasEnquiryPortraitPdf(Request $request)
    {
        try {
            $userid = $request->session()->get('user_id');
            $usertype = $request->session()->get('user_type');
           // if (isset($userid) && isset($usertype)) {
                $report = new  CasEnquiryReportPDF;
                $report->run()
            ->export('CasEnquiryReportPdf')
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
            ->toBrowser("enquiryportraitreport.pdf");
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
    public function getCasEnquiryLandscapePdf(Request $request)
    {
        try {
            $userid = $request->session()->get('user_id');
            $usertype = $request->session()->get('user_type');
            //if (isset($userid) && isset($usertype)) {
                $report = new  CasEnquiryReportPDF;
                $report->run()
            ->export('CasEnquiryReportPdf')
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
            ->toBrowser("enquirylandscapereport.pdf");
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
    public function getCasEnquiryExcel(Request $request)
    {
        try {
            $userid = $request->session()->get('user_id');
            $usertype = $request->session()->get('user_type');
           // if (isset($userid) && isset($usertype)) {
                $report = new  CasEnquiryReport;
                $report->run()
            ->exportToExcel('CasEnquiryReportExcel')
            ->toBrowser("casenquiryexcel.xlsx");
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
    public function getComplainByFimm(Request $request)
    {
        try {
            $userid = $request->session()->get('user_id');
            $usertype = $request->session()->get('user_type');
           // if (isset($userid) && isset($usertype)) {
                $decode = base64_decode($request->q);
                $paramstr= explode("/", $decode);
                $requestuid=$paramstr[0];
                $requestutype=$paramstr[1];
               // if ($userid == $requestuid && $usertype == $requestutype) {
                    $report = new CasComplainFimm;
                    return $report->run()->render("CasComplainFimm");
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
    public function getCasComplainPortraitPdf(Request $request)
    {
        try {
            $userid = $request->session()->get('user_id');
            $usertype = $request->session()->get('user_type');
           // if (isset($userid) && isset($usertype)) {
                $report = new  CasComplainFimmPDF;
                $report->run()
            ->export('CasComplainFimmPdf')
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
            ->toBrowser("complainportraitreport.pdf");
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
    public function getCasComplainLandscapePdf(Request $request)
    {
        try {
            $userid = $request->session()->get('user_id');
            $usertype = $request->session()->get('user_type');
            //if (isset($userid) && isset($usertype)) {
                $report = new  CasComplainFimmPDF;
                $report->run()
            ->export('CasComplainFimmPdf')
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
            ->toBrowser("complainlandscapereport.pdf");
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
    public function getCasComplainFimmExcel(Request $request)
    {
        try {
            $userid = $request->session()->get('user_id');
            $usertype = $request->session()->get('user_type');
            //if (isset($userid) && isset($usertype)) {
                $report = new  CasComplainFimm;
                $report->run()
            ->exportToExcel('CasComplainFimmExcel')
            ->toBrowser("cascomplainexcel.xlsx");
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
    public function getSanctionedByFimm(Request $request)
    {
        try {
            $userid = $request->session()->get('user_id');
            $usertype = $request->session()->get('user_type');
            //if (isset($userid) && isset($usertype)) {
                $decode = base64_decode($request->q);
                $paramstr= explode("/", $decode);
                $requestuid=$paramstr[0];
                $requestutype=$paramstr[1];
               // if ($userid == $requestuid && $usertype == $requestutype) {
                    $report = new CasSanctionedReport;
                    return $report->run()->render("CasSanctionedReport");
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
    public function getCasSanctionedPortraitPdf(Request $request)
    {
        try {
            $userid = $request->session()->get('user_id');
            $usertype = $request->session()->get('user_type');
           // if (isset($userid) && isset($usertype)) {
                $report = new  CasSanctionedReportPDF;
                $report->run()
            ->export('CasSanctionedReportPdf')
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
            ->toBrowser("sanctionedportraitreport.pdf");
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
    public function getCasSanctionedLandscapePdf(Request $request)
    {
        try {
            $userid = $request->session()->get('user_id');
            $usertype = $request->session()->get('user_type');
           // if (isset($userid) && isset($usertype)) {
                $report = new  CasSanctionedReportPDF;
                $report->run()
            ->export('CasSanctionedReportPdf')
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
            ->toBrowser("sanctionedlandscapereport.pdf");
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
    public function getCasSanctionedReportExcel(Request $request)
    {
        try {
            $userid = $request->session()->get('user_id');
            $usertype = $request->session()->get('user_type');
           // if (isset($userid) && isset($usertype)) {
                $report = new  CasSanctionedReport;
                $report->run()
            ->exportToExcel('CasSanctionedReportExcel')
            ->toBrowser("cassanctionedexcel.xlsx");
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
    public function getCasFileDownload(Request $request)
    {
      //  Log::info("DownloadId =". $request->templateId);
        try {
       // Log::info("DownloadId =". $request->templateId);
        $userid = $request->session()->get('user_id');
        $usertype = $request->session()->get('user_type');
       // if (isset($userid) && isset($usertype)) {
          //  Log::info("Enter =". $request->templateId);
          $data= DB::table('consultantAlert_management.CA_DOCUMENT AS CA_DOCUMENT')
          ->select('*')
                ->where('CA_DOCUMENT.CA_DOCUMENT_ID',$request->fileId)
                ->first();

               // $file_contents = base64_decode($data->FILE_BLOB);
                $file_contents = $data->DOC_BLOB;

                return response($file_contents)
                    ->header('Cache-Control', 'no-cache private')
                    ->header('Content-Description', 'File Transfer')
                    ->header('Content-Type', $data->DOC_MIMETYPE)
                    ->header('Content-length', strlen($file_contents))
                    ->header('Content-Disposition', 'attachment; filename=' . $data->DOC_ORIGINAL_NAME)
                    ->header('Content-Transfer-Encoding', 'binary');
       //}
    } catch (RequestException $r) {
        http_response_code(400);
        return response([
        'message' => 'Failed to retrieve data.',
        'errorCode' => 4103
        ], 400);
    }
    }
}
