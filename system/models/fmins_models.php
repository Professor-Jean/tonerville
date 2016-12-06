<?php validatePermission(array(0, 1));?>
<h4>Registro de Modelos</h4>
<div class="center_box">
	<h2>Registrar modelo</h2>
	<form name="model" method="post" action="?folder=models/&file=ins_models&ext=php" onsubmit="return validateModels();">
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
								$id_brands = $sel_brands_data['id'];
								$name_brands = $sel_brands_data['name'];
								echo "<option value='".$id_brands."'>".$name_brands."</option>";
							}
						?>
						</select>
				</td>
			</tr>
			<tr>
				<td>*Nome</td>
				<td><input type="text" maxlength="60" name="name"></td>
			</tr>
			<tr>
				<td colspan="2"><button type="reset" class="reset_btn">Reiniciar</button><button type="submit" class="submit_btn">Enviar</button></td>
			</tr>
		</table>
	</form>
</div>
<?php
	$sel_models = "SELECT models.id, models.brands_id, models.name, brands.name as brand FROM models INNER JOIN brands ON models.brands_id=brands.id";
	$sel_models_prepared = $db_connection->prepare($sel_models);
	$sel_models_prepared->execute();
?>
<table class="entries">
	<tr>
		<th width="10%">Marca</th>
		<th width="20%">Nome</th>
		<th width="10%">Editar</th>
		<th width="10%">Excluir</th>
	</tr>
	<?php
		if($sel_models_prepared->rowCount()>0){

			while($sel_models_data = $sel_models_prepared->fetch()){
				?>
				<tr>
					<td><?php echo $sel_models_data['brand']; ?></td>
					<td><?php echo $sel_models_data['name']; ?></td>
					<td><a href="?folder=models/&file=fmupd_models&ext=php&id=<?php echo $sel_models_data['id']?>" title="Editar Registro"><img src="../layout/images/edit.png" height="20px"></a></td>
					<td><?php echo safeDelete($sel_models_data['id'], '?folder=models/&file=del_models&ext=php', 'modelo', $sel_models_data['name'])?></td>
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
