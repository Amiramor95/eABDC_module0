<?php

namespace App\Http\Controllers;

use App\Models\ManageRequiredDocument;
use App\Models\SettingGeneral;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Ixudra\Curl\Facades\Curl;
use Validator;
use DB;
use Illuminate\Support\Facades\Log;

class ManageRequiredDocumentController extends Controller
{
    public function get(Request $request)
    {
        try {
            $query = ManageRequiredDocument::all();
            if ($query->isEmpty()) {
                http_response_code(200);
                return response([
                    'message' => 'Table empty.',
                    'data' => ([
                        'list' => []
                    ])
                ], 200);
            } else {
                $query = ManageRequiredDocument::select('*');
                $query->join('MANAGE_SUBMODULE', 'MANAGE_SUBMODULE.MANAGE_SUBMODULE_ID', '=', 'MANAGE_REQUIRED_DOCUMENT.MANAGE_SUBMODULE_ID');

                $filter = ManageRequiredDocument::select('MANAGE_SUBMODULE.MANAGE_SUBMODULE_ID', 'MANAGE_SUBMODULE.SUBMOD_NAME', 'CREATE_TIMESTAMP', 'SETTING_GENERAL.SETTING_GENERAL_ID', 'SETTING_GENERAL.SET_PARAM')
                    ->join('MANAGE_SUBMODULE', 'MANAGE_SUBMODULE.MANAGE_SUBMODULE_ID', '=', 'MANAGE_REQUIRED_DOCUMENT.MANAGE_SUBMODULE_ID')
                    ->join('SETTING_GENERAL', 'SETTING_GENERAL.SETTING_GENERAL_ID', '=', 'MANAGE_REQUIRED_DOCUMENT.REQ_DOCU_TYPE');
                $filter->groupBy('MANAGE_SUBMODULE_ID', 'MANAGE_SUBMODULE.SUBMOD_NAME', 'CREATE_TIMESTAMP', 'SETTING_GENERAL.SET_PARAM', 'SETTING_GENERAL.SETTING_GENERAL_ID');
                $dataFilter = $filter->latest('CREATE_TIMESTAMP')->first();

                // $query->where('MANAGE_SUBMODULE.MANAGE_SUBMODULE_ID', $dataFilter->MANAGE_SUBMODULE_ID);
                // $query->where('REQ_DOCU_TYPE', $dataFilter->SETTING_GENERAL_ID);

                $data = $query->get();
                http_response_code(200);
                return response([
                    'message' => 'Data successfully retrieved.',
                    'data' => ([
                        'dataFilter' => $dataFilter,
                        'list' => $data
                    ])
                ]);
            }
        } catch (RequestException $r) {

            http_response_code(400);
            return response([
                'message' => 'Failed to retrieve data.',
                'errorCode' => 4103
            ], 400);
        }
    }

    public function getById(Request $request)
    {
        try {
            $data = ManageRequiredDocument::find($request->MANAGE_REQUIRED_DOCUMENT_ID);

            http_response_code(200);
            return response([
                'message' => 'All data successfully retrieved.',
                'data' => $data
            ]);
        } catch (RequestException $r) {
            http_response_code(400);
            return response([
                'message' => 'Failed to retrieve all data.',
                'errorCode' => $r
            ], 400);
        }
    }
    public function getEditDataById(Request $request)
    {
        // select `managedoc`.`*,submodule`.* from `admin_management`.`MANAGE_REQUIRED_DOCUMENT` as `managedoc` left join `admin_management`.`MANAGE_SUBMODULE` as `submodule` on `managedoc`.`MANAGE_SUBMODULE_ID` = `submodule`.`MANAGE_SUBMODULE_ID` where `managedoc`.`MANAGE_REQUIRED_DOCUMENT_ID` = 40 limit 1) {"exception":"[object] (Illuminate\\Database\\QueryException(code: 42S02): SQLSTATE[42S02]: Base table or view not found: 1051 Unknown table 'managedoc.*,submodule' (SQL: select `managedoc`.`*,submodule`.* from `admin_management`.`MANAGE_REQUIRED_DOCUMENT` as `managedoc` left join `admin_management`.`MANAGE_SUBMODULE` as `submodule` on `managedoc`.`MANAGE_SUBMODULE_ID` = `submodule`.`MANAGE_SUBMODULE_ID` where `managedoc`.`MANAGE_REQUIRED_DOCUMENT_ID` = 40 limit 1
        try {
            //$data = ManageRequiredDocument::find($request->MANAGE_REQUIRED_DOCUMENT_ID);
            Log::info("ManageData Data ===>" . $request);
            $data = DB::table('admin_management.MANAGE_REQUIRED_DOCUMENT AS managedoc')
                ->select('managedoc.*', 'submodule.SUBMOD_NAME as SUBNAME', 'settype.SET_PARAM as docTypeName')
                ->leftJoin('admin_management.MANAGE_SUBMODULE AS submodule', 'managedoc.MANAGE_SUBMODULE_ID', '=', 'submodule.MANAGE_SUBMODULE_ID')
                ->leftJoin('SETTING_GENERAL AS settype', 'settype.SETTING_GENERAL_ID', '=', 'managedoc.REQ_DOCU_TYPE')
                //  ->leftJoin('SETTING_GENERAL AS COUNTRY', 'STATE.SET_VALUE', '=', 'COUNTRY.SETTING_GENERAL_ID')
                ->where('managedoc.MANAGE_REQUIRED_DOCUMENT_ID', $request->MANAGE_REQUIRED_DOCUMENT_ID)
                ->first();
            //dd($data);

            http_response_code(200);
            return response([
                'message' => 'All data successfully retrieved.',
                'data' => $data
            ]);
        } catch (RequestException $r) {
            http_response_code(400);
            return response([
                'message' => 'Failed to retrieve all data.',
                'errorCode' => $r
            ], 400);
        }
    }

    public function getSubModule()
    {
        try {
            $subModule = ManageRequiredDocument::select('MANAGE_SUBMODULE.MANAGE_SUBMODULE_ID', 'MANAGE_SUBMODULE.SUBMOD_NAME');
            $subModule->join('MANAGE_SUBMODULE', 'MANAGE_SUBMODULE.MANAGE_SUBMODULE_ID', '=', 'MANAGE_REQUIRED_DOCUMENT.MANAGE_SUBMODULE_ID');
            $subModule->groupBy('MANAGE_SUBMODULE_ID', 'MANAGE_SUBMODULE.SUBMOD_NAME');
            $data = $subModule->get();

            http_response_code(200);
            return response([
                'message' => 'All data successfully retrieved.',
                'data' => $data
            ]);
        } catch (RequestException $r) {

            http_response_code(400);
            return response([
                'message' => 'Failed to retrieve all data.',
                'errorCode' => $r
            ], 400);
        }
    }

    public function getDocType()
    {
        try {
            $docType = SettingGeneral::select('SETTING_GENERAL_ID', 'SET_TYPE', 'SET_PARAM')->where('SET_TYPE', 'DOCUMENTCHECKLIST');
            $data = $docType->get();

            http_response_code(200);
            return response([
                'message' => 'All data successfully retrieved.',
                'data' => $data
            ]);
        } catch (RequestException $r) {

            http_response_code(400);
            return response([
                'message' => 'Failed to retrieve all data.',
                'errorCode' => 4103
            ], 400);
        }
    }

    public function getAll()
    {
        try {
            // $data = ManageRequiredDocument::all();

            $data = DB::table('admin_management.MANAGE_REQUIRED_DOCUMENT AS managedoc')
                ->select('managedoc.*', 'submodule.SUBMOD_NAME as SUBNAME', 'settype.SET_PARAM as docTypeName')
                ->leftJoin('admin_management.MANAGE_SUBMODULE AS submodule', 'managedoc.MANAGE_SUBMODULE_ID', '=', 'submodule.MANAGE_SUBMODULE_ID')
                ->leftJoin('SETTING_GENERAL AS settype', 'settype.SETTING_GENERAL_ID', '=', 'managedoc.REQ_DOCU_TYPE')
                ->get();

            http_response_code(200);
            return response([
                'message' => 'All data successfully retrieved.',
                'data' => $data
            ]);
        } catch (RequestException $r) {

            http_response_code(400);
            return response([
                'message' => 'Failed to retrieve all data.',
                'errorCode' => 4103
            ], 400);
        }
    }

    public function getDocumentProposalFile(Request $request)
    {
        try {
            $dataRaw = ManageRequiredDocument::where('REQ_DOCU_TYPE', 1)
                // ->select('MANAGE_REQUIRED_DOCUMENT_ID','MANAGE_SUBMODULE_ID','REQ_DOCU_TYPE','REQ_DOCU_SECTION','REQ_DOCU_NAME','REQ_DOCU_STATUS','REQ_DOCU_INDEX')
                ->select('*')
                ->where('MANAGE_SUBMODULE_ID', $request->MANAGE_SUBMODULE_ID)
                ->leftJoin('distributor_management.DISTRIBUTOR_DOCUMENT as distDoc', 'distDoc.REQ_DOCU_ID', '=', 'MANAGE_REQUIRED_DOCUMENT_ID')
                // ->join('distributor_management.DISTRIBUTOR_APPROVAL_DOCUMENT as dist_appr_doc', 'dist_appr_doc.DIST_DOC_ID', '=', 'distDoc.DIST_DOCU_ID')
                ->where('distDoc.DIST_ID', $request->DISTRIBUTOR_ID)
                ->get();

            foreach ($dataRaw as $docs) {
                $docs->DOCU_BLOB = base64_encode($docs->DOCU_BLOB);
            }

            $data = ManageRequiredDocument::select('REQ_DOCU_SECTION')->where('REQ_DOCU_TYPE', 1)
                ->where('MANAGE_SUBMODULE_ID', $request->MANAGE_SUBMODULE_ID)
                ->groupBy('REQ_DOCU_SECTION')
                ->get();

            foreach ($data as $item) {
                $document = array();
                foreach ($dataRaw as $element) {
                    if ($item->REQ_DOCU_SECTION === $element->REQ_DOCU_SECTION) {
                        $document[] = $element;
                    }
                    $element->setFileRecords([]);
                    $element->setFileRecordsForUpload([]);
                    $element->DOCU_REMARK = null;
                }
                $item->list = $document;
            }
            http_response_code(200);
            return response([
                'message' => 'Data successfully retrieved.',
                'data' => ([
                    'dataProposal' => $data,
                ]),
            ]);
        } catch (RequestException $r) {
            http_response_code(400);
            return response([
                'message' => 'Failed to retrieve data.',
                'errorCode' => 4103
            ], 400);
        }
    }
    public function getDocumentRequired(Request $request)
    {
        try {
            $dataAdditional = ManageRequiredDocument::where('REQ_DOCU_TYPE', 2)
                ->where('MANAGE_SUBMODULE_ID', $request->MANAGE_SUBMODULE_ID)
                ->leftJoin('distributor_management.DISTRIBUTOR_DOCUMENT as distDoc', 'distDoc.REQ_DOCU_ID', '=', 'MANAGE_REQUIRED_DOCUMENT_ID')
                ->where('DIST_ID', $request->DISTRIBUTOR_ID)
                ->get();

            foreach ($dataAdditional as $docs) {
                $docs->DOCU_BLOB = base64_encode($docs->DOCU_BLOB);
                $docs->setFileRecords([]);
                $docs->setFileRecordsForUpload([]);
                $docs->DOCU_REMARK = null;
            }
            http_response_code(200);
            return response([
                'message' => 'Data successfully retrieved.',
                'data' => ([
                    'dataAdditional' => $dataAdditional,
                ]),
            ]);
        } catch (RequestException $r) {
            http_response_code(400);
            return response([
                'message' => 'Failed to retrieve data.',
                'errorCode' => 4103
            ], 400);
        }
    }

    public function getDocumentAdditional(Request $request)
    {
        try {
            $data = ManageRequiredDocument::where('REQ_DOCU_TYPE', $request->REQ_DOCU_TYPE)
                ->where('MANAGE_SUBMODULE_ID', $request->MANAGE_SUBMODULE_ID)
                ->leftJoin('distributor_management.DISTRIBUTOR_DOCUMENT as distDoc', 'distDoc.REQ_DOCU_ID', '=', 'MANAGE_REQUIRED_DOCUMENT_ID')
                ->get();
        } catch (RequestException $r) {

            http_response_code(400);
            return response([
                'message' => 'Failed to retrieve data.',
                'errorCode' => 4103
            ], 400);
        }
    }

    public function getDocumentProposal(Request $request)
    {
        try {
            DB::enableQueryLog();
            $dataRaw = ManageRequiredDocument::where('REQ_DOCU_TYPE', $request->REQ_DOCU_TYPE)
                ->select('MANAGE_REQUIRED_DOCUMENT_ID', 'MANAGE_SUBMODULE_ID', 'REQ_DOCU_TYPE', 'REQ_DOCU_SECTION', 'REQ_DOCU_NAME', 'REQ_DOCU_STATUS', 'REQ_DOCU_INDEX')
                // ->select('*')
                // ->where('MANAGE_SUBMODULE_ID', $request->MANAGE_SUBMODULE_ID)
                // ->leftJoin('distributor_management.DISTRIBUTOR_DOCUMENT as distDoc', 'distDoc.REQ_DOCU_ID','=','MANAGE_REQUIRED_DOCUMENT_ID')
                // ->join('distributor_management.DISTRIBUTOR_APPROVAL_DOCUMENT as dist_appr_doc', 'dist_appr_doc.DIST_DOC_ID', '=', 'distDoc.DIST_DOCU_ID')
                // ->where('distDoc.DIST_ID', $request->DISTRIBUTOR_ID)
                ->get();

            foreach ($dataRaw as $docs) {
                $docs->DOCU_BLOB = base64_encode($docs->DOCU_BLOB);
            }

            $data = ManageRequiredDocument::select('REQ_DOCU_SECTION')->where('REQ_DOCU_TYPE', $request->REQ_DOCU_TYPE)
                ->where('MANAGE_SUBMODULE_ID', $request->MANAGE_SUBMODULE_ID)
                ->groupBy('REQ_DOCU_SECTION')
                ->get();

            foreach ($data as $item) {
                $document = array();
                foreach ($dataRaw as $element) {
                    if ($item->REQ_DOCU_SECTION === $element->REQ_DOCU_SECTION) {
                        $document[] = $element;
                    }
                    $element->setFileRecords([]);
                    $element->setFileRecordsForUpload([]);
                    $element->DOCU_REMARK = null;
                }
                $item->list = $document;
            }

            $dataAdditional = ManageRequiredDocument::where('REQ_DOCU_TYPE', 2)
                ->where('MANAGE_SUBMODULE_ID', $request->MANAGE_SUBMODULE_ID)
                // ->leftJoin('distributor_management.DISTRIBUTOR_DOCUMENT as distDoc', 'distDoc.REQ_DOCU_ID', '=', 'MANAGE_REQUIRED_DOCUMENT_ID')
                // ->join('distributor_management.DISTRIBUTOR_APPROVAL_DOCUMENT as dist_appr_doc', 'dist_appr_doc.DIST_DOC_ID', '=', 'distDoc.DIST_DOCU_ID')
                // ->where('DIST_ID', $request->DISTRIBUTOR_ID)
                ->get();

            foreach ($dataAdditional as $docs) {
                $docs->DOCU_BLOB = base64_encode($docs->DOCU_BLOB);
                $docs->setFileRecords([]);
                $docs->setFileRecordsForUpload([]);
                $docs->DOCU_REMARK = null;
            }
            // dd(DB::getQueryLog());

            http_response_code(200);
            return response([
                'message' => 'Data successfully retrieved.',
                'data' => ([
                    'dataProposal' => $data,
                    'dataAdditional' => $dataAdditional
                ]),
            ]);
        } catch (RequestException $r) {

            http_response_code(400);
            return response([
                'message' => 'Failed to retrieve data.',
                'errorCode' => 4103
            ], 400);
        }
    }

    public function getDocumentDataReview(Request $request)
    {
        try {
            //return $request->all();
            //DB::enableQueryLog();

            $ditst_id = $request->DISTRIBUTOR_ID;
            $apprv_id = $request->DIST_APPROVAL_ID;
            $dataRaw = DB::table('admin_management.MANAGE_REQUIRED_DOCUMENT AS REQDOC')->select('*', 'distAppDoc.DOCU_REMARK AS PROPOSAL_REMARK')
                ->where('REQDOC.REQ_DOCU_TYPE', $request->REQ_DOCU_TYPE)
                ->where('REQDOC.MANAGE_SUBMODULE_ID', $request->MANAGE_SUBMODULE_ID)
                ->leftJoin('distributor_management.DISTRIBUTOR_DOCUMENT as distDoc', function ($join) use ($ditst_id) {
                    $join->on('REQDOC.MANAGE_REQUIRED_DOCUMENT_ID', '=', 'distDoc.REQ_DOCU_ID')
                        ->where('distDoc.DIST_ID', '=', $ditst_id);
                })
                ->leftJoin('distributor_management.DISTRIBUTOR_APPROVAL_DOCUMENT as distAppDoc', function ($join) use ($ditst_id, $apprv_id) {
                    $join->on('REQDOC.MANAGE_REQUIRED_DOCUMENT_ID', '=', 'distAppDoc.REQUIRED_DOC_ID')
                        ->where('distAppDoc.DIST_ID', '=', $ditst_id)
                        ->where('distAppDoc.DIST_APPR_ID', '=', $apprv_id);
                })

                ->get();

            foreach ($dataRaw as $docs) {
                $docs->DOCU_BLOB = base64_encode($docs->DOCU_BLOB);
            }

            $data = ManageRequiredDocument::select('REQ_DOCU_SECTION')->where('REQ_DOCU_TYPE', $request->REQ_DOCU_TYPE)
                ->where('MANAGE_SUBMODULE_ID', $request->MANAGE_SUBMODULE_ID)
                ->groupBy('REQ_DOCU_SECTION')
                ->get();

            foreach ($data as $item) {
                $document = array();
                foreach ($dataRaw as $element) {
                    if ($item->REQ_DOCU_SECTION === $element->REQ_DOCU_SECTION) {
                        $document[] = $element;
                    }
                    //  $element->setFileRecords([]);
                    //  $element->setFileRecordsForUpload([]);
                    $element->DOCU_REMARK = null;
                    $element->fileRecords = [];
                    $element->fileRecordsForUpload = [];
                }
                $item->list = $document;
            }

            $dataAdditional = ManageRequiredDocument::where('REQ_DOCU_TYPE', 2)
                ->where('MANAGE_SUBMODULE_ID', $request->MANAGE_SUBMODULE_ID)
                ->leftJoin('distributor_management.DISTRIBUTOR_DOCUMENT as distDoc', 'distDoc.REQ_DOCU_ID', '=', 'MANAGE_REQUIRED_DOCUMENT_ID')
                // ->join('distributor_management.DISTRIBUTOR_APPROVAL_DOCUMENT as dist_appr_doc', 'dist_appr_doc.DIST_DOC_ID', '=', 'distDoc.DIST_DOCU_ID')
                ->where('DIST_ID', $request->DISTRIBUTOR_ID)
                ->get();

            foreach ($dataAdditional as $docs) {
                $docs->DOCU_BLOB = base64_encode($docs->DOCU_BLOB);
                $docs->setFileRecords([]);
                $docs->setFileRecordsForUpload([]);
                $docs->DOCU_REMARK = null;
            }
            // dd(DB::getQueryLog());


            http_response_code(200);
            return response([
                'message' => 'Data successfully retrieved.',
                'data' => ([
                    'dataProposal' => $data,
                    'dataAdditional' => $dataAdditional
                ]),
            ]);
        } catch (RequestException $r) {

            http_response_code(400);
            return response([
                'message' => 'Failed to retrieve data.',
                'errorCode' => 4103
            ], 400);
        }
    }

    public function getDocumentProposalData(Request $request)
    {
        try {
            //DB::enableQueryLog();
            $ditst_id = $request->DISTRIBUTOR_ID;
            $dataRaw = DB::table('admin_management.MANAGE_REQUIRED_DOCUMENT AS REQDOC')->select('*')
                ->where('REQDOC.REQ_DOCU_TYPE', $request->REQ_DOCU_TYPE)
                ->where('REQDOC.MANAGE_SUBMODULE_ID', $request->MANAGE_SUBMODULE_ID)
                ->leftJoin('distributor_management.DISTRIBUTOR_DOCUMENT as distDoc', function ($join) use ($ditst_id) {
                    $join->on('REQDOC.MANAGE_REQUIRED_DOCUMENT_ID', '=', 'distDoc.REQ_DOCU_ID')
                        ->where('distDoc.DIST_ID', '=', $ditst_id);
                })
                ->get();

            foreach ($dataRaw as $docs) {
                $docs->DOCU_BLOB = base64_encode($docs->DOCU_BLOB);
            }
            $data = ManageRequiredDocument::select('REQ_DOCU_SECTION')->where('REQ_DOCU_TYPE', $request->REQ_DOCU_TYPE)
                ->where('MANAGE_SUBMODULE_ID', $request->MANAGE_SUBMODULE_ID)
                ->groupBy('REQ_DOCU_SECTION')
                ->get();

            foreach ($data as $item) {
                $document = array();
                foreach ($dataRaw as $element) {
                    if ($item->REQ_DOCU_SECTION === $element->REQ_DOCU_SECTION) {
                        $document[] = $element;
                    }
                    // if($docs->DOCU_BLOB != ""){
                    // $element->setFileRecords([]);
                    // $element->setFileRecordsForUpload([]);
                    // $element->DOCU_REMARK = null;
                    // }
                    $element->fileRecords = [];
                    $element->fileRecordsForUpload = [];
                }
                $item->list = $document;
            }

            $dataAdditional = ManageRequiredDocument::where('REQ_DOCU_TYPE', 2)
                ->where('MANAGE_SUBMODULE_ID', $request->MANAGE_SUBMODULE_ID)
                ->leftJoin('distributor_management.DISTRIBUTOR_DOCUMENT as distDoc', 'distDoc.REQ_DOCU_ID', '=', 'MANAGE_REQUIRED_DOCUMENT_ID')
                // ->join('distributor_management.DISTRIBUTOR_APPROVAL_DOCUMENT as dist_appr_doc', 'dist_appr_doc.DIST_DOC_ID', '=', 'distDoc.DIST_DOCU_ID')
                ->where('DIST_ID', $request->DISTRIBUTOR_ID)
                ->get();

            foreach ($dataAdditional as $docs) {
                $docs->DOCU_BLOB = base64_encode($docs->DOCU_BLOB);
                $docs->setFileRecords([]);
                $docs->setFileRecordsForUpload([]);
                $docs->DOCU_REMARK = null;
            }
            // dd(DB::getQueryLog());

            http_response_code(200);
            return response([
                'message' => 'Data successfully retrieved.',
                'data' => ([
                    'dataProposal' => $data,
                    'dataAdditional' => $dataAdditional
                ]),
            ]);
        } catch (RequestException $r) {

            http_response_code(400);
            return response([
                'message' => 'Failed to retrieve data.',
                'errorCode' => 4103
            ], 400);
        }
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'MANAGE_SUBMODULE_ID' => 'required|integer',
            'REQ_DOCU_TYPE' => 'required',
            'REQ_DOCU_NAME' => 'required|string',
            'REQ_DOCU_DESCRIPTION' => 'nullable|string',
            'REQ_DOCU_STATUS' => 'required|integer',
            'REQ_DOCU_INDEX' => 'required|integer',
            //'CREATE_BY' => 'required|integer'
        ]);
        $create_by = $request->header('Uid');
        if ($validator->fails()) {
            http_response_code(400);
            return response([
                'message' => 'Data validation error.',
                'errorCode' => $validator->errors() //4106
            ], 400);
        }

        try {
            $data = new ManageRequiredDocument;
            $data->MANAGE_SUBMODULE_ID = $request->MANAGE_SUBMODULE_ID;
            $data->REQ_DOCU_TYPE = $request->REQ_DOCU_TYPE;
            $data->REQ_DOCU_NAME = $request->REQ_DOCU_NAME;
            $data->REQ_DOCU_DESCRIPTION = $request->REQ_DOCU_DESCRIPTION;
            $data->REQ_DOCU_STATUS = $request->REQ_DOCU_STATUS;
            $data->REQ_DOCU_INDEX = $request->REQ_DOCU_INDEX;
            $data->AUDIENCE_TYPE = $request->AUDIENCE_TYPE;
            $data->CREATE_BY = $create_by;
            $data->REQ_DOCU_SECTION = $request->REQ_DOCU_SECTION;
            $data->save();

            http_response_code(200);
            return response([
                'message' => 'Data successfully created.'
            ]);
        } catch (RequestException $r) {

            http_response_code(400);
            return response([
                'message' => 'Data failed to be created.',
                'errorCode' => 4100
            ], 400);
        }
    }

    public function manage(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'MANAGE_SUBMODULE_ID' => 'required|integer',
            'REQ_DOCU_TYPE' => 'required|integer',
            'REQ_DOCU_NAME' => 'required|string',
            'REQ_DOCU_DESCRIPTION' => 'required|string',
            'REQ_DOCU_STATUS' => 'required|integer',
            'REQ_DOCU_INDEX' => 'required|integer',
            'CREATE_BY' => 'required|integer',
            'CREATE_TIMESTAMP' => 'required|integer'
        ]);

        if ($validator->fails()) {
            http_response_code(400);
            return response([
                'message' => 'Data validation error.',
                'errorCode' => 4106
            ], 400);
        }

        try {
            //manage function

            http_response_code(200);
            return response([
                'message' => ''
            ]);
        } catch (RequestException $r) {

            http_response_code(400);
            return response([
                'message' => '',
                'errorCode' => 4104
            ], 400);
        }
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'MANAGE_SUBMODULE_ID' => 'required|integer',
            'REQ_DOCU_TYPE' => 'required',
            'REQ_DOCU_NAME' => 'required|string',
            'REQ_DOCU_DESCRIPTION' => 'nullable|string',
            'REQ_DOCU_STATUS' => 'required|integer',
            'REQ_DOCU_INDEX' => 'required|integer',
            //'CREATE_BY' => 'required|integer'
        ]);

        if ($validator->fails()) {
            http_response_code(400);
            return response([
                'message' => 'Data validation error.',
                'errorCode' => $validator->errors() //4106
            ], 400);
        }

        try {
            $create_by = $request->header('Uid');
            $data = ManageRequiredDocument::find($request->MANAGE_REQUIRED_DOCUMENT_ID);
            $data->MANAGE_SUBMODULE_ID = $request->MANAGE_SUBMODULE_ID;
            $data->REQ_DOCU_TYPE = $request->REQ_DOCU_TYPE;
            $data->REQ_DOCU_NAME = $request->REQ_DOCU_NAME;
            $data->REQ_DOCU_SECTION = $request->REQ_DOCU_SECTION;
            $data->REQ_DOCU_DESCRIPTION = $request->REQ_DOCU_DESCRIPTION;
            $data->REQ_DOCU_STATUS = $request->REQ_DOCU_STATUS;
            $data->REQ_DOCU_INDEX = $request->REQ_DOCU_INDEX;
            $data->AUDIENCE_TYPE = $request->AUDIENCE_TYPE;
            $data->CREATE_BY = $create_by;
            $data->save();

            http_response_code(200);
            return response([
                'message' => 'Data successfully updated'
            ]);
        } catch (RequestException $r) {

            http_response_code(400);
            return response([
                'message' => 'Data failed to be updated.',
                'errorCode' => 4101
            ], 400);
        }
    }

    public function delete(Request $request)
    {
        try {
            $data = ManageRequiredDocument::find($request->MANAGE_REQUIRED_DOCUMENT_ID);
            $data->delete();

            http_response_code(200);
            return response([
                'message' => 'Data successfully deleted.'
            ]);
        } catch (RequestException $r) {

            http_response_code(400);
            return response([
                'message' => 'Data failed to be deleted.',
                'errorCode' => 4102
            ], 400);
        }
    }

    public function filter(Request $request)
    {
        try {

            $query = DB::table('admin_management.MANAGE_REQUIRED_DOCUMENT AS managedoc')
                ->select('managedoc.*', 'submodule.SUBMOD_NAME as SUBNAME', 'settype.SET_PARAM as docTypeName')
                ->leftJoin('admin_management.MANAGE_SUBMODULE AS submodule', 'managedoc.MANAGE_SUBMODULE_ID', '=', 'submodule.MANAGE_SUBMODULE_ID')
                ->leftJoin('SETTING_GENERAL AS settype', 'settype.SETTING_GENERAL_ID', '=', 'managedoc.REQ_DOCU_TYPE');
            if ($request->MANAGE_SUBMODULE_ID  != null) {
                $query->where('managedoc.MANAGE_SUBMODULE_ID', $request->MANAGE_SUBMODULE_ID);
            }
            if ($request->REQ_DOCU_TYPE != null) {
                $query->where('managedoc.REQ_DOCU_TYPE', $request->REQ_DOCU_TYPE);
            }
            $data = $query->get();

            // $query = ManageRequiredDocument::select('*');
            //     if ($request->MANAGE_SUBMODULE_ID  != null) {
            //         $query->where('MANAGE_SUBMODULE_ID', $request->MANAGE_SUBMODULE_ID);
            //     }
            //     if ($request->REQ_DOCU_TYPE != null) {
            //         $query->where('REQ_DOCU_TYPE', $request->REQ_DOCU_TYPE);
            //     }
            $data = $query->get();

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
}
