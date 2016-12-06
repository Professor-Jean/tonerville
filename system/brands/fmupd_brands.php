<?php validatePermission(array(0, 1));

	$g_id = $_GET['id'];
	$sel_brands = "SELECT * FROM brands WHERE id='".$g_id."'";
	$sel_brands_prepared = $db_connection->prepare($sel_brands);
	$sel_brands_prepared->execute();
	$sel_brands_data = $sel_brands_prepared->fetch();

?>
<h4>Registro de Marcas</h4>
<div class="center_box">
	<h2>Alterar marca</h2>
	<form name="brand" method="post" action="?folder=brands/&file=upd_brands&ext=php" onsubmit="return validateBrands();">
		<input type="hidden" name="hidid" value="<?php echo $sel_brands_data['id'];?>" />
		<table>
			<tr>
				<td>*Nome</td>
				<td><input type="text" maxlength="20" name="name" value="<?php echo $sel_brands_data['name'];?>"></td>
			</tr>
			<tr>
				<td colspan="2"><button type="reset" class="reset_btn">Reiniciar</button><button type="submit" class="submit_btn">Enviar</button></td>
			</tr>
		</table>
	</form>
</div>
