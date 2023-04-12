<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ManageModule;
use App\Models\DistributorManageModule;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;

class ManageModuleController extends Controller
{
    public function get(Request $request)
    {
        try {
            $data = ManageModule::find($request->MANAGE_MODULE_ID);

            http_response_code(200);
            return response([
                'message' => 'Data successfully retrieved.',
                'data' => $data,
            ]);
        } catch (RequestException $r) {

            http_response_code(400);
            return response([
                'message' => 'Failed to retrieve data.',
                'errorCode' => 0,
            ]);
        }
    }

    public function getAll()
    {
        try {
           // Log::info("request=".$request->USER_TYPE);
            // $data = ManageModule::all();
            $data = ManageModule::orderBy('MOD_INDEX', 'asc')
            // ->orderBy('MOD_INDEX', 'asc')
            ->get();

            http_response_code(200);
            return response([
                'message' => 'All data successfully retrieved.',
                'data' => $data,
            ]);
        } catch (RequestException $r) {

            http_response_code(400);
            return response([
                'message' => 'Failed to retrieve all data.',
                'errorCode' => 4103,
            ], 400);
        }
    }
    public function getAllByType(Request $request)
    {
        try {
           // Log::info("request=".$request->USER_TYPE);
            // $data = ManageModule::all();
            if($request->USER_TYPE == 'fimm')
            {
            $data = ManageModule::orderBy('MOD_INDEX', 'asc')
            // ->orderBy('MOD_INDEX', 'asc')
            ->get();
            }
            if($request->USER_TYPE == 'DISTRIBUTOR')
            {
            $data = DistributorManageModule::orderBy('DISTRIBUTOR_MOD_INDEX', 'asc')
            // ->orderBy('MOD_INDEX', 'asc')
            ->get();
            }

            http_response_code(200);
            return response([
                'message' => 'All data successfully retrieved.',
                'data' => $data,
            ]);
        } catch (RequestException $r) {

            http_response_code(400);
            return response([
                'message' => 'Failed to retrieve all data.',
                'errorCode' => 4103,
            ], 400);
        }
    }

    public function create(Request $request)
    {
        $messages = [
            'unique' => 'The module code has already been taken',
            'required' => 'Required field can not be blank',
        ];
        $validator = Validator::make($request->all(), [
            'MOD_CODE' => 'required|unique:MANAGE_MODULE',
            'MOD_NAME' => 'required',
            'MOD_SNAME' => 'required',
            'MOD_INDEX' => 'required',
            'MOD_ICON' => 'required'
        ],$messages);

        if ($validator->fails()) {
            http_response_code(400);
            return response([
                'message' => $validator->errors()->first(),
                'errorCode' => 4106,
            ], 400);
        }

        try {
            $module = new ManageModule;
            $module->MOD_CODE = $request->MOD_CODE;
            $module->MOD_NAME = strtoupper($request->MOD_NAME);
            $module->MOD_SNAME = strtoupper($request->MOD_SNAME);
            $module->MOD_INDEX = $request->MOD_INDEX;
            $module->MOD_ICON = $request->MOD_ICON;
            $module->save();

            http_response_code(200);
            return response([
                'message' => 'Data successfully created.',
            ]);

        } catch (RequestException $r) {

            http_response_code(400);
            return response([
                'message' => 'Data failed to be created.',
                'errorCode' => 4100,
            ], 400);
        }

    }

    public function update(Request $request)
    {
        // $validator = Validator::make($request->all(), [
        //     'MOD_CODE' => 'required|string',
        //     'MOD_NAME' => 'required|string',
        //     'MOD_SNAME' => 'required|string',
        //     'MOD_INDEX' => 'required|integer'
        // ]);

        // if ($validator->fails()) {
        //     http_response_code(400);
        //     return response([
        //         'message' => 'Data validation error.',
        //         'errorCode' => 4106,
        //     ], 400);
        // }

        $messages = [
            'unique' => 'The module code has already been taken',
            'required' => 'Required field can not be blank',
        ];
        $validator = Validator::make($request->all(), [
            //'MOD_CODE' => 'required|unique:MANAGE_MODULE,MOD_CODE,'. $request->MANAGE_MODULE_ID,
            'MOD_CODE' => ['required',Rule::unique('MANAGE_MODULE')->where(function ($query) use ($request) {
                return $query->where('MANAGE_MODULE_ID', '!=',  $request->MANAGE_MODULE_ID);
            })],
            'MOD_NAME' => 'required',
            'MOD_SNAME' => 'required',
            'MOD_INDEX' => 'required',
            'MOD_ICON' => 'required'
        ],$messages);

        if ($validator->fails()) {
            http_response_code(400);
            return response([
                'message' => $validator->errors()->first(),
                'errorCode' => 4106,
            ], 400);
        }
    
        try {
            $module = ManageModule::find($request->MANAGE_MODULE_ID);
            $module->MOD_CODE = $request->MOD_CODE;
            $module->MOD_NAME = strtoupper($request->MOD_NAME);
            $module->MOD_SNAME = strtoupper($request->MOD_SNAME);
            $module->MOD_INDEX = $request->MOD_INDEX;
            $module->MOD_ICON = $request->MOD_ICON;
            $module->save();
            //update function

            http_response_code(200);
            return response([
                'message' => 'Data successfully Updated.',
                'data' => '',
            ]);

        } catch (RequestException $r) {

            http_response_code(400);
            return response([
                'message' => '',
                'errorCode' => 0,
            ]);
        }
    }

    public function delete(Request $request)
    {
        try {

            $data = ManageModule::find($request->MANAGE_MODULE_ID);
            $data->delete();
            http_response_code(200);
            return response([
                'message' => 'Data successfully deleted.',
            ]);

        } catch (RequestException $r) {

            http_response_code(400);
            return response([
                'message' => 'Data failed to be deleted.',
                'errorCode' => 0,
            ]);
        }
    }
}
