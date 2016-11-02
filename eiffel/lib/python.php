<?php 
	
	class Python extends Config {

		private $baseFolder = null;
		private $pythonFolder = 'C:\\Python33\\python.exe';
		private $pyFile = '_calc.py';

		function __construct(){
			$this->baseFolder = $this->getConfig('path').$this->getConfig('files-dir');
		}

		function execute($subFolder,$pyClass,$function,$parameters){
			try {
				$python = shell_exec($this->pythonFolder.' '.$this->baseFolder.'\\'.$subFolder.'\\py\\'.$this->pyFile.' '.$pyClass.' '.$function.' '.$parameters);
				#echo $this->pythonFolder.' '.$this->baseFolder.'\\'.$subFolder.'\\py\\'.$this->pyFile.' '.$pyClass.' '.$function.' '.$parameters;
				return json_decode($python);
			} catch (Exception $e) {
				return $e;
			}
		}

	}

 ?>