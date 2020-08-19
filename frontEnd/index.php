<?php

$url = "http://lucas.innovaweb.com.br/google/calendar/read/";

$context = stream_context_create(array(
    'http' => array(
        'header' => "Authorization: ",
    ),
));

$calendar =  json_decode(file_get_contents($url,false,$context));


//print_r($calendar->items);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style type="text/css">
        .div{
            display: flex;
            align-items: center;
            flex-direction:column;
        }
        .followup{
            margin-top: 20px;
        }
        .icon {
            background: url(imgs/google.svg) no-repeat;
            margin-top: 50px;
            border: none;
            width: 40px;
            height: 40px;
        }
        .popup{
            width:200px;
            height: 250px;
            border: 3px solid #000;
           
        }
        .form-container {
            display: flex;
            flex-direction:column;
            max-width: 300px;
            padding: 10px;
            background-color: white;
        }
    </style>
    <title>Document</title>
    
    <div class="div">
        <button class="icon" onclick="abrir('http://localhost:8000/login.php')"></button>
        <button class="followup" onclick="openForm()">follow up</button>
    </div>

    <div class="popup" id="popup_form">
        <div>
            <input type="checkbox" id="calendar" name="calendar" onclick="addCalendar()">
            <label for="calendar">Salvar no calendario</label><br>
        </div>

        <div class="div_form" id="div_form" style="display:none">
            <form class="form-container" action="calendars.php">
                <label>Calendarios: </label>
                <select  id="calendars" name="user[calendar]" > 
                    <option></option>  
                    <?php foreach($calendar->items as $row) {?> 
                        <option  value="<?=$row->id?>"><?=$row->summary?></option>
                    <?php } ?>
                </select>

                <div>
                    <input type="checkbox" id="lead"  onclick="myFunction()">
                    <label for="lead"> Notificar lead</label><br>
                </div>
                <input id="email_lead" style="display:none" placeholder="email lead" name="user[lead]">

                <div>
                    <label>Titulo</label>
                    <input id="summary"  placeholder="titulo do evento" name="user[summary]">
                </div>
                <button type="submit" class="btn">salvar</button>
                
            </form>
        </div><button type="button" class="btn cancel" onclick="closeForm()">Close</button>
    </div>

    <script language=javascript type="text/javascript">
        function abrir(URL) {
            window.open(URL, 'janela', 'width=795, height=590, top=100, left=699, scrollbars=no, status=no, toolbar=no, location=no, menubar=no, resizable=no, fullscreen=no')}

        function openForm() {
            document.getElementById("popup_form").style.display = "block";
        }

        function closeForm() {
            document.getElementById("popup_form").style.display = "none";
        }

        function myFunction() {
            var checkBox = document.getElementById("lead");
            var text = document.getElementById("email_lead");
            if (checkBox.checked == true){
                text.style.display = "block";
            } else {
                text.style.display = "none";
            }
        }
        function addCalendar() {
            var checkBox = document.getElementById("calendar");
            var text = document.getElementById("div_form");
            if (checkBox.checked == true){
                text.style.display = "block";
            } else {
                text.style.display = "none";
            }
        }
    </script>
</head>
<body>
</body>
</html>