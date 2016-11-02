<?php 
	require_once '../lib/config.php';
	require_once '../lib/constant.php';
	require_once '../lib/csv.php';
	require_once '../lib/python.php';

	$EIFFEL = new Config();
	$EIFFEL->setConfig('page','Relatório');

	include '../header.php';

	# $msg = array('info','Bem vindo ao sistema <b>Eiffel</b>.');
	$oConstant = new constant();
	$oPython = new python();
?>
	
	<div id="custom-index" class="col-lg-12">
		<?php $oUtil->printMsg($msg) ?>
		<div class="row mt">
				
			<h3>Relatório</h3>
			<hr>

			<div class="col-lg-12">
				<?php #var_dump($_SESSION) ?>
				<form class="form-panel dynamic-form" method="post" action="relatorio/download.php" target="_blank">
					
					<?php include_once '../inc/relatorio.php' ?>
					
					<div class="text-right">
						<button class="btn btn-success">Gerar PDF</button>
					</div>
					
				</form>

		    </div>
		</div>
	</div>

<?php include '../footer.php' ?>