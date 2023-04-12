<?php

namespace App\Helpers;

use PHPMailer\PHPMailer;
use Config;
use Database\Seeders\ModuleSeeder;
use Illuminate\Database\Eloquent\Model;

class SettingEmailTemplate extends Model
{
    protected $connection= 'module0';

    protected $table = 'SETTING_EMAIL_TEMPLATE';

    public $timestamps =false;
    use HasFactory;
}

class UserFiMM extends Model
{
    protected $connection= 'module0';

    protected $table = 'USER';

    public $timestamps =false;
    use HasFactory;
}
class UserDistributor extends Model
{
    protected $connection= 'module1';

    protected $table = 'USER';

    public $timestamps =false;
    use HasFactory;
}
class UserConsultant extends Model
{
    protected $connection= 'module2';

    protected $table = 'CONSULTANT';

    public $timestamps =false;
    use HasFactory;
}

class UserThirdParty extends Model
{
    protected $connection= 'module5';

    protected $table = 'THIRD_PARTY_USER';

    public $timestamps = false;
    use HasFactory;
}

class SettingEmail extends Model
{
    protected $table = 'SETTING_EMAIL';

    protected $primaryKey = 'SETTING_EMAIL_ID';

    public $timestamps = false;
}

class SendEmail
{
    public function send(
        $receiverId, //group id or user id (example: 1)
        $receiverType, //group or user (example: 'group')
        $emailTemplateId
        )
    {

        $emailDetails = SettingEmailTemplate::where('EMAIL_TEMP_TYPE',$emailTemplateId);

        $email = $parameter->email;
        $name = $parameter->name;
        $otp = $parameter->OTP;
        $loginId = $parameter->loginId;
        $loginURL = $parameter->loginURL;

        $emailDetails = SettingEmail::first();
        $EMAIL_FROM = $emailDetails->EMAIL_FROM;
        $EMAIL_SECURITY = $emailDetails->EMAIL_SECURITY;
        $EMAIL_SMTP_SERVER = $emailDetails->EMAIL_SMTP_SERVER;
        $EMAIL_SMTP_PORT = $emailDetails->EMAIL_SMTP_PORT;

        $EMAIL_LOGIN_ID = $emailDetails->EMAIL_LOGIN_ID;
        $EMAIL_LOGIN_PASS = $emailDetails->EMAIL_LOGIN_PASS;

        $mail = new PHPMailer(true);
        $mail->IsSMTP(); // enable SMTP
        $mail->SMTPDebug = 0; // debugging: 1 = errors and messages, 2 = messages only
        $mail->SMTPAuth = true; // authentication
        $mail->SMTPSecure = $EMAIL_SECURITY; // secure transfer enabled REQUIRED for Gmail
        $mail->SMTPAutoTLS = false;
        $mail->Host = $EMAIL_SMTP_SERVER;
        $mail->Port = $EMAIL_SMTP_PORT; // or 587

        $mail->Username = $EMAIL_LOGIN_ID;
        $mail->Password = $EMAIL_LOGIN_PASS;
        $mail->SetFrom($EMAIL_LOGIN_ID, $EMAIL_FROM);

        $mail->IsHTML(true);
        $mail->AddEmbeddedImage('./emailTemplate/logo_fimm.png', 'logo_fimm');
        $mail->Subject = 'New User Registration';
        $mail->AddAddress($email);
        $mail->MsgHTML($body);
        $mail->CharSet = "utf-8"; // use utf-8 character encoding
        if (!$mail->Send()) {
            http_response_code(400);
            $r = new response();
            $r->result = "failed";
            $r->reason = "Email error";
            echo json_encode($r);
            exit();
        } else {
            http_response_code(200);
            $r = new response();
            $r->result = "success";
            $r->reason = "Message has been sent";
            echo json_encode($r);
        }
    }

    public function newRegistration($parameter)
    {
        $email = $parameter->email;
        $name = $parameter->name;
        $otp = $parameter->OTP;
        $loginId = $parameter->loginId;
        $loginURL = $parameter->loginURL;

        $emailDetails = SettingEmail::first();
        $EMAIL_FROM = $emailDetails->EMAIL_FROM;
        $EMAIL_SECURITY = $emailDetails->EMAIL_SECURITY;
        $EMAIL_SMTP_SERVER = $emailDetails->EMAIL_SMTP_SERVER;
        $EMAIL_SMTP_PORT = $emailDetails->EMAIL_SMTP_PORT;

        $EMAIL_LOGIN_ID = $emailDetails->EMAIL_LOGIN_ID;
        $EMAIL_LOGIN_PASS = $emailDetails->EMAIL_LOGIN_PASS;

        $mail = new PHPMailer(true);
        $mail->IsSMTP(); // enable SMTP
        $mail->SMTPDebug = 0; // debugging: 1 = errors and messages, 2 = messages only
        $mail->SMTPAuth = true; // authentication
        $mail->SMTPSecure = $EMAIL_SECURITY; // secure transfer enabled REQUIRED for Gmail
        $mail->SMTPAutoTLS = false;
        $mail->Host = $EMAIL_SMTP_SERVER;
        $mail->Port = $EMAIL_SMTP_PORT; // or 587

        $mail->Username = $EMAIL_LOGIN_ID;
        $mail->Password = $EMAIL_LOGIN_PASS;
        $mail->SetFrom($EMAIL_LOGIN_ID, $EMAIL_FROM);

        $mail->IsHTML(true);
        $mail->AddEmbeddedImage('./emailTemplate/logo_fimm.png', 'logo_fimm');
        $mail->Subject = 'New User Registration';
        $body = file_get_contents('./emailTemplate/newRegistration.php');
        $body = str_replace('$name', $name, $body);
        $body = str_replace('$otp', $otp, $body);
        $body = str_replace('$loginId', $loginId, $body);
        $body = str_replace('$loginURL', $loginURL, $body);
        $body = preg_replace('/\\\\/', '', $body); //Strip backslashes
        $mail->AddAddress($email);
        $mail->MsgHTML($body);
        $mail->CharSet = "utf-8"; // use utf-8 character encoding
        if (!$mail->Send()) {
            http_response_code(400);
            $r = new response();
            $r->result = "failed";
            $r->reason = "Email error";
            echo json_encode($r);
            exit();
        } else {
            http_response_code(200);
            $r = new response();
            $r->result = "success";
            $r->reason = "Message has been sent";
            echo json_encode($r);
        }
    }
}
