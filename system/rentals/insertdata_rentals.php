<?php validatePermission(array(0, 1)); ?>
<?php
	$g_id = $_GET['id'];
	$sel_rentals = "SELECT id, page_distinction FROM rentals WHERE id='".$g_id."'";
	$sel_rentals_prepared = $db_connection->prepare($sel_rentals);
	$sel_rentals_prepared->execute();
	$sel_rentals_data = $sel_rentals_prepared->fetch();
	$sel_rentals_has_printers = "SELECT printers.mlt FROM rentals_has_printers INNER JOIN printers ON rentals_has_printers.printers_mlt=printers.mlt INNER JOIN rentals ON rentals_has_printers.rentals_id=rentals.id WHERE rentals.id='".$g_id."' and printers.status=1";
	$sel_rentals_has_printers_prepared = $db_connection->prepare($sel_rentals_has_printers);
	$sel_rentals_has_printers_prepared->execute();
	?>
<h4>Inserção de Dados do Relatório</h4>
<div class="center_box">
	<h2>Inserir dados do relatório</h2>
	<form name="insertdata" method="post" action="?folder=rentals/&file=ins_insertdata_rentals&ext=php" onsubmit="return validateInsertdata();">
		<input type="hidden" name="hidid" value="<?php echo $sel_rentals_data['id'];?>" />
		<table>
			<tr>
				<th>MLT</th>
				<th>Medidor Total</th>
				<?php if ($sel_rentals_data['page_distinction']){?>
					<th>Medidor colorido</th>
				<?php }?>
			</tr>
			<?php
				if($sel_rentals_has_printers_prepared->rowCount()>0){

					while($sel_rentals_has_printers_data = $sel_rentals_has_printers_prepared->fetch()){
			?>
			<input type="hidden" name="hidmlt[]" value="<?php echo $sel_rentals_has_printers_data['mlt'];?>" />
			<tr class="lines">

				<td><?php echo $sel_rentals_has_printers_data['mlt'];?></td>
				<td><input type="text" name="total_meter[]" maxlength="6" placeholder="páginas"></td>
				<?php if ($sel_rentals_data['page_distinction']){?>
					<td><input type="text" name="color_meter[]" maxlength="6" placeholder="páginas"></td>
				<?php }?>
			</tr>
			<?php
					}
				}else {
			?>
					<tr>
						<td colspan="4">Não há registros.</td>
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