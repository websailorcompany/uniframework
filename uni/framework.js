function modMaze(idModulo, dados, idLocal) {
	var xhttp;
	if (window.XMLHttpRequest) {xhttp = new XMLHttpRequest();} 
	else {	xhttp = new ActiveXObject("Microsoft.XMLHTTP");	}
	// xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
		  //ação caso receba o obj
		  document.getElementById(idLocal).innerHTML = this.responseText;
			
		}
	};
	xhttp.open("POST", "ajax_modMaze.php", true);
	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhttp.send("modulo="+idModulo+"&dados="+dados);
}

function testeAlert(){
	alert('funciona!');
}

displayConteudo(posicao, conteudo){  // necessidade improvavel
	getElementById(posicao).innerHTML = conteudo;
}