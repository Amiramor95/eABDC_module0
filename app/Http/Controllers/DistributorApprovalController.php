<?php

namespace App\Http\Controllers;

use DB;
use App\Models\Distributor;
use App\Models\DistributorApproval;
use Illuminate\Http\Request;

class DistributorApprovalController extends Controller
{
    public function getDistributorApplicationList(Request $request)
    {
        try {
            $newData = array();
            $group_id = $request->APPR_GROUP_ID;

            $data = DB::table('distributor_management.DISTRIBUTOR_APPROVAL AS DA')
            ->select('*','task_status2.TS_PARAM AS TS_PARAM_MAIN','task_status.TS_PARAM AS TS_PARAM')
            ->join('admin_management.TASK_STATUS AS task_status', 'task_status.TS_ID', '=', 'DA.APPROVAL_STATUS')
            ->join('distributor_management.DISTRIBUTOR AS dist', 'dist.DISTRIBUTOR_ID', '=', 'DA.DIST_ID')
            ->join('admin_management.APPROVAL_LEVEL AS appr_level', 'appr_level.APPROVAL_LEVEL_ID', '=', 'DA.APPROVAL_LEVEL_ID')
            ->join('distributor_management.DISTRIBUTOR_STATUS AS dist_status', 'dist_status.DIST_ID', '=', 'DA.DIST_ID')
            ->join('admin_management.TASK_STATUS AS task_status2', 'task_status2.TS_ID', '=', 'dist_status.DIST_APPROVAL_STATUS')
            ->where('DA.APPR_GROUP_ID','=',$request->APPR_GROUP_ID)
            ->whereIn('DA.APPROVAL_DATE', function ($query) use ($group_id) {
                return $query->select(DB::raw('max(DA2.APPROVAL_DATE) as APPROVAL_DATE'))
                    ->from('distributor_management.DISTRIBUTOR_APPROVAL AS DA2')
                    ->where('DA2.APPR_GROUP_ID','=', $group_id)
                    ->groupBy('DA2.DIST_ID');
            })
           ->groupBy('DA.DIST_ID')
           ->get();

            foreach($data as $item){
                if($item->APPR_INDEX == 1){
                    $item->TS_PARAM = $item->TS_PARAM_MAIN;
                    $newData[] = $item;
                }else{
                    $dataAppr = DistributorApproval::where('APPROVAL_INDEX', 1)->first();
                    if($dataAppr->APPR_GROUP_ID == $item->APPR_GROUP_ID){
                        $item->TS_PARAM = $item->TS_PARAM_MAIN;
                        $newData[] = $item;
                    }else{
                        if($item->APPROVAL_STATUS == 15){//pending
                            $newData[] = $item;
                        }
                    }
                }
            }

            http_response_code(200);
            return response([
                'message' => 'Data successfully retrieved.',
                'data' => $newData
            ]);
        } catch (RequestException $r) {

            http_response_code(400);
            return response([
                'message' => 'Failed to retrieve data.',
                'errorCode' => 4103
            ],400);
        }
    }

    public function getDistributorApplicationList2(Request $request)
    {
        try {
            $data = Distributor::where('DISTRIBUTOR_APPROVAL.APPR_GROUP_ID',$request->APPR_GROUP_ID)
        //    / ->where('DIST_ID',$request->DISTRIBUTOR_ID)
            ->join('DISTRIBUTOR_APPROVAL', 'DISTRIBUTOR_APPROVAL.DIST_ID', '=', 'DISTRIBUTOR.DISTRIBUTOR_ID')
           // ->join('distributor_management.DISTRIBUTOR_STATUS AS dist_status', 'dist_status.DIST_ID', '=', 'distributor.DISTRIBUTOR_ID')
            ->join('admin_management.TASK_STATUS AS task_status', 'task_status.TS_ID', '=', 'DISTRIBUTOR_APPROVAL.APPROVAL_STATUS')
            ->get();

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
            ],400);
        }
    }

    public function create(Request $request)
    {
        try {
            $data =  new DistributorApproval;//DB::table('distributor_management.DISTRIBUTOR_APPROVAL AS dist_appr');
            $data->APPROVAL_FIMM_USER = $request->APPROVAL_FIMM_USER;
            $data->APPROVAL_REMARK_PROFILE = $request->APPROVAL_REMARK_PROFILE;
            $data->APPR_REMARK_DOCU_PROFILE = $request->APPR_REMARK_DOCU_PROFILE;
            $data->APPROVAL_REMARK_DETAILINFO = $request->APPROVAL_REMARK_DETAILINFO;
            $data->APPR_REMARK_DOCU_DETAILINFO = $request->APPR_REMARK_DOCU_DETAILINFO;
            $data->APPROVAL_REMARK_CEOnDIR = $request->APPROVAL_REMARK_CEOnDIR;
            $data->APPR_REMARK_DOCU_CEOnDIR = $request->APPR_REMARK_DOCU_CEOnDIR;
            $data->APPROVAL_REMARK_ARnAAR = $request->APPROVAL_REMARK_ARnAAR;
            $data->APPR_REMARK_DOCU_ARnAAR = $request->APPR_REMARK_DOCU_ARnAAR;
            $data->APPROVAL_REMARK_ADDTIONALINFO = $request->APPROVAL_REMARK_ADDTIONALINFO;
            $data->APPR_REMARK_DOCU_ADDITIONALINFO = $request->APPR_REMARK_DOCU_ADDITIONALINFO;
            $data->APPROVAL_REMARK_PAYMENT = $request->APPROVAL_REMARK_PAYMENT;
            $data->APPR_REMARK_DOCU_PAYMENT = $request->APPR_REMARK_DOCU_PAYMENT;
            $data->save();

            http_response_code(200);
            return response([
                'message' => 'Data successfully created.',
                'data' => $data
            ]);
        } catch (RequestException $r) {

            http_response_code(400);
            return response([
                'message' => 'Failed to create data.', 
                'errorCode' => 4103
            ],400);
        }
    }
}
