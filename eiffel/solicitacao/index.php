<?php 
	require_once '../lib/config.php';
	require_once '../lib/constant.php';

	$EIFFEL = new Config();
	$EIFFEL->setConfig('page','Solicitação');

	include '../header.php';

	# $msg = array('info','Bem vindo ao sistema <b>Eiffel</b>.');
	$oConstant = new constant();
	
?>
	
	<div id="custom-index" class="col-lg-12">
		<?php $oUtil->printMsg($msg) ?>
		<div class="row mt">
				
			<h3>Solicitação</h3>
			<hr>

			<div class="col-lg-12">

				<?php $check = $oSession->isTrue('Check-tracao') ?>
		      	<div class="form-panel dynamic-form">
		        	<div class="dynamic-form-header">
		        		<img src="assets/img/icons/tracao.png"> <h3>Tração</h3>
		        		<input name="Check-tracao" class="toggle-form" type="checkbox" value="1" <?php if($check) echo 'checked' ?>>
		        	</div>
		        	<div class="form-horizontal style-form dynamic-form-content" <?php if(!$check) echo 'style="display: none"' ?>>
		        		<hr>
						<div class="form-group">
							<label class="col-sm-2 control-label">Nsd [kN]</label>
							<div class="col-sm-10">
								<input name="Nsd-tracao" type="number" class="form-control small-input input-double" value="<?php if($oSession->has('Nsd-tracao')) echo $oSession->get('Nsd-tracao') ?>">
							</div>
						</div>
						
					</div>
		      	</div>
		        
		        <?php $check = $oSession->isTrue('Check-compressao') ?>
		        <div class="form-panel dynamic-form">
		        	<div class="dynamic-form-header">
		        		<img src="assets/img/icons/compressao.png"> <h3>Compressão</h3>
		        		<input name="Check-compressao" class="toggle-form" type="checkbox" value="1" <?php if($check) echo 'checked' ?>>
		        	</div>
		        	<div class="form-horizontal style-form dynamic-form-content" <?php if(!$check) echo 'style="display: none"' ?>>
		        		<hr>
						<div class="form-group">
							<label class="col-sm-2 control-label">Nsd [kN]</label>
							<div class="col-sm-10">
								<input name="Nsd-compressao" type="number" class="form-control small-input input-double" value="<?php if($oSession->has('Nsd-compressao')) echo $oSession->get('Nsd-compressao') ?>">
							</div>
						</div>
						
					</div>
		      	</div>

		      	<?php $check = $oSession->isTrue('Check-Fletor_x') ?>
		      	<div class="form-panel dynamic-form">
		        	<div class="dynamic-form-header">
		        		<img src="assets/img/icons/Fletor_x.png"> <h3>Fletor x</h3>
		        		<input name="Check-Fletor_x" class="toggle-form" type="checkbox" value="1" <?php if($check) echo 'checked' ?>>
		        	</div>
		        	<div class="form-horizontal style-form dynamic-form-content" <?php if(!$check) echo 'style="display: none"' ?>>
		        		<hr>
						<div class="form-group">
							<label class="col-sm-2 control-label">Msd [kN.cm]</label>
							<div class="col-sm-10">
								<input name="Msd-Fletor_x" type="number" class="form-control small-input input-double" value="<?php if($oSession->has('Msd-Fletor_x')) echo $oSession->get('Msd-Fletor_x') ?>">
							</div>
						</div>
						
					</div>
		      	</div>

		      	<?php $check = $oSession->isTrue('Check-Fletor_y') ?>
		      	<div class="form-panel dynamic-form">
		        	<div class="dynamic-form-header">
		        		<img src="assets/img/icons/Fletor_y.png"> <h3>Fletor y</h3>
		        		<input name="Check-Fletor_y" class="toggle-form" type="checkbox" value="1" <?php if($check) echo 'checked' ?>>
		        	</div>
		        	<div class="form-horizontal style-form dynamic-form-content" <?php if(!$check) echo 'style="display: none"' ?>>
		        		<hr>
						<div class="form-group">
							<label class="col-sm-2 control-label">Msd [kN.cm]</label>
							<div class="col-sm-10">
								<input name="Msd-Fletor_y" type="number" class="form-control small-input input-double"value="<?php if($oSession->has('Msd-Fletor_y')) echo $oSession->get('Msd-Fletor_y') ?>">
							</div>
						</div>
						
					</div>
		      	</div>

		      	<?php $check = $oSession->isTrue('Check-corte_x') ?>
		      	<div class="form-panel dynamic-form">
		        	<div class="dynamic-form-header">
		        		<img src="assets/img/icons/corte_x.png"> <h3>Corte x</h3>
		        		<input name="Check-corte_x" class="toggle-form" type="checkbox" value="1" <?php if($check) echo 'checked' ?>>
		        	</div>
		        	<div class="form-horizontal style-form dynamic-form-content" <?php if(!$check) echo 'style="display: none"' ?>>
		        		<hr>
						<div class="form-group">
							<label class="col-sm-2 control-label">Vsd [kN]</label>
							<div class="col-sm-10">
								<input name="Vsd-corte_x" type="number" class="form-control small-input input-double"value="<?php if($oSession->has('Vsd-corte_x')) echo $oSession->get('Vsd-corte_x') ?>">
							</div>
						</div>
						
					</div>
		      	</div>

		      	<?php $check = $oSession->isTrue('Check-corte_y') ?>
		      	<div class="form-panel dynamic-form">
		        	<div class="dynamic-form-header">
		        		<img src="assets/img/icons/corte_y.png"> <h3>Corte y</h3>
		        		<input name="Check-corte_y" class="toggle-form" type="checkbox" value="1" <?php if($check) echo 'checked' ?>>
		        	</div>
		        	<div class="form-horizontal style-form dynamic-form-content" <?php if(!$check) echo 'style="display: none"' ?>>
		        		<hr>
						<div class="form-group">
							<label class="col-sm-2 control-label">Vsd [kN]</label>
							<div class="col-sm-10">
								<input name="Vsd-corte_y" type="number" class="form-control small-input input-double"value="<?php if($oSession->has('Vsd-corte_y')) echo $oSession->get('Vsd-corte_y') ?>">
							</div>
						</div>
						
					</div>
		      	</div>

		    </div>
		</div>
	</div>

<?php include '../footer.php' ?>