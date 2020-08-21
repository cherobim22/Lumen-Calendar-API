<?php

include "listCalendars.php";

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
                    <form  action="newEvent.php">
                        <div class="row">
                            <div id="lcalendar" class="col-sm">
                                 Calendarios:
                            </div>
                            <div class="col-sm d-flex flex-row-reverse">
                            <button type="button" class="btn btn-primary btn-sm pull-right" data-toggle="modal" id="newCalendar" data-target="#myModal">Novo Calendario</button>
                            </div>
                        </div>
    
                        <select  id="calendars" name="user[calendar_id]" class="custom-select"> 
                            <option>Selecione um calendario</option>  
                            <?php foreach($calendar->items as $row) {?> 
                                <option  value="<?=$row->id?>"><?=$row->summary?></option>
                            <?php } ?>
                        </select>

                        <div class="lead-box">
                            </br>
                            <input type="checkbox" id="lead" class="form-check-input" onclick="setEmail()">
                            <label for="lead">Notificar lead</label>
                            </br> 
                            <input class="form-control" id="email_lead" style="display:none" placeholder="Email lead" name="user[email]">                      
                        </div>

                        <div>
                            </br>
                            <div class="form-group row">
                                <label for="example-datetime-local-input" class="col-2 col-form-label">Titulo</label>
                                <div class="col-10">
                                    <input id="summary" class="form-control" placeholder="Titulo do evento" name="user[summary]">
                                </div>
                            </div>
                            </br>
                            <div class="form-group row">
                                <label for="example-datetime-local-input" class="col-2 col-form-label">Inicio</label>
                                <div class="col-10">
                                    <input class="form-control" type="datetime-local"  id="example-datetime-local-input" name="user[start_datetime]">
                                </div>
                            </div>
                            </br>
                            <div class="form-group row">
                                <label for="example-datetime-local-input" class="col-2 col-form-label">Fim</label>
                                <div class="col-10">
                                    <input class="form-control" type="datetime-local"  id="example-datetime-local-input" name="user[end_datetime]">
                                </div>
                            </div>
                            </br>
                        </div>
                       
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Salvar</button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Sair</button>
                        </div>
                    </form> 
                </div>
            </div>
        </div>
    </div>

    
    <!-- The Modal -->
  <div class="modal fade" id="myModal">
    <div class="modal-dialog">
      <div class="modal-content">
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Novo Calendario</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <!-- Modal body -->
        <form id="formCalendar" action="new_calendar.php">
            <div class="modal-body">
                <label>Titulo</label>
                <input id="summary"  class="form-control" placeholder="nome do calendario" name="user[summary]">
            </div>
            <!-- Modal footer -->
            <div class="modal-footer d-flex flex-row">
                <button id="saveCalendar" type="submit" class="btn btn-primary">Save</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
        </form>
      </div>
    </div>
  </div>
  <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script type="text/javascript">
     $(function () {

        $('#newCalendar').on('click', function (e) {
            $('#exampleModal').css('display', 'none');
        });

        });
    </script>
</body>
</html>