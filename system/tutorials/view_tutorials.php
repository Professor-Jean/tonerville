<div class="tutorials">
	<h1>Videos Tutoriais</h1>
	<?php
		$sel_videos = "SELECT * FROM videos";
		$sel_videos_prepared = $db_connection->prepare($sel_videos);
		$sel_videos_prepared->execute();
		if($sel_videos_prepared->rowCount()==0){
			echo "<h2>Por enquanto não há nenhum vídeo tutorial, aguarde novidades.</h2>";
		}
		while($sel_videos_data = $sel_videos_prepared->fetch()){
			?>
			<h2><?php echo $sel_videos_data['name']; ?></h2>
			<iframe width="500" height="345" src="<?php echo $sel_videos_data['url'];?>"></iframe>
			<p><?php echo $sel_videos_data['description']; ?></p>
			<?php
		}
	?>
</div>
