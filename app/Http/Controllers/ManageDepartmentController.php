<?php

namespace App\Http\Controllers;

use App\Models\ManageDepartment;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Ixudra\Curl\Facades\Curl;
use Validator;

class ManageDepartmentController extends Controller
{
    public function get(Request $request)
    {
        try {
            $department = DB::table('MANAGE_DEPARTMENT')
            ->select('MANAGE_DEPARTMENT.MANAGE_DEPARTMENT_ID','MANAGE_DEPARTMENT.MANAGE_DIVISION_ID','MANAGE_DIVISION.DIV_NAME AS DIV_NAME','MANAGE_DEPARTMENT.DPMT_NAME AS DPMT_NAME')
            ->join('MANAGE_DIVISION', 'MANAGE_DIVISION.MANAGE_DIVISION_ID', '=', 'MANAGE_DEPARTMENT.MANAGE_DIVISION_ID')
            ->where('MANAGE_DEPARTMENT.MANAGE_DEPARTMENT_ID',$request->MANAGE_DEPARTMENT_ID)
            
            ->first();

            http_response_code(200);
            return response([
                'message' => 'Data successfully retrieved.',
                'data' => $department
            ]);
        } catch (RequestException $r) {

            http_response_code(400);
            return response([
                'message' => 'Failed to retrieve data.', 
                'errorCode' => 4103
            ],400);
        }
        
    }

    public function getByDivision(Request $request)
    {
        try {
            $department = ManageDepartment::select('*')
            ->where('MANAGE_DIVISION_ID',$request->MANAGE_DIVISION_ID)
            ->get();

            http_response_code(200);
            return response([
                'message' => 'Data successfully retrieved.',
                'data' => $department
            ]);
        } catch (RequestException $r) {

            http_response_code(400);
            return response([
                'message' => 'Failed to retrieve data.', 
                'errorCode' => 4103
            ],400);
        }
    }

    public function getAll()
    {
        try {
            //$department = ManageDepartment::all();
            $department = DB::table('MANAGE_DEPARTMENT')
            ->select('MANAGE_DEPARTMENT.MANAGE_DEPARTMENT_ID','MANAGE_DEPARTMENT.MANAGE_DIVISION_ID','MANAGE_DIVISION.DIV_NAME AS DIV_NAME','MANAGE_DEPARTMENT.DPMT_NAME AS DPMT_NAME')
            ->join('MANAGE_DIVISION', 'MANAGE_DIVISION.MANAGE_DIVISION_ID', '=', 'MANAGE_DEPARTMENT.MANAGE_DIVISION_ID')

            ->get();
           

            http_response_code(200);
            return response([
                'message' => 'All data successfully retrieved.',
                'data' => $department
            ]);
        } catch (RequestException $r) {

            http_response_code(400);
            return response([
                'message' => 'Failed to retrieve all data.', 
                'errorCode' => 4103
            ],400);
        }
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'MANAGE_DIVISION_ID' => 'required|integer',
            'DPMT_NAME' => 'required|string'
        ]);
      
        try {
            //create function
            $department = new ManageDepartment;
            $department->MANAGE_DIVISION_ID = $request->MANAGE_DIVISION_ID;
            $department->DPMT_NAME = $request->DPMT_NAME;
            $department->save();

            http_response_code(200);
            return response([
                'message' => 'Data successfully Created.'
            ]);

        } catch (RequestException $r) {

            http_response_code(400);
            return response([
                'message' => 'Data failed to be updated.',
                'errorCode' => 4100
            ],400);
        }

    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'MANAGE_DEPARTMENT_ID' => 'required|string',
            'DPMT_NAME' => 'required|string'
        ]);

        if ($validator->fails()) {
            http_response_code(400);
            return response([
                'message' => 'Data validation error.',
                'errorCode' => 4106
            ],400);
        }

        try {
            //update function
            $department =ManageDepartment::find($request->MANAGE_DEPARTMENT_ID);
            $department->MANAGE_DIVISION_ID = $request->MANAGE_DIVISION_ID;
            $department->DPMT_NAME = $request->DPMT_NAME;
            $department->save();

            http_response_code(200);
            return response([
                'message' => 'Department successfully updated',
            ]);
        } catch (\Throwable $th) {
            http_response_code(400);
            return response([
                'message' => 'Department failed to be updated', 
                'errorCode' => 4102
            ]);

        } catch (RequestException $r) {

            http_response_code(400);
            return response([
                'message' => 'Data failed to be updated.',
                'errorCode' => 4101
            ],400);
        }
    }

    public function delete(Request $request)
    {
        try { 
            $department = ManageDepartment::find($request->MANAGE_DEPARTMENT_ID);
            $department->delete();
           
      
            http_response_code(200);
            return response([
                'message' => 'Department successfully deleted',
            ]);
        } catch (\Throwable $th) {
            http_response_code(400);
            return response([
                'message' => 'Failed to delete Department', 
                'errorCode' =>  4102
            ]);

        } catch (RequestException $r) {

            http_response_code(400);
            return response([
                'message' => 'Filtered data failed to be retrieved.',
                'errorCode' => 4105
            ],400);
        }
    }
    public function filter(Request $request)
    {
        try {
            $query = ManageDepartment::select('*');
                if ($request->MANAGE_DIVISION_ID  != null) {
                    $query->where('MANAGE_DIVISION_ID', $request->MANAGE_DIVISION_ID);
                }
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
            ],400);
        }
    }
}
