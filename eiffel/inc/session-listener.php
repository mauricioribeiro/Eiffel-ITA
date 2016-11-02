<?php 
	
	include_once '../lib/config.php';
	include_once '../lib/session.php';

	ini_set('display_errors',0);

	$oSessionListener = new Session();

	if(isset($_GET['key']) && isset($_GET['val'])){
		$oSessionListener->refresh($_GET['key'],$_GET['val']);
	}

	if(isset($_GET['flag']) && $_GET['flag'] == 'RESET'){
		$oSessionListener->reset();
		header('Location: ../');
	}

 ?>