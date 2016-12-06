<?php validatePermission(array(0, 1)); ?>
<h4>Registro de Marcas</h4>
<div class="center_box">
	<h2>Registrar marca</h2>
	<form name="brand" method="post" action="?folder=brands/&file=ins_brands&ext=php" onsubmit="return validateBrands();">
		<table>
			<tr>
				<td>*Nome</td>
				<td><input type="text" maxlength="20" name="name"></td>
			</tr>
			<tr>
				<td colspan="2"><button type="reset" class="reset_btn">Reiniciar</button><button type="submit" class="submit_btn">Enviar</button></td>
			</tr>
		</table>
	</form>
</div>
<?php
	$sel_brands = "SELECT * FROM brands";
	$sel_brands_prepared = $db_connection->prepare($sel_brands);
	$sel_brands_prepared->execute();
?>
<table class="entries">
	<tr>
		<th width="10%">ID</th>
		<th width="20%">Nome</th>
		<th width="10%">Editar</th>
		<th width="10%">Excluir</th>
	</tr>
	<?php
		if($sel_brands_prepared->rowCount()>0){

			while($sel_brands_data = $sel_brands_prepared->fetch()){
				?>
				<tr>
					<td><?php echo $sel_brands_data['id']; ?></td>
					<td><?php echo $sel_brands_data['name']; ?></td>
					<td><a href="?folder=brands/&file=fmupd_brands&ext=php&id=<?php echo $sel_brands_data['id']?>" title="Editar Registro"><img src="../layout/images/edit.png" height="20px"></a></td>
					<td><?php echo safeDelete($sel_brands_data['id'], '?folder=brands/&file=del_brands&ext=php', 'marca', $sel_brands_data['name'])?></td>
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