<?php	validatePermission(array(0, 1)); ?>

<h4>Categoria de Solicitações de Serviço</h4>
<div class="center_box">
	<h2>Registrar categoria</h2>
	<form name="categories" method="post" action="?folder=categories/&file=ins_categories&ext=php " onsubmit="return validateCategories();">
		<table>
			<tr>
				<td>*Nome da categoria:</td>
				<td><input type="text" maxlength="45" name="category"></td>
			</tr>
			<tr>
				<td>*Prioridade:</td>
				<td><input type="text" maxlength="1" name="priority"></td>
			</tr>
			<tr>
				<td colspan="2"><button type="reset" class="reset_btn">Reiniciar</button><button type="submit" class="submit_btn">Enviar</button></td>
			</tr>
		</table>
	</form>
</div>

<table class="entries">
	<tr>
		<th width="10%">ID</th>
		<th width="50%">Nome da categoria</th>
		<th width="10%">Prioridade</th>
		<th width="15%">Editar</th>
		<th width="15%">Excluir</th>
	</tr>
	<?php
		$sel_categories = "SELECT * FROM categories";
		$sel_categories_prepared = $db_connection->prepare($sel_categories);
		$sel_categories_prepared->execute();
		while($sel_categories_data = $sel_categories_prepared->fetch()){
			?>
			<tr>
				<td><?php echo $sel_categories_data['id']?></td>
				<td><?php echo $sel_categories_data['name']?></td>
				<td><?php echo $sel_categories_data['priority']?></td>
				<td><a href="?folder=categories/&file=fmupd_categories&ext=php&id=<?php echo $sel_categories_data['id'];?>"><img src="../layout/images/edit.png" height="20px"></a></td>
				<td><?php echo safeDelete($sel_categories_data['id'], '?folder=categories/&file=del_categories&ext=php', 'categoria', $sel_categories_data['name'])?></td>
			</tr>
		<?php }
			if($sel_categories_prepared->rowCount()==0){
				?>
				<tr>
					<td colspan="5">Não existe nenhuma categoria de solicitação de serviço registrada</td>
				</tr>
				<?php
					}
				?>

</table>


