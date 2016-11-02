<?php 
	require_once 'includes.php';

    $oUtil = new util();
    $oSession = new session();
    $oMenu = new menu();
    
    $msg = null;

 ?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="author" content="Mauricio Ribeiro">
		<base href="<?php echo $EIFFEL->getConfig('url') ?>"></base>

		<title><?php echo $EIFFEL->getConfig('name').' - '.$EIFFEL->getConfig('client').' | '.$EIFFEL->getConfig('page') ?></title>

		<link href="assets/css/bootstrap.css" rel="stylesheet">
		<link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
		<link href="assets/css/style.css" rel="stylesheet">
		<link href="assets/css/custom.css" rel="stylesheet">
		<link href="assets/css/style-responsive.css" rel="stylesheet">
		<link href="assets/css/ui-overcast/jquery-ui-1.9.2.custom.min.css" rel="stylesheet">

		<link href="assets/css/bootstrap.css" rel="stylesheet" media="print">
		<link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" media="print"/>
		<link href="assets/css/style.css" rel="stylesheet media="print">
		<link href="assets/css/custom.css" rel="stylesheet media="print">
		<link href="assets/css/style-responsive.css" rel="stylesheet" media="print">
		<link href="assets/css/ui-overcast/jquery-ui-1.9.2.custom.min.css" rel="stylesheet" media="print">

		<link href="assets/img/icon.ico" rel='icon'/>

		<link href='https://fonts.googleapis.com/css?family=IM+Fell+English:400italic' rel='stylesheet' type='text/css'>

		<!--[if lt IE 9]>
		  <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
		  <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
		<![endif]-->

		<script src="assets/js/jquery.js"></script>
		<script src="assets/js/jquery.mask.min.js"></script>
    	<script src="assets/js/custom.js"></script>
		
		</head>
		<body>

		<section id="container" >
	      <!--header start-->
	      <header class="header not-print">
				<div class="sidebar-toggle-box">
				  <div id="eiffel-logo" class="fa fa-bars tooltips" data-placement="right" data-original-title="Toggle Navigation"></div>
				</div>
            	<a id="eiffel-name" href="<?php echo $EIFFEL->getConfig('url') ?>" class="logo"><b><?php echo $EIFFEL->getConfig('name') ?></b></a>
	            <div class="top-menu">
	            	<ul class="nav pull-right top-menu">
	            		<li id="header-status"></li>
	                    <!--<li><a class="logout" href="javascript:void(0)" data-toggle="modal" data-target="#mdlLogout">Sair</a></li>-->
	            	</ul>
	            </div>
	        </header>
	      <!--header end-->

	      	<!-- modals start -->
	      	<div class="modal fade" id="mdlLogout" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
			  <div class="modal-dialog">
			    <div class="modal-content">
			      <div class="modal-header">
			        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			        <h4 class="modal-title" id="myModalLabel">Sair do Sistema...</h4>
			      </div>
			      <div class="modal-body">
			        Tem certeza que deseja sair do Sistema?
			      </div>
			      <div class="modal-footer">
			        <button type="button" class="btn btn-default" data-dismiss="modal">Voltar</button>
			        <a type="button" href="logout.php" class="btn btn-danger">Sair</a>
			      </div>
			    </div>
			  </div>
			</div>

			<div class="modal fade" id="mdlDeleteItem" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
			  <div class="modal-dialog">
			    <div class="modal-content">
			      <div class="modal-header">
			        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			        <h4 class="modal-title" id="myModalLabel">Deletando item...</h4>
			      </div>
			      <div class="modal-body">
			        Tem certeza que deseja deletar este item? Uma vez deletado, o item não pode ser mais recuperado.
			      </div>
			      <div class="modal-footer">
			        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
			        <a id="btn-confirm-del" type="button" href="javascript:void(0)" class="btn btn-danger">Deletar item permanentemente</a>
			      </div>
			    </div>
			  </div>
			</div>

			<div class="modal fade" id="mdlInfo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
			  <div class="modal-dialog">
			    <div class="modal-content">
			      <div class="modal-header">
			        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			        <h4 class="modal-title" id="myModalLabel"><i class="fa fa-info"></i> Informações</h4>
			      </div>
			      <div class="modal-body"></div> 
			    </div>
			  </div>
			</div>

			<!-- modals end -->
	      
	      <!--sidebar start-->
	      <aside class="not-print">
	          <div id="sidebar"  class="nav-collapse ">
	              <!-- sidebar menu start-->
	              <ul class="sidebar-menu" id="nav-accordion">
	              
					<!--
					<p class="centered">Logado como:</p>
					<h5 class="centered"><?php #echo $admUsuario->Nome ?></h5>
					<h5 class="centered"><?php #echo $admSetor->getSetor($admUsuario->SetorID); ?></h5>
					-->

					<div id="sidebar-main-buttons">
						<a href="inc/session-listener.php?flag=RESET" title="Redefinir Valores"><i class="fa fa-refresh"></i></a>
						<!--<a href="conta/" title="Editar Conta"><i class="fa fa-pencil-square"></i></a>-->
					</div>

					<!-- CEMEF menu -->
					<?php 
						$menu = $oMenu->getParents();
						foreach($menu as $item) { 
					?>                  

					<li class="sub-menu">
					  	<a href="<?php echo ($item['link']) ? $item['link'] : 'javascript:void(0)' ?>">
					      <img src="assets/img/menu/<?php echo $item['icon'] ?>">
					      <span><?php echo $item['name'] ?></span>
					  	</a>

					  	<?php 
					  	$submenu = $oMenu->getChildren($item['id']);
					  	if(count($submenu)){
					  		echo '<ul class="sub">';
					  		foreach($submenu as $subitem) { 
					  			echo '<li><a href="'.$subitem['link'].'">'.$subitem['name'].'</a></li>';
					  			if($EIFFEL->getConfig('dir') == $subitem['link']) $EIFFEL->setConfig('icon',$subitem['icon']);
					  		}
					  		echo '</ul>';
						}
						?>
		            </li>

	                <?php } ?>

	              </ul>
	              <!-- sidebar menu end-->
	          </div>
	      </aside>

	    <section id="main-content">
		  	<section class="wrapper site-min-height">
				<!-- <h3 class="not-print"> <img src="assets/img/menu/<?php echo $EIFFEL->getConfig('icon') ?>"></i> <?php echo $EIFFEL->getConfig('page') ?></h3>-->