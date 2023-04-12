<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ManageModule;
use App\Models\ManageSubmodule;
use App\Models\ManageScreenAccess;
use App\Models\ManageScreen;

use App\Models\DistributorManageModule;
use App\Models\DistributorManageSubmodule;
use App\Models\DistributorScreenAccess;
use App\Models\DistributorManageScreen;

use App\Models\ConsultantManageSubmodule;
use App\Models\ConsultantManageModule;
use App\Models\ConsultantScreenAccess;
use App\Models\ConsultantManageScreen;


use DB;

use Illuminate\Http\Request;

class sidebar {
    public $name;
    public $displayName;
    public $meta;
}

class SideBarController extends Controller
{
    public function getSideBarByGroupId(Request $request)
    {
        try {  
            ini_set('max_execution_time', 180); //3 minutes
            //return $request->all();
            
            if($request->USER_TYPE == 'fimm'){
                // Screen Access For Fimm USER
                $sidebar = $this->fimmSceenAccess($request);
            }else if($request->USER_TYPE == 'DISTRIBUTOR'){
                // Screen Access For Fimm USER
                $sidebar = $this->distributorSceenAccess($request);
            }else if($request->USER_TYPE == 'CONSALTANT-00'){
                // Screen Access For Fimm USER
                $sidebar = $this->consultantSceenAccess($request);
            }else{
                $sidebar = ''; 
            }
            //$sidebar = $this->fimmSceenAccess($request);
            http_response_code(200);
            return response([
                'message' => 'Data successfully retrieved.',
                'data' => $sidebar,
            ]);
        } catch (RequestException $r) {

            http_response_code(400);
            return response([
                'message' => 'Failed to retrieve data.',
                'errorCode' => 0,
            ]);
        }
    }

    // Fimm Use User Access Function
    public function fimmSceenAccess($request){
        $sidebar = array();
        $subsidebar = array();
        $modules = array();
        //Screen Access for user Group
        $screenIdArray = ManageScreenAccess::where('MANAGE_GROUP_ID', 
                            $request->MANAGE_GROUP_ID)->value('MANAGE_SCREEN_ID');
        $screenIdArray = json_decode($screenIdArray,true) ?? [];
        //Additional screen access 
        $additional = DB::table('ADDITIONAL_USER_ACCESS_SCREEN')
                ->where('USER_ID',$request->USER_ID)->value('ADDITIONAL_SCREEN_ID');
        $additional = json_decode($additional,true);
        // add additional array
        if(is_array($additional) && sizeof($additional)> 0){
            $screenIdArray = array_merge($screenIdArray,$additional);
        }
        //If all access
        if(isset($screenIdArray[0]) && $screenIdArray[0] === 0){
            $screenIdArray = ManageScreen::where('MANAGE_SCREEN_ID' ,'>' ,250)->pluck('MANAGE_SCREEN_ID');
            $screenIdArray = json_decode($screenIdArray,true);
        }                                  
        //return $screenIdArray;
        $current = 0;
        //Geneate sidebar object
        foreach($screenIdArray as $key=>$screenId){
            $screen = ManageScreen::find($screenId ?? 0);
            $submoduleId = $screen->MANAGE_SUBMODULE_ID ?? 0;
            $submodule = ManageSubmodule::find($submoduleId ?? 0);
            $moduleId = $submodule->MANAGE_MODULE_ID ?? 0;
            $modules[$moduleId] = $moduleId;
            $sub = new sidebar;
            $sub->name = $screen->SCREEN_ROUTE ?? 0;
            //$sub->path = $screen->SCREEN_ROUTE;
            //$sub->displayName = ucwords(strtolower($submodule->SUBMOD_NAME ?? ''));
            $sub->displayName = (strtoupper($submodule->SUBMOD_NAME ?? ''));
            $subsidebar[$moduleId][] = $sub;
            if ($current == $moduleId) {
            } else {
                $sub = new sidebar;
                $sub->name = 'dashboard-setting/'.$screen->SCREEN_ROUTE ?? '';
                $sub->path = 'dashboard-setting/'.$screen->SCREEN_ROUTE ?? '';
                $sub->displayName = 'Dashboard Setting';
                //$subsidebar[$moduleId][] = $sub;
            }
            $current = $moduleId;
        }
        foreach ($modules as $moduleId) {
            $module = ManageModule::find($moduleId);
            $s = new sidebar;
            $s->order = $module->MOD_INDEX ?? 0;
            $s->name = $module->MOD_SNAME ?? '';
            $s->path = $screen->SCREEN_ROUTE ?? '';
            //$s->displayName = ucwords(strtolower($module->MOD_NAME ?? ''));
            $s->displayName = (strtoupper($module->MOD_NAME ?? ''));
            $s->meta['iconClass'] = $module->MOD_ICON ?? '';
            $s->disabled = true;
            $s->children = $subsidebar[$moduleId];
            $sidebar[] = $s;
        }
        // Asc sort
        if(is_array($sidebar)){
            usort($sidebar,function($first,$second){
                return $first->order > $second->order;
            });
        }
        return $sidebar;
    }

    // Distributor Use User Access Function
    public function distributorSceenAccess($request){
        $sidebar = array();
        $subsidebar = array();
        $modules = array();
        //Screen Access for user Group MANAGE_SCREEN_ID
        $screenIdArray = DistributorScreenAccess::where('DISTRIBUTOR_MANAGE_GROUP_ID', 
                            $request->MANAGE_GROUP_ID)->value('DISTRIBUTOR_SCREEN_ID');
        $screenIdArray = json_decode($screenIdArray) ?? [];
        //return $screenIdArray;
        //If all access
        if(isset($screenIdArray[0]) && $screenIdArray[0] === 0){
            $screenIdArray = DistributorManageScreen::pluck('DISTRIBUTOR_MANAGE_SCREEN_ID');
            $screenIdArray = json_decode($screenIdArray,true);
        }                                  
        //return $screenIdArray;
        $current = 0;
        //Geneate sidebar object
        foreach($screenIdArray as $key=>$screenId){
            $screen = DistributorManageScreen::find($screenId ?? 0);
            $submoduleId = $screen->DISTRIBUTOR_MANAGE_SUBMODULE_ID ?? 0;
            $submodule = DistributorManageSubmodule::find($submoduleId ?? 0);
            $moduleId = $submodule->DISTRIBUTOR_MODULE_ID ?? 0;
            $modules[$moduleId] = $moduleId;
            $sub = new sidebar;
            $sub->name = ($screen->DISTRIBUTOR_SCREEN_ROUTE ?? 0);
            $sub->displayName = (strtoupper($submodule->DISTRIBUTOR_SUBMODULE_NAME ?? ''));
            $subsidebar[$moduleId][] = $sub;
            if ($current == $moduleId) {
            } else {
                $sub = new sidebar;
                $sub->name = 'dashboard-setting/'.$screen->DISTRIBUTOR_SCREEN_ROUTE ?? '';
                $sub->path = 'dashboard-setting/'.$screen->DISTRIBUTOR_SCREEN_ROUTE ?? '';
                $sub->displayName = 'Dashboard Setting';
                //$subsidebar[$moduleId][] = $sub;
            }
            $current = $moduleId;
        }
        foreach ($modules as $moduleId) {
            $module = DistributorManageModule::find($moduleId);
            $s = new sidebar;
            $s->order = $module->DISTRIBUTOR_MOD_INDEX ?? 0;
            $s->name = $module->DISTRIBUTOR_MOD_SNAME ?? '';
            $s->path = $screen->DISTRIBUTOR_SCREEN_ROUTE ?? '';
            //$s->displayName = ucwords(strtolower($module->MOD_NAME ?? ''));
            $s->displayName = (strtoupper($module->DISTRIBUTOR_MOD_NAME ?? ''));
            $s->meta['iconClass'] = $module->DISTRIBUTOR_MOD_ICON ?? '';
            $s->disabled = true;
            $s->children = $subsidebar[$moduleId];
            $sidebar[] = $s;
        }
        if(is_array($sidebar)){
            usort($sidebar,function($first,$second){
                return $first->order > $second->order;
            });
        }
        return $sidebar;
    }

    // CONSULTANT User Access Function
    public function consultantSceenAccess($request){
        $sidebar = array();
        $subsidebar = array();
        $modules = array();
        //Screen Access for user Group MANAGE_SCREEN_ID
        $screenIdArray = ConsultantScreenAccess::where('CONSULTANT_MANAGE_GROUP_ID', 
                            $request->MANAGE_GROUP_ID)->value('CONSULTANT_SCREEN_ID');
        $screenIdArray = json_decode($screenIdArray,true) ?? [];
        //If all access
        if(isset($screenIdArray[0]) && $screenIdArray[0] === 0){
            $screenIdArray = ConsultantManageScreen::pluck('DISTRIBUTOR_MANAGE_SCREEN_ID');
            $screenIdArray = json_decode($screenIdArray,true);
        }                                  
        //return $screenIdArray;
        $current = 0;
        //Geneate sidebar object
        foreach($screenIdArray as $key=>$screenId){
            $screen = ConsultantManageScreen::find($screenId ?? 0);
            $submoduleId = $screen->CONSULTANT_MANAGE_SUBMODULE_ID ?? 0;
            $submodule = ConsultantManageSubmodule::find($submoduleId ?? 0);
            $moduleId = $submodule->CONSULTANT_MODULE_ID ?? 0;
            $modules[$moduleId] = $moduleId;
            $sub = new sidebar;
            $sub->name = $screen->CONSULTANT_SCREEN_ROUTE ?? 0;
            $sub->displayName = (strtoupper($submodule->CONSULTANT_SUBMODULE_NAME ?? ''));
            $subsidebar[$moduleId][] = $sub;
            if ($current == $moduleId) {
            } else {
                $sub = new sidebar;
                $sub->name = 'dashboard-setting/'.$screen->CONSULTANT_SCREEN_ROUTE ?? '';
                $sub->path = 'dashboard-setting/'.$screen->CONSULTANT_SCREEN_ROUTE ?? '';
                $sub->displayName = 'Dashboard Setting';
                //$subsidebar[$moduleId][] = $sub;
            }
            $current = $moduleId;
        }
        foreach ($modules as $moduleId) {
            $module = ConsultantManageModule::find($moduleId);
            $s = new sidebar;
            $s->order = $module->CONSULTANT_MOD_INDEX ?? 0;
            $s->name = $module->CONSULTANT_MOD_SNAME ?? '';
            $s->path = $screen->CONSULTANT_SCREEN_ROUTE ?? '';
            //$s->displayName = ucwords(strtolower($module->MOD_NAME ?? ''));
            $s->displayName = (strtoupper($module->CONSULTANT_MOD_NAME ?? ''));
            $s->meta['iconClass'] = $module->CONSULTANT_MOD_ICON ?? '';
            $s->disabled = true;
            $s->children = $subsidebar[$moduleId];
            $sidebar[] = $s;
        }
        return $sidebar;
    }

    public function getAll()
    {
        try {
            $data = ManageModule::all();

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
        $validator = Validator::make($request->all(), [
            'MOD_CODE' => 'required|string',
            'MOD_NAME' => 'required|string',
            'MOD_SNAME' => 'required|string',
            'MOD_INDEX' => 'required|integer',
            'MOD_ICON' => 'required|string',
        ]);

        if ($validator->fails()) {
            http_response_code(400);
            return response([
                'message' => 'Data validation error.',
                'errorCode' => 4106,
            ], 400);
        }

        try {
            $module = new ManageModule;
            $module->MOD_CODE = $request->MOD_CODE;
            $module->MOD_NAME = $request->MOD_NAME;
            $module->MOD_SNAME = $request->MOD_SNAME;
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

    public function update($id)
    {
        $validator = Validator::make($request->all(), [
            'test' => 'required|string' //test
        ]);

        try {
            //update function

            http_response_code(200);
            return response([
                'message' => '',
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

    public function delete($id)
    {
        try {

            $data = ManageModule::find($id);
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
