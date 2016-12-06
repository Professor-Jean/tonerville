<?php
	
	function safeDelete($value, $action, $type, $name){
		// nome de formulário único
		$form_name = md5($value.time());
		// verificando se há dois ids
		$value = explode("&", $value);
		if (isset($value[1])){
			// criptografando o valor
			$secretValue = md5($value[0]) . "&" . md5($value[1]);
		} else {
			$secretValue = md5($value[0]);
		}
		
		// iniciando o formulário
		$safeLink  = "<form name='".$form_name."' action='".$action."' method='POST' ";
		// adicionando a confirmação de exclusão
		$safeLink .= "onSubmit=\"return confirmDelete('".$type."', '".$name."')\">";
		// adicionando o input com o id a ser excluído
		$safeLink .= "<input type='hidden' name='id' value='".$secretValue."'>";
		// adicionando o botão de excluir
		$safeLink .= "<input type='image' height='20' src='../layout/images/delete.png' title='Excluir Registro'/>";
		// fechando o formulário
		$safeLink .= "</form>";
		
		return $safeLink;
	}