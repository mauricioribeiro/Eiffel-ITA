<?php 
	ini_set('display_errors',0);
	
	include_once '../lib/config.php';
	include_once '../lib/file.php';
	include_once '../lib/csv.php';
	include_once '../lib/python.php';
	include_once '../lib/session.php';
	include_once '../lib/constant.php';

	$r = '<h3>Resumo</h3>
		<div>
			<table class="table table-striped table-advance table-hover">
	            <thead>
	              <tr>
	              	<th>Combinação</th>
	                <th>Status</th>
	              </tr>
	            </thead>
	            <tbody>';

	$oSession = new session();
	$oPython = new python();
	$oConstant = new constant();

	if($oSession->has('Secao') && $oSession->has('Componente')){

		$oCSV = new CSV($oSession->get('Componente'));
		$oCSV->setFileName($oSession->get('Secao'));
		if($oCSV->openFile()){
			$p = $oCSV->getLine($oSession->get('Bitola'));
		}

		$oCSV = new CSV($oSession->get('Componente'));
		$oCSV->setFileName('aco');
		if($oCSV->openFile()){
			$a = $oCSV->getLine($oSession->get('Aco'));
		}

		$flexao = false;
		$NSd = $MxSd = $MySd = 0;
		$NRdMatrix = $MxRdMatrix = $MyRdMatrix = array();

		if($oSession->isTrue('Check-Fletor_x')){
			$g = $oConstant->getGamma($oSession->get('Combinacao-Fletor_x'));					
			$param = array(
				'Cb' => $oSession->get('Cb-Fletor_x'),
				'fy' => $a['fy'],
				'fu' => $a['fu'],
				'd' => $p['d'],
				'bf' => $p['bf'],
				'tf' => $p['tf'],
				'tw' => $p['tw'],
				'h' => $p['h'],
				'hw' => $p['hw'],
				'Lb' => $oSession->get('Lb-Fletor_x'),
				'ry' => $p['ry'],
				'Zx' => $p['Zx'],
				'gamma1' => $g['gamma1'],
				'Iy' => $p['Iy'],
				'J' => $p['J'],
				'Cw' => $p['Cw'],
				'Wx' => $p['Wx'],
				'a' => $oSession->get('a-Fletor_x'),
				'Afn' => $oSession->get('Afn-Fletor_x'),
				'MSd' => $oSession->get('Msd-Fletor_x')
			);
			$MxSd = floatval($oSession->get('Msd-Fletor_x'));
			$MxRdMatrix = $oPython->execute($oSession->get('Componente'), $oSession->get('Secao'),'verificarFletorX',implode(',',$param));
			$flexao = true;
		}
		
		if($oSession->isTrue('Check-Fletor_y')){
			$g = $oConstant->getGamma($oSession->get('Combinacao-Fletor_y'));					
			$param = array(
				'Cb' => 0.0,
				'fy' => $a['fy'],
				'fu' => $a['fu'],
				'd' => $p['d'],
				'bf' => $p['bf'],
				'tf' => $p['tf'],
				'tw' => $p['tw'],
				'h' => $p['h'],
				'hw' => $p['hw'],
				'ry' => $p['ry'],
				'Zx' => $p['Zx'],
				'gamma1' => $g['gamma1'],
				'Iy' => $p['Iy'],
				'J' => $p['J'],
				'Cw' => $p['Cw'],
				'Wy' => $p['Wy'],
				'Afn' => $oSession->get('Afn-Fletor_y'),
				'MSd' => $oSession->get('Msd-Fletor_y')
			);
			$MySd = floatval($oSession->get('Msd-Fletor_y'));
			$MyRdMatrix = $oPython->execute($oSession->get('Componente'), $oSession->get('Secao'),'verificarFletorY',implode(',',$param));
			$flexao = true;
		}

		if($oSession->isTrue('Check-tracao')){

			$g = $oConstant->getGamma($oSession->get('Combinacao-tracao'));			
			$param = array(
				'Area' => $p['Area'],
				'fy' => $a['fy'],
				'gamma1' => $g['gamma1'],
				'Ct' => $oSession->get('Ct-tracao'),
				'An' => $oSession->get('An-tracao'),
				'fu' => $a['fu'],
				'gamma2' => $g['gamma2'],
				'L' => $oSession->get('L-tracao'),
				'rx' => $p['rx'],
				'ry' => $p['ry'],
				'Anv' => $oSession->get('Anv-tracao'),
				'Ant' => $oSession->get('Ant-tracao'),
				'Agv' => $oSession->get('Agv-tracao'),
				'Nsd' => $oSession->get('Nsd-tracao')
			);
			$NSd = floatval($oSession->get('Nsd-tracao'));
			$NRdMatrix = $oPython->execute($oSession->get('Componente'), $oSession->get('Secao'),'verificarTracao',implode(',',$param));

			$status = $oConstant->getCombinado($NSd, $NRdMatrix, $MxSd, $MxRdMatrix, $MySd, $MyRdMatrix);
			$r .= '<tr><td>Tração';
			if($oSession->isTrue('Check-Fletor_x') || $oSession->isTrue('Check-Fletor_y')) $r .= ' e Flexão';
			$r .= '</td>';
			$r .= ($status) ? '<td title="OK"><i class="fa fa-check-circle"></i></td>' : '<td title="Não OK"><i class="fa fa-times-circle"></i></td>';
			$r.= '</tr>';
			$flexao = false;
		}

		if($oSession->isTrue('Check-compressao')){
			$g = $oConstant->getGamma($oSession->get('Combinacao-compressao'));					
			$param = array(
				'Area' => $p['Area'],
				'Kx' => $oSession->get('Kx-compressao'),
				'Ky' => $oSession->get('Ky-compressao'),
				'Kz' => $oSession->get('Kz-compressao'),
				'Lx' => $oSession->get('Lx-compressao'),
				'Ly' => $oSession->get('Ly-compressao'),
				'Lz' => $oSession->get('Lz-compressao'),
				'fy' => $a['fy'],
				'd' => $p['d'],
				'bf' => $p['bf'],
				'tf' => $p['tf'],
				'tw' => $p['tw'],
				'h' => $p['h'],
				'hw' => $p['hw'],
				'Ix' => $p['Ix'],
				'Iy' => $p['Iy'],
				'Cw' => $p['Cw'],
				'J' => $p['J'],
				'gamma1' => $g['gamma1'],
				'Nsd' => $oSession->get('Nsd-compressao')
			);

			$NSd = floatval($oSession->get('Nsd-compressao'));
			$NRdMatrix = $oPython->execute($oSession->get('Componente'), $oSession->get('Secao'),'verificarCompressao',implode(',',$param));

			$status = $oConstant->getCombinado($NSd, $NRdMatrix, $MxSd, $MxRdMatrix, $MySd, $MyRdMatrix);
			$r .= '<tr><td>Compressão';
			if($oSession->isTrue('Check-Fletor_x') || $oSession->isTrue('Check-Fletor_y')) $r .= ' e Flexão';
			$r .= '</td>';
			$r .= ($status) ? '<td title="OK"><i class="fa fa-check-circle"></i></td>' : '<td title="Não OK"><i class="fa fa-times-circle"></i></td>';
			$r.= '</tr>';
			$flexao = false;
		}

		if($flexao){
			$status = $oConstant->getCombinado($NSd, $NRdMatrix, $MxSd, $MxRdMatrix, $MySd, $MyRdMatrix);
			$r .= '<tr><td>Flexão</td>';
			$r .= ($status) ? '<td title="OK"><i class="fa fa-check-circle"></i></td>' : '<td title="Não OK"><i class="fa fa-times-circle"></i></td>';
			$r.= '</tr>';
		}
	} else {
		$r .= '<tr colspan="4"><td><p>Componente / Seção inválidos.</p></td></tr>';
	}

	$r .= '</tbody>
	   	</table>
    </div>';

	echo $r;

 ?>