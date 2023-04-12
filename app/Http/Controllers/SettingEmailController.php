<?php

namespace App\Http\Controllers;

use App\Mail\NewUserNotification;
use App\Mail\casEmailNotification;
use App\Mail\casEmailBarring;
use App\Mail\acceptanceEmail;
use App\Mail\TPNewUserNotification;
use App\Mail\distributorRegistrationApprovalEmail;
use App\Mail\suspendRevokeCeoEmail;
use App\Mail\cessationEmail;
use App\Mail\trpRegistrationApprovalEmail;
use App\Mail\thirdPartyRegistrationApprovalEmail;
use App\Mail\TestMail;
use App\Mail\mediaNewUserRegistration;
use App\Mail\mediaNewUserRegistrationOtp;
use App\Mail\mediaNewUserRejected;
use App\Models\EmailTac;
use App\Models\SettingEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Validator;
use \Swift_Mailer;
use \Swift_MailTransport;
use GuzzleHttp\Exception\RequestException;
use App\Mail\DistributorEmailTacNotification;

use Ixudra\Curl\Facades\Curl;
use Illuminate\Support\Facades\Log;

class SettingEmailController extends Controller
{
    public function get()
    {
        $emailSetting = SettingEmail::orderBy('SETTING_EMAIL_ID', 'desc')->first();

        http_response_code(200);
        return response([
            'message' => 'Email Settings successfully retrieved.',
            'data' => $emailSetting
        ]);
    }
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'EMAIL_SMTP_PORT' => 'required', //587
            'EMAIL_SMTP_SERVER' => 'required|string', //smtp.gmail.com
            'EMAIL_FROM' => 'required|string', //fimm.demo@gmail.com
            'EMAIL_LOGIN_ID' => 'required|string', //pyhupykajwokvagp
            'EMAIL_LOGIN_PASS' => 'required|string',
            'EMAIL_LOGIN_PASS_VER1' => 'required|string',
        ]);
        if ($validator->fails()) {
            http_response_code(400);
            return response([
            'message' => 'Data validation error.',
            'errorCode' => 4106
            ], 400);
        }

        try {
            $data = SettingEmail::where('SETTING_EMAIL_ID', $request->SETTING_EMAIL_ID);
            $data->where('SETTING_EMAIL_ID', $request->SETTING_EMAIL_ID)->update([
                'EMAIL_FROM' => $request->EMAIL_FROM,
                'NOTIFICATION_TO' => $request->NOTIFICATION_TO,
                'EMAIL_SECURITY' => $request->EMAIL_SECURITY,
                'EMAIL_SMTP_SERVER' => $request->EMAIL_SMTP_SERVER,
                'EMAIL_SMTP_PORT' => $request->EMAIL_SMTP_PORT,
                'EMAIL_LOGIN_ID' => $request->EMAIL_LOGIN_ID,
                'EMAIL_LOGIN_PASS' => $request->EMAIL_LOGIN_PASS,
                'EMAIL_LOGIN_PASS_VER1' => $request->EMAIL_LOGIN_PASS_VER1,
                ]);

            http_response_code(200);
            return response([
                'message' => 'Email Setting successfully Updated.'
            ]);
        } catch (RequestException $r) {
            http_response_code(400);
            return response([
                'message' => 'Email Setting connection failed to be Update.',
                'errorCode' => 4001
            ]);
        }
    }

    public function testConnection(Request $request)
    {
        Log::info("request => ", $request->all());
        Log::info("request => " . $request->EMAIL_SMTP_SERVER);
        $target = $request->EMAIL_SMTP_SERVER;
        //"smtp.office365.com";
        $port = $request->EMAIL_SMTP_PORT;
        //25;
        $error_number = "";
        $error_string = "";
        $timeout = 9;
        $newline = "\n\r";
        $log = [];

        $data = array(
                'email' => $request->NOTIFICATION_TO,
                'name' => 'Fimm'
            );
        try {
            //test send mail
            Mail::to($data['email'])->send(new TestMail($data));
            /// Server Connection
            $con = fsockopen($target, $port, $errno, $errstr, $timeout);
            $response = fgets($con, 4096);
            if (empty($con)) {
                $log['error'][] = "Failed to connect: $response";
                var_dump($log);
                exit;
            } else {
                $log['connection'][] = "Connected to: $response";
            }
            fputs($con, "HELO" . $newline);
            $response = fgets($con, 4096);
            $log['connection'][] = "$response";
            Log::info("Started execution");
            try {
                Log::info("Successful");
                $transport = new \Swift_SmtpTransport($request->EMAIL_SMTP_SERVER, $request->EMAIL_SMTP_PORT, 'tls');
                $transport->setUsername($request->EMAIL_LOGIN_ID);
                $transport->setPassword($request->EMAIL_LOGIN_PASS);
                $mailer = new Swift_Mailer($transport);
                $mailer->getTransport()->start();
            } catch (Swift_TransportException $e) {
                Log::info("Error Transportation# " . $e->getMessage());
                return response([
                        'message' => $e->getMessage(),
                        'status' => 400
                    ]);
            } catch (Exception $e) {
                Log::info("Error Exception# " . $e->getMessage());
                return response([
                    'message' => $e->getMessage(),
                    'status' => 400
                    ]);
            }

        } catch (RequestException $err) {
            var_dump($err);
        }
        return response([
                'message' => 'Email setting successfully connected.',
                'status' => 200
            ]);
    }

    public function manage(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'EMAIL_SMTP_PORT' => 'required', //587
            'EMAIL_SMTP_SERVER' => 'required|string', //smtp.gmail.com
            'EMAIL_FROM' => 'required|string', //fimm.demo@gmail.com
            'EMAIL_LOGIN_ID' => 'required|string', //pyhupykajwokvagp
            'EMAIL_LOGIN_PASS' => 'required|string',
            'EMAIL_LOGIN_PASS_VER1' => 'required|string',
        ]);
        if ($validator->fails()) {
            http_response_code(400);
            return response([
            'message' => 'Data validation error.',
            'errorCode' => 4106
            ], 400);
        }

        try {
            $data = new SettingEmail;
            $data->EMAIL_FROM = $request->EMAIL_FROM;
            $data->NOTIFICATION_TO = $request->NOTIFICATION_TO;
            $data->EMAIL_SECURITY = $request->EMAIL_SECURITY;
            $data->EMAIL_SMTP_SERVER = $request->EMAIL_SMTP_SERVER;
            $data->EMAIL_SMTP_PORT = $request->EMAIL_SMTP_PORT;
            $data->EMAIL_LOGIN_ID = $request->EMAIL_LOGIN_ID;
            $data->EMAIL_LOGIN_PASS = $request->EMAIL_LOGIN_PASS;
            $data->EMAIL_LOGIN_PASS_VER1 = $request->EMAIL_LOGIN_PASS_VER1;
            $data->save();

            http_response_code(200);
            return response([
                'message' => 'Email setting successfully configured.'
            ]);
        } catch (RequestException $r) {
            http_response_code(400);
            return response([
                'message' => 'Email connection failed to be configured.',
                'errorCode' => 4001
            ]);
        }
    }

    public function test()
    {
        $email = Email::first();

        http_response_code(200);
        return response([
            'message' => 'Email successfully retrieved.',
            'data' => $email
        ]);
    }

    public function send(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email' //Hello there
        ]);

        try {
            $pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

            $otp = substr(str_shuffle(str_repeat($pool, 5)), 0, 8);

            $settings = SettingEmail::all();
            $data = array(
                'email' => $request->email,
                'name' => $request->name,
                'userid' => $request->userid,
                'otp' => $otp,
                'loginUrl' => $request->loginUrl
            );

            Mail::to($data['email'])->send(new NewUserNotification($data));

            http_response_code(200);
            return response([
                'message' => 'Email successfully send.',
                'data' => $otp
            ]);
        } catch (RequestException $r) {
            http_response_code(400);
            return response([
                'message' => 'Email failed to be sent.',
                'errorCode' => 4000
            ]);
        }
    }
    public function send_tac(Request $request)
    {
        // $validator = Validator::make($request->all(), [
        //     'email' => 'required|email' //Hello there
        // ]);

        try {
            $pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

            $otp = substr(str_shuffle(str_repeat($pool, 5)), 0, 8);
            Log::info( "emailtac ===>" . $request->useremail);

            $settings = SettingEmail::all();
            $data = array(
                'email' => $request->useremail,
               // 'name' => $request->name,
                'userid' => $request->userid,
                'otp' => $otp,
               // 'loginUrl' => $request->loginUrl
            );

            Mail::to($data['email'])->send(new DistributorEmailTacNotification($data));

            http_response_code(200);
            return response([
                'message' => 'Email successfully send.',
                'data' => $otp
            ]);
        } catch (RequestException $r) {
            http_response_code(400);
            return response([
                'message' => 'Email failed to be sent.',
                'errorCode' => 4000
            ]);
        }
    }

    public function send_consultant(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email' //Hello there
        ]);

        try {
            $settings = SettingEmail::all();
            $data = array(
                'email' => $request->email,
                'name' => $request->name,
                'userid' => $request->userid,
                'otp' => $request->otp,
                'loginUrl' => $request->loginUrl
            );

            Mail::to($data['email'])->send(new NewUserNotification($data));

            http_response_code(200);
            return response([
                'message' => 'Email successfully send.',
                'data' => $request->otp
            ]);
        } catch (RequestException $r) {
            http_response_code(400);
            return response([
                'message' => 'Email failed to be sent.',
                'errorCode' => 4000
            ]);
        }
    }

    public function sendTPEmail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email' //Hello there
        ]);

        try {
            $pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

            $otp = substr(str_shuffle(str_repeat($pool, 5)), 0, 16);

            $settings = SettingEmail::all();
            $data = array(
                'email' => $request->email,
                'name' => $request->name,
                'otp' => $otp,
                'loginUrl' => $request->loginUrl
            );

            Mail::to($data['email'])->send(new TPNewUserNotification($data));

            http_response_code(200);
            return response([
                'message' => 'Email successfully send.',
                'data' => $otp
            ]);
        } catch (RequestException $r) {
            http_response_code(400);
            return response([
                'message' => 'Email failed to be sent.',
                'errorCode' => 4000
            ]);
        }
    }

    public function sendCasEmail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email' //Hello there
        ]);

        try {
            $settings = SettingEmail::all();
            $data = array(
                'email' => $request->email,
                'title' => $request->title,
                'userName' => $request->userName,
                'consultantName' =>  $request->consultantName,
                'consultantNric' =>  $request->consultantNric,
                'consultantPassport' =>  $request->consultantPassport,
                'caRemark' =>  $request->caRemark,
                'caComment' => $request->caComment,
            );
            Mail::to($data['email'])->send(new casEmailNotification($data));

            http_response_code(200);
            return response([
                'message' => 'Email Notification successfully send.'

            ]);
        } catch (RequestException $r) {
            http_response_code(400);
            return response([
                'message' => 'Email Notification failed to be sent.',
                'errorCode' => 4000
            ]);
        }
    }

    public function sendCasBarring(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email' //Hello there
        ]);

        try {
            $settings = SettingEmail::all();
            $data = array(
                'email' => $request->email,
                'title' => $request->title,
                'userName' => $request->userName,
                'consultantName' =>  $request->consultantName,
                'consultantNric' =>  $request->consultantNric,
                'consultantPassport' =>  $request->consultantPassport,
                'caRemark' =>  $request->caRemark,
                'caEndDate' => $request->caEndDate,
            );
            Mail::to($data['email'])->send(new casEmailBarring($data));

            http_response_code(200);
            return response([
                'message' => 'Email Notification successfully send.'

            ]);
        } catch (RequestException $r) {
            http_response_code(400);
            return response([
                'message' => 'Email Notification failed to be sent.',
                'errorCode' => 4000
            ]);
        }
    }

    public function sendAcceptanceEmail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email' //Hello there
        ]);

        try {
            $settings = SettingEmail::all();
            $data = array(
                'email' => $request->email,
                'name' => $request->name,
                'nric' => $request->nric,
                'passportNo' => $request->passportNo,
                'phoneNo' => $request->phoneNo,
                'licenseType' => $request->licenseType,
                'staffOrAgent' => $request->staffOrAgent,
                'distName' => $request->distName,
                'title' => $request->title

            );
            Mail::to($data['email'])->send(new acceptanceEmail($data));

            http_response_code(200);
            return response([
                'message' => 'Email Notification successfully send.'


            ]);
        } catch (RequestException $r) {
            http_response_code(400);
            return response([
                'message' => 'Email Notification failed to be sent.',
                'errorCode' => 4000
            ]);
        }
    }

    public function sendDistRegEmail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email' //Hello there
        ]);
        try {
            $settings = SettingEmail::all();
            $data = array(
                'email' => $request->email,
                'distName' => $request->distName,
                'distRemark' => $request->distRemark
            );
            Mail::to($data['email'])->send(new distributorRegistrationApprovalEmail($data));

            http_response_code(200);
            return response([
                'message' => 'Email Notification successfully send.'
            ]);
        } catch (RequestException $r) {
            http_response_code(400);
            return response([
                'message' => 'Email Notification failed to be sent.',
                'errorCode' => 4000
            ]);
        }
    }

    public function sendsuspendRevokeCeoEmail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email' //Hello there
        ]);

        try {
            $settings = SettingEmail::all();
            $data = array(
                'email' => $request->email,
                'name' => $request->name,
                'distName' => $request->distName,
                'distRegNo' => $request->distRegNo,
                'distNewRegNo' => $request->distNewRegNo,
                'submissionType' => $request->submissionType,
                'dateStart' => $request->dateStart,
                'dateEnd' => $request->dateEnd,
                'effectiveDate' => $request->effectiveDate,
                'reason' => $request->reason,
                'title' => $request->title
            );

            Mail::to($data['email'])->send(new suspendRevokeCeoEmail($data));

            http_response_code(200);
            return response([
                'message' => 'Email Notification successfully send.'


            ]);
        } catch (RequestException $r) {
            http_response_code(400);
            return response([
                'message' => 'Email Notification failed to be sent.',
                'errorCode' => 4000
            ]);
        }
    }

    public function sendCeaseEmail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email' //Hello there
        ]);

        try {
            $settings = SettingEmail::all();
            $data = array(
                'email' => $request->email,
                'name' => $request->name,
                'distName' => $request->distName,
                'distRegNo' => $request->distRegNo,
                'distNewRegNo' => $request->distNewRegNo,
                'cessationName' => $request->cessationName,
                'cessationDate' => $request->cessationDate,
                'title' => $request->title

            );

            Mail::to($data['email'])->send(new cessationEmail($data));

            http_response_code(200);
            return response([
                'message' => 'Email Notification successfully send.'


            ]);
        } catch (RequestException $r) {
            http_response_code(400);
            return response([
                'message' => 'Email Notification failed to be sent.',
                'errorCode' => 4000
            ]);
        }
    }

    public function sendTRPRegEmail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email' //Hello there
        ]);
        try {
            $settings = SettingEmail::all();
            $data = array(
                'email' => $request->email,
                'trpName' => $request->trpName,
                'status' => $request->status
            );
            Mail::to($data['email'])->send(new trpRegistrationApprovalEmail($data));

            http_response_code(200);
            return response([
                'message' => 'Email Notification successfully send.'
            ]);
        } catch (RequestException $r) {
            http_response_code(400);
            return response([
                'message' => 'Email Notification failed to be sent.',
                'errorCode' => 4000
            ]);
        }
    }
    public function send3rdRegEmail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email' //Hello there
        ]);
        try {
            $settings = SettingEmail::all();
            $data = array(
                'email' => $request->email,
                'trpName' => $request->thirdPartyName,
                'status' => $request->status
            );
            Mail::to($data['email'])->send(new thirdPartyRegistrationApprovalEmail($data));

            http_response_code(200);
            return response([
                'message' => 'Email Notification successfully send.'
            ]);
        } catch (RequestException $r) {
            http_response_code(400);
            return response([
                'message' => 'Email Notification failed to be sent.',
                'errorCode' => 4000
            ]);
        }
    }

    public function emailOtp(Request $request)
    {
        $validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
            'email' => ['required', 'string'],
        ]);

        if ($validator->fails()) {
            http_response_code(400);
            return response([
                'message' => 'The given data was invalid.',
                'errorCode' => 4106,
                'errors' => $validator->errors()
            ], 400);
        }

        DB::beginTransaction();
        try {

            //New
            $tac = mt_rand(100000, 999999);

            $end_time = \Carbon\Carbon::now()->addMinutes(60)->timestamp;

            $request->tac = strval($tac);

            $email = $request->email;
            $data = [
                'tac' => $tac
            ];
            //send OTP to email
            Mail::send('emails.email-tac', ['data' => $data],
                function ($message) use ($email) {
                    $message->to($email);
                    $message->subject('Profile Update Email : Tac Code');
                });

            $smsTac = new EmailTac();
            $smsTac->EMAIL_TAC_NUMBER	= $tac;
            $smsTac->EMAIL_TAC_RECIPIENT = $request->email;
            $smsTac->EMAIL_TAC_END_TIME = $end_time;
            $smsTac->save();
            DB::commit();

            http_response_code(200);
            return response([
                'message' => 'OTP successfully send to email.',
                'tac' => $tac
            ]);

        } catch (\Exception $e) {
            DB::rollback();
            http_response_code(400);
            return response([
                'message' => $e->getMessage() ?? 'Failed to store data.',
                'errorCode' => 4103,
            ], 400);
        }
    }

    public function sendMediaUserEmail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email' //Hello there
        ]);

        try {
            $settings = SettingEmail::all();
            $data = array(
                'email' => $request->email,
                'title' => $request->title,
                'userName' => $request->userName,
                'mediaUserName' =>  $request->mediaUserName,
                'userID' =>  $request->userID,
                'designation' =>  $request->designation,
                'companyName' =>  $request->companyName,
                'contactNo' => $request->contactNo,
                'mediaEmail' => $request->mediaEmail,
            );
            Mail::to($data['email'])->send(new mediaNewUserRegistration($data));

            http_response_code(200);
            return response([
                'message' => 'Email Notification successfully send.'

            ]);
        } catch (RequestException $r) {
            http_response_code(400);
            return response([
                'message' => 'Email Notification failed to be sent.',
                'errorCode' => 4000
            ]);
        }
    }

    public function sendMediaUserRejected(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email' //Hello there
        ]);

        try {
            $settings = SettingEmail::all();
            $data = array(
                'email' => $request->email,
                'title' => $request->title,
                'content' => $request->content,
                'userName' =>  $request->userName,

            );
            Mail::to($data['email'])->send(new mediaNewUserRejected($data));

            http_response_code(200);
            return response([
                'message' => 'Email Notification successfully send.'

            ]);
        } catch (RequestException $r) {
            http_response_code(400);
            return response([
                'message' => 'Email Notification failed to be sent.',
                'errorCode' => 4000
            ]);
        }
    }

    public function sendMediaUserEmailOTP(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email' //Hello there
        ]);

        try {
            $settings = SettingEmail::all();
            $data = array(
                'email' => $request->email,
                'title' => $request->title,
                'userName' => $request->userName,
                'mediaUserName' =>  $request->mediaUserName,
                'userID' =>  $request->userID,
                'designation' =>  $request->designation,
                'companyName' =>  $request->companyName,
                'contactNo' => $request->contactNo,
                'mediaEmail' => $request->mediaEmail,
                'otp' => $request->otp,
            );
            Mail::to($data['email'])->send(new mediaNewUserRegistrationOtp($data));

            http_response_code(200);
            return response([
                'message' => 'Email Notification successfully send.'

            ]);
        } catch (RequestException $r) {
            http_response_code(400);
            return response([
                'message' => 'Email Notification failed to be sent.',
                'errorCode' => 4000
            ]);
        }
    }


}
