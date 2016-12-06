<?php validatePermission(array(0, 1));?>
<script>
	$(document).ready(function(){
		$("#sel_brand").change(function() {
			$("#sel_model").load("printers/selgetter_printers.php?id=" + $("#sel_brand").val());
		});
	});
</script>
<h4>Impressoras</h4>
<div class="center_box">
	<h2>Registrar impressora</h2>
	<form name="printer" method="post" action="?folder=printers/&file=ins_printers&ext=php" onsubmit="return validatePrinters();">
		<table>
			<tr>
				<td>*MLT</td>
				<td><input type="text" maxlength="4" name="mlt"></td>
			</tr>
			<tr>
				<td>*Marca</td>
				<td>
					<?php
						$sel_brands = "SELECT * FROM brands";
						$sel_brands_prepared = $db_connection->prepare($sel_brands);
						$sel_brands_prepared->execute();
					?>
					<select name="brand" id="sel_brand">
						<option value="">Selecione...</option>
						<?php
							while($sel_brands_data = $sel_brands_prepared->fetch()){
								echo "<option value='".$sel_brands_data['id']."'>".$sel_brands_data['name']."</option>";
							}
						?>
					</select>
				</td>
			</tr>
			<tr>
				<td>*Modelo</td>
				<td>
					<select name="model" id="sel_model">
						<option value="">Selecione a marca...</option>
					</select>
				</td>
			</tr>
			<tr>
				<td colspan="2"><button type="reset" class="reset_btn">Reiniciar</button><button type="submit" class="submit_btn">Enviar</button></td>
			</tr>
		</table>
	</form>
</div>
<?php
	$sel_printers = "SELECT printers.mlt, brands.name AS brand, models.name AS model, printers.status FROM printers INNER JOIN models ON printers.models_id=models.id INNER JOIN brands ON models.brands_id=brands.id";
	$sel_printers_prepared = $db_connection->prepare($sel_printers);
	$sel_printers_prepared->execute();
?>
<table class="entries">
	<tr>
		<th width="10%">MLT</th>
		<th width="20%">Marca</th>
		<th width="30%">Modelo</th>
		<th width="20%">Status</th>
		<th width="10%">Editar</th>
		<th width="10%">Excluir</th>
	</tr>
	<?php
		if($sel_printers_prepared->rowCount()>0){

			while($sel_printers_data = $sel_printers_prepared->fetch()){
				?>
				<tr>
					<td><?php echo $sel_printers_data['mlt']; ?></td>
					<td><?php echo $sel_printers_data['brand']; ?></td>
					<td><?php echo $sel_printers_data['model']; ?></td>
					<td><?php
						switch($sel_printers_data['status']){
							case 0:
								echo "Disponível";
								break;
							case 1:
								echo "Alugada";
								break;
							case 2:
								echo "Retirada";
								break;
							default:
								echo "Erro";
								break;
						}
						?></td>
					<td><a href="?folder=printers/&file=fmupd_printers&ext=php&mlt=<?php echo $sel_printers_data['mlt']?>" title="Editar Registro"><img src="../layout/images/edit.png" height="20px"></a></td>
					<td><?php echo safeDelete($sel_printers_data['mlt'], '?folder=printers/&file=del_printers&ext=php', 'impressora', $sel_printers_data['brand'] . " " . $sel_printers_data['model'])?></td>
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
