<?php validatePermission(array(3));
	$g_id = $_GET['sol_id'];
	$user = $_GET['user_id'];
?>
<h4>Finalizar Solicitação</h4>
<div class="center_box">
	<h2>Finalizar Solicitação</h2>
	<form name="login" method="post" action="?folder=solicitations/shared/&file=end_solicitation_shared&ext=php" onsubmit="return validateLogin();">
		<input type="hidden" name="hidid" value="<?php echo $g_id;?>" />
		<input type="hidden" name="hiduser" value="<?php echo $user;?>" />
		<table>
			<tr>
				<td>*Senha</td>
				<td><input type="password" maxlength="60" name="password"></td>
			</tr>
			<tr>
				<td>Descrição</td>
				<td><input type="text" maxlength="60" name="desc"></td>
			</tr>
			<tr>
				<td colspan="2"><button type="reset" class="reset_btn">Reiniciar</button><button type="submit" class="submit_btn">Enviar</button></td>
			</tr>
		</table>
	</form>
</div>
