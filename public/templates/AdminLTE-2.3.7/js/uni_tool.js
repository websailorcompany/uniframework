function AssincRequest(event, form, method, rota){
  event.preventDefault();
  // var rota = form.getAttribute('action');
  // console.log(rota);
  // var verbo = form.getAttribute('method');
  // console.log(verbo);
  /*definir quando possível, se formulario guarda method e action,
  por hora é definido pela aplicação*/
  var xhr = new XMLHttpRequest();
  xhr.open(method, rota);
  var formData = new FormData(form);
	xhr.send(formData);
  xhr.onreadystatechange = function () {
    if(this.readyState == 4 && this.status == 200) {
      var recebe = this.responseText;
      return TRUE;
    }
    //opcional
    else{
      console.log('erro na conexão, realizar lista de status/erro');
      return FALSE;
    }
  }

}

function submiter_licencas(event, form, preview){
  event.preventDefault();
  console.log(attrib);
  var xhr = new XMLHttpRequest();
  xhr.open("POST", './temp.php');
  var formData = new FormData(form);
	xhr.send(formData);


	if(preview){
    xhr.addEventListener('readystatechange', function() {
      if (xhr.readyState === 4 && xhr.status == 200) {
        var json = JSON.parse(xhr.responseText); // se espera uma resposta JSON do servidor
        if (json.err === 0 && json.save === 1) {
          preview.innerHTML = "<span id='label_licencas' class='label label-primary'>Enviado!!</span>";
          form.reset();
        } else {
          switch (json.err) {
            case 1:
            preview.innerHTML = "<span id='label_licencas' class='label label-danger'>ERRO: 1.</span>";
            break;
            case 2:
            preview.innerHTML = "<span id='label_licencas' class='label label-danger'>ERRO: 2.</span>";
            break;
            case 3:
            preview.innerHTML = "<span id='label_licencas' class='label label-danger'>ERRO: 3.</span>";
            break;
            case 4:
            preview.innerHTML = "<span id='label_licencas' class='label label-danger'>Extensão de arquivo não aceita.</span>";
            break;
            case 5:
            preview.innerHTML = "<span id='label_licencas' class='label label-danger'>ERRO: 5.</span>";
            break;
            case 6:
            preview.innerHTML = "<span id='label_licencas' class='label label-danger'>ERRO: 6.</span>";
            break;
            case 7:
            preview.innerHTML = "<span id='label_licencas' class='label label-danger'>Arquivo já existe no gerenciador.</span>";
            break;
            case 8:
            preview.innerHTML = "<span id='label_licencas' class='label label-danger'>Processo referencia Licença já Salva.</span>";
            break;
            default:

          }
        }
        // preview.innerHTML = xhr.responseText; //for debbug
      } else {
        preview.innerHTML = xhr.statusText;
      }
    });
    // Monitorar o progresso e printar na tela
    xhr.upload.addEventListener("progress", function(e) {
      if (e.lengthComputable) {
        var percentage = Math.round((e.loaded * 100) / e.total);
        preview.innerHTML = String(percentage) + '%';
      }
    }, false);
    // Monitorar o progresso e printar na tela
    xhr.upload.addEventListener("load", function(e){
      preview.innerHTML = String(100) + '%';
    }, false);
  }
}
