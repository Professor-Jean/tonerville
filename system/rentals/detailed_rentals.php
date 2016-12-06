<?php validatePermission(array(0, 1));
	$g_id = $_GET['id'];
	$sel_rentals = "SELECT *, rentals.id AS rental FROM rentals INNER JOIN clients ON rentals.clients_id=clients.id WHERE rentals.id=".$g_id;
	$sel_rentals_prepared = $db_connection->prepare($sel_rentals);
	$sel_rentals_prepared->execute();
	$sel_rentals_data = $sel_rentals_prepared->fetch();
?>
<h4>Consulta Detalhada de Aluguel Finalizado</h4>
<div class="rental_wrapper" id="final_report">
	<table class="entries">
		<tr>
			<th>MLT</th>
			<th>Medidor total inicial</th>
			<th>Medidor total final</th>
			<?php if ($sel_rentals_data['page_distinction']){?>
				<th>Medidor colorido inicial</th>
				<th>Medidor colorido final</th>
				<th>Páginas P/B</th>
				<th>Páginas Coloridas</th>
			<?php } else { ?>
				<th>Páginas impressas</th>
			<?php } ?>
		</tr>
		<?php
			$sel_printers = "SELECT * FROM rentals_has_printers INNER JOIN printers ON rentals_has_printers.printers_mlt=printers.mlt WHERE rentals_id=".$sel_rentals_data['rental']." ORDER BY printers_mlt";
			$sel_printers_prepared = $db_connection->prepare($sel_printers);
			$sel_printers_prepared->execute();
			
			$total_color_pages = 0;
			$total_bw_pages = 0;
			
			while ($sel_printers_data = $sel_printers_prepared->fetch()) {
				$color_pages = $sel_printers_data['final_color_meter'] - $sel_printers_data['initial_color_meter'];
				$bw_pages = $sel_printers_data['final_total_meter'] - $sel_printers_data['initial_total_meter'] - $color_pages;
				
				$total_color_pages += $color_pages;
				$total_bw_pages += $bw_pages;
				?>
				<tr>
					<td><?php echo $sel_printers_data['mlt']?></td>
					<td><?php echo $sel_printers_data['initial_total_meter']?></td>
					<td><?php echo $sel_printers_data['final_total_meter']?></td>
					<?php if ($sel_rentals_data['page_distinction']){?>
						<td><?php echo $sel_printers_data['initial_color_meter']?></td>
						<td><?php echo $sel_printers_data['final_color_meter']?></td>
						<td><?php echo $bw_pages?></td>
						<td><?php echo $color_pages?></td>
					<?php } else {?>
						<td><?php echo $bw_pages?></td>
					<?php }?>
				</tr>
				<?php
			}
		?>
	</table>
	<table>
		<tr>
			<td><b>Nome do representante:</b> </td>
			<td><?php echo $sel_rentals_data['rep_name']?></td>
			<td><b>Nome fantasia:</b> </td>
			<td><?php echo $sel_rentals_data['trade_name'] ?: 'Pessoa física'?></td>
		</tr>
		<tr>
			<td><b>Data de início:</b> </td>
			<td><?php echo implode("/", array_reverse(explode("-", $sel_rentals_data['start_date'])))?></td>
			<td><b>Data de fim:</b> </td>
			<td><?php echo implode("/", array_reverse(explode("-", $sel_rentals_data['end_date'])))?></td>
		</tr>
		<tr>
			<td><b>E-mail:</b> </td>
			<td><?php echo $sel_rentals_data['email'] ?: "-"?></td>
			<td><b>Telefone:</b> </td>
			<td class="phone_mask optional_mask"><?php echo $sel_rentals_data['phone']?></td>
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
			<td><?php echo $sel_rentals_data['street_comp'] ?: "-"?></td>
			<td><b>CEP:</b> </td>
			<td class="cep_mask"><?php echo $sel_rentals_data['cep']?></td>
		</tr>
		<tr>
			<td><b>CNPJ:</b> </td>
			<td class="cnpj_mask optional_mask"><?php echo $sel_rentals_data['cnpj'] ?: "-"?></td>
			<td><b>Inscrição estadual:</b> </td>
			<td><?php echo $sel_rentals_data['ie'] ?: "-"?></td>
		</tr>
		<tr>
			<?php
				if (!$sel_rentals_data['page_distinction']){
					?>
					<td><b>Franquia:</b> </td>
					<td><?php echo $sel_rentals_data['page_cap'] ?></td>
					<td><b>Preço da franquia:</b> </td>
					<td>R$ <?php
							$cap_price_array = explode('.', $sel_rentals_data['page_cap_price']);
							$cap_price = $cap_price_array[0] . ',' . $cap_price_array[1];
							echo $cap_price;
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
							$bw_price_array = explode('.', $sel_rentals_data['bw_price']);
							$bw_price = $bw_price_array[0] . ',' . $bw_price_array[1];
							echo $bw_price;
						?></td>
					<td><b>Preço da página colorida:</b> </td>
					<td>R$ <?php
							$color_price_array = explode('.', $sel_rentals_data['color_price']);
							$color_price = $color_price_array[0] . ',' . $color_price_array[1];
							echo $color_price;
						?></td>
					<?php
				} else {
					?>
					<td><b>Preço da página excedida:</b> </td>
					<td>R$ <?php
							$exed_price_array = explode('.', $sel_rentals_data['bw_price']);
							$exed_price = $exed_price_array[0] . ',' . $exed_price_array[1];
							echo $exed_price;
						?></td>
					<td>-</td>
					<?php
				}
			?>
		</tr>
		<tr>
			<?php
				if ($sel_rentals_data['page_distinction']){
					?>
					<td><b>Páginas P/B impressas:</b> </td>
					<td><?php echo $total_bw_pages ?></td>
					<td><b>Páginas coloridas impressas:</b> </td>
					<td><?php echo $total_color_pages ?></td>
					<?php
				} else {
					?>
					<td><b>Páginas P/B impressas:</b> </td>
					<td><?php echo $total_bw_pages ?></td>
					<td>-</td>
					<?php
				}
			?>
		</tr>
		<tr>
			<?php
				if ($sel_rentals_data['page_distinction']){
					$total_price = ($total_bw_pages * $sel_rentals_data['bw_price']) + ($total_color_pages * $sel_rentals_data['color_price']);
				} else {
					
					if ($total_bw_pages < $sel_rentals_data['page_cap']){
						$total_price = $sel_rentals_data['page_cap_price'];
					} else {
						$total_price = (($total_bw_pages - $sel_rentals_data['page_cap']) * $sel_rentals_data['bw_price']) + $sel_rentals_data['page_cap_price'];
					}
					
				}
			?>
			<td><b>Preço total:</b></td>
			<td> R$ <?php echo number_format($total_price, 2, ',', '.')?></td>
		</tr>
	</table>
</div>