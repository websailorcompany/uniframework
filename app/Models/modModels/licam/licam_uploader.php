<?php
$c['box-warning'] = "teste de warning";
$c['box-warning'] = 	(	empty($c['box-warning'])? "":
				htmlspecialchars_decode("<div class='callout callout-info'>
					<h4>Informação!</h4>
						". $c['box-warning'] ."
					<br><a href='./'>Analise a documentação</a>
				</div>")
			);
$x=ini_get('upload_max_filesize');
$c['box-title'] = "Upload de Licenças Emitidas: arquivo de até {$x}";
$c['box-body']=htmlspecialchars_decode("
  <form role='form' method='post' enctype='multipart/form-data' action='licam/licam_upload' id='envia_licam_doc' name='envia_licam_doc' onsubmit=\"submiter_licencas(event, this, document.getElementById('label_up_licencas') );\">
    <div class='box-body'>
    <div class='form-group'>
      <label for='sigma_lic'>Identificação</label>
      <input class='form-control' type='text' id='sigma_lic' name='sigma_lic' placeholder='Identificação da licença. Ex: 123/2017 ou 018/2018' required>
			<label for='sigma_lic_ano'>Ano da Licença</label>
      <input class='form-control' type='text' id='sigma_lic_ano' name='sigma_lic_ano' placeholder='ano' required>
      <label for='sigma_lic_razao_social'>Razão Social</label>
      <input class='form-control' type='text' id='sigma_lic_razao_social' name='sigma_lic_razao_social' placeholder='Razão Social referente à licença' required>
			<label for='sigma_lic_nome_fantasia'>Nome Fantasia [opcional]</label>
			<input class='form-control' type='text' id='sigma_lic_nome_fantasia' name='sigma_lic_nome_fantasia' placeholder='Nome Fantasia referente à Razão Social'>
    </div>
    <div class='form-group'>
      <label for='sigma_doc_for_licam'>Upload do arquivo</label>
      <input type='file' id='sigma_doc_for_licam' name='sigma_doc_for_licam'>
    </div>
    </div>
  </form>");

$c['box-footer'] = "	<button type='reset' class='btn btn-default'>
                Cancelar
            </button>
            <button type='submit' id='doc_submit' name='doc_submit' form='envia_licam_doc' class='btn btn-info pull-right'>
                Enviar
            </button>";

return $c;
