<?php validatePermission(array(0));
	$g_id = $_GET['id'];
	$sel_clients = "SELECT clients.id, clients.users_id, clients.trade_name, clients.rep_name, clients.phone, clients.email, clients.city, clients.neighborhood, clients.street, clients.street_num, clients.street_comp, clients.cep, clients.cnpj, clients.ie, users.username FROM clients INNER JOIN users ON clients.users_id=users.id WHERE clients.id='".$g_id."'";
	$sel_clients_prepared = $db_connection->prepare($sel_clients);
	$sel_clients_prepared->execute();
	$sel_clients_data = $sel_clients_prepared->fetch();
?>
<h4>Consulta detalhada de cliente</h4>
<div class="rental_wrapper" style="border: none">
	<table>
		<tr>
			<td><b>Nome fantasia:</b></td>
			<td><?php echo $sel_clients_data['trade_name'] ?: "Pessoa física";?></td>
			<td><b>Nome representante:</b></td>
			<td><?php echo $sel_clients_data['rep_name'];?></td>
		</tr>
		<tr>
			<td><b>Telefone:</b></td>
			<td class="phone_mask optional_mask"><?php echo $sel_clients_data['phone'] ?: "-";?></td>
			<td><b>E-mail:</b></td>
			<td><?php echo $sel_clients_data['email'] ?: "-";?></td>
		</tr>
		<tr>
			<td><b>Cidade:</b></td>
			<td><?php echo $sel_clients_data['city'];?></td>
			<td><b>Bairro:</b></td>
			<td><?php echo $sel_clients_data['neighborhood'];?></td>
		</tr>
		<tr>
			<td><b>Logradouro:</b></td>
			<td><?php echo $sel_clients_data['street'];?></td>
			<td><b>Número:</b></td>
			<td><?php echo $sel_clients_data['street_num'];?></td>
		</tr>
		<tr>
			<td><b>Complemento:</b></td>
			<td><?php echo $sel_clients_data['street_comp'] ?: "-";?></td>
			<td><b>CEP:</b></td>
			<td class="cep_mask"><?php echo $sel_clients_data['cep'];?></td>
		</tr>
		<tr>
			<td><b>CNPJ:</b></td>
			<td class="cnpj_mask optional_mask"><?php echo $sel_clients_data['cnpj'] ?: "-";?></td>
			<td><b>Inscrição estadual:</b></td>
			<td><?php echo $sel_clients_data['ie'] ?: "-";?></td>
		</tr>
		<tr>
			<td><b>Usuário:</b></td>
			<td><?php echo $sel_clients_data['username'];?></td>
		</tr>
	</table>
</div>