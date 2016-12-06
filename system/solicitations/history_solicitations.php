<?php validatePermission(array(0, 1));?>
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
				<td>Nome do representante</td>
				<td><input type="text" maxlength="10" name="rep_name"></td>
			</tr>
			<tr>
				<td>Nome fantasia</td>
				<td><input type="text" maxlength="10" name="fantasy_name"></td>
			</tr>
			<tr>
				<td colspan="2"><button type="reset" class="reset_btn">Reiniciar</button><button type="submit" class="submit_btn">Enviar</button></td>
			</tr>
		</table>
	</div>
</form>
<table class="entries" style="width: 95%; max-width: 95%; font-size: 12px;">
	<head>
	<tr>
		<th width="9%">Data</th>
		<th width="4%">MLT</th>
		<th width="10%">Desc.</th>
		<th width="10%">Coment.</th>
		<th width="8%">Categoria</th>
		<th width="8%">Nome Rep.</th>
		<th width="9%">Nome Fant.</th>
		<th width="6%">Cidade</th>
		<th width="5%">Bairro</th>
		<th width="6%">Logradouro</th>
		<th width="5%">Num.</th>
		<th width="5%">Compl.</th>
		<th width="5%">Tel.</th>
		<th width="6%">Prioridade</th>
	</tr>
	</head>
	<body>
	<?php
		
		
		@$condition1 = !empty($_POST['mlt'])  ? "solicitations.printers_mlt=" .$_POST['mlt'] : "TRUE";
		@$condition2 = !empty($_POST['category']) ? "solicitations.categories_id LIKE '%".$_POST['category']."%'" : "TRUE";
		@$condition3 = !empty($_POST['rep_name']) ? "clients.rep_name LIKE '%".$_POST['rep_name']."%'" : "TRUE";
		@$condition4 = !empty($_POST['fantasy_name']) ? "clients.trade_name LIKE '%".$_POST['fantasy_name']."%'" : "TRUE";
		
		
		$sel_solicitations = "SELECT users.username, solicitations.id, solicitations.date AS date_soli, printers.mlt, categories.name AS name_cat, solicitations.description AS desc_sol, solicitations.priority, clients.rep_name, clients.trade_name, clients.city, clients.neighborhood, clients.street_comp, clients.street_num, clients.street, clients.phone, solicitations.users_id, solicitations.status, solicitations.comment FROM solicitations INNER JOIN clients ON solicitations.clients_id = clients.id INNER JOIN users ON users.id = clients.users_id INNER JOIN rentals ON rentals.clients_id = solicitations.clients_id INNER JOIN categories ON solicitations.categories_id = categories.id INNER JOIN printers ON printers.mlt = solicitations.printers_mlt WHERE solicitations.status='2' AND ".$condition1." AND ".$condition2." AND ".$condition3." AND ".$condition4." GROUP BY solicitations.id ORDER BY solicitations.date DESC";
		$sel_solicitations_prepared = $db_connection->prepare($sel_solicitations);
		$sel_solicitations_prepared->execute();
		
		while($sel_solicitations_data = $sel_solicitations_prepared->fetch()){
			?>
			<tr>
				<td><?php echo implode('/', array_reverse(explode('-', $sel_solicitations_data['date_soli'])))?></td>
				<td><?php echo $sel_solicitations_data['mlt']?></td>
				<td><?php echo $sel_solicitations_data['desc_sol']?></td>
				<td><?php echo $sel_solicitations_data['comment']?></td>
				<td><?php echo $sel_solicitations_data['name_cat']?></td>
				<td><?php echo $sel_solicitations_data['rep_name']?></td>
				<td><?php echo $sel_solicitations_data['trade_name'] ?: "Pessoa física"?></td>
				<td><?php echo $sel_solicitations_data['city']?></td>
				<td><?php echo $sel_solicitations_data['neighborhood']?></td>
				<td><?php echo $sel_solicitations_data['street']?></td>
				<td><?php echo $sel_solicitations_data['street_num']?></td>
				<td><?php echo $sel_solicitations_data['street_comp']?></td>
				<td><?php echo $sel_solicitations_data['phone']?></td>
				<td><?php echo $sel_solicitations_data['priority']?></td>
			</tr>
		<?php
		}
		if($sel_solicitations_prepared->rowcount()==0){
			echo "<td colspan='14'>Não existem solicitações finalizadas.</td>";
		}
	?>
	</body>
</table>
