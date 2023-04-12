<?php

namespace App\Http\Controllers;

use App\Models\Screen;
use Illuminate\Http\Request;

class ScreenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        try {
            //code...
        $screen = new Screen;
        $screen->code = $request->code;
        $screen->name = $request->name;
        $screen->short_name = $request->short_name;
        $screen->icon = $request->icon;
        $screen->index = $request->index;
        $screen->save();

        return response(['message' => 'Data created successfully', 'status' => 200]);
        } catch (\Throwable $th) {
            //throw $th;
            return response(['message' => 'Failed to create module', 'status' => 400]);
        }
        
    }
}
