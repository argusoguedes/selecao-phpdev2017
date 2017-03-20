<?php
require_once("../_inc/global.php");

$mysql = new GDbMysql();
$form = new GForm();

//<editor-fold desc="Header">
$title = '<span class="acaoTitulo"></span>';
$tools = '<a id="f__btn_voltar"><i class="fa fa-arrow-left font-blue-steel"></i> <span class="hidden-phone font-blue-steel bold uppercase">Voltar</span></a>';
$htmlForm .= getWidgetHeader($title, $tools);

$htmlForm .= '<div style="padding: 50px;"> <img src="../../fotos/placeholder.png" id="foto" width="50px height="50px"/>';
$htmlForm .= '<form method="POST" id="formImage" action="/upload" enctype="multipart/form-data">';
$htmlForm .= '<input name="argus" id="argus" type="file" class="form-control">';
$htmlForm .= '<button class="submit btn btn-danger" type="submit" "> Upload  </button>';
$htmlForm .= '</form>';
$htmlForm .=' </div>';


$htmlForm .= $form->open('form', 'form-vertical form');
$htmlForm .= $form->addInput('hidden', 'acao', false, array('value' => 'ins', 'class' => 'acao'), false, false, false);
$htmlForm .= $form->addInput('hidden', 'ani_int_codigo', false, array('value' => ''), false, false, false);
$htmlForm .= $form->addInput('hidden', 'ani_var_foto', false, array('value' => '', 'id'=>'ani_var_foto'), false, false, false);
$htmlForm .= $form->addInput('text', 'ani_var_nome', 'Nome*', array('maxlength' => '50', 'validate' => 'required'));
$htmlForm .= $form->addSelect('ani_cha_vivo', array('S' => 'Sim', 'N' => 'Não'), '', 'Vivo*', array('validate' => 'required'), false, false, true, '', 'Selecione...');

        $array_proprietario = array();
        $query = "SELECT pro_int_codigo,pro_var_nome FROM vw_proprietario WHERE 1";
       
        $mysql->execute($query, null);

        if ($mysql->numRows() > 0) {
            while ($mysql->fetch()) {
                $array_proprietario[$mysql->res['pro_int_codigo']] = $mysql->res['pro_var_nome'];
            }
        }
        
        $mysql->close();
        
$htmlForm .= $form->addSelect('pro_int_codigo', $array_proprietario, '', 'Proprietário*', array('validate' => 'required', 'class'=> 'js-example-basic-single'), false, false, true, '', 'Selecione...');

$htmlForm .= $form->addInput('text', 'ani_dec_peso', 'Peso*', array('maxlength' => '100', 'validate' => 'required'));
$htmlForm .= $form->addInput('text', 'ani_var_raca', 'Raça*', array('maxlength' => '100', 'validate' => 'required'));


$htmlForm .= '<div class="form-actions">';
$htmlForm .= getBotoesAcao(true);
$htmlForm .= '</div>';
$htmlForm .= $form->close();
//</editor-fold>
$htmlForm .= getWidgetFooter();

echo $htmlForm;
?>
<script type="application/javascript">
    $(function() {
        
        $('#formImage').on('submit', uploadFiles);
        
        $('#ani_dec_peso').maskMoney({thousands:'.', decimal:',', precision:3,  affixesStay: false});

        $('#form').submit(function() {
            var ani_int_codigo = $('#ani_int_codigo').val();
            $('#p__selecionado').val();
            if ($('#form').gValidate()) {
                var method = ($('#acao').val() == 'ins') ? 'POST' : 'PUT';
                var endpoint = ($('#acao').val() == 'ins') ? URL_API + 'animais' : URL_API + 'animais/' + ani_int_codigo;
                $.gAjax.exec(method, endpoint, $('#form').serializeArray(), false, function(json) {
                    if (json.status) {
                        showList(true);
                    }
                });
            }
            return false;
        });

        $('#f__btn_cancelar, #f__btn_voltar').click(function() {
            showList();
            return false;
        });

        $('#f__btn_excluir').click(function() {
            var ani_int_codigo = $('#ani_int_codigo').val();

            $.gDisplay.showYN("Quer realmente deletar o item selecionado?", function() {
                $.gAjax.exec('DELETE', URL_API + 'usuarios/' + ani_int_codigo, false, false, function(json) {
                    if (json.status) {
                        showList(true);
                    }
                });
            });
        });
    });
    
    function uploadFiles(event)
    {
        event.stopPropagation();
        event.preventDefault();
        
        var data = new FormData();
	jQuery.each(jQuery('#argus')[0].files, function(i, file) {
	    data.append('argus', file);
	});
	
	if(data.get('argus') != null){
		
		var opts = {
			    url: URL_API + 'animais/upload',
			    data: data,
			    cache: false,
			    contentType: false,
			    processData: false,
			    type: 'POST',
			    success: function(data){
                                var res = data.split("/");
                                var foto = res[res.length-1].split(".");
                                $("#ani_var_foto").val(foto[0] + "." + foto[2]);
			        $("#foto").prop("src", data);
			    },
			    fail: function(){
			    	alert("Erro ao realizar upload da foto!")
			    }
		};
		
		if(data.fake) {
		    // Make sure no text encoding stuff is done by xhr
		    opts.xhr = function() { 
		    		var xhr = jQuery.ajaxSettings.xhr(); 
		    		xhr.send = xhr.sendAsBinary; 
		    		return xhr; 
			};
		    opts.contentType = "multipart/form-data; boundary="+data.boundary;
		    opts.data = data.toString();
		}
		
		jQuery.ajax(opts);
        }
    }   
</script>