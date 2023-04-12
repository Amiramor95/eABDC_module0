<?php

namespace App\Http\Controllers;

use GuzzleHttp\Exception\RequestException;
use App\Models\SettingLdap;
use App\Helpers\LDAP;
use Illuminate\Support\Facades\Http;
use Ixudra\Curl\Facades\Curl;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\Log;
use LaravelKeycloakAdmin\Facades\KeycloakAdmin;

class SettingLdapController extends Controller
{
    public function get()
    {
        try {
            $data = SettingLdap::orderBy('SETTING_IDAP_ID', 'desc')->first();

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

    public function getAll()
    {
        try {
            $data = SettingLdap::all();

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

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'LDAP_ATTR_RDN' => 'required|string',
            'LDAP_ATTR_UUID' => 'required|string',
            'LDAP_USER_OBJ' => 'required|string',
            'LDAP_CONN_URL' => 'required|string',
            'LDAP_USER_DN' => 'required|string',
            'LDAP_BIND_TYPE' => 'required|string',
            'LDAP_BIND_DN' => 'required|string',
            'LDAP_BIND_CRED' => 'required|string',
            ]);
           // Log::info( "request ===>" . $request->all());
            if ($validator->fails()) {
            http_response_code(400);
            return response([
            'message' => 'Data validation error.',
            'errorCode' => 4106
            ],400);
            }

            $data = new SettingLdap;
            $data->LDAP_ATTR_RDN = $request->LDAP_ATTR_RDN;
            $data->LDAP_ATTR_UUID = $request->LDAP_ATTR_UUID;
            $data->LDAP_USER_OBJ = $request->LDAP_USER_OBJ;
            $data->LDAP_CONN_URL = $request->LDAP_CONN_URL;
            $data->LDAP_USER_DN = $request->LDAP_USER_DN;
            $data->LDAP_USER_FILTER = $request->LDAP_USER_FILTER;
            $data->LDAP_SEARCH_SCOPE = $request->LDAP_SEARCH_SCOPE;
            $data->LDAP_BIND_TYPE = $request->LDAP_BIND_TYPE;
            $data->LDAP_BIND_DN = $request->LDAP_BIND_DN;
            $data->LDAP_BIND_CRED = $request->LDAP_BIND_CRED;
            $data->save();
            try {
            //create function
            http_response_code(200);
            return response([
            'message' => 'Data successfully Inserted.'
            ]);

            } catch (RequestException $r) {
            http_response_code(400);
            return response([
            'message' => 'Data failed to be created.',
            'errorCode' => 4100
            ],400);
            }

    }

    public function test(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'bindDn' => 'required|string', //CN=dummy,OU=HR Admin,DC=ad,DC=vn,DC=my
            'bindCredential' => 'required|string', //@Bcd1234
            'connectionUrl' => 'required|string' //ldap://192.168.3.199:389
        ]);

        try {
            //$ldap = new LDAP;
            //$testLDAP = $ldap->testLDAP($request);
            // $ldap = KeycloakAdmin::addon()->testLDAPConnection([
            //     'body' => [
            //         'action' => 'testAuthentication',
            //         'authType' => 'simple',
            //         'bindCredential' => $request->bindCredential,
            //         'bindDn' => $request->bindDn,
            //         'connectionUrl' => $request->connectionUrl,
            //         'startTls' => false,
            //         'useTruststoreSpi' => 'Only for ldaps',
            //     ],
            // ]);
            //dd($testLDAP);
            //office
            $LDAP_CONN_URL = $request->LDAP_CONN_URL;
            $LDAP_USER_DN = $request->LDAP_USER_DN;
            $LDAP_BIND_DN = $request->LDAP_BIND_DN;

            $ldapHost = $LDAP_CONN_URL;
            //"ldap://192.168.104.88:389";
            $pwd = "";
            $bindDn = $LDAP_USER_DN . ','. $LDAP_BIND_DN;
            //"uid=lfcs,DC=fimm,DC=net";
            $conn = ldap_connect($ldapHost);
            //ldap_set_option($conn, LDAP_OPT_PROTOCOL_VERSION, 3);
            if($conn){
                $ldapbind = ldap_bind($conn, $bindDn, $pwd);
                if ($ldapbind) {
                    Log::info("Okay");
                    http_response_code(200);
                    return response([
                        'message' => 'LDAP successfully tested and able to connect.',
                        "status" => 200,
                    ]);
                }else{
                    Log::info("Error?");
                }
            }
            http_response_code(400);
            return response([
                'message' => 'LDAP unsuccessful to connect.',
                "status" => 400,
            ]);
            //other ldap test
            // $ldaprdn  = 'cn=read-only-admin,ou=scientists,dc=example,dc=com';     // ldap rdn or dn
            // $ldappass = 'password';  // associated password

            // // connect to ldap server
            // $ldapconn = ldap_connect("ldap://ldap.forumsys.com:389")
            //     or die("Could not connect to LDAP server.");

            // if ($ldapconn) {
            //     //ldap_set_option($ldapconn, LDAP_OPT_PROTOCOL_VERSION, 3);
            //     // binding to ldap server
            //     $ldapbind = ldap_bind($ldapconn, $ldaprdn, $ldappass);

            //     // verify binding
            //     if ($ldapbind) {
            //         Log::info("LDAP bind successful...");
            //     } else {
            //         Log::info("LDAP bind failed...");
            //     }

            // }

        } catch (RequestException $r) {

            http_response_code(400);
            return response([
                'message' => 'LDAP connection is not successful.',
                'errorCode' => 4005
            ]);
        }

    }

    public function manage(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'test' => 'required|string' //test
        ]);

        if ($validator->fails()) {
            http_response_code(400);
            return response([
                'message' => 'Data validation error.',
                'errorCode' => 4106
            ],400);
        }

        try {
            //manage function
            $model = SettingLdap::first();
            // $model->EMAIL_SMTP_PORT = $request->EMAIL_SMTP_PORT;
            // $model->EMAIL_SMTP_SERVER = $request->EMAIL_SMTP_SERVER;
            // $model->EMAIL_FROM = $request->EMAIL_FROM;
            // $model->EMAIL_LOGIN_ID = $request->EMAIL_LOGIN_ID;
            $model->LDAP_ATTR_RDN = $request->LDAP_ATTR_RDN; // cn
            $model->LDAP_ATTR_UUID = $request->LDAP_ATTR_UUID; // objectGUID
            $model->LDAP_USER_OBJ = $request->LDAP_USER_OBJ; // person,organisationalPerson,user
            $model->LDAP_USER_URL = $request->LDAP_USER_URL; // ldap://192.163.3.199:389
            $model->LDAP_USER_DN = $request->LDAP_USER_DN; // OU=HR Admin,DC=ad,DC=vn,DC=my
            $model->LDAP_USER_FILTER = $request->LDAP_USER_FILTER; // LDAP Filter
            $model->LDAP_SEARCH_SCOPE = $request->LDAP_SEARCH_SCOPE; // One Level
            $model->LDAP_BIND_TYPE = $request->LDAP_BIND_TYPE; // simple
            $model->LDAP_BIND_DN = $request->LDAP_BIND_DN; // CN=dummy,OU=HR Admin,DC=ad,DC=vn,DC=my
            $model->LDAP_BIND_CRED = $request->LDAP_BIND_CRED; // @Bcd1234
            $model->save();

            http_response_code(200);
            return response([
                'message' => ''
            ]);

        } catch (RequestException $r) {

            http_response_code(400);
            return response([
                'message' => '',
                'errorCode' => 4104
            ],400);
        }
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'LDAP_ATTR_RDN' => 'required|string',
            'LDAP_ATTR_UUID' => 'required|string',
            'LDAP_USER_OBJ' => 'required|string',
            'LDAP_CONN_URL' => 'required|string',
            'LDAP_USER_DN' => 'required|string',
            'LDAP_BIND_TYPE' => 'required|string',
            'LDAP_BIND_DN' => 'required|string',
            'LDAP_BIND_CRED' => 'required|string',
            ]);
            Log::info( "request ===>" . $request->SETTING_IDAP_ID);
            if ($validator->fails()) {
            http_response_code(400);
            return response([
            'message' => 'Data validation error.',
            'errorCode' => 4106
            ],400);
            }


            $data = SettingLdap::where('SETTING_IDAP_ID',$request->SETTING_IDAP_ID);

            $data->where('SETTING_IDAP_ID',$request->SETTING_IDAP_ID)->update([ 
                'LDAP_ATTR_RDN' => $request->LDAP_ATTR_RDN,
                'LDAP_ATTR_UUID' => $request->LDAP_ATTR_UUID,
                'LDAP_USER_OBJ' => $request->LDAP_USER_OBJ,
                'LDAP_CONN_URL' => $request->LDAP_CONN_URL,
                'LDAP_USER_DN' => $request->LDAP_USER_DN,
                'LDAP_USER_FILTER' => $request->LDAP_USER_FILTER,
                'LDAP_SEARCH_SCOPE' => $request->LDAP_SEARCH_SCOPE,
                'LDAP_BIND_TYPE' => $request->LDAP_BIND_TYPE,
                'LDAP_BIND_DN' => $request->LDAP_BIND_DN,
                'LDAP_BIND_CRED' => $request->LDAP_BIND_CRED,
                ]);
           /* $data->LDAP_ATTR_RDN = $request->LDAP_ATTR_RDN;
            $data->LDAP_ATTR_UUID = $request->LDAP_ATTR_UUID;
            $data->LDAP_USER_OBJ = $request->LDAP_USER_OBJ;
            $data->LDAP_CONN_URL = $request->LDAP_CONN_URL;
            $data->LDAP_USER_DN = $request->LDAP_USER_DN;
            $data->LDAP_USER_FILTER = $request->LDAP_USER_FILTER;
            $data->LDAP_SEARCH_SCOPE = $request->LDAP_SEARCH_SCOPE;
            $data->LDAP_BIND_TYPE = $request->LDAP_BIND_TYPE;
            $data->LDAP_BIND_DN = $request->LDAP_BIND_DN;
            $data->LDAP_BIND_CRED = $request->LDAP_BIND_CRED;
            $data->save();*/
            try {
            //create function
            http_response_code(200);
            return response([
            'message' => 'Data successfully Updated.'
            ]);

            } catch (RequestException $r) {
            http_response_code(400);
            return response([
            'message' => 'Data failed to be update.',
            'errorCode' => 4100
            ],400);
            }
    }

    public function delete($id)
    {
        try {
            $data = SettingLdap::find($id);
            $data->delete();

            http_response_code(200);
            return response([
                'message' => 'Data successfully deleted.'
            ]);

        } catch (RequestException $r) {

            http_response_code(400);
            return response([
                'message' => 'Data failed to be deleted.',
                'errorCode' => 4102
            ],400);
        }
    }

    public function filter(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'test' => 'required|string' //test
        ]);

        if ($validator->fails()) {
            http_response_code(400);
            return response([
                'message' => 'Data validation error.',
                'errorCode' => 4106
            ],400);
        }

        try {
            //manage function

            http_response_code(200);
            return response([
                'message' => 'Filtered data successfully retrieved.'
            ]);

        } catch (RequestException $r) {

            http_response_code(400);
            return response([
                'message' => 'Filtered data failed to be retrieved.',
                'errorCode' => 4105
            ],400);
        }
    }
}
