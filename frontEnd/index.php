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
    <link rel="stylesheet" href="css/index.css" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
    <script language=javascript type="text/javascript" src="script.js"></script>
    <title>Document</title>
    
</head>
<body>
    <div class="divlogin">
        <button class="icon" onclick="abrir('http://localhost:8000/login.php')"></button>
        <button type="button" id="btn-modal" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">Follow Up</button>
    </div>

        <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Novo Evento</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <form class="form-container" action="calendars.php">
                        <div class="row">
                            <div id="lcalendar" class="col-sm">
                            Calendarios:
                            </div>
                            <div class="col-sm">
                            <button type="button" class="btn btn-primary btn-sm pull-right" data-toggle="modal" id="newCalendar" data-target="#myModal">Novo Calendario</button>
                            </div>
                            <a href="#"><span class="glyphicon glyphicon-envelope"></span></a>
                        </div>
                        <select  id="calendars" name="user[calendar_id]" class="custom-select"> 
                            <option></option>  
                            <?php foreach($calendar->items as $row) {?> 
                                <option  value="<?=$row->id?>"><?=$row->summary?></option>
                            <?php } ?>
                        </select>
                        

                        <div class="lead-box">
                            </br>
                            <input type="checkbox" id="lead" class="form-check-input" onclick="myFunction()">
                            <label for="lead">Notificar lead</label><br>                           
                        </div>

                        <input id="email_lead"class="form-control" style="display:none" placeholder="email lead" name="user[email]">
                        </br>

                        <div>
                            <label>Titulo</label>
                            <input id="summary" class="form-control" placeholder="titulo do evento" name="user[summary]">
                            </br>
                            <label>Inicio</label>
                            <input id="summary" class="form-control" placeholder="2015-05-28T17:00:00-07:00" name="user[start_datetime]">
                            </br>
                            <label>Fim</label>
                            <input id="summary" class="form-control" placeholder="2015-05-28T17:00:00-07:00" name="user[end_datetime]">
                            </br>
                        </div>
                       <button type="submit" class="btn btn-primary">Save</button>
                    </form> 
                    
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>

            </div>
        </div>
    </div>

    
    <!-- The Modal -->
  <div class="modal" id="myModal">
    <div class="modal-dialog">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Novo Calendario</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body">
            <form class="form-container" action="new_calendar.php">
                <label>Titulo</label>
                <input id="summary"  class="form-control" placeholder="nome do calendario" name="user[summary]">
                            </br>
                <button type="submit" class="btn btn-primary">Save</button>
            </form>
        </div>
        
        <!-- Modal footer -->
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>
        
      </div>
    </div>
  </div>
  <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script type="text/javascript">
     $(function () {

        $('form').on('submit', function (e) {

        e.preventDefault();

        $.ajax({
            type: 'post',
            url: 'new_calendar.php',
            data: $('form').serialize(),
            success: function () {
            alert('form was submitted');
            location.reload();
            }
        });

        });

        });
    </script>
</body>
</html>