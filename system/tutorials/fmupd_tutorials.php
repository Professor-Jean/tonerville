<?php validatePermission(array(0, 1));
	
	$g_id = $_GET['id'];
	$sel_videos = "SELECT * FROM videos WHERE id='".$g_id."'";
	$sel_videos_prepared = $db_connection->prepare($sel_videos);
	$sel_videos_prepared->execute();
	$sel_videos_data = $sel_videos_prepared->fetch();
	
?>
<h4>Registro de Vídeo Tutorial</h4>
<div class="center_box">
	<h2>Alterar vídeo</h2>
	<form name="tutorial" method="post" action="?folder=tutorials/&file=upd_tutorials&ext=php" onsubmit="return validateTutorials();">
		<input type="hidden" name="hidid" value="<?php echo $sel_videos_data['id'];?>" />
		<table>
			<tr>
				<td>Nome</td>
				<td><input type="text" maxlength="100" name="name" value="<?php echo $sel_videos_data['name'];?>"></td>
			</tr>
			<tr>
				<td>ID da URL do vídeo</td>
				<td><input type="text" maxlength="70" name="url" value="<?php echo substr($sel_videos_data['url'], 30);?>"></td>
			</tr>
			<tr>
				<td>Descrição</td>
				<td><textarea maxlength="500" name="description"><?php echo $sel_videos_data['description'];?></textarea></td>
			</tr>
			<tr>
				<td colspan="2"><button type="reset" class="reset_btn">Reiniciar</button><button type="submit" class="submit_btn">Enviar</button></td>
			</tr>
		</table>
	</form>
</div>