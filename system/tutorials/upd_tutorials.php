<?php	validatePermission(array(0, 1));
	
	$p_id = $_POST['hidid'];
	$p_name = trim($_POST['name']);
	$p_url = trim($_POST['url']);
	$p_description = trim($_POST['description']);

	if(!validateText(1,100,$p_name)){
		$title = "Erro";
		$message = "O campo \"Nome\" foi preenchido incorretamente.";
	}else if(!validateText(1,70,$p_url)){
		$title = "Erro";
		$message = "O campo \"URL do vídeo\" foi preenchido incorretamente.";
	}else if(!validateText(1,500,$p_description)){
		$title = "Erro";
		$message = "O campo \"Descrição\" foi preenchido incorretamente.";
	}else{
		$sel_videos = "SELECT * FROM videos WHERE (name='".$p_name."' or url='"."https://www.youtube.com/embed/".$p_url."') and id<>'".$p_id."'";
		$sel_videos_prepared = $db_connection->prepare($sel_videos);
		$sel_videos_prepared->execute();
		if($sel_videos_prepared->rowCount()==0){
			$table = "videos";
			$data = array(
				'name' => $p_name,
				'url' => "https://www.youtube.com/embed/".$p_url,
				'description' => $p_description
			);
			$condition = "id='".$p_id."'";
			$upd_videos = db_update($table, $data, $condition);
			if($upd_videos){
				$title = "Sucesso";
				$message = "Vídeo tutorial alterado com sucesso.";
			}else{
				$title = "Erro";
				$message = "Erro na alteração de vídeo tutorial.";
			}
		}else{
			$title = "Erro";
			$message = "Esse registro de vídeo tutorial já existe.";
		}
	}
?>
<div class="center_box">
	<h1><?php echo $title; ?></h1>
	<?php echo $message; ?>
	<?php
		if($title=='Sucesso'){
			$back = "?folder=tutorials/&file=fmins_tutorials&ext=php";
		}else{
			$back = "?folder=tutorials/&file=fmupd_tutorials&ext=php&id=".$p_id;
		}
	?>
	<br/><a href="<?php echo $back?>"><img height="15" src="../layout/images/back.png"> Voltar</a>
</div>
