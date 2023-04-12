<?php

namespace App\Http\Controllers;

use App\Models\User;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;
use App\Helpers\CurrentUser;
use Illuminate\Support\Facades\Http;
use Validator;

class UserController extends Controller
{
    public function getLastLogin(Request $request)
    {
        try {
            // $user = KeycloakAdmin::user()->find([
            //     'query' => [
            //         'id' => $request->user_id,
            //     ],
            // ]);

            return $user;

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
        // $validator = Validator::make($request->all(), [
        //     'TYPE_NAME' => 'required|string',
        // ]);

        // if ($validator->fails()) {
        //     http_response_code(400);
        //     return response([
        //         'message' => 'Data validation error.',
        //         'errorCode' => 4106,
        //     ], 400);
        // }

        try {
            $user = new CurrentUser();
            $result = $user->createUser($request);

            http_response_code(200);
            return response([
                'message' => 'User successfully created.',
            ]);

        } catch (RequestException $r) {

            http_response_code(400);
            return response([
                'message' => 'Data failed to be updated.',
                'errorCode' => 4100,
            ], 400);
        }

    }

    public function manage(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'TYPE_NAME' => 'required|string',
        ]);

        if ($validator->fails()) {
            http_response_code(400);
            return response([
                'message' => 'Data validation error.',
                'errorCode' => 4106,
            ], 400);
        }

        try {
            //manage function

            http_response_code(200);
            return response([
                'message' => '',
            ]);

        } catch (RequestException $r) {

            http_response_code(400);
            return response([
                'message' => '',
                'errorCode' => 4104,
            ], 400);
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'TYPE_NAME' => 'required|string',
        ]);

        if ($validator->fails()) {
            http_response_code(400);
            return response([
                'message' => 'Data validation error.',
                'errorCode' => 4106,
            ], 400);
        }

        try {
            $data = ConsultantType::where('id', $id)->first();
            $data->TEST = $request->TEST; //nama column
            $data->save();

            http_response_code(200);
            return response([
                'message' => '',
            ]);

        } catch (RequestException $r) {

            http_response_code(400);
            return response([
                'message' => 'Data failed to be updated.',
                'errorCode' => 4101,
            ], 400);
        }
    }

    public function delete($id)
    {
        try {
            $data = ConsultantType::find($id);
            $data->delete();

            http_response_code(200);
            return response([
                'message' => 'Data successfully deleted.',
            ]);

        } catch (RequestException $r) {

            http_response_code(400);
            return response([
                'message' => 'Data failed to be deleted.',
                'errorCode' => 4102,
            ], 400);
        }
    }

    public function filter(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'TYPE_NAME' => 'required|string',
        ]);

        if ($validator->fails()) {
            http_response_code(400);
            return response([
                'message' => 'Data validation error.',
                'errorCode' => 4106,
            ], 400);
        }

        try {
            //manage function

            http_response_code(200);
            return response([
                'message' => 'Filtered data successfully retrieved.',
            ]);

        } catch (RequestException $r) {

            http_response_code(400);
            return response([
                'message' => 'Filtered data failed to be retrieved.',
                'errorCode' => 4105,
            ], 400);
        }
    }
}
