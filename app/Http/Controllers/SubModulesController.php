<?php

namespace App\Http\Controllers;

use App\Models\SubModules;
use App\Models\Modules;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;
class SubModulesController extends Controller
{

    public function create(Request $request)
    {
        try {
            //code...
        $subModules = new SubModules;
        $subModules->modules_id = $request->modules_id;
        $subModules->code = $request->subModuleCode;
        $subModules->name = $request->subModuleName;
        $subModules->save();

        return response(['message' => 'Data created successfully', 'status' => 200]);
        } catch (\Throwable $th) {
            //throw $th;
            return response(['message' => 'Failed to create module', 'status' => 400]);
        }
    }

    public function get()
    {
        $subModule = DB::table('sub_modules')
            ->select('sub_modules.id','sub_modules.code','sub_modules.name','modules.name as moduleName' )
            ->join('modules', 'modules.id', '=', 'sub_modules.modules_id')

            ->get();
            return $subModule;
    }

    public function getAll()
    {
        $subModule = DB::table('sub_modules')
            ->select('sub_modules.id','sub_modules.code','sub_modules.name','modules.name as moduleName' )
            ->join('modules', 'modules.id', '=', 'sub_modules.modules_id')

            ->get();
            return $subModule;
    }

    public function delete(Request $request)
    {
        try {
            //code...
        $module = SubModules::find($request->id);
        $module->delete();

        return response(['message' => 'Data delete successfully', 'status' => 200]);
        } catch (\Throwable $th) {
            //throw $th;
            return response(['message' => 'Failed to delete sub modules', 'status' => 400]);
        }
        
    }

    public function update(Request $request)
    {
        $submodule = SubModules::find($request->id);
        $submodule->modules_id = $request->modules_id;
        $submodule->code = $request->code;
        $submodule->name = $request->name;
        $submodule->save();

        return response(['message' => 'Data updated successfully', 'status' => 200]);
    }
}
