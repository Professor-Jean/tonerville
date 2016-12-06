<?php
	validatePermission(array(0, 1));
	$g_id = $_GET['id'];

	$sel_rentals = "SELECT * FROM rentals WHERE rentals.id=".$g_id;
	$sel_rentals_prepared = $db_connection->prepare($sel_rentals);
	$sel_rentals_prepared->execute();
	$sel_rentals_data = $sel_rentals_prepared->fetch();

	$page_d = $sel_rentals_data['page_distinction'];
?>
<script> // programação do formulário mestre/detalhe
	
	function toggleDistinction(){
		// esconde/mostra os campos de página colorida
		$('.page_distinction').toggle();
		// esvazia os valores de página colorida
		$('[name="color_meter[]"]').val("");
		// esvazia oa valores de franquia e bota como readonly
		$('[name="page_cap"]').val(0);
		$('[name="page_cap"]').prop('readonly', $('[name="page_distinction"]:checked').length);
		$('[name="page_cap_price"]').val(0);
		$('[name="page_cap_price"]').prop('readonly', $('[name="page_distinction"]:checked').length);
	}
	
	// inicia as funções de adiçionar/excluir campos
	$(function () {
		// verifica se a distinção de página está selecionada
		if($('[name="page_distinction"]:checked').length){
			toggleDistinction();
		}
		//cria a função de remover campo
		function removeField() {
			//desvincula os elementos da class "remove_field" à função criada abaixo, para que o alert de "A última linha não pode ser removida." funcione apenas quando necessário
			$(".remove_field").unbind("click");
			// adiciona a seguinte função ao evento de click dos elementos com classe remove_field
			$(".remove_field").bind("click", function(){
				// verifica que existe mais do que uma linha
				if($("tr.lines").length > 1){
					// remove a linha (this é o botão, primeiro parent é o td, segundo parent é o tr)
					$(this).parent().parent().remove();
				}else{
					alert("A última linha não pode ser removida.");
				}
				//fecha a function do bind
			});
			//fecha a função removeField
		}

		// adiciona a seguinte função ao evento de click dos elementos com classe add_field
		$(".add_field").click(function(){
			// clona o primeiro detalhe e armazena numa variável
			novoCampo = $("tr.lines:first").clone();
			// esvazia os inputs do detalhe
			novoCampo.find("input").val("");
			novoCampo.find("select").val("");
			// insere o clone após a última linha
			novoCampo.insertAfter("tr.lines:last");
			// executa o removeField, que adiciona a função de remover campo ao botão adequado
			removeField();
		});

		// verifica se o botão de distinção deve estar checado
		<?php
			if ($page_d){
		?>
		$('[name="page_distinction"]').prop('checked', true);
		toggleDistinction();
		<?php
			}
		?>
		// executa a função do bind dos botões
		$(".remove_field").bind("click", function(){
			// verifica que existe mais do que uma linha
			if($("tr.lines").length > 1){
				// remove a linha (this é o botão, primeiro parent é o td, segundo parent é o tr)
				$(this).parent().parent().remove();
			}else{
				alert("A última linha não pode ser removida.");
			}
			//fecha a function do bind
		});
	});

	function validateDetails(){
		// recebe os valores dos mlts preenchidos
		var validateMLT = document.getElementsByName('mlt[]');
		// recebe os valores dos medidores totais preenchidos
		var validateTotal = document.getElementsByName('total_meter[]');
		// valida todos os campos para cada linha de detalhes
		var validateColor = document.getElementsByName('color_meter[]');
		// valida todos os campos para cada linha de detalhes
		for (var i = 0; i < validateMLT.length; i++){
			// verifica se algum campo está vazio
			if ((validateMLT[i].value=="")||(validateTotal[i].value=="")||(validateColor[i].value=="" && $('[name="page_distinction"]:checked').length)){
				// avisa que linha foi preenchida incorretamente (i começa em 0, entao i:0=linha:1, por isso o (i+1))
				alert ("A linha "+ (i+1) +" foi preenchida incorretamente.");
				return false;
			}
			if ((parseInt(validateColor[i].value) > parseInt(validateTotal[i].value)) && $('[name="page_distinction"]:checked').length){
				alert("O medidor colorido não pode ser maior do que o total. (linha "+ (i+1) +")");
				return false;
			}
		}
	}

</script>
<h4>Aluguéis</h4>
<div class="center_box">
	<h2>Renovar aluguel</h2>
	<form name="rental" method="post" action="?folder=rentals/&file=renew_rentals&ext=php" onsubmit="return validateRentals();">
		<input type="hidden" name="rental_id" value="<?php echo $sel_rentals_data['id']?>">
		<table>
			<tr>
				<td>*Cliente</td>
				<td>
					<?php
						$sel_clients = "SELECT clients.id, clients.trade_name, clients.rep_name FROM clients LEFT JOIN rentals ON clients.id=rentals.clients_id WHERE (ISNULL(rentals.id) OR clients.id='".$sel_rentals_data['clients_id']."')";
						$sel_clients_prepared = $db_connection->prepare($sel_clients);
						$sel_clients_prepared->execute();
					?>
					<select name="client">
						<option value="">Selecione...</option>
						<?php
							while($sel_clients_data = $sel_clients_prepared->fetch()){

								// deixa a opção selecionada se for a do cliente
								echo $sel_clients_data['id'] == $sel_rentals_data['clients_id'] ? "<option selected " : "<option ";
								// printa o resto da opção
								echo "value='".$sel_clients_data['id']."'>".$sel_clients_data['rep_name']." - ".($sel_clients_data['trade_name'] ?: 'Pessoa física')."</option>";
							}
						?>
					</select>
				</td>
			</tr>
			<tr>
				<td>*Data de início</td>
				<td><input readonly class="datepicker" type="text" name="start_date" value="<?php echo implode('/', array_reverse(explode('-', $sel_rentals_data['end_date'])))?>"></td>
			</tr>
			<tr>
				<td>*Data de fim</td>
				<td><input readonly class="datepicker" type="text" name="end_date" placeholder="dd/mm/aaaa"></td>
			</tr>
			<tr>
				<td>Franquia</td>
				<td><input type="text" maxlength="5" name="page_cap" placeholder="páginas" value="<?php echo $sel_rentals_data['page_cap']?>"></td>
			</tr>
			<tr>
				<td>Preço da franquia</td>
				<td><input type="text" class="money_mask" maxlength="7" name="page_cap_price" placeholder="R$" value="<?php echo $sel_rentals_data['page_cap_price']?>"></td>
			</tr>
			<tr>
				<td colspan="2" align="center"><input type="checkbox" name="page_distinction" value="1" onclick="toggleDistinction()"> Haverá distinção por tipo de página</td>
			</tr>
			<tr>
				<td>*Preço da página monocromática excedida</td>
				<td><input type="text" class="money_mask" maxlength="4" name="bw_price" placeholder="R$" value="<?php echo $sel_rentals_data['bw_price']?>"></td>
			</tr>
			<tr class="page_distinction">
				<td style="text-align: left">Preço da página colorida excedida</td>
				<td><input type="text" class="money_mask" maxlength="4" name="color_price" placeholder="R$" value="<?php echo $sel_rentals_data['color_price']?>"></td>
			</tr>
		</table>
		<h3>Adicionar Impressoras</h3>
		<table>
			<tr>
				<th>*MLT</th>
				<th>*Medidor Total</th>
				<th class="page_distinction">Medidor Colorido</th>
				<th><a class="add_field" title="Adicionar item"><img height="20px" src="../layout/images/add.png"></a></th>
			</tr>
			<?php
				$sel_rentalprinters = "SELECT * FROM rentals_has_printers WHERE rentals_id=".$sel_rentals_data['id'];
				$sel_rentalprinters_prepared = $db_connection->prepare($sel_rentalprinters);
				$sel_rentalprinters_prepared->execute();

				while($sel_rentalprinters_data = $sel_rentalprinters_prepared->fetch()) {
					?>
					<tr class="lines">
						<td>
							<select name="mlt[]">
								<option value="">...</option>
								<?php

									$sel_printers = "SELECT * FROM printers LEFT JOIN rentals_has_printers ON printers.mlt=rentals_has_printers.printers_mlt WHERE printers.status=0 OR rentals_has_printers.rentals_id=".$sel_rentals_data['id']." ORDER BY mlt";
									$sel_printers_prepared = $db_connection->prepare($sel_printers);
									$sel_printers_prepared->execute();

									while ($sel_printers_data = $sel_printers_prepared->fetch()) {
										echo $sel_printers_data['mlt'] == $sel_rentalprinters_data['printers_mlt'] ? "<option selected " : "<option ";
										echo "value='" . $sel_printers_data['mlt'] . "'>" . $sel_printers_data['mlt'] . "</option>";
									}

								?>
							</select>
						</td>
						<td><input type="text" name="total_meter[]" maxlength="6" placeholder="páginas"></td>
						<td class="page_distinction"><input type="text" name="color_meter[]" maxlength="6" placeholder="páginas"></td>
						<td width="10%"><a class="remove_field" title="Remover linha"><img height="20px" src="../layout/images/delete.png"></a></td>
					</tr>
					<?php
				}
			?>
		</table>
		<table>
			<tr>
				<td colspan="2"><button type="reset" class="reset_btn">Reiniciar</button><button type="submit" class="submit_btn">Enviar</button></td>
			</tr>
		</table>
	</form>
</div>