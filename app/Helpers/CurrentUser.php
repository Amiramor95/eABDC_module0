<?php

namespace App\Helpers;

use App\Helpers\Decrypt;
use App\Models\KeycloakDefaultGroup;
use App\Models\KeycloakSettings;
use App\Models\PasswordHistory;

use Config;
use Ixudra\Curl\Facades\Curl;

class CurrentUser
{
    public function getUserDetails($token)
    {
        $response = Curl::to(env('KEYCLOAK_BASE_URL', 0) . '/realms/ldap-realm/protocol/openid-connect/userinfo')
            ->withBearer($token)
            ->get();
        $response = json_decode($response, true);
        return $response;
    }

    public function changePassword(Request $request)
    {
        $token = $request->bearerToken();
        $response = Curl::to(env('KEYCLOAK_BASE_URL', 0) . '/realms/ldap-realm/account/credentials/password')
            ->withBearer($token)
            ->withData([
                'currentPassword' => $request->oldPassword,
                'newPassword' => $request->newPassword,
                'confirmation' => $request->confirmation,
            ])
            ->post();

        if ($response) { //if password successfully changed, then update PASSWORD_HISTORY table

            $secret = random_bytes(30);
            $data = new Decrypt();
            $hashedOldPassword = $data->hashingOldPass($request->oldPassword, $secret);

            $passwordLog = new PasswordHistory;
            $passwordLog->KEYCLOAK_ID = $request->KEYCLOAK_ID;
            $passwordLog->PASSWORD = $hashedOldPassword;
            $passwordLog->SECRET = $secret;
            $passwordLog->save();
        }

        return $response;
    }

    public function comparePreviousPassword(Request $request)
    {
        $passwords = PasswordHistory::where('KEYCLOAK_ID', $request->KEYCLOAK_ID)->get();

        $checkIfValid = false;

        foreach ($passwords as $password) {
            $data = new Decrypt();
            $checkIfValid = $data->compareOldPass($password->PASSWORD, $request->password, $password->SECRET);

            if ($checkIfValid) {
                break;
            }
        }

        return $checkIfValid;
    }

    public static function userType()
    {
        if (session()->has('user')) {
            $user = session()->get('user', false);

            return $user->userType;
        } else {
            return null;
        }
    }

    public function createUser($parameter)
    {
        $data = new Decrypt();
        $admin = $data->keycloakAdminPass();

        $setting = KeycloakSettings::where('KEYCLOAK_REALM_NAME', 'master')
            ->first();

        $response = Curl::to($setting->KEYCLOAK_TOKEN_URL)

            ->withData([
                'username' => $admin['username'],
                'password' => $admin['password'],
                'client_id' => $setting->KEYCLOAK_CLIENT_ID,
                'grant_type' => 'password',
                'client_secret' => $setting->KEYCLOAK_CLIENT_SECRET,
            ])
            ->post();

        $response = json_decode($response, true);

        $token = $response['access_token']; //get admin token

        $response = Curl::to(env('KEYCLOAK_BASE_URL', 0) . '/admin/realms/' . env('KEYCLOAK_REALM', 0) . '/users')
            ->withBearer($token)
            ->withData(
                array(
                'email' => $parameter->email,
                'enabled' => true,
                'username' => $parameter->username,
                'emailVerified' => false,
                'credentials' => [[
                    'type' => 'password',
                    'value' => $parameter->password,
                    'temporary' => false,
                ]],
            )
            )
            ->asJson()
            ->post();
        return $response;
    }

    public function addToMainGroup($keycloakId, $group)
    {
        //decrypt Keycloak admin details
        $data = new Decrypt();
        $admin = $data->keycloakAdminPass();

        $groupDetails = KeycloakDefaultGroup::find($group); //1 : FiMM User , 2 : Distributor , 3 : Consultant , 4 : Training Provider , 5 : Third Party
        $groupId = $groupDetails->GROUP_ID;
        // dd($groupId);
        $setting = KeycloakSettings::where('KEYCLOAK_REALM_NAME', 'master')
            ->first();

        $response = Curl::to($setting->KEYCLOAK_TOKEN_URL)

            ->withData([
                'username' => $admin['username'],
                'password' => $admin['password'],
                'client_id' => $setting->KEYCLOAK_CLIENT_ID,
                'grant_type' => 'password',
                'client_secret' => $setting->KEYCLOAK_CLIENT_SECRET,
            ])
            ->post();

        $response = json_decode($response, true);

        $token = $response['access_token'];
        $response = Curl::to(env('KEYCLOAK_BASE_URL', 0) . '/admin/realms/' . env('KEYCLOAK_REALM', 0) . '/users/' . $keycloakId . '/groups/' . $groupId)
            ->withBearer($token)
            ->put();

        return $response;
    }

    public function resetPassword($parameter)
    {
        //decrypt Keycloak admin details
        $data = new Decrypt();
        $admin = $data->keycloakAdminPass();

        $setting = KeycloakSettings::where('KEYCLOAK_REALM_NAME', 'master')
            ->first();

        $response = Curl::to($setting->KEYCLOAK_TOKEN_URL)

            ->withData([
                'username' => $admin['username'],
                'password' => $admin['password'],
                'client_id' => $setting->KEYCLOAK_CLIENT_ID,
                'grant_type' => 'password',
                'client_secret' => $setting->KEYCLOAK_CLIENT_SECRET,
            ])
            ->post();

        $response = json_decode($response, true);

        $token = $response['access_token']; //get admin token
        /**
         * Paramater to pass : KEYCLOAK_ID ->Keycloak User Id
         */
        $response = Curl::to(env('KEYCLOAK_BASE_URL', 0) . '/admin/realms/' . env('KEYCLOAK_REALM', 0) . '/users/' . $parameter->KEYCLOAK_ID . '/reset-password')
            ->withBearer($token)
            ->withData(array('type' => 'password', 'temporary' => 'false', 'value' => $parameter->newPassword))
            ->asJson()
            ->put();

        return $response;
    }

    public function resetPasswordByTAC($parameter) //pending
    {
        $token = $request->bearerToken();
        $response = Curl::to(env('KEYCLOAK_BASE_URL', 0) . '/realms/ldap-realm/account/credentials/password')
            ->withBearer($token)
            ->withData([
                'currentPassword' => $request->oldPassword,
                'newPassword' => $request->newPassword,
                'confirmation' => $request->confirmation,
            ])
            ->post();

        return $response;
    }

    public function resetPasswordByEmail($parameter)
    {
        $token = $request->bearerToken();
        $response = Curl::to(env('KEYCLOAK_BASE_URL', 0) . '/admin/realms/' . env('REALM', 0) . '/user/' . $parameter->KEYCLOAK_ID . '/execute-actions-email')
            ->withBearer($token)
            ->withData(["UPDATE_PASSWORD"])
            ->post();
        return $response;
    }

    public static function HasAccess($parameter)
    {
        $proceed = false;

        switch (self::UserType()) {
            case 'admin':
                $proceed = config('access.admin.' . $access, false);
                break;
            case 'parent':
                $proceed = config('access.parent.' . $access, false);
                break;
            case 'agent':
                $proceed = config('access.agent.' . $access, false);
                break;
            case 'saleOperator':
                $proceed = config('access.saleOperator.' . $access, false);
                break;
            case 'teacher':
                $proceed = config('access.teacher.' . $access, false);
                break;
            case 'bookshop':
                $proceed = config('access.bookshopAgent.' . $access, false);
                break;
            case 'serviceProvider':
                $proceed = config('access.serviceProvider.' . $access, false);
                break;
            case 'soleProprietor':
                $proceed = config('access.soleProprietor.' . $access, false);
                break;
            case 'moderator':
                $proceed = config('access.moderator.' . $access, false);
                break;
        }

        return $proceed;
    }
}
