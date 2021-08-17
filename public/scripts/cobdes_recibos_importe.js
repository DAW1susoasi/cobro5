// JavaScript Document
let botonesCobrar;
let botonesDescargar;
let formulario;
window.onload = function(){
    getRecibos();
}

function getRecibos(){
    let formData = new FormData();
    formData.append("function", "getRecibos");
    ajax(rutaUrl + "/cobdes_importe_dinamico/", "POST", "txt", setRecibos, formData);
}

function setRecibos(text){
    let dinamico = document.getElementById("dinamico");
    dinamico.innerHTML = text;
    
    formulario = document.querySelector("form");
    formulario.addEventListener('submit', submit);
    
    botonesCobrar = document.getElementsByClassName("cobrar");
    if(botonesCobrar){
        botonesCobrarClick();
    }
    
    botonesDescargar = document.getElementsByClassName("descargar");
    if(botonesDescargar){
        botonesDescargarClick();
    }
    document.getElementById("importe").focus();
}

function submit(event){
    event.preventDefault();
    //let formData = new FormData(event.target); // todo el formulario
    let formData = new FormData();
    formData.append("importe", formulario.elements["importe"].value);
    formData.append("function", "submit");
    ajax(rutaUrl + "/cobdes_importe_dinamico/", "POST", "txt", setRecibos, formData);
}

function botonesCobrarClick(){
    for(let x = 0; x < botonesCobrar.length; x++){
        botonesCobrar[x].addEventListener("click", function() {
            let tds = this.parentNode.parentNode.getElementsByTagName("td");
            let id = tds[1].innerText;
            let formData= new FormData();
            formData.append("id", id);
            formData.append("function", "cobrarReciboo");
            ajax(rutaUrl + "/cobdes_importe_dinamico/", "POST", "nada", getRecibos, formData);
        });
    }
}

function botonesDescargarClick(){
    for(let x = 0; x < botonesDescargar.length; x++){
        botonesDescargar[x].addEventListener("click", function() {
            let tds = this.parentNode.parentNode.getElementsByTagName("td");
            let id = tds[1].innerText;
            let formData= new FormData();
            formData.append("id", id);
            formData.append("function", "descargarReciboo");
            ajax(rutaUrl + "/cobdes_importe_dinamico/", "POST", "nada", getRecibos, formData);
        });
    }
}

function ajax(url, metodo, tipo, despues, params){
    let peticion_fetch;
    if(params){
        peticion_fetch = new Request(url, {method: metodo, body: params});
    }
    else{
        peticion_fetch = new Request(url, {method: metodo});
    }
    fetch(peticion_fetch)
        .then( response => {
            if(response.status == 200){
                return response.text();
            }
            else{
                throw "Respuesta incorrecta del servidor"
            }
    })
    .then( responseText => {
        switch (tipo){
            case 'xml':
                let parser = new DOMParser();
                despues(parser.parseFromString(responseText, "text/xml"));
                break;
            case 'json':
                despues(JSON.parse(responseText));
                break;
            case 'txt':
                despues(responseText);
                break;
            case 'nada':
                despues();
                break;
        }
    })
    .catch(err => {
        console.log(err);
    });
}