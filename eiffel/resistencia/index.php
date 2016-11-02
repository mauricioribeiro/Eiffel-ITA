<?php 
	require_once '../lib/config.php';
	require_once '../lib/constant.php';
	require_once '../lib/csv.php';
	require_once '../lib/python.php';

	$EIFFEL = new Config();
	$EIFFEL->setConfig('page','Resistência');

	include '../header.php';

	# $msg = array('info','Bem vindo ao sistema <b>Eiffel</b>.');
	$oConstant = new constant();

?>
	
	<div id="custom-index" class="col-lg-12">
		<?php $oUtil->printMsg($msg) ?>
		<div class="row mt">
				
			<h3>Resistência</h3>
			<hr>

			<div class="col-lg-12">

				<?php if($oSession->isTrue('Check-tracao')){ ?>
			      	<div class="form-panel dynamic-form">
			        	<div class="dynamic-form-header">
			        		<img src="assets/img/icons/tracao.png"> <h3>Tração</h3>
			        		<a id="verificarTracao" class="btn btn-success btn-verificar" href="javascript:void(0)">Verificar</a>
			        	</div>
			        	<div class="form-horizontal style-form dynamic-form-content">
			        		<hr>
			        		<div class="form-group">
								<label class="col-sm-2 control-label">Combinação</label>
								<div class="col-sm-10">
									<select id="Combinacao-tracao" name="Combinacao-tracao" class="form-control">
										<option>---</option>
										<?php 
											foreach($oConstant->getCombinacoes() as $c => $v){
												$s = ($oSession->has('Combinacao-tracao') && $oSession->get('Combinacao-tracao') == $c) ? 'selected' : '';
												echo '<option value="'.$c.'"'.$s.'>'.$c.'</option>';
											}
										?>
									</select>
								</div>
							</div>
			        		<div class="form-group">
								<label class="col-sm-2 control-label">L [cm]</label>
								<div class="col-sm-10">
									<input name="L-tracao" type="number" class="form-control small-input input-double" value="<?php echo ($oSession->has('L-tracao')) ? $oSession->get('L-tracao') : '100.00' ?>" min="10" step="0.01">
								</div>
							</div>
							<?php 
								$maxAn = 0;
		    					$oCSV = new CSV($oSession->get('Componente'));
		    					$oCSV->setFileName($oSession->get('Secao'));
		    					if($oCSV->openFile()){
		    						$item = $oCSV->getLine($oSession->get('Bitola'));
		    						$maxAn = $item['Area'];
		    						//if($oSession->has('An-tracao')) $oSession->set('An-tracao',$maxAn);
		    					}
		    				?>
							<div class="form-group">
								<label class="col-sm-2 control-label">An [cm²]</label>
								<div class="col-sm-10">
									<input name="An-tracao" type="number" class="form-control small-input input-double" value="<?php echo $maxAn ?>" min="0.01" max="<?php echo $maxAn ?>" step="0.01">
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label">Ct</label>
								<div class="col-sm-10">
									<input name="Ct-tracao" type="number" class="form-control small-input input-double" value="<?php echo ($oSession->has('Ct-tracao')) ? $oSession->get('Ct-tracao') : '1.00' ?>" min="0.01" max="1.00" step="0.01">
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label">Anv [cm²]</label>
								<div class="col-sm-10">
									<input name="Anv-tracao" type="number" class="form-control small-input input-double" value="<?php echo $maxAn ?>" min="0.01" step="0.01">
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label">Ant [cm²]</label>
								<div class="col-sm-10">
									<input name="Ant-tracao" type="number" class="form-control small-input input-double" value="<?php echo $maxAn ?>" min="0.01" step="0.01">
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label">Agv [cm²]</label>
								<div class="col-sm-10">
									<input name="Agv-tracao" type="number" class="form-control small-input input-double" value="<?php echo $maxAn ?>" min="0.01" step="0.01">
								</div>
							</div>
						</div>
						<div id="verificarTracao-resumo"></div>
			      	</div>
		      	<?php } ?>
		        
		        <?php if($oSession->isTrue('Check-compressao')){ ?>
			        <div class="form-panel dynamic-form">
			        	<div class="dynamic-form-header">
			        		<img src="assets/img/icons/compressao.png"> <h3>Compressão</h3>
			        		<a id="verificarCompressao" class="btn btn-success btn-verificar" href="javascript:void(0)">Verificar</a>
			        	</div>
			        	<div class="form-horizontal style-form dynamic-form-content">
			        		<hr>
			        		<div class="form-group">
								<label class="col-sm-2 control-label">Combinação</label>
								<div class="col-sm-10">
									<select id="Combinacao-compressao" name="Combinacao-compressao" class="form-control">
										<option>---</option>
										<?php 
											foreach($oConstant->getCombinacoes() as $c => $v){
												$s = ($oSession->has('Combinacao-compressao') && $oSession->get('Combinacao-compressao') == $c) ? 'selected' : '';
												echo '<option value="'.$c.'"'.$s.'>'.$c.'</option>';
											}
										?>
									</select>
								</div>
							</div>
			        		<div class="form-group">
								<label class="col-sm-2 control-label">Lx [cm]</label>
								<div class="col-sm-10">
									<input name="Lx-compressao" type="number" class="form-control small-input input-double" value="<?php echo ($oSession->has('Lx-compressao')) ? $oSession->get('Lx-compressao') : '100.00' ?>" min="10" step="0.01">
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label">Ly [cm]</label>
								<div class="col-sm-10">
									<input name="Ly-compressao" type="number" class="form-control small-input input-double" value="<?php echo ($oSession->has('Ly-compressao')) ? $oSession->get('Ly-compressao') : '100.00' ?>" min="10" step="0.01">
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label">Lz [cm]</label>
								<div class="col-sm-10">
									<input name="Lz-compressao" type="number" class="form-control small-input input-double" value="<?php echo ($oSession->has('Lz-compressao')) ? $oSession->get('Lz-compressao') : '100.00' ?>" min="10" step="0.01">
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label">Kx</label>
								<div class="col-sm-10">
									<input name="Kx-compressao" type="number" class="form-control small-input input-double" value="<?php echo ($oSession->has('Kx-compressao')) ? $oSession->get('Kx-compressao') : '1.00' ?>" min="0.65" max="2.10" step="0.01">
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label">Ky</label>
								<div class="col-sm-10">
									<input name="Ky-compressao" type="number" class="form-control small-input input-double" value="<?php echo ($oSession->has('Ky-compressao')) ? $oSession->get('Ky-compressao') : '1.00' ?>" min="0.65" max="2.1" step="0.01">
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label">Kz</label>
								<div class="col-sm-10">
									<input name="Kz-compressao" type="number" class="form-control small-input input-double" value="<?php echo ($oSession->has('Kz-compressao')) ? $oSession->get('Kz-compressao') : '1.00' ?>" min="1.00" max="2.00" step="0.01">
								</div>
							</div>
						</div>
						<div id="verificarCompressao-resumo"></div>
			      	</div>
		      	<?php } ?>

		      	<?php if($oSession->isTrue('Check-Fletor_x')){ ?>
			      	<div class="form-panel dynamic-form">
			        	<div class="dynamic-form-header">
			        		<img src="assets/img/icons/Fletor_x.png"> <h3>Fletor x</h3>
			        		<a id="verificarFletorX" class="btn btn-success btn-verificar" href="javascript:void(0)">Verificar</a>
			        	</div>
			        	<div class="form-horizontal style-form dynamic-form-content">
			        		<hr>
			        		<div class="form-group">
								<label class="col-sm-2 control-label">Combinação</label>
								<div class="col-sm-10">
									<select id="Combinacao-Fletor_x" name="Combinacao-Fletor_x" class="form-control">
										<option>---</option>
										<?php 
											foreach($oConstant->getCombinacoes() as $c => $v){
												$s = ($oSession->has('Combinacao-Fletor_x') && $oSession->get('Combinacao-Fletor_x') == $c) ? 'selected' : '';
												echo '<option value="'.$c.'"'.$s.'>'.$c.'</option>';
											}
										?>
									</select>
								</div>
							</div>
			        		<div class="form-group">
								<label class="col-sm-2 control-label">Lb [cm]</label>
								<div class="col-sm-10">
									<input name="Lb-Fletor_x" type="number" class="form-control small-input input-double" value="<?php echo ($oSession->has('Lb-Fletor_x')) ? $oSession->get('Lb-Fletor_x') : '100.00' ?>" min="0" step="0.01">
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label">Cb</label>
								<div class="col-sm-10">
									<input name="Cb-Fletor_x" type="number" class="form-control small-input input-double" value="<?php echo ($oSession->has('Cb-Fletor_x') && $oSession->get('Cb-Fletor_x') <= 3) ? $oSession->get('Cb-Fletor_x') : '1.00' ?>" min="0" max="3.00" step="0.01">
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label">a [cm]</label>
								<div class="col-sm-10">
									<input name="a-Fletor_x" type="number" class="form-control small-input input-double" value="<?php echo ($oSession->has('a-Fletor_x')) ? $oSession->get('a-Fletor_x') : '100.00' ?>" min="0" step="0.01">
								</div>
							</div>
							<?php 
								$Afn = '0.00';
								$oCSV = new CSV($oSession->get('Componente'));
								$oCSV->setFileName($oSession->get('Secao'));
								if($oCSV->openFile()){
									$p = $oCSV->getLine($oSession->get('Bitola'));
									$Afn = number_format($p['bf'] * $p['tf']/100,2,'.','');
								}
							 ?>
							<div class="form-group">
								<label class="col-sm-2 control-label">Afn [cm²]</label>
								<div class="col-sm-10">
									<input name="Afn-Fletor_x" type="number" class="form-control small-input input-double" value="<?php echo $Afn ?>" min="0" max="<?php echo $Afn ?>" step="0.01">
								</div>
							</div>
						</div>
						<div id="verificarFletorX-resumo"></div>
			      	</div>
		      	<?php } ?>

		      	<?php if($oSession->isTrue('Check-Fletor_y')){ ?>
			      	<div class="form-panel dynamic-form">
			        	<div class="dynamic-form-header">
			        		<img src="assets/img/icons/Fletor_y.png"> <h3>Fletor y</h3>
			        		<a id="verificarFletorY" class="btn btn-success btn-verificar" href="javascript:void(0)">Verificar</a>
			        	</div>
			        	<div class="form-horizontal style-form dynamic-form-content">
			        		<hr>
			        		<div class="form-group">
								<label class="col-sm-2 control-label">Combinação</label>
								<div class="col-sm-10">
									<select id="Combinacao-Fletor_y" name="Combinacao-Fletor_y" class="form-control">
										<option>---</option>
										<?php 
											foreach($oConstant->getCombinacoes() as $c => $v){
												$s = ($oSession->has('Combinacao-Fletor_y') && $oSession->get('Combinacao-Fletor_y') == $c) ? 'selected' : '';
												echo '<option value="'.$c.'"'.$s.'>'.$c.'</option>';
											}
										?>
									</select>
								</div>
							</div>
			        		<?php 
								$Afn = '0.00';
								$oCSV = new CSV($oSession->get('Componente'));
								$oCSV->setFileName($oSession->get('Secao'));
								if($oCSV->openFile()){
									$p = $oCSV->getLine($oSession->get('Bitola'));
									$Afn = number_format($p['bf'] * $p['tf']/100,2,'.','');
								}
							 ?>
			        		<div class="form-group">
								<label class="col-sm-2 control-label">Afn [cm²]</label>
								<div class="col-sm-10">
									<input name="Afn-Fletor_y" type="number" class="form-control small-input input-double" value="<?php echo $Afn ?>" min="0" max="<?php echo $Afn ?>" step="0.01">
								</div>
							</div>
						</div>
						<div id="verificarFletorY-resumo"></div>
			      	</div>
		      	<?php } ?>

		      	<?php if($oSession->isTrue('Check-corte_x')){ ?>
			      	<div class="form-panel dynamic-form">
			        	<div class="dynamic-form-header">
			        		<img src="assets/img/icons/corte_x.png"> <h3>Corte x</h3>
			        		<a id="verificarCorteX" class="btn btn-success btn-verificar" href="javascript:void(0)">Verificar</a>
			        	</div>
			        	<div class="form-horizontal style-form dynamic-form-content">
			        		<hr>
			        		<div class="form-group">
								<label class="col-sm-2 control-label">Combinação</label>
								<div class="col-sm-10">
									<select id="Combinacao-corte_x" name="Combinacao-corte_x" class="form-control">
										<option>---</option>
										<?php 
											foreach($oConstant->getCombinacoes() as $c => $v){
												$s = ($oSession->has('Combinacao-corte_x') && $oSession->get('Combinacao-corte_x') == $c) ? 'selected' : '';
												echo '<option value="'.$c.'"'.$s.'>'.$c.'</option>';
											}
										?>
									</select>
								</div>
							</div>
							<div id="verificarCorteX-resumo"></div>
						</div>
			      	</div>
		      	<?php } ?>

		      	<?php if($oSession->isTrue('Check-corte_y')){ ?>
			      	<div class="form-panel dynamic-form">
			        	<div class="dynamic-form-header">
			        		<img src="assets/img/icons/corte_y.png"> <h3>Corte y</h3>
			        		<a id="verificarCorteY" class="btn btn-success btn-verificar" href="javascript:void(0)">Verificar</a>
			        	</div>
			        	<div class="form-horizontal style-form dynamic-form-content">
			        		<hr>
			        		<div class="form-group">
								<label class="col-sm-2 control-label">Combinação</label>
								<div class="col-sm-10">
									<select id="Combinacao-corte_y" name="Combinacao-corte_y" class="form-control">
										<option>---</option>
										<?php 
											foreach($oConstant->getCombinacoes() as $c => $v){
												$s = ($oSession->has('Combinacao-corte_y') && $oSession->get('Combinacao-corte_y') == $c) ? 'selected' : '';
												echo '<option value="'.$c.'"'.$s.'>'.$c.'</option>';
											}
										?>
									</select>
								</div>
							</div>
			        		<div class="form-group">
								<label class="col-sm-2 control-label">kv</label>
								<div class="col-sm-10">
									<input name="kv-corte_y" type="number" class="form-control small-input input-double" value="<?php echo ($oSession->has('kv-corte_y')) ? $oSession->get('kv-corte_y') : '5.00' ?>" min="5.00" step="0.01">
								</div>
							</div>
			        		<div id="verificarCorteY-resumo"></div>
						</div>
			      	</div>
		      	<?php } ?>

		      	<?php if($oSession->isTrue('Check-tracao') || $oSession->isTrue('Check-compressao') || $oSession->isTrue('Check-Fletor_x') || $oSession->isTrue('Check-Fletor_y')) { ?>
		      		<div class="form-panel dynamic-form">
			        	<div class="dynamic-form-header">
			        		<img src="assets/img/icons/combinado.png"> <h3>Combinado</h3>
			        		<a id="verificarCombinado" class="btn btn-success btn-verificar-combinacao" href="javascript:void(0)">Verificar</a>
			        	</div>
			        	<div class="form-horizontal style-form dynamic-form-content">
			        		<hr>
			        		<div id="verificarCombinado-resumo"></div>
						</div>
			      	</div>
		      	<?php } ?>

		    </div>
		</div>
	</div>

	<script>
  		$(document).ready(function(){
  			$('.dynamic-form').find('input').each(function(){
  				listen($(this));
  			});
  		});
  	</script>

<?php include '../footer.php' ?>