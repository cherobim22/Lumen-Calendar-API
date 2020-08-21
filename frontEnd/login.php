<?php
$url = "";

$context = stream_context_create(array(
    'http' => array(
        'header' => "Authorization: ",
    ),
));

$response = file_get_contents($url,false,$context);

header("location: ".$response);

?>