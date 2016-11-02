<?php
	$oConstant = new constant();
	$oDictionary = new dictionary();

	$oCSV = new CSV($oSession->get('Componente'));
	$oCSV->setFileName($oSession->get('Secao'));
	if($oCSV->openFile()){
		$catalogo = $oCSV->getLine($oSession->get('Bitola'));
	}

	$oCSV = new CSV($oSession->get('Componente'));
	$oCSV->setFileName('aco');
	if($oCSV->openFile()){
		$aco = $oCSV->getLine($oSession->get('Aco'));
	}

	$funcao = '';
	function getPosHTML($f){
		return '<div id="'.$f.'-resumo"></div>
		<textarea id="'.$f.'-input" name="'.$f.'-input" style="display:none"></textarea>
		<script>$(document).ready(function(){ calcular(\''.$f.'\') });</script>
		<hr>';
	}

	function getParList($title, $pars){
		$r = '<h2>'.$title.'</h2>
		<h3>Parâmetros</h3>
		<ul>';
		foreach($pars as $p) {
			$r .= '<li>'.$p['sigla'].' ('.$p['nome'].')';
			$r .= ' = '.$p['valor'];
			if($p['unidade']){
				$r .= ' '.$p['unidade'].'</li>';
			}
		}
		return $r . '</ul>';
	}
?>

<div id="relatorioPDF">

	<?php
		// Tração
		if($oSession->isTrue('Check-tracao')){
			$funcao = 'verificarTracao';
			$gamma = $oConstant->getGamma($oSession->get('Combinacao-tracao'));			
			$param = $oDictionary->getForTracao($catalogo, $aco, $gamma, $oSession);
			echo getParList('Tração',$param);
			echo (!isset($_POST[$funcao.'-input'])) ? getPosHTML($funcao) : $_POST[$funcao.'-input'];
		}
	?>

	<?php
		// Compressão
		if($oSession->isTrue('Check-compressao')){
			$funcao = 'verificarCompressao';
			$gamma = $oConstant->getGamma($oSession->get('Combinacao-compressao'));					
			$param = $oDictionary->getForCompressao($catalogo, $aco, $gamma, $oSession);
			echo '<!-- newPage -->';
			echo getParList('Compressão',$param);

			echo (!isset($_POST[$funcao.'-input'])) ? getPosHTML($funcao) : $_POST[$funcao.'-input'];
		}
	?>

	<?php
		// Fletor X
		if($oSession->isTrue('Check-Fletor_x')){
			$funcao = 'verificarFletorX';
			$gamma = $oConstant->getGamma($oSession->get('Combinacao-Fletor_x'));
			$param = $oDictionary->getForFletorX($catalogo, $aco, $gamma, $oSession);

			echo '<!-- newPage -->';
			echo getParList('Fletor X',$param);

			echo (!isset($_POST[$funcao.'-input'])) ? getPosHTML($funcao) : $_POST[$funcao.'-input'];
		}
	?>

	<?php
		// Fletor Y
		if($oSession->isTrue('Check-Fletor_y')){
			$funcao = 'verificarFletorY';
			$gamma = $oConstant->getGamma($oSession->get('Combinacao-Fletor_y'));			
			$param = $oDictionary->getForFletorY($catalogo, $aco, $gamma, $oSession);

			echo '<!-- newPage -->';
			echo getParList('Fletor Y',$param);

			echo (!isset($_POST[$funcao.'-input'])) ? getPosHTML($funcao) : $_POST[$funcao.'-input'];
		}
	?>

	<?php
		// Corte X
		if($oSession->isTrue('Check-corte_x')){
			$funcao = 'verificarCorteX';
			$gamma = $oConstant->getGamma($oSession->get('Combinacao-corte_y'));					
			$param = $oDictionary->getForCorteX($catalogo, $aco, $gamma, $oSession);

			echo '<!-- newPage -->';
			echo getParList('Corte X',$param);

			echo (!isset($_POST[$funcao.'-input'])) ? getPosHTML($funcao) : $_POST[$funcao.'-input'];
		}
	?>

	<?php
		// Corte Y
		if($oSession->isTrue('Check-corte_y')){
			$funcao = 'verificarCorteY';
			$gamma = $oConstant->getGamma($oSession->get('Combinacao-corte_y'));					
			$param = $oDictionary->getForCorteY($catalogo, $aco, $gamma, $oSession);

			echo '<!-- newPage -->';
			echo getParList('Corte Y',$param);

			echo (!isset($_POST[$funcao.'-input'])) ? getPosHTML($funcao) : $_POST[$funcao.'-input'];
		}
	?>

</div>

<script>
	function calcular(funcao){
		$('#'+funcao+'-resumo').hide();
		$.ajax({
			url: 'inc/resistencia-data.php',
			data : { 'funcao' : funcao, 'pdf' : true },
		  	type : 'GET',
		  	success: function (r) {
				$('#'+funcao+'-resumo').html(r).fadeIn();
				$('#'+funcao+'-input').html(r);
			}
		});
	}	
</script>