// JavaScript Document
let botonCobrar;
let botonDescargar;
let formulario;
window.onload = function(){
    getRecibos();
}

function getRecibos(){
    let formData = new FormData();
    formData.append("function", "getRecibos");
    ajax(rutaUrl + "/cobdes_id_dinamico/", "POST", "txt", setRecibos, formData);
}

function setRecibos(text){
    let dinamico = document.getElementById("dinamico");
    dinamico.innerHTML = text;
    
    formulario = document.querySelector("form");
    formulario.addEventListener('submit', submit);
    
    botonCobrar = document.getElementById("cobrar")
    if(botonCobrar){
        botonCobrarClick();
    }
    
    botonDescargar = document.getElementById("descargar");
    if(botonDescargar){
        botonDescargarClick();
    }
    document.getElementById("id").focus();
}

function submit(event){
    event.preventDefault();
    //let formData = new FormData(event.target); // todo el formulario
    let formData = new FormData();
    formData.append("id", formulario.elements["id"].value);
    formData.append("function", "submit");
    ajax(rutaUrl + "/cobdes_id_dinamico/", "POST", "txt", setRecibos, formData);
}

function botonCobrarClick(){
    botonCobrar.addEventListener("click", function() {
        let tds = this.parentNode.parentNode.getElementsByTagName("td");
        let id = tds[1].innerText;
        let formData= new FormData();
        formData.append("id", id);
        formData.append("function", "cobrarReciboo");
        ajax(rutaUrl + "/cobdes_id_dinamico/", "POST", "nada", getRecibos, formData);
    });
}

function botonDescargarClick(){
    botonDescargar.addEventListener("click", function() {
        let tds = this.parentNode.parentNode.getElementsByTagName("td");
        let id = tds[1].innerText;
        let formData= new FormData();
        formData.append("id", id);
        formData.append("function", "descargarReciboo");
        ajax(rutaUrl + "/cobdes_id_dinamico/", "POST", "nada", getRecibos, formData);
    });
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