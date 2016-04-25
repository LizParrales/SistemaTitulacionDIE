$(document).ready(function(){

	var modal = document.getElementById("cambio_pass");
	var cerrar = document.getElementById("cerrar");
     	
	cerrar.onclick = function(){
		modal.style.display = "none";
	}
	window.onclick = function(event) {
    	if (event.target == modal) {
			modal.style.display = "none";
		}
	}
});

