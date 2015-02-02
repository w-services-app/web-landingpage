<?php

//header('Content-Type: text/html; charset=UTF-8');

if (!(isset($_SERVER['HTTP_X_REQUESTED_WITH']) AND strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest')) {
    die("Hacking attempt!");
}

function send_mail($from_name, $to_name, $to, $from, $subject_func = 'Без темы', $body = '', $attachment, $filename = '', $path = '') {

    $subject = "=?utf-8?B?" . base64_encode($subject_func) . "?=";
    $to_name_enecode = "=?utf-8?B?" . base64_encode($to_name) . "?=";
    $from_name_enecode = "=?utf-8?B?" . base64_encode($from_name) . "?=";

    $message = $body;
    $headers = 'MIME-Version: 1.0' . "\r\n";

    if ($attachment != FALSE) {
        $file = $path . $filename;
        $file_size = filesize($file);
        $handle = fopen($file, "r");
        $content = fread($handle, $file_size);
        fclose($handle);
        $content = chunk_split(base64_encode($content));
        $uid = md5(uniqid(time()));
        $name = basename($file);
        $headers .= 'To: ' . $to_name . '<' . $to . '>' . "\r\n";
        $headers .= 'From: ' . $from_name . '<' . $from . '>' . "\r\n";
        $headers .= "Content-Type: multipart/mixed; boundary=\"" . $uid . "\"\r\n\r\n";
        $headers .= "This is a multi-part message in MIME format.\r\n";
        $headers .= "--" . $uid . "\r\n";
        $headers .= "Content-type:text/plain; charset=utf-8\r\n";
        $headers .= "Content-Transfer-Encoding: 7bit\r\n\r\n";
        $headers .= $message . "\r\n\r\n";
        $headers .= "--" . $uid . "\r\n";
        $headers .= "Content-Type: application/octet-stream; name=\"" . $filename . "\"\r\n"; // use different content types here
        $headers .= "Content-Transfer-Encoding: base64\r\n";
        $headers .= "Content-Disposition: attachment; filename=\"" . $filename . "\"\r\n\r\n";
        $headers .= $content . "\r\n\r\n";
        $headers .= "--" . $uid . "--";
    } else {
        $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
        // Дополнительные заголовки
        $headers .= 'To: ' . $to_name_enecode . ' <' . $to . '>' . "\r\n";
        $headers .= 'From: ' . $from_name_enecode . ' <' . $from . '>' . "\r\n";
    }
    $send_mail = mail($to, $subject, $message, $headers);
    return $send_mail;
}

$name = isset($_POST["name"]) ? trim($_POST["name"]) : "";
$email = isset($_POST["email"]) ? trim($_POST["email"]) : "";

/* FOR DEBUG 
  $name = 'Вася';
  $email = 'vasja@inbox.lv';
  $phone = '+37129537953'; */


$response = '';
$error = false;
$error_email = false;
$error_name = false;

if ($email == '') {
    $error = true;
    $error_email = true;
} else {
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = true;
        $error_email = true;
        $response = "E-mail is not valid";
    }
}

if ($name == '') {
    $error = true;
    $error_name = true;
}

if ($error === FALSE) {


    //$clients_send = send_mail('Имя Фирмы', '', $email, 'info@domain.eu', $subject_func, $body_client, FALSE);

    $copy_send = '1';
    $copy_send2 = '1';
    $debug = '<b>DEBUG: </b>' . '<br /><br />'
            . '<b>$name:</b> ' . $name . '<br />'
            . '<b>$email:</b> ' . $email;
    if ($copy_send == '1' and $copy_send2 == '1') {
        $response = '<div class="page-header"><h3>Спасибо, Ваше сообщение отправлено!</h3></div>';
    } else {
        $error = true;
        $response = 'not send sucefulity' . $debug;
    }
}


$data = array(
    'response' => $response,
    'error' => $error,
    'email' => $error_email,
    'name' => $error_name
);

header('Content-Type: application/json');

echo json_encode($data);
