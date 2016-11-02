<?php 
	require_once 'lib/config.php';

	header('Location: verificacao');

	$EIFFEL = new Config();
	$EIFFEL->setConfig('page','Início');

	include 'header.php';

	# $msg = array('info','Bem vindo ao sistema <b>Eiffel</b>.');

?>
	
	<div id="custom-index" class="col-lg-12">
		<?php $oUtil->printMsg($msg) ?>
		<div class="row mt">
			<p></p>
		</div>
	</div>

<?php include 'footer.php' ?>