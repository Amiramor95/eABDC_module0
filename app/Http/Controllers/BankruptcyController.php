<?php

namespace App\Http\Controllers;

use GuzzleHttp\Exception\RequestException;
use App\Models\Consultant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Ixudra\Curl\Facades\Curl;
use Validator;

class BankruptcyController extends Controller
{
    public function check(Request $request)
    {
        $type= $request->EntityType;
        $name = $request->EntityName;
        $id = $request->EntityId;
        $mobileNo = $request->MobileNo;
        $email = $request->EmailAddress;
        $address = $request->LastKnownAddress;
        $ref2 = $request->Ref2;
        $api_url = 'https://b2buat.experian.com.my/index.php/fimm/nrvb/';
        // $username = 'FIMMB2BPRS';
        // $password = 'H6j3S7';
        $username = 'FIM1';
        // $password = 'Fimm.1';
        $password = 'Fimmfim.1';
        // $username = 'FIMPRS';
        // $password = 'Fimm.1';


        try {
            $curl = curl_init();

            curl_setopt_array($curl, array(
            CURLOPT_URL => $api_url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_HTTPAUTH => CURLAUTH_BASIC,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS =>'<?xml version= "1.0" encoding= "utf-8"?>
            <xml>
            <request>
            <EntityType>'. $type .'</EntityType>
            <EntityName>'. $name .'</EntityName>
            <EntityId>'. $id .'</EntityId>
            <MobileNo>'. $mobileNo .'</MobileNo>
            <EmailAddress>'. $email .'</EmailAddress  >
            <LastKnownAddress>
            '. $address .'
            </LastKnownAddress>
            <Ref2>'. $ref2 .'</Ref2>

            </request>
            </xml>',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/xml',
                'Authorization: Basic '. base64_encode("$username:$password")
            ),
            ));

            $response = curl_exec($curl);

            curl_close($curl);
            // echo $response;

            // <EntityType>I</EntityType>
            // <EntityName>ALI BIN ABU</EntityName>
            // <EntityId>999999-99-9999</EntityId>
            // <MobileNo>60123456789</MobileNo>
            // <EmailAddress>ali.abu@email.com</EmailAddress>
            // <LastKnownAddress>
            // 199, Jalan Haji Harun,
            // Kampung Baru Kepong,
            // Kuala Lumpur
            // </LastKnownAddress>
            // <Ref2>FIMM10000001</Ref2>



            // <EntityType>' + $type + '</EntityType>
            // <EntityName>' + $name + '</EntityName>
            // <EntityId>' + $id + '</EntityId>
            // <MobileNo>' + $mobileNo + '</MobileNo>
            // <EmailAddress>' + $email + '</EmailAddress  >
            // <LastKnownAddress>
            // ' + $address + '
            // </LastKnownAddress>
            // <Ref2>' + $ref2 + '</Ref2>
            $xmlObject = simplexml_load_string($response);
            $json = json_encode($xmlObject);
            $response1 = json_decode($json, true);


            return response([
                'message' => 'All data successfully retrieved.',
                'data' => $response1
            ]);
        } catch (RequestException $r) {
            http_response_code(400);
            return response([
                'message' => 'Failed to retrieve data.',
                'errorCode' => 4103
            ], 400);
        }
    }

    public function bulkBankruptcyCheck(Request $request){
        try {
            //$consultantIds = json_decode($request->CONSULTANT_ID);
            $consultantIds = Consultant::whereIn('CONSULTANT_ID', json_decode($request->CONSULTANT_ID))->get();
            foreach ($consultantIds as $item) {
                $response = $this->bankruptcyCheck(
                   'I', //EntityType, required, (Always “I” for individual bankruptcy report)
                   $item->CONSULTANT_NAME, //EntityName, required
                   $item->CONSULTANT_NRIC, //EntityId, required
                   $item->CONSULTANT_MOBILE_NO, //MobileNo, either one
                   $item->CONSULTANT_EMAIL, //EmailAddress, either one
                   $item->CONSULTANT_CORRESPONDENT_ADDR1, //LastKnownAddress, either one
                   '',//Ref2 // Billing reference ( this should be a running number)
                );
                //dd($response);
            }

            http_response_code(200);
            return response([
                'message' => 'Data successfully retrieved.',
                'data' => '',
            ]);
        } catch (RequestException $r) {
            http_response_code(400);
            return response([
                'message' => 'Failed to retrieve data.',
                'errorCode' => 4103,
            ], 400);
        }
    }

    public function bankruptcyCheck($EntityType, $EntityName, $EntityId, $MobileNo, $EmailAddress, $LastKnownAddress, $Ref2){
        //dd($EntityType, $EntityName, $EntityId, $MobileNo, $EmailAddress, $LastKnownAddress, $Ref2);

        $type= $EntityType;
        $name = $EntityName;
        $id = $EntityId;
        $mobileNo = $MobileNo;
        $email = $EmailAddress;
        $address = $LastKnownAddress;
        $ref2 = $Ref2;
        $api_url = 'https://b2buat.experian.com.my/index.php/fimm/nrvb/';
        // $username = 'FIMMB2BPRS';
        // $password = 'H6j3S7';
        $username = 'FIM1';
        $password = 'Fimm.1';
        // $username = 'FIMPRS';
        // $password = 'Fimm.1';


        try {
            $curl = curl_init();

            curl_setopt_array($curl, array(
            CURLOPT_URL => $api_url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_HTTPAUTH => CURLAUTH_BASIC,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS =>'<?xml version= "1.0" encoding= "utf-8"?>
            <xml>
            <request>
            <EntityType>'. $type .'</EntityType>
            <EntityName>'. $name .'</EntityName>
            <EntityId>'. $id .'</EntityId>
            <MobileNo>'. $mobileNo .'</MobileNo>
            <EmailAddress>'. $email .'</EmailAddress  >
            <LastKnownAddress>
            '. $address .'
            </LastKnownAddress>
            <Ref2>'. $ref2 .'</Ref2>

            </request>
            </xml>',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/xml',
                'Authorization: Basic '. base64_encode("$username:$password")
            ),
            ));

            $response = curl_exec($curl);

            curl_close($curl);
            // echo $response;

            // <EntityType>I</EntityType>
            // <EntityName>ALI BIN ABU</EntityName>
            // <EntityId>999999-99-9999</EntityId>
            // <MobileNo>60123456789</MobileNo>
            // <EmailAddress>ali.abu@email.com</EmailAddress>
            // <LastKnownAddress>
            // 199, Jalan Haji Harun,
            // Kampung Baru Kepong,
            // Kuala Lumpur
            // </LastKnownAddress>
            // <Ref2>FIMM10000001</Ref2>



            // <EntityType>' + $type + '</EntityType>
            // <EntityName>' + $name + '</EntityName>
            // <EntityId>' + $id + '</EntityId>
            // <MobileNo>' + $mobileNo + '</MobileNo>
            // <EmailAddress>' + $email + '</EmailAddress  >
            // <LastKnownAddress>
            // ' + $address + '
            // </LastKnownAddress>
            // <Ref2>' + $ref2 + '</Ref2>
            $xmlObject = simplexml_load_string($response);
            $json = json_encode($xmlObject);
            $response = json_decode($json, true);

            return response([
                'message' => 'All data successfully retrieved.',
                'data' => $response
            ]);
        } catch (RequestException $r) {
            http_response_code(400);
            return response([
                'message' => 'Failed to retrieve data.',
                'errorCode' => 4103
            ], 400);
        }
    }

}
