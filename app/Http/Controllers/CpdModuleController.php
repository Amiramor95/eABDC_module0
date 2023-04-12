<?php

namespace App\Http\Controllers;

use App\Models\CpdModule;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Log;
use Ixudra\Curl\Facades\Curl;
use App\Reports\CpdProgramSecretariatReport;
use App\Reports\CpdProgramSecretariatPDF;
use App\Reports\CpdProgramRepeatedReport;
use App\Reports\CpdProgramRepeatedReportPDF;
use App\Reports\CpdEvaluationReport;
use App\Reports\CpdEvaluationReportPDF;
use App\Reports\CpdFpamConsultant;
use App\Reports\CpdFpamConsultantReport;
use App\Reports\CpdFpamConsultantReportPDF;
use App\Reports\CpdAcademicConsultant;
use App\Reports\CpdAcademicConsultantReport;
use App\Reports\CpdAcademicConsultantReportPDF;
use App\Reports\CpdReadingConsultant;
use App\Reports\CpdReadingConsultantReport;
use App\Reports\CpdReadingConsultantReportPDF;
use App\Reports\CpdTeachingConsultant;
use App\Reports\CpdTeachingConsultantReport;
use App\Reports\CpdTeachingConsultantReportPDF;
use App\Reports\CpdWaiverConsultant;
use App\Reports\CpdWaiverConsultantReport;
use App\Reports\CpdWaiverConsultantReportPDF;
use App\Reports\CpdWritingConsultant;
use App\Reports\CpdWritingConsultantReport;
use App\Reports\CpdWritingConsultantReportPDF;
use App\Reports\CpdRecordConsultant;
use App\Reports\CpdRecordConsultantReport;
use App\Reports\CpdRecordParticipant;
use App\Reports\CpdRecordParticipantReport;
use App\Reports\CpdRecordParticipantReportPDF;

class CpdModuleController extends Controller
{
    public function get($id)
    {
        try {
            $data = App\Models\CpdModule::find($id);

            http_response_code(200);
            return response([
                'message' => 'Data successfully retrieved.',
                'data' => $data
            ]);
        } catch (RequestException $r) {

            http_response_code(400);
            return response([
                'message' => 'Failed to retrieve data.', 
                'errorCode' => 0
            ]);
        }
    }

    public function getAll()
    {
        try {
            $data = CpdModule::all();

            http_response_code(200);
            return response([
                'message' => 'All data successfully retrieved.',
                'data' => $data
            ]);
        } catch (RequestException $r) {

            http_response_code(400);
            return response([
                'message' => 'Failed to retrieve all data.', 
                'errorCode' => 0
            ]);
        }
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'test' => 'required|string' //test
        ]);

        try {
            //create function

            http_response_code(200);
            return response([
                'message' => 'Data successfully updated.'
            ]);

        } catch (RequestException $r) {

            http_response_code(400);
            return response([
                'message' => 'Data failed to be updated.',
                'errorCode' => 0
            ]);
        }

    }

    public function update($id)
    {
        $validator = Validator::make($request->all(), [
            'test' => 'required|string' //test
        ]);

        try {
            //update function

            http_response_code(200);
            return response([
                'message' => '',
                'data' => ''
            ]);

        } catch (RequestException $r) {

            http_response_code(400);
            return response([
                'message' => '',
                'errorCode' => 0,
            ]);
        }
    }

    public function delete($id)
    {
        try {

            $data = CpdModule::find($id);
            $data->delete();

            http_response_code(200);
            return response([
                'message' => 'Data successfully deleted.'
            ]);

        } catch (RequestException $r) {

            http_response_code(400);
            return response([
                'message' => 'Data failed to be deleted.',
                'errorCode' => 0
            ]);
        }
    }
    public function getCPDProgramSecretariatReport(Request $request)
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
                    $report = new CpdProgramSecretariatReport;
                    return $report->run()->render("CpdProgramSecretariatReport");
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
    public function getCPDProgramSecretariatPortraitPdf(Request $request)
    {
        try {
            $userid = $request->session()->get('user_id');
            $usertype = $request->session()->get('user_type');
            //if (isset($userid) && isset($usertype)) {
                $report = new  CpdProgramSecretariatPDF;
                $report->run()
            ->export('CpdProgramSecretariatReportPdf')
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
            ->toBrowser("cpdprogramportraitreport.pdf");
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
    public function getCPDProgramSecretariatLandscapePdf(Request $request)
    {
        try {
            $userid = $request->session()->get('user_id');
            $usertype = $request->session()->get('user_type');
            //if (isset($userid) && isset($usertype)) {
                $report = new  CpdProgramSecretariatPDF;
                $report->run()
            ->export('CpdProgramSecretariatReportPdf')
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
            ))
            ->toBrowser("cpdprogramlandscapereport.pdf");
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
    public function getCPDProgramSecretariatExcel(Request $request)
    {
        try {
            $userid = $request->session()->get('user_id');
            $usertype = $request->session()->get('user_type');
            //if (isset($userid) && isset($usertype)) {
                $report = new  CpdProgramSecretariatReport;
                $report->run()
            ->exportToExcel('CpdProgramSecretariatReportExcel')
            ->toBrowser("cpdprogramsecretariat.xlsx");
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
    public function getCPDProgramRepeatedReport(Request $request)
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
                    $report = new CpdProgramRepeatedReport;
                    return $report->run()->render("CpdProgramRepeatedReport");
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
    public function getCPDProgramRepeatedPortraitPdf(Request $request)
    {
        try {
            $userid = $request->session()->get('user_id');
            $usertype = $request->session()->get('user_type');
           // if (isset($userid) && isset($usertype)) {
                $report = new  CpdProgramRepeatedReportPDF;
                $report->run()
            ->export('CpdProgramRepeatedReportPdf')
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
            ->toBrowser("cpdprogramprepeatedortraitreport.pdf");
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
    public function getCPDProgramRepeatedLandscapePdf(Request $request)
    {
        try {
            $userid = $request->session()->get('user_id');
            $usertype = $request->session()->get('user_type');
          //  if (isset($userid) && isset($usertype)) {
                $report = new  CpdProgramRepeatedReportPDF;
                $report->run()
            ->export('CpdProgramRepeatedReportPdf')
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
            ->toBrowser("cpdprogramrepeatedlandscapereport.pdf");
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
    public function getCPDProgramRepeatedExcel(Request $request)
    {
        try {
            $userid = $request->session()->get('user_id');
            $usertype = $request->session()->get('user_type');
           // if (isset($userid) && isset($usertype)) {
                $report = new  CpdProgramRepeatedReport;
                $report->run()
            ->exportToExcel('CpdProgramRepeatedReportExcel')
            ->toBrowser("cpdprogramrepeated.xlsx");
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
    public function getCPDEvaluationReport(Request $request)
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
                    $report = new CpdEvaluationReport;
                    return $report->run()->render("CpdEvaluationReport");
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
    public function getCPDEvaluationPortraitPdf(Request $request)
    {
        try {
            $userid = $request->session()->get('user_id');
            $usertype = $request->session()->get('user_type');
            //if (isset($userid) && isset($usertype)) {
                $report = new  CpdEvaluationReportPDF;
                $report->run()
            ->export('CpdEvaluationReportPdf')
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
            ->toBrowser("cpdevaluationportraitreport.pdf");
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
    public function getCPDEvaluationLandscapePdf(Request $request)
    {
        try {
            $userid = $request->session()->get('user_id');
            $usertype = $request->session()->get('user_type');
            //if (isset($userid) && isset($usertype)) {
                $report = new  CpdEvaluationReportPDF;
                $report->run()
            ->export('CpdEvaluationReportPdf')
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
            ))
            ->toBrowser("cpdevaluationreport.pdf");
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
    public function getCPDEvaluationExcel(Request $request)
    {
        try {
            $userid = $request->session()->get('user_id');
            $usertype = $request->session()->get('user_type');
           // if (isset($userid) && isset($usertype)) {
                $report = new  CpdEvaluationReport;
                $report->run()
            ->exportToExcel('CpdEvaluationReportExcel')
            ->toBrowser("cpdevaluation.xlsx");
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
    public function getCPDFpamConsultant(Request $request)
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
                    $report = new CpdFpamConsultant;
                    return $report->run()->render("CpdFpamConsultant");
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
    public function getCPDFpamConsultantReport(Request $request)
    {
       // Log::info("Req =". $request->q);
        try {
            $userid = $request->session()->get('user_id');
            $usertype = $request->session()->get('user_type');
            //if (isset($userid) && isset($usertype)) {
                $decode = base64_decode($request->q);
                $paramstr= explode("/", $decode);
               // Log::info("Req1 =". $paramstr[2]);
                $requestuid=$paramstr[0];
                $requestutype=$paramstr[1];
                $consultantid=$paramstr[2];
               // if ($userid == $requestuid && $usertype == $requestutype) {
                    $report = new CpdFpamConsultantReport(array(
                        "CID"=>$consultantid
                    ));
                    return $report->run()->render("CpdFpamConsultantReport");
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
    public function getCPDFpamConsultantPortraitPdf(Request $request)
    {
        try {
            $userid = $request->session()->get('user_id');
            $usertype = $request->session()->get('user_type');
            //if (isset($userid) && isset($usertype)) {
                $consultantid=$request->consultantid;
                $report = new CpdFpamConsultantReportPDF(array(
                    "CID"=>$consultantid
                ));
                $report->run()
            ->export('CpdFpamConsultantReportPdf')
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
            ->toBrowser("cpdfpamreport.pdf");
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
    public function getCPDFpamConsultantLandscapePdf(Request $request)
    {
        try {
            $userid = $request->session()->get('user_id');
            $usertype = $request->session()->get('user_type');
           // if (isset($userid) && isset($usertype)) {
                $consultantid=$request->consultantid;
                $report = new CpdFpamConsultantReportPDF(array(
                    "CID"=>$consultantid
                ));
                $report->run()
            ->export('CpdProgramRepeatedReportPdf')
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
            ->toBrowser("cpdfpamreport.pdf");
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
    public function getCPDFpamExcel(Request $request)
    {
        try {
            $userid = $request->session()->get('user_id');
            $usertype = $request->session()->get('user_type');
          //  if (isset($userid) && isset($usertype)) {
                $consultantid=$request->consultantid;
                $report = new CpdFpamConsultantReport(array(
                    "CID"=>$consultantid
                ));
                $report->run()
            ->exportToExcel('CpdFpamConsultantReportExcel')
            ->toBrowser("cpdfpam.xlsx");
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
    public function getCPDAcademicConsultant(Request $request)
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
                    $report = new CpdAcademicConsultant;
                    return $report->run()->render("CpdAcademicConsultant");
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
    public function getCPDAcademicConsultantReport(Request $request)
    {
       // Log::info("Req =". $request->q);
        try {
            $userid = $request->session()->get('user_id');
            $usertype = $request->session()->get('user_type');
           // if (isset($userid) && isset($usertype)) {
                $decode = base64_decode($request->q);
                $paramstr= explode("/", $decode);
               // Log::info("Req1 =". $paramstr[2]);
                $requestuid=$paramstr[0];
                $requestutype=$paramstr[1];
                $consultantid=$paramstr[2];
               // if ($userid == $requestuid && $usertype == $requestutype) {
                    $report = new CpdAcademicConsultantReport(array(
                        "CID"=>$consultantid
                    ));
                    return $report->run()->render("CpdAcademicConsultantReport");
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
    public function getCPDAcademicConsultantPortraitPdf(Request $request)
    {
        try {
            $userid = $request->session()->get('user_id');
            $usertype = $request->session()->get('user_type');
            //if (isset($userid) && isset($usertype)) {
                $consultantid=$request->consultantid;
                $report = new CpdAcademicConsultantReportPDF(array(
                    "CID"=>$consultantid
                ));
                $report->run()
            ->export('CpdAcademicConsultantReportPdf')
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
            ->toBrowser("cpdacademicreport.pdf");
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
    public function getCPDAcademicConsultantLandscapePdf(Request $request)
    {
        try {
            $userid = $request->session()->get('user_id');
            $usertype = $request->session()->get('user_type');
           // if (isset($userid) && isset($usertype)) {
                $consultantid=$request->consultantid;
                $report = new CpdAcademicConsultantReportPDF(array(
                    "CID"=>$consultantid
                ));
                $report->run()
            ->export('CpdAcademicConsultantReportPdf')
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
            ->toBrowser("cpdacademiclandreport.pdf");
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
    public function getCPDAcademicExcel(Request $request)
    {
        try {
            $userid = $request->session()->get('user_id');
            $usertype = $request->session()->get('user_type');
           // if (isset($userid) && isset($usertype)) {
                $consultantid=$request->consultantid;
                $report = new CpdAcademicConsultantReport(array(
                    "CID"=>$consultantid
                ));
                $report->run()
            ->exportToExcel('CpdAcademicConsultantReportExcel')
            ->toBrowser("cpdacademic.xlsx");
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
    public function getCPDReadingConsultant(Request $request)
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
                    $report = new CpdReadingConsultant;
                    return $report->run()->render("CpdReadingConsultant");
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
    public function getCPDReadingConsultantReport(Request $request)
    {
       // Log::info("Req =". $request->q);
        try {
            $userid = $request->session()->get('user_id');
            $usertype = $request->session()->get('user_type');
            //if (isset($userid) && isset($usertype)) {
                $decode = base64_decode($request->q);
                $paramstr= explode("/", $decode);
               // Log::info("Req1 =". $paramstr[2]);
                $requestuid=$paramstr[0];
                $requestutype=$paramstr[1];
                $consultantid=$paramstr[2];
                //if ($userid == $requestuid && $usertype == $requestutype) {
                    $report = new CpdReadingConsultantReport(array(
                        "CID"=>$consultantid
                    ));
                    return $report->run()->render("CpdReadingConsultantReport");
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
    public function getCPDReadingConsultantPortraitPdf(Request $request)
    {
        try {
            $userid = $request->session()->get('user_id');
            $usertype = $request->session()->get('user_type');
           // if (isset($userid) && isset($usertype)) {
                $consultantid=$request->consultantid;
                $report = new CpdReadingConsultantReportPDF(array(
                    "CID"=>$consultantid
                ));
                $report->run()
            ->export('CpdReadingConsultantReportPdf')
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
            ->toBrowser("cpdreadingreport.pdf");
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
    public function getCPDReadingConsultantLandscapePdf(Request $request)
    {
        try {
            $userid = $request->session()->get('user_id');
            $usertype = $request->session()->get('user_type');
           // if (isset($userid) && isset($usertype)) {
                $consultantid=$request->consultantid;
                $report = new CpdReadingConsultantReportPDF(array(
                    "CID"=>$consultantid
                ));
                $report->run()
            ->export('CpdReadingConsultantReportPdf')
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
            ->toBrowser("cpdreadinglandreport.pdf");
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
    public function getCPDReadingExcel(Request $request)
    {
        try {
            $userid = $request->session()->get('user_id');
            $usertype = $request->session()->get('user_type');
           // if (isset($userid) && isset($usertype)) {
                $consultantid=$request->consultantid;
                $report = new CpdReadingConsultantReport(array(
                    "CID"=>$consultantid
                ));
                $report->run()
            ->exportToExcel('CpdReadingConsultantReportExcel')
            ->toBrowser("cpdreading.xlsx");
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
    public function getCPDTeachingConsultant(Request $request)
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
                    $report = new CpdTeachingConsultant;
                    return $report->run()->render("CpdTeachingConsultant");
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
    public function getCPDTeachingConsultantReport(Request $request)
    {
       // Log::info("Req =". $request->q);
        try {
            $userid = $request->session()->get('user_id');
            $usertype = $request->session()->get('user_type');
            //if (isset($userid) && isset($usertype)) {
                $decode = base64_decode($request->q);
                $paramstr= explode("/", $decode);
               // Log::info("Req1 =". $paramstr[2]);
                $requestuid=$paramstr[0];
                $requestutype=$paramstr[1];
                $consultantid=$paramstr[2];
                //if ($userid == $requestuid && $usertype == $requestutype) {
                    $report = new CpdTeachingConsultantReport(array(
                        "CID"=>$consultantid
                    ));
                    return $report->run()->render("CpdTeachingConsultantReport");
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
    public function getCPDTeachingConsultantPortraitPdf(Request $request)
    {
        try {
            $userid = $request->session()->get('user_id');
            $usertype = $request->session()->get('user_type');
            //if (isset($userid) && isset($usertype)) {
                $consultantid=$request->consultantid;
                $report = new CpdTeachingConsultantReportPDF(array(
                    "CID"=>$consultantid
                ));
                $report->run()
            ->export('CpdTeachingConsultantReportPdf')
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
            ->toBrowser("cpdteachingreport.pdf");
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
    public function getCPDTeachingConsultantLandscapePdf(Request $request)
    {
        try {
            $userid = $request->session()->get('user_id');
            $usertype = $request->session()->get('user_type');
            //if (isset($userid) && isset($usertype)) {
                $consultantid=$request->consultantid;
                $report = new CpdTeachingConsultantReportPDF(array(
                    "CID"=>$consultantid
                ));
                $report->run()
            ->export('CpdTeachingConsultantReportPdf')
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
            ->toBrowser("cpdteachinglandreport.pdf");
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
    public function getCPDTeachingExcel(Request $request)
    {
        try {
            $userid = $request->session()->get('user_id');
            $usertype = $request->session()->get('user_type');
           // if (isset($userid) && isset($usertype)) {
                $consultantid=$request->consultantid;
                $report = new CpdTeachingConsultantReport(array(
                    "CID"=>$consultantid
                ));
                $report->run()
            ->exportToExcel('CpdTeachingConsultantReportExcel')
            ->toBrowser("cpdteaching.xlsx");
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
    public function getCPDWaiverConsultant(Request $request)
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
                if ($userid == $requestuid && $usertype == $requestutype) {
                    $report = new CpdWaiverConsultant;
                    return $report->run()->render("CpdWaiverConsultant");
                }
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
    public function getCPDWaiverConsultantReport(Request $request)
    {
       // Log::info("Req =". $request->q);
        try {
            $userid = $request->session()->get('user_id');
            $usertype = $request->session()->get('user_type');
           // if (isset($userid) && isset($usertype)) {
                $decode = base64_decode($request->q);
                $paramstr= explode("/", $decode);
               // Log::info("Req1 =". $paramstr[2]);
                $requestuid=$paramstr[0];
                $requestutype=$paramstr[1];
                $consultantid=$paramstr[2];
               // if ($userid == $requestuid && $usertype == $requestutype) {
                    $report = new CpdWaiverConsultantReport(array(
                        "CID"=>$consultantid
                    ));
                    return $report->run()->render("CpdWaiverConsultantReport");
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
    public function getCPDWaiverConsultantPortraitPdf(Request $request)
    {
        try {
            $userid = $request->session()->get('user_id');
            $usertype = $request->session()->get('user_type');
           // if (isset($userid) && isset($usertype)) {
                $consultantid=$request->consultantid;
                $report = new CpdWaiverConsultantReportPDF(array(
                    "CID"=>$consultantid
                ));
                $report->run()
            ->export('CpdWaiverConsultantReportPdf')
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
            ->toBrowser("cpdwaiverreport.pdf");
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
    public function getCPDWaiverConsultantLandscapePdf(Request $request)
    {
        try {
            $userid = $request->session()->get('user_id');
            $usertype = $request->session()->get('user_type');
            //if (isset($userid) && isset($usertype)) {
                $consultantid=$request->consultantid;
                $report = new CpdWaiverConsultantReportPDF(array(
                    "CID"=>$consultantid
                ));
                $report->run()
            ->export('CpdWaiverConsultantReportPdf')
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
            ->toBrowser("cpdwaiverlandreport.pdf");
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
    public function getCPDWaiverExcel(Request $request)
    {
        try {
            $userid = $request->session()->get('user_id');
            $usertype = $request->session()->get('user_type');
           // if (isset($userid) && isset($usertype)) {
                $consultantid=$request->consultantid;
                $report = new CpdWaiverConsultantReport(array(
                    "CID"=>$consultantid
                ));
                $report->run()
            ->exportToExcel('CpdWaiverConsultantReportExcel')
            ->toBrowser("cpdwaiver.xlsx");
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
    public function getCPDWritingConsultant(Request $request)
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
                    $report = new CpdWritingConsultant;
                    return $report->run()->render("CpdWritingConsultant");
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
    public function getCPDWritingConsultantReport(Request $request)
    {
       // Log::info("Req =". $request->q);
        try {
            $userid = $request->session()->get('user_id');
            $usertype = $request->session()->get('user_type');
           // if (isset($userid) && isset($usertype)) {
                $decode = base64_decode($request->q);
                $paramstr= explode("/", $decode);
               // Log::info("Req1 =". $paramstr[2]);
                $requestuid=$paramstr[0];
                $requestutype=$paramstr[1];
                $consultantid=$paramstr[2];
                //if ($userid == $requestuid && $usertype == $requestutype) {
                    $report = new CpdWritingConsultantReport(array(
                        "CID"=>$consultantid
                    ));
                    return $report->run()->render("CpdWritingConsultantReport");
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
    public function getCPDWritingConsultantPortraitPdf(Request $request)
    {
        try {
            $userid = $request->session()->get('user_id');
            $usertype = $request->session()->get('user_type');
            //if (isset($userid) && isset($usertype)) {
                $consultantid=$request->consultantid;
                $report = new CpdWritingConsultantReportPDF(array(
                    "CID"=>$consultantid
                ));
                $report->run()
            ->export('CpdWritingConsultantReportPdf')
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
            ->toBrowser("cpdwritingreport.pdf");
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
    public function getCPDWritingConsultantLandscapePdf(Request $request)
    {
        try {
            $userid = $request->session()->get('user_id');
            $usertype = $request->session()->get('user_type');
           // if (isset($userid) && isset($usertype)) {
                $consultantid=$request->consultantid;
                $report = new CpdWritingConsultantReportPDF(array(
                    "CID"=>$consultantid
                ));
                $report->run()
            ->export('CpdWritingConsultantReportPdf')
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
            ->toBrowser("cpdwritinglandreport.pdf");
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
    public function getCPDWritingExcel(Request $request)
    {
        try {
            $userid = $request->session()->get('user_id');
            $usertype = $request->session()->get('user_type');
            //if (isset($userid) && isset($usertype)) {
                $consultantid=$request->consultantid;
                $report = new CpdWritingConsultantReport(array(
                    "CID"=>$consultantid
                ));
                $report->run()
            ->exportToExcel('CpdWritingConsultantReportExcel')
            ->toBrowser("cpdwriting.xlsx");
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
    public function getCPDRecordConsultant(Request $request)
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
                    $report = new CpdRecordConsultant;
                    return $report->run()->render("CpdRecordConsultant");
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
    public function getCPDRecordConsultantReport(Request $request)
    {
       // Log::info("Req =". $request->q);
        try {
            $userid = $request->session()->get('user_id');
            $usertype = $request->session()->get('user_type');
            //if (isset($userid) && isset($usertype)) {
                $decode = base64_decode($request->q);
                $paramstr= explode("/", $decode);
               // Log::info("Req1 =". $paramstr[2]);
                $requestuid=$paramstr[0];
                $requestutype=$paramstr[1];
                $consultantid=$paramstr[2];
                //if ($userid == $requestuid && $usertype == $requestutype) {
                    $report = new CpdRecordConsultantReport(array(
                        "CID"=>$consultantid
                    ));
                    return $report->run()->render("CpdRecordConsultantReport");
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
    public function getCPDRecordConsultantPortraitPdf(Request $request)
    {
        try {
            $userid = $request->session()->get('user_id');
            $usertype = $request->session()->get('user_type');
            //if (isset($userid) && isset($usertype)) {
                $consultantid=$request->consultantid;
                $report = new CpdRecordConsultantReportPDF(array(
                    "CID"=>$consultantid
                ));
                $report->run()
            ->export('CpdRecordConsultantReportPdf')
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
            ->toBrowser("cpdconsultantreport.pdf");
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
    public function getCPDRecordConsultantLandscapePdf(Request $request)
    {
        try {
            $userid = $request->session()->get('user_id');
            $usertype = $request->session()->get('user_type');
          //  if (isset($userid) && isset($usertype)) {
                $consultantid=$request->consultantid;
                $report = new CpdRecordConsultantReportPDF(array(
                    "CID"=>$consultantid
                ));
                $report->run()
            ->export('CpdRecordConsultantReportPdf')
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
            ->toBrowser("cpdconsultantlandreport.pdf");
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
    public function getCPDRecordConsultantExcel(Request $request)
    {
        try {
            $userid = $request->session()->get('user_id');
            $usertype = $request->session()->get('user_type');
            //if (isset($userid) && isset($usertype)) {
                $consultantid=$request->consultantid;
                $report = new CpdRecordConsultantReport(array(
                    "CID"=>$consultantid
                ));
                $report->run()
            ->exportToExcel('CpdRecordConsultantReportExcel')
            ->toBrowser("cpdrecordconsultant.xlsx");
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
    public function getCPDRecord(Request $request)
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
                    $report = new CpdRecordParticipant;
                    return $report->run()->render("CpdRecordParticipant");
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
    public function getCPDRecordParticipantReport(Request $request)
    {
       // Log::info("Req =". $request->q);
        try {
            $userid = $request->session()->get('user_id');
            $usertype = $request->session()->get('user_type');
           // if (isset($userid) && isset($usertype)) {
                $decode = base64_decode($request->q);
                $paramstr= explode("/", $decode);
               // Log::info("Req1 =". $paramstr[2]);
                $requestuid=$paramstr[0];
                $requestutype=$paramstr[1];
                $consultantid=$paramstr[2];
                //if ($userid == $requestuid && $usertype == $requestutype) {
                    $report = new CpdRecordParticipantReport(array(
                        "CID"=>$consultantid
                    ));
                    return $report->run()->render("CpdRecordParticipantReport");
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
    public function getCPDRecordPortraitPdf(Request $request)
    {
        try {
            $userid = $request->session()->get('user_id');
            $usertype = $request->session()->get('user_type');
           // if (isset($userid) && isset($usertype)) {
                $consultantid=$request->consultantid;
                $report = new CpdRecordParticipantReportPDF(array(
                    "CID"=>$consultantid
                ));
                $report->run()
            ->export('CpdRecordParticipantReportPdf')
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
            ->toBrowser("cpdparticipantreport.pdf");
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
    public function getCPDRecordLandscapePdf(Request $request)
    {
        try {
            $userid = $request->session()->get('user_id');
            $usertype = $request->session()->get('user_type');
            //if (isset($userid) && isset($usertype)) {
                $consultantid=$request->consultantid;
                $report = new CpdRecordParticipantReportPDF(array(
                    "CID"=>$consultantid
                ));
                $report->run()
            ->export('CpdRecordParticipantReportPdf')
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
            ->toBrowser("cpdparticipantlandreport.pdf");
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
    public function getCPDRecordExcel(Request $request)
    {
        try {
            $userid = $request->session()->get('user_id');
            $usertype = $request->session()->get('user_type');
            //if (isset($userid) && isset($usertype)) {
                $consultantid=$request->consultantid;
                $report = new CpdRecordParticipantReport(array(
                    "CID"=>$consultantid
                ));
                $report->run()
            ->exportToExcel('CpdRecordParticipantReportExcel')
            ->toBrowser("cpdparticipant.xlsx");
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
