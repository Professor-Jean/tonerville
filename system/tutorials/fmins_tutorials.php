<?php validatePermission(array(0, 1));?>
<h4>Registro de Vídeo Tutorial</h4>
<div class="center_box">
	<h2>Registrar vídeo</h2>
	<form name="tutorial" method="post" action="?folder=tutorials/&file=ins_tutorials&ext=php" onsubmit="return validateTutorials();">
		<table>
			<tr>
				<td colspan="2" align="center"><a href="?folder=tutorials/&file=tutorial_tutorials&ext=php">Tutorial de upload de vídeo</a></td>
			</tr>
			<tr>
				<td>*Nome</td>
				<td><input type="text" maxlength="100" name="name"></td>
			</tr>
			<tr>
				<td>*ID da URL do vídeo</td>
				<td><input type="text" maxlength="70" name="url" placeholder="PzqIrqEHIW0"></td>
			</tr>
			<tr>
				<td>*Descrição</td>
				<td><textarea maxlength="500" name="description"></textarea></td>
			</tr>
			<tr>
				<td colspan="2"><button type="reset" class="reset_btn">Reiniciar</button><button type="submit" class="submit_btn">Enviar</button></td>
			</tr>
		</table>
	</form>
</div>
<?php
	$sel_videos = "SELECT * FROM videos";
	$sel_videos_prepared = $db_connection->prepare($sel_videos);
	$sel_videos_prepared->execute();
?>
<table class="entries">
	<tr>
		<th width="10%">ID</th>
		<th width="20%">Nome</th>
		<th width="20%">URL do vídeo</th>
		<th width="30%">Descrição</th>
		<th width="10%">Editar</th>
		<th width="10%">Excluir</th>
	</tr>
	<?php
		if($sel_videos_prepared->rowCount()>0){

			while($sel_videos_data = $sel_videos_prepared->fetch()){
				?>
				<tr>
					<td><?php echo $sel_videos_data['id']; ?></td>
					<td><?php echo $sel_videos_data['name']; ?></td>
					<td><?php echo $sel_videos_data['url']; ?></td>
					<td><?php echo $sel_videos_data['description']; ?></td>
					<td><a href="?folder=tutorials/&file=fmupd_tutorials&ext=php&id=<?php echo $sel_videos_data['id']?>" title="Editar Registro"><img src="../layout/images/edit.png" height="20px"></a></td>
					<td><?php echo safeDelete($sel_videos_data['id'], '?folder=tutorials/&file=del_tutorials&ext=php', 'tutorial', $sel_videos_data['name'])?></td>
				</tr>
				<?php
			}
		}else {
			?>
			<tr>
				<td colspan="6">Não há registros.</td>
			</tr>
			<?php
		}
	?>
</table>
