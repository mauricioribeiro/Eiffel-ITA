<?php 

	class Dictionary extends Config {

		public $param = array();

		function __construct(){
			$this->addParameter('Area','área bruta da seção transversal','cm<sup>2</sup>');
			$this->addParameter('fy','resistência ao escoamento do aço','kN/cm<sup>2</sup>');
			$this->addParameter($this->getGammaSymbol() . 'a1','coeficiente de ponderação das resistências');
			$this->addParameter('Ct','coeficiente de redução da área líquida');
			$this->addParameter('An','área líquida da barra','cm<sup>2</sup>');
			$this->addParameter('fu','resistência à ruptura do aço','kN/cm<sup>2</sup>');
			$this->addParameter($this->getGammaSymbol() . 'a2','coeficiente de ponderação das resistências');
			$this->addParameter('L','comprimento destravado','cm');
			$this->addParameter('rx','raio de giração no eixo x','cm');
			$this->addParameter('ry','raio de giração no eixo y','cm');
			$this->addParameter('Anv','área líquida sujeita a cisalhamento','cm<sup>2</sup>');
			$this->addParameter('Ant','área líquida sujeita à tração','cm<sup>2</sup>');
			$this->addParameter('Agv','área bruta sujeita a cisalhamento','cm<sup>2</sup>');
			$this->addParameter('NSd','esforço axial solicitante de cálculo','kN');
			$this->addParameter('Combinação','Classificação da ação','');
			$this->addParameter('Kx','coeficiente de flambagem por flexão em x');
			$this->addParameter('Ky','coeficiente de flambagem por flexão em y');
			$this->addParameter('Kz','coeficiente de flambagem por torção');
			$this->addParameter('Lx','comprimento da peça no plano yz','cm');
			$this->addParameter('Ly','comprimento da peça no plano xz','cm');
			$this->addParameter('Lz','comprimento da peça','cm');
			$this->addParameter('d','altura total da seção transversal','mm');
			$this->addParameter('bf','largura da mesa','mm');
			$this->addParameter('tf','espessura da mesa','mm');
			$this->addParameter('tw','espessura da alma','mm');
			$this->addParameter('h','altura da alma','mm');
			$this->addParameter('hw','altura da alma do perfil laminado','mm');
			$this->addParameter('Ix','momento de inércia no eixo x','cm<sup>4</sup>');
			$this->addParameter('Iy','momento de inércia no eixo y','cm<sup>4</sup>');
			$this->addParameter('Cw','constante de empenamento da seção transversal','cm<sup>6</sup>');
			$this->addParameter('J','constante de torção','cm<sup>4</sup>');
			$this->addParameter('Cb','fator de modificação para diagrama de momento fletor não-uniforme');
			$this->addParameter('Lb','comprimento destravado','cm');
			$this->addParameter('Zx','módulo de resistência plástico no eixo x','cm&sup3;');
			$this->addParameter('Wx','módulo de resistência elástico no eixo x','cm&sup3;');
			$this->addParameter('a','distância entre enrijecedores transversais','cm');
			$this->addParameter('Afn','área líquida da mesa tracionada','cm<sup>2</sup>');
			$this->addParameter('MSd','esforço de flexão solicitante de cálculo','kN.cm');
			$this->addParameter('Zy','módulo de resistência plástico no eixo y','cm&sup3;');
			$this->addParameter('Wy','módulo de resistência elástico no eixo y','cm&sup3;');
			$this->addParameter('kv','parâmetro de flambagem de cisalhamento');
			$this->addParameter('VSd','esforço cortante solicitante de cálculo','kN');
		}

		function addParameter($acronym, $name, $unit){
			$this->param[$acronym] = array(
				'sigla' => $acronym,
				'nome' => $name,
				'unidade' => $unit,
				'valor' => null,
			);
		}

		function getGammaSymbol(){
			return '&#947;';
		}

		function setValues($keysAndValues){
			$r = array();
			foreach ($keysAndValues as $k => $v) {
				$this->param[$k]['valor'] = $v;
				array_push($r, $this->param[$k]);
			}
			return $r;
		}

		function getForTracao($catalogo, $aco, $gamma, $sessao){
			$p = array(
				'Area' => $catalogo['Area'],
				'fy' => $aco['fy'],
				$this->getGammaSymbol() . 'a1' => $gamma['gamma1'],
				'Ct' => $sessao->get('Ct-tracao'),
				'An' => $sessao->get('An-tracao'),
				'fu' => $aco['fu'],
				$this->getGammaSymbol() . 'a2' => $gamma['gamma2'],
				'L' => $sessao->get('L-tracao'),
				'rx' => $catalogo['rx'],
				'ry' => $catalogo['ry'],
				'Anv' => $sessao->get('Anv-tracao'),
				'Ant' => $sessao->get('Ant-tracao'),
				'Agv' => $sessao->get('Agv-tracao'),
				'NSd' => $sessao->get('Nsd-tracao')
			);
			return $this->setValues($p);
		}

		function getForCompressao($catalogo, $aco, $gamma, $sessao){
			$p = array(
				'Area' => $catalogo['Area'],
				'Kx' => $sessao->get('Kx-compressao'),
				'Ky' => $sessao->get('Ky-compressao'),
				'Kz' => $sessao->get('Kz-compressao'),
				'Lx' => $sessao->get('Lx-compressao'),
				'Ly' => $sessao->get('Ly-compressao'),
				'Lz' => $sessao->get('Lz-compressao'),
				'fy' => $aco['fy'],
				'd' => $catalogo['d'],
				'bf' => $catalogo['bf'],
				'tf' => $catalogo['tf'],
				'tw' => $catalogo['tw'],
				'h' => $catalogo['h'],
				'hw' => $catalogo['hw'],
				'Ix' => $catalogo['Ix'],
				'Iy' => $catalogo['Iy'],
				'Cw' => $catalogo['Cw'],
				'J' => $catalogo['J'],
				$this->getGammaSymbol() . 'a1' => $g['gamma1'],
				'NSd' => $sessao->get('Nsd-compressao')
			);
			return $this->setValues($p);
		}

		function getForFletorX($catalogo, $aco, $gamma, $sessao){
			$p = array(
				'Cb' => $sessao->get('Cb-Fletor_x'),
				'fy' => $aco['fy'],
				'fu' => $aco['fu'],
				'd' => $catalogo['d'],
				'bf' => $catalogo['bf'],
				'tf' => $catalogo['tf'],
				'tw' => $catalogo['tw'],
				'h' => $catalogo['h'],
				'hw' => $catalogo['hw'],
				'Lb' => $sessao->get('Lb-Fletor_x'),
				'ry' => $catalogo['ry'],
				'Zx' => $catalogo['Zx'],
				$this->getGammaSymbol() . 'a1' => $gamma['gamma1'],
				'Iy' => $catalogo['Iy'],
				'J' => $catalogo['J'],
				'Cw' => $catalogo['Cw'],
				'Wx' => $catalogo['Wx'],
				'a' => $sessao->get('a-Fletor_x'),
				'Afn' => $sessao->get('Afn-Fletor_x'),
				'MSd' => $sessao->get('Msd-Fletor_x')
			);
			return $this->setValues($p);
		}

		function getForFletorY($catalogo, $aco, $gamma, $sessao){
			$p = array(
				'Cb' => 0.0,
				'fy' => $aco['fy'],
				'fu' => $aco['fu'],
				'd' => $catalogo['d'],
				'bf' => $catalogo['bf'],
				'tf' => $catalogo['tf'],
				'tw' => $catalogo['tw'],
				'h' => $catalogo['h'],
				'hw' => $catalogo['hw'],
				'ry' => $catalogo['ry'],
				'Zx' => $catalogo['Zx'],
				$this->getGammaSymbol() . 'a1' => $gamma['gamma1'],
				'Iy' => $catalogo['Iy'],
				'J' => $catalogo['J'],
				'Cw' => $catalogo['Cw'],
				'Wy' => $catalogo['Wy'],
				'Afn' => $sessao->get('Afn-Fletor_y'),
				'MSd' => $sessao->get('Msd-Fletor_y')
			);
			return $this->setValues($p);
		}

		function getForCorteX($catalogo, $aco, $gamma, $sessao){
			$p = array(
				'fy' => $aco['fy'],
				'd' => $catalogo['d'],
				'bf' => $catalogo['bf'],
				'tf' => $catalogo['tf'],
				'tw' => $catalogo['tw'],
				'h' => $catalogo['h'],
				'hw' => $catalogo['hw'],
				$this->getGammaSymbol() . 'a1'  => $gamma['gamma1'],
				'VSd' => $sessao->get('Vsd-corte_y')
			);
			return $this->setValues($p);
		}

		function getForCorteY($catalogo, $aco, $gamma, $sessao){
			$p = array(
				'fy' => $aco['fy'],
				'd' => $catalogo['d'],
				'bf' => $catalogo['bf'],
				'tf' => $catalogo['tf'],
				'tw' => $catalogo['tw'],
				'h' => $catalogo['h'],
				'hw' => $catalogo['hw'],
				$this->getGammaSymbol() . 'a1' => $gamma['gamma1'],
				'kv' => $sessao->get('kv-corte_y'),
				'VSd' => $sessao->get('Vsd-corte_y')
			);
			return $this->setValues($p);
		}

	}
	
?>