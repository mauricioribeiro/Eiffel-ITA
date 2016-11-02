<?php 

	class Constant extends Config {

		function getComponentes(){
			return array(
    			'perfil' => 'Perfil',
    			'ligacao_parafusada' => 'Ligação Parafusada',
    			'ligacao_soldada' => 'Ligação Soldada'
    		);
		}

		function getCombinacoes(){
			return array(
				'Normal' => '1.1;1.35',
				'Especiais / Construção' => '1.1;1.35',
				'Excepcionais' => '1;1.15',
			);
		}

		function getCombinacao($val){
			return array_search($val, $this->getCombinacoes());
		}

		function getGamma($val){
			$c = $this->getCombinacoes();
			$g = explode(';',$c[$val]);
			return array(
				'gamma1' => floatval($g[0]),
				'gamma2' => floatval($g[1]),
			);
		}

		function getCombinado($NSd, $NRdMatrix, $MxSd, $MxRdMatrix, $MySd, $MyRdMatrix){
			$NRd = $this->getMinFromMatrix($NRdMatrix);
			$MxRd = $this->getMinFromMatrix($MxRdMatrix);
			$MyRd = $this->getMinFromMatrix($MyRdMatrix);

			$MxDivision = ($MxRd) ? $MxSd / $MxRd : 0;
			$MyDivision = ($MyRd) ? $MySd / $MyRd : 0;

			if($NSd / $NRd >= 0.2){
				return (($NSd / $NRd + 8/9 * ($MxDivision + $MyDivision)) <= 1) ? true : false;
			} else {
				return (($NSd / (2 * $NRd) + ($MxDivision + $MyDivision)) <= 1) ? true : false;
			}
		}

		function getMinFromMatrix($matrix){
			$values = array();
			foreach ($matrix as $row) {
				if(is_numeric($row[2]) && $row[5] == "True"){
					array_push($values, $row[2]);
				}
			}
			return (count($values)) ? min($values) : false;
		}

	}
	
?>