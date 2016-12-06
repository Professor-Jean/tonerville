<?php validatePermission(array(0, 1));
	$p_id = $_POST['id'];
	if($p_id==""){
		$message = "Vídeo tutorial inexistente.";
	}else{
		$table = "videos";
		$condition = "MD5(id)='".$p_id."'";
		$del_videos = db_delete($table, $condition);
		
		if($del_videos){
			$title = "Sucesso";
			$message = "Vídeo tutorial removido com sucesso.";
		}else{
			$title = "Erro";
			$message = "Erro na remoção de vídeo tutorial.";
		}
	}
	?>
<div class="center_box">
	<h1><?php echo $title; ?></h1>
	<?php echo $message; ?>
	<br/><a href="?folder=tutorials/&file=fmins_tutorials&ext=php"><img height="15" src="../layout/images/back.png"> Voltar</a>
</div>
