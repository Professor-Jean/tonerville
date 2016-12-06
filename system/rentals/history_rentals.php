<?php validatePermission(array(0, 1)); ?>
<h4>Histórico de Aluguéis</h4>
<form name='filter' id="filter" action="#" method="POST">
	<h1 onclick="$('#filter div').slideToggle()">▼ Filtro</h1>
	<div>
		<table>
		<tr>
			<td>MLT</td>
			<td><input type="text" maxlength="4" name="mlt"></td>
		</tr>
		<tr>
			<td>Nome fantasia</td>
			<td><input type="text" maxlength="90" name="trade_name"></td>
		</tr>
		<tr>
			<td>Nome representante</td>
			<td><input type="text" maxlength="70" name="rep_name"></td>
		</tr>
			<tr>
				<td>Data de início</td>
				<td><input readonly class="datepicker" type="text" name="start_date" placeholder="dd/mm/aaaa"></td>
			</tr>
			<tr>
				<td>Data de término</td>
				<td><input readonly class="datepicker" type="text" name="end_date" placeholder="dd/mm/aaaa"></td>
			</tr>
		<tr>
			<td colspan="2"><button type="reset" class="reset_btn">Reiniciar</button><button type="submit" class="submit_btn">Enviar</button></td>
		</tr>
	</table>
	</div>
	</form>
<?php
	if($_POST['start_date']!="") {
		$date_array = explode('/', $_POST['start_date']);
		$p_start_date = $date_array[2] . '-' . $date_array[1] . '-' . $date_array[0];
	}
	if($_POST['end_date']!="") {
		$date_array = explode('/', $_POST['end_date']);
		$p_end_date = $date_array[2] . '-' . $date_array[1] . '-' . $date_array[0];
	}
	@$condition1 = !empty($_POST['mlt'])  ? "rentals_has_printers.printers_mlt = '" .$_POST['mlt'] ."'" : "TRUE";
	@$condition2 = !empty($_POST['trade_name']) ? "clients.trade_name LIKE '%".$_POST['trade_name']."%'" : "TRUE";
	@$condition3 = !empty($_POST['rep_name']) ? "clients.rep_name LIKE '%".$_POST['rep_name']."%'" : "TRUE";
	@$condition4 = !empty($p_start_date) ? "rentals.start_date LIKE '%".$p_start_date."%'" : "TRUE";
	@$condition5 = !empty($p_end_date) ? "rentals.end_date LIKE '%".$p_end_date."%'" : "TRUE";

	$sel_rentals = "SELECT clients.id, clients.rep_name, clients.trade_name, rentals.start_date, rentals.end_date, rentals.id AS rental FROM rentals INNER JOIN clients ON rentals.clients_id=clients.id INNER JOIN rentals_has_printers ON rentals_has_printers.rentals_id = rentals.id WHERE rentals.status=2 AND ".$condition1." AND ".$condition2." AND ".$condition3." AND ".$condition4." AND ".$condition5." GROUP BY rentals.id";
	$sel_rentals_prepared = $db_connection->prepare($sel_rentals);
	$sel_rentals_prepared->execute();
?>
	<table class="entries rental_history">
	<tr>
		<th width="10%">MLTs</th>
		<th width="20%">Nome Representante</th>
		<th width="20%">Nome fantasia</th>
		<th width="20%">Data de início</th>
		<th width="20%">Data de término</th>
		<th width="20%">Detalhes</th>
	</tr>
	<?php
		if($sel_rentals_prepared->rowCount()>0){
			while($sel_rentals_data = $sel_rentals_prepared->fetch()){
				$start_date = explode("-", $sel_rentals_data['start_date']);
				$end_date = explode("-", $sel_rentals_data['end_date']);
				?>
				<tr>
					<td><a href="#" onclick="$(this).parent().parent().next().toggle()"><img src="../layout/images/expand.png" height="20px" width="20px"></a></td>
					<td><?php echo $sel_rentals_data['rep_name']; ?></td>
					<td><?php echo $sel_rentals_data['trade_name'] ?: 'Pessoa física'; ?></td>
					<td><?php echo $start_date[2] . "/" . $start_date[1] . "/" . $start_date[0]; ?></td>
					<td><?php echo $end_date[2] . "/" . $end_date[1] . "/" . $end_date[0]; ?></td>
					<td><a href="?folder=rentals/&file=detailed_rentals&ext=php&id=<?php echo $sel_rentals_data['rental'];?>" title="Detalhes"><img src="../layout/images/external.png" height="20px"></a></td>
				</tr>
				<tr class="mlt_row">
					<td colspan="6">
						<?php
							$sel_printers = "SELECT rentals_has_printers.printers_mlt FROM rentals_has_printers INNER JOIN rentals ON rentals_has_printers.rentals_id=rentals.id WHERE rentals.id=".$sel_rentals_data['rental'];
							$sel_printers_prepared = $db_connection->prepare($sel_printers);
							$sel_printers_prepared->execute();
							$mlts = "";

							while($sel_printers_data = $sel_printers_prepared->fetch()){
								$mlts .= $sel_printers_data['printers_mlt'] . ", ";
							}
							echo substr($mlts, 0, -2);
						?>
					</td>
				</tr>
				<?php
			}
		}else {
			?>
			<tr>
				<td colspan="6">Não há registros.</td>
			</tr>
			<?php
		}
	?>
</table>