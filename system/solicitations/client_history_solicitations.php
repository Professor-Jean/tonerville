<?php validatePermission(array(2));?>
<h4>Histórico de solicitações de serviço</h4>
<form name="filter" id="filter" action="#" method="post">
	<h1 onclick="$('#filter div').slideToggle()">▼ Filtro</h1>
	<div>
		<table id="filtro">
			<tr>
				<td>MLT</td>
				<td><input type="text" name="mlt" maxlength="4"></td>
			</tr>
			<tr>
				<td>Categoria</td>
				<td><select name="category">
						<option value="">Selecione...</option>
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
	</div>
</form>
<table class="entries">
	<tr>
		<th width="9%">Data</th>
		<th width="4%">MLT</th>
		<th width="10%">Desc.</th>
		<th width="8%">Categoria</th>
		<th width="8%">Comentário</th>
	</tr>
	<?php
		
		
		@$condition1 = !empty($_POST['mlt'])  ? "solicitations.printers_mlt=" .$_POST['mlt'] : "TRUE";
		@$condition2 = !empty($_POST['category']) ? "solicitations.categories_id LIKE '%".$_POST['category']."%'" : "TRUE";
		
		$sel_solicitations = "SELECT solicitations.comment, users.username, solicitations.id, solicitations.date AS date_soli, printers.mlt, categories.name AS name_cat, solicitations.description AS desc_sol, solicitations.priority, clients.rep_name, clients.trade_name, clients.city, clients.neighborhood, clients.street_comp, clients.street_num, clients.street, clients.phone, solicitations.users_id, solicitations.status FROM solicitations INNER JOIN clients ON solicitations.clients_id = clients.id INNER JOIN users ON users.id = clients.users_id INNER JOIN rentals ON rentals.clients_id = solicitations.clients_id INNER JOIN categories ON solicitations.categories_id = categories.id INNER JOIN printers ON printers.mlt = solicitations.printers_mlt WHERE solicitations.status='2' AND clients.users_id='".$_SESSION['user_id']."' AND ".$condition1." AND ".$condition2." GROUP BY solicitations.id";
		$sel_solicitations_prepared = $db_connection->prepare($sel_solicitations);
		$sel_solicitations_prepared->execute();
		
		while($sel_solicitations_data = $sel_solicitations_prepared->fetch()){
			?>
			<tr>
				<td><?php echo implode('/', array_reverse(explode('-', $sel_solicitations_data['date_soli'])))?></td>
				<td><?php echo $sel_solicitations_data['mlt']?></td>
				<td><?php echo $sel_solicitations_data['desc_sol']?></td>
				<td><?php echo $sel_solicitations_data['name_cat']?></td>
				<td><?php echo $sel_solicitations_data['comment']?></td>
			</tr>
		<?php
		}
		if($sel_solicitations_prepared->rowcount()==0){
			echo "<td colspan='5'>Não existem solicitações finalizadas.</td>";
		}
	?>
</table>
