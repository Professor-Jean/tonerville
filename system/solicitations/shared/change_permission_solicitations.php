
<?php
	validatePermission(array(0, 1));

	$_SESSION['permission'] = 3;

	header("Location: ?folder=solicitations/shared/&file=shared_solicitations&ext=php");


?>
