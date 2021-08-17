// JavaScript Document
let botonesCobrar;
let botonesDescargar;
let botonesPaginacion;
let pagina;
window.onload = function(){
    getRecibos();
}

function getRecibos(){
    let formData = new FormData();
    pagina = pagina ? pagina : 1;
    formData.append("pagina", pagina);
    formData.append("function", "getRecibos");
    ajax(rutaUrl + "/cobdes_dinamico/", "POST", "txt", setRecibos, formData);
}

function setRecibos(text){
    let dinamico = document.getElementById("dinamico");
    dinamico.innerHTML = text;
    
    botonesPaginacion = document.getElementsByClassName("paginacion");
    botonesPaginacionClick();
    
    botonesCobrar = document.getElementsByClassName("cobrar");
    botonesCobrarClick();
    
    botonesDescargar = document.getElementsByClassName("descargar");
    botonesDescargarClick();
}

function botonesPaginacionClick(){
    for(let x = 0; x < botonesPaginacion.length; x++){
        botonesPaginacion[x].addEventListener("click", function() {
            pagina = botonesPaginacion[x].value;
            getRecibos();
        });
    }
}

function botonesCobrarClick(){
    for(let x = 0; x < botonesCobrar.length; x++){
        botonesCobrar[x].addEventListener("click", function() {
            let tds = this.parentNode.parentNode.getElementsByTagName("td");
            let id = tds[2].innerText;
            let formData= new FormData();
            formData.append("id", id);
            formData.append("function", "cobrarReciboo");
            ajax(rutaUrl + "/cobdes_dinamico/", "POST", "nada", getRecibos, formData);
        });
    }
}

function botonesDescargarClick(){
    for(let x = 0; x < botonesDescargar.length; x++){
        botonesDescargar[x].addEventListener("click", function() {
            let tds = this.parentNode.parentNode.getElementsByTagName("td");
            let id = tds[2].innerText;
            let formData= new FormData();
            formData.append("id", id);
            formData.append("function", "descargarReciboo");
            ajax(rutaUrl + "/cobdes_dinamico/", "POST", "nada", getRecibos, formData);
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