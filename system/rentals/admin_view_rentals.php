<?php validatePermission(array(0, 1)); ?>
<h4>Aluguéis Ativos</h4>

<form name='filter' id="filter" action="?folder=rentals/&file=admin_view_rentals&ext=php" method="POST">
	<h1 onclick="$('#filter div').slideToggle()">▼ Filtro</h1>
	<div>
		<table>
			<tr>
				<td>Dias restantes</td>
				<td><input type="text" name="remaining_days" maxlength="1"></td>
			</tr>
			<tr>
				<td>MLT</td>
				<td><input type="text" name="mlt" maxlength="4"></td>
			</tr>
			<tr>
				<td>Nome do representante</td>
				<td><input type="text" name="rep_name" maxlength="70"></td>
			</tr>
			<tr>
				<td>Nome fantasia</td>
				<td><input type="text" name="trade_name" maxlength="90"></td>
			</tr>
			<tr>
				<td>Status</td>
				<td>
					<select name="status">
						<option value="">Selecione...</option>
						<option value="0">Aguardando pedido de relatório</option>
						<option value="1">Aguardando inserção dos dados</option>
						<option value="2">Aguardando finalização</option>
					</select>
				</td>
			</tr>
			<tr>
				<td colspan="2" align="center"><button type="reset" class="reset_btn">Reiniciar</button><button type="submit" class="submit_btn">Enviar</button></td>
			</tr>
		</table>
	</div>
</form>

<?php
	// seta condições de filtro
	@$condition1 = !empty($_POST['mlt'])        ? 'rentals_has_printers.printers_mlt=' . $_POST['mlt'] : 'TRUE';
	@$condition2 = !empty($_POST['rep_name'])   ? 'clients.rep_name LIKE "%' . $_POST['rep_name'] . '%"' : 'TRUE';
	@$condition3 = !empty($_POST['trade_name']) ? 'clients.trade_name LIKE "%' . $_POST['trade_name'] . '%"' : 'TRUE';
	// seta condição de dias restantes para o término
	if (!empty($_POST['remaining_days'])){
		date_default_timezone_set('America/Sao_Paulo');
		$date = date('Y-m-d h:i:s', time());
		$condition4 = 'rentals.end_date BETWEEN "'.$date.'" AND DATE_ADD("'.$date.'", INTERVAL '.$_POST['remaining_days'].' DAY)';
	} else {
		$condition4 = 'TRUE';
	}
	// seta condição de status
	if (!empty($_POST['status'])){
		if ($_POST['status'] == '2'){
			$condition5 = 'rentals.status=1 AND !ISNULL(rentals_has_printers.final_total_meter)';
		} else {
			$condition5 = 'rentals.status='.$_POST['status'].' AND ISNULL(rentals_has_printers.final_total_meter)';
		}
	} else {
		$condition5 = 'TRUE';
	}

	$sel_rentals = "SELECT *, rentals.id AS rental FROM rentals INNER JOIN clients ON rentals.clients_id=clients.id INNER JOIN rentals_has_printers ON rentals.id=rentals_has_printers.rentals_id WHERE rentals.status<>2 AND ".$condition1." AND ".$condition2." AND ".$condition3." AND ".$condition4." AND ".$condition5 . " GROUP BY rentals.id";
	$sel_rentals_prepared = $db_connection->prepare($sel_rentals);
	$sel_rentals_prepared->execute();
	
	if ($sel_rentals_prepared->rowCount()==0){
		?>
		<div class="center_box">
			<h3>Não há nenhum aluguel ativo.</h3>
		</div>
		<?php
	} else {
		while ($sel_rentals_data = $sel_rentals_prepared->fetch()) {
			?>
			<div class="rental_wrapper">
				<table>
					<tr>
						<td><b>Nome do representante:</b> </td>
						<td><?php echo $sel_rentals_data['rep_name']?></td>
						<td><b>Nome fantasia:</b> </td>
						<td><?php echo $sel_rentals_data['trade_name'] ?: 'Pessoa física'?></td>
					</tr>
					<tr>
						<!-- explode, reverte e implode de volta a data. -->
						<td><b>Data de início:</b> </td>
						<td><?php echo implode('/', array_reverse(explode('-', $sel_rentals_data['start_date'])))?></td>
						<td><b>Data de fim:</b> </td>
						<td><?php echo implode('/', array_reverse(explode('-', $sel_rentals_data['end_date'])))?></td>
					</tr>
					<tr>
						<td><b>E-mail:</b> </td>
						<td><?php echo $sel_rentals_data['email'] ?: '-'?></td>
						<td><b>Telefone:</b> </td>
						<td><?php echo $sel_rentals_data['phone'] ?: '-'?></td>
					</tr>
					<tr>
						<td><b>Cidade:</b> </td>
						<td><?php echo $sel_rentals_data['city']?></td>
						<td><b>Bairro:</b> </td>
						<td><?php echo $sel_rentals_data['neighborhood']?></td>
					</tr>
					<tr>
						<td><b>Logradouro:</b> </td>
						<td><?php echo $sel_rentals_data['street']?></td>
						<td><b>Número:</b> </td>
						<td><?php echo $sel_rentals_data['street_num']?></td>
					</tr>
					<tr>
						<td><b>Complemento:</b> </td>
						<td><?php echo $sel_rentals_data['street_comp'] ?: '-'?></td>
						<td><b>Distinção de tipo de página:</b> </td>
						<td><?php echo $sel_rentals_data['page_distinction'] ? 'Sim' : 'Não'?></td>
					</tr>
					<tr>
						<?php
							if (!$sel_rentals_data['page_distinction']){
								?>
								<td><b>Franquia:</b> </td>
								<td><?php echo $sel_rentals_data['page_cap'] ?></td>
								<td><b>Preço da franquia:</b> </td>
								<td>R$ <?php
									$price_array = explode('.', $sel_rentals_data['page_cap_price']);
									$page_cap_price = $price_array[0] . ',' . $price_array[1];
									echo $page_cap_price;
									?></td>
								<?php
							}
						?>
					</tr>
					<tr>
						<?php
							if ($sel_rentals_data['page_distinction']){
								?>
								<td><b>Preço da página P/B:</b> </td>
								<td>R$ <?php
									$price_array = explode('.', $sel_rentals_data['bw_price']);
									$bw_price = $price_array[0] . ',' . $price_array[1];
									echo $bw_price;
									?></td>
								<td><b>Preço da página colorida:</b> </td>
								<td>R$ <?php
									$price_array = explode('.', $sel_rentals_data['color_price']);
									$color_price = $price_array[0] . ',' . $price_array[1];
									echo $color_price;
									?></td>
								<?php
							} else {
								?>
								<td><b>Preço da página excedida:</b> </td>
								<td>R$ <?php
									$price_array = explode('.', $sel_rentals_data['bw_price']);
									$bw_price = $price_array[0] . ',' . $price_array[1];
									echo $bw_price;
									?></td>
								<td>-</td>
								<?php
							}
						?>
					</tr>
				</table>
				<table class="entries">
					<tr>
						<th>MLT</th>
						<th>Medidor total</th>
						<?php if ($sel_rentals_data['page_distinction']){?>
						<th>Medidor colorido</th>
						<?php }?>
						<th>Status</th>
						<th>Trocar/voltar</th>
					</tr>
					<?php
						$sel_printers = "SELECT * FROM rentals_has_printers INNER JOIN printers ON rentals_has_printers.printers_mlt=printers.mlt WHERE rentals_id=".$sel_rentals_data['rental']." ORDER BY printers_mlt";
						$sel_printers_prepared = $db_connection->prepare($sel_printers);
						$sel_printers_prepared->execute();
						
						while ($sel_printers_data = $sel_printers_prepared->fetch()) {
							if ($sel_printers_data['status'] == '1'){
								$final_meter = $sel_printers_data['final_total_meter'];
							}
							?>
							<tr>
								<td><?php echo $sel_printers_data['mlt']?></td>
								<td><?php echo $sel_printers_data['initial_total_meter']?></td>
								<?php if ($sel_rentals_data['page_distinction']){?>
								<td><?php echo $sel_printers_data['initial_color_meter']?></td>
								<?php }?>
								<td><?php echo $sel_printers_data['status'] == '1' ? 'Alugada' : 'Retirada'?></td>
								<td>
									<?php
										if ($sel_printers_data['status'] == '1') {
											?>
											<a href="?folder=rentals/&file=fm_exchangeprinter_rentals&ext=php&pd=<?php echo $sel_rentals_data['page_distinction']?>&mlt=<?php echo $sel_printers_data['mlt'];?>&id=<?php echo $sel_rentals_data['rental'];?>"><img height="20px" src="../layout/images/exchange.png"></a>
											<?php
										} else {
											?>
											<script>
												function confirmReturn(){

													return confirm("Você tem certeza que quer retornar essa impressora ao aluguel?");

												}
											</script>
											<a onclick='return confirmReturn()' href="?folder=rentals/&file=returnprinter_rentals&ext=php&mlt=<?php echo $sel_printers_data['mlt'];?>&id=<?php echo $sel_rentals_data['rental'];?>"><img height="20px" src="../layout/images/check.png"></a>
											<?php
										}
									?>
								</td>
							</tr>
							<?php
						}
					?>
				</table>
				<script>
					function confirmRequest(){

						return confirm("Você tem certeza que quer confirmar o pedido de relatório?");

					}
				</script>
				<?php

					switch($sel_rentals_data['status']){
						case 0:
							echo "<a onclick='return confirmRequest()' href='?folder=rentals/&file=confirmrequest_rentals&ext=php&id=".$sel_rentals_data['rental']."'>Confirmar pedido de relatório</a>";
							break;
						case 1:
							if (!$final_meter){
								echo "<a href='?folder=rentals/&file=insertdata_rentals&ext=php&id=".$sel_rentals_data['rental']."'>Inserir dados do relatório</a>";
							} else {
								?>
								<a href='?folder=rentals/&file=fmrenew_rentals&ext=php&id=<?php echo $sel_rentals_data['rental']?>'>Renovar aluguel</a> / <a href='?folder=rentals/&file=finalize_rentals&ext=php&id=<?php echo $sel_rentals_data['rental']?>'>Finalizar aluguel</a><br>
								<a href='?folder=rentals/&file=finalreport_rentals&ext=php&id=<?php echo $sel_rentals_data['rental']?>'>Visualizar relatório final</a>
								<?php
							}
							break;
					}

				?>
			</div>
			<?php
		}
	}
?>