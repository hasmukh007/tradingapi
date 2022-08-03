<?php
//Load Composer's autoloader
require __DIR__ . '/../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


function out($message)
{
    die(stripslashes(json_encode($message)));
}

function sendError($message)
{
    out(['status' => 'notok', 'message' => $message]);
}

function sendSuccess($data)
{
    out(['status' => 'ok', 'data' => $data]);
}
function getAuthToken()
{
    $headers = getallheaders();
    if (isset($headers['Auth'])) return $headers['Auth'];
    if (isset($headers['auth'])) return $headers['auth'];
    return '';
}
function getRequest($name, $default = '')
{
    if (isset($_REQUEST[$name])) return $_REQUEST[$name];
    $request = file_get_contents('php://input');
    if (!empty($request) && !is_null($request)) {
        $request = json_decode($request, true);
        if (isset($request[$name])) return $request[$name];
    }
    return $default;
}

function generateCode($length)
{
    $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890';
    $code = '';
    while (strlen($code) < $length) {
        $c = rand(0, strlen($chars));
        $code .= substr($chars, $c, 1);
    }
    return $code;
}

function sendEmail($to, $subject, $body, $toName = '')
{
    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = SMTP;                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = SMTP_USER;                     //SMTP username
        $mail->Password   = SMTP_PASSWORD;                               //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
        $mail->Port       = SMTP_PORT;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        //Recipients
        $mail->setFrom(MAIL_FROM, 'H1L');
        $mail->addAddress($to, $toName);     //Add a recipient

        //Attachments
        // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments

        //Content
        $mail->isHTML(false);                                  //Set email format to HTML
        $mail->Subject = $subject;
        $mail->Body    = $body;
        // $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

        $mail->send();
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}