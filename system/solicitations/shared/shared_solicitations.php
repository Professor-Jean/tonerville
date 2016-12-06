<?php validatePermission(array(3));?>
<span class="imprimir">
	<h4>Área Compartilhada</h4>
</span>
<form action="../addons/buildpdf_php.php" id="gerarpdf" method="POST" onSubmit="return catchContent()">
	<input type="hidden" name="dadospdf" id="dadospdf" value="">
	<button type="submit" class="b_imprimir print-button"><span class="print-icon"></span></button>
</form>
<form name="filter" id="filter" action="#" method="post">
	<h1 onclick="$('#filter div').slideToggle()">▼ Filtro</h1>
	<div>
		<table id="filtro">
			<tr>
				<td>Data</td>
				<td><input readonly class="datepicker" type="text" name="date" placeholder="dd/mm/aaaa"></td>
			</tr>
			<tr>
				<td>Status</td>
				<td><select name="status">
						<option value="">Selecione...</option>
						<option value="0">Pendente</option>
						<option value="1">Em andamento</option>
				</td>
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
<span class="imprimir">
<table class="entries" style="width: 95%; max-width: 95%; font-size: 12px;">
	<tr>
		<th width="6%">Prioridade</th>
		<th width="9%">Data</th>
		<th width="4%">MLT</th>
		<th width="10%">Descrição</th>
		<th width="8%">Categoria</th>
		<th width="8%">Nome Representante</th>
		<th width="9%">Nome Fantasia</th>
		<th width="6%">Cidade</th>
		<th width="5%">Bairro</th>
		<th width="6%">Logradouro</th>
		<th width="5%">Num.</th>
		<th width="5%">Compl.</th>
		<th width="5%">Tel.</th>
		<th width="8%">Usuário vinculado</th>
		<th width="3%">Vinc.</th>
		<th width="3%">Fin.</th>
	</tr>
	<?php
		
		
		@$condition1 = !empty($_POST['date'])  ? "solicitations.date LIKE '%" .$_POST['date'] ."%'" : "TRUE";
		@$condition2 = !empty($_POST['status']) ? "solicitations.status LIKE '%".$_POST['status']."%'" : "TRUE";
		@$condition3 = !empty($_POST['category']) ? "solicitations.categories_id LIKE '%".$_POST['category']."%'" : "TRUE";
		@$condition4 = !empty($_POST['rep_name']) ? "clients.rep_name LIKE '%".$_POST['rep_name']."%'" : "TRUE";
		@$condition5 = !empty($_POST['fantasy_name']) ? "clients.trade_name LIKE '%".$_POST['fantasy_name']."%'" : "TRUE";


		$sel_solicitations = "SELECT users.username, solicitations.id, solicitations.date AS date_soli, printers.mlt, categories.name AS name_cat, solicitations.description AS desc_sol, solicitations.priority, clients.rep_name, clients.trade_name, clients.city, clients.neighborhood, clients.street_comp, clients.street_num, clients.street, clients.phone, solicitations.users_id, solicitations.status FROM solicitations INNER JOIN clients ON solicitations.clients_id = clients.id INNER JOIN users ON users.id = clients.users_id INNER JOIN rentals ON rentals.clients_id = solicitations.clients_id INNER JOIN categories ON solicitations.categories_id = categories.id INNER JOIN printers ON printers.mlt = solicitations.printers_mlt WHERE solicitations.status < '2' AND ".$condition1." AND ".$condition2." AND ".$condition3." AND ".$condition4." AND ".$condition5."  GROUP BY solicitations.id ORDER BY solicitations.date DESC, solicitations.priority DESC";
		$sel_solicitations_prepared = $db_connection->prepare($sel_solicitations);
		$sel_solicitations_prepared->execute();
		while($sel_solicitations_data = $sel_solicitations_prepared->fetch()){
			?>
			<tr>
				<td><?php echo $sel_solicitations_data['priority']?><a href="?folder=solicitations/&file=pluspriority_solicitations&ext=php&id=<?php echo $sel_solicitations_data['id'];?>"><img style="height: 15px;" title="Arrow Up by Riley Shaw from the Noun Project" src="../layout/images/up.png" height="30px"></a></br><a href="?folder=solicitations/&file=downpriority_solicitations&ext=php&id=<?php echo $sel_solicitations_data['id'];?>"><img style="height: 15px; margin-left: 6px;;" title="Arrow Down by Riley Shaw from the Noun Project" src="../layout/images/down.png" height="30px"></a></td>
				<td><?php echo implode('/', array_reverse(explode('-', $sel_solicitations_data['date_soli'])))?></td>
				<td><?php echo $sel_solicitations_data['mlt']?></td>
				<td><?php echo $sel_solicitations_data['desc_sol']?></td>
				<td><?php echo $sel_solicitations_data['name_cat']?></td>
				<td><?php echo $sel_solicitations_data['rep_name']?></td>
				<td><?php echo $sel_solicitations_data['trade_name'] ?: "Pessoa física"?></td>
				<td><?php echo $sel_solicitations_data['city']?></td>
				<td><?php echo $sel_solicitations_data['neighborhood']?></td>
				<td><?php echo $sel_solicitations_data['street']?></td>
				<td><?php echo $sel_solicitations_data['street_num']?></td>
				<td><?php echo $sel_solicitations_data['street_comp']?></td>
				<td><?php echo $sel_solicitations_data['phone']?></td>
				<?php
					if($sel_solicitations_data['users_id']!="") {
						$employees_name = "SELECT username FROM users WHERE id = '" . $sel_solicitations_data['users_id'] . "'";
						$employees_name_prepared = $db_connection->prepare($employees_name);
						$employees_name_prepared->execute();
						$employees_name_data = $employees_name_prepared->fetch();
						?>
						<td><?php echo $employees_name_data['username'] ?></td>
						<?php
					}else{
						?>
						<td>Nenhum</td>
					<?php }
					if($sel_solicitations_data['status'] == 0){

						?>
						<td><a href="?folder=solicitations/shared/&file=linkperson_shared&ext=php&id=<?php echo $sel_solicitations_data['id'];?>"><img src="../layout/images/link_person.png" height="30px"></a></td>
						<td><img src="../layout/images/check.png" height="30px" style="opacity: 0.5"></td>
						<?php
					}else{
						?>
						<td><a href="?folder=solicitations/shared/&file=unlinkperson_shared&ext=php&user_id=<?php echo $sel_solicitations_data['users_id'];?>&sol_id=<?php echo $sel_solicitations_data['id'];?>"><img src="../layout/images/unlink_person.png" height="20px"></a></td>
						<td><a href="?folder=solicitations/shared/&file=fmend_solicitation_shared&ext=php&user_id=<?php echo $sel_solicitations_data['users_id'];?>&sol_id=<?php echo $sel_solicitations_data['id'];?>"><img src="../layout/images/check.png" height="30px"></a></td>
						<?php
					}
				?>
			</tr>
		<?php }
		if($sel_solicitations_prepared->rowcount()==0){
			echo "<td colspan='16'>Não existem solicitações pendentes.</td>";
		}
	?>
</table>
	</span>




