<?php validatePermission(array(3));
	$g_user_id = $_GET['user_id'];
	$g_sol_id = $_GET['sol_id'];
?>
<h4>Desvínculo de usuário </h4>
<div class="center_box">
	<h2>Desvincular usuário</h2>
	<form name="login" method="post" action="?folder=solicitations/shared/&file=ins_unlinkperson_shared&ext=php" onsubmit="return validateLogin();">
		<input type="hidden" name="user_id" value="<?php echo $g_user_id;?>" />
		<input type="hidden" name="sol_id" value="<?php echo $g_sol_id;?>" />
		<table>
			<tr>
				<td>Senha</td>
				<td><input type="password" maxlength="60" name="password"></td>
			</tr>
			<tr>
				<td colspan="2"><button type="reset" class="reset_btn">Reiniciar</button><button type="submit" class="submit_btn">Enviar</button></td>
			</tr>
</table>
</form>
</div>