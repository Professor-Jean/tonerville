<?php validatePermission(array(0, 1));
	$g_id = $_GET['id'];
	$sel_models = "SELECT models.id, models.brands_id, models.name, brands.name as brand FROM models INNER JOIN brands ON models.brands_id=brands.id WHERE models.id='".$g_id."'";
	$sel_models_prepared = $db_connection->prepare($sel_models);
	$sel_models_prepared->execute();
	$sel_models_data = $sel_models_prepared->fetch();
?>
<h4>Registro de Modelos</h4>
<div class="center_box">
	<h2>Alterar modelo</h2>
	<form name="model" method="post" action="?folder=models/&file=upd_models&ext=php" onsubmit="return validateModels();">
		<input type="hidden" name="hidid" value="<?php echo $sel_models_data['id'];?>" />
		<table>
			<tr>
				<td>*Marca</td>
				<td><select name="brand" id="sel_brand">
						<option value="">Selecione...</option>
						<?php
							$sel_brands = "SELECT * FROM brands ORDER BY name ASC";
							$sel_brands_prepared = $db_connection->prepare($sel_brands);
							$sel_brands_prepared->execute();
							while($sel_brands_data = $sel_brands_prepared->fetch()){
								$selected = "";
								if($sel_brands_data['id']==$sel_models_data['brands_id']){
									$selected = "selected";
								}
								?>
								<option value="<?php echo $sel_brands_data['id']; ?>" <?php echo $selected; ?>><?php echo $sel_brands_data['name'] ?></option>
						<?php
							}
						?>
					</select>
				</td>
			</tr>
			<tr>
				<td>*Nome</td>
				<td><input type="text" maxlength="60" name="name" value="<?php echo $sel_models_data['name'];?>"></td>
			</tr>
			<tr>
				<td colspan="2"><button type="reset" class="reset_btn">Reiniciar</button><button type="submit" class="submit_btn">Enviar</button></td>
			</tr>
		</table>
	</form>
</div>