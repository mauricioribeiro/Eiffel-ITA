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
	                  <th>Estado Limite</th>
	                  <th>Valor Projeto</th>
	                  <th>Valor Admissível</th>
	                  <th>Segurança (%)</th>
	                  <th>Status</th>
	              </tr>
	            </thead>
	            <tbody>';

	if(isset($_GET['funcao'])){

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

			switch($_GET['funcao']){

				# verificarTracao(Area,fy,gamma1,Ct,An,fu,gamma2,L,rx,ry,Anv,Ant,Agv,NtSd)
				case 'verificarTracao':
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
				break;

				# verificarCompressao(Area,Kx,Ky,Kz,Lx,Ly,Lz,fy,d,bf,tf,tw,h,hw,Ix,Iy,Cw,J,gamma1,NcSd)
				case 'verificarCompressao':
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
				break;

				# verificarFletorX(Cb,fy,fu,d,bf,tf,tw,h,hw,Lb,ry,Zx,gamma1,Iy,J,Cw,Wx,a,Afn,MSd)
				case 'verificarFletorX':
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
				break;

				#verificarFletorY(Cb,fy,fu,d,bf,tf,tw,h,hw,ry,Zy,gamma1,Iy,J,Cw,Wy,Afn,MSd)
				case 'verificarFletorY':
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
				break;

				#verificarCorteX(fy,d,bf,tf,tw,h,hw,gamma1,VSd)
				case 'verificarCorteX':
					$g = $oConstant->getGamma($oSession->get('Combinacao-corte_x'));					
					$param = array(
						'fy' => $a['fy'],
						'd' => $p['d'],
						'bf' => $p['bf'],
						'tf' => $p['tf'],
						'tw' => $p['tw'],
						'h' => $p['h'],
						'hw' => $p['hw'],
						'gamma1' => $g['gamma1'],
						'VSd' => $oSession->get('Vsd-corte_x')
					);
				break;

				#verificarCorteY(fy,d,bf,tf,tw,h,hw,gamma1,kv,VSd)
				case 'verificarCorteY':
					$g = $oConstant->getGamma($oSession->get('Combinacao-corte_y'));					
					$param = array(
						'fy' => $a['fy'],
						'd' => $p['d'],
						'bf' => $p['bf'],
						'tf' => $p['tf'],
						'tw' => $p['tw'],
						'h' => $p['h'],
						'hw' => $p['hw'],
						'gamma1' => $g['gamma1'],
						'kv' => $oSession->get('kv-corte_y'),
						'VSd' => $oSession->get('Vsd-corte_y')
					);
				break;
				
				default:
					$r .= '<tr><td colspan="5"><p>A função <i>'.$_GET['funcao'].'</i> não é válida</p></td></tr>';
				break;
			}

			$matrix = $oPython->execute($oSession->get('Componente'), $oSession->get('Secao'), $_GET['funcao'],implode(',',$param));

			if(count($matrix)){
				foreach ($matrix as $arr) {
					$r .= '<tr>';
					if(count($arr)){
						$r .= '<td>'.$arr[0].'</td>';
						$r .= (is_numeric($arr[1])) ? '<td>'.round($arr[1],2).'</td>' : '<td>'.$arr[1].'</td>';
						$r .= (is_numeric($arr[2])) ? '<td>'.round($arr[2],2).'</td>' : '<td>'.$arr[2].'</td>';
						$r .= '<td>'.$arr[3].'</td>';
						if(isset($_GET['pdf'])){
							$r .= ($arr[4]) ? '<td>OK</td>' : '<td>Não OK</td>';
						} else {
							$r .= ($arr[4]) ? '<td title="OK"><i class="fa fa-check-circle"></i></td>' : '<td title="Não OK"><i class="fa fa-times-circle"></i></td>';
						}
					}
					$r .= '</tr>';
				}
			} else {
				$r .= '<tr><td colspan="5"><p>Falha ao calcular. Verifique os parâmetros.</p></td></tr>';
			}

		} else {
			$r .= '<tr><td colspan="5"><p>Componente / Seção inválidos.</p></td></tr>';
		}
	} else {
		$r .= '<tr><td colspan="5"><p>Nenhuma função selecionada</p></td></tr>';
	}

	$r .= '</tbody>
	   	</table>
    </div>';

	echo $r;

 ?>