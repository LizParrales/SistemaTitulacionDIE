/*
$(document).ready(function(){
	var validaLetras = /^[A-Z]+$/;
	var validaCorreo =  /^[a-zA-Z0-9\._-]+@[a-zA-Z0-9-]{2,}[.][a-zA-Z]{2,4}$/;
	var validaNum =  /^[0-9]+$/;
	var validaDec = /^[0-9]+[.][0-9]+;
	var validaPagina = /^[a-zA-Z0-9\_-]{2,}[.][a-zA-Z]{2,4}$/;
	var validaRFC = /^[A-Z]{4}[0-9]{6};
	});
});

*/
function validarCorreo() {
	email = $("#Correo").val()
    expr = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    if (!expr.test(email)){
        alert("Error: La dirección de correo " + email + " es incorrecta.");
        $("#Correo").focus();
    }
}

function validarNombre(){
	nom = $("#Nombre").val()
    expr = /^([A-Z]+[\s]?)+$/;
    if (!expr.test(nom)){
        alert("Error: Este campo no acepta acentos ni minúsculas.");
        $("#Nombre").focus();
    }
}

function validarPat(){
	apPat = $("#Ap_Pat").val()
    expr = /^([A-Z]+[\s]?)+$/;
    if (!expr.test(apPat)){
        alert("Error: Este campo no acepta acentos ni minúsculas.");
        $("#Ap_Pat").focus();
    }
}

function validarMat(){
	apMat = $("#Ap_Mat").val()
    expr = /^([A-Z]+[\s]?)+$/;
    if (!expr.test(apMat)){
        alert("Error: Este campo no acepta acentos ni minúsculas.");
        $("#Ap_Mat").focus();
    }
}

function validarRFC(){
	rfc = $("#RFC").val()
    expr = /^[A-Z]{4}[0-9]{6}$/;
    if (!expr.test(rfc)){
        alert("Error: RFC invalido.");
        $("#RFC").focus();
    }
}

function validarId(){
	cuenta = $("#Cuenta").val()
    expr = /^[0-9]+$/;
    if (!expr.test(cuenta)){
        alert("Error: Este campo solo acepta números");
        $("#Cuenta").focus();
    }
}

function validarUbicacion(){
	ubic = $("#Ubic").val()
    expr = /^([A-Z]+[\s]?)+$/;
    if (!expr.test(ubic)){
        alert("Error: Este campo no acepta acentos ni minúsculas.");
        $("#Ubic").focus();
    }
}

function validarTel(){
	tel = $("#Tel").val()
    expr = /^[a-zA-Z0-9\s\,\.]+$/;
    if (!expr.test(tel)){
        alert("Error: Rellene este campo por favor");
        $("#Tel").focus();
    }
}

function validarPagina() {
	pagina = $("#Pag").val()
    expr = /^(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    if (!expr.test(pagina)){
        alert("Error: La dirección de correo " + pagina + " es incorrecta.");
        $("#Pag").focus();
    }
}

function validarSemestre(){
	sem = $("#semestre").val()
    expr = /^[0-9]{5}$/;
    if (!expr.test(sem)){
        alert("Error: Por favor ingrese el semestre de ingreso sin guión");
        $("#semestre").focus();
    }
}

function validarPromedio(){
	prom = $("#Promedio").val()
    expr = /^[0-9]{1,2}[.][0-9]+$/;
    if (!expr.test(prom)){
        alert("Error: Promedio incorrecto");
        $("#Promedio").focus();
    }
}

function validarAvance(){
	avance = $("#Creditos").val()
    expr = /^[0-9]{1,3}[.][0-9]+/;
    if (!expr.test(avance)){
        alert("Error: Avance de creditos incorrecto");
        $("#Creditos").focus();
    }
}
