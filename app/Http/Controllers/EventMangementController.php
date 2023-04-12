<?php

namespace App\Http\Controllers;

use App\Models\EventManagement;
use Illuminate\Http\Request;
use Validator;

class EventMangementController extends Controller
{
    public function get(Request $request)
    {
        try {
            $event = EventManagement::find($request->id);
            return response([
                'message' => 'Event list successfully retrieved.', 
                'data' => $event
            ]);
        } catch (\Throwable $th) {
            http_response_code(400);
             return response([
                 'message' => 'Failed to retrieve all event list.', 
                 'errorCode' => 4002
             ]);
        }
    }

    public function getAll()
    {
        try {
            $event = EventManagement::all();
             http_response_code(200);
             return response([
                 'message' => 'All event list successfully retrieved.', 
                 'data' => $event
             ]);
         } catch (\Throwable $th) {
             http_response_code(400);
             return response([
                 'message' => 'Failed to retrieve all event list.', 
                 'errorCode' => 4002
             ]);
         }
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'calendar_set_name' => 'required|string', //Cuti raya cina
            'calendar_set_start' => 'required|string', //2021-02-13
            'calendar_set_end' => 'required|string', //2021-02-14
            'calendar_set_desc' => 'required|string' //Cuti hari raya cina
        ]);
        
        try {
            $event = new EventManagement;
            $event->EVENT_MGMT_TITLE = $request->title;
            $event->EVENT_MGMT_CONTENT = $request->content;
            $event->EVENT_MGMT_AUDIENCE = $request->compType;
            $event->EVENT_MGMT_START = $request->startDate;
            $event->EVENT_MGMT_END = $request->endDate;
            $event->save();
    
            http_response_code(200);
            return response([
                'message' => 'Event successfully added.'
            ]);
        } catch (\Throwable $th) {
            http_response_code(400);
            return response([
                'message' => 'Event failed to be added.', 
                'errorCode' => $th//4003
            ]);
        }
    }

    public function update($id)
    {
        $validator = Validator::make($request->all(), [
            'test' => 'required|string' //test
        ]);

    }

    public function delete($id)
    {
        //
    }
}
