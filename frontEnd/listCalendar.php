<?php
$url = "http://lucas.innovaweb.com.br/google/calendar/read/";

$context = stream_context_create(array(
    'http' => array(
        'header' => "Authorization: ",
    ),
));

$calendar =  json_decode(file_get_contents($url,false,$context));

return $calendar;

?>