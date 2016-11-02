<?php 
	require_once '../lib/config.php';
	require_once '../lib/constant.php';
	require_once '../lib/file.php';
	require_once '../lib/csv.php';

	$EIFFEL = new Config();
	$EIFFEL->setConfig('page','Verificação');

	$oConstant = new constant();
	$oFile = new file();
	$oCSV = new csv();

	include '../header.php';

	# $msg = array('info','Bem vindo ao sistema <b>Eiffel</b>.');

?>
	
	<div id="custom-index" class="col-lg-12">
		<?php $oUtil->printMsg($msg) ?>
		<div class="row mt">
				
			<h3>Verificação</h3>
			<hr>

			<div class="col-lg-12">
		        <div class="form-panel">
		        	<hr>
		        	<!-- <form class="form-horizontal style-form" method="post"> -->
		        	<div class="form-horizontal style-form">
						<div class="form-group">
						    <label class="col-sm-2 control-label">Componente</label>
						    <div class="col-sm-10">
						        <select id="Componente" name="Componente" class="form-control">
						        	<option value="" <?php if(!$oSession->has('Componente')) echo 'selected' ?>>---</option>
						        	<?php 
						        		foreach ($oConstant->getComponentes() as $k => $v) {
						        			$s = ($oSession->get('Componente') == $k) ? 'selected' : '';
						        			echo '<option value="'.$k.'"'.$s.'>'.$v.'</option>';
						        		}
						        	 ?>
						        </select>
						    </div>
						</div>

						<div class="form-group">
						    <label class="col-sm-2 control-label">Aço</label>
						    <div id="targetAco" class="col-sm-10">
						    	<?php if($oSession->has('Aco')){ ?>
						    		<select class="form-control" disabled>
						    			<option value="">
						    				<?php 
						    					$oCSV = new CSV($oSession->get('Componente'));
						    					$oCSV->setFileName('aco');
						    					if($oCSV->openFile()){
						    						$item = $oCSV->getLine($oSession->get('Aco'));
						    						echo $item['Denominacao'];
						    					}
						    				?>
						    			</option>
						    		</select>
								<?php } ?>
						    </div>
						</div>

						<div class="form-group">
							<label class="col-sm-2 control-label">Seção</label>
							<div id="targetSecao" class="col-sm-10">
								<?php if($oSession->has('Secao')){ ?>
						    		<select class="form-control" disabled>
						    			<option value=""><?php echo $oFile->file2human($oSession->get('Secao')) ?></option>
						    		</select>
								<?php } ?>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-2 control-label">Bitola</label>
							<div id="targetBitola" class="col-sm-10">
								<?php if($oSession->has('Bitola')){ ?>
						    		<select class="form-control" disabled>
						    			<option value="">
						    				<?php 
						    					$oCSV = new CSV($oSession->get('Componente'));
						    					$oCSV->setFileName($oSession->get('Secao'));
						    					if($oCSV->openFile()){
						    						$item = $oCSV->getLine($oSession->get('Bitola'));
						    						echo $item['Bitola'];
						    					}
						    				?>
						    			</option>
						    		</select>
								<?php } ?>
							</div>
						</div>

						<!---
						<div class="form-group">
							<label class="col-sm-2 control-label">Python</label>
							<div class="col-sm-10">
								<?php
									$oPython = new Python();
									var_dump($oPython->execute('perfil','i_generico','hi()'));
								?>
							</div>
						</div>
						-->

					</div>
					<!-- exibir que está pronto para o próximo passo -->
		      	</div>
		    </div>
		</div>
	</div>

<?php include '../footer.php' ?>