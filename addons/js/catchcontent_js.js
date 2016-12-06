// Função para pegar conteúdo da página para qual será gerado um pdf pelo mpdf.
function catchContent(){

	var dados = ""; //iniciando variável

	$('.imprimir').each(function(){ //executa para cada tag com a classe "imprimir"
		dados += $(this).html(); //adiciona o conteúdo da tag para a variável "dados"
	});

	if(dados != ""){ //valida se algo foi encontrado
		dados = dados.replace('/href="[^"]*"/', ''); // tira os links
		$('#dadospdf').val(dados); //atribui a variável "dados" para o valor do input id "dadospdf"
		return true; //retorna true para o formulário ser enviado
	}

	alert("Problema ao gerar o PDF, recarregue a página e tente novamente."); //caso true não seja retornado, alertar o usuário de erros
	return false; //retorna false para o formulário não ser enviado

}

