function abrir(URL) {
    window.open(URL, 'janela', 'width=795, height=590, top=100, left=10, scrollbars=no, status=no, toolbar=no, location=no, menubar=no, resizable=no, fullscreen=no')}


function setEmail() {
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