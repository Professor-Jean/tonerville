<?php validatePermission(array(2)); ?>
<h4>Aluguel Ativo</h4>

<?php

	$sel_rentals = "SELECT * FROM rentals INNER JOIN clients ON rentals.clients_id=clients.id WHERE status<>2 AND clients.users_id='".$_SESSION['user_id']."'";
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
			<div class="rental_wrapper" style="border: 0">
				<table>
					<tr>
						<!-- explode, reverte e implode de volta a data. -->
						<td><b>Data de início:</b> </td>
						<td><?php echo implode('/', array_reverse(explode('-', $sel_rentals_data['start_date'])))?></td>
						<td><b>Data de fim:</b> </td>
						<td><?php echo implode('/', array_reverse(explode('-', $sel_rentals_data['end_date'])))?></td>
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
			</div>
			<?php
		}
	}
?>