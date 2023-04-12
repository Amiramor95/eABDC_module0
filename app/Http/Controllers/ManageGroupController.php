<?php

namespace App\Http\Controllers;

use App\Models\ManageGroup;
use App\Models\ManageDistributorGroup;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
// use LaravelKeycloakAdmin\Facades\KeycloakAdmin;
use Validator;

class ManageGroupController extends Controller
{
    
    public function getAll()
    {
        try {
            $group  = DB::table('MANAGE_GROUP')
            ->select('MANAGE_GROUP.MANAGE_GROUP_ID','MANAGE_GROUP.MANAGE_DEPARTMENT_ID','MANAGE_DEPARTMENT.DPMT_NAME AS DPMT_NAME','MANAGE_GROUP.GROUP_NAME AS GROUP_NAME','MANAGE_DIVISION.MANAGE_DIVISION_ID','MANAGE_DIVISION.DIV_NAME AS DIV_NAME')
            ->join('MANAGE_DEPARTMENT', 'MANAGE_DEPARTMENT.MANAGE_DEPARTMENT_ID', '=', 'MANAGE_GROUP.MANAGE_DEPARTMENT_ID')
            ->join('MANAGE_DIVISION', 'MANAGE_DIVISION.MANAGE_DIVISION_ID', '=', 'MANAGE_DEPARTMENT.MANAGE_DIVISION_ID')
            ->get();
           

            http_response_code(200);
            return response([
                'message' => 'All data successfully retrieved.',
                'data' => $group 
            ]);
        } catch (RequestException $r) {

            http_response_code(400);
            return response([
                'message' => 'Failed to retrieve all data.', 
                'errorCode' => 4103
            ],400);
        }
    }

    public function getAllDistributorGroup()
    {
        try {
            $data = ManageDistributorGroup::all();
           

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
            ],400);
        }
    }

    public function getByDepartment(Request $request)
    {
        try {
            $department = ManageGroup::select('*')
            ->where('MANAGE_DEPARTMENT_ID',$request->MANAGE_DEPARTMENT_ID)
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


    public function delete(Request $request)
    {
        try {
          
            
            $group = ManageGroup::find($request->MANAGE_GROUP_ID);
            $group->delete();
           
      
            http_response_code(200);
            return response([
                'message' => 'Group successfully deleted',
            ]);
        } catch (\Throwable $th) {
            http_response_code(400);
            return response([
                'message' => 'Failed to delete group', 
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

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), 
        [
            'MANAGE_DEPARTMENT_ID' => 'required|integer',
            'GROUP_NAME' => 'required|string'
        ]);
      
        try {
            
            //create function
            $group = new ManageGroup;
            $group->MANAGE_DEPARTMENT_ID = $request->MANAGE_DEPARTMENT_ID;
            $group->GROUP_NAME = $request->GROUP_NAME;
            $group->save();

            $groupId = strval($group->MANAGE_DEPARTMENT_ID);
            // $addGroup = KeycloakAdmin::addon()->addGroup([
            //     'body' => [
            //         'name' => $request->GROUP_NAME,
            //         'subGroups' => [[
            //             'name' => 'testing',
            //         ]]
            //     ],
            // ]);

            http_response_code(200);
            return response([
                'message' => 'Data successfully created.'
            ]);

        } catch (RequestException $r) {

            http_response_code(400);
            return response([
                'message' => 'Data failed to be created.',
                'errorCode' => 4100
            ],400);
        }

    }
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'MANAGE_GROUP_ID' => 'required|int',
            'MANAGE_DEPARTMENT_ID' => 'required|int',
            'GROUP_NAME' => 'required|string'
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
            $group =ManageGroup::find($request->MANAGE_GROUP_ID);
            $group->MANAGE_DEPARTMENT_ID = $request->MANAGE_DEPARTMENT_ID;
            $group->GROUP_NAME = $request->GROUP_NAME;
            $group->save();

            http_response_code(200);
            return response([
                'message' => 'Group successfully updated',
            ]);
        } catch (\Throwable $th) {
            http_response_code(400);
            return response([
                'message' => 'Group failed to be updated', 
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
    public function get(Request $request)
    {
        try {
            $group = DB::table('MANAGE_GROUP')
            ->select('MANAGE_GROUP.MANAGE_GROUP_ID','MANAGE_GROUP.MANAGE_DEPARTMENT_ID','MANAGE_DEPARTMENT.DPMT_NAME AS DPMT_NAME','MANAGE_GROUP.GROUP_NAME AS GROUP_NAME','MANAGE_DIVISION.MANAGE_DIVISION_ID','MANAGE_DIVISION.DIV_NAME AS DIV_NAME')
            ->join('MANAGE_DEPARTMENT', 'MANAGE_DEPARTMENT.MANAGE_DEPARTMENT_ID', '=', 'MANAGE_GROUP.MANAGE_DEPARTMENT_ID')
            ->join('MANAGE_DIVISION', 'MANAGE_DIVISION.MANAGE_DIVISION_ID', '=', 'MANAGE_DEPARTMENT.MANAGE_DIVISION_ID')
            ->where('MANAGE_GROUP.MANAGE_GROUP_ID',$request->MANAGE_GROUP_ID)
            
            ->first();

            http_response_code(200);
            return response([
                'message' => 'Data successfully retrieved.',
                'data' => $group
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
