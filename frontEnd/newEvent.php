<?php


$user = $_REQUEST['user'];

$start = date_format(new DateTime($user['start_datetime']),'Y-m-d\TH:i:s');
$end = date_format(new DateTime($user['end_datetime']),'Y-m-d\TH:i:s');

if(empty($user['email'])){
    unset($user['email']);
}

$user['start_datetime'] = $start;
$user['end_datetime'] = $end;
$data = $user;

print_r($data);


$iniciar = curl_init();
curl_setopt($iniciar, CURLOPT_URL, "http://lucas.innovaweb.com.br/google/events/create/");
curl_setopt($iniciar, CURLOPT_POST, true);
curl_setopt($iniciar, CURLOPT_HTTPHEADER, array(
    'Authorization: '
));
curl_setopt($iniciar, CURLOPT_POSTFIELDS, $data);
curl_setopt($iniciar, CURLOPT_RETURNTRANSFER, true);

$response = curl_exec($iniciar);

curl_close ($iniciar);
header("Location: index.php");

?>