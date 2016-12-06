<?php validatePermission(array(0, 1));
	$g_mlt = $_GET['mlt'];
	$sel_printers = "SELECT brands.id AS brand, models.id AS model FROM printers INNER JOIN models ON printers.models_id=models.id INNER JOIN brands ON models.brands_id=brands.id WHERE printers.mlt=".$g_mlt;
	$sel_printers_prepared = $db_connection->prepare($sel_printers);
	$sel_printers_prepared->execute();
	$sel_printers_data = $sel_printers_prepared->fetch();
?>
<script>
	$(document).ready(function(){
		$("#sel_brand").change(function() {
			$("#sel_model").load("printers/selgetter_printers.php?id=" + $("#sel_brand").val());
		});
	});
</script>
<h4>Impressoras</h4>
<div class="center_box">
	<h2>Alterar impressora</h2>
	<form name="printer" method="post" action="?folder=printers/&file=upd_printers&ext=php" onsubmit="return validatePrinters();">
		<table>
			<tr>
				<td>*MLT</td>
				<td><input type="text" readonly maxlength="4" name="mlt" value="<?php echo $g_mlt?>"></td>
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
								// seta a option como selecionada se ela for da marca que será alterada
								echo $sel_printers_data['brand'] == $sel_brands_data['id'] ? "<option selected " : "<option ";
								echo "value='".$sel_brands_data['id']."'>".$sel_brands_data['name']."</option>";
							}
						?>
					</select>
				</td>
			</tr>
			<tr>
				<td>*Modelo</td>
				<td>
					<?php
						$sel_models = "SELECT * FROM models where brands_id=".$sel_printers_data['brand'];
						$sel_models_prepared = $db_connection->prepare($sel_models);
						$sel_models_prepared->execute();
					?>
					<select name="model" id="sel_model">
						<option value="">Selecione...</option>
						<?php
							while($sel_models_data = $sel_models_prepared->fetch()){
								// seta a option como selecionada se ela for do modelo que será alterado
								echo $sel_printers_data['model'] == $sel_models_data['id'] ? "<option selected " : "<option ";
								echo "value='".$sel_models_data['id']."'>".$sel_models_data['name']."</option>";
							}
						?>
				</td>
			</tr>
			<tr>
				<td colspan="2"><button type="reset" class="reset_btn">Reiniciar</button><button type="submit" class="submit_btn">Enviar</button></td>
			</tr>
		</table>
	</form>
</div>
