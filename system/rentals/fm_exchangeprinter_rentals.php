<?php
	validatePermission(array(0, 1));
	$g_mlt = $_GET['mlt'];
	$g_id = $_GET['id'];
	$g_page_distinction = $_GET['pd'];
?>
<h4>Aluguéis</h4>
<div class="center_box">
	<h2>Trocar impressora</h2>
	<form name="exchangeprinter" method="post" action="?folder=rentals/&file=exchangeprinter_rentals&ext=php">
		<input type="hidden" name="old_mlt" value="<?php echo $g_mlt?>">
		<input type="hidden" name="page_distinction" value="<?php echo $g_page_distinction?>">
		<input type="hidden" name="rental_id" value="<?php echo $g_id?>">
		<table>
			<tr>
				<td colspan="2" align="center">Retirar impressora - MLT: <?php echo $g_mlt?></td>
			</tr>
			<tr>
				<td>*Medidor total final</td>
				<td><input type="text" maxlength="100" name="final_total_meter"></td>
			</tr>
			<?php
				if ($g_page_distinction == '1'){
					?>
					<tr>
						<td>Medidor colorido final</td>
						<td><input type="text" maxlength="100" name="final_color_meter"></td>
					</tr>
					<?php
				}
			?>
			<tr>
				<td colspan="2" align="center">Impressora nova</td>
			</tr>
			<tr>
				<td>MLT</td>
				<td>
					<select name="mlt">
						<option value="">Selecione...</option>
						<?php

							$sel_printers = "SELECT * FROM printers WHERE status=0 ORDER BY mlt";
							$sel_printers_prepared = $db_connection->prepare($sel_printers);
							$sel_printers_prepared->execute();

							while ($sel_printers_data = $sel_printers_prepared->fetch()){
								echo "<option value='".$sel_printers_data['mlt']."'>".$sel_printers_data['mlt']."</option>";
							}

						?>
					</select>
				</td>
			</tr>
			<tr>
				<td>*Medidor total inicial</td>
				<td><input type="text" maxlength="100" name="initial_total_meter"></td>
			</tr>
			<?php
				if ($g_page_distinction == '1'){
					?>
					<tr>
						<td>*Medidor colorido inicial</td>
						<td><input type="text" maxlength="100" name="initial_color_meter"></td>
					</tr>
					<?php
				}
			?>
			<tr>
				<td colspan="2"><button type="reset" class="reset_btn">Reiniciar</button><button type="submit" class="submit_btn">Enviar</button></td>
			</tr>
		</table>
	</form>
</div>