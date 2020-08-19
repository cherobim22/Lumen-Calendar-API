<?php
$url = "http://lucas.innovaweb.com.br/google/auth/geturl";

$context = stream_context_create(array(
    'http' => array(
        'header' => "Authorization: ",
    ),
));

$response = file_get_contents($url,false,$context);

header("location: ".$response);

?>