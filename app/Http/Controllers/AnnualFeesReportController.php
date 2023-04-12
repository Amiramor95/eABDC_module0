<?php
namespace App\Http\Controllers;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Http;
use Ixudra\Curl\Facades\Curl;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\Log;
use App\Reports\AmsfAumReport;
use App\Reports\AmsfAumReportPDF;
use App\Reports\AmsfGrossSaleReport;
use App\Reports\AmsfGrossSaleReportPDF;
use App\Reports\AmsfTotalSubmissionReport;
use App\Reports\AmsfTotalSubmissionReportPDF;
use App\Reports\AmsfSummaryUTMCReport;
use App\Reports\AmsfSummaryUTMCReportPDF;
use App\Reports\AmsfSummaryIUTAReport;
use App\Reports\AmsfSummaryIUTAReportPDF;
use App\Reports\AmsfSummaryUTMCPRPReport;
use App\Reports\AmsfSummaryUTMCPRPReportPDF;
use App\Reports\AmsfSummaryPRPReport;
use App\Reports\AmsfSummaryPRPReportPDF;
use App\Reports\AmsfSummaryIUTAIPRPReport;
use App\Reports\AmsfSummaryIUTAIPRPReportPDF;
use App\Reports\AmsfSummaryUTMCIPRPReport;
use App\Reports\AmsfSummaryUTMCIPRPReportPDF;
use App\Reports\AmsfSummaryCUTACPRAReport;
use App\Reports\AmsfSummaryCUTACPRAReportPDF;
use App\Reports\AmsfAUMTGSReport;
use App\Reports\AmsfAUMTGSReportPDF;
use App\Reports\AmsfA1FormDistributorReport;
use App\Reports\AmsfA1FormDistributorReportPDF;
use App\Reports\AmsfA2FormDistributorReport;
use App\Reports\AmsfA2FormDistributorReportPDF;
use App\Reports\AmsfB1FormDistributorReport;
use App\Reports\AmsfB1FormDistributorReportPDF;
use App\Reports\AmsfB2FormDistributorReport;
use App\Reports\AmsfB2FormDistributorReportPDF;
use App\Reports\AmsfC1FormDistributorReport;
use App\Reports\AmsfC1FormDistributorReportPDF;
use App\Reports\AmsfC2FormDistributorReport;
use App\Reports\AmsfC2FormDistributorReportPDF;
use App\Reports\AmsfD1FormDistributorReport;
use App\Reports\AmsfD1FormDistributorReportPDF;
use App\Reports\AmsfD2FormDistributorReport;
use App\Reports\AmsfD2FormDistributorReportPDF;
use App\Reports\AmsfAUMTGSDistributorReport;
use App\Reports\AmsfAUMTGSDistributorReportPDF;
use App\Reports\AmsfTOTALAUMReport;
use App\Reports\AmsfTOTALAUMReportPDF;
use App\Reports\AmsfTOTALSALESReport;
use App\Reports\AmsfTOTALSALESReportPDF;

class AnnualFeesReportController extends Controller
{
    public function getAmsfaumReport(Request $request)
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
                    $report = new AmsfAumReport;
                    return $report->run()->render("AmsfAumReport");
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
   
    public function getAmsfAumExcel(Request $request)
    {
        try {
            $userid = $request->session()->get('user_id');
            $usertype = $request->session()->get('user_type');
           // if (isset($userid) && isset($usertype)) {
                $report = new  AmsfAumReport;
                $report->run()
            ->exportToExcel('AmsfAumReportExcel')
            ->toBrowser("amsfaum.xlsx");
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
    public function getAmsfGrossSaleReport(Request $request)
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
                    $report = new AmsfGrossSaleReport;
                    return $report->run()->render("AmsfGrossSaleReport");
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
   
    public function getAmsfGrossSaleExcel(Request $request)
    {
        try {
            $userid = $request->session()->get('user_id');
            $usertype = $request->session()->get('user_type');
            //if (isset($userid) && isset($usertype)) {
                $report = new  AmsfGrossSaleReport;
                $report->run()
            ->exportToExcel('AmsfGrossSaleReportExcel')
            ->toBrowser("amsfgrosssale.xlsx");
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
    public function getAmsfTotalSubmissionReport(Request $request)
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
                    $report = new AmsfTotalSubmissionReport;
                    return $report->run()->render("AmsfTotalSubmissionReport");
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
   
    public function getAmsfTotalSubmissionExcel(Request $request)
    {
        try {
            $userid = $request->session()->get('user_id');
            $usertype = $request->session()->get('user_type');
           // if (isset($userid) && isset($usertype)) {
                $report = new  AmsfTotalSubmissionReport;
                $report->run()
            ->exportToExcel('AmsfTotalSubmissionReportExcel')
            ->toBrowser("amsftotalsubmission.xlsx");
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
    public function getAmsfSummaryUTMCReport(Request $request)
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
                    $report = new AmsfSummaryUTMCReport;
                    return $report->run()->render("AmsfSummaryUTMCReport");
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
   
    public function getAmsfSummaryUTMCExcel(Request $request)
    {
        try {
            $userid = $request->session()->get('user_id');
            $usertype = $request->session()->get('user_type');
           // if (isset($userid) && isset($usertype)) {
                $report = new  AmsfSummaryUTMCReport;
                $report->run()
            ->exportToExcel('AmsfSummaryUTMCReportExcel')
            ->toBrowser("amsfsummaryutmc.xlsx");
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
    public function getAmsfSummaryIUTAReport(Request $request)
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
                    $report = new AmsfSummaryIUTAReport;
                    return $report->run()->render("AmsfSummaryIUTAReport");
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
   
    public function getAmsfSummaryIUTAExcel(Request $request)
    {
        try {
            $userid = $request->session()->get('user_id');
            $usertype = $request->session()->get('user_type');
           // if (isset($userid) && isset($usertype)) {
                $report = new  AmsfSummaryIUTAReport;
                $report->run()
            ->exportToExcel('AmsfSummaryIUTAReportExcel')
            ->toBrowser("amsfsummaryiuta.xlsx");
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
    public function getAmsfSummaryUTMCPRPReport(Request $request)
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
                    $report = new AmsfSummaryUTMCPRPReport;
                    return $report->run()->render("AmsfSummaryUTMCPRPReport");
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
    public function getAmsfSummaryUTMCPRPExcel(Request $request)
    {
        try {
            $userid = $request->session()->get('user_id');
            $usertype = $request->session()->get('user_type');
           // if (isset($userid) && isset($usertype)) {
                $report = new  AmsfSummaryUTMCPRPReport;
                $report->run()
            ->exportToExcel('AmsfSummaryUTMCPRPReportExcel')
            ->toBrowser("amsfsummaryutmcprp.xlsx");
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
    public function getAmsfSummaryPRPReport(Request $request)
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
                    $report = new AmsfSummaryPRPReport;
                    return $report->run()->render("AmsfSummaryPRPReport");
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
    public function getAmsfSummaryPRPExcel(Request $request)
    {
        try {
            $userid = $request->session()->get('user_id');
            $usertype = $request->session()->get('user_type');
          //  if (isset($userid) && isset($usertype)) {
                $report = new  AmsfSummaryPRPReport;
                $report->run()
            ->exportToExcel('AmsfSummaryPRPReportExcel')
            ->toBrowser("amsfsummaryprp.xlsx");
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
    public function getAmsfSummaryIUTAIPRPReport(Request $request)
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
                    $report = new AmsfSummaryIUTAIPRPReport;
                    return $report->run()->render("AmsfSummaryIUTAIPRPReport");
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
    public function getAmsfSummaryIUTAIPRPExcel(Request $request)
    {
        try {
            $userid = $request->session()->get('user_id');
            $usertype = $request->session()->get('user_type');
            //if (isset($userid) && isset($usertype)) {
                $report = new  AmsfSummaryIUTAIPRPReport;
                $report->run()
            ->exportToExcel('AmsfSummaryIUTAIPRPReportExcel')
            ->toBrowser("amsfsummaryiutaiprp.xlsx");
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
    public function getAmsfSummaryUTMCIPRPReport(Request $request)
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
                    $report = new AmsfSummaryUTMCIPRPReport;
                    return $report->run()->render("AmsfSummaryUTMCIPRPReport");
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
    public function getAmsfSummaryUTMCIPRPExcel(Request $request)
    {
        try {
            $userid = $request->session()->get('user_id');
            $usertype = $request->session()->get('user_type');
           // if (isset($userid) && isset($usertype)) {
                $report = new  AmsfSummaryUTMCIPRPReport;
                $report->run()
            ->exportToExcel('AmsfSummaryUTMCIPRPReportExcel')
            ->toBrowser("amsfsummaryutmciprp.xlsx");
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
    public function getAmsfSummaryCUTACPRAReport(Request $request)
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
                //if ($userid == $requestuid && $usertype == $requestutype) {
                    $report = new AmsfSummaryCUTACPRAReport;
                    return $report->run()->render("AmsfSummaryCUTACPRAReport");
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
    public function getAmsfSummaryCUTACPRAExcel(Request $request)
    {
        try {
            $userid = $request->session()->get('user_id');
            $usertype = $request->session()->get('user_type');
           // if (isset($userid) && isset($usertype)) {
                $report = new  AmsfSummaryCUTACPRAReport;
                $report->run()
            ->exportToExcel('AmsfSummaryCUTACPRAReportExcel')
            ->toBrowser("amsfsummarycutacpra.xlsx");
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
    public function getAmsfAUMTGSReport(Request $request)
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
                    $report = new AmsfAUMTGSReport;
                    return $report->run()->render("AmsfAUMTGSReport");
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
    public function getAmsfAUMTGSExcel(Request $request)
    {
        try {
            $userid = $request->session()->get('user_id');
            $usertype = $request->session()->get('user_type');
            //if (isset($userid) && isset($usertype)) {
                $report = new  AmsfAUMTGSReport;
                $report->run()
            ->exportToExcel('AmsfAUMTGSReportExcel')
            ->toBrowser("amsfaumtgs.xlsx");
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
    public function getAmsfA1FormDistributorReport(Request $request)
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
                $distributorid=$paramstr[2];
               // if ($userid == $requestuid && $usertype == $requestutype) {
                    $report = new AmsfA1FormDistributorReport(array(
                        "DID"=>$distributorid
                    ));
                    return $report->run()->render("AmsfA1FormDistributorReport");
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
    public function getAmsfA1FormDistributorExcel(Request $request)
    {
        try {
             Log::info("Req =". $request);
            $userid = $request->session()->get('user_id');
            $usertype = $request->session()->get('user_type');
           // if (isset($userid) && isset($usertype)) {
                // $decode = base64_decode($request->q);
                // $paramstr= explode("/", $decode);
                // $requestuid=$paramstr[0];
                // $requestutype=$paramstr[1];
                 $distributorid=$request->DISTRIBUTORID;
                 $AMSFYEAR=$request->AMSFYEAR;
                $report = new AmsfA1FormDistributorReport(array(
                    "DID"=>$distributorid,
                    "AMSFYEAR"=>$AMSFYEAR
                ));
                $report->run()
            ->exportToExcel('AmsfA1FormDistributorReportExcel')
            ->toBrowser("amsfa1formdistributor.xlsx");
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
    public function getAmsfA2FormDistributorReport(Request $request)
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
                $distributorid=$paramstr[2];
               // if ($userid == $requestuid && $usertype == $requestutype) {
                    $report = new AmsfA2FormDistributorReport(array(
                        "DID"=>$distributorid
                    ));
                    return $report->run()->render("AmsfA2FormDistributorReport");
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
    public function getAmsfA2FormDistributorExcel(Request $request)
    {
        try {
            // Log::info("Req =". $request);
            $userid = $request->session()->get('user_id');
            $usertype = $request->session()->get('user_type');
          //  if (isset($userid) && isset($usertype)) {
                // $decode = base64_decode($request->q);
                // $paramstr= explode("/", $decode);
                // $requestuid=$paramstr[0];
                // $requestutype=$paramstr[1];
                 $distributorid=$request->DISTRIBUTORID;
                 $AMSFYEAR=$request->AMSFYEAR;
                $report = new AmsfA2FormDistributorReport(array(
                    "DID"=>$distributorid,
                    "AMSFYEAR"=>$AMSFYEAR
                ));
                $report->run()
            ->exportToExcel('AmsfA2FormDistributorReportExcel')
            ->toBrowser("amsfa2formdistributor.xlsx");
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
    public function getAmsfB1FormDistributorReport(Request $request)
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
                $distributorid=$paramstr[2];
               // if ($userid == $requestuid && $usertype == $requestutype) {
                    $report = new AmsfB1FormDistributorReport(array(
                        "DID"=>$distributorid
                    ));
                    return $report->run()->render("AmsfB1FormDistributorReport");
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
    public function getAmsfB1FormDistributorExcel(Request $request)
    {
        try {
             Log::info("Req =". $request);
            $userid = $request->session()->get('user_id');
            $usertype = $request->session()->get('user_type');
          //  if (isset($userid) && isset($usertype)) {
                // $decode = base64_decode($request->q);
                // $paramstr= explode("/", $decode);
                // $requestuid=$paramstr[0];
                // $requestutype=$paramstr[1];
                 $distributorid=$request->DISTRIBUTORID;
                 $AMSFYEAR=$request->AMSFYEAR;
                $report = new AmsfB1FormDistributorReport(array(
                    "DID"=>$distributorid,
                    "AMSFYEAR"=>$AMSFYEAR
                ));
                $report->run()
            ->exportToExcel('AmsfB1FormDistributorReportExcel')
            ->toBrowser("amsfb1formdistributor.xlsx");
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
    public function getAmsfB2FormDistributorReport(Request $request)
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
                $distributorid=$paramstr[2];
               // if ($userid == $requestuid && $usertype == $requestutype) {
                    $report = new AmsfB2FormDistributorReport(array(
                        "DID"=>$distributorid
                    ));
                    return $report->run()->render("AmsfB2FormDistributorReport");
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
    public function getAmsfB2FormDistributorExcel(Request $request)
    {
        try {
            // Log::info("Req =". $request);
            $userid = $request->session()->get('user_id');
            $usertype = $request->session()->get('user_type');
           // if (isset($userid) && isset($usertype)) {
                // $decode = base64_decode($request->q);
                // $paramstr= explode("/", $decode);
                // $requestuid=$paramstr[0];
                // $requestutype=$paramstr[1];
                 $distributorid=$request->DISTRIBUTORID;
                 $AMSFYEAR=$request->AMSFYEAR;
                $report = new AmsfB2FormDistributorReport(array(
                    "DID"=>$distributorid,
                    "AMSFYEAR"=>$AMSFYEAR
                ));
                $report->run()
            ->exportToExcel('AmsfB2FormDistributorReportExcel')
            ->toBrowser("amsfb2formdistributor.xlsx");
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
    public function getAmsfC1FormDistributorReport(Request $request)
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
                $distributorid=$paramstr[2];
                //if ($userid == $requestuid && $usertype == $requestutype) {
                    $report = new AmsfC1FormDistributorReport(array(
                        "DID"=>$distributorid
                    ));
                    return $report->run()->render("AmsfC1FormDistributorReport");
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
    public function getAmsfC1FormDistributorExcel(Request $request)
    {
        try {
           //  Log::info("Req =". $request);
            $userid = $request->session()->get('user_id');
            $usertype = $request->session()->get('user_type');
          //  if (isset($userid) && isset($usertype)) {
                // $decode = base64_decode($request->q);
                // $paramstr= explode("/", $decode);
                // $requestuid=$paramstr[0];
                // $requestutype=$paramstr[1];
                 $distributorid=$request->DISTRIBUTORID;
                 $AMSFYEAR=$request->AMSFYEAR;
                $report = new AmsfC1FormDistributorReport(array(
                    "DID"=>$distributorid,
                    "AMSFYEAR"=>$AMSFYEAR
                ));
                $report->run()
            ->exportToExcel('AmsfC1FormDistributorReportExcel')
            ->toBrowser("amsfc1formdistributor.xlsx");
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
    public function getAmsfC2FormDistributorReport(Request $request)
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
                $distributorid=$paramstr[2];
               // if ($userid == $requestuid && $usertype == $requestutype) {
                    $report = new AmsfC2FormDistributorReport(array(
                        "DID"=>$distributorid
                    ));
                    return $report->run()->render("AmsfC2FormDistributorReport");
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
    public function getAmsfC2FormDistributorExcel(Request $request)
    {
        try {
           // Log::info("Req =". $request);
            $userid = $request->session()->get('user_id');
            $usertype = $request->session()->get('user_type');
           // if (isset($userid) && isset($usertype)) {
                // $decode = base64_decode($request->q);
                // $paramstr= explode("/", $decode);
                // $requestuid=$paramstr[0];
                // $requestutype=$paramstr[1];
                 $distributorid=$request->DISTRIBUTORID;
                 $AMSFYEAR=$request->AMSFYEAR;
                $report = new AmsfC2FormDistributorReport(array(
                    "DID"=>$distributorid,
                    "AMSFYEAR"=>$AMSFYEAR
                ));
                $report->run()
            ->exportToExcel('AmsfC2FormDistributorReportExcel')
            ->toBrowser("amsfc2formdistributor.xlsx");
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
    public function getAmsfD1FormDistributorReport(Request $request)
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
                $distributorid=$paramstr[2];
               // if ($userid == $requestuid && $usertype == $requestutype) {
                    $report = new AmsfD1FormDistributorReport(array(
                        "DID"=>$distributorid
                    ));
                    return $report->run()->render("AmsfD1FormDistributorReport");
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
    public function getAmsfD1FormDistributorExcel(Request $request)
    {
        try {
            // Log::info("Req =". $request);
            $userid = $request->session()->get('user_id');
            $usertype = $request->session()->get('user_type');
            //if (isset($userid) && isset($usertype)) {
                // $decode = base64_decode($request->q);
                // $paramstr= explode("/", $decode);
                // $requestuid=$paramstr[0];
                // $requestutype=$paramstr[1];
                 $distributorid=$request->DISTRIBUTORID;
                 $AMSFYEAR=$request->AMSFYEAR;
                $report = new AmsfD1FormDistributorReport(array(
                    "DID"=>$distributorid,
                    "AMSFYEAR"=>$AMSFYEAR
                ));
                $report->run()
            ->exportToExcel('AmsfD1FormDistributorReportExcel')
            ->toBrowser("amsfd1formdistributor.xlsx");
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
    public function getAmsfD2FormDistributorReport(Request $request)
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
                $distributorid=$paramstr[2];
               // if ($userid == $requestuid && $usertype == $requestutype) {
                    $report = new AmsfD2FormDistributorReport(array(
                        "DID"=>$distributorid
                    ));
                    return $report->run()->render("AmsfD2FormDistributorReport");
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
    public function getAmsfD2FormDistributorExcel(Request $request)
    {
        try {
            // Log::info("Req =". $request);
            $userid = $request->session()->get('user_id');
            $usertype = $request->session()->get('user_type');
           // if (isset($userid) && isset($usertype)) {
                // $decode = base64_decode($request->q);
                // $paramstr= explode("/", $decode);
                // $requestuid=$paramstr[0];
                // $requestutype=$paramstr[1];
                 $distributorid=$request->DISTRIBUTORID;
                 $AMSFYEAR=$request->AMSFYEAR;
                $report = new AmsfD2FormDistributorReport(array(
                    "DID"=>$distributorid,
                    "AMSFYEAR"=>$AMSFYEAR
                ));
                $report->run()
            ->exportToExcel('AmsfD2FormDistributorReportExcel')
            ->toBrowser("amsfd2formdistributor.xlsx");
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
    public function getAmsfAUMTGSDistributorReport(Request $request)
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
                    $report = new AmsfAUMTGSDistributorReport;
                    return $report->run()->render("AmsfAUMTGSDistributorReport");
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
    public function getAmsfAUMTGSDistributorExcel(Request $request)
    {
        try {
            $userid = $request->session()->get('user_id');
            $usertype = $request->session()->get('user_type');
           // if (isset($userid) && isset($usertype)) {
                $report = new  AmsfAUMTGSDistributorReport;
                $report->run()
            ->exportToExcel('AmsfAUMTGSDistributorReportExcel')
            ->toBrowser("amsfaumtgsdistributor.xlsx");
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
    public function getAmsfTotalAUMReport(Request $request)
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
                    $report = new AmsfTOTALAUMReport;
                    return $report->run()->render("AmsfTOTALAUMReport");
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
    public function getAmsfTotalAUMExcel(Request $request)
    {
        try {
            $userid = $request->session()->get('user_id');
            $usertype = $request->session()->get('user_type');
           // if (isset($userid) && isset($usertype)) {
                $report = new  AmsfTOTALAUMReport;
                $report->run()
            ->exportToExcel('AmsfTOTALAUMReportExcel')
            ->toBrowser("amsftotalaum.xlsx");
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
    public function getAmsfTotalSALESReport(Request $request)
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
                    $report = new AmsfTOTALSALESReport;
                    return $report->run()->render("AmsfTOTALSALESReport");
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
    public function getAmsfTotalSALESExcel(Request $request)
    {
        try {
            $userid = $request->session()->get('user_id');
            $usertype = $request->session()->get('user_type');
           // if (isset($userid) && isset($usertype)) {
                $report = new  AmsfTOTALSALESReport;
                $report->run()
            ->exportToExcel('AmsfTOTALSALESReportExcel')
            ->toBrowser("amsftotalsales.xlsx");
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
