// JavaScript Document
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
    ajax(rutaUrl + "/quedaron_pendientes_mes_dinamico/", "POST", "txt", setRecibos, formData);
}

function setRecibos(text){
    let dinamico = document.getElementById("dinamico");
    dinamico.innerHTML = text;
    
    botonesPaginacion = document.getElementsByClassName("paginacion");
    botonesPaginacionClick();
}

function botonesPaginacionClick(){
    for(let x = 0; x < botonesPaginacion.length; x++){
        botonesPaginacion[x].addEventListener("click", function() {
            pagina = botonesPaginacion[x].value;
            getRecibos();
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