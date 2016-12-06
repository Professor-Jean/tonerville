	<?php validatePermission(array(0, 1));
	$g_id = $_GET['id'];

	$sel_categories = "SELECT * FROM categories WHERE id='".$g_id."'";
	$sel_categories_prepared = $db_connection->prepare($sel_categories);
	$sel_categories_prepared->execute();
	$sel_categories_data = $sel_categories_prepared->fetch();
?>
<h4>Categoria de Solicitações de Serviço</h4>
<div class="center_box">
	<h2>Registrar de categoria</h2>
	<form name="categories" method="post" action="?folder=categories/&file=upd_categories&ext=php" onsubmit="return validateCategories();">
		<input type="hidden" name="hidid" value="<?php echo $sel_categories_data['id'];?>">
		<table>
			<tr>
				<td>*Nome de categoria</td>
				<td><input type="text" maxlength="45" name="category" value="<?php echo htmlspecialchars($sel_categories_data['name']);?>"></td>
			</tr>
			<tr>
				<td>*Prioridade</td>
				<td><input type="text" maxlength="1" name="priority" value="<?php echo htmlspecialchars($sel_categories_data['priority']);?>"></td>
			</tr>
			<tr>
				<td colspan="2"><button type="reset" class="reset_btn">Reiniciar</button><button type="submit" class="submit_btn">Enviar</button></td>
			</tr>
		</table>
	</form>
</div>