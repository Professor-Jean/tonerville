<?php validatePermission(array(3));
	$g_id = $_GET['id'];
?>
<h4>Vínculo de usuário </h4>
<div class="center_box">
	<h2>Vincular usuário</h2>
	<form name="login" method="post" action="?folder=solicitations/shared/&file=ins_linkperson_shared&ext=php" onsubmit="return validateLogin();">
		<input type="hidden" name="hidid" value="<?php echo $g_id;?>" />
		<table>
			<tr>
				<td>Nome</td>
				<td><input type="text" maxlength="60" name="name"></td>
			</tr>
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