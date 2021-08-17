// JavaScript Document
let botonesEliminar;
let botonesEditar;
let botonEliminarTodos;
let botonesPaginacion;
let formulario;
let pagina;
window.onload = function(){
    //console.log(rutaUrl);
    getRecibos();
}

function getRecibos(){
    let formData = new FormData();
    pagina = pagina ? pagina : 1;
    formData.append("pagina", pagina);
    formData.append("function", "getRecibos");
    ajax(rutaUrl + "/crud_dinamico/", "POST", "txt", setRecibos, formData);
}

function setRecibos(text){
    let dinamico = document.getElementById("dinamico");
    dinamico.innerHTML = text;
    
    formulario = document.querySelector("form");
    formulario.addEventListener('submit', submit);

    
    botonesPaginacion = document.getElementsByClassName("paginacion");
    botonesPaginacionClick();
    
    botonesEditar = document.getElementsByClassName("editar");
    botonesEditarClick();
    
    botonesEliminar = document.getElementsByClassName("eliminar");
    botonesEliminarClick();
    
    botonEliminarTodos = document.getElementById("eliminar_todos");
    botonEliminarTodosClick();
    
    document.getElementById("importe").focus();
}

function submit(event){
    event.preventDefault();
    //let formData = new FormData(event.target); // todo el formulario
    let formData = new FormData();
    formData.append("importe", formulario.elements["importe"].value);
    formData.append("id", formulario.elements["id"].value);
    formData.append("function", "submit");
    ajax(rutaUrl + "/crud_dinamico/", "POST", "nada", getRecibos, formData);
}

function botonesPaginacionClick(){
    for(let x = 0; x < botonesPaginacion.length; x++){
        botonesPaginacion[x].addEventListener("click", function() {
            pagina = botonesPaginacion[x].value;
            getRecibos();
        });
    }
}

function botonEliminarTodosClick(){
    botonEliminarTodos.addEventListener("click", function() {
        let formData= new FormData();
        formData.append("function", "eliminarRecibosTemp");
        ajax(rutaUrl + "/crud_dinamico/", "POST", "nada", getRecibos, formData);
    });
}

function botonesEditarClick(){
    for(let x = 0; x < botonesEditar.length; x++){
        botonesEditar[x].addEventListener("click", function() { 
            let tds = this.parentNode.parentNode.getElementsByTagName("td");
            document.getElementById("importe").value = tds[2].innerText;
            document.getElementById("id").value = tds[1].innerText;
            document.getElementById("id").readOnly = "readonly";
            document.getElementById("importe").focus();
        });
    }
}

function botonesEliminarClick(){
    for(let x = 0; x < botonesEliminar.length; x++){
        botonesEliminar[x].addEventListener("click", function() {
            if(confirm('Eliminar recibo. ¿Continuar?')){
                let tds = this.parentNode.parentNode.getElementsByTagName("td");
                let id = tds[1].innerText;
                let formData = new FormData();
                formData.append("id", id);
                formData.append("function", "eliminarReciboo");
                ajax(rutaUrl + "/crud_dinamico/", "POST", "nada", getRecibos, formData);
            }
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