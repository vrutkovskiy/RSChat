<?php
	session_start();
	$data['logout'] = 'Logout';
	echo json_encode($data);
	session_destroy();
?>