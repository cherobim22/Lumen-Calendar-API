<?php
$user = $_REQUEST['user'];

print_r($user);

$iniciar = curl_init();
curl_setopt($iniciar, CURLOPT_URL, "http://lucas.innovaweb.com.br/google/events/create/");
curl_setopt($iniciar, CURLOPT_POST, true);
curl_setopt($iniciar, CURLOPT_HTTPHEADER, array(
    'Authorization: '
));
curl_setopt($iniciar, CURLOPT_POSTFIELDS, $user);
curl_setopt($iniciar, CURLOPT_RETURNTRANSFER, true);

$response = curl_exec($iniciar);

curl_close ($iniciar);

return print_r(json_encode($response));

?>