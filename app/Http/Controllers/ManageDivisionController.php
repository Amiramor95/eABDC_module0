<?php

namespace App\Http\Controllers;

use App\Models\ManageDivision;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;

class ManageDivisionController extends Controller
{
    public function get(Request $request)
    {
        try {
            $division = ManageDivision::find($request->MANAGE_DIVISION_ID);
            $division->DIV_NAME;
            
            return response([
                'message' => 'Data successfully retrieved.', 
                'data' => $division
            ]);
        } catch (\Throwable $th) {
            http_response_code(400);
            return response([
                'message' => 'Data failed to be retrieved.', 
                'errorCode' => 4103
            ]);
        }
        
    }

    

    public function getAll()
    {
        try {
            $division = ManageDivision::all();

            http_response_code(200);
            return response([
                'message' => 'All data successfully retrieved.',
                'data' => $division
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
            'DIV_NAME' => 'required|string' //test
        ]);

        try {
            //create function
            $division = new ManageDivision;
            $division->DIV_NAME= $request->DIV_NAME;
            $division->save();

            http_response_code(200);
            return response([
                'message' => 'Data successfully created.'
            ]);

        } catch (RequestException $r) {

            http_response_code(400);
            return response([
                'message' => 'Data failed to be created.',
                'errorCode' => 0
            ]);
        }

    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'MANAGE_DIVISION_ID' => 'required|string' ,
            'DIV_NAME' => 'required|string'
        ]);

        try {
            //update function
            $division =ManageDivision::find($request->MANAGE_DIVISION_ID);
            $division->DIV_NAME = $request->DIV_NAME;
            $division->save();

            http_response_code(200);
            return response([
                'message' => 'Division successfully updated',
            ]);
        } catch (\Throwable $th) {
            http_response_code(400);
            return response([
                'message' => 'Division failed to be updated', 
                'errorCode' => 4102
            ]);
        }
    }

    public function delete(Request $request)
    {
        try {
          
            
            $division = ManageDivision::find($request->MANAGE_DIVISION_ID);
            $division->delete();
           
      
            http_response_code(200);
            return response([
                'message' => 'Division successfully deleted',
            ]);
        } catch (\Throwable $th) {
            http_response_code(400);
            return response([
                'message' => 'Failed to delete division', 
                'errorCode' =>  4102
            ]);
        }
    }
}
