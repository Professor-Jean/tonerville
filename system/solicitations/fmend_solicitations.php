<?php validatePermission(array(0, 1));
	$g_id = $_GET['id'];
?>
<h4>Finalizar Solicitação</h4>
<div class="center_box">
	<h2>Finalizar Solicitação</h2>
	<form name="login" method="post" action="?folder=solicitations/&file=end_solicitations&ext=php" onsubmit="return validateLogin();">
		<input type="hidden" name="hidid" value="<?php echo $g_id;?>" />
		<table>
			<tr>
				<td>Descrição</td>
				<td><input type="text" maxlength="60" name="description"></td>
			</tr>
			<tr>
				<td colspan="2"><button type="reset" class="reset_btn">Reiniciar</button><button type="submit" class="submit_btn">Enviar</button></td>
			</tr>
		</table>
	</form>
</div>

