	<?php validatePermission(array(2));?>
<h4>Solicitações de serviço</h4>
<div class="center_box">
	<h2>Registrar solicitação</h2>
	<form name="fmins_solicitations" method="post" action="?folder=solicitations/&file=ins_solicitations&ext=php">
		<table>
			<tr>
				<td>Descrição da solicitação</td>
				<td><textarea maxlength="250" name="description"></textarea></td>
			</tr>
			<tr>
				<td>*Impressoras</td>
				<td><select name="printers">
				<option value="">Selecione uma impressora</option>
						<?php
							$sel_printers = "SELECT printers.mlt, rentals.status FROM printers INNER JOIN rentals_has_printers ON printers.mlt = rentals_has_printers.printers_mlt INNER JOIN rentals ON rentals.id = rentals_has_printers.rentals_id INNER JOIN clients ON clients.id = rentals.clients_id INNER JOIN users ON clients.users_id = users.id WHERE users.id ='".$_SESSION['user_id']."' AND rentals.status < 2 ORDER BY mlt";
							$sel_printers_prepared = $db_connection->prepare($sel_printers);
							$sel_printers_prepared->execute();

							if($sel_printers_data['status']>1){
								echo "<option value=''>Você não possui um aluguel ativo.</option>";
							}else{
								while($sel_printers_data = $sel_printers_prepared->fetch()){
									$printers = $sel_printers_data['mlt'];
									echo "<option value='".$printers."'>".$printers."</option>";

								}
							}
							if($sel_printers_prepared->rowcount()==0){
								echo "<option value=''>Não existem impressoras registradas em seu aluguel.</option>";
							}
						?>
				</td>
			</tr>
			<tr>
				<td>*Categoria</td>
				<td><select name="category">
					<option value="">Selecione uma categoria</option>
						<?php
							$sel_categories = "SELECT name, id FROM categories";
							$sel_categories_prepared = $db_connection->prepare($sel_categories);
							$sel_categories_prepared->execute();

							while($sel_categories_data = $sel_categories_prepared->fetch()){
								$categories = $sel_categories_data['name'];
								$categories_id = $sel_categories_data['id'];
								echo "<option value='".$categories_id."'>".$categories."</option>";

							}
							if($sel_categories_prepared->rowcount()==0){
								echo "<option value=''>Não existem categorias registradas.</option>";
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
<table class="entries">
	<tr>
		<th width="25%">Data</th>
		<th width="25%">MLT da impressora</th>
		<th width="25%">Categoria</th>
		<th width="25%">Descrição</th>
	</tr>
	<?php
		$sel_solicitations = "SELECT solicitations.date, printers.mlt, categories.name, solicitations.description FROM solicitations INNER JOIN clients ON solicitations.clients_id = clients.id INNER JOIN users ON users.id = clients.users_id INNER JOIN rentals ON rentals.clients_id = solicitations.clients_id INNER JOIN categories ON solicitations.categories_id = categories.id INNER JOIN printers ON printers.mlt = solicitations.printers_mlt WHERE users.id = '".$_SESSION['user_id']."' AND solicitations.status < 2 GROUP BY solicitations.id";
		$sel_solicitations_prepared = $db_connection->prepare($sel_solicitations);
		$sel_solicitations_prepared->execute();
		while($sel_solicitations_data = $sel_solicitations_prepared->fetch()){
			?>
			<tr>
				<td><?php echo implode('/', array_reverse(explode('-', $sel_solicitations_data['date'])))?></td>
				<td><?php echo $sel_solicitations_data['mlt']?></td>
				<td><?php echo $sel_solicitations_data['name']?></td>
				<td><?php echo $sel_solicitations_data['description']?></td>
			</tr>
		<?php }

		if($sel_solicitations_prepared->rowcount()==0){
			?>
			<tr>
				<td colspan="4">Você não possui nenhuma solicitação de serviço ativa no momento.</td>
			</tr>
	<?php
		}
	?>
</table>
