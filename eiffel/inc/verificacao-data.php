<?php 
	ini_set('display_errors',0);
	
	include_once '../lib/config.php';
	include_once '../lib/file.php';
	include_once '../lib/csv.php';

	# v = value, t = title
	$r = array(
		'Aco' => array(array('v'=>'','t'=>'Esperando Componente...')),
		'Secao' => array(array('v'=>'','t'=>'Esperando Componente...')),
		'Bitola' => array(array('v'=>'','t'=>'Esperando Seção...')),
	);
	
	if(isset($_GET['Secao']) && isset($_GET['Componente'])){

		$oCSV = new CSV($_GET['Componente']);
		$oCSV->setFileName($_GET['Secao']);
		if($oCSV->openFile()){
			$r['Bitola'][0]['t'] = '---';
			foreach ($oCSV->getData() as $item){
				array_push($r['Bitola'], array('v'=>$item['LINE'], 't'=>$item['Bitola']));
			}
		}

	} else if(isset($_GET['Componente'])){

		$oCSV = new CSV($_GET['Componente']);
		$oCSV->setFileName('aco');
		if($oCSV->openFile()){
			$r['Aco'][0]['t'] = '---';
			foreach ($oCSV->getData() as $item){
				array_push($r['Aco'], array('v'=>$item['LINE'], 't'=>$item['Denominacao']));
			}
		}

		$oFile = new File();
		$options = $oFile->getOptions($_GET['Componente']);
		if(count($options)){
			$r['Secao'][0]['t'] = '---';
			foreach ($options as $option){
				array_push($r['Secao'], array('v'=>$oFile->human2file($option), 't'=>$option));
			}
		}

	}

	echo json_encode($r);

 ?>