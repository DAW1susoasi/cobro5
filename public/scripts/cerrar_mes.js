// JavaScript Document
let botonesEditar;
let botonesPaginacion;
let pagina;
let formulario;
window.onload = function(){
    getRecibos();
}

function getRecibos(){
    let formData = new FormData();
    pagina = pagina ? pagina : 1;
    formData.append("pagina", pagina);
    formData.append("function", "getRecibos");
    ajax(rutaUrl + "/cerrar_mes_dinamico/", "POST", "txt", setRecibos, formData);
}

function setRecibos(text){
    let dinamico = document.getElementById("dinamico");
    dinamico.innerHTML = text;
    
    botonesPaginacion = document.getElementsByClassName("paginacion");
    botonesPaginacionClick();
    
    formulario = document.querySelector("form");
    formulario.addEventListener('submit', submit);
    
    botonesEditar = document.getElementsByClassName("editar");
    botonesEditarClick();
    
    document.getElementById("observaciones").focus();
}

function botonesPaginacionClick(){
    for(let x = 0; x < botonesPaginacion.length; x++){
        botonesPaginacion[x].addEventListener("click", function() {
            pagina = botonesPaginacion[x].value;
            getRecibos();
        });
    }
}

function submit(event){
    event.preventDefault();
    //let formData = new FormData(event.target); // todo el formulario
    let formData = new FormData();
    formData.append("id", formulario.elements["id"].value);
    formData.append("importe", formulario.elements["importe"].value);
    formData.append("observaciones", formulario.elements["observaciones"].value);
    formData.append("function", "submit");
    ajax(rutaUrl + "/cerrar_mes_dinamico/", "POST", "txt", getRecibos, formData);
}

function botonesEditarClick(){
    for(let x = 0; x < botonesEditar.length; x++){
        botonesEditar[x].addEventListener("click", function() { 
            let tds = this.parentNode.parentNode.getElementsByTagName("td");
            document.getElementById("importe").value = tds[1].innerText;
            document.getElementById("id").value = tds[2].innerText;
            document.getElementById("id").readOnly = "readonly";
            document.getElementById("fecha").innerText = tds[3].innerText;
            document.getElementById("observaciones").value = tds[4].innerText;
            document.getElementById("observaciones").focus();
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