<?php 
	require_once '../lib/config.php';

	$EIFFEL = new Config();
	$EIFFEL->setConfig('page','Verificação');

	include '../header.php';

	$grandezas = array(
		'E		kN/cm²',
		'G		kN/cm²',
		'Área		cm²',
		'fy		kN/cm²',
		'gamma1	-',
		'Ct		-',
		'fu		kN/cm²',
		'gamma2	-',
		'L		cm',
		'rx		cm',
		'ry		cm',
		'NtSd		kN',
		'Kx		-',
		'Ky		-',
		'Kz		-',
		'Lx		cm',
		'Ly		cm',
		'Lz		cm',
		'd		cm',
		'bf		cm',
		'tf		cm',
		'tw		cm',
		'h		cm',
		'hw		cm',
		'I		cm^4',
		'Cw		cm^6',
		'J		cm^4',
		'NcSd		kN',
		'Cb		-',
		'Z		cm³',
		'W		cm³',
		'a		cm',
		'MSd		kN.cm',
		'VSd		kN',
	);

?>
	
	<div id="custom-index" class="col-lg-12">
		<?php $oUtil->printMsg($msg) ?>
		<div class="row mt">
				
			<h3>Ajuda</h3>
			<hr>

			<div class="col-lg-12">
				<div class="panel panel-default">
					<div class="panel-body">
						<div class="topic">
					        <h4>Como adicionar/atualizar scripts python e planilhas de dados csv?</h4>
					        <hr>
					        <p>Para a atualização e/ou adição de novos scripts python ou base de dados csv, é preciso criar uma conexão ftp. Os passos são os seguintes:</p>
					        <ul>
					        	<li>Instalar um programa que permita conexões ftp (recomenda-se o <a href="https://filezilla-project.org/" target="_blank">Filezilla</a>);</li>
					        	<li>Adicionar uma nova conexão com os dados:
					        		<ul>
					        			<li>
					        				<table class="table table-bordered" style="margin-top: -10px;">
							        			<tbody>
							        				<tr>
							        					<td><b>servidor/host</b></td>
							        					<td>161.24.12.204</td>
							        				</tr>
													<tr>
							        					<td><b>porta</b></td>
							        					<td>21</td>
							        				</tr>
													<tr>
							        					<td><b>usuário</b></td>
							        					<td>lme</td>
							        				</tr>
													<tr>
							        					<td><b>senha</b></td>
							        					<td>lme#2016</td>
							        				</tr>
							        			</tbody>
							        		</table>
					        			</li>
					        		</ul>
					        	</li>
					        </ul>
					        <p>A estrutura de pastas da estrutura ftp do Eiffel é organizada por componentes (Figura 1). Em cada pasta de componente são encontradas três sub-pastas:</p>
					        <ul>
					        	<li><b>csv</b> pasta reservada para as planilhas de base de dados csv. As planilhas .csv devem ser criadas dentro do <a href="#padrao-csv">padrão Eiffel</a>.</li>
					        	<li><b>jpg</b> pasta reservada para imagens dos componentes;</li>
					        	<li><b>py</b> pasta reservada para os scripts de cálculo em python. A versão do Python usada é 2.7 (pode ser baixada <a href="https://www.python.org/download/releases/2.7/" target="_blank">aqui</a>). Os scripts .py devem ser escritos dentro do <a href="#padrao-py">padrão Eiffel</a>.</li>
					        </ul>
					        <p class="text-center">
					        	<img src="assets/img/ftp-raiz.png" class="thumbnail center-block" title="Raíz do FTP Eiffel" style="width:80%">
					        	<small>Figura 1 - Raíz do FTP Eiffel</small>
					        </p>
					        <p>O Eiffel reconhece automaticamente scripts .py e planilhas .csv adicionadas nas pastas dos componentes.</p>
				        </div>
				        <div class="topic">
				        	<h4 id="padrao-csv">Como criar planilhas .csv no padrão Eiffel?</h4>
				        	<hr>
				        	<p>Para a criação de planilhas .csv deve-se respeitar os seguintes itens:</p>
				        	<ul>
				        		<li>O formato dos arquivos .csv deve ser MS-DOS, ou seja, sem formatação e com "ponto e virgula" (;) como separadores de colunas;</li>
				        		<li>O nome do arquivo deve ser escrito com letras minúsculas apenas, sem caracteres especiais nem espaços. Utilize o <i>underline</i> (_) na separação das palavras;</li>
				        		<li>Os parâmetros devem ser explicitos na primeira linha do arquivo e devem ter os mesmos nomes das variáveis utilizadas nos cálculos no script .py correspondente;</li>
				        	</ul>
				        </div>
				        <div class="topic">
				        	<h4 id="padrao-py">Como codificar classes no padrão Eiffel?</h4>
				        	<hr>
				        	<p>Em breve documentação.</p>
				        </div>
			        </div>
		        </div>
		    </div>
		</div>
	</div>

	<style type="text/css"> ul li {list-style: initial;} .topic{ margin: 5px 5px 50px 5px; }</style>

<?php include '../footer.php' ?>