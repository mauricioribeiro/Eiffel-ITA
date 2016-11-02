<?php 
	require_once '../lib/config.php';

	$EIFFEL = new Config();
	$EIFFEL->setConfig('page','Relatório');

	require_once '../includes.php';
	require_once '../lib/mpdf/mpdf.php';

    $oUtil = new util();
    $oSession = new session();
    $oMenu = new menu();
    
    $PDF = new mPDF();
    $html = '<!DOCTYPE html><html><head><meta charset="utf-8"><base href="'.$EIFFEL->getConfig('url').'"></base></head><body>';
	$html .= '<style>
		html,body,table{ background: #fff !important; }
		* { font-family: Arial, sans-serif !important; color: #000 !important; }
		p{ margin: 5px 0; }
		a{ text-decoration: none }
		table{ border-spacing: 0; } th,td{ border: 1px solid #000; padding: 5px; }
		tr.children-center *,.children-center *,tr.children-center td,.children-center td,tr.children-center h1{ text-align: center !important; }
		tr.blank td, .blank td { height: 20px; border-left: 1px solid #fff !important; border-right: 1px solid #fff !important; }
		.control-p { font-weight: bold; padding: 0; }
		.form-group{ border-bottom: 1px solid #C6C6C6; }
	</style>
	<script src="assets/js/jquery.js"></script>
   	<script src="assets/js/jquery.mask.min.js"></script>
   	<script src="assets/js/custom.js"></script>';

	ob_start();
	include_once '../inc/relatorio.php';
	$html .= ob_get_contents();
	ob_end_clean();

	$pages = explode('<!-- newPage -->', $html);

	for ($i = 0; $i < count($pages); $i++) { 
		$PDF->WriteHTML($pages[$i]);
		if($i != count($pages)-1) $PDF->AddPage();
	}

	$PDF->WriteHTML('</body></html>');
	$PDF->Output($EIFFEL->getConfig('name').' Relatório.pdf','I');#,'D');
	#echo $html;
 ?>